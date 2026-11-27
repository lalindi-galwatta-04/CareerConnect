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
        } elseif ($currentView === 'course_management' || $currentView === 'course_details' || $currentView === 'course_profile') {
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

    // Add, Edit or View Course Profile / Management
    public function manageCourse() {
        $user_id = $_SESSION['user_id'];
        $provider = $this->providerModel->getProfile($user_id);
        $courses = $this->providerModel->getCoursesByProvider($user_id);
        $course_id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['course_id']) ? (int)$_POST['course_id'] : null);
        $course = null;

        $mode = $_GET['mode'] ?? '';

        $reqMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Mode: 'new' -> show course_form.php to create a new course
        if ($mode === 'new' && $reqMethod !== 'POST') {
            $course = null;
            require __DIR__ . '/../views/provider/course_form.php';
            return;
        }

        if ($course_id) {
            $course = $this->providerModel->getCourseById($course_id, $user_id);
        }

        // If no course_id was passed, but provider has courses, default to first course
        if (!$course && !empty($courses)) {
            $course = $courses[0];
            $course_id = (int)$course['course_id'];
        }

        // Mode: 'edit' -> show course_form.php to edit basic details
        if ($mode === 'edit' && $course && $reqMethod !== 'POST') {
            require __DIR__ . '/../views/provider/course_form.php';
            return;
        }

        // Handle POST Requests
        if ($reqMethod === 'POST') {
            $actionType = $_POST['action_type'] ?? '';

            // Handle Course Creation / Updating from course_form.php or modal
            if ($actionType === 'update_course_details' || isset($_POST['title'])) {
                $targetId = (int)($_POST['course_id'] ?? $course_id ?? 0);
                $title = trim($_POST['title'] ?? '');
                $category = trim($_POST['category'] ?? '');
                $duration = trim($_POST['duration'] ?? '');
                $fee = (float)($_POST['fee'] ?? 0);
                $description = trim($_POST['description'] ?? '');

                if ($targetId > 0) {
                    $this->providerModel->updateCourse($targetId, $user_id, $title, $category, $duration, $fee, $description);
                    if ($actionType === 'update_course_details') {
                        header("Location: index.php?action=manage_course&id=" . $targetId);
                        exit;
                    }
                } else if (!empty($title)) {
                    $newId = $this->providerModel->createCourse($user_id, $title, $category, $duration, $fee, $description);
                    header("Location: index.php?action=manage_course&id=" . ($newId ?: ''));
                    exit;
                }

                header("Location: index.php?action=provider_dashboard&view=courses");
                exit;
            }

            // Handle Lecture File Upload
            if ($actionType === 'upload_lecture_file') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $lectureId = trim($_POST['lecture_id'] ?? 'sec-general');
                $itemTitle = trim($_POST['item_title'] ?? '');
                $itemType = trim($_POST['item_type'] ?? 'document');

                if (isset($_FILES['lecture_file']) && $_FILES['lecture_file']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../public/uploads/courses/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $origName = basename($_FILES['lecture_file']['name']);
                    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
                    $fileName = 'course_' . $targetCourseId . '_' . uniqid() . '.' . $ext;
                    $destPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['lecture_file']['tmp_name'], $destPath)) {
                        $fileSize = round($_FILES['lecture_file']['size'] / 1024, 1) . ' KB';
                        if ($_FILES['lecture_file']['size'] > 1048576) {
                            $fileSize = round($_FILES['lecture_file']['size'] / 1048576, 1) . ' MB';
                        }
                        $fileItem = [
                            'id' => 'item-' . uniqid(),
                            'title' => !empty($itemTitle) ? $itemTitle : $origName,
                            'type' => $itemType,
                            'file_name' => $origName,
                            'file_path' => 'public/uploads/courses/' . $fileName,
                            'file_size' => $fileSize,
                            'uploaded_at' => date('Y-m-d H:i:s')
                        ];
                        $this->providerModel->addLectureFileToCourse($targetCourseId, $user_id, $lectureId, $fileItem);
                    }
                }
                header("Location: index.php?action=manage_course&id=" . $targetCourseId);
                exit;
            }

            // Handle Add Announcement
            if ($actionType === 'add_announcement') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $annTitle = trim($_POST['announcement_title'] ?? '');
                $annContent = trim($_POST['announcement_content'] ?? '');
                $annTag = trim($_POST['announcement_tag'] ?? 'Update');

                if (!empty($annTitle)) {
                    $annItem = [
                        'id' => 'ann-' . uniqid(),
                        'title' => $annTitle,
                        'content' => $annContent,
                        'tag' => $annTag,
                        'date' => date('M d, Y')
                    ];
                    $this->providerModel->addAnnouncementToCourse($targetCourseId, $user_id, $annItem);
                }
                header("Location: index.php?action=manage_course&id=" . $targetCourseId);
                exit;
            }

            // Handle Delete Announcement
            if ($actionType === 'delete_announcement') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $annId = trim($_POST['announcement_id'] ?? '');
                if (!empty($annId)) {
                    $this->providerModel->deleteAnnouncementFromCourse($targetCourseId, $user_id, $annId);
                }
                echo json_encode(['status' => 'success']);
                exit;
            }

            // Handle Add Lecture Topic
            if ($actionType === 'add_lecture_topic') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $title = trim($_POST['lecture_title'] ?? '');
                $status = trim($_POST['lecture_status'] ?? 'IN-PROGRESS');

                if (!empty($title)) {
                    $newLecture = $this->providerModel->addLectureTopicToCourse($targetCourseId, $user_id, $title, $status);
                    if (!empty($_POST['is_ajax'])) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'lecture' => $newLecture]);
                        exit;
                    }
                }
                header("Location: index.php?action=manage_course&id=" . $targetCourseId);
                exit;
            }

            // Handle Delete Lecture Section
            if ($actionType === 'delete_lecture_section') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $sectionId = trim($_POST['section_id'] ?? '');
                if (!empty($sectionId)) {
                    $this->providerModel->deleteLectureSectionFromCourse($targetCourseId, $user_id, $sectionId);
                }
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
                exit;
            }

            // Handle Delete Item
            if ($actionType === 'delete_item' || $actionType === 'delete_lecture_item') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $itemId = trim($_POST['item_id'] ?? '');
                if (!empty($itemId)) {
                    $this->providerModel->deleteLectureItemFromCourse($targetCourseId, $user_id, $itemId);
                }
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success']);
                exit;
            }

            // Handle Rename Section
            if ($actionType === 'rename_section') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $sectionId = trim($_POST['section_id'] ?? '');
                $newTitle = trim($_POST['new_title'] ?? '');
                if (!empty($sectionId) && !empty($newTitle)) {
                    $this->providerModel->renameSectionInCourse($targetCourseId, $user_id, $sectionId, $newTitle);
                }
                echo json_encode(['status' => 'success']);
                exit;
            }

            // Handle Rename Lecture
            if ($actionType === 'rename_lecture') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $lectureId = trim($_POST['lecture_id'] ?? '');
                $newTitle = trim($_POST['new_title'] ?? '');
                if (!empty($lectureId) && !empty($newTitle)) {
                    $this->providerModel->renameLectureInCourse($targetCourseId, $user_id, $lectureId, $newTitle);
                }
                echo json_encode(['status' => 'success']);
                exit;
            }

            // Handle Visibility Change
            if ($actionType === 'update_visibility') {
                $targetCourseId = (int)($_POST['course_id'] ?? $course_id ?? 1);
                $visibility = trim($_POST['visibility'] ?? 'visible');
                $curriculum = $this->providerModel->getCourseCurriculum($targetCourseId, $user_id);
                $curriculum['visibility'] = $visibility;
                $this->providerModel->saveCourseCurriculum($targetCourseId, $user_id, $curriculum);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }

        // If no course exists at all, show creation form
        if (!$course) {
            require __DIR__ . '/../views/provider/course_form.php';
            return;
        }

        // Load Course Profile / Course Management View!
        $curriculum = $this->providerModel->getCourseCurriculum($course['course_id'], $user_id);
        require __DIR__ . '/../views/provider/course_management.php';
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
