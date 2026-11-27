<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
    <style>
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

<?php
$activePage = 'profile';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>

<div class="container">
    <div class="welcome-card" style="width: 100%;">
        <div>
            <h1>My Profile</h1>
            <p>View your personal information and professional background.</p>
        </div>
        <div>
            <a href="index.php?action=edit_jobseeker_profile" class="btn">Edit Profile</a>
        </div>
    </div>

    <!-- Personal & Professional Details Section -->
    <div class="section-card" style="width: 100%; margin-top: 1.5rem;">
        <h2>Personal Details</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
            
            <!-- First Name -->
            <div class="form-group">
                <label>First Name</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000;">
                    <?php 
                        $fullNameParts = !empty($profile['full_name']) ? explode(' ', trim($profile['full_name'])) : array();
                        $firstName = !empty($profile['first_name']) ? $profile['first_name'] : (!empty($fullNameParts) ? $fullNameParts[0] : '');
                        echo htmlspecialchars(!empty($firstName) ? $firstName : 'Not provided');
                    ?>
                </div>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label>Last Name</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000;">
                    <?php 
                        $nameParts = !empty($profile['full_name']) ? explode(' ', trim($profile['full_name']), 2) : array();
                        $lastName = !empty($profile['last_name']) ? $profile['last_name'] : (count($nameParts) > 1 ? $nameParts[1] : '');
                        echo htmlspecialchars(!empty($lastName) ? $lastName : 'Not provided');
                    ?>
                </div>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label>Email Address</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000;">
                    <?php echo htmlspecialchars(isset($profile['email']) ? $profile['email'] : (isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A')); ?>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label>Phone Number</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000;">
                    <?php 
                        $phone = !empty($profile['phone_number']) ? $profile['phone_number'] : (!empty($profile['phone']) ? $profile['phone'] : '');
                        echo htmlspecialchars(!empty($phone) ? $phone : 'Not provided');
                    ?>
                </div>
            </div>

            <!-- Education Level -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Education Level</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000;">
                    <?= htmlspecialchars(!empty($profile['education_level']) ? $profile['education_level'] : 'Not provided') ?>
                </div>
            </div>

            <!-- Skills & Competencies -->
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Skills & Competencies</label>
                <div style="padding: 0.85rem 1rem; background-color: var(--input-bg); border: 1.5px solid var(--input-border); border-radius: 12px; color: #070000; min-height: 80px;">
                    <?= nl2br(htmlspecialchars(!empty($profile['skills']) ? $profile['skills'] : 'No skills added yet.')) ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Work Experience Section -->
    <div class="section-card" style="width: 100%; margin-top: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 0.6rem; margin-bottom: 1.25rem;">
            <h2 style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">Work Experience</h2>
        </div>

        <?php if (empty($work_experiences)): ?>
            <p style="color: var(--text-muted); margin-top: 1rem;">No work experience recorded yet.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Job Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($work_experiences as $exp): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($exp['company_name']) ?></strong></td>
                        <td><?= htmlspecialchars(isset($exp['job_title']) ? $exp['job_title'] : 'N/A') ?></td>
                        <td><?= date('m/d/Y', strtotime($exp['start_date'])) ?></td>
                        <td>
                            <?php if (!empty($exp['end_date'])): ?>
                                <?= date('m/d/Y', strtotime($exp['end_date'])) ?>
                            <?php else: ?>
                                <span class="status status-approved">Present</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>