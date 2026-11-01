<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pending Approval - CareerConnect</title>

	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 24px;
			font-family: Arial, sans-serif;
			background: #f3f6fa;
			color: #1e293b;
		}

		.approval-card {
			width: 100%;
			max-width: 540px;
			padding: 40px 32px;
			background: #ffffff;
			border: 1px solid #dbe3ec;
			border-radius: 16px;
			text-align: center;
		}

		.logo {
			display: block;
			width: 180px;
			max-width: 100%;
			height: auto;
			margin: 0 auto 28px;
		}

		.status-label {
			display: inline-block;
			padding: 8px 16px;
			margin-bottom: 20px;
			border: 1px solid #f5d48a;
			border-radius: 24px;
			background: #fff7e6;
			color: #875600;
			font-size: 14px;
			font-weight: 600;
		}

		h1 {
			margin: 0 0 16px;
			font-size: 28px;
			line-height: 1.3;
		}

		p {
			margin: 0 0 16px;
			color: #64748b;
			font-size: 15px;
			line-height: 1.7;
		}

		.approval-info {
			margin: 24px 0;
			padding: 18px;
			border: 1px solid #dbe3ec;
			border-radius: 10px;
			background: #f8fafc;
		}

		.approval-info p {
			margin: 0;
			color: #475569;
		}

		.login-button {
			display: inline-block;
			padding: 12px 24px;
			border: 1px solid #2563eb;
			border-radius: 8px;
			background: #2563eb;
			color: #ffffff;
			text-decoration: none;
			font-size: 15px;
			font-weight: 600;
		}

		.login-button:hover {
			background: #1d4ed8;
			border-color: #1d4ed8;
		}

		.login-button:focus-visible {
			outline: 3px solid #93c5fd;
			outline-offset: 4px;
		}

		.footer-text {
			margin: 24px 0 0;
			font-size: 13px;
		}

		@media (max-width: 480px) {
			.approval-card {
				padding: 32px 20px;
			}

			h1 {
				font-size: 24px;
			}
		}
	</style>
</head>

<body>
	<main class="approval-card">

		<img
			src="/CareerConnect/public/images/logo2.png"
			alt="CareerConnect"
			class="logo"
		>

		<?php $isRejected = ($status ?? '') === 'rejected' || !empty($rejectionNotice); ?>
		<div class="status-label" style="<?php echo $isRejected ? 'background:#fef2f2; color:#991b1b; border-color:#fca5a5;' : ''; ?>">
			<?php echo $isRejected ? 'Registration Rejected' : 'Pending Approval'; ?>
		</div>

		<h1><?php echo $isRejected ? 'Application Rejected' : 'Your Account Is Awaiting Approval'; ?></h1>

		<p>
			<?php if ($isRejected): ?>
				Your application was reviewed and could not be approved by the administrator.
			<?php else: ?>
				Your registration has been received. An administrator will review
				your account before you can access your dashboard.
			<?php endif; ?>
		</p>

		<?php if ($isRejected && !empty($rejectionNotice)): ?>
			<div class="approval-info" style="border-color: #fca5a5; background: #fff5f5; text-align: left;">
				<div style="font-size: 12px; font-weight: 700; color: #991b1b; text-transform: uppercase; margin-bottom: 4px;">Admin Feedback / Reason:</div>
				<p style="color: #7f1d1d; font-size: 14px;"><?php echo htmlspecialchars($rejectionNotice); ?></p>
			</div>
		<?php else: ?>
			<div class="approval-info">
				<p>
					Once your account is approved, you can log in using your
					registered email address and password.
				</p>
			</div>
		<?php endif; ?>

		<a href="/CareerConnect/index.php?action=login" class="login-button">
			Return to Login
		</a>

		<p class="footer-text">
			Thank you for joining CareerConnect.
		</p>

	</main>
</body>
</html>