<?php
$companyName = $company['company_name'] ?? 'Company Account';
// Get applicant status class
function applicantStatusClass($status) {
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
	<title>Applicants - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
	<style>
		.applicants-page {
			width: 100%;
			box-sizing: border-box;
		}
		.applicants-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 20px;
			margin-bottom: 25px;
		}
		.applicants-header h1 {
			margin: 0 0 6px 0;
		}
		.applicants-header p {
			margin: 0;
			color: var(--text-muted);
		}
		.applicant-filters {
			display: grid;
			grid-template-columns: minmax(250px, 2fr) minmax(200px, 1fr) minmax(200px, 1fr);
			gap: 15px;
			align-items: end;
		}
		.applicant-filters .form-group {
			margin-bottom: 0;
		}
		.filter-results {
			margin-top: 15px;
			font-size: 14px;
			color: var(--text-muted);
		}
		.applicants-table-wrapper {
			width: 100%;
			overflow-x: auto;
		}
		.applicants-table {
			width: 100%;
			min-width: 850px;
			border-collapse: collapse;
			text-align: left;
		}
		.applicants-table th {
			padding: 14px 12px;
			border-bottom: 2px solid #e5e7eb;
			white-space: nowrap;
		}
		.applicants-table td {
			padding: 15px 12px;
			border-bottom: 1px solid #eeeeee;
			vertical-align: middle;
		}
		.applicants-table tbody tr:last-child td {
			border-bottom: none;
		}
		.candidate-name {
			font-weight: 700;
		}
		.candidate-email {
			font-size: 12px;
			color: var(--text-muted);
			margin-top: 4px;
		}
		.status-badge {
			display: inline-block;
			padding: 5px 10px;
			border-radius: 20px;
			font-size: 11px;
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
		.action-btn {
			font-size: 12px;
			padding: 7px 12px;
			white-space: nowrap;
		}
		.no-results {
			display: none;
			text-align: center;
			padding: 45px 20px;
		}
		.no-results h3 {
			margin-bottom: 8px;
		}
		.no-results p {
			margin: 0;
			color: var(--text-muted);
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
			.applicant-filters {
				grid-template-columns: 1fr 1fr;
			}
			.applicant-search-group {
				grid-column: 1 / -1;
			}
		}
		@media (max-width: 700px) {
			.applicants-header {
				flex-direction: column;
				align-items: flex-start;
			}
			.applicant-filters {
				grid-template-columns: 1fr;
			}
			.applicant-search-group {
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
	<div class="applicants-page">
		<div class="applicants-header">
			<div>
				<h1>Applicants</h1>
			</div>
			<a
				href="index.php?action=manage_jobs"
				class="btn btn-secondary"
			>
				Manage Vacancies
			</a>
		</div>
		<div
			class="section-card"
			style="margin-bottom:20px;"
		>
			<div class="applicant-filters">
				<div class="form-group applicant-search-group">
					<label for="applicantSearch">
						Search Applicant
					</label>
					<input
						type="text"
						id="applicantSearch"
						placeholder="Search by applicant name..."
					>
				</div>
				<div class="form-group">
					<label for="jobFilter">
						Job Vacancy
					</label>
					<select id="jobFilter">
						<option value="">
							All Jobs
						</option>
						<option value="Associate SE (React / Node)">
							Associate SE (React / Node)
						</option>
						<option value="Senior HR Executive">
							Senior HR Executive
						</option>
						<option value="UI/UX Product Designer">
							UI/UX Product Designer
						</option>
					</select>
				</div>
				<div class="form-group">
					<label for="applicantStatusFilter">
						Application Status
					</label>
					<select id="applicantStatusFilter">
						<option value="">
							All Statuses
						</option>
						<option value="Pending Review">
							Pending Review
						</option>
						<option value="Shortlisted">
							Shortlisted
						</option>
						<option value="Interview Scheduled">
							Interview Scheduled
						</option>
						<option value="Rejected">
							Rejected
						</option>
					</select>
				</div>
			</div>
			<div
				class="filter-results"
				id="applicantFilterResults"
			>
				Showing 0 applicant(s)
			</div>
		</div>
		<div class="section-card">
			<div class="applicants-table-wrapper">
				<table class="applicants-table">
					<thead>
						<tr>
							<th>Candidate</th>
							<th>Applied Job Vacancy</th>
							<th>Applied Date</th>
							<th>Status</th>
							<th style="text-align:right;">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php if (!empty($applicants)): ?>
						<?php foreach ($applicants as $applicant): ?>
							<?php
							$status =
								$applicantStatuses[$applicant['key']]
								?? 'Pending Review';
							$statusClass =
								applicantStatusClass($status);
							?>
							<tr
								class="applicant-row"
								data-name="<?php echo htmlspecialchars($applicant['name']); ?>"
								data-job="<?php echo htmlspecialchars($applicant['job']); ?>"
								data-status="<?php echo htmlspecialchars($status); ?>"
							>
								<td>
									<div class="candidate-name">
										<?php echo htmlspecialchars($applicant['name']); ?>
									</div>
									<div class="candidate-email">
										<?php echo htmlspecialchars($applicant['email']); ?>
									</div>
								</td>
								<td>
									<?php echo htmlspecialchars($applicant['job']); ?>
								</td>
								<td>
									<?php echo htmlspecialchars($applicant['applied_date']); ?>
								</td>
								<td>
									<span
										class="status-badge <?php echo htmlspecialchars($statusClass); ?>"
									>
										<?php echo htmlspecialchars($status); ?>
									</span>
								</td>
								<td style="text-align:right;">
									<a
										href="index.php?action=candidate_review&candidate=<?php echo urlencode($applicant['key']); ?>"
										class="btn action-btn"
									>
										Review Candidate
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
			<div
				id="noApplicantResults"
				class="no-results"
			>
				<h3>No Applicants Found</h3>
				<p>No applicants match the selected filters.</p>
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
		</div>
	</div>
</main>
<script>
// Normalize values
function normalizeValue(value) {
	return String(value || '')
		.toLowerCase()
		.replace(/\s+/g, ' ')
		.trim();
}
// Applicant filters
const applicantSearch = document.getElementById('applicantSearch');
const jobFilter = document.getElementById('jobFilter');
const applicantStatusFilter = document.getElementById('applicantStatusFilter');
const applicantFilterResults = document.getElementById('applicantFilterResults');
const noApplicantResults = document.getElementById('noApplicantResults');
const paginationInfo = document.getElementById('paginationInfo');
const paginationControls = document.getElementById('paginationControls');
const applicantRows = Array.from(
	document.querySelectorAll('.applicant-row')
);
const recordsPerPage = 5;
let currentPage = 1;
let filteredApplicants = applicantRows;
// Filter applicants
function filterApplicants() {
	const searchValue = normalizeValue(applicantSearch.value);
	const jobValue = normalizeValue(jobFilter.value);
	const statusValue = normalizeValue(applicantStatusFilter.value);
	filteredApplicants = applicantRows.filter(
		function(row) {
			const name = normalizeValue(row.dataset.name);
			const job = normalizeValue(row.dataset.job);
			const status = normalizeValue(row.dataset.status);
			const matchesSearch =
				searchValue === '' ||
				name.includes(searchValue);
			const matchesJob =
				jobValue === '' ||
				job === jobValue;
			const matchesStatus =
				statusValue === '' ||
				status === statusValue;
			return (
				matchesSearch &&
				matchesJob &&
				matchesStatus
			);
		}
	);
	currentPage = 1;
	displayApplicantPage();
}
// Display applicant page
function displayApplicantPage() {
	applicantRows.forEach(
		function(row) {
			row.style.display = 'none';
		}
	);
	const totalRecords = filteredApplicants.length;
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
	const currentRows = filteredApplicants.slice(
		startIndex,
		endIndex
	);
	currentRows.forEach(
		function(row) {
			row.style.display = '';
		}
	);
	applicantFilterResults.textContent =
		'Showing ' +
		totalRecords +
		' applicant(s)';
	noApplicantResults.style.display =
		totalRecords === 0
			? 'block'
			: 'none';
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
		' applicant(s)';
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
				displayApplicantPage();
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
				displayApplicantPage();
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
				displayApplicantPage();
			}
		}
	);
	paginationControls.appendChild(nextButton);
}
// Filter events
applicantSearch.addEventListener(
	'input',
	filterApplicants
);
jobFilter.addEventListener(
	'change',
	filterApplicants
);
applicantStatusFilter.addEventListener(
	'change',
	filterApplicants
);
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
// Initial display
filterApplicants();
</script>
</body>
</html>