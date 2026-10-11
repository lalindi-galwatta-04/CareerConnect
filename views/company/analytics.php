<?php
$companyName = $company['company_name'] ?? 'Company Account';
$today = date('Y-m-d');
// Safe defaults normally prepared by CompanyController
$totalApplicants = $totalApplicants ?? 0;
$activeCount = $activeCount ?? 0;
$upcomingCount = $upcomingCount ?? 0;
$draftCount = $draftCount ?? 0;
$closedCount = $closedCount ?? 0;
$pendingApplications = $pendingApplications ?? 0;
$shortlistedApplications = $shortlistedApplications ?? 0;
$interviewApplications = $interviewApplications ?? 0;
$rejectedApplications = $rejectedApplications ?? 0;
$maxApplicants = $maxApplicants ?? 0;
// Total vacancies
$totalVacancies =
	$activeCount +
	$upcomingCount +
	$draftCount +
	$closedCount;
// Vacancy status widths
$activeWidth =
	$totalVacancies > 0
		? ($activeCount / $totalVacancies) * 100
		: 0;
$upcomingWidth =
	$totalVacancies > 0
		? ($upcomingCount / $totalVacancies) * 100
		: 0;
$draftWidth =
	$totalVacancies > 0
		? ($draftCount / $totalVacancies) * 100
		: 0;
$closedWidth =
	$totalVacancies > 0
		? ($closedCount / $totalVacancies) * 100
		: 0;
// Application status widths
$pendingWidth =
	$totalApplicants > 0
		? ($pendingApplications / $totalApplicants) * 100
		: 0;
$shortlistedWidth =
	$totalApplicants > 0
		? ($shortlistedApplications / $totalApplicants) * 100
		: 0;
$interviewWidth =
	$totalApplicants > 0
		? ($interviewApplications / $totalApplicants) * 100
		: 0;
$rejectedWidth =
	$totalApplicants > 0
		? ($rejectedApplications / $totalApplicants) * 100
		: 0;
