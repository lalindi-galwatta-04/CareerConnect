<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Company Profile - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=5.0">
	<style>
		.profile-grid {
			display: grid;
			grid-template-columns: minmax(0, 2fr) minmax(260px, 1fr);
			gap: 1.5rem;
			align-items: start;
		}
		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 1.25rem;
		}
		.profile-side {
			display: flex;
			flex-direction: column;
			gap: 1.5rem;
		}
		.profile-side .section-card {
			margin-bottom: 0;
		}
		.logo-preview-box {
			width: 130px;
			height: 130px;
			border: 1px solid var(--card-border);
			border-radius: var(--radius-md);
			display: flex;
			align-items: center;
			justify-content: center;
			background: #f8fafc;
			margin: 0 auto 12px;
			overflow: hidden;
		}
		.logo-preview-box img {
			max-width: 100px;
			max-height: 100px;
			object-fit: contain;
		}
		.logo-upload {
			text-align: center;
		}
		.logo-upload small {
			display: block;
			color: var(--text-muted);
			font-size: 0.78rem;
			margin-bottom: 12px;
		}
		.logo-upload .btn {
			width: 100%;
		}
		.verification-badge {
			display: inline-block;
			padding: 6px 12px;
			background: #ecfdf5;
			color: #047857;
			border: 1px solid #a7f3d0;
			border-radius: 30px;
			font-size: 0.78rem;
			font-weight: 700;
			margin-bottom: 1rem;
		}
		.verification-info {
			color: var(--text-body);
			font-size: 0.9rem;
			line-height: 1.6;
		}
		.verification-info code {
			display: inline-block;
			margin-top: 4px;
			padding: 3px 7px;
			background: #f1f5f9;
			color: var(--text-main);
			border-radius: 5px;
		}
		.verification-date {
			color: var(--text-muted);
			font-size: 0.8rem;
			margin-top: 12px;
		}
		.form-actions {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			padding-top: 1.5rem;
			margin-top: 1.5rem;
			border-top: 1px solid var(--card-border);
		}
		@media (max-width: 1000px) {
			.profile-grid {
				grid-template-columns: 1fr;
			}
		}
		@media (max-width: 700px) {
			.form-row {
				grid-template-columns: 1fr;
				gap: 0;
			}
			.form-actions {
				flex-direction: column-reverse;
			}
			.form-actions .btn {
				width: 100%;
			}
		}
	</style>
</head>
<body>
<?php
$activePage = 'profile';
require __DIR__ . '/partials/company_navbar.php';
?>
<header class="top-header">
	<div class="user-profile" id="userProfile">
		<button type="button" class="user-profile-button" onclick="toggleProfileDropdown()">
			<img src="public/images/logo.png" alt="Company" class="user-avatar">
			<span class="user-name">
				<?php echo htmlspecialchars($company['company_name'] ?? 'Company Account'); ?>
			</span>
			<span class="user-arrow">▼</span>
		</button>
		<div class="profile-dropdown" id="profileDropdown">
			<div class="dropdown-user">
				<img src="public/images/logo.png" alt="Company">
				<div class="dropdown-user-info">
					<strong>
						<?php echo htmlspecialchars($company['company_name'] ?? 'Company Account'); ?>
					</strong>
					<span>
						<?php echo htmlspecialchars($company['email'] ?? 'Company Account'); ?>
					</span>
				</div>
			</div>
			<a href="index.php?action=company_profile">Company Profile</a>
			<a href="index.php?action=public_company_profile">View Public Profile</a>
			<a href="index.php?action=logout" class="dropdown-logout">Logout</a>
		</div>
	</div>
