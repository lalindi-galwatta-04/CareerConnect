<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Coach.php';

class AuthController {

    private $db;
    private $userModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }


    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($email, $password);

            if ($user) {

                // Job seekers and admins do not require approval
                if (
                    $user['user_type'] !== 'job_seeker' &&
                    $user['user_type'] !== 'admin'
                ) {

                    if (($user['approval_status'] ?? 'pending') === 'pending') {
	session_unset();
	session_regenerate_id(true);
	require __DIR__ . '/../views/auth/pending_approval.php';
	return;
}

                    if (($user['approval_status'] ?? '') === 'rejected') {

                        $error = "Your account registration has been rejected.";
                        require __DIR__ . '/../views/auth/login.php';
                        return;
                    }

                    if (($user['approval_status'] ?? '') !== 'approved') {

                        $error = "Your account has not been approved.";
                        require __DIR__ . '/../views/auth/login.php';
                        return;
                    }
                }

                session_regenerate_id(true);
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_type'] = $user['user_type'];

                switch ($user['user_type']) {

                    case 'job_seeker':
                        header("Location: index.php?action=jobseeker_dashboard");
                        break;

                    case 'career_coach':
                        header("Location: index.php?action=coach_dashboard");
                        break;

                    case 'company':
                        header("Location: index.php?action=company_dashboard");
                        break;

                    case 'training_provider':
                        header("Location: index.php?action=provider_dashboard");
                        break;

                    case 'admin':
                        header("Location: index.php?action=admin_dashboard");
                        break;

                    default:
                        header("Location: index.php?action=login");
                        break;
                }

                exit;

            } else {

                $error = "Invalid email or password.";
                require __DIR__ . '/../views/auth/login.php';
            }

        } else {

            require __DIR__ . '/../views/auth/login.php';
        }
    }


    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone = trim($_POST['phone_number'] ?? '');
            $user_type = $_POST['user_type'] ?? '';

            $allowed_roles = [
                'job_seeker',
                'career_coach',
                'company',
                'training_provider'
            ];

            if (!in_array($user_type, $allowed_roles, true)) {

                $error = "Unauthorized role selection.";
                require __DIR__ . '/../views/auth/register.php';
                return;
            }


            // Create user account
            $user_id = $this->userModel->register(
                $email,
                $password,
                $phone,
                $user_type
            );


            if (!$user_id) {

                $error = "Registration failed. Email may already exist.";
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Upload directory
            $uploadDirectory = __DIR__ . '/../public/uploads/verification/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }


            switch ($user_type) {


                // JOB SEEKER
                case 'job_seeker':

                    $firstName = trim($_POST['first_name'] ?? '');
                    $lastName = trim($_POST['last_name'] ?? '');

                    if ($firstName === '' || $lastName === '') {

                        $error = "First name and last name are required.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }

                    $stmt = $this->db->prepare("
                        INSERT INTO job_seeker
                        (user_id, first_name, last_name)
                        VALUES
                        (:uid, :fn, :ln)
                    ");

                    $stmt->execute([
                        ':uid' => $user_id,
                        ':fn' => $firstName,
                        ':ln' => $lastName
                    ]);

                    break;


                // CAREER COACH
                case 'career_coach':

                    $coachName = trim($_POST['coach_name'] ?? '');
                    $specialization = trim($_POST['specialization'] ?? '');

                    if (
                        $coachName === '' ||
                        $specialization === '' ||
                        !isset($_FILES['coach_document']) ||
                        $_FILES['coach_document']['error'] !== UPLOAD_ERR_OK
                    ) {

                        $error = "Please complete all Career Coach registration fields.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $coachDocument = $this->uploadDocument(
                        $_FILES['coach_document'],
                        $uploadDirectory,
                        'coach'
                    );


                    if (!$coachDocument) {

                        $error = "Invalid Career Coach verification document.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $stmt = $this->db->prepare("
                        INSERT INTO career_coach
                        (
                            user_id,
                            coach_name,
                            specialization,
                            verification_document
                        )
                        VALUES
                        (
                            :uid,
                            :name,
                            :specialization,
                            :document
                        )
                    ");

                    $stmt->execute([
                        ':uid' => $user_id,
                        ':name' => $coachName,
                        ':specialization' => $specialization,
                        ':document' => $coachDocument
                    ]);

                    break;


                // COMPANY
                case 'company':

                    $companyName = trim($_POST['company_name'] ?? '');
                    $industry = trim($_POST['industry'] ?? '');
                    $registrationNumber = trim(
                        $_POST['company_registration_number'] ?? ''
                    );


                    if (
                        $companyName === '' ||
                        $industry === '' ||
                        $registrationNumber === '' ||
                        !isset($_FILES['company_document']) ||
                        $_FILES['company_document']['error'] !== UPLOAD_ERR_OK
                    ) {

                        $error = "Please complete all Company registration fields.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $companyDocument = $this->uploadDocument(
                        $_FILES['company_document'],
                        $uploadDirectory,
                        'company'
                    );


                    if (!$companyDocument) {

                        $error = "Invalid Company registration document.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $stmt = $this->db->prepare("
                        INSERT INTO company
                        (
                            user_id,
                            company_name,
                            industry,
                            registration_number,
                            registration_document
                        )
                        VALUES
                        (
                            :uid,
                            :name,
                            :industry,
                            :registration,
                            :document
                        )
                    ");

                    $stmt->execute([
                        ':uid' => $user_id,
                        ':name' => $companyName,
                        ':industry' => $industry,
                        ':registration' => $registrationNumber,
                        ':document' => $companyDocument
                    ]);

                    break;


                // TRAINING PROVIDER
                case 'training_provider':

                    $providerName = trim($_POST['provider_name'] ?? '');
                    $registrationNumber = trim(
                        $_POST['provider_registration_number'] ?? ''
                    );


                    if (
                        $providerName === '' ||
                        $registrationNumber === '' ||
                        !isset($_FILES['provider_document']) ||
                        $_FILES['provider_document']['error'] !== UPLOAD_ERR_OK
                    ) {

                        $error = "Please complete all Training Provider registration fields.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $providerDocument = $this->uploadDocument(
                        $_FILES['provider_document'],
                        $uploadDirectory,
                        'provider'
                    );


                    if (!$providerDocument) {

                        $error = "Invalid Training Provider registration document.";
                        require __DIR__ . '/../views/auth/register.php';
                        return;
                    }


                    $stmt = $this->db->prepare("
                        INSERT INTO training_provider
                        (
                            user_id,
                            provider_name,
                            registration_number,
                            registration_document
                        )
                        VALUES
                        (
                            :uid,
                            :name,
                            :registration,
                            :document
                        )
                    ");

                    $stmt->execute([
                        ':uid' => $user_id,
                        ':name' => $providerName,
                        ':registration' => $registrationNumber,
                        ':document' => $providerDocument
                    ]);

                    break;
            }
            // Registration completed
            // Registration completed
session_unset();
session_regenerate_id(true);

if ($user_type === 'job_seeker') {
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user_type'] = 'job_seeker';

	header("Location: index.php?action=jobseeker_dashboard");
	exit;
}

require __DIR__ . '/../views/auth/pending_approval.php';
exit;
        } else {
            require __DIR__ . '/../views/auth/register.php';
        }
    }

    private function uploadDocument($file, $uploadDirectory, $prefix) {

        $allowedExtensions = [
            'pdf',
            'jpg',
            'jpeg',
            'png'
        ];

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowedExtensions, true)) {
            return false;
        }

        // Maximum file size: 5 MB
        if ($file['size'] > 5 * 1024 * 1024) {
            return false;
        }

        $fileName =
            $prefix . '_' .
            uniqid() . '.' .
            $extension;

        $destination =
            $uploadDirectory .
            $fileName;

        if (!move_uploaded_file(
            $file['tmp_name'],
            $destination
        )) {
            return false;
        }
        return 'public/uploads/verification/' . $fileName;
    }


    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}