<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - CareerConnect</title>
	<link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="public/images/logo2.png" alt="CareerConnect">
            </div>
            <h2>Welcome Back</h2>
            <p class="auth-subtitle">Sign in to your CareerConnect account</p>

            <?php if (!empty($rejectionNotice)): ?>
                <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: 10px; padding: 16px; margin-bottom: 1.25rem; text-align: left; box-shadow: 0 2px 6px rgba(239,68,68,0.08);">
                    <div style="display: flex; align-items: center; gap: 8px; color: #b91c1c; font-weight: 700; font-size: 0.95rem; margin-bottom: 6px;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>Account Registration Rejected</span>
                    </div>
                    <p style="margin: 0 0 10px 0; color: #7f1d1d; font-size: 0.88rem; line-height: 1.4;">
                        Your registration has been reviewed and rejected by the CareerConnect administration team.
                    </p>
                    <div style="background: #ffffff; border-left: 3px solid #ef4444; border-radius: 4px; padding: 10px 12px; margin-bottom: 8px;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 3px;">Admin Feedback / Reason:</div>
                        <div style="color: #1e293b; font-size: 0.88rem; font-weight: 500;"><?php echo htmlspecialchars($rejectionNotice); ?></div>
                    </div>
                    <p style="margin: 0; color: #991b1b; font-size: 0.8rem;">
                        If you believe this was an error, please re-register with valid verification documents or contact support.
                    </p>
                </div>
            <?php elseif (isset($error) && !empty($error)): ?>
                <div class="alert" style="background:#fee2e2; color:#991b1b; border: 1px solid #f87171; padding: 12px; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 600;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST">
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.9rem; color: #334155; margin-bottom: 0.4rem;">Email Address</label>
                    <input type="email" name="email" required placeholder="name@domain.com" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.9rem; color: #334155; margin-bottom: 0.4rem;">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                </div>
                <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 1rem; font-weight: 700; border-radius: 8px; background: #065fd5; color: #ffffff; border: none; cursor: pointer;">Login to Account</button>
            </form>
            <p style="margin-top: 1.75rem; text-align: center; color: #64748b; font-size: 0.92rem; margin-bottom: 0;">
                Don't have an account? <a href="index.php?action=register" style="color: #065fd5; font-weight: 700; text-decoration: none;">Create an Account</a>
            </p>
        </div>
    </div>
</body>
</html>