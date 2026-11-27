<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Company Profile - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
	<style>
		.profile-page {
			width: 100%;
			max-width: 1400px;
			margin: 0 auto;
			box-sizing: border-box;
			padding-bottom: 30px;
		}
		.profile-header {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			gap: 20px;
			margin-bottom: 24px;
			flex-wrap: wrap;
		}
		.profile-heading {
			display: flex;
			align-items: flex-start;
			gap: 14px;
		}
		.profile-heading-icon {
			width: 46px;
			height: 46px;
			flex: 0 0 46px;
			display: grid;
			place-items: center;
			border-radius: 12px;
			background: #eef2ff;
			color: #4338ca;
			font-size: 22px;
		}
		.profile-header h1 {
			margin: 0 0 6px;
			font-size: clamp(24px, 3vw, 30px);
			line-height: 1.25;
		}
		.profile-header p {
			margin: 0;
			color: var(--text-muted);
			line-height: 1.5;
		}
		.profile-grid {
			display: grid;
			grid-template-columns: minmax(0, 1.75fr) minmax(280px, .85fr);
			gap: 22px;
			align-items: start;
		}
		.profile-main-column, .profile-side-column { min-width: 0; }
		.profile-card {
			background: #fff;
			border: 1px solid #e5e7eb;
			border-radius: 14px;
			padding: 24px;
			box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
			min-width: 0;
			box-sizing: border-box;
		}
		.profile-card + .profile-card { margin-top: 18px; }
		.profile-card-heading {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			margin-bottom: 22px;
			padding-bottom: 17px;
			border-bottom: 1px solid #edf0f4;
		}
		.profile-section-icon {
			width: 38px;
			height: 38px;
			flex: 0 0 38px;
			display: grid;
			place-items: center;
			border-radius: 10px;
			background: #f3f4f6;
			font-size: 18px;
		}
		.profile-card-heading h2 {
			font-size: 17px;
			margin: 1px 0 5px;
			color: #111827;
		}
		.profile-card-heading p {
			margin: 0;
			color: var(--text-muted);
			font-size: 13px;
			line-height: 1.5;
		}
		.profile-form .form-group { margin-bottom: 19px; }
		.profile-form label {
			display: block;
			margin-bottom: 7px;
			font-size: 13px;
			font-weight: 600;
			color: #374151;
		}
		.profile-form input, .profile-form textarea {
			width: 100%;
			max-width: 100%;
			box-sizing: border-box;
			border: 1px solid #d1d5db;
			border-radius: 8px;
			padding: 11px 12px;
			font: inherit;
			font-size: 14px;
			color: #111827;
			background: #fff;
			transition: border-color .15s ease, box-shadow .15s ease;
		}
		.profile-form input { min-height: 43px; }
		.profile-form textarea {
			resize: vertical;
			min-height: 140px;
			line-height: 1.6;
		}
		.profile-form input:focus, .profile-form textarea:focus {
			outline: none;
			border-color: #6366f1;
			box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
		}
		.profile-form .required { color: #dc2626; }
		.profile-row {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 16px;
		}
		.profile-section-title {
			display: flex;
			align-items: center;
			gap: 10px;
			margin: 28px 0 18px;
			padding-top: 23px;
			border-top: 1px solid #edf0f4;
			font-size: 16px;
			color: #111827;
		}
		.profile-section-title span { font-size: 18px; }
		.profile-form .field-hint {
			margin: 6px 0 0;
			color: #6b7280;
			font-size: 12px;
			line-height: 1.5;
		}
		.form-actions {
			display: flex;
			justify-content: flex-end;
			align-items: center;
			gap: 10px;
			margin-top: 25px;
			padding-top: 20px;
			border-top: 1px solid #edf0f4;
			flex-wrap: wrap;
		}
		.form-actions .btn { min-height: 42px; }
		.profile-alert {
			padding: 13px 15px;
			border-radius: 9px;
			margin-bottom: 18px;
			font-size: 14px;
			line-height: 1.5;
			border: 1px solid transparent;
		}
		.profile-alert-error {
			color: #991b1b;
			background: #fef2f2;
			border-color: #fecaca;
		}
		.profile-alert-success {
			color: #166534;
			background: #f0fdf4;
			border-color: #bbf7d0;
		}
		.company-summary { text-align: center; }
		.company-avatar-large {
			width: 88px;
			height: 88px;
			border-radius: 20px;
			background: linear-gradient(135deg, #eef2ff, #e0e7ff);
			color: #3730a3;
			display: grid;
			place-items: center;
			font-size: 32px;
			font-weight: 750;
			margin: 0 auto 15px;
			border: 1px solid #c7d2fe;
		}
		.company-summary h2 {
			margin: 0 0 7px;
			font-size: 19px;
			line-height: 1.4;
			color: #111827;
			overflow-wrap: anywhere;
		}
		.company-industry {
			display: inline-block;
			max-width: 100%;
			margin: 0;
			padding: 5px 10px;
			border-radius: 999px;
			background: #f3f4f6;
			color: #4b5563;
			font-size: 12px;
			overflow-wrap: anywhere;
		}
		.profile-info {
			margin-top: 22px;
			padding-top: 6px;
			border-top: 1px solid #edf0f4;
			text-align: left;
		}
		.profile-info-item {
			display: grid;
			grid-template-columns: 32px minmax(0, 1fr);
			gap: 10px;
			align-items: start;
			padding: 14px 0;
			border-bottom: 1px solid #f1f3f5;
		}
		.profile-info-item:last-child { border-bottom: 0; }
		.info-icon {
			width: 30px;
			height: 30px;
			display: grid;
			place-items: center;
			background: #f9fafb;
			border: 1px solid #edf0f4;
			border-radius: 8px;
			font-size: 14px;
		}
		.info-copy strong {
			display: block;
			font-size: 12px;
			color: #6b7280;
			margin: 0 0 4px;
		}
		.info-copy span, .info-copy a {
			display: block;
			font-size: 13px;
			line-height: 1.5;
			color: #374151;
			overflow-wrap: anywhere;
			text-decoration: none;
		}
		.info-copy a:hover { color: #4338ca; text-decoration: underline; }
		.profile-tips {
			display: flex;
			align-items: flex-start;
			gap: 12px;
		}
		.profile-tips-icon {
			width: 36px;
			height: 36px;
			flex: 0 0 36px;
			display: grid;
			place-items: center;
			border-radius: 10px;
			background: #eef2ff;
			font-size: 17px;
		}
		.profile-tips h2 { margin: 1px 0 7px; font-size: 15px; }
		.profile-tips p {
			margin: 0;
			color: var(--text-muted);
			font-size: 13px;
			line-height: 1.7;
		}
		.profile-completion {
			margin-top: 19px;
			padding: 13px;
			background: #f9fafb;
			border: 1px solid #f0f1f3;
			border-radius: 10px;
		}
		.completion-label {
			display: flex;
			justify-content: space-between;
			gap: 10px;
			font-size: 12px;
			color: #4b5563;
			margin-bottom: 8px;
		}
		.completion-track {
			height: 6px;
			background: #e5e7eb;
			border-radius: 999px;
			overflow: hidden;
		}
		.completion-fill {
			height: 100%;
			width: 0;
			background: #6366f1;
			border-radius: inherit;
			transition: width .2s ease;
		}
		@media (max-width: 1100px) {
			.profile-grid { grid-template-columns: minmax(0, 1fr); }
			.profile-side-column {
				display: grid;
				grid-template-columns: repeat(2, minmax(0, 1fr));
				gap: 18px;
			}
			.profile-side-column .profile-card + .profile-card { margin-top: 0; }
		}
		@media (max-width: 700px) {
			.profile-header { align-items: stretch; }
			.profile-header > a { align-self: flex-start; }
			.profile-grid { gap: 16px; }
			.profile-card { padding: 18px; border-radius: 12px; }
			.profile-row { grid-template-columns: minmax(0, 1fr); gap: 0; }
			.profile-side-column { grid-template-columns: minmax(0, 1fr); }
			.profile-form textarea { min-height: 120px; }
			.form-actions { display: grid; grid-template-columns: 1fr 1fr; }
			.form-actions .btn { text-align: center; justify-content: center; }
		}
		@media (max-width: 420px) {
			.form-actions { grid-template-columns: 1fr; }
		}
	</style>
</head>
<body>
<?php
$companyName = $company['company_name'] ?? 'Company Account';
$activePage = 'profile';
require __DIR__ . '/partials/company_navbar.php';

$companyInitial = strtoupper(substr(trim((string)$companyName), 0, 1));
if ($companyInitial === '') {
	$companyInitial = 'C';
}
$profileWebsite = trim((string)($company['website'] ?? ''));
$profileWebsiteHref = '';
if ($profileWebsite !== '') {
	$profileWebsiteHref = preg_match('~^https?://~i', $profileWebsite)
		? $profileWebsite
		: 'https://' . $profileWebsite;
}
$profileFields = [
	'company_name' => trim((string)($company['company_name'] ?? '')),
	'industry' => trim((string)($company['industry'] ?? '')),
	'location' => trim((string)($company['location'] ?? '')),
	'description' => trim((string)($company['description'] ?? '')),
	'website' => $profileWebsite
];
$profileCompleted = count(array_filter($profileFields, static function ($value) {
	return $value !== '';
}));
$profileCompletion = (int)round(($profileCompleted / count($profileFields)) * 100);
?>
<header class="top-header">
	<div class="user-profile" id="userProfile">
		<button type="button" class="user-profile-button" onclick="toggleProfileDropdown()" aria-expanded="false" aria-controls="profileDropdown">
			<div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
				<?php echo htmlspecialchars($companyInitial, ENT_QUOTES, 'UTF-8'); ?>
			</div>
			<span class="user-name"><?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></span>
			<span class="user-arrow">▼</span>
		</button>
		<div class="profile-dropdown" id="profileDropdown">
			<div class="dropdown-user">
				<div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
					<?php echo htmlspecialchars($companyInitial, ENT_QUOTES, 'UTF-8'); ?>
				</div>
				<div class="dropdown-user-info">
					<strong><?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></strong>
					<span><?php echo htmlspecialchars($company['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
				</div>
			</div>
			<a href="index.php?action=company_profile">Company Profile</a>
			<a href="index.php?action=logout" class="dropdown-logout">Logout</a>
		</div>
	</div>
</header>

<main class="container">
	<div class="profile-page">
		<div class="profile-header">
			<div class="profile-heading">
				<div class="profile-heading-icon" aria-hidden="true">🏢</div>
				<div>
					<h1>Company Profile</h1>
					<p>Manage your organization details and public company information.</p>
				</div>
			</div>
			<a href="index.php?action=company_dashboard" class="btn btn-secondary">Back to Dashboard</a>
		</div>

		<?php if (isset($error) && $error !== ''): ?>
			<div class="profile-alert profile-alert-error" role="alert">
				<?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
			</div>
		<?php endif; ?>
		<?php if (isset($success) && $success !== ''): ?>
			<div class="profile-alert profile-alert-success" role="status">
				<?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
			</div>
		<?php endif; ?>

		<div class="profile-grid">
			<div class="profile-main-column">
				<section class="profile-card">
					<div class="profile-card-heading">
						<div class="profile-section-icon" aria-hidden="true">📋</div>
						<div>
							<h2>General Organization Details</h2>
							<p>Keep your company details accurate and up to date.</p>
						</div>
					</div>

					<form class="profile-form" action="index.php?action=company_profile" method="POST">
						<div class="form-group">
							<label for="company_name">Official Company Name <span class="required">*</span></label>
							<input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company['company_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. ABC Company (Pvt) Ltd" autocomplete="organization" required>
						</div>

						<div class="profile-row">
							<div class="form-group">
								<label for="industry">Industry Sector <span class="required">*</span></label>
								<input type="text" id="industry" name="industry" value="<?php echo htmlspecialchars($company['industry'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. IT &amp; Software" required>
							</div>
							<div class="form-group">
								<label for="location">Head Office Location</label>
								<input type="text" id="location" name="location" value="<?php echo htmlspecialchars($company['location'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Colombo, Sri Lanka" autocomplete="address-level2">
							</div>
						</div>

						<div class="form-group">
							<label for="description">About Company</label>
							<textarea id="description" name="description" rows="6" placeholder="Describe your company, its services, mission and working environment..."><?php echo htmlspecialchars($company['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
							<p class="field-hint">A clear description helps job seekers understand your organization.</p>
						</div>

						<h3 class="profile-section-title"><span aria-hidden="true">🌐</span> Web Information</h3>
						<div class="form-group">
							<label for="website">Company Website URL</label>
							<input type="url" id="website" name="website" value="<?php echo htmlspecialchars($profileWebsite, ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://www.company.com" autocomplete="url">
							<p class="field-hint">Include https:// at the beginning of your website address.</p>
						</div>

						<div class="form-actions">
							<a href="index.php?action=company_dashboard" class="btn btn-secondary">Cancel</a>
							<button type="submit" class="btn">Save Profile Changes</button>
						</div>
					</form>
				</section>
			</div>

			<aside class="profile-side-column">
				<section class="profile-card company-summary">
					<div class="company-avatar-large" aria-hidden="true"><?php echo htmlspecialchars($companyInitial, ENT_QUOTES, 'UTF-8'); ?></div>
					<h2><?php echo htmlspecialchars($company['company_name'] ?? 'Company Account', ENT_QUOTES, 'UTF-8'); ?></h2>
					<p class="company-industry"><?php echo htmlspecialchars($company['industry'] ?? 'Industry not specified', ENT_QUOTES, 'UTF-8'); ?></p>

					<div class="profile-info">
						<div class="profile-info-item">
							<div class="info-icon" aria-hidden="true">📍</div>
							<div class="info-copy">
								<strong>Location</strong>
								<span><?php echo htmlspecialchars(($company['location'] ?? '') !== '' ? $company['location'] : 'Not specified', ENT_QUOTES, 'UTF-8'); ?></span>
							</div>
						</div>
						<div class="profile-info-item">
							<div class="info-icon" aria-hidden="true">🔗</div>
							<div class="info-copy">
								<strong>Website</strong>
								<?php if ($profileWebsite !== ''): ?>
									<a href="<?php echo htmlspecialchars($profileWebsiteHref, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars($profileWebsite, ENT_QUOTES, 'UTF-8'); ?></a>
								<?php else: ?>
									<span>Not specified</span>
								<?php endif; ?>
							</div>
						</div>
						<?php if (!empty($company['email'])): ?>
							<div class="profile-info-item">
								<div class="info-icon" aria-hidden="true">✉️</div>
								<div class="info-copy">
									<strong>Account Email</strong>
									<span><?php echo htmlspecialchars($company['email'], ENT_QUOTES, 'UTF-8'); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<div class="profile-completion">
						<div class="completion-label">
							<span>Profile information</span>
							<strong><?php echo $profileCompletion; ?>%</strong>
						</div>
						<div class="completion-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo $profileCompletion; ?>" aria-label="Profile information completed">
							<div class="completion-fill" style="width: <?php echo $profileCompletion; ?>%;"></div>
						</div>
					</div>
				</section>

				<section class="profile-card">
					<div class="profile-tips">
						<div class="profile-tips-icon" aria-hidden="true">💡</div>
						<div>
							<h2>Keep your profile up to date</h2>
							<p>Complete your organization details so job seekers can learn about your company and make informed decisions about opportunities you publish.</p>
						</div>
					</div>
				</section>
			</aside>
		</div>
	</div>
</main>

<script>
function toggleProfileDropdown() {
	const dropdown = document.getElementById('profileDropdown');
	const profile = document.getElementById('userProfile');
	const button = profile ? profile.querySelector('.user-profile-button') : null;
	if (!dropdown || !profile) return;
	const isOpen = dropdown.classList.toggle('show');
	profile.classList.toggle('open', isOpen);
	if (button) button.setAttribute('aria-expanded', String(isOpen));
}

document.addEventListener('click', function(event) {
	const profile = document.getElementById('userProfile');
	const dropdown = document.getElementById('profileDropdown');
	if (profile && dropdown && !profile.contains(event.target)) {
		dropdown.classList.remove('show');
		profile.classList.remove('open');
		const button = profile.querySelector('.user-profile-button');
		if (button) button.setAttribute('aria-expanded', 'false');
	}
});
</script>
</body>
</html>