// Helper functions
function getAnalyticsJobStatus($job, $today) {
	if (!empty($job['display_status'])) {
		return $job['display_status'];
	}
	$status = strtolower($job['status'] ?? 'draft');
	$openingDate = $job['opening_date'] ?? '';
	$closingDate = $job['closing_date'] ?? '';
	if ($status === 'draft') {
		return 'Draft';
	}
	if (
		$openingDate !== '' &&
		$openingDate > $today
	) {
		return 'Upcoming';
	}
	if (
		$closingDate !== '' &&
		$closingDate < $today
	) {
		return 'Closed';
	}
	return 'Active';
}
function formatAnalyticsDate($date) {
	if (empty($date)) {
		return '-';
	}
	return date(
		'M d, Y',
		strtotime($date)
	);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Recruitment Analytics - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
	<style>
		.analytics-page {
			width: 100%;
			box-sizing: border-box;
		}
		.analytics-heading {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			gap: 20px;
			margin-bottom: 25px;
		}
		.analytics-heading h1 {
			margin: 0 0 6px 0;
			font-size: 26px;
			color: #0a1d37;
		}
		.analytics-heading p {
			margin: 0;
			color: #64748b;
			font-size: 13px;
		}
		.analytics-heading-actions {
			display: flex;
			gap: 10px;
		}
		.metrics-grid {
			display: grid;
			grid-template-columns: repeat(4, minmax(0, 1fr));
			gap: 15px;
			margin-bottom: 25px;
		}
		.metric-card {
			background: #ffffff;
			border: 1px solid #dfe3e8;
			border-radius: 9px;
			padding: 18px;
			min-height: 115px;
			box-sizing: border-box;
		}
		.metric-title {
			font-size: 11px;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			color: #64748b;
			margin-bottom: 10px;
		}
		.metric-value {
			font-size: 28px;
			font-weight: 700;
			color: #0a1d37;
			margin-bottom: 6px;
		}
		.metric-note {
			font-size: 12px;
			color: #64748b;
		}
		.analytics-grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 20px;
			margin-bottom: 25px;
		}
		.analytics-card {
			background: #ffffff;
			border: 1px solid #dfe3e8;
			border-radius: 9px;
			padding: 20px;
			box-sizing: border-box;
			min-width: 0;
		}
		.analytics-card h2 {
			font-size: 16px;
			margin: 0 0 5px 0;
			color: #0a1d37;
		}
		.card-description {
			font-size: 12px;
			color: #64748b;
			margin: 0 0 22px 0;
		}
		.application-row {
			margin-bottom: 18px;
		}
		.application-row:last-child {
			margin-bottom: 0;
		}
		.application-info {
			display: flex;
			justify-content: space-between;
			gap: 15px;
			font-size: 13px;
			margin-bottom: 7px;
		}
		.application-info span:first-child {
			font-weight: 600;
			color: #0a1d37;
		}
		.application-count {
			font-weight: 700;
			color: #0a1d37;
			white-space: nowrap;
		}
		.progress-track {
			width: 100%;
			height: 11px;
			background: #e5e9ee;
			border-radius: 10px;
			overflow: hidden;
		}
		.progress-fill {
			height: 100%;
			background: #0066ff;
			border-radius: 10px;
		}
		.status-row {
			margin-bottom: 18px;
		}
		.status-row:last-child {
			margin-bottom: 0;
		}
		.status-info {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 7px;
			font-size: 13px;
		}
		.status-name,
		.status-number {
			font-weight: 600;
			color: #0a1d37;
		}
		.status-number {
			font-weight: 700;
		}
		.status-active-fill {
			background: #16a34a;
		}
		.status-upcoming-fill {
			background: #2563eb;
		}
		.status-draft-fill {
			background: #94a3b8;
		}
		.status-closed-fill {
			background: #dc2626;
		}
		.status-pending-fill {
			background: #d97706;
		}
		.status-shortlisted-fill {
			background: #16a34a;
		}
		.status-interview-fill {
			background: #2563eb;
		}
		.status-rejected-fill {
			background: #dc2626;
		}
		.performance-card {
			background: #ffffff;
			border: 1px solid #dfe3e8;
			border-radius: 9px;
			padding: 20px;
			margin-bottom: 25px;
			box-sizing: border-box;
			width: 100%;
		}
		.performance-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 15px;
			margin-bottom: 20px;
		}
		.performance-header h2 {
			margin: 0 0 5px 0;
			font-size: 16px;
			color: #0a1d37;
		}
		.performance-header p {
			margin: 0;
			font-size: 12px;
			color: #64748b;
		}
		.table-wrapper {
			width: 100%;
			overflow-x: auto;
		}
		.performance-table {
			width: 100%;
			border-collapse: collapse;
			text-align: left;
			font-size: 12px;
		}
		.performance-table th {
			background: #f1f5f9;
			padding: 11px 10px;
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 0.4px;
			color: #64748b;
			border-bottom: 1px solid #d5dce5;
			white-space: nowrap;
		}
		.performance-table td {
			padding: 13px 10px;
			border-bottom: 1px solid #e5e7eb;
			vertical-align: middle;
		}
		.performance-table tbody tr:last-child td {
			border-bottom: none;
		}
		.job-title {
			font-weight: 700;
			color: #0a1d37;
		}
		.applicant-number {
			font-weight: 700;
			color: #0066ff;
		}
		.status-badge {
			display: inline-block;
			padding: 5px 10px;
			border-radius: 20px;
			font-size: 10px;
			font-weight: 700;
			white-space: nowrap;
		}
		.badge-active {
			background: #dcfce7;
			color: #15803d;
		}
		.badge-upcoming {
			background: #dbeafe;
			color: #1d4ed8;
		}
		.badge-draft {
			background: #f1f5f9;
			color: #64748b;
		}
		.badge-closed {
			background: #fee2e2;
			color: #b91c1c;
		}
		.empty-message {
			padding: 30px 10px;
			text-align: center;
			color: #64748b;
			font-size: 13px;
		}
		@media (max-width: 1000px) {
			.metrics-grid {
				grid-template-columns: repeat(2, minmax(0, 1fr));
			}
			.analytics-grid {
				grid-template-columns: 1fr;
			}
		}
		@media (max-width: 768px) {
			.analytics-heading {
				flex-direction: column;
			}
			.performance-header {
				flex-direction: column;
				align-items: flex-start;
			}
		}
		@media (max-width: 500px) {
			.metrics-grid {
				grid-template-columns: 1fr;
			}
		}
	</style>
