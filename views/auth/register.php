<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 500px;
            padding: 30px 20px;
            margin: 0 auto;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 2.5rem;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 1.25rem;
        }

        .auth-logo img {
            max-width: 190px;
            height: auto;
        }

        .auth-card h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.4rem;
            text-align: center;
        }

        .auth-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.92rem;
            margin-bottom: 1.5rem;
        }

        .auth-form-group {
            margin-bottom: 1.15rem;
        }

        .auth-form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            color: #334155;
            margin-bottom: 0.35rem;
        }

        .auth-form-group input,
        .auth-form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            box-sizing: border-box;
            background: #ffffff;
        }

        .auth-form-group input:focus,
        .auth-form-group select:focus {
            outline: none;
            border-color: #065fd5;
            box-shadow: 0 0 0 3px rgba(6, 95, 213, 0.15);
        }
    </style>
</head>

<body>

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="auth-logo">
            <img src="public/images/logo2.png" alt="CareerConnect">
        </div>

        <h2>Create an Account</h2>

        <p class="auth-subtitle">
            Join the CareerConnect career & training ecosystem
        </p>

        <?php if (isset($error) && !empty($error)): ?>

            <div class="alert" style="background:#fee2e2;color:#991b1b;border:1px solid #f87171;padding:12px;border-radius:8px;margin-bottom:1.25rem;font-size:0.9rem;font-weight:600;">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form action="index.php?action=register" method="POST" enctype="multipart/form-data">

            <div class="auth-form-group">

                <label>
                    Email Address
                    <span style="color:#dc2626;">*</span>
                </label>

                <input type="email" name="email" required placeholder="name@domain.com">

            </div>

            <div class="auth-form-group">

                <label>
                    Password
                    <span style="color:#dc2626;">*</span>
                </label>

                <input type="password" name="password" required placeholder="••••••••">

            </div>

            <div class="auth-form-group">

                <label>
                    Phone Number
                    <span style="color:#dc2626;">*</span>
                </label>

                <input type="text" name="phone_number" required placeholder="e.g. 0771234567">

            </div>

            <div class="auth-form-group">

                <label>
                    Account Type / Role
                    <span style="color:#dc2626;">*</span>
                </label>

                <select name="user_type" id="user_type" onchange="toggleProfileFields()" required>

                    <option value="">Select Role</option>
                    <option value="job_seeker">Job Seeker</option>
                    <option value="career_coach">Career Coach</option>
                    <option value="company">Company</option>
                    <option value="training_provider">Training Provider</option>

                </select>

            </div>


            <!-- Job Seeker Fields -->

            <div id="job_seeker_fields" style="display:none;">

                <div class="auth-form-group">

                    <label>
                        First Name
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="first_name" placeholder="John">

                </div>

                <div class="auth-form-group">

                    <label>
                        Last Name
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="last_name" placeholder="Doe">

                </div>

            </div>


            <!-- Career Coach Fields -->

            <div id="coach_fields" style="display:none;">

                <div class="auth-form-group">

                    <label>
                        Career Coach Name
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="coach_name" placeholder="Enter your name">

                </div>

                <div class="auth-form-group">

                    <label>
                        Specialization
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="specialization" placeholder="e.g. IT Career Guidance">

                </div>

                <div class="auth-form-group">

                    <label>
                        Verification Document
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="file" name="coach_document" accept=".pdf,.jpg,.jpeg,.png">

                </div>

                <div style="display:flex;align-items:flex-start;gap:12px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 14px;margin-bottom:1.15rem;">

                    <div style="width:22px;height:22px;min-width:22px;border-radius:50%;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;">
                        i
                    </div>

                    <div>

                        <strong style="display:block;color:#92400e;font-size:13px;margin-bottom:2px;">
                            Administrator approval required
                        </strong>

                        <p style="margin:0;color:#a16207;font-size:12px;line-height:1.5;">
                            Your account must be approved before you can access the Career Coach dashboard.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Company Fields -->

            <div id="company_fields" style="display:none;">

                <div class="auth-form-group">

                    <label>
                        Company Name
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="company_name" placeholder="e.g. TechCorp Solutions">

                </div>

                <div class="auth-form-group">

                    <label>
                        Industry
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="industry" placeholder="e.g. Information Technology">

                </div>

                <div class="auth-form-group">

                    <label>
                        Registration Number
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="company_registration_number" placeholder="Enter registration number">

                </div>

                <div class="auth-form-group">

                    <label>
                        Registration Document
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="file" name="company_document" accept=".pdf,.jpg,.jpeg,.png">

                </div>

                <div style="display:flex;align-items:flex-start;gap:12px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 14px;margin-bottom:1.15rem;">

                    <div style="width:22px;height:22px;min-width:22px;border-radius:50%;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;">
                        i
                    </div>

                    <div>

                        <strong style="display:block;color:#92400e;font-size:13px;margin-bottom:2px;">
                            Administrator approval required
                        </strong>

                        <p style="margin:0;color:#a16207;font-size:12px;line-height:1.5;">
                            Your account must be approved before you can access the Company dashboard.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Training Provider Fields -->

            <div id="provider_fields" style="display:none;">

                <div class="auth-form-group">

                    <label>
                        Institution / Provider Name
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="provider_name" placeholder="e.g. Apex IT Academy">

                </div>

                <div class="auth-form-group">

                    <label>
                        Registration Number
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="text" name="provider_registration_number" placeholder="Enter registration number">

                </div>

                <div class="auth-form-group">

                    <label>
                        Registration Document
                        <span style="color:#dc2626;">*</span>
                    </label>

                    <input type="file" name="provider_document" accept=".pdf,.jpg,.jpeg,.png">

                </div>

                <div style="display:flex;align-items:flex-start;gap:12px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 14px;margin-bottom:1.15rem;">

                    <div style="width:22px;height:22px;min-width:22px;border-radius:50%;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;">
                        i
                    </div>

                    <div>

                        <strong style="display:block;color:#92400e;font-size:13px;margin-bottom:2px;">
                            Administrator approval required
                        </strong>

                        <p style="margin:0;color:#a16207;font-size:12px;line-height:1.5;">
                            Your account must be approved before you can access the Training Provider dashboard.
                        </p>

                    </div>

                </div>

            </div>


            <button type="submit" class="btn" style="width:100%;padding:12px;font-size:1rem;font-weight:700;border-radius:8px;background:#065fd5;color:#ffffff;border:none;cursor:pointer;margin-top:0.5rem;">
                Create Account
            </button>

        </form>

        <p style="margin-top:1.5rem;text-align:center;color:#64748b;font-size:0.92rem;margin-bottom:0;">

            Already have an account?

            <a href="index.php?action=login" style="color:#065fd5;font-weight:700;text-decoration:none;">
                Login here
            </a>

        </p>

    </div>

</div>


<script>

function toggleProfileFields() {

    const type = document.getElementById('user_type').value;

    const sections = {
        job_seeker: 'job_seeker_fields',
        career_coach: 'coach_fields',
        company: 'company_fields',
        training_provider: 'provider_fields'
    };

    Object.values(sections).forEach(id => {

        const section = document.getElementById(id);

        section.style.display = 'none';

        section.querySelectorAll('input').forEach(input => {
            input.required = false;
        });

    });

    if (sections[type]) {

        const selectedSection = document.getElementById(sections[type]);

        selectedSection.style.display = 'block';

        selectedSection.querySelectorAll('input').forEach(input => {
            input.required = true;
        });

    }

}

document.addEventListener('DOMContentLoaded', toggleProfileFields);

</script>

</body>
</html>