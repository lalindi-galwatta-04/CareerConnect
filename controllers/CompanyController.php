<?php

require_once __DIR__ . '/../models/Company.php';

class CompanyController {
	private $companyModel;

	public function __construct() {
		$database = new Database();
		$db = $database->getConnection();
		$this->companyModel = new CompanyModel($db);
	}

	public function dashboard() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);
		$jobs = $this->companyModel->getJobsByCompany($user_id);
		$metrics = $this->companyModel->getCompanyMetrics($user_id);

		$this->initializeDummyApplicantStatuses();

		$applicantStatuses = $_SESSION['dummy_applicant_statuses'];
		$dummyApplicants = $this->getDummyApplicants();

		$totalApplications = count($dummyApplicants);

		$pendingApplications = 0;
		$shortlistedApplications = 0;
		$interviewApplications = 0;
		$rejectedApplications = 0;

		foreach ($applicantStatuses as $status) {
			switch ($status) {
				case 'Pending Review':
					$pendingApplications++;
					break;

				case 'Shortlisted':
					$shortlistedApplications++;
					break;

				case 'Interview Scheduled':
					$interviewApplications++;
					break;

				case 'Rejected':
					$rejectedApplications++;
					break;
			}
		}

		$today = date('Y-m-d');

		$activeJobs = 0;
		$postedJobs = 0;
		$draftedJobs = 0;
		$upcomingJobs = 0;
		$closedJobs = 0;

		foreach ($jobs as $job) {
			$status = strtolower($job['status'] ?? 'draft');
			$openingDate = $job['opening_date'] ?? '';
			$closingDate = $job['closing_date'] ?? '';

			if ($status === 'draft') {
				$draftedJobs++;
				continue;
			}

			if ($status === 'posted') {
				$postedJobs++;

				if ($openingDate !== '' && $openingDate > $today) {
					$upcomingJobs++;
				} elseif ($closingDate !== '' && $closingDate < $today) {
					$closedJobs++;
				} else {
					$activeJobs++;
				}
			}
		}

		require __DIR__ . '/../views/company/dashboard.php';
	}

	public function profile() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];
		$company = $this->companyModel->getProfile($user_id);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = trim($_POST['company_name'] ?? '');
			$industry = trim($_POST['industry'] ?? '');
			$website = trim($_POST['website'] ?? '');
			$location = trim($_POST['location'] ?? '');
			$description = trim($_POST['description'] ?? '');

			if ($name === '') {
				$error = "Company name is required.";
			} else {
				$this->companyModel->updateProfile(
					$user_id,
					$name,
					$industry,
					$website,
					$location,
					$description
				);

				header("Location: index.php?action=company_profile");
				exit;
			}
		}

		require __DIR__ . '/../views/company/profile.php';
	}

	public function manageJobs() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);
		$jobs = $this->companyModel->getJobsByCompany($user_id);

		$statusFilter = strtolower(trim($_GET['status'] ?? ''));

		if ($statusFilter !== '') {
			$jobs = array_filter(
				$jobs,
				function($job) use ($statusFilter) {
					return strtolower($job['status'] ?? '') === $statusFilter;
				}
			);
		}

		require __DIR__ . '/../views/company/manage_jobs.php';
	}

	public function manageJob() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);

		$job_id = $_GET['id'] ?? null;
		$job = null;

		if ($job_id) {
			$job = $this->companyModel->getJobById(
				$job_id,
				$user_id
			);

			if (!$job) {
				header("Location: index.php?action=manage_jobs");
				exit;
			}
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$title = trim($_POST['title'] ?? '');
			$job_type = trim($_POST['job_type'] ?? '');
			$location = trim($_POST['location'] ?? '');
			$salary = trim($_POST['salary_range'] ?? '');
			$description = trim($_POST['description'] ?? '');
			$requirements = trim($_POST['requirements'] ?? '');
			$opening_date = trim($_POST['opening_date'] ?? '');
			$closing_date = trim($_POST['closing_date'] ?? '');

			// Keep existing flyer when editing
			$flyer = $job['flyer'] ?? null;

			// Handle optional job flyer
			if (
				isset($_FILES['flyer']) &&
				$_FILES['flyer']['error'] !== UPLOAD_ERR_NO_FILE
			) {
				if ($_FILES['flyer']['error'] === UPLOAD_ERR_OK) {
					$allowedExtensions = [
						'pdf',
						'jpg',
						'jpeg',
						'png'
					];

					$originalName = $_FILES['flyer']['name'];
					$tempName = $_FILES['flyer']['tmp_name'];
					$extension = strtolower(
						pathinfo(
							$originalName,
							PATHINFO_EXTENSION
						)
					);

					if (!in_array($extension, $allowedExtensions, true)) {
						$error = "Flyer must be a PDF, JPG, JPEG or PNG file.";
					} else {
						$uploadDirectory =
							__DIR__ . '/../public/uploads/job_flyers/';

						if (!is_dir($uploadDirectory)) {
							mkdir(
								$uploadDirectory,
								0777,
								true
							);
						}

						$fileName =
							'job_flyer_' .
							uniqid() .
							'.' .
							$extension;

						$destination =
							$uploadDirectory .
							$fileName;

						if (
							move_uploaded_file(
								$tempName,
								$destination
							)
						) {
							$flyer =
								'public/uploads/job_flyers/' .
								$fileName;
						} else {
							$error =
								"Unable to upload the job flyer.";
						}
					}
				} else {
					$error =
						"An error occurred while uploading the job flyer.";
				}
			}

			if (isset($error)) {
				// Keep the error and show the form again
			} elseif (
				$title === '' ||
				$job_type === '' ||
				$location === '' ||
				$description === '' ||
				$requirements === '' ||
				$opening_date === '' ||
				$closing_date === ''
			) {
				$error = "Please complete all required fields.";
			} elseif ($closing_date < $opening_date) {
				$error =
					"Closing date cannot be before the opening date.";
			} else {
				if ($job_id) {
					$this->companyModel->updateJob(
						$job_id,
						$user_id,
						$title,
						$job_type,
						$location,
						$salary,
						$description,
						$requirements,
						$opening_date,
						$closing_date,
						$flyer
					);
				} else {
					$this->companyModel->createJob(
						$user_id,
						$title,
						$job_type,
						$location,
						$salary,
						$description,
						$requirements,
						$opening_date,
						$closing_date,
						'draft',
						$flyer
					);
				}

				header("Location: index.php?action=manage_jobs");
				exit;
			}
		}

		require __DIR__ . '/../views/company/job_form.php';
	}

	public function postJob() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];
		$job_id = $_GET['id'] ?? null;

		if (!$job_id) {
			header("Location: index.php?action=manage_jobs");
			exit;
		}

		$job = $this->companyModel->getJobById(
			$job_id,
			$user_id
		);

		if (!$job) {
			header("Location: index.php?action=manage_jobs");
			exit;
		}

		if (strtolower($job['status'] ?? '') === 'draft') {
			$this->companyModel->updateJobStatus(
				$job_id,
				$user_id,
				'posted'
			);
		}

		header("Location: index.php?action=manage_jobs");
		exit;
	}

	public function deleteJob() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];
		$job_id = $_GET['id'] ?? null;

		if (!$job_id) {
			header("Location: index.php?action=manage_jobs");
			exit;
		}

		$job = $this->companyModel->getJobById(
			$job_id,
			$user_id
		);

		if (!$job) {
			header("Location: index.php?action=manage_jobs");
			exit;
		}

		$this->companyModel->deleteJob(
			$job_id,
			$user_id
		);

		header("Location: index.php?action=manage_jobs");
		exit;
	}

	public function applicants() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);

		$this->initializeDummyApplicantStatuses();

		$applicantStatuses =
			$_SESSION['dummy_applicant_statuses'];

		$applicants = $this->getDummyApplicants();

		require __DIR__ . '/../views/company/applicants.php';
	}

	public function candidateReview() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);

		$this->initializeDummyApplicantStatuses();

		$applicantStatuses =
			$_SESSION['dummy_applicant_statuses'];

		require __DIR__ . '/../views/company/candidate_review.php';
	}

	public function updateCandidateStatus() {
		$this->checkCompanySession();

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header("Location: index.php?action=applicants");
			exit;
		}

		$this->initializeDummyApplicantStatuses();

		$candidate = trim($_POST['candidate'] ?? '');
		$status = trim($_POST['status'] ?? '');

		$validCandidates = [
			'kasun',
			'nuwan',
			'kavindi',
			'sahan',
			'dilini'
		];

		$validStatuses = [
			'Pending Review',
			'Shortlisted',
			'Interview Scheduled',
			'Rejected'
		];

		if (
			in_array($candidate, $validCandidates, true) &&
			in_array($status, $validStatuses, true)
		) {
			$_SESSION['dummy_applicant_statuses'][$candidate] =
				$status;

			$_SESSION['candidate_status_message'] =
				'Application status updated successfully.';
		}

		header(
			"Location: index.php?action=candidate_review&candidate=" .
			urlencode($candidate)
		);

		exit;
	}

	public function analytics() {
		$this->checkCompanySession();

		$user_id = $_SESSION['user_id'];

		$company = $this->companyModel->getProfile($user_id);
		$jobs = $this->companyModel->getJobsByCompany($user_id);
		$metrics = $this->companyModel->getCompanyMetrics($user_id);

		$this->initializeDummyApplicantStatuses();

		$applicantStatuses =
			$_SESSION['dummy_applicant_statuses'];

		$dummyApplicants = $this->getDummyApplicants();

		$totalApplicants = count($dummyApplicants);

		$pendingApplications = 0;
		$shortlistedApplications = 0;
		$interviewApplications = 0;
		$rejectedApplications = 0;

		foreach ($applicantStatuses as $status) {
			switch ($status) {
				case 'Pending Review':
					$pendingApplications++;
					break;

				case 'Shortlisted':
					$shortlistedApplications++;
					break;

				case 'Interview Scheduled':
					$interviewApplications++;
					break;

				case 'Rejected':
					$rejectedApplications++;
					break;
			}
		}

		$today = date('Y-m-d');

		$activeCount = 0;
		$upcomingCount = 0;
		$draftCount = 0;
		$closedCount = 0;

		foreach ($jobs as &$job) {
			$status =
				strtolower($job['status'] ?? 'draft');

			$openingDate =
				$job['opening_date'] ?? '';

			$closingDate =
				$job['closing_date'] ?? '';

			if ($status === 'draft') {
				$displayStatus = 'Draft';
				$draftCount++;
			} elseif (
				$openingDate !== '' &&
				$openingDate > $today
			) {
				$displayStatus = 'Upcoming';
				$upcomingCount++;
			} elseif (
				$closingDate !== '' &&
				$closingDate < $today
			) {
				$displayStatus = 'Closed';
				$closedCount++;
			} else {
				$displayStatus = 'Active';
				$activeCount++;
			}

			$job['display_status'] = $displayStatus;
			$job['applicant_count'] = 0;
		}

		unset($job);

		foreach ($dummyApplicants as $applicant) {
			foreach ($jobs as &$job) {
				if (
					strtolower(
						trim($job['title'] ?? '')
					) ===
					strtolower(
						trim($applicant['job'])
					)
				) {
					$job['applicant_count']++;
					break;
				}
			}

			unset($job);
		}

		$maxApplicants = 0;

		foreach ($jobs as $job) {
			$applicantCount =
				(int)($job['applicant_count'] ?? 0);

			if ($applicantCount > $maxApplicants) {
				$maxApplicants = $applicantCount;
			}
		}

		require __DIR__ . '/../views/company/analytics.php';
	}

	private function getDummyApplicants() {
		return [
			[
				'key' => 'kasun',
				'name' => 'Kasun Fernando',
				'email' => 'kasun.f@example.com',
				'job' => 'Associate SE (React / Node)',
				'applied_date' => 'Aug 10, 2026'
			],
			[
				'key' => 'nuwan',
				'name' => 'Nuwan Jayasinghe',
				'email' => 'nuwan.j@example.com',
				'job' => 'Associate SE (React / Node)',
				'applied_date' => 'Aug 07, 2026'
			],
			[
				'key' => 'kavindi',
				'name' => 'Kavindi Perera',
				'email' => 'kavindi.p@example.com',
				'job' => 'Senior HR Executive',
				'applied_date' => 'Aug 09, 2026'
			],
			[
				'key' => 'sahan',
				'name' => 'Sahan Wickramasinghe',
				'email' => 'sahan.w@example.com',
				'job' => 'Senior HR Executive',
				'applied_date' => 'Aug 02, 2026'
			],
			[
				'key' => 'dilini',
				'name' => 'Dilini Silva',
				'email' => 'dilini.s@example.com',
				'job' => 'UI/UX Product Designer',
				'applied_date' => 'Aug 06, 2026'
			]
		];
	}

	private function initializeDummyApplicantStatuses() {
		if (!isset($_SESSION['dummy_applicant_statuses'])) {
			$_SESSION['dummy_applicant_statuses'] = [
				'kasun' => 'Pending Review',
				'nuwan' => 'Shortlisted',
				'kavindi' => 'Pending Review',
				'sahan' => 'Rejected',
				'dilini' => 'Interview Scheduled'
			];
		}
	}

	private function checkCompanySession() {
		if (!isset($_SESSION['user_id'])) {
			header("Location: index.php?action=login");
			exit;
		}
	}
}