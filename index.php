<?php

session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CoachController.php';
require_once __DIR__ . '/controllers/ProviderController.php';
require_once __DIR__ . '/controllers/CompanyController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/JobSeekerController.php';

$action = $_GET['action'] ?? 'home';

// Public routes
if ($action === 'home') {
	require __DIR__ . '/views/main.php';
	exit;
}

$publicActions = ['login', 'register', 'logout'];

if (!in_array($action, $publicActions, true)) {
	// Require a logged-in account
	if (empty($_SESSION['user_id'])) {
		header("Location: index.php?action=login");
		exit;
	}

	$database = new Database();
	$db = $database->getConnection();

	// Read the current role and approval status
	$stmt = $db->prepare("
		SELECT user_id, user_type, approval_status, rejection_reason
		FROM `User`
		WHERE user_id = :user_id
		LIMIT 1
	");
	$stmt->execute([
		':user_id' => $_SESSION['user_id']
	]);
	$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$currentUser) {
		session_unset();
		session_regenerate_id(true);
		header("Location: index.php?action=login");
		exit;
	}

	$role = $currentUser['user_type'];
	$status = $currentUser['approval_status'] ?? 'pending';

	// Job seekers and administrators do not require approval
	if (!in_array($role, ['job_seeker', 'admin'], true)) {
		if ($status !== 'approved') {
			session_unset();
			session_regenerate_id(true);

			if ($status === 'pending') {
				require __DIR__ . '/views/auth/pending_approval.php';
			} else {
				$error = $status === 'rejected'
					? "Your account registration has been rejected."
					: "Your account has not been approved.";
				$rejectionNotice = !empty($currentUser['rejection_reason']) ? $currentUser['rejection_reason'] : null;

				require __DIR__ . '/views/auth/login.php';
			}

			exit;
		}
	}

	// Use the role stored in the database
	$_SESSION['user_type'] = $role;

	// Allowed routes for each role
	$roleActions = [
		'job_seeker' => [
			'jobseeker_dashboard',
			'view_jobseeker_profile',
			'edit_jobseeker_profile',
			'job_search',
			'job_details',
			'apply_job',
			'apply',
			'my_applications',
			'career_assessment',
			'assessment_results',
			'jobseeker_analytics',
			'browse_courses',
			'browse_coaches',
			'book_session',
			'submit_feedback'
		],
		'career_coach' => [
			'coach_dashboard',
			'coach_profile',
			'coach_availability',
			'conduct_session',
			'update_coach_session'
		],
		'training_provider' => [
			'provider_dashboard',
			'my_courses',
			'courses',
			'enrollment_requests',
			'financials',
			'revenue',
			'provider_financials',
			'manage_course',
			'delete_course',
			'provider_profile',
			'training_dashboard'
		],
		'company' => [
			'company_dashboard',
			'manage_jobs',
			'manage_job',
			'post_job',
			'delete_job',
			'applicants',
			'candidate_review',
			'update_candidate_status',
			'company_analytics',
			'company_profile'
		],
		'admin' => [
			'admin_dashboard',
			'admin_update_approval',
			'admin_delete_user',
			'admin_delete_job',
			'admin_delete_course'
		]
	];

	if (!in_array($action, $roleActions[$role] ?? [], true)) {
		http_response_code(403);
		exit('Access denied. You do not have permission to access this page.');
	}
}

