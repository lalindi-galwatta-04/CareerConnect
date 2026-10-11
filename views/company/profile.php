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
			box-sizing: border-box;
		}
		.profile-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 20px;
			margin-bottom: 25px;
		}
		.profile-header h1 {
			margin: 0 0 6px 0;
		}
		.profile-header p {
			margin: 0;
			color: var(--text-muted);
		}
		.profile-grid {
			display: grid;
			grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
			gap: 25px;
			align-items: start;
		}
		.profile-card {
			background: #ffffff;
			border: 1px solid #e5e7eb;
			border-radius: 10px;
			padding: 25px;
		}
		.profile-card h3 {
			margin-top: 0;
			margin-bottom: 20px;
			padding-bottom: 10px;
			border-bottom: 1px solid #e5e7eb;
		}
		.profile-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 15px;
		}
		.company-avatar-large {
			width: 100px;
			height: 100px;
			border-radius: 12px;
			background: #f3f4f6;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 36px;
			font-weight: 700;
			margin: 0 auto 15px;
			border: 1px solid #e5e7eb;
		}
		.company-summary {
			text-align: center;
		}
		.company-summary h3 {
			border: none;
			padding: 0;
			margin-bottom: 5px;
		}
		.company-summary p {
			color: var(--text-muted);
			margin: 5px 0;
		}
		.profile-info {
			margin-top: 20px;
			padding-top: 15px;
			border-top: 1px solid #e5e7eb;
		}
		.profile-info-item {
			margin-bottom: 15px;
		}
		.profile-info-item:last-child {
			margin-bottom: 0;
		}
		.profile-info-item strong {
			display: block;
			font-size: 13px;
			margin-bottom: 4px;
		}
		.profile-info-item span {
			color: var(--text-muted);
			font-size: 14px;
			word-break: break-word;
		}
		.form-actions {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			margin-top: 25px;
			padding-top: 20px;
			border-top: 1px solid #e5e7eb;
		}
		.alert {
			margin-bottom: 20px;
		}
		@media (max-width: 1100px) {
			.profile-grid {
				grid-template-columns: 1fr;
			}
		}
		@media (max-width: 700px) {
			.profile-header {
				flex-direction: column;
				align-items: flex-start;
			}
			.profile-row {
				grid-template-columns: 1fr;
			}
			.form-actions {
				flex-wrap: wrap;
			}
		}
	</style>
</head>
<body>
<?php
$companyName = $company['company_name'] ?? 'Company Account';
$activePage = 'profile';
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
					strtoupper(substr($companyName, 0, 1))
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
						strtoupper(substr($companyName, 0, 1))
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
	<div class="profile-page">
		<div class="profile-header">
			<div>
				<h1>Company Profile</h1>
			</div>
			<a
				href="index.php?action=company_dashboard"
				class="btn btn-secondary"
			>
				Back to Dashboard
			</a>
		</div>
		<?php if (isset($error)): ?>
			<div class="alert">
				<?php echo htmlspecialchars($error); ?>
			</div>
		<?php endif; ?>
		<?php if (isset($success)): ?>
			<div class="alert alert-success">
				<?php echo htmlspecialchars($success); ?>
			</div>
		<?php endif; ?>
		<div class="profile-grid">
			<div class="profile-card">
				<h3>General Organization Details</h3>
				<form
					action="index.php?action=company_profile"
					method="POST"
				>
					<div class="form-group">
						<label for="company_name">
							Official Company Name
							<span class="required">*</span>
						</label>
						<input
							type="text"
							id="company_name"
							name="company_name"
							value="<?php echo htmlspecialchars($company['company_name'] ?? ''); ?>"
							placeholder="e.g. ABC Company (Pvt) Ltd"
							required
						>
					</div>
					<div class="profile-row">
						<div class="form-group">
							<label for="industry">
								Industry Sector
								<span class="required">*</span>
							</label>
							<input
								type="text"
								id="industry"
								name="industry"
								value="<?php echo htmlspecialchars($company['industry'] ?? ''); ?>"
								placeholder="e.g. IT & Software"
								required
							>
						</div>
						<div class="form-group">
							<label for="location">
								Head Office Location
							</label>
							<input
								type="text"
								id="location"
								name="location"
								value="<?php echo htmlspecialchars($company['location'] ?? ''); ?>"
								placeholder="e.g. Colombo, Sri Lanka"
							>
						</div>
					</div>
					<div class="form-group">
						<label for="description">
							About Company
						</label>
						<textarea
							id="description"
							name="description"
							rows="6"
							placeholder="Describe your company, its services, mission and working environment..."
						><?php echo htmlspecialchars($company['description'] ?? ''); ?></textarea>
					</div>
					<h3 style="margin-top:30px;">
						Web Information
					</h3>
					<div class="form-group">
						<label for="website">
							Company Website URL
						</label>
						<input
							type="url"
							id="website"
							name="website"
							value="<?php echo htmlspecialchars($company['website'] ?? ''); ?>"
							placeholder="https://www.company.com"
						>
					</div>
					<div class="form-actions">
						<a
							href="index.php?action=company_dashboard"
							class="btn btn-secondary"
						>
							Cancel
						</a>
						<button
							type="submit"
							class="btn"
						>
							Save Profile Changes
						</button>
					</div>
				</form>
			</div>
			<div>
				<div class="profile-card company-summary">
					<div class="company-avatar-large">
						<?php
						echo htmlspecialchars(
							strtoupper(substr($companyName, 0, 1))
						);
						?>
					</div>
					<h3>
						<?php
						echo htmlspecialchars(
							$company['company_name'] ?? 'Company Account'
						);
						?>
					</h3>
					<p>
						<?php
						echo htmlspecialchars(
							$company['industry'] ?? 'Industry not specified'
						);
						?>
					</p>
					<div class="profile-info">
						<div class="profile-info-item">
							<strong>
								Location
							</strong>
							<span>
								<?php
								echo htmlspecialchars(
									$company['location'] ?? 'Not specified'
								);
								?>
							</span>
						</div>
						<div class="profile-info-item">
							<strong>
								Website
							</strong>
							<span>
								<?php
								if (!empty($company['website'])) {
									echo htmlspecialchars($company['website']);
								} else {
									echo 'Not specified';
								}
								?>
							</span>
						</div>
						<?php if (!empty($company['email'])): ?>
							<div class="profile-info-item">
								<strong>
									Account Email
								</strong>
								<span>
									<?php
									echo htmlspecialchars(
										$company['email']
									);
									?>
								</span>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div
					class="profile-card"
					style="margin-top:20px;"
				>
					<h3>
						Profile Information
					</h3>
					<p
						style="font-size:14px;color:var(--text-muted);line-height:1.6;margin-bottom:0;"
					>
						Keep your company information updated so job seekers can
						understand your organization and available opportunities.
					</p>
				</div>
			</div>
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
	if (!profile.contains(event.target)) {
		dropdown.classList.remove('show');
		profile.classList.remove('open');
	}
});
</script>
</body>
</html>