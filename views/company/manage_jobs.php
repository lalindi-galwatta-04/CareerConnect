<?php
$companyName = $company['company_name'] ?? 'Company Account';
$today = date('Y-m-d');
// Collect actual job types
$jobTypes = [];
if (!empty($jobs)) {
	foreach ($jobs as $job) {
		$type = trim($job['job_type'] ?? '');
		if (
			$type !== '' &&
			!in_array($type, $jobTypes, true)
		) {
			$jobTypes[] = $type;
		}
	}
	sort($jobTypes);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>
	<title>Manage Jobs - CareerConnect</title>
	<link
		rel="stylesheet"
		href="public/css/style.css?v=5.0"
	>
	<style>
		.job-filters {
			display: grid;
			grid-template-columns: repeat(4, minmax(0, 1fr));
			gap: 12px;
			align-items: end;
		}
		.job-filters .form-group { margin-bottom: 0; min-width: 0; }
		.job-search-group { grid-column: span 2; }
		.job-filters input, .job-filters select { width: 100%; min-width: 0; box-sizing: border-box; }
		.filter-toolbar { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-top:14px; }
		.filter-results { color: var(--text-muted); font-size: 13px; }
		.clear-filters { border:0; background:transparent; color:#1457a6; font-weight:600; cursor:pointer; padding:6px 0; }
		.jobs-table-wrapper { width:100%; overflow:visible; }
		.jobs-table { width:100%; table-layout:fixed; border-collapse:collapse; }
		.jobs-table th, .jobs-table td { padding:11px 8px; vertical-align:middle; overflow-wrap:anywhere; white-space:normal; font-size:13px; }
		.jobs-table th { font-size:12px; }
		.jobs-table th:nth-child(1) { width:17%; }
		.jobs-table th:nth-child(2) { width:10%; }
		.jobs-table th:nth-child(3) { width:13%; }
		.jobs-table th:nth-child(4), .jobs-table th:nth-child(5) { width:10%; }
		.jobs-table th:nth-child(6) { width:7%; }
		.jobs-table th:nth-child(7) { width:9%; }
		.jobs-table th:nth-child(8) { width:24%; }
		.job-actions { display:flex; align-items:center; flex-wrap:wrap; gap:5px; min-width:0; }
		.job-actions .btn, .job-actions .btn-reopen { display:inline-flex; align-items:center; justify-content:center; padding:6px 8px; min-height:30px; font-size:11px; line-height:1.2; border-radius:6px; white-space:normal; text-align:center; text-decoration:none; }
		.btn-reopen { border:1px solid #b7d5ff; background:#edf5ff; color:#084da8; font-weight:600; }
		.btn-reopen:hover { background:#dceaff; }
		.btn-repost { display:inline-flex; align-items:center; justify-content:center; padding:7px 9px; border:1px solid #b9a4f5; border-radius:7px; background:#f3efff; color:#5632a8; font-size:12px; font-weight:700; cursor:pointer; }
		.repost-modal { display:none; position:fixed; inset:0; z-index:9999; background:rgba(15,23,42,.58); padding:20px; align-items:center; justify-content:center; }
		.repost-modal.open { display:flex; }
		.repost-dialog { width:min(100%, 480px); background:#fff; border-radius:14px; padding:24px; box-shadow:0 20px 60px rgba(0,0,0,.25); }
		.repost-dialog h2 { margin:0 0 8px; font-size:22px; color:#172033; }
		.repost-dialog p { color:#64748b; margin:0 0 18px; font-size:14px; }
		.repost-fields { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
		.repost-fields label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#334155; }
		.repost-fields input { width:100%; box-sizing:border-box; padding:10px; border:1px solid #cbd5e1; border-radius:7px; }
		.repost-readonly { padding:10px; min-height:18px; border:1px solid #e2e8f0; border-radius:7px; background:#f8fafc; color:#334155; font-size:13px; }
		.repost-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:22px; flex-wrap:wrap; }
		.repost-cancel { border:1px solid #cbd5e1; background:#fff; color:#334155; border-radius:7px; padding:9px 14px; cursor:pointer; }
		.repost-confirm { border:0; background:#5632a8; color:#fff; border-radius:7px; padding:10px 15px; font-weight:700; cursor:pointer; }
		.repost-notice { display:none; margin:12px 0 0; padding:11px 13px; border-radius:8px; background:#ecfdf3; color:#166534; font-size:13px; }
		@media(max-width:520px){ .repost-fields{grid-template-columns:1fr;} .repost-dialog{padding:19px;} }
		.no-filter-results {
			display: none;
			text-align: center;
			padding: 40px 20px;
		}
		.no-filter-results h3 {
			margin-bottom: 8px;
		}
		.no-filter-results p {
			color: var(--text-muted);
			margin-bottom: 0;
		}
		.pagination-area {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 15px;
			margin-top: 20px;
			flex-wrap: wrap;
		}
		.pagination-info {
			font-size: 14px;
			color: var(--text-muted);
		}
		.pagination-controls {
			display: flex;
			align-items: center;
			gap: 8px;
			flex-wrap: wrap;
		}
		.pagination-btn {
			min-width: 38px;
			padding: 8px 12px;
			border: 1px solid #d1d5db;
			background: #ffffff;
			border-radius: 6px;
			cursor: pointer;
			font-size: 13px;
		}
		.pagination-btn:hover:not(:disabled) {
			background: #f3f4f6;
		}
		.pagination-btn.active {
			background: #111827;
			color: #ffffff;
			border-color: #111827;
		}
		.pagination-btn:disabled {
			opacity: 0.45;
			cursor: not-allowed;
		}
		.status-badge { display:inline-flex; align-items:center; padding:5px 10px; border-radius:999px; font-size:12px; font-weight:700; line-height:1.4; white-space:nowrap; }
		.status-draft { background:#f1f5f9; color:#475569; }
		.status-upcoming { background:#fff4d6; color:#8a6300; }
		.status-active { background:#e6f4ea; color:#137333; }
		.status-closed { background:#fce8e6; color:#c5221f; }
		.job-actions { display:flex; align-items:center; flex-wrap:wrap; gap:8px; min-width:230px; }
		.btn-reopen { display:inline-flex; align-items:center; justify-content:center; padding:8px 12px; border:1px solid #b7d5ff; border-radius:7px; background:#edf5ff; color:#084da8; font-size:13px; font-weight:600; text-decoration:none; white-space:nowrap; }
		.btn-reopen:hover { background:#dceaff; }
		.btn-repost { display:inline-flex; align-items:center; justify-content:center; padding:7px 9px; border:1px solid #b9a4f5; border-radius:7px; background:#f3efff; color:#5632a8; font-size:12px; font-weight:700; cursor:pointer; }
		.repost-modal { display:none; position:fixed; inset:0; z-index:9999; background:rgba(15,23,42,.58); padding:20px; align-items:center; justify-content:center; }
		.repost-modal.open { display:flex; }
		.repost-dialog { width:min(100%, 480px); background:#fff; border-radius:14px; padding:24px; box-shadow:0 20px 60px rgba(0,0,0,.25); }
		.repost-dialog h2 { margin:0 0 8px; font-size:22px; color:#172033; }
		.repost-dialog p { color:#64748b; margin:0 0 18px; font-size:14px; }
		.repost-fields { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
		.repost-fields label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#334155; }
		.repost-fields input { width:100%; box-sizing:border-box; padding:10px; border:1px solid #cbd5e1; border-radius:7px; }
		.repost-readonly { padding:10px; min-height:18px; border:1px solid #e2e8f0; border-radius:7px; background:#f8fafc; color:#334155; font-size:13px; }
		.repost-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:22px; flex-wrap:wrap; }
		.repost-cancel { border:1px solid #cbd5e1; background:#fff; color:#334155; border-radius:7px; padding:9px 14px; cursor:pointer; }
		.repost-confirm { border:0; background:#5632a8; color:#fff; border-radius:7px; padding:10px 15px; font-weight:700; cursor:pointer; }
		.repost-notice { display:none; margin:12px 0 0; padding:11px 13px; border-radius:8px; background:#ecfdf3; color:#166534; font-size:13px; }
		@media(max-width:520px){ .repost-fields{grid-template-columns:1fr;} .repost-dialog{padding:19px;} }
		@media (max-width: 1250px) {
			.job-filters { grid-template-columns: repeat(3, minmax(0, 1fr)); }
			.job-search-group { grid-column: span 2; }
			.jobs-table th, .jobs-table td { padding:9px 6px; font-size:12px; }
			.job-actions .btn, .job-actions .btn-reopen { padding:6px; font-size:10px; }
		}
		@media (max-width: 900px) {
			.job-filters { grid-template-columns: repeat(2, minmax(0, 1fr)); }
			.job-search-group { grid-column: 1 / -1; }
			.jobs-table-wrapper { overflow:visible; }
			.jobs-table, .jobs-table tbody, .jobs-table tr, .jobs-table td { display:block; width:100%; }
			.jobs-table thead { display:none; }
			.jobs-table tr.job-row { border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; margin-bottom:12px; background:#fff; }
			.jobs-table td { display:grid; grid-template-columns:minmax(100px, 36%) minmax(0, 1fr); gap:10px; padding:7px 0; border:0; white-space:normal; }
			.jobs-table td::before { content:attr(data-label); font-weight:700; color:#64748b; }
			.jobs-table td:first-child { font-size:14px; }
			.jobs-table td:last-child { display:block; border-top:1px solid #edf0f3; margin-top:5px; padding-top:10px; }
			.jobs-table td:last-child::before { content:'Actions'; display:block; margin-bottom:8px; }
			.job-actions { gap:7px; }
			.job-actions .btn, .job-actions .btn-reopen { font-size:12px; padding:7px 9px; }
		}
		@media (max-width: 520px) {
			.job-filters { grid-template-columns:1fr; }
			.job-search-group { grid-column:auto; }
			.jobs-table td { grid-template-columns:100px minmax(0,1fr); }
			.pagination-area { flex-direction:column; align-items:flex-start; }
		}
	</style>
</head>
<body>
<?php
$activePage = 'jobs';
require __DIR__ . '/partials/company_navbar.php';
?>
<header class="top-header">
	<div
		class="user-profile"
		id="userProfile"
	>
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
			<span class="user-arrow">
				▼
			</span>
		</button>
		<div
			class="profile-dropdown"
			id="profileDropdown"
		>
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
	<div class="page-header">
		<div>
			<h1>
				Manage Jobs
			</h1>
		</div>
		<a
			href="index.php?action=manage_job"
			class="btn"
		>
			+ New Job
		</a>
	</div>
	<?php if (!empty($jobs)): ?>
		<div
			class="section-card"
			style="margin-bottom:20px;"
		>
			<div class="job-filters">
				<div class="form-group job-search-group">
					<label for="jobSearch">
						Search Jobs
					</label>
					<input
						type="text"
						id="jobSearch"
						placeholder="Search by job title or location..."
					>
				</div>
				<div class="form-group">
					<label for="statusFilter">
						Status
					</label>
					<select id="statusFilter">
						<option value="">
							All Statuses
						</option>
						<option value="Draft">Draft</option>
						<option value="Posted">Posted (all published jobs)</option>
						<option value="Upcoming">
							Upcoming
						</option>
						<option value="Active">
							Active
						</option>
						<option value="Closed">
							Closed
						</option>
					</select>
				</div>
				<div class="form-group">
					<label for="typeFilter">
						Job Type
					</label>
					<select id="typeFilter">
						<option value="">
							All Job Types
						</option>
						<?php foreach ($jobTypes as $type): ?>
							<option
								value="<?php echo htmlspecialchars($type); ?>"
							>
								<?php echo htmlspecialchars($type); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="closingFilter">Closing Date</label>
					<select id="closingFilter">
						<option value="">Any Closing Date</option>
						<option value="no-date">No Closing Date</option>
						<option value="7">Closing in 7 days</option>
						<option value="30">Closing in 30 days</option>
						<option value="overdue">Past Closing Date</option>
					</select>
				</div>
				<div class="form-group">
					<label for="applicantFilter">Applicants</label>
					<select id="applicantFilter">
						<option value="">Any Applicant Count</option>
						<option value="0">No applicants</option>
						<option value="1-5">1–5 applicants</option>
						<option value="6+">6 or more applicants</option>
					</select>
				</div>
				<div class="form-group">
					<label for="sortFilter">Sort By</label>
					<select id="sortFilter">
						<option value="default">Default Order</option>
						<option value="title">Job Title (A–Z)</option>
						<option value="closing-asc">Closing Date (Soonest)</option>
						<option value="applicants-desc">Most Applicants</option>
					</select>
				</div>
			</div>
			<div class="filter-toolbar">
				<div class="filter-results" id="filterResults">Showing <?php echo count($jobs); ?> job(s)</div>
				<button type="button" class="clear-filters" id="clearFilters">Clear all filters</button>
			</div>
		</div>
	<?php endif; ?>
	<div class="section-card">
		<?php if (!empty($jobs)): ?>
			<div class="jobs-table-wrapper">
				<table class="jobs-table">
					<thead>
						<tr>
							<th>Job Title</th>
							<th>Type</th>
							<th>Location</th>
							<th>Opening Date</th>
							<th>Closing Date</th>
							<th>Applicants</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="jobsTableBody">
					<?php foreach ($jobs as $job): ?>
						<?php
						$jobStatus = strtolower(
							trim(
								$job['status'] ?? 'draft'
							)
						);
						$openingDate = $job['opening_date'] ?? '';
						$closingDate = $job['closing_date'] ?? '';
						// Display status
						if ($jobStatus === 'draft') {
							$displayStatus = 'Draft';
						} elseif (
							!empty($openingDate) &&
							$openingDate > $today
						) {
							$displayStatus = 'Upcoming';
						} elseif (
							!empty($closingDate) &&
							$closingDate < $today
						) {
							$displayStatus = 'Closed';
						} else {
							$displayStatus = 'Active';
						}
						?>
						<tr
							class="job-row"
							data-title="<?php echo htmlspecialchars($job['title'] ?? ''); ?>"
							data-location="<?php echo htmlspecialchars($job['location'] ?? ''); ?>"
							data-type="<?php echo htmlspecialchars($job['job_type'] ?? ''); ?>"
							data-status="<?php echo htmlspecialchars($displayStatus); ?>"
							data-published-status="<?php echo htmlspecialchars($jobStatus === 'posted' ? 'Posted' : 'Draft'); ?>"
							data-opening="<?php echo htmlspecialchars($openingDate); ?>"
							data-closing="<?php echo htmlspecialchars($closingDate); ?>"
							data-applicants="<?php echo (int)($job['applicant_count'] ?? $job['total_applications'] ?? 0); ?>"
						>
							<td data-label="Job Title">
								<strong>
									<?php echo htmlspecialchars($job['title'] ?? ''); ?>
								</strong>
							</td>
							<td data-label="Type">
								<?php echo htmlspecialchars($job['job_type'] ?? '-'); ?>
							</td>
							<td data-label="Location">
								<?php echo htmlspecialchars($job['location'] ?? '-'); ?>
							</td>
							<td data-label="Opening Date">
								<?php
								if (!empty($openingDate)) {
									echo htmlspecialchars(
										date(
											'M d, Y',
											strtotime($openingDate)
										)
									);
								} else {
									echo '-';
								}
								?>
							</td>
							<td data-label="Closing Date">
								<?php
								if (!empty($closingDate)) {
									echo htmlspecialchars(
										date(
											'M d, Y',
											strtotime($closingDate)
										)
									);
								} else {
									echo '-';
								}
								?>
							</td>
							<td data-label="Applicants">
								<?php
								echo (int)(
									$job['applicant_count']
									?? $job['total_applications']
									?? 0
								);
								?>
							</td>
							<td data-label="Status">
								<span class="status-badge status-<?php echo strtolower($displayStatus); ?>"><?php echo htmlspecialchars($displayStatus); ?></span>
							</td>
							<td data-label="Actions">
								<div class="job-actions">
									<a
										href="index.php?action=manage_job&id=<?php echo urlencode($job['job_id']); ?>"
										class="btn btn-secondary"
									>
										Edit
									</a>
									<?php if ($displayStatus === 'Closed'): ?>
										<button type="button" class="btn-reopen" title="Create a new posting using the same job details" data-title="<?php echo htmlspecialchars($job['title'] ?? 'Job vacancy', ENT_QUOTES); ?>" data-type="<?php echo htmlspecialchars($job['job_type'] ?? '', ENT_QUOTES); ?>" data-location="<?php echo htmlspecialchars($job['location'] ?? '', ENT_QUOTES); ?>" data-opening="<?php echo htmlspecialchars($openingDate, ENT_QUOTES); ?>" data-closing="<?php echo htmlspecialchars($closingDate, ENT_QUOTES); ?>" data-job="<?php echo htmlspecialchars(json_encode($job, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8'); ?>" onclick="openRepostModal(this)">Reopen</button>
										<?php endif; ?>
										<?php if ($jobStatus === 'draft'): ?>
										<a
											href="index.php?action=post_job&id=<?php echo urlencode($job['job_id']); ?>"
											class="btn"
											onclick="return confirm('Are you sure you want to post this job?');"
										>
											Post
										</a>
									<?php endif; ?>
									<a
										href="index.php?action=delete_job&id=<?php echo urlencode($job['job_id']); ?>"
										class="btn btn-danger"
										onclick="return confirm('Are you sure you want to delete this job vacancy?');"
									>
										Delete
									</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div
				class="no-filter-results"
				id="noFilterResults"
			>
				<h3>No Matching Jobs</h3>
				<p>No job vacancies match the selected filters.</p>
			</div>
			<div class="pagination-area">
				<div
					class="pagination-info"
					id="paginationInfo"
				></div>
				<div
					class="pagination-controls"
					id="paginationControls"
				></div>
			</div>
		<?php else: ?>
			<div class="empty-state">
				<h3>No Jobs Created Yet</h3>
				<p>
					Create your first job vacancy.
					It will be saved as a draft before you post it.
				</p>
				<a
					href="index.php?action=manage_job"
					class="btn"
					style="margin-top:15px;"
				>
					+ New Job
				</a>
			</div>
		<?php endif; ?>
	</div>
</main>

<!-- Frontend-only Reopen dialog: copied details are prefilled and editable. -->
<div class="repost-modal" id="repostModal" role="dialog" aria-modal="true" aria-labelledby="repostModalTitle">
  <div class="repost-dialog" style="width:min(100%, 760px); max-height:90vh; overflow-y:auto;">
    <h2 id="repostModalTitle">Create a New Job Posting</h2>
    <p id="repostJobSummary">The original job details are copied by default. Change the opening and closing dates, and edit any other details if needed. The original vacancy remains unchanged.</p>
    <form id="repostForm">
      <div class="repost-fields">
        <div><label for="repostTitle">Job title</label><input type="text" id="repostTitle" required></div>
        <div><label for="repostType">Job type</label><input type="text" id="repostType" required></div>
        <div style="grid-column:1/-1"><label for="repostLocation">Location</label><input type="text" id="repostLocation" required></div>
        <div><label for="repostOpening">New opening date</label><input type="date" id="repostOpening" required></div>
        <div><label for="repostClosing">New closing date</label><input type="date" id="repostClosing" required></div>
      </div>
      <div id="repostExtraFields" class="repost-fields" style="margin-top:14px;"></div>
      <div class="repost-notice" id="repostNotice" role="status"></div>
      <div class="repost-actions">
        <button type="button" class="repost-cancel" onclick="closeRepostModal()">Cancel</button>
        <button type="submit" class="repost-confirm">Create New Posting</button>
      </div>
    </form>
  </div>
</div>
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
// Job filters and pagination
const jobSearch = document.getElementById('jobSearch');
const statusFilter = document.getElementById('statusFilter');
const typeFilter = document.getElementById('typeFilter');
const closingFilter = document.getElementById('closingFilter');
const applicantFilter = document.getElementById('applicantFilter');
const sortFilter = document.getElementById('sortFilter');
const clearFilters = document.getElementById('clearFilters');
const filterResults = document.getElementById('filterResults');
const noFilterResults = document.getElementById('noFilterResults');
const paginationInfo = document.getElementById('paginationInfo');
const paginationControls = document.getElementById('paginationControls');
let jobRows = Array.from(
	document.querySelectorAll('.job-row')
);
const recordsPerPage = 5;
let currentPage = 1;
let filteredJobs = jobRows;

// Repost demo state: the new posting is temporary and browser-only.
let repostSourceRow = null;
let repostOriginalJob = {};
let repostEditMode = false;
const repostFieldAliases = [
  { id:'description', label:'Job description', keys:['description','job_description'], type:'textarea', wide:true },
  { id:'responsibilities', label:'Responsibilities', keys:['responsibilities','job_responsibilities'], type:'textarea', wide:true },
  { id:'requirements', label:'Requirements', keys:['requirements','job_requirements'], type:'textarea', wide:true },
  { id:'qualifications', label:'Qualifications', keys:['qualifications','qualification','education'], type:'textarea', wide:true },
  { id:'experience', label:'Experience', keys:['experience','experience_required'], type:'text' },
  { id:'salary', label:'Salary', keys:['salary','salary_range'], type:'text' },
  { id:'work_mode', label:'Work arrangement', keys:['work_mode','work_arrangement','workplace_type'], type:'text' },
  { id:'benefits', label:'Benefits', keys:['benefits'], type:'textarea', wide:true }
];
function firstJobValue(job, keys) {
  for (const key of keys) {
    if (job && job[key] !== undefined && job[key] !== null && String(job[key]).trim() !== '') return String(job[key]);
  }
  return '';
}
function openRepostModal(button, editMode = false) {
  repostEditMode = editMode;
  repostSourceRow = button.closest('.job-row');
  try { repostOriginalJob = JSON.parse(button.dataset.job || '{}'); }
  catch (error) { repostOriginalJob = {}; }

  document.getElementById('repostTitle').value = firstJobValue(repostOriginalJob, ['title']) || button.dataset.title || '';
  document.getElementById('repostType').value = firstJobValue(repostOriginalJob, ['job_type','type']) || button.dataset.type || '';
  document.getElementById('repostLocation').value = firstJobValue(repostOriginalJob, ['location']) || button.dataset.location || '';

  const today = new Date();
  const todayString = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().slice(0,10);
  const rowOpening = repostSourceRow?.dataset.opening || '';
  const rowClosing = repostSourceRow?.dataset.closing || '';
  document.getElementById('repostOpening').value = editMode && rowOpening ? rowOpening : todayString;
  const closing = new Date(today); closing.setDate(closing.getDate() + 30);
  document.getElementById('repostClosing').value = editMode && rowClosing ? rowClosing : new Date(closing.getTime() - closing.getTimezoneOffset() * 60000).toISOString().slice(0,10);

  const extra = document.getElementById('repostExtraFields');
  extra.innerHTML = '';
  repostFieldAliases.forEach(field => {
    const value = firstJobValue(repostOriginalJob, field.keys);
    if (!value) return;
    const wrapper = document.createElement('div');
    if (field.wide) wrapper.style.gridColumn = '1 / -1';
    const label = document.createElement('label');
    label.htmlFor = 'repost_' + field.id;
    label.textContent = field.label;
    const control = field.type === 'textarea' ? document.createElement('textarea') : document.createElement('input');
    control.id = 'repost_' + field.id;
    control.value = value;
    control.style.width = '100%';
    control.style.boxSizing = 'border-box';
    control.style.padding = '10px';
    control.style.border = '1px solid #cbd5e1';
    control.style.borderRadius = '7px';
    if (field.type === 'textarea') control.rows = 3;
    else control.type = 'text';
    wrapper.append(label, control);
    extra.appendChild(wrapper);
  });
  document.getElementById('repostModalTitle').textContent = editMode ? 'Edit Demo Job Posting' : 'Create a New Job Posting';
  document.querySelector('#repostForm .repost-confirm').textContent = editMode ? 'Save Changes' : 'Create New Posting';
  document.getElementById('repostNotice').style.display = 'none';
  document.getElementById('repostModal').classList.add('open');
}
function closeRepostModal() {
  document.getElementById('repostModal').classList.remove('open');
  repostSourceRow = null;
  repostOriginalJob = {};
  repostEditMode = false;
  document.getElementById('repostModalTitle').textContent = 'Create a New Job Posting';
  document.querySelector('#repostForm .repost-confirm').textContent = 'Create New Posting';
}
document.getElementById('repostModal').addEventListener('click', function(e) {
  if (e.target === this) closeRepostModal();
});
document.getElementById('repostForm').addEventListener('submit', function(e) {
  e.preventDefault();
  if (!repostSourceRow) return;
  const opening = document.getElementById('repostOpening').value;
  const closing = document.getElementById('repostClosing').value;
  const title = document.getElementById('repostTitle').value.trim();
  const type = document.getElementById('repostType').value.trim();
  const location = document.getElementById('repostLocation').value.trim();
  const notice = document.getElementById('repostNotice');
  if (!title || !type || !location || !opening || !closing || closing < opening) {
    notice.textContent = 'Please complete the required fields and choose a closing date on or after the opening date.';
    notice.style.display = 'block'; notice.style.background = '#fef2f2'; notice.style.color = '#991b1b';
    return;
  }
  const targetRow = repostEditMode ? repostSourceRow : repostSourceRow.cloneNode(true);
  targetRow.dataset.title = title; targetRow.dataset.type = type; targetRow.dataset.location = location;
  targetRow.dataset.opening = opening; targetRow.dataset.closing = closing;
  targetRow.dataset.status = opening > new Date().toISOString().slice(0,10) ? 'Upcoming' : 'Active';
  targetRow.dataset.publishedStatus = 'Posted';
  targetRow.dataset.applicants = repostEditMode ? (targetRow.dataset.applicants || '0') : '0';
  targetRow.querySelector('td:nth-child(1) strong').textContent = title;
  targetRow.querySelector('td:nth-child(2)').textContent = type;
  targetRow.querySelector('td:nth-child(3)').textContent = location;
  targetRow.querySelector('td:nth-child(4)').textContent = formatDemoDate(opening);
  targetRow.querySelector('td:nth-child(5)').textContent = formatDemoDate(closing);
  if (!repostEditMode) targetRow.querySelector('td:nth-child(6)').textContent = '0';
  const status = targetRow.querySelector('td:nth-child(7) .status-badge');
  const displayStatus = targetRow.dataset.status;
  status.className = 'status-badge status-' + displayStatus.toLowerCase();
  status.textContent = displayStatus;
  targetRow.querySelector('td:nth-child(8) .job-actions').innerHTML = `
    <button type="button" class="btn btn-secondary" onclick="openDemoEdit(this)">Edit</button>
    <button type="button" class="btn btn-danger" onclick="deleteDemoPosting(this)">Delete</button>`;
  if (!repostEditMode) document.getElementById('jobsTableBody').prepend(targetRow);
  jobRows = Array.from(document.querySelectorAll('.job-row'));
  notice.textContent = repostEditMode ? 'Demo posting updated. Changes are temporary and disappear when the page is refreshed.' : 'New demo posting created using the copied details and your edits. The original posting remains unchanged. This demo row disappears when the page is refreshed.';
  notice.style.display = 'block'; notice.style.background = '#ecfdf3'; notice.style.color = '#166534';
  repostSourceRow = null;
  setTimeout(function(){ closeRepostModal(); filterJobs(); }, 1800);
});
function openDemoEdit(button) {
  const row = button.closest('.job-row');
  const source = row.querySelector('.btn-reopen');
  const payload = {title: row.dataset.title || '', job_type: row.dataset.type || '', location: row.dataset.location || ''};
  const trigger = document.createElement('button');
  trigger.dataset.job = JSON.stringify(payload);
  trigger.dataset.title = payload.title; trigger.dataset.type = payload.job_type; trigger.dataset.location = payload.location;
  trigger.dataset.opening = row.dataset.opening || ''; trigger.dataset.closing = row.dataset.closing || '';
  trigger.closest = () => row;
  openRepostModal(trigger, true);
}
function deleteDemoPosting(button) {
  if (!confirm('Delete this temporary demo posting?')) return;
  button.closest('.job-row').remove();
  jobRows = Array.from(document.querySelectorAll('.job-row'));
  filterJobs();
}
function formatDemoDate(value) {
  if (!value) return '-';
  return new Date(value + 'T00:00:00').toLocaleDateString('en-US', {month:'short', day:'2-digit', year:'numeric'});
}
// Normalize values
function normalizeValue(value) {
	return String(value || '')
		.toLowerCase()
		.replace(/[-_]/g, ' ')
		.replace(/\s+/g, ' ')
		.trim();
}
// Filter jobs
function filterJobs() {
	if (
		!jobSearch ||
		!statusFilter ||
		!typeFilter
	) {
		return;
	}
	const searchValue = normalizeValue(jobSearch.value);
	const statusValue = normalizeValue(statusFilter.value);
	const typeValue = normalizeValue(typeFilter.value);
	const closingValue = closingFilter ? closingFilter.value : '';
	const applicantValue = applicantFilter ? applicantFilter.value : '';
	const todayDate = new Date();
	todayDate.setHours(0,0,0,0);
	filteredJobs = jobRows.filter(
		function(row) {
			const title = normalizeValue(row.dataset.title);
			const location = normalizeValue(row.dataset.location);
			const status = normalizeValue(row.dataset.status);
			const publishedStatus = normalizeValue(row.dataset.publishedStatus);
			const type = normalizeValue(row.dataset.type);
			const closing = row.dataset.closing || '';
			const applicants = Number(row.dataset.applicants || 0);
			const matchesSearch =
				searchValue === '' ||
				title.includes(searchValue) ||
				location.includes(searchValue);
			const matchesStatus =
				statusValue === '' ||
				(statusValue === 'posted'
					? publishedStatus === 'posted'
					: status === statusValue);
			const matchesType = typeValue === '' || type === typeValue;
			let matchesClosing = true;
			if (closingValue === 'no-date') matchesClosing = closing === '';
			else if (closingValue === 'overdue') matchesClosing = closing !== '' && closing < todayDate.toISOString().slice(0,10);
			else if (closingValue === '7' || closingValue === '30') {
				const deadline = new Date(todayDate); deadline.setDate(deadline.getDate() + Number(closingValue));
				matchesClosing = closing !== '' && closing >= todayDate.toISOString().slice(0,10) && closing <= deadline.toISOString().slice(0,10);
			}
			let matchesApplicants = true;
			if (applicantValue === '0') matchesApplicants = applicants === 0;
			else if (applicantValue === '1-5') matchesApplicants = applicants >= 1 && applicants <= 5;
			else if (applicantValue === '6+') matchesApplicants = applicants >= 6;
			return (
				matchesSearch &&
				matchesStatus &&
				matchesType &&
				matchesClosing &&
				matchesApplicants
			);
		}
	);
	const sortValue = sortFilter ? sortFilter.value : 'default';
	if (sortValue === 'title') filteredJobs.sort((a,b) => normalizeValue(a.dataset.title).localeCompare(normalizeValue(b.dataset.title)));
	else if (sortValue === 'closing-asc') filteredJobs.sort((a,b) => (a.dataset.closing || '9999-12-31').localeCompare(b.dataset.closing || '9999-12-31'));
	else if (sortValue === 'applicants-desc') filteredJobs.sort((a,b) => Number(b.dataset.applicants || 0) - Number(a.dataset.applicants || 0));
	currentPage = 1;
	displayJobPage();
}
// Display current page
function displayJobPage() {
	jobRows.forEach(
		function(row) {
			row.style.display = 'none';
		}
	);
	const totalRecords = filteredJobs.length;
	const totalPages = Math.ceil(
		totalRecords / recordsPerPage
	);
	if (
		totalPages > 0 &&
		currentPage > totalPages
	) {
		currentPage = totalPages;
	}
	const startIndex =
		(currentPage - 1) * recordsPerPage;
	const endIndex =
		startIndex + recordsPerPage;
	const currentRows = filteredJobs.slice(
		startIndex,
		endIndex
	);
	currentRows.forEach(
		function(row) {
			row.style.display = '';
		}
	);
	if (filterResults) {
		filterResults.textContent =
			'Showing ' +
			totalRecords +
			' job(s)';
	}
	if (noFilterResults) {
		noFilterResults.style.display =
			totalRecords === 0
				? 'block'
				: 'none';
	}
	renderPagination(
		totalRecords,
		totalPages
	);
}
// Pagination
function renderPagination(
	totalRecords,
	totalPages
) {
	if (
		!paginationInfo ||
		!paginationControls
	) {
		return;
	}
	paginationControls.innerHTML = '';
	if (totalRecords === 0) {
		paginationInfo.textContent = '';
		return;
	}
	const startRecord =
		(currentPage - 1) *
		recordsPerPage +
		1;
	const endRecord = Math.min(
		currentPage * recordsPerPage,
		totalRecords
	);
	paginationInfo.textContent =
		'Showing ' +
		startRecord +
		' - ' +
		endRecord +
		' of ' +
		totalRecords +
		' job(s)';
	const previousButton =
		document.createElement('button');
	previousButton.type = 'button';
	previousButton.className = 'pagination-btn';
	previousButton.textContent = 'Previous';
	previousButton.disabled = currentPage === 1;
	previousButton.addEventListener(
		'click',
		function() {
			if (currentPage > 1) {
				currentPage--;
				displayJobPage();
			}
		}
	);
	paginationControls.appendChild(previousButton);
	for (
		let page = 1;
		page <= totalPages;
		page++
	) {
		const pageButton =
			document.createElement('button');
		pageButton.type = 'button';
		pageButton.className = 'pagination-btn';
		if (page === currentPage) {
			pageButton.classList.add('active');
		}
		pageButton.textContent = page;
		pageButton.addEventListener(
			'click',
			function() {
				currentPage = page;
				displayJobPage();
			}
		);
		paginationControls.appendChild(pageButton);
	}
	const nextButton =
		document.createElement('button');
	nextButton.type = 'button';
	nextButton.className = 'pagination-btn';
	nextButton.textContent = 'Next';
	nextButton.disabled =
		currentPage === totalPages;
	nextButton.addEventListener(
		'click',
		function() {
			if (currentPage < totalPages) {
				currentPage++;
				displayJobPage();
			}
		}
	);
	paginationControls.appendChild(nextButton);
}
// Filter events
if (jobSearch) {
	jobSearch.addEventListener(
		'input',
		filterJobs
	);
}
if (statusFilter) {
	statusFilter.addEventListener(
		'change',
		filterJobs
	);
}
if (typeFilter) typeFilter.addEventListener('change', filterJobs);
if (closingFilter) closingFilter.addEventListener('change', filterJobs);
if (applicantFilter) applicantFilter.addEventListener('change', filterJobs);
if (sortFilter) sortFilter.addEventListener('change', filterJobs);
if (clearFilters) {
	clearFilters.addEventListener('click', function() {
		if (jobSearch) jobSearch.value = '';
		if (statusFilter) statusFilter.value = '';
		if (typeFilter) typeFilter.value = '';
		if (closingFilter) closingFilter.value = '';
		if (applicantFilter) applicantFilter.value = '';
		if (sortFilter) sortFilter.value = 'default';
		filterJobs();
	});
}
// Initial display
if (jobRows.length > 0) {
	filterJobs();
}
</script>
</body>
</html>