switch ($action) {

	case 'home':
    require_once __DIR__ . '/views/main.php';
    break;

	// Auth Routes
	case 'login':
		$auth = new AuthController();
		$auth->login();
		break;

	case 'register':
		$auth = new AuthController();
		$auth->register();
		break;

	case 'logout':
		$auth = new AuthController();
		$auth->logout();
		break;


	// Career Coach Routes
	case 'coach_dashboard':
		$coach = new CoachController();
		$coach->dashboard();
		break;

	case 'coach_profile':
		$coach = new CoachController();
		$coach->manageProfile();
		break;

	case 'coach_availability':
		$coach = new CoachController();
		$coach->manageAvailability();
		break;

	case 'conduct_session':
		$coach = new CoachController();
		$coach->conductSession();
		break;

	case 'update_coach_session':
		$coach = new CoachController();
		if (method_exists($coach, 'updateSession')) {
			$coach->updateSession();
		} elseif (method_exists($coach, 'conductSession')) {
			$coach->conductSession();
		}
		break;

	// Job Seeker Coach Interaction Routes
	case 'browse_coaches':
		$coach = new CoachController();
		$coach->listCoachesForSeeker();
		break;

	case 'book_session':
		$coach = new CoachController();
		$coach->bookSession();
		break;

	case 'submit_feedback':
		$coach = new CoachController();
		$coach->submitFeedback();
		break;


	// Job Seeker Routes
	case 'jobseeker_dashboard':
		$js = new JobSeekerController();
		$js->dashboard();
		break;

	case 'view_jobseeker_profile':
		$js = new JobSeekerController();
		$js->viewProfile();
		break;

	case 'edit_jobseeker_profile':
		$js = new JobSeekerController();
		$js->editProfile();
		break;

	case 'job_search':
		$js = new JobSeekerController();
		$js->searchJobs();
		break;

	case 'job_details':
		$js = new JobSeekerController();
		$js->jobDetails();
		break;

	case 'apply_job':
	case 'apply':
		$js = new JobSeekerController();
		$js->apply();
		break;

	case 'my_applications':
		$js = new JobSeekerController();
		$js->myApplications();
		break;

	case 'career_assessment':
		$js = new JobSeekerController();
		$js->assessment();
		break;

	case 'assessment_results':
		$js = new JobSeekerController();
		$js->assessmentResults();
		break;

	case 'jobseeker_analytics':
		$js = new JobSeekerController();
		$js->analytics();
		break;

	case 'browse_courses':
        $js = new JobSeekerController();
        $js->browseCourses();
        break;


	// Training Provider Routes
	case 'provider_dashboard':
		$provider = new ProviderController();
		$provider->dashboard();
		break;

	case 'my_courses':
	case 'courses':
		$provider = new ProviderController();
		$provider->myCourses();
		break;

	case 'enrollment_requests':
		$provider = new ProviderController();
		$provider->enrollmentRequests();
		break;

	case 'financials':
	case 'revenue':
	case 'provider_financials':
		$provider = new ProviderController();
		$provider->financials();
		break;

	case 'manage_course':
		$provider = new ProviderController();
		$provider->manageCourse();
		break;

	case 'delete_course':
		$provider = new ProviderController();
		$provider->deleteCourse();
		break;

	case 'provider_profile':
		$provider = new ProviderController();
		$provider->profile();
		break;


	// Company / Employer Routes 
    case 'company_dashboard': 
        $company = new CompanyController(); 
        $company->dashboard(); 
        break; 

    case 'manage_jobs': 
        $company = new CompanyController(); 
        $company->manageJobs(); 
        break; 

    case 'manage_job': 
        $company = new CompanyController(); 
        $company->manageJob(); 
        break; 

    case 'post_job': 
        $company = new CompanyController(); 
        $company->postJob(); 
        break; 

    case 'delete_job': 
        $company = new CompanyController(); 
        $company->deleteJob(); 
        break; 

    case 'applicants': 
        $company = new CompanyController(); 
        $company->applicants(); 
        break; 

    case 'candidate_review': 
        $company = new CompanyController(); 
        $company->candidateReview(); 
        break; 

    case 'update_candidate_status': 
        $company = new CompanyController(); 
        $company->updateCandidateStatus(); 
        break; 

    case 'company_analytics': 
        $company = new CompanyController(); 
        $company->analytics(); 
        break; 

    case 'company_profile': 
        $company = new CompanyController(); 
        $company->profile(); 
        break;

	// Admin Routes
		case 'admin_update_approval':
		$admin = new AdminController();
		$admin->updateApproval();
		break;

	case 'admin_dashboard':
		$admin = new AdminController();
		$admin->dashboard();
		break;

	case 'admin_delete_user':
		$admin = new AdminController();
		$admin->deleteUser();
		break;

	case 'admin_delete_job':
		$admin = new AdminController();
		$admin->deleteJob();
		break;

	case 'admin_delete_course':
		$admin = new AdminController();
		$admin->deleteCourse();
		break;


	// Remaining Module Shells
	case 'training_dashboard':
		require __DIR__ . '/views/training/dashboard.php';
		break;


	// Default Route
	default:
		$auth = new AuthController();
		$auth->login();
		break;
}