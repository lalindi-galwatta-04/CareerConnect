<?php
$companyName = $company['company_name'] ?? 'Company Account';
$candidates = [
	'kasun' => [
		'name' => 'Kasun Fernando',
		'email' => 'kasun.f@example.com',
		'phone' => '+94 77 123 4567',
		'job' => 'Associate SE (React / Node)',
		'applied_date' => 'Aug 10, 2026',
		'education' => 'BSc in Information Systems',
		'institution' => 'University of Colombo School of Computing',
		'experience' => '1 Year',
		'location' => 'Colombo',
		'skills' => [
			'JavaScript',
			'React',
			'Node.js',
			'MySQL'
		],
		'summary' => 'Entry-level software developer with experience in web application development and modern JavaScript technologies.'
	],
	'nuwan' => [
		'name' => 'Nuwan Jayasinghe',
		'email' => 'nuwan.j@example.com',
		'phone' => '+94 71 456 7890',
		'job' => 'Associate SE (React / Node)',
		'applied_date' => 'Aug 07, 2026',
		'education' => 'BSc in Software Engineering',
		'institution' => 'University of Westminster',
		'experience' => '2 Years',
		'location' => 'Gampaha',
		'skills' => [
			'React',
			'JavaScript',
			'Express.js',
			'MongoDB'
		],
		'summary' => 'Software engineering graduate with practical experience developing responsive web applications and REST APIs.'
	],
	'kavindi' => [
		'name' => 'Kavindi Perera',
		'email' => 'kavindi.p@example.com',
		'phone' => '+94 76 234 5678',
		'job' => 'Senior HR Executive',
		'applied_date' => 'Aug 09, 2026',
		'education' => 'BSc in Human Resource Management',
		'institution' => 'University of Sri Jayewardenepura',
		'experience' => '4 Years',
		'location' => 'Kandy',
		'skills' => [
			'Recruitment',
			'Employee Relations',
			'HR Operations',
			'Performance Management'
		],
		'summary' => 'Human resources professional experienced in recruitment, employee relations and organizational HR operations.'
	],
	'sahan' => [
		'name' => 'Sahan Wickramasinghe',
		'email' => 'sahan.w@example.com',
		'phone' => '+94 75 345 6789',
		'job' => 'Senior HR Executive',
		'applied_date' => 'Aug 02, 2026',
		'education' => 'BSc in Business Management',
		'institution' => 'University of Kelaniya',
		'experience' => '3 Years',
		'location' => 'Colombo',
		'skills' => [
			'Recruitment',
			'Training',
			'HR Administration',
			'Communication'
		],
		'summary' => 'Business management graduate with experience supporting recruitment and employee development activities.'
	],
	'dilini' => [
		'name' => 'Dilini Silva',
		'email' => 'dilini.s@example.com',
		'phone' => '+94 70 567 8901',
		'job' => 'UI/UX Product Designer',
		'applied_date' => 'Aug 06, 2026',
		'education' => 'BSc in Information Technology',
		'institution' => 'University of Moratuwa',
		'experience' => '2 Years',
		'location' => 'Colombo',
		'skills' => [
			'Figma',
			'UI Design',
			'UX Research',
			'Prototyping'
		],
		'summary' => 'UI/UX designer focused on user-centered interfaces, wireframing, prototyping and digital product design.'
	]
];
$candidateKey = $_GET['candidate'] ?? 'kasun';
if (!isset($candidates[$candidateKey])) {
	$candidateKey = 'kasun';
}
$candidate = $candidates[$candidateKey];
$currentStatus = $applicantStatuses[$candidateKey] ?? 'Pending Review';
$statusMessage = $_SESSION['candidate_status_message'] ?? '';
unset($_SESSION['candidate_status_message']);
// Get candidate status class
function candidateStatusClass($status) {
	switch ($status) {
		case 'Shortlisted':
			return 'status-shortlisted';
		case 'Interview Scheduled':
			return 'status-interview';
		case 'Rejected':
			return 'status-rejected';
		default:
			return 'status-pending';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Review - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
	<style>
		.candidate-review-page {
			width: 100%;
			box-sizing: border-box;
		}
		.review-header {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			gap: 20px;
			margin-bottom: 25px;
		}
		.review-header h1 {
			margin: 0 0 6px 0;
		}
		.review-header p {
			margin: 0;
			color: var(--text-muted);
		}
		.review-grid {
			display: grid;
			grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
			gap: 20px;
			align-items: start;
		}
		.review-section {
			margin-bottom: 20px;
		}
		.review-section h2,
		.status-card h2 {
			margin: 0 0 18px 0;
			font-size: 18px;
		}
		.candidate-heading {
			display: flex;
			align-items: center;
			gap: 16px;
			margin-bottom: 22px;
		}
		.candidate-large-avatar {
			width: 58px;
			height: 58px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #eef4ff;
			color: #0066ff;
			font-size: 20px;
			font-weight: 700;
			flex-shrink: 0;
		}
		.candidate-heading h2 {
			margin: 0 0 5px 0;
			font-size: 20px;
		}
		.candidate-heading p {
			margin: 0;
			color: var(--text-muted);
			font-size: 14px;
		}
		.info-grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 18px;
		}
		.info-label {
			display: block;
			margin-bottom: 5px;
			font-size: 12px;
			font-weight: 600;
			color: var(--text-muted);
		}
		.info-value {
			font-size: 14px;
			font-weight: 600;
			word-break: break-word;
		}
		.summary-text {
			margin: 0;
			line-height: 1.7;
		}
		.skills-list {
			display: flex;
			flex-wrap: wrap;
			gap: 8px;
		}
		.skill-tag {
			display: inline-block;
			padding: 7px 11px;
			border-radius: 20px;
			background: #f1f5f9;
			border: 1px solid #e2e8f0;
			font-size: 12px;
			font-weight: 600;
		}
		.status-badge {
			display: inline-block;
			padding: 6px 11px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			white-space: nowrap;
		}
		.status-pending {
			background: #fff4d6;
			color: #8a6300;
		}
		.status-shortlisted {
			background: #e6f4ea;
			color: #137333;
		}
		.status-interview {
			background: #e8f0fe;
			color: #174ea6;
		}
		.status-rejected {
			background: #fce8e6;
			color: #c5221f;
		}
		.cv-box {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 15px;
			padding: 16px;
			border: 1px solid #e5e7eb;
			border-radius: 8px;
			background: #f9fbfd;
		}
		.cv-info strong {
			display: block;
			margin-bottom: 4px;
		}
		.cv-info span {
			font-size: 12px;
			color: var(--text-muted);
		}
		.status-card {
			position: sticky;
			top: calc(var(--header-height) + 25px);
		}
		.current-status {
			padding: 15px;
			margin-bottom: 20px;
			border-radius: 8px;
			background: #f9fbfd;
			border: 1px solid #e5e7eb;
		}
		.current-status-label {
			display: block;
			margin-bottom: 8px;
			font-size: 12px;
			font-weight: 600;
			color: var(--text-muted);
		}
		.status-actions .form-group {
			margin-bottom: 15px;
		}
		.status-actions .btn {
			width: 100%;
			text-align: center;
		}
		.status-message {
			margin-bottom: 20px;
			padding: 12px;
			border-radius: 6px;
			background: #e6f4ea;
			color: #137333;
			font-size: 13px;
			font-weight: 600;
		}
		@media (max-width: 1000px) {
			.review-grid {
				grid-template-columns: 1fr;
			}
			.status-card {
				position: static;
			}
		}
		@media (max-width: 700px) {
			.review-header {
				flex-direction: column;
			}
			.info-grid {
				grid-template-columns: 1fr;
			}
			.cv-box {
				flex-direction: column;
				align-items: flex-start;
			}
		}
	</style>
</head>
<body>
<?php
$activePage = 'applicants';
require __DIR__ . '/partials/company_navbar.php';
?>
<header class="top-header">
	<div class="user-profile" id="userProfile">
		<button
			type="button"
			class="user-profile-button"
			onclick="toggleProfileDropdown()"
		>
			<div
				class="user-avatar"
				style="display:flex;align-items:center;justify-content:center;font-weight:700;"
			>
				<?php
				echo htmlspecialchars(
					strtoupper(
						substr($companyName, 0, 1)
					)
				);
				?>
			</div>
			<span class="user-name">
				<?php echo htmlspecialchars($companyName); ?>
			</span>
			<span class="user-arrow">▼</span>
		</button>
		<div class="profile-dropdown" id="profileDropdown">
			<div class="dropdown-user">
				<div
					class="user-avatar"
					style="display:flex;align-items:center;justify-content:center;font-weight:700;"
				>
					<?php
					echo htmlspecialchars(
						strtoupper(
							substr($companyName, 0, 1)
						)
					);
					?>
				</div>
				<div class="dropdown-user-info">
					<strong>
						<?php echo htmlspecialchars($companyName); ?>
					</strong>
					<span>
						<?php echo htmlspecialchars($company['email'] ?? ''); ?>
					</span>
				</div>
			</div>
			<a href="index.php?action=company_profile">
				Company Profile
			</a>
			<a
				href="index.php?action=logout"
				class="dropdown-logout"
			>
				Logout
			</a>
		</div>
	</div>
</header>
<main class="container">
	<div class="candidate-review-page">
		<div class="review-header">
			<div>
				<h1>Candidate Review</h1>
				<p>Review candidate information and update the application status.</p>
			</div>
			<a
				href="index.php?action=applicants"
				class="btn btn-secondary"
			>
				← Back to Applicants
			</a>
		</div>
		<?php if ($statusMessage !== ''): ?>
			<div class="status-message">
				<?php echo htmlspecialchars($statusMessage); ?>
			</div>
		<?php endif; ?>
		<div class="review-grid">
			<div>
				<div class="section-card review-section">
					<div class="candidate-heading">
						<div class="candidate-large-avatar">
							<?php
							echo htmlspecialchars(
								strtoupper(
									substr($candidate['name'], 0, 1)
								)
							);
							?>
						</div>
						<div>
							<h2>
								<?php echo htmlspecialchars($candidate['name']); ?>
							</h2>
							<p>
								<?php echo htmlspecialchars($candidate['email']); ?>
							</p>
						</div>
					</div>
					<div class="info-grid">
						<div>
							<span class="info-label">
								Applied Position
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['job']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Applied Date
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['applied_date']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Email Address
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['email']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Phone Number
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['phone']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Location
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['location']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Experience
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['experience']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="section-card review-section">
					<h2>Professional Summary</h2>
					<p class="summary-text">
						<?php echo htmlspecialchars($candidate['summary']); ?>
					</p>
				</div>
				<div class="section-card review-section">
					<h2>Education</h2>
					<div class="info-grid">
						<div>
							<span class="info-label">
								Qualification
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['education']); ?>
							</div>
						</div>
						<div>
							<span class="info-label">
								Institution
							</span>
							<div class="info-value">
								<?php echo htmlspecialchars($candidate['institution']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="section-card review-section">
					<h2>Skills</h2>
					<div class="skills-list">
						<?php foreach ($candidate['skills'] as $skill): ?>
							<span class="skill-tag">
								<?php echo htmlspecialchars($skill); ?>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="section-card review-section">
					<h2>Resume / CV</h2>
					<div class="cv-box">
						<div class="cv-info">
							<strong>
								<?php echo htmlspecialchars($candidate['name']); ?> - CV.pdf
							</strong>
							<span>PDF Document</span>
						</div>
						<button
							type="button"
							class="btn btn-secondary"
							onclick="viewDummyCV()"
						>
							View CV
						</button>
					</div>
				</div>
			</div>
			<div>
				<div class="section-card status-card">
					<h2>Application Status</h2>
					<div class="current-status">
						<span class="current-status-label">
							Current Status
						</span>
						<span
							class="status-badge <?php echo htmlspecialchars(candidateStatusClass($currentStatus)); ?>"
						>
							<?php echo htmlspecialchars($currentStatus); ?>
						</span>
					</div>
					<form
						method="POST"
						action="index.php?action=update_candidate_status"
						class="status-actions"
					>
						<input
							type="hidden"
							name="candidate"
							value="<?php echo htmlspecialchars($candidateKey); ?>"
						>
						<div class="form-group">
							<label for="applicationStatus">
								Update Status
							</label>
							<select
								id="applicationStatus"
								name="status"
								required
							>
								<option
									value="Pending Review"
									<?php echo $currentStatus === 'Pending Review' ? 'selected' : ''; ?>
								>
									Pending Review
								</option>
								<option
									value="Shortlisted"
									<?php echo $currentStatus === 'Shortlisted' ? 'selected' : ''; ?>
								>
									Shortlisted
								</option>
								<option
									value="Interview Scheduled"
									<?php echo $currentStatus === 'Interview Scheduled' ? 'selected' : ''; ?>
								>
									Interview Scheduled
								</option>
								<option
									value="Rejected"
									<?php echo $currentStatus === 'Rejected' ? 'selected' : ''; ?>
								>
									Rejected
								</option>
							</select>
						</div>
						<button
							type="submit"
							class="btn"
						>
							Update Status
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
<script>
// CV preview
function viewDummyCV() {
	alert('CV preview is for UI demonstration only.');
}
// Profile dropdown
function toggleProfileDropdown() {
	const dropdown = document.getElementById('profileDropdown');
	const profile = document.getElementById('userProfile');
	dropdown.classList.toggle('show');
	profile.classList.toggle('open');
}
document.addEventListener(
	'click',
	function(event) {
		const profile = document.getElementById('userProfile');
		const dropdown = document.getElementById('profileDropdown');
		if (
			profile &&
			dropdown &&
			!profile.contains(event.target)
		) {
			dropdown.classList.remove('show');
			profile.classList.remove('open');
		}
	}
);
</script>
</body>
</html>