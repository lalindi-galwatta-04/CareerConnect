<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - CareerConnect Coach</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.0">
    <style>

    /* Dynamic item container styled for light theme background */
    .dynamic-item {
        display: grid;
        grid-template-columns: 2fr 1.5fr auto auto;
        gap: 0.75rem;
        align-items: center;
        margin-bottom: 0.75rem;
        background: #ffffff;
        padding: 0.625rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    /* Fixed "+ Add..." action buttons matching primary dark navy theme */
    .btn-add-item {
        background: #0f172a;
        color: #ffffff;
        border: 1px dashed #334155;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        width: 100%;
        margin-top: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-add-item:hover {
        background: #1e293b;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Soft Indigo/Purple Edit Button */
    .btn-edit-item {
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
        border-radius: 6px;
        padding: 0.45rem 0.85rem;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-edit-item:hover {
        background: #4f46e5;
        color: #ffffff;
        border-color: #4f46e5;
    }

    /* Soft Red Delete/Remove Button */
    .btn-remove-item {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 6px;
        padding: 0.45rem 0.85rem;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-remove-item:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    /* Readonly inputs styled for clean dark text readability */
    .input-readonly {
        background: transparent !important;
        border-color: transparent !important;
        color: #0f172a !important;
        font-weight: 500;
        pointer-events: none;
    }

    /* Input text color for light theme */
    .dynamic-item .input-field {
        color: #0f172a;
    }

    /* Custom styling for Coaching Mode dropdown select */
    .select-field {
        width: 100%;
        padding: 0.75rem;
        background-color: #ffffff;
        color: #0f172a;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.95rem;
        outline: none;
    }

    .select-field option {
        background-color: #ffffff;
        color: #0f172a;
    }
    .profile-page {
    width: calc(100% - 260px);
    max-width: none;
    margin-left: 260px;
    padding: 5rem 3rem 3rem;
    box-sizing: border-box;
}

.profile-page > .card {
    width: 100%;
    max-width: 1000px !important;
    margin: 0 auto;
}
</style>
</head>
<body>
    <header class="top-header">
        <div class="user-profile" id="userProfile">
            <button type="button" class="user-profile-button" onclick="toggleProfileDropdown()">
                <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
                    <?php 
                        $displayName =$coachName ?? $coach['full_name'] ?? $coach['coach_name'] ?? 'Coach';
                        echo htmlspecialchars(strtoupper(substr($displayName, 0, 1))); 
                    ?>
                </div>

                <span class="user-name">
                    <?php echo htmlspecialchars($displayName); ?>
                </span>

                <span class="user-arrow">▼</span>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-user">
                    <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
                        <?php echo htmlspecialchars(strtoupper(substr($displayName, 0, 1))); ?>
                    </div>

                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($displayName); ?></strong>
                        <span><?php echo htmlspecialchars($coach['email'] ?? $_SESSION['user']['email'] ?? ''); ?></span>
                    </div>
                </div>

                <a href="index.php?action=coach_profile">Profile</a>
                <a href="index.php?action=logout" class="dropdown-logout">Logout</a>
            </div>
        </div>
    </header>

    <?php
$activePage = 'profile';
require __DIR__ . '/partials/coach_navbar.php';
?>

<div class="container profile-page">
          <div class="card auth-card" style="max-width: 100%;">
            <h2>Manage Coach Profile</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem; text-align: center;">
                Update your personal details, qualifications, certifications, skills, and session rates.
            </p>

            <form action="index.php?action=coach_profile" method="POST">
                
                <!-- Full Name & Display Title -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($coach['full_name'] ?? $coach['coach_name'] ?? ''); ?>" placeholder="e.g. Dr. Jane Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Display Title / Tagline</label>
                        <input type="text" name="display_title" value="<?php echo htmlspecialchars($coach['display_title'] ?? ''); ?>" placeholder="e.g. Senior Executive Coach & Career Strategist" required>
                    </div>
                </div>

                <!-- Workplace & Experience -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Current Workplace / Organization</label>
                        <input type="text" name="workplace" value="<?php echo htmlspecialchars($coach['workplace'] ?? ''); ?>" placeholder="e.g. Apex Global Solutions / Independent Coach" required>
                    </div>
                    <div class="form-group">
                        <label>Overall Experience (Years)</label>
                        <input type="number" min="0" max="60" name="experience_years" value="<?php echo htmlspecialchars($coach['experience_years'] ?? '0'); ?>" required>
                    </div>
                </div>

                <!-- Specialization & Hourly Rate (LKR) -->
                <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Primary Specialization</label>
                        <input type="text" name="specialization" value="<?php echo htmlspecialchars($coach['specialization'] ?? ''); ?>" placeholder="e.g. Leadership & Executive Coaching" required>
                    </div>
                    <div class="form-group">
                        <label>Hourly Rate (LKR / Rs.)</label>
                        <input type="number" step="50.00" min="0" name="hourly_rate" value="<?php echo htmlspecialchars($coach['hourly_rate'] ?? '2500.00'); ?>" placeholder="e.g. 5000.00" required>
                    </div>
                </div>

                <!-- Mode & Portfolio Link -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Coaching Mode</label>
                        <select name="coaching_mode" class="form-control select-field">
                            <option value="Online / Remote" <?php echo ($coach['coaching_mode'] ?? '') === 'Online / Remote' ? 'selected' : ''; ?>>Online / Remote</option>
                            <option value="In-Person" <?php echo ($coach['coaching_mode'] ?? '') === 'In-Person' ? 'selected' : ''; ?>>In-Person</option>
                            <option value="Hybrid (Both)" <?php echo ($coach['coaching_mode'] ?? '') === 'Hybrid (Both)' ? 'selected' : ''; ?>>Hybrid (Both)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>LinkedIn Profile / Portfolio Link</label>
                        <input type="url" name="linkedin_url" value="<?php echo htmlspecialchars($coach['linkedin_url'] ?? ''); ?>" placeholder="https://linkedin.com/in/username">
                    </div>
                </div>

                <!-- Professional Bio -->
                <div class="form-group">
                    <label>Professional Bio</label>
                    <textarea name="bio" rows="4" placeholder="Introduce yourself, your coaching philosophy, and how you assist clients..." required><?php echo htmlspecialchars($coach['bio'] ?? ''); ?></textarea>
                </div>

                <!-- Academic Qualifications -->
                <div class="form-group" style="margin-top: 1.5rem;">
                    <div class="section-header">
                        <label style="margin-bottom: 0;">Academic Qualifications</label>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Manage your degrees and diplomas</span>
                    </div>

                    <div id="qualificationsContainer">
                        <?php 
                        $qualificationsList =$coach['qualifications'] ?? [];
                        if (is_string($qualificationsList)) {
                            $qualificationsList = json_decode($qualificationsList, true) ?? [];
                        }

                        if (!empty($qualificationsList) && is_array($qualificationsList)):
                            foreach ($qualificationsList as$qual):
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field input-readonly" readonly name="qualifications_title[]" value="<?php echo htmlspecialchars($qual['title'] ?? ''); ?>" placeholder="Degree/Diploma Title (e.g. B.Sc. in Business Administration)" required>
                                <input type="text" class="input-field input-readonly" readonly name="qualifications_institute[]" value="<?php echo htmlspecialchars($qual['institute'] ?? ''); ?>" placeholder="University / Institute" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Edit</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('qualificationsContainer', this)">Delete</button>
                            </div>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field" name="qualifications_title[]" placeholder="Degree/Diploma Title (e.g. B.Sc. in Business Administration)" required>
                                <input type="text" class="input-field" name="qualifications_institute[]" placeholder="University / Institute" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('qualificationsContainer', this)">Delete</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn" onclick="addQualificationRow()">+ Add Qualification</button>
                </div>

                <!-- Professional Certifications -->
                <div class="form-group" style="margin-top: 1.5rem;">
                    <div class="section-header">
                        <label style="margin-bottom: 0;">Professional Certifications</label>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Manage your industry licenses and certificates</span>
                    </div>

                    <div id="certificationsContainer">
                        <?php 
                        $certificationsList =$coach['certifications'] ?? [];
                        if (is_string($certificationsList)) {
                            $certificationsList = json_decode($certificationsList, true) ?? [];
                        }

                        if (!empty($certificationsList) && is_array($certificationsList)):
                            foreach ($certificationsList as$cert):
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field input-readonly" readonly name="certifications_title[]" value="<?php echo htmlspecialchars($cert['title'] ?? ''); ?>" placeholder="Certification Name (e.g. Associate Certified Coach)" required>
                                <input type="text" class="input-field input-readonly" readonly name="certifications_body[]" value="<?php echo htmlspecialchars($cert['issuing_body'] ?? ''); ?>" placeholder="Issuing Organization (e.g. ICF)" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Edit</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('certificationsContainer', this)">Delete</button>
                            </div>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field" name="certifications_title[]" placeholder="Certification Name (e.g. Associate Certified Coach)" required>
                                <input type="text" class="input-field" name="certifications_body[]" placeholder="Issuing Organization (e.g. ICF)" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('certificationsContainer', this)">Delete</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn" onclick="addCertificationRow()">+ Add Certification</button>
                </div>

                <!-- Skills & Experience Breakdown -->
                <div class="form-group" style="margin-top: 1.5rem;">
                    <div class="section-header">
                        <label style="margin-bottom: 0;">Skills & Experience Breakdown</label>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Manage your key competencies and experience years</span>
                    </div>
                    
                    <div id="skillsContainer">
                        <?php 
                        $skillsList =$coach['skills'] ?? [];
                        if (is_string($skillsList)) {
                            $skillsList = json_decode($skillsList, true) ?? [];
                        }

                        if (!empty($skillsList) && is_array($skillsList)):
                            foreach ($skillsList as$skill):
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field input-readonly" readonly name="skills_name[]" value="<?php echo htmlspecialchars($skill['name'] ?? ''); ?>" placeholder="Skill Name (e.g. Interview Preparation)" required>
                                <input type="number" class="input-field input-readonly" readonly name="skills_exp[]" value="<?php echo htmlspecialchars($skill['experience'] ?? '1'); ?>" placeholder="Years Exp" min="1" max="50" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Edit</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('skillsContainer', this)">Delete</button>
                            </div>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                            <div class="dynamic-item">
                                <input type="text" class="input-field" name="skills_name[]" placeholder="Skill Name (e.g. Interview Preparation)" required>
                                <input type="number" class="input-field" name="skills_exp[]" placeholder="Years Exp" value="3" min="1" max="50" required>
                                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                                <button type="button" class="btn-remove-item" onclick="removeRow('skillsContainer', this)">Delete</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn" onclick="addSkillRow()">+ Add Skill & Experience</button>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 2rem;">Save Profile Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle Profile Dropdown Menu
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        }

        // Close Profile Dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const userProfile = document.getElementById('userProfile');
            const dropdown = document.getElementById('profileDropdown');
            if (userProfile && dropdown && !userProfile.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Toggle Edit/Save Mode per Row
        function toggleEditRow(button) {
            const row = button.closest('.dynamic-item');
            const inputs = row.querySelectorAll('input');

            if (button.innerText === 'Edit') {
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.classList.remove('input-readonly');
                });
                inputs[0].focus();
                button.innerText = 'Save';
            } else {
                let allValid = true;
                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        allValid = false;
                    }
                });

                if (allValid) {
                    inputs.forEach(input => {
                        input.setAttribute('readonly', true);
                        input.classList.add('input-readonly');
                    });
                    button.innerText = 'Edit';
                }
            }
        }

        // Generic Remove Row Handler
        function removeRow(containerId, button) {
            const container = document.getElementById(containerId);
            if (container.children.length > 1) {
                button.closest('.dynamic-item').remove();
            } else {
                alert('You must keep at least one entry in this section.');
            }
        }

        // Add Qualification
        function addQualificationRow() {
            const container = document.getElementById('qualificationsContainer');
            const div = document.createElement('div');
            div.className = 'dynamic-item';
            div.innerHTML = `
                <input type="text" class="input-field" name="qualifications_title[]" placeholder="Degree/Diploma Title (e.g. B.Sc. in Business Administration)" required>
                <input type="text" class="input-field" name="qualifications_institute[]" placeholder="University / Institute" required>
                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                <button type="button" class="btn-remove-item" onclick="removeRow('qualificationsContainer', this)">Delete</button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Add Certification
        function addCertificationRow() {
            const container = document.getElementById('certificationsContainer');
            const div = document.createElement('div');
            div.className = 'dynamic-item';
            div.innerHTML = `
                <input type="text" class="input-field" name="certifications_title[]" placeholder="Certification Name (e.g. Associate Certified Coach)" required>
                <input type="text" class="input-field" name="certifications_body[]" placeholder="Issuing Organization (e.g. ICF)" required>
                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                <button type="button" class="btn-remove-item" onclick="removeRow('certificationsContainer', this)">Delete</button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }

        // Add Skill
        function addSkillRow() {
            const container = document.getElementById('skillsContainer');
            const div = document.createElement('div');
            div.className = 'dynamic-item';
            div.innerHTML = `
                <input type="text" class="input-field" name="skills_name[]" placeholder="Skill Name (e.g. Interview Preparation)" required>
                <input type="number" class="input-field" name="skills_exp[]" placeholder="Years Exp" value="1" min="1" max="50" required>
                <button type="button" class="btn-edit-item" onclick="toggleEditRow(this)">Save</button>
                <button type="button" class="btn-remove-item" onclick="removeRow('skillsContainer', this)">Delete</button>
            `;
            container.appendChild(div);
            div.querySelector('input').focus();
        }
    </script>
</body>
</html>