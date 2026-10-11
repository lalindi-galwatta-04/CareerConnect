<?php
$isEdit = !empty($job);
$pageTitle = $isEdit ? 'Edit Job' : 'New Job';
$companyName = $company['company_name'] ?? 'Company Account';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($pageTitle); ?> - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
</head>
<body>

<?php
$activePage = 'jobs';
require __DIR__ . '/partials/company_navbar.php';
?>

<header class="top-header">
	<div class="user-profile" id="userProfile">
		<button type="button" class="user-profile-button" onclick="toggleProfileDropdown()">
			<div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
				<?php echo htmlspecialchars(strtoupper(substr($companyName, 0, 1))); ?>
			</div>

			<span class="user-name">
				<?php echo htmlspecialchars($companyName); ?>
			</span>

			<span class="user-arrow">▼</span>
		</button>

		<div class="profile-dropdown" id="profileDropdown">
			<div class="dropdown-user">
				<div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
					<?php echo htmlspecialchars(strtoupper(substr($companyName, 0, 1))); ?>
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

			<a href="index.php?action=logout" class="dropdown-logout">
				Logout
			</a>
		</div>
	</div>
</header>

<main class="container">
	<div style="width:100%;max-width:850px;margin:0 auto;">

		<div style="margin-bottom:20px;">
			<a href="index.php?action=manage_jobs" style="color:var(--primary);text-decoration:none;font-size:14px;font-weight:600;">
				← Back to Manage Jobs
			</a>
		</div>

		<div class="page-header">
			<div>
				<h1>
					<?php echo htmlspecialchars($pageTitle); ?>
				</h1>

				<p>
					<?php
					echo $isEdit
						? 'Update the information for this job vacancy.'
						: 'Create a new job vacancy and save it as a draft.';
					?>
				</p>
			</div>
		</div>

		<div class="section-card">

			<?php if (isset($error)): ?>
				<div class="alert" style="margin-bottom:20px;">
					<?php echo htmlspecialchars($error); ?>
				</div>
			<?php endif; ?>

			<form
				action="index.php?action=manage_job<?php echo $isEdit && !empty($job['job_id']) ? '&id=' . urlencode($job['job_id']) : ''; ?>"
				method="POST"
				enctype="multipart/form-data"
			>

				<div class="form-group">
					<label for="title">
						Job Title
						<span class="required">*</span>
					</label>

					<input
						type="text"
						id="title"
						name="title"
						value="<?php echo htmlspecialchars($job['title'] ?? ''); ?>"
						placeholder="e.g. Associate Software Engineer"
						required
					>
				</div>

				<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;">

					<div class="form-group">
						<label for="job_type">
							Employment Type
							<span class="required">*</span>
						</label>

						<select id="job_type" name="job_type" required>
							<option value="">
								Select Employment Type
							</option>

							<option
								value="Full-Time"
								<?php echo (($job['job_type'] ?? '') === 'Full-Time') ? 'selected' : ''; ?>
							>
								Full-Time
							</option>

							<option
								value="Part-Time"
								<?php echo (($job['job_type'] ?? '') === 'Part-Time') ? 'selected' : ''; ?>
							>
								Part-Time
							</option>

							<option
								value="Contract"
								<?php echo (($job['job_type'] ?? '') === 'Contract') ? 'selected' : ''; ?>
							>
								Contract
							</option>

							<option
								value="Internship"
								<?php echo (($job['job_type'] ?? '') === 'Internship') ? 'selected' : ''; ?>
							>
								Internship
							</option>
						</select>
					</div>

					<div class="form-group">
						<label for="location">
							Location
							<span class="required">*</span>
						</label>

						<input
							type="text"
							id="location"
							name="location"
							value="<?php echo htmlspecialchars($job['location'] ?? ''); ?>"
							placeholder="e.g. Colombo, Sri Lanka"
							required
						>
					</div>

				</div>

				<div class="form-group">
					<label for="salary_range">
						Salary Range (Monthly)
					</label>

					<input
						type="text"
						id="salary_range"
						name="salary_range"
						value="<?php echo htmlspecialchars($job['salary_range'] ?? ''); ?>"
						placeholder="e.g. LKR 120,000 - 180,000"
					>
				</div>

				<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;">

					<div class="form-group">
						<label for="opening_date">
							Opening Date
							<span class="required">*</span>
						</label>

						<input
							type="date"
							id="opening_date"
							name="opening_date"
							value="<?php echo htmlspecialchars($job['opening_date'] ?? ''); ?>"
							required
						>
					</div>

					<div class="form-group">
						<label for="closing_date">
							Closing Date
							<span class="required">*</span>
						</label>

						<input
							type="date"
							id="closing_date"
							name="closing_date"
							value="<?php echo htmlspecialchars($job['closing_date'] ?? ''); ?>"
							required
						>
					</div>

				</div>

				<div class="form-group">
					<label for="description">
						Job Overview & Responsibilities
						<span class="required">*</span>
					</label>

					<textarea
						id="description"
						name="description"
						rows="7"
						placeholder="Describe the job role, responsibilities and main duties..."
						required
					><?php echo htmlspecialchars($job['description'] ?? ''); ?></textarea>
				</div>

				<div class="form-group">
					<label for="requirements">
						Requirements & Skills
						<span class="required">*</span>
					</label>

					<textarea
						id="requirements"
						name="requirements"
						rows="7"
						placeholder="Enter the qualifications, skills and experience required..."
						required
					><?php echo htmlspecialchars($job['requirements'] ?? ''); ?></textarea>
				</div>

				<div class="form-group">
					<label for="flyer">
						Job Flyer
						<span style="font-weight:400;color:#64748b;">(Optional)</span>
					</label>

					<?php if ($isEdit && !empty($job['flyer'])): ?>
						<div style="margin-bottom:10px;padding:10px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;">
							<span style="font-size:13px;color:#64748b;">
								Current flyer:
							</span>

							<a
								href="<?php echo htmlspecialchars($job['flyer']); ?>"
								target="_blank"
								style="margin-left:5px;color:var(--primary);font-size:13px;font-weight:600;"
							>
								View Flyer
							</a>
						</div>
					<?php endif; ?>

					<input
						type="file"
						id="flyer"
						name="flyer"
						accept=".pdf,.jpg,.jpeg,.png"
					>

					<small style="display:block;margin-top:6px;color:#64748b;font-size:13px;">
						Upload a PDF, JPG, JPEG or PNG file.
						<?php if ($isEdit && !empty($job['flyer'])): ?>
							Leave this empty to keep the current flyer.
						<?php endif; ?>
					</small>
				</div>

				<?php if (!$isEdit): ?>
					<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 16px;margin-top:10px;">
						<strong style="font-size:14px;">
							Draft Job
						</strong>

						<p style="margin:5px 0 0;color:#64748b;font-size:13px;">
							Saving this job will create it as a draft. You can post it later from Manage Jobs.
						</p>
					</div>
				<?php endif; ?>

				<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;border-top:1px solid #e2e8f0;padding-top:20px;margin-top:20px;">

					<div>
						<?php if ($isEdit && !empty($job['job_id'])): ?>
							<a
								href="index.php?action=delete_job&id=<?php echo urlencode($job['job_id']); ?>"
								class="btn btn-danger"
								onclick="return confirm('Are you sure you want to delete this job vacancy?');"
							>
								Delete Vacancy
							</a>
						<?php endif; ?>
					</div>

					<div style="display:flex;gap:10px;">
						<a href="index.php?action=manage_jobs" class="btn btn-secondary">
							Cancel
						</a>

						<button type="submit" class="btn">
							<?php echo $isEdit ? 'Save Changes' : 'Save as Draft'; ?>
						</button>
					</div>

				</div>

			</form>
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

document.addEventListener('click', function(event) {
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
});

// Job date validation
const openingDate = document.getElementById('opening_date');
const closingDate = document.getElementById('closing_date');

function updateClosingDate() {
	if (openingDate.value) {
		closingDate.min = openingDate.value;

		if (
			closingDate.value &&
			closingDate.value < openingDate.value
		) {
			closingDate.value = '';
		}
	}
}

openingDate.addEventListener('change', updateClosingDate);
updateClosingDate();
</script>

</body>
</html>