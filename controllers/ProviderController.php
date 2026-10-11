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

    // Main Dashboard, Courses, Student Roster & Grading View Manager
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
        $roster = $this->providerModel->getEnrolledStudents($user_id, null);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, null);

        if ($currentView === 'roster') {
            require __DIR__ . '/../views/provider/roster.php';
            return;
        } elseif ($currentView === 'grading') {
            require __DIR__ . '/../views/provider/grading.php';
            return;
        }

        require __DIR__ . '/../views/provider/dashboard.php';
    }

    // Dedicated Student Roster Action
    public function roster() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $currentView = 'roster';

        $selectedCourseId = isset($_GET['course_id']) && $_GET['course_id'] !== '' && $_GET['course_id'] !== 'all' ? (int)$_GET['course_id'] : null;
        $roster = $this->providerModel->getEnrolledStudents($user_id, null);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, null);

        require __DIR__ . '/../views/provider/roster.php';
    }

    // Dedicated Grading & Results Action
    public function grading() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $metrics = $this->providerModel->getProviderMetrics($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
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
        $roster = $this->providerModel->getEnrolledStudents($user_id, null);
        $gradingRecords = $this->providerModel->getGradingRecords($user_id, null);

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
            $title = $_POST['title'];
            $category = $_POST['category'];
            $duration = $_POST['duration'];
            $fee = $_POST['fee'];
            $description = $_POST['description'];

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
            $name = $_POST['provider_name'];
            $email = $_POST['contact_email'];
            $website = $_POST['website'];
            $desc = $_POST['description'];

            $this->providerModel->updateProfile($user_id, $name, $email, $website, $desc);
            header("Location: index.php?action=provider_dashboard");
            exit;
        }

        $provider = $this->providerModel->getProfile($user_id);
        require __DIR__ . '/../views/provider/profile.php';
    }
}