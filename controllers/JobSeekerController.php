<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/JobSeeker.php';

class JobSeekerController {
    private $db;
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new JobSeeker();
    }

    private function getProfile() {
        return $this->model->getProfileByUserId($_SESSION['user_id']);
    }

    private function getJobseekerId($profile) {
        if (!$profile) {
            return null;
        }

        if (isset($profile['user_id'])) {
            return $profile['user_id'];
        }

        if (isset($profile['jobseeker_id'])) {
            return $profile['jobseeker_id'];
        }

        return null;
    }

    private function renderView($viewName, $data = array()) {
        extract($data);

        $filePath = __DIR__ . '/../views/jobseeker/' . $viewName;

        if (file_exists($filePath)) {
            require $filePath;
        } else {
            echo "Error: View file <strong>" . htmlspecialchars($viewName) . "</strong> not found.";
        }
    }

    public function dashboard() {
        $profile = $this->getProfile();
        $jobseekerId = $this->getJobseekerId($profile);
        $applications = $jobseekerId
            ? $this->model->getApplications($jobseekerId)
            : array();

        $this->renderView('dashboard.php', compact('profile', 'applications'));
    }

    public function viewProfile() {
        $profile = $this->getProfile();
        $userId = $_SESSION['user_id'];
        $work_experiences = $this->model->getWorkExperiences($userId);

        $this->renderView(
            'view_Jobseeker_profile.php',
            compact('profile', 'work_experiences')
        );
    }

    public function editProfile() {
        $profile = $this->getProfile();
        $userId = $_SESSION['user_id'];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $phone = trim($_POST['phone_number'] ?? $_POST['phone'] ?? '');
            $education = trim($_POST['education_level'] ?? '');
            $skills = trim($_POST['skills'] ?? '');
            $experiences = isset($_POST['experiences']) && is_array($_POST['experiences'])
                ? $_POST['experiences']
                : array();

            foreach ($experiences as $index => &$experience) {
                $experience['company_name'] = trim($experience['company_name'] ?? '');
                $experience['job_title'] = trim($experience['job_title'] ?? '');
                $experience['start_date'] = trim($experience['start_date'] ?? '');
                $experience['end_date'] = trim($experience['end_date'] ?? '');
                $experience['is_current'] = !empty($experience['is_current']) ? 1 : 0;

                if ($experience['is_current'] === 1) {
                    $experience['end_date'] = '';
                }

                if (
                    $experience['start_date'] !== '' &&
                    $experience['end_date'] !== '' &&
                    $experience['end_date'] < $experience['start_date']
                ) {
                    $error = 'The end date of a work experience cannot be earlier than its start date.';
                    break;
                }
            }

            unset($experience);

            if ($error === '') {
                $updated = $this->model->updateProfileWithExperiences(
                    $userId,
                    $firstName,
                    $lastName,
                    $phone,
                    $education,
                    $skills,
                    $experiences
                );

                if ($updated) {
                    header('Location: index.php?action=view_jobseeker_profile');
                    exit;
                }

                $error = 'Unable to update the profile. Please try again.';
            }

            $profile = $this->getProfile();
            $work_experiences = $experiences;

            $this->renderView(
                'edit_Jobseeker_profile.php',
                compact('profile', 'work_experiences', 'error')
            );

            return;
        }

        $work_experiences = $this->model->getWorkExperiences($userId);

        $this->renderView(
            'edit_Jobseeker_profile.php',
            compact('profile', 'work_experiences', 'error')
        );
    }

    public function searchJobs() {
        $keyword = trim(
            $_GET['q']
            ?? $_GET['search']
            ?? $_GET['keyword']
            ?? ''
        );

        $jobs = $this->model->searchJobs($keyword);

        $this->renderView(
            'job_search.php',
            compact('jobs', 'keyword')
        );
    }

    public function jobDetails() {
        $jobId = $_GET['id'] ?? 0;
        $job = $this->model->getJobById($jobId);

        $this->renderView(
            'job_details.php',
            compact('job')
        );
    }

    public function apply() {
        $profile = $this->getProfile();
        $jobseekerId = $this->getJobseekerId($profile);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $jobseekerId) {
            $jobId = $_POST['job_id'] ?? 0;
            $cover = $_POST['cover_letter'] ?? '';

            $this->model->applyForJob(
                $jobId,
                $jobseekerId,
                $cover
            );

            header('Location: index.php?action=my_applications');
            exit;
        }
    }

    public function myApplications() {
        $profile = $this->getProfile();
        $jobseekerId = $this->getJobseekerId($profile);

        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['delete_id']) &&
            $jobseekerId
        ) {
            $this->model->deleteApplication(
                $_POST['delete_id'],
                $jobseekerId
            );
        }

        $applications = $jobseekerId
            ? $this->model->getApplications($jobseekerId)
            : array();

        $this->renderView(
            'my_application.php',
            compact('applications', 'profile')
        );
    }

    public function assessment() {
        $profile = $this->getProfile();

        $this->renderView(
            'career_assessment.php',
            compact('profile')
        );
    }

    public function assessmentResults() {
        $profile = $this->getProfile();
        $jobseekerId = $this->getJobseekerId($profile);

        $result = $jobseekerId
            ? $this->model->getLatestAssessment($jobseekerId)
            : null;

        $this->renderView(
            'assessment_results.php',
            compact('result', 'profile')
        );
    }

    public function analytics() {
        $profile = $this->getProfile();
        $jobseekerId = $this->getJobseekerId($profile);

        $applications = $jobseekerId
            ? $this->model->getApplications($jobseekerId)
            : array();

        $this->renderView(
            'Jobseeker_analytics.php',
            compact('applications', 'profile')
        );
    }

    public function browseCourses() {
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $courses = array();

        if ($this->db) {
            try {
                $sql = "SELECT c.*, tp.provider_name
                        FROM course c
                        JOIN training_provider tp ON c.provider_id = tp.user_id
                        WHERE 1=1";

                $params = array();

                if ($search !== '') {
                    $sql .= " AND (c.title LIKE :search OR c.description LIKE :search)";
                    $params[':search'] = '%' . $search . '%';
                }

                if ($category !== '') {
                    $sql .= " AND c.category = :category";
                    $params[':category'] = $category;
                }

                $sql .= " ORDER BY c.created_at DESC";

                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);

                $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Course Fetch Error: " . $e->getMessage());
                $courses = array();
            }
        }

        $profile = $this->getProfile();

        $this->renderView(
            'courses.php',
            compact('courses', 'profile', 'search', 'category')
        );
    }
}