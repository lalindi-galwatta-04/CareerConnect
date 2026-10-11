<?php
class Booking {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Retrieve sessions with optional status filtering
    public function getSessionsByCoach($coach_id, $status = 'all') {
        $query = "SELECT ci.*, js.first_name, js.last_name 
                  FROM Coach_interaction ci 
                  JOIN Job_seeker js ON ci.job_seeker_id = js.user_id 
                  WHERE ci.coach_id = :coach_id";
        
        if ($status !== 'all') {
            $query .= " AND ci.status = :status";
        }

        $query .= " ORDER BY ci.session_date ASC";

        $stmt = $this->conn->prepare($query);
        $params = [':coach_id' => $coach_id];
        
        if ($status !== 'all') {
            $params[':status'] = $status;
        }

        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Update session status and notes
    public function updateSessionStatus($interaction_id, $status, $notes = "") {
        $query = "UPDATE Coach_interaction SET status = :status, notes = :notes WHERE interaction_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':notes' => $notes,
            ':id' => $interaction_id
        ]);
    }

    // Calculate metrics for dashboard summary cards
    public function getCoachMetrics($coach_id) {
        $query = "SELECT 
                    COUNT(*) as total_sessions,
                    SUM(CASE WHEN status = 'scheduled' THEN 1 ELSE 0 END) as pending_sessions,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_sessions,
                    AVG(rating) as avg_rating,
                    COUNT(rating) as rated_sessions_count
                  FROM Coach_interaction 
                  WHERE coach_id = :coach_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':coach_id' => $coach_id]);
        return $stmt->fetch();
    }

    // Fetch rated feedback entries for the coach
    public function getFeedbackByCoach($coach_id) {
        $query = "SELECT ci.rating, ci.notes, ci.session_date, js.first_name, js.last_name 
                  FROM Coach_interaction ci
                  JOIN Job_seeker js ON ci.job_seeker_id = js.user_id
                  WHERE ci.coach_id = :coach_id AND ci.rating IS NOT NULL
                  ORDER BY ci.session_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':coach_id' => $coach_id]);
        return $stmt->fetchAll();
    }

    // Retrieve all active coaches for Job Seekers to browse
    public function getAllCoaches() {
        $query = "SELECT c.*, u.email, u.phone_number 
                  FROM Career_coach c 
                  JOIN User u ON c.user_id = u.user_id 
                  ORDER BY c.coach_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Retrieve details for a single selected coach
    public function getCoachById($coach_id) {
        $query = "SELECT c.*, u.email, u.phone_number 
                  FROM Career_coach c 
                  JOIN User u ON c.user_id = u.user_id 
                  WHERE c.user_id = :coach_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':coach_id' => $coach_id]);
        return $stmt->fetch();
    }

    // Job Seeker creates a new coaching session booking
    public function createBooking($job_seeker_id, $coach_id, $session_date, $duration_minutes = 60) {
        $query = "INSERT INTO Coach_interaction (job_seeker_id, coach_id, session_date, duration_minutes, status) 
                  VALUES (:job_seeker_id, :coach_id, :session_date, :duration_minutes, 'scheduled')";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':job_seeker_id' => $job_seeker_id,
            ':coach_id' => $coach_id,
            ':session_date' => $session_date,
            ':duration_minutes' => $duration_minutes
        ]);
    }

    // Job Seeker submits feedback and rating for a completed session
    public function submitFeedback($interaction_id, $rating, $notes) {
        $query = "UPDATE Coach_interaction 
                  SET rating = :rating, notes = :notes 
                  WHERE interaction_id = :id AND status = 'completed'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':rating' => $rating,
            ':notes' => $notes,
            ':id' => $interaction_id
        ]);
    }

    // Retrieve past bookings for a specific Job Seeker
    public function getSessionsByJobSeeker($job_seeker_id) {
        $query = "SELECT ci.*, c.coach_name, c.specialization, c.hourly_rate 
                  FROM Coach_interaction ci 
                  JOIN Career_coach c ON ci.coach_id = c.user_id 
                  WHERE ci.job_seeker_id = :job_seeker_id 
                  ORDER BY ci.session_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':job_seeker_id' => $job_seeker_id]);
        return $stmt->fetchAll();
    }
}