</header>
<main class="container">
	<div class="page-header">
		<div>
			<h1>Company Profile</h1>
			<p>Manage your company information and public profile.</p>
		</div>
		<a href="index.php?action=public_company_profile" class="btn btn-secondary">
			View Public Profile
		</a>
	</div>
	<form action="index.php?action=update_company_profile" method="POST" enctype="multipart/form-data">
		<div class="profile-grid">
			<div class="section-card">
				<h2>General Organization Details</h2>
				<div class="form-group">
					<label for="company_name">Official Company Name</label>
					<input
						type="text"
						id="company_name"
						name="company_name"
						value="<?php echo htmlspecialchars($company['company_name'] ?? ''); ?>"
						required
					>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="industry">Industry Sector</label>
						<select id="industry" name="industry" required>
							<option value="">Select Industry</option>
							<option value="IT & Software">IT & Software Development</option>
							<option value="Banking & Finance">Banking & Finance</option>
							<option value="Telecommunications">Telecommunications</option>
							<option value="Manufacturing">Manufacturing</option>
							<option value="Education">Education</option>
							<option value="Healthcare">Healthcare</option>
							<option value="Other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="company_size">Company Size</label>
						<select id="company_size" name="company_size" required>
							<option value="">Select Company Size</option>
							<option value="1-10">1 - 10 Employees</option>
							<option value="11-50">11 - 50 Employees</option>
							<option value="51-200">51 - 200 Employees</option>
							<option value="201-500">201 - 500 Employees</option>
							<option value="500+">500+ Employees</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="primary_email">Primary Business Email</label>
						<input
							type="email"
							id="primary_email"
							name="email"
							value="<?php echo htmlspecialchars($company['email'] ?? ''); ?>"
							required
						>
					</div>
					<div class="form-group">
						<label for="phone">Contact Phone</label>
						<input
							type="tel"
							id="phone"
							name="phone"
							value="<?php echo htmlspecialchars($company['phone'] ?? ''); ?>"
							required
						>
					</div>
				</div>
				<div class="form-group">
					<label for="location">Head Office Address / Location</label>
					<input
						type="text"
						id="location"
						name="location"
						value="<?php echo htmlspecialchars($company['location'] ?? ''); ?>"
						required
					>
				</div>
				<div class="form-group">
					<label for="bio">About Company</label>
					<textarea
						id="bio"
						name="bio"
						required
					><?php echo htmlspecialchars($company['bio'] ?? ''); ?></textarea>
				</div>
				<h2>Web & Social Media Links</h2>
				<div class="form-group">
					<label for="website">Company Website URL</label>
					<input
						type="url"
						id="website"
						name="website"
						value="<?php echo htmlspecialchars($company['website'] ?? ''); ?>"
						placeholder="https://www.example.com"
					>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label for="linkedin">LinkedIn Page</label>
						<input
							type="url"
							id="linkedin"
							name="linkedin"
							value="<?php echo htmlspecialchars($company['linkedin'] ?? ''); ?>"
							placeholder="https://linkedin.com/company/example"
						>
					</div>
					<div class="form-group">
						<label for="facebook">Facebook Page</label>
						<input
							type="url"
							id="facebook"
							name="facebook"
							value="<?php echo htmlspecialchars($company['facebook'] ?? ''); ?>"
							placeholder="https://facebook.com/example"
						>
					</div>
				</div>
			</div>
			<div class="profile-side">
				<div class="section-card">
					<h2>Company Logo</h2>
					<div class="logo-upload">
						<div class="logo-preview-box">
							<img src="public/images/logo.png" alt="Company Logo" id="logoPreview">
						</div>
						<small>PNG, JPG or SVG. Maximum file size 2MB.</small>
						<input
							type="file"
							id="logo_upload"
							name="company_logo"
							accept="image/png,image/jpeg,image/svg+xml"
							hidden
						>
						<button
							type="button"
							class="btn btn-secondary"
							onclick="document.getElementById('logo_upload').click()"
						>
							Upload New Logo
						</button>
					</div>
				</div>
				<div class="section-card">
					<h2>Verification Status</h2>
					<span class="verification-badge">
						✓ Verified Employer
					</span>
					<div class="verification-info">
						<strong>PV / BR Number</strong><br>
						<code>
							<?php echo htmlspecialchars($company['registration_number'] ?? 'Not available'); ?>
						</code>
					</div>
					<p class="verification-date">
						Your business registration has been verified by CareerConnect.
					</p>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<a href="index.php?action=company_dashboard" class="btn btn-secondary">
				Cancel
			</a>
			<button type="submit" class="btn">
				Save Profile Changes
			</button>
		</div>
	</form>
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
	if (!profile.contains(event.target)) {
		dropdown.classList.remove('show');
		profile.classList.remove('open');
	}
});
// Company logo preview
document.getElementById('logo_upload').addEventListener('change', function(event) {
	const file = event.target.files[0];
	if (file) {
		document.getElementById('logoPreview').src = URL.createObjectURL(file);
	}
});
</script>
</body>
</html>