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

            <?php if (isset($error) && !empty($error)): ?>
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