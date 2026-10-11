<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $db;
    private $adminModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Auth check: verify user is logged in as 'admin'
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            header("Location: index.php?action=login");
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->adminModel = new AdminModel($this->db);
        		if (empty($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
    }

    // Main Admin Dashboard & Sub-views Manager
    public function dashboard() {
        $rawView = $_GET['view'] ?? 'dashboard';
        $currentView = strtolower(trim($rawView));
        $metrics = $this->adminModel->getSystemMetrics();

        if (in_array($currentView, ['approvals', 'entity_approvals', 'approval'])) {
            $entities = $this->adminModel->getEntityApprovals();
            require __DIR__ . '/../views/admin/approvals.php';
            return;
        } elseif (in_array($currentView, ['users', 'user', 'user_accounts'])) {
            $users = $this->adminModel->getAllUsers();
            require __DIR__ . '/../views/admin/users.php';
            return;
        } elseif (in_array($currentView, ['seekers', 'seeker', 'job_seekers', 'job_seeker', 'jobseekers'])) {
            $seekers = $this->adminModel->getAllJobSeekers();
            require __DIR__ . '/../views/admin/seekers.php';
            return;
        } elseif (in_array($currentView, ['coaches', 'coach', 'career_coaches', 'career_coach'])) {
            $coaches = $this->adminModel->getAllCareerCoaches();
            require __DIR__ . '/../views/admin/coaches.php';
            return;
        } elseif (in_array($currentView, ['companies', 'company', 'employers', 'employer'])) {
            $companies = $this->adminModel->getAllCompanies();
            require __DIR__ . '/../views/admin/companies.php';
            return;
        } elseif (in_array($currentView, ['jobs', 'job', 'job_listings'])) {
            $jobs = $this->adminModel->getAllJobs();
            require __DIR__ . '/../views/admin/jobs.php';
            return;
        } elseif (in_array($currentView, ['courses', 'course', 'training_courses'])) {
            $courses = $this->adminModel->getAllCourses();
            require __DIR__ . '/../views/admin/courses.php';
            return;
        } elseif (in_array($currentView, ['providers', 'provider', 'training_providers', 'training_provider', 'manage_providers', 'manage_training_providers'])) {
            $providers = $this->adminModel->getAllTrainingProviders();
            require __DIR__ . '/../views/admin/providers.php';
            return;
        }

        // Default: Main Dashboard Control Panel
        $users = $this->adminModel->getAllUsers();
        $jobs = $this->adminModel->getAllJobs();
        $courses = $this->adminModel->getAllCourses();
        $providers = $this->adminModel->getAllTrainingProviders();
        $seekers = $this->adminModel->getAllJobSeekers();
        $coaches = $this->adminModel->getAllCareerCoaches();
        $companies = $this->adminModel->getAllCompanies();
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    // Dedicated Entity Approvals View Action
    public function approvals() {
        $currentView = 'approvals';
        $metrics = $this->adminModel->getSystemMetrics();
        $entities = $this->adminModel->getEntityApprovals();
        require __DIR__ . '/../views/admin/approvals.php';
    }

    // Dedicated User Accounts View Action
    public function users() {
        $currentView = 'users';
        $metrics = $this->adminModel->getSystemMetrics();
        $users = $this->adminModel->getAllUsers();
        require __DIR__ . '/../views/admin/users.php';
    }

    // Dedicated Job Seekers View Action
    public function seekers() {
        $currentView = 'seekers';
        $metrics = $this->adminModel->getSystemMetrics();
        $seekers = $this->adminModel->getAllJobSeekers();
        require __DIR__ . '/../views/admin/seekers.php';
    }

    // Dedicated Career Coaches View Action
    public function coaches() {
        $currentView = 'coaches';
        $metrics = $this->adminModel->getSystemMetrics();
        $coaches = $this->adminModel->getAllCareerCoaches();
        require __DIR__ . '/../views/admin/coaches.php';
    }

    // Dedicated Companies View Action
    public function companies() {
        $currentView = 'companies';
        $metrics = $this->adminModel->getSystemMetrics();
        $companies = $this->adminModel->getAllCompanies();
        require __DIR__ . '/../views/admin/companies.php';
    }

    // Dedicated Job Listings View Action
    public function jobs() {
        $currentView = 'jobs';
        $metrics = $this->adminModel->getSystemMetrics();
        $jobs = $this->adminModel->getAllJobs();
        require __DIR__ . '/../views/admin/jobs.php';
    }

    // Dedicated Courses View Action
    public function courses() {
        $currentView = 'courses';
        $metrics = $this->adminModel->getSystemMetrics();
        $courses = $this->adminModel->getAllCourses();
        require __DIR__ . '/../views/admin/courses.php';
    }

    // Dedicated Training Providers View Action
    public function providers() {
        $currentView = 'providers';
        $metrics = $this->adminModel->getSystemMetrics();
        $providers = $this->adminModel->getAllTrainingProviders();
        require __DIR__ . '/../views/admin/providers.php';
    }

    	// Approve or reject a pending account
	public function updateApproval() {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			http_response_code(405);
			header('Allow: POST');
			exit('Method not allowed.');
		}

		$token = $_POST['csrf_token'] ?? '';

		if (
			!is_string($token) ||
			empty($_SESSION['csrf_token']) ||
			!hash_equals($_SESSION['csrf_token'], $token)
		) {
			http_response_code(403);
			exit('Invalid request. Refresh the approvals page and try again.');
		}

		$user_id = filter_var(
			$_POST['user_id'] ?? '',
			FILTER_VALIDATE_INT,
			['options' => ['min_range' => 1]]
		);
		$status = $_POST['approval_status'] ?? '';

		if (
			!$user_id ||
			!in_array($status, ['approved', 'rejected'], true)
		) {
			http_response_code(400);
			exit('Invalid user or approval status.');
		}

		$stmt = $this->db->prepare("
			UPDATE `User`
			SET approval_status = :status
			WHERE user_id = :user_id
			AND user_type IN ('company', 'career_coach', 'training_provider')
			AND approval_status = 'pending'
		");

		$stmt->execute([
			':status' => $status,
			':user_id' => $user_id
		]);

		header("Location: index.php?action=admin_dashboard&view=approvals");
		exit;
	}

    // User Deletion
    public function deleteUser() {
        $user_id = $_GET['id'] ?? null;
        if ($user_id) {
            $this->adminModel->deleteUser($user_id);
        }
        $redirectView = $_GET['from'] ?? 'users';
        header("Location: index.php?action=admin_dashboard&view=" . urlencode($redirectView));
        exit;
    }

    // Admin Job Moderation
    public function deleteJob() {
        $job_id = $_GET['id'] ?? null;
        if ($job_id) {
            $this->adminModel->deleteJob($job_id);
        }
        $redirectView = $_GET['from'] ?? 'jobs';
        header("Location: index.php?action=admin_dashboard&view=" . urlencode($redirectView));
        exit;
    }

    // Admin Course Moderation
    public function deleteCourse() {
        $course_id = $_GET['id'] ?? null;
        if ($course_id) {
            $this->adminModel->deleteCourse($course_id);
        }
        $redirectView = $_GET['from'] ?? 'courses';
        header("Location: index.php?action=admin_dashboard&view=" . urlencode($redirectView));
        exit;
    }
}