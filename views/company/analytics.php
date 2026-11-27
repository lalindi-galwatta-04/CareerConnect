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
			flex-wrap: wrap;
		}
		.report-primary-btn { display:inline-flex; align-items:center; gap:8px; }
		.report-modal-backdrop { position:fixed; inset:0; z-index:10000; display:none; align-items:center; justify-content:center; padding:20px; background:rgba(15,23,42,.58); }
		.report-modal-backdrop.is-open { display:flex; }
		.report-modal { width:min(900px,100%); max-height:calc(100vh - 40px); overflow:auto; background:#fff; border-radius:16px; box-shadow:0 24px 80px rgba(0,0,0,.25); }
		.report-modal-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; padding:22px 24px; border-bottom:1px solid #e5e7eb; }
		.report-modal-header h2 { margin:0 0 5px; font-size:20px; color:#0f172a; }
		.report-modal-header p { margin:0; color:#64748b; font-size:13px; line-height:1.5; }
		.report-close-btn { border:0; background:#f3f4f6; color:#374151; border-radius:8px; width:36px; height:36px; font-size:22px; cursor:pointer; flex:0 0 36px; }
		.report-modal-body { padding:22px 24px; }
		.report-builder-grid { display:grid; grid-template-columns:minmax(0, .85fr) minmax(0, 1.15fr); gap:22px; }
		.report-builder-panel { border:1px solid #e5e7eb; border-radius:12px; padding:17px; min-width:0; }
		.report-builder-panel h3 { margin:0 0 15px; font-size:15px; color:#111827; }
		.report-field { margin-bottom:15px; }
		.report-field label, .report-section-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:7px; }
		.report-field select, .report-field input { width:100%; min-height:40px; box-sizing:border-box; border:1px solid #d1d5db; border-radius:8px; padding:9px 10px; background:#fff; color:#111827; font:inherit; font-size:13px; }
		.report-checks { display:grid; gap:11px; }
		.report-check { display:flex; align-items:flex-start; gap:9px; font-size:13px; color:#374151; line-height:1.45; }
		.report-check input { margin-top:2px; accent-color:#4f46e5; }
		.report-note { color:#64748b; font-size:12px; line-height:1.5; margin:10px 0 0; }
		.report-preview { border:1px solid #e5e7eb; border-radius:12px; padding:17px; background:#f9fafb; min-height:210px; }
		.report-preview h3 { margin:0 0 5px; font-size:16px; color:#111827; }
		.report-preview-meta { margin:0 0 15px; font-size:12px; color:#64748b; }
		.report-preview-stats { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:9px; margin-bottom:14px; }
		.report-preview-stat { background:#fff; border:1px solid #e5e7eb; border-radius:9px; padding:11px; }
		.report-preview-stat span { display:block; color:#64748b; font-size:11px; margin-bottom:5px; }
		.report-preview-stat strong { font-size:20px; color:#111827; }
		.report-preview-table-wrap { overflow:auto; max-width:100%; }
		.report-preview table { border-collapse:collapse; width:100%; background:#fff; font-size:12px; }
		.report-preview th, .report-preview td { border:1px solid #e5e7eb; padding:8px; text-align:left; }
		.report-preview th { background:#f3f4f6; }
		.report-modal-footer { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; padding:16px 24px 22px; border-top:1px solid #e5e7eb; }
		.report-footer-actions { display:flex; gap:9px; flex-wrap:wrap; }
		.report-error { display:none; color:#b91c1c; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:10px 12px; margin-bottom:12px; font-size:13px; }
		.report-error.is-visible { display:block; }
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
			overflow: visible;
		}
		.performance-filters {
			display: grid;
			grid-template-columns: minmax(220px, 2fr) minmax(160px, 1fr) minmax(170px, 1fr) auto;
			gap: 12px;
			align-items: end;
			margin-bottom: 18px;
		}
		.performance-filters .form-group { margin: 0; min-width: 0; }
		.performance-filters label {
			display: block; margin-bottom: 6px; font-size: 12px;
			font-weight: 600; color: #475569;
		}
		.performance-filters input,
		.performance-filters select {
			width: 100%; min-width: 0; box-sizing: border-box;
			padding: 10px 11px; border: 1px solid #cbd5e1;
			border-radius: 6px; background: #fff; font: inherit; font-size: 13px;
		}
		.performance-filter-summary {
			font-size: 12px; color: #64748b; margin: -4px 0 12px;
		}
		.clear-performance-filters {
			padding: 10px 12px; border: 1px solid #cbd5e1;
			border-radius: 6px; background: #fff; cursor: pointer;
			font-size: 12px; white-space: nowrap;
		}
		.performance-table {
			width: 100%;
			border-collapse: collapse;
			text-align: left;
			font-size: 12px;
			table-layout: fixed;
		}
		.performance-table th,
		.performance-table td { overflow-wrap: anywhere; }
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
			.performance-filters { grid-template-columns: repeat(2, minmax(0, 1fr)); }
			.metrics-grid {
				grid-template-columns: repeat(2, minmax(0, 1fr));
			}
			.analytics-grid {
				grid-template-columns: 1fr;
			}
		}
		@media (max-width: 768px) {
			.performance-table, .performance-table tbody, .performance-table tr,
			.performance-table td { display: block; width: 100%; box-sizing: border-box; }
			.performance-table thead { display: none; }
			.performance-table tbody tr {
				border: 1px solid #e2e8f0; border-radius: 8px;
				padding: 8px 12px; margin-bottom: 12px; background: #fff;
			}
			.performance-table td {
				display: grid; grid-template-columns: minmax(105px, 38%) minmax(0, 1fr);
				gap: 10px; padding: 9px 0; border-bottom: 1px solid #eef2f7;
				text-align: left !important;
			}
			.performance-table td:last-child { border-bottom: none; }
			.performance-table td::before {
				content: attr(data-label); color: #64748b; font-size: 10px;
				font-weight: 700; text-transform: uppercase; letter-spacing: .3px;
			}
			.performance-filters { grid-template-columns: 1fr; }
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
				<button type="button" class="btn report-primary-btn" id="openReportBuilder">&#128196; Generate Report</button>
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
				<div class="performance-filters">
					<div class="form-group">
						<label for="vacancySearch">Search vacancies</label>
						<input type="search" id="vacancySearch" placeholder="Search role or location...">
					</div>
					<div class="form-group">
						<label for="vacancyStatusFilter">Vacancy status</label>
						<select id="vacancyStatusFilter">
							<option value="">All statuses</option>
							<option value="Active">Active</option>
							<option value="Upcoming">Upcoming</option>
							<option value="Draft">Draft</option>
							<option value="Closed">Closed</option>
						</select>
					</div>
					<div class="form-group">
						<label for="vacancySort">Sort by</label>
						<select id="vacancySort">
							<option value="default">Default order</option>
							<option value="applicants-desc">Most applicants</option>
							<option value="applicants-asc">Fewest applicants</option>
							<option value="title-asc">Role A–Z</option>
							<option value="title-desc">Role Z–A</option>
						</select>
					</div>
					<button type="button" class="clear-performance-filters" id="clearPerformanceFilters">Clear filters</button>
				</div>
				<div class="performance-filter-summary" id="performanceFilterSummary">Showing all vacancies</div>
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
							$badgeClass = strtolower($displayStatus);
							$jobApplicantCount = (int)($job['applicant_count'] ?? 0);
							$jobTitleText = $job['title'] ?? '';
							$jobLocationText = $job['location'] ?? '';
							?>
							<tr class="performance-row"
								data-title="<?php echo htmlspecialchars($jobTitleText, ENT_QUOTES, 'UTF-8'); ?>"
								data-location="<?php echo htmlspecialchars($jobLocationText, ENT_QUOTES, 'UTF-8'); ?>"
								data-status="<?php echo htmlspecialchars($displayStatus, ENT_QUOTES, 'UTF-8'); ?>"
								data-applicants="<?php echo $jobApplicantCount; ?>"
								data-original-index="<?php echo (int)array_search($job, $jobs, true); ?>">
								<td data-label="Vacant Role">
									<span class="job-title">
										<?php
										echo htmlspecialchars(
											$job['title'] ?? ''
										);
										?>
									</span>
								</td>
								<td data-label="Type">
									<?php
									echo htmlspecialchars(
										$job['job_type'] ?? '-'
									);
									?>
								</td>
								<td data-label="Location">
									<?php
									echo htmlspecialchars(
										$job['location'] ?? '-'
									);
									?>
								</td>
								<td data-label="Applicants">
									<span class="applicant-number">
										<?php
										echo (int)(
											$jobApplicantCount
										);
										?>
									</span>
								</td>
								<td data-label="Opening Date">
									<?php
									echo formatAnalyticsDate(
										$job['opening_date'] ?? ''
									);
									?>
								</td>
								<td data-label="Closing Date">
									<?php
									echo formatAnalyticsDate(
										$job['closing_date'] ?? ''
									);
									?>
								</td>
								<td data-label="Status">
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
				<div class="empty-message" id="noVacancyMatches" style="display:none;">
					No vacancies match your filters. Try changing or clearing the filters.
				</div>
			<?php else: ?>
				<div class="empty-message">
					No job vacancies are available.
				</div>
			<?php endif; ?>
		</div>
	</div>
</main>

<div class="report-modal-backdrop" id="reportModalBackdrop" aria-hidden="true">
	<section class="report-modal" role="dialog" aria-modal="true" aria-labelledby="reportModalTitle">
		<div class="report-modal-header">
			<div>
				<h2 id="reportModalTitle">Generate Recruitment Report</h2>
				<p>Choose a reporting period and the information to include, then preview and download your report.</p>
			</div>
			<button type="button" class="report-close-btn" id="closeReportBuilder" aria-label="Close report builder">&times;</button>
		</div>
		<div class="report-modal-body">
			<div class="report-error" id="reportError" role="alert"></div>
			<div class="report-builder-grid">
				<div class="report-builder-panel">
					<h3>Report settings</h3>
					<div class="report-field">
						<label for="reportPeriod">Reporting period</label>
						<select id="reportPeriod">
							<option value="all">All available vacancy data</option>
							<option value="month">This month (vacancies opening this month)</option>
							<option value="week">This week (vacancies opening this week)</option>
							<option value="custom">Custom opening-date range</option>
						</select>
					</div>
					<div id="customReportDates" style="display:none;">
						<div class="report-field"><label for="reportStartDate">Start date</label><input type="date" id="reportStartDate"></div>
						<div class="report-field"><label for="reportEndDate">End date</label><input type="date" id="reportEndDate"></div>
					</div>
					<div class="report-field">
						<label for="reportFormat">Download format</label>
						<select id="reportFormat"><option value="pdf">PDF (print/save as PDF)</option><option value="csv">CSV spreadsheet</option></select>
					</div>
					<span class="report-section-label">Include sections</span>
					<div class="report-checks">
						<label class="report-check"><input type="checkbox" name="reportSection" value="overview" checked> <span>Recruitment overview and summary metrics</span></label>
						<label class="report-check"><input type="checkbox" name="reportSection" value="applications" checked> <span>Application status breakdown</span></label>
						<label class="report-check"><input type="checkbox" name="reportSection" value="vacancies" checked> <span>Vacancy performance details</span></label>
						<label class="report-check"><input type="checkbox" name="reportSection" value="dates" checked> <span>Vacancy opening and closing dates</span></label>
					</div>
					<p class="report-note">Date ranges filter vacancies by their opening date. Applicant totals shown in the overview are the current Analytics totals because application-date records are not available in this page's data.</p>
				</div>
				<div>
					<div class="report-preview" id="reportPreview" aria-live="polite">
						<h3>Report preview</h3>
						<p class="report-preview-meta">Choose your settings, then select “Create report preview”.</p>
						<p class="report-note">The preview will use the vacancy and analytics data currently available on this page.</p>
					</div>
					<div style="display:flex;justify-content:flex-end;margin-top:12px;">
						<button type="button" class="btn" id="createReportPreview">Create report preview</button>
					</div>
				</div>
			</div>
		</div>
		<div class="report-modal-footer">
			<span class="report-note">Reports are generated from the current page data.</span>
			<div class="report-footer-actions">
				<button type="button" class="btn btn-secondary" id="cancelReportBuilder">Cancel</button>
				<button type="button" class="btn" id="downloadReport" disabled>Download report</button>
			</div>
		</div>
	</section>
</div>

<script>
// Vacancy performance filters and sorting (display-only; no backend changes)
(function () {
	const search = document.getElementById('vacancySearch');
	const statusFilter = document.getElementById('vacancyStatusFilter');
	const sortSelect = document.getElementById('vacancySort');
	const clearButton = document.getElementById('clearPerformanceFilters');
	const summary = document.getElementById('performanceFilterSummary');
	const noMatches = document.getElementById('noVacancyMatches');
	const tbody = document.querySelector('.performance-table tbody');
	if (!search || !statusFilter || !sortSelect || !tbody) return;

	const rows = Array.from(tbody.querySelectorAll('.performance-row'));
	function applyVacancyFilters() {
		const query = search.value.toLowerCase().trim();
		const status = statusFilter.value.toLowerCase();
		let visible = rows.filter(function (row) {
			const title = (row.dataset.title || '').toLowerCase();
			const location = (row.dataset.location || '').toLowerCase();
			const rowStatus = (row.dataset.status || '').toLowerCase();
			const matchesSearch = !query || title.includes(query) || location.includes(query);
			const matchesStatus = !status || rowStatus === status;
			return matchesSearch && matchesStatus;
		});

		const sort = sortSelect.value;
		visible.sort(function (a, b) {
			if (sort === 'applicants-desc') return Number(b.dataset.applicants) - Number(a.dataset.applicants);
			if (sort === 'applicants-asc') return Number(a.dataset.applicants) - Number(b.dataset.applicants);
			if (sort === 'title-asc') return (a.dataset.title || '').localeCompare(b.dataset.title || '');
			if (sort === 'title-desc') return (b.dataset.title || '').localeCompare(a.dataset.title || '');
			return Number(a.dataset.originalIndex) - Number(b.dataset.originalIndex);
		});

		rows.forEach(function (row) { row.style.display = 'none'; });
		visible.forEach(function (row) {
			row.style.display = '';
			tbody.appendChild(row);
		});
		if (summary) summary.textContent = 'Showing ' + visible.length + ' of ' + rows.length + ' vacancy/vacancies';
		if (noMatches) noMatches.style.display = visible.length ? 'none' : 'block';
	}
	search.addEventListener('input', applyVacancyFilters);
	statusFilter.addEventListener('change', applyVacancyFilters);
	sortSelect.addEventListener('change', applyVacancyFilters);
	clearButton.addEventListener('click', function () {
		search.value = '';
		statusFilter.value = '';
		sortSelect.value = 'default';
		applyVacancyFilters();
	});
	applyVacancyFilters();
})();

// Report builder modal, preview, CSV export and print-to-PDF
(function () {
	const backdrop = document.getElementById('reportModalBackdrop');
	const openButton = document.getElementById('openReportBuilder');
	const closeButton = document.getElementById('closeReportBuilder');
	const cancelButton = document.getElementById('cancelReportBuilder');
	const periodSelect = document.getElementById('reportPeriod');
	const customDates = document.getElementById('customReportDates');
	const startInput = document.getElementById('reportStartDate');
	const endInput = document.getElementById('reportEndDate');
	const formatSelect = document.getElementById('reportFormat');
	const previewButton = document.getElementById('createReportPreview');
	const downloadButton = document.getElementById('downloadReport');
	const preview = document.getElementById('reportPreview');
	const errorBox = document.getElementById('reportError');
	if (!backdrop || !openButton) return;

	let currentReport = null;
	const metricCards = Array.from(document.querySelectorAll('.metrics-grid .metric-card'));
	function metricValue(label) {
		const card = metricCards.find(el => (el.querySelector('.metric-title')?.textContent || '').trim().toLowerCase() === label.toLowerCase());
		return card ? (card.querySelector('.metric-value')?.textContent || '0').trim() : '0';
	}
	function openModal() {
		backdrop.classList.add('is-open');
		backdrop.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
		closeButton.focus();
	}
	function closeModal() {
		backdrop.classList.remove('is-open');
		backdrop.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		openButton.focus();
	}
	function showError(message) {
		errorBox.textContent = message;
		errorBox.classList.add('is-visible');
	}
	function clearError() {
		errorBox.textContent = '';
		errorBox.classList.remove('is-visible');
	}
	function esc(value) {
		return String(value ?? '').replace(/[&<>"']/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[ch]));
	}
	function getSelectedSections() {
		return Array.from(document.querySelectorAll('input[name="reportSection"]:checked')).map(el => el.value);
	}
	function dateInRange(date, start, end) {
		if (!date) return false;
		return (!start || date >= start) && (!end || date <= end);
	}
	function getRange() {
		const period = periodSelect.value;
		const now = new Date();
		const yyyy = now.getFullYear();
		const mm = String(now.getMonth() + 1).padStart(2, '0');
		const dd = String(now.getDate()).padStart(2, '0');
		const today = `${yyyy}-${mm}-${dd}`;
		if (period === 'all') return {label:'All available vacancy data', start:'', end:''};
		if (period === 'month') return {label:'This month (opening date)', start:`${yyyy}-${mm}-01`, end:today};
		if (period === 'week') {
			const day = now.getDay();
			const monday = new Date(now);
			monday.setDate(now.getDate() + (day === 0 ? -6 : 1 - day));
			const start = `${monday.getFullYear()}-${String(monday.getMonth()+1).padStart(2,'0')}-${String(monday.getDate()).padStart(2,'0')}`;
			return {label:'This week (opening date)', start, end:today};
		}
		return {label:'Custom opening-date range', start:startInput.value, end:endInput.value};
	}
	function getRows(range) {
		return Array.from(document.querySelectorAll('.performance-table tbody .performance-row')).filter(row => {
			if (periodSelect.value === 'all') return true;
			return dateInRange(row.dataset.openingDate || '', range.start, range.end);
		}).map(row => {
			const cells = row.querySelectorAll('td');
			return {
				title: row.dataset.title || cells[0]?.innerText.trim() || '',
				type: cells[1]?.innerText.trim() || '-',
				location: row.dataset.location || cells[2]?.innerText.trim() || '-',
				applicants: Number(row.dataset.applicants || 0),
				openingDate: row.dataset.openingDate || '',
				closingDate: row.dataset.closingDate || '',
				status: row.dataset.status || cells[6]?.innerText.trim() || ''
			};
		});
	}
	function buildReport() {
		clearError();
		const range = getRange();
		if (periodSelect.value === 'custom') {
			if (!range.start || !range.end) { showError('Please select both a start date and an end date.'); return; }
			if (range.start > range.end) { showError('The start date must be on or before the end date.'); return; }
		}
		const sections = getSelectedSections();
		if (!sections.length) { showError('Select at least one report section.'); return; }
		const rows = getRows(range);
		const statusRows = Array.from(document.querySelectorAll('.analytics-card')).flatMap(card => Array.from(card.querySelectorAll('.status-row')).map(row => ({
			status: row.querySelector('.status-name')?.textContent.trim() || '',
			count: row.querySelector('.status-number')?.textContent.trim() || '0'
		})));
		currentReport = {
			title: 'CareerConnect Recruitment Analytics Report',
			generatedAt: new Date().toLocaleString(),
			range,
			sections,
			rows,
			metrics: {
				applicants: metricValue('Total Applicants'),
				active: metricValue('Active Vacancies'),
				upcoming: metricValue('Upcoming Vacancies'),
				draft: metricValue('Draft Vacancies')
			},
			statuses: statusRows
		};
		renderPreview(currentReport);
		downloadButton.disabled = false;
	}
	function renderPreview(report) {
		let html = `<h3>${esc(report.title)}</h3><p class="report-preview-meta">${esc(report.range.label)} · Generated ${esc(report.generatedAt)} · ${report.rows.length} vacancy/vacancies included</p>`;
		if (report.sections.includes('overview')) {
			html += '<div class="report-preview-stats">' + [
				['Total Applicants',report.metrics.applicants],['Active Vacancies',report.metrics.active],['Upcoming Vacancies',report.metrics.upcoming],['Draft Vacancies',report.metrics.draft]
			].map(item => `<div class="report-preview-stat"><span>${esc(item[0])}</span><strong>${esc(item[1])}</strong></div>`).join('') + '</div>';
		}
		if (report.sections.includes('applications')) {
			html += '<h4>Application status breakdown</h4><div class="report-preview-table-wrap"><table><thead><tr><th>Status</th><th>Applications</th></tr></thead><tbody>';
			html += report.statuses.map(item => `<tr><td>${esc(item.status)}</td><td>${esc(item.count)}</td></tr>`).join('');
			html += '</tbody></table></div><br>';
		}
		if (report.sections.includes('vacancies')) {
			html += '<h4>Vacancy performance</h4><div class="report-preview-table-wrap"><table><thead><tr><th>Role</th><th>Type</th><th>Location</th><th>Applicants</th><th>Status</th>' + (report.sections.includes('dates') ? '<th>Opening</th><th>Closing</th>' : '') + '</tr></thead><tbody>';
			if (report.rows.length) {
				html += report.rows.map(row => `<tr><td>${esc(row.title)}</td><td>${esc(row.type)}</td><td>${esc(row.location)}</td><td>${esc(row.applicants)}</td><td>${esc(row.status)}</td>${report.sections.includes('dates') ? `<td>${esc(row.openingDate || '-')}</td><td>${esc(row.closingDate || '-')}</td>` : ''}</tr>`).join('');
			} else {
				html += `<tr><td colspan="${report.sections.includes('dates') ? 7 : 5}">No vacancies match this reporting period.</td></tr>`;
			}
			html += '</tbody></table></div>';
		}
		preview.innerHTML = html;
	}
	function csvCell(value) { return '"' + String(value ?? '').replace(/"/g, '""') + '"'; }
	function downloadCsv(report) {
		const lines = [[report.title],['Reporting period',report.range.label],['Generated',report.generatedAt],[]];
		if (report.sections.includes('overview')) {
			lines.push(['Recruitment Overview'],['Total Applicants',report.metrics.applicants],['Active Vacancies',report.metrics.active],['Upcoming Vacancies',report.metrics.upcoming],['Draft Vacancies',report.metrics.draft],[]);
		}
		if (report.sections.includes('applications')) {
			lines.push(['Application Status Breakdown'],['Status','Applications']);
			report.statuses.forEach(item => lines.push([item.status,item.count]));
			lines.push([]);
		}
		if (report.sections.includes('vacancies')) {
			const header = ['Role','Type','Location','Applicants','Status'];
			if (report.sections.includes('dates')) header.push('Opening Date','Closing Date');
			lines.push(['Vacancy Performance'],header);
			report.rows.forEach(row => {
				const values = [row.title,row.type,row.location,row.applicants,row.status];
				if (report.sections.includes('dates')) values.push(row.openingDate,row.closingDate);
				lines.push(values);
			});
		}
		const csv = '\ufeff' + lines.map(line => line.map(csvCell).join(',')).join('\r\n');
		const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
		const url = URL.createObjectURL(blob);
		const link = document.createElement('a');
		link.href = url;
		link.download = 'careerconnect-analytics-report.csv';
		document.body.appendChild(link); link.click(); link.remove(); URL.revokeObjectURL(url);
	}
	function downloadPdf(report) {
		const reportWindow = window.open('', '_blank');
		if (!reportWindow) { showError('Your browser blocked the report window. Allow pop-ups for this site and try again.'); return; }
		const sectionsHtml = preview.innerHTML;
		reportWindow.document.open();
		reportWindow.document.write(`<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>${esc(report.title)}</title><style>body{font:13px Arial,sans-serif;color:#111827;margin:28px}h1{font-size:23px;margin-bottom:6px}h3{margin-top:20px}p{color:#4b5563}table{border-collapse:collapse;width:100%;font-size:11px;margin:10px 0 18px}th,td{border:1px solid #d1d5db;padding:7px;text-align:left;overflow-wrap:anywhere}th{background:#f3f4f6}.report-preview-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}.report-preview-stat{border:1px solid #ddd;border-radius:6px;padding:10px}.report-preview-stat span{display:block;font-size:11px;color:#555}.report-preview-stat strong{display:block;font-size:18px;margin-top:5px}.report-preview-meta{font-size:11px;color:#555}@media print{body{margin:12mm}.report-preview-table-wrap{overflow:visible}}</style></head><body><h1>${esc(report.title)}</h1>${sectionsHtml}<script>window.onload=function(){window.print();};<\/script></body></html>`);
		reportWindow.document.close();
	}
	openButton.addEventListener('click', openModal);
	closeButton.addEventListener('click', closeModal);
	cancelButton.addEventListener('click', closeModal);
	backdrop.addEventListener('click', event => { if (event.target === backdrop) closeModal(); });
	document.addEventListener('keydown', event => { if (event.key === 'Escape' && backdrop.classList.contains('is-open')) closeModal(); });
	periodSelect.addEventListener('change', () => {
		customDates.style.display = periodSelect.value === 'custom' ? 'block' : 'none';
		currentReport = null; downloadButton.disabled = true; clearError();
	});
	[startInput, endInput].forEach(input => input.addEventListener('change', () => { currentReport = null; downloadButton.disabled = true; clearError(); }));
	document.querySelectorAll('input[name="reportSection"]').forEach(input => input.addEventListener('change', () => { currentReport = null; downloadButton.disabled = true; clearError(); }));
	formatSelect.addEventListener('change', () => { downloadButton.textContent = formatSelect.value === 'csv' ? 'Download CSV' : 'Download PDF'; });
	previewButton.addEventListener('click', buildReport);
	downloadButton.addEventListener('click', () => {
		if (!currentReport) { showError('Create a report preview before downloading.'); return; }
		if (formatSelect.value === 'csv') downloadCsv(currentReport); else downloadPdf(currentReport);
	});
	downloadButton.textContent = 'Download PDF';
})();

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