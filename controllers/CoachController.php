<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Coach.php';
require_once __DIR__ . '/../models/Booking.php';

class CoachController {
    private $db;
    private $coachModel;
    private $bookingModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Authentication check
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->coachModel = new Coach($this->db);
        $this->bookingModel = new Booking($this->db);
    }

    /**
     * Helper to restrict coach-only dashboard actions
     */
    private function checkCoachAccess() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'career_coach') {
            header("Location: index.php?action=jobseeker_dashboard");
            exit;
        }
    }

    // Render Main Dashboard
    public function dashboard() {
        $this->checkCoachAccess();
        $user_id = $_SESSION['user_id'];
        
        $coach = $this->coachModel->getProfile($user_id);
        $status_filter = $_GET['status'] ?? 'all';
        
        // Fetch sessions by coach and status filter
        $sessions = $this->bookingModel->getSessionsByCoach($user_id, $status_filter);
        $metrics = $this->bookingModel->getCoachMetrics($user_id);
        $feedback = $this->bookingModel->getFeedbackByCoach($user_id);

        require __DIR__ . '/../views/coach/dashboard.php';
    }

    // Update Session Status or Notes from Dashboard
    public function updateSession() {
        $this->checkCoachAccess();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $interaction_id = $_POST['interaction_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $notes = $_POST['notes'] ?? '';
            $filterStatus = $_POST['filter_status'] ?? 'all';

            if ($interaction_id && $status) {
                $this->bookingModel->updateSessionStatus($interaction_id, $status, $notes);
            }

            header("Location: index.php?action=coach_dashboard&status=" . urlencode($filterStatus) . "#coaching-sessions");
            exit;
        }
        header("Location: index.php?action=coach_dashboard");
        exit;
    }

    // Route conductSession to updateSession to resolve the undefined method error
    public function conductSession() {
        $this->checkCoachAccess();
        $this->updateSession();
    }

    // Manage Profile Details
    public function manageProfile() {
        $this->checkCoachAccess();
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract single form fields matching the form inputs
            $full_name        = $_POST['full_name'] ?? $_POST['coach_name'] ?? '';
            $display_title    = $_POST['display_title'] ?? '';
            $workplace        = $_POST['workplace'] ?? '';
            $experience_years = $_POST['experience_years'] ?? 0;
            $specialization   = $_POST['specialization'] ?? '';
            $hourly_rate      = $_POST['hourly_rate'] ?? 0.00;
            $coaching_mode    = $_POST['coaching_mode'] ?? '';
            $linkedin_url     = $_POST['linkedin_url'] ?? '';
            $bio              = $_POST['bio'] ?? '';

            // Process Academic Qualifications into JSON structure
            $qualifications = [];
            if (!empty($_POST['qualifications_title'])) {
                foreach ($_POST['qualifications_title'] as $index => $title) {
                    $t = trim($title);
                    $inst = trim($_POST['qualifications_institute'][$index] ?? '');
                    if ($t !== '') {
                        $qualifications[] = [
                            'title'     => $t,
                            'institute' => $inst
                        ];
                    }
                }
            }

            // Process Professional Certifications into JSON structure
            $certifications = [];
            if (!empty($_POST['certifications_title'])) {
                foreach ($_POST['certifications_title'] as $index => $title) {
                    $t = trim($title);
                    $body = trim($_POST['certifications_body'][$index] ?? '');
                    if ($t !== '') {
                        $certifications[] = [
                            'title'        => $t,
                            'issuing_body' => $body
                        ];
                    }
                }
            }

            // Process Skills & Experience into JSON structure
            $skills = [];
            if (!empty($_POST['skills_name'])) {
                foreach ($_POST['skills_name'] as $index => $name) {
                    $n = trim($name);
                    $exp = intval($_POST['skills_exp'][$index] ?? 1);
                    if ($n !== '') {
                        $skills[] = [
                            'name'       => $n,
                            'experience' => $exp
                        ];
                    }
                }
            }

            // Consolidate data payload array
            $data = [
                'full_name'        => $full_name,
                'display_title'    => $display_title,
                'workplace'        => $workplace,
                'experience_years' => $experience_years,
                'specialization'   => $specialization,
                'hourly_rate'      => $hourly_rate,
                'coaching_mode'    => $coaching_mode,
                'linkedin_url'     => $linkedin_url,
                'bio'              => $bio,
                'qualifications'   => json_encode($qualifications),
                'certifications'   => json_encode($certifications),
                'skills'           => json_encode($skills)
            ];

            // Pass array payload or individual arguments to model
            if (method_exists($this->coachModel, 'updateFullProfile')) {
                $this->coachModel->updateFullProfile($user_id, $data);
            } else {
                $this->coachModel->updateProfile(
                    $user_id, 
                    $full_name, 
                    $specialization, 
                    $hourly_rate, 
                    $bio, 
                    $data
                );
            }

            header("Location: index.php?action=coach_profile&success=1");
            exit;
        }

        // Fetch existing coach profile for GET requests
        $coach = $this->coachModel->getProfile($user_id);
        require __DIR__ . '/../views/coach/profile.php';
    }

    // Manage Availability & Schedule
    public function manageAvailability() {
        $this->checkCoachAccess();
        $user_id = $_SESSION['user_id'];
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action_type = $_POST['action_type'] ?? '';
            $slot_date   = $_POST['slot_date'] ?? date('Y-m-d');

            // 1. ADD TIME SLOT
            if ($action_type === 'add') {
                $start = $_POST['start_time'] ?? '';
                $end   = $_POST['end_time'] ?? '';

                if ($slot_date && $start && $end) {
                    if ($start >= $end) {
                        $error = "End time must be after start time.";
                    } else {
                        // Check if exact timeslot already exists for this day
                        $checkDuplicate = $this->db->prepare(
                            "SELECT slot_id FROM coach_availability 
                             WHERE user_id = ? AND slot_date = ? AND start_time = ? AND end_time = ?"
                        );
                        $checkDuplicate->execute([$user_id, $slot_date, $start, $end]);

                        if ($checkDuplicate->fetch()) {
                            $error = "This time slot (" . date('g:i A', strtotime($start)) . " - " . date('g:i A', strtotime($end)) . ") already exists for this day.";
                        } else {
                            $stmt = $this->db->prepare("INSERT INTO coach_availability (user_id, slot_date, start_time, end_time) VALUES (?, ?, ?, ?)");
                            $stmt->execute([$user_id, $slot_date, $start, $end]);
                            $message = "Time slot added successfully!";
                        }
                    }
                }
            }

            // 2. EDIT TIME SLOT
            elseif ($action_type === 'edit') {
                $slot_id = $_POST['slot_id'] ?? null;
                $start   = $_POST['start_time'] ?? '';
                $end     = $_POST['end_time'] ?? '';

                if ($slot_id && $start && $end) {
                    // Check if booked by job seeker
                    $check = $this->db->prepare("SELECT is_booked FROM coach_availability WHERE slot_id = ? AND user_id = ?");
                    $check->execute([$slot_id, $user_id]);
                    $slot = $check->fetch(PDO::FETCH_ASSOC);

                    if ($slot && $slot['is_booked'] == 1) {
                        $error = "Cannot edit this slot because a job seeker has already booked it.";
                    } elseif ($start >= $end) {
                        $error = "End time must be after start time.";
                    } else {
                        // Check if updated timing conflicts with another existing slot on the same day
                        $checkDuplicate = $this->db->prepare(
                            "SELECT slot_id FROM coach_availability 
                             WHERE user_id = ? AND slot_date = ? AND start_time = ? AND end_time = ? AND slot_id != ?"
                        );
                        $checkDuplicate->execute([$user_id, $slot_date, $start, $end, $slot_id]);

                        if ($checkDuplicate->fetch()) {
                            $error = "Another time slot with this exact timing already exists for this day.";
                        } else {
                            $stmt = $this->db->prepare("UPDATE coach_availability SET start_time = ?, end_time = ? WHERE slot_id = ? AND user_id = ?");
                            $stmt->execute([$start, $end, $slot_id, $user_id]);
                            $message = "Time slot updated successfully!";
                        }
                    }
                }
            }

            // 3. DELETE TIME SLOT
            elseif ($action_type === 'delete') {
                $slot_id = $_POST['slot_id'] ?? null;

                if ($slot_id) {
                    // Protection Check: Cannot delete booked sessions
                    $check = $this->db->prepare("SELECT is_booked FROM coach_availability WHERE slot_id = ? AND user_id = ?");
                    $check->execute([$slot_id, $user_id]);
                    $slot = $check->fetch(PDO::FETCH_ASSOC);

                    if ($slot && $slot['is_booked'] == 1) {
                        $error = "Cannot delete this slot because a job seeker has already booked it.";
                    } else {
                        $stmt = $this->db->prepare("DELETE FROM coach_availability WHERE slot_id = ? AND user_id = ?");
                        $stmt->execute([$slot_id, $user_id]);
                        $message = "Time slot removed successfully!";
                    }
                }
            }
        }

        // Set selected date
        $selected_date = $_GET['date'] ?? $_POST['slot_date'] ?? date('Y-m-d');

        // Fetch slots for the selected date
        $stmt = $this->db->prepare("SELECT * FROM coach_availability WHERE user_id = ? AND slot_date = ? ORDER BY start_time ASC");
        $stmt->execute([$user_id, $selected_date]);
        $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $coach = $this->coachModel->getProfile($user_id);

        require __DIR__ . '/../views/coach/availability.php';
    }

    // Render Analytics & Report Generation Page
    public function reports() {
        $this->checkCoachAccess();
        $user_id = $_SESSION['user_id'];
        $coach = $this->coachModel->getProfile($user_id);

        // Retrieve filter parameters
        $startDate = $_GET['start_date'] ?? date('Y-m-01'); // Default to start of current month
        $endDate = $_GET['end_date'] ?? date('Y-m-t');     // Default to end of current month
        $statusParam = $_GET['report_status'] ?? 'all';
        $exportFormat = $_GET['export'] ?? '';

        // Build status filter condition
        $statusCondition = "";
        $params = [$user_id, $startDate, $endDate];
        if ($statusParam !== 'all') {
            $statusCondition = "AND ci.status = ?";
            $params[] = $statusParam;
        }

        // Fetch filtered sessions safely using coach_interaction and user tables
        $query = "SELECT ci.*, u.email, 'Job Seeker' as full_name 
                  FROM coach_interaction ci 
                  LEFT JOIN user u ON ci.job_seeker_id = u.user_id 
                  WHERE ci.coach_id = ? AND ci.session_date BETWEEN ? AND ? $statusCondition 
                  ORDER BY ci.session_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate summary metrics for the selected period
        $totalSessions = count($reportData);
        $completedCount = 0;
        $totalEarnings = 0;
        $hourlyRate = floatval($coach['hourly_rate'] ?? 1000.00);

        foreach ($reportData as $row) {
            if (strtolower($row['status']) === 'completed') {
                $completedCount++;
                $durationHours = ($row['duration_minutes'] ?? 60) / 60;
                $totalEarnings += ($durationHours * $hourlyRate);
            }
        }

        // Handle CSV Export Download if requested
        if ($exportFormat === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Coach_Analytics_Report_' . date('Y-m-d') . '.csv');
            $output = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($output, ['Interaction ID', 'Client Email', 'Date & Time', 'Duration (Mins)', 'Status', 'Notes']);
            
            foreach ($reportData as $row) {
                fputcsv($output, [
                    $row['interaction_id'] ?? '',
                    $row['email'] ?? 'N/A',
                    $row['session_date'],
                    $row['duration_minutes'] ?? 60,
                    ucfirst($row['status']),
                    $row['notes'] ?? ''
                ]);
            }
            fclose($output);
            exit;
        }

        require __DIR__ . '/../views/coach/reports.php';
    }

    // ==========================================
    // JOB SEEKER ACCESSIBLE METHODS
    // ==========================================

    // List all coaches for Job Seekers (index.php?action=browse_coaches)
    public function listCoachesForSeeker() {
        $user_id = $_SESSION['user_id'];

        $coaches = method_exists($this->coachModel, 'getAllCoaches')
            ? $this->coachModel->getAllCoaches()
            : array();

        $stmt = $this->db->prepare(
            "SELECT js.*, u.email, u.phone_number
             FROM Job_seeker js
             JOIN User u ON js.user_id = u.user_id
             WHERE js.user_id = :user_id"
        );

        $stmt->execute([
            ':user_id' => $user_id
        ]);

        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/jobseeker/browse_coaches.php';
    }

    // Book session with a coach (index.php?action=book_session)
    public function bookSession() {
        $coach_id = isset($_GET['coach_id']) ? $_GET['coach_id'] : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seeker_id = $_SESSION['user_id'];
            $coach_id = isset($_POST['coach_id']) ? $_POST['coach_id'] : null;
            $session_date = isset($_POST['session_date']) ? $_POST['session_date'] : '';

            // Handle booking logic using $this->bookingModel
            header("Location: index.php?action=jobseeker_dashboard");
            exit;
        }

        $coach = $coach_id ? $this->coachModel->getProfile($coach_id) : null;
        require __DIR__ . '/../views/jobseeker/book_session.php';
    }
}