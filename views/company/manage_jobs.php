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
			grid-template-columns:
				minmax(250px, 2fr)
				minmax(180px, 1fr)
				minmax(180px, 1fr);
			gap: 15px;
			align-items: end;
		}
		.job-filters .form-group {
			margin-bottom: 0;
		}
		.filter-results {
			margin-top: 15px;
			color: var(--text-muted);
			font-size: 14px;
		}
		.jobs-table-wrapper {
			width: 100%;
			overflow-x: auto;
		}
		.jobs-table {
			width: 100%;
			min-width: 1000px;
			border-collapse: collapse;
		}
		.jobs-table th,
		.jobs-table td {
			white-space: nowrap;
		}
		.jobs-table th:first-child,
		.jobs-table td:first-child {
			min-width: 200px;
		}
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
		@media (max-width: 1100px) {
			.job-filters {
				grid-template-columns: 1fr 1fr;
			}
			.job-search-group {
				grid-column: 1 / -1;
			}
		}
		@media (max-width: 700px) {
			.job-filters {
				grid-template-columns: 1fr;
			}
			.job-search-group {
				grid-column: auto;
			}
			.pagination-area {
				flex-direction: column;
				align-items: flex-start;
			}
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
						<option value="Draft">
							Draft
						</option>
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
			</div>
			<div
				class="filter-results"
				id="filterResults"
			>
				Showing <?php echo count($jobs); ?> job(s)
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
						>
							<td>
								<strong>
									<?php echo htmlspecialchars($job['title'] ?? ''); ?>
								</strong>
							</td>
							<td>
								<?php echo htmlspecialchars($job['job_type'] ?? '-'); ?>
							</td>
							<td>
								<?php echo htmlspecialchars($job['location'] ?? '-'); ?>
							</td>
							<td>
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
							<td>
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
							<td>
								<?php
								echo (int)(
									$job['applicant_count']
									?? $job['total_applications']
									?? 0
								);
								?>
							</td>
							<td>
								<?php echo htmlspecialchars($displayStatus); ?>
							</td>
							<td>
								<div
									style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;"
								>
									<a
										href="index.php?action=manage_job&id=<?php echo urlencode($job['job_id']); ?>"
										class="btn btn-secondary"
									>
										Edit
									</a>
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
const filterResults = document.getElementById('filterResults');
const noFilterResults = document.getElementById('noFilterResults');
const paginationInfo = document.getElementById('paginationInfo');
const paginationControls = document.getElementById('paginationControls');
const jobRows = Array.from(
	document.querySelectorAll('.job-row')
);
const recordsPerPage = 5;
let currentPage = 1;
let filteredJobs = jobRows;
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
	filteredJobs = jobRows.filter(
		function(row) {
			const title = normalizeValue(row.dataset.title);
			const location = normalizeValue(row.dataset.location);
			const status = normalizeValue(row.dataset.status);
			const type = normalizeValue(row.dataset.type);
			const matchesSearch =
				searchValue === '' ||
				title.includes(searchValue) ||
				location.includes(searchValue);
			const matchesStatus =
				statusValue === '' ||
				status === statusValue;
			const matchesType =
				typeValue === '' ||
				type === typeValue;
			return (
				matchesSearch &&
				matchesStatus &&
				matchesType
			);
		}
	);
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
if (typeFilter) {
	typeFilter.addEventListener(
		'change',
		filterJobs
	);
}
// Initial display
if (jobRows.length > 0) {
	filterJobs();
}
</script>
</body>
</html>