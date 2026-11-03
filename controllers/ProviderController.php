<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Provider.php';

class ProviderController {
    private $db;
    private $providerModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Auth & Role verification
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'training_provider') {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->providerModel = new Provider($this->db);
    }

    // Main Dashboard View Manager
    public function dashboard() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $currentView = $_GET['view'] ?? 'dashboard';

        // Handle Grade Update submission if posted to dashboard
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'update_grade') {
            $enrollment_id = (int)($_POST['enrollment_id'] ?? 0);
            $grade = trim($_POST['grade'] ?? '');
            if ($enrollment_id > 0 && !empty($grade)) {
                $this->providerModel->updateGrade($enrollment_id, $grade);
            }
            header("Location: index.php?action=provider_dashboard&view=grading");
            exit;
        }

        $selectedCourseId = isset($_GET['course_id']) && $_GET['course_id'] !== '' && $_GET['course_id'] !== 'all' ? (int)$_GET['course_id'] : null;
        $roster = $this->providerModel->getEnrolledStudents($user_id, $selectedCourseId);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, $selectedCourseId);
        $financials = $this->providerModel->getFinancials($user_id);
        $recentActivities = $this->providerModel->getRecentActivities($user_id);
        $pendingRequests = $this->providerModel->getPendingRequests($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);

        if ($currentView === 'roster') {
            require __DIR__ . '/../views/provider/roster.php';
            return;
        } elseif ($currentView === 'grading') {
            require __DIR__ . '/../views/provider/grading.php';
            return;
        } elseif ($currentView === 'courses') {
            require __DIR__ . '/../views/provider/courses.php';
            return;
        } elseif ($currentView === 'requests' || $currentView === 'enrollment_requests') {
            return $this->enrollmentRequests();
        } elseif ($currentView === 'financials' || $currentView === 'revenue') {
            return $this->financials();
        } elseif ($currentView === 'analytics' || $currentView === 'breakdown') {
            return $this->analytics();
        } elseif ($currentView === 'course_management' || $currentView === 'course_details') {
            return $this->manageCourse();
        }

        require __DIR__ . '/../views/provider/dashboard.php';
    }

    // Dedicated My Courses Action (index.php?action=my_courses / courses)
    public function myCourses() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);
        $currentView = 'courses';

        require __DIR__ . '/../views/provider/courses.php';
    }

    // Dedicated Financials & Revenue Action (index.php?action=financials)
    public function financials() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);

        $selectedYear = isset($_GET['year']) && is_numeric($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
        $selectedCourse = $_GET['course_id'] ?? 'all';
        $selectedPeriod = $_GET['date_period'] ?? 'all';
        $startDate = !empty($_GET['start_date']) ? trim($_GET['start_date']) : null;
        $endDate = !empty($_GET['end_date']) ? trim($_GET['end_date']) : null;
        $search = trim($_GET['search'] ?? '');

        $financials = $this->providerModel->getFinancials($user_id, $selectedYear, $startDate, $endDate);
        $transactions = $this->providerModel->getVerifiedTransactions($user_id, $selectedCourse, $selectedPeriod, $search, $startDate, $endDate);
        $currentView = 'financials';

        require __DIR__ . '/../views/provider/financials.php';
    }

    // Dedicated Enrollment Requests Action (index.php?action=enrollment_requests)
    public function enrollmentRequests() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $selectedCourse = $_GET['course_id'] ?? 'all';
        $selectedStatus = $_GET['status'] ?? 'all';

        // Handle Approve / Reject submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'update_status') {
            $enrollment_id = (int)($_POST['enrollment_id'] ?? 0);
            $new_status = $_POST['status'] ?? 'active';
            if ($enrollment_id > 0) {
                $this->providerModel->updateEnrollmentStatus($enrollment_id, $new_status, $user_id);
            }
            header("Location: index.php?action=enrollment_requests" . (!empty($_GET['course_id']) ? "&course_id=" . urlencode($_GET['course_id']) : '') . (!empty($_GET['status']) ? "&status=" . urlencode($_GET['status']) : ''));
            exit;
        }

        $requests = $this->providerModel->getEnrollmentRequests($user_id, $selectedCourse, $selectedStatus);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);
        $currentView = 'requests';

        require __DIR__ . '/../views/provider/requests.php';
    }

    // Dedicated Analytics & Breakdown Action (index.php?action=provider_dashboard&view=analytics)
    public function analytics() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);

        $selectedCourse = $_GET['course_id'] ?? 'all';
        $selectedPeriod = $_GET['period'] ?? 'this_year';

        $analytics = $this->providerModel->getAnalyticsData($user_id, $selectedCourse, $selectedPeriod);
        $currentView = 'analytics';

        require __DIR__ . '/../views/provider/analytics.php';
    }

    // Dedicated Student Roster Action
    public function roster() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);
        $currentView = 'roster';

        $selectedCourseId = isset($_GET['course_id']) && $_GET['course_id'] !== '' && $_GET['course_id'] !== 'all' ? (int)$_GET['course_id'] : null;
        $roster = $this->providerModel->getEnrolledStudents($user_id, $selectedCourseId);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, $selectedCourseId);

        require __DIR__ . '/../views/provider/roster.php';
    }

    // Dedicated Grading & Results Action
    public function grading() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $pendingCount = $this->providerModel->getPendingEnrollmentsCount($user_id);
        $currentView = 'grading';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'update_grade') {
            $enrollment_id = (int)($_POST['enrollment_id'] ?? 0);
            $grade = trim($_POST['grade'] ?? '');
            if ($enrollment_id > 0 && !empty($grade)) {
                $this->providerModel->updateGrade($enrollment_id, $grade);
            }
            header("Location: index.php?action=provider_dashboard&view=grading");
            exit;
        }

        $selectedCourseId = isset($_GET['course_id']) && $_GET['course_id'] !== '' && $_GET['course_id'] !== 'all' ? (int)$_GET['course_id'] : null;
        $roster = $this->providerModel->getEnrolledStudents($user_id, $selectedCourseId);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, $selectedCourseId);

        require __DIR__ . '/../views/provider/grading.php';
    }

    // Add or Edit Course
    public function manageCourse() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $course_id = $_GET['id'] ?? null;
        $course = null;

        if ($course_id) {
            $course = $this->providerModel->getCourseById($course_id, $user_id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $category = $_POST['category'] ?? '';
            $duration = $_POST['duration'] ?? '';
            $fee = $_POST['fee'] ?? 0;
            $description = $_POST['description'] ?? '';

            if ($course_id) {
                // Update
                $this->providerModel->updateCourse($course_id, $user_id, $title, $category, $duration, $fee, $description);
            } else {
                // Create
                $this->providerModel->createCourse($user_id, $title, $category, $duration, $fee, $description);
            }

            header("Location: index.php?action=provider_dashboard&view=courses");
            exit;
        }

        require __DIR__ . '/../views/provider/course_form.php';
    }

    // Delete Course
    public function deleteCourse() {
        $user_id = $_SESSION['user_id'];
        $course_id = $_GET['id'] ?? null;

        if ($course_id) {
            $this->providerModel->deleteCourse($course_id, $user_id);
        }

        header("Location: index.php?action=provider_dashboard&view=courses");
        exit;
    }

    // Manage Profile
    public function profile() {
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['provider_name'] ?? '';
            $email = $_POST['contact_email'] ?? '';
            $website = $_POST['website'] ?? '';
            $desc = $_POST['description'] ?? '';

            $this->providerModel->updateProfile($user_id, $name, $email, $website, $desc);
            header("Location: index.php?action=provider_dashboard");
            exit;
        }

        $provider = $this->providerModel->getProfile($user_id);
        require __DIR__ . '/../views/provider/profile.php';
    }
}