</head>
<body>
<?php
$activePage = 'analytics';
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
	<div class="analytics-page">
		<div class="analytics-heading">
			<div>
				<h1>Recruitment Analytics & Insights</h1>
			</div>
			<div class="analytics-heading-actions">
				<a
					href="index.php?action=manage_jobs"
					class="btn btn-secondary"
				>
					View Jobs
				</a>
			</div>
		</div>
		<div class="metrics-grid">
			<div class="metric-card">
				<div class="metric-title">
					Total Applicants
				</div>
				<div class="metric-value">
					<?php echo $totalApplicants; ?>
				</div>
				<div class="metric-note">
					Applications received
				</div>
			</div>
			<div class="metric-card">
				<div class="metric-title">
					Active Vacancies
				</div>
				<div class="metric-value">
					<?php echo $activeCount; ?>
				</div>
				<div class="metric-note">
					Currently accepting applications
				</div>
			</div>
			<div class="metric-card">
				<div class="metric-title">
					Upcoming Vacancies
				</div>
				<div class="metric-value">
					<?php echo $upcomingCount; ?>
				</div>
				<div class="metric-note">
					Scheduled to open
				</div>
			</div>
			<div class="metric-card">
				<div class="metric-title">
					Draft Vacancies
				</div>
				<div class="metric-value">
					<?php echo $draftCount; ?>
				</div>
				<div class="metric-note">
					Not yet published
				</div>
			</div>
		</div>
		<div class="analytics-grid">
			<div class="analytics-card">
				<h2>Applications by Vacancy</h2>
				<p class="card-description">
					Number of applicants received for each vacancy.
				</p>
				<?php if (!empty($jobs)): ?>
					<?php foreach ($jobs as $job): ?>
						<?php
						$applicantCount = (int)(
							$job['applicant_count'] ?? 0
						);
						$barWidth = 0;
						if ($maxApplicants > 0) {
							$barWidth = (
								$applicantCount /
								$maxApplicants
							) * 100;
						}
						?>
						<div class="application-row">
							<div class="application-info">
								<span>
									<?php
									echo htmlspecialchars(
										$job['title'] ?? 'Untitled Job'
									);
									?>
								</span>
								<span class="application-count">
									<?php echo $applicantCount; ?>
									<?php
									echo
										$applicantCount === 1
											? 'Applicant'
											: 'Applicants';
									?>
								</span>
							</div>
							<div class="progress-track">
								<div
									class="progress-fill"
									style="width:<?php echo round($barWidth, 1); ?>%;"
								></div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="empty-message">
						No vacancy information available.
					</div>
				<?php endif; ?>
			</div>
			<div class="analytics-card">
				<h2>Application Status</h2>
				<p class="card-description">
					Current progress of candidate applications.
				</p>
				<div class="status-row">
					<div class="status-info">
						<span class="status-name">
							Pending Review
						</span>
						<span class="status-number">
							<?php echo $pendingApplications; ?>
						</span>
					</div>
					<div class="progress-track">
						<div
							class="progress-fill status-pending-fill"
							style="width:<?php echo round($pendingWidth, 1); ?>%;"
						></div>
					</div>
				</div>
				<div class="status-row">
					<div class="status-info">
						<span class="status-name">
							Shortlisted
						</span>
						<span class="status-number">
							<?php echo $shortlistedApplications; ?>
						</span>
					</div>
					<div class="progress-track">
						<div
							class="progress-fill status-shortlisted-fill"
							style="width:<?php echo round($shortlistedWidth, 1); ?>%;"
						></div>
					</div>
				</div>
				<div class="status-row">
					<div class="status-info">
						<span class="status-name">
							Interview Scheduled
						</span>
						<span class="status-number">
							<?php echo $interviewApplications; ?>
						</span>
					</div>
					<div class="progress-track">
						<div
							class="progress-fill status-interview-fill"
							style="width:<?php echo round($interviewWidth, 1); ?>%;"
						></div>
					</div>
				</div>
				<div class="status-row">
					<div class="status-info">
						<span class="status-name">
							Rejected
						</span>
						<span class="status-number">
							<?php echo $rejectedApplications; ?>
						</span>
					</div>
					<div class="progress-track">
						<div
							class="progress-fill status-rejected-fill"
							style="width:<?php echo round($rejectedWidth, 1); ?>%;"
						></div>
					</div>
				</div>
			</div>
		</div>
		<div
			class="analytics-card"
			style="margin-bottom:25px;"
		>
			<h2>Vacancy Status Distribution</h2>
			<p class="card-description">
				Current status of your job vacancies.
			</p>
			<div class="status-row">
				<div class="status-info">
					<span class="status-name">
						Active
					</span>
					<span class="status-number">
						<?php echo $activeCount; ?>
					</span>
				</div>
				<div class="progress-track">
					<div
						class="progress-fill status-active-fill"
						style="width:<?php echo round($activeWidth, 1); ?>%;"
					></div>
				</div>
			</div>
			<div class="status-row">
				<div class="status-info">
					<span class="status-name">
						Upcoming
					</span>
					<span class="status-number">
						<?php echo $upcomingCount; ?>
					</span>
				</div>
				<div class="progress-track">
					<div
						class="progress-fill status-upcoming-fill"
						style="width:<?php echo round($upcomingWidth, 1); ?>%;"
					></div>
				</div>
			</div>
			<div class="status-row">
				<div class="status-info">
					<span class="status-name">
						Draft
					</span>
					<span class="status-number">
						<?php echo $draftCount; ?>
					</span>
				</div>
				<div class="progress-track">
					<div
						class="progress-fill status-draft-fill"
						style="width:<?php echo round($draftWidth, 1); ?>%;"
					></div>
				</div>
			</div>
			<div class="status-row">
				<div class="status-info">
					<span class="status-name">
						Closed
					</span>
					<span class="status-number">
						<?php echo $closedCount; ?>
					</span>
				</div>
				<div class="progress-track">
					<div
						class="progress-fill status-closed-fill"
						style="width:<?php echo round($closedWidth, 1); ?>%;"
					></div>
				</div>
			</div>
		</div>
		<div class="performance-card">
			<div class="performance-header">
				<div>
					<h2>Vacancy Performance</h2>
					<p>
						Applicant activity for each job vacancy.
					</p>
				</div>
				<a
					href="index.php?action=manage_jobs"
					class="btn btn-secondary"
				>
					View All Vacancies
				</a>
			</div>
			<?php if (!empty($jobs)): ?>
				<div class="table-wrapper">
					<table class="performance-table">
						<thead>
							<tr>
								<th>Vacant Role</th>
								<th>Type</th>
								<th>Location</th>
								<th>Applicants</th>
								<th>Opening Date</th>
								<th>Closing Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($jobs as $job): ?>
							<?php
							$displayStatus = getAnalyticsJobStatus(
								$job,
								$today
							);
							$badgeClass = strtolower(
								$displayStatus
							);
							?>
							<tr>
								<td>
									<span class="job-title">
										<?php
										echo htmlspecialchars(
											$job['title'] ?? ''
										);
										?>
									</span>
								</td>
								<td>
									<?php
									echo htmlspecialchars(
										$job['job_type'] ?? '-'
									);
									?>
								</td>
								<td>
									<?php
									echo htmlspecialchars(
										$job['location'] ?? '-'
									);
									?>
								</td>
								<td>
									<span class="applicant-number">
										<?php
										echo (int)(
											$job['applicant_count'] ?? 0
										);
										?>
									</span>
								</td>
								<td>
									<?php
									echo formatAnalyticsDate(
										$job['opening_date'] ?? ''
									);
									?>
								</td>
								<td>
									<?php
									echo formatAnalyticsDate(
										$job['closing_date'] ?? ''
									);
									?>
								</td>
								<td>
									<span
										class="status-badge badge-<?php echo htmlspecialchars($badgeClass); ?>"
									>
										<?php
										echo htmlspecialchars(
											$displayStatus
										);
										?>
									</span>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="empty-message">
					No job vacancies are available.
				</div>
			<?php endif; ?>
		</div>
	</div>
</main>
<script>
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