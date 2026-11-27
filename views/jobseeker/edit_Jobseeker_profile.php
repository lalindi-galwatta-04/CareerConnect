<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate Profile - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">

    <style>
        .btn-remove-skill {
            background-color: rgba(255, 92, 92, 0.15);
            color: #ff5c5c;
            border: 1px solid rgba(255, 92, 92, 0.3);
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-remove-skill:hover {
            background-color: #ff5c5c;
            color: #ffffff;
        }

        .btn-remove-experience {
            background-color: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
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

    <div class="welcome-card">
        <div>
            <h1>Edit Candidate Profile</h1>
            <p>Update your personal information, skills, and work history.</p>
        </div>
    </div>

    <form action="index.php?action=edit_jobseeker_profile" method="POST">

        <!-- Personal Details -->
        <div class="section-card">
            <h2>Personal Details</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1rem;">

                <div class="form-group">
                    <label>First Name</label>
                    <input
                        type="text"
                        name="first_name"
                        value="<?php echo htmlspecialchars(!empty($profile['first_name']) ? $profile['first_name'] : (!empty($profile['full_name']) ? current(explode(' ', $profile['full_name'])) : '')); ?>"
                        class="form-control"
                        placeholder="John"
                    >
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input
                        type="text"
                        name="last_name"
                        value="<?= htmlspecialchars(!empty($profile['last_name']) ? $profile['last_name'] : (!empty($profile['full_name']) ? ltrim(strrchr(trim($profile['full_name']), ' '), ' ') : '')) ?>"
                        class="form-control"
                        placeholder="Doe"
                    >
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input
                        type="text"
                        name="phone_number"
                        value="<?= htmlspecialchars(isset($profile['phone_number']) ? $profile['phone_number'] : '') ?>"
                        class="form-control"
                        placeholder="+1234567890"
                    >
                </div>

                <div class="form-group">
                    <label>Education Level</label>
                    <input
                        type="text"
                        name="education_level"
                        value="<?= htmlspecialchars(isset($profile['education_level']) ? $profile['education_level'] : '') ?>"
                        class="form-control"
                        placeholder="e.g. Bachelor's in Computer Science"
                    >
                </div>

            </div>
        </div>

        <!-- Skills -->
        <div class="section-card">

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 0.6rem; margin-bottom: 1.25rem;">
                <h2 style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                    Skills
                </h2>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem;">

                <input
                    type="text"
                    id="skill_input"
                    class="form-control"
                    placeholder="Enter a skill (e.g., PHP, JavaScript, Project Management)"
                    style="width: 100%; max-width: 700px;"
                >

                <button
                    type="button"
                    class="btn"
                    id="add_skill_btn"
                    style="white-space: nowrap; padding: 0.5rem 1rem;"
                >
                    + Add Skill
                </button>

            </div>

            <div class="table-responsive">
                <table class="table" id="skills_table">

                    <thead>
                        <tr>
                            <th style="width: 75%;">Skill</th>
                            <th style="width: 25%; text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody id="skills_table_body"></tbody>

                </table>
            </div>

            <input
                type="hidden"
                name="skills"
                id="skills_hidden_input"
                value="<?= htmlspecialchars(!empty($profile['skills']) ? $profile['skills'] : '') ?>"
            >

        </div>

        <!-- Work Experience -->
        <div class="section-card">

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 0.6rem; margin-bottom: 1.25rem;">

                <h2 style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                    Work Experience
                </h2>

                <button
                    type="button"
                    class="btn"
                    id="add-exp-btn"
                    style="font-size: 0.85rem; padding: 0.5rem 1rem;"
                >
                    + Add Experience
                </button>

            </div>

            <div class="table-responsive">

                <table class="table" id="experience-table">

                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Job Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="width: 80px; text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody id="experience-body">

                        <?php if (!empty($work_experiences)): ?>

                            <?php foreach ($work_experiences as $index => $exp): ?>

                                <tr>

                                    <td>
                                        <input
                                            type="text"
                                            name="experiences[<?= $index ?>][company_name]"
                                            value="<?= htmlspecialchars(isset($exp['company_name']) ? $exp['company_name'] : '') ?>"
                                            required
                                            class="form-control"
                                            placeholder="Company Name"
                                        >
                                    </td>

                                    <td>
                                        <input
                                            type="text"
                                            name="experiences[<?= $index ?>][job_title]"
                                            value="<?= htmlspecialchars(isset($exp['job_title']) ? $exp['job_title'] : '') ?>"
                                            required
                                            class="form-control"
                                            placeholder="Job Title"
                                        >
                                    </td>

                                    <td>
                                        <input
                                            type="date"
                                            name="experiences[<?= $index ?>][start_date]"
                                            value="<?= htmlspecialchars(isset($exp['start_date']) ? $exp['start_date'] : '') ?>"
                                            required
                                            class="form-control"
                                        >
                                    </td>

                                    <td>
                                        <input
                                            type="date"
                                            name="experiences[<?= $index ?>][end_date]"
                                            value="<?= htmlspecialchars(isset($exp['end_date']) ? $exp['end_date'] : '') ?>"
                                            class="form-control"
                                        >
                                    </td>

                                    <td style="text-align: center;">
                                        <button
                                            type="button"
                                            class="btn-remove-experience remove-row-btn"
                                        >
                                            Remove
                                        </button>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <p
                id="no-exp-msg"
                style="color: var(--text-muted); margin-top: 1rem; display: <?= empty($work_experiences) ? 'block' : 'none' ?>;"
            >
                No work experience added yet. Click "+ Add Experience" above to list your past jobs.
            </p>

        </div>

        <!-- Form Actions -->
        <div style="display: flex; gap: 1rem; margin-bottom: 3rem;">

            <button type="submit" class="btn">
                Save Profile Details
            </button>

            <a
                href="index.php?action=view_jobseeker_profile"
                class="btn"
                style="background: #64748b; color: #ffffff;"
            >
                Cancel
            </a>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const skillInput = document.getElementById('skill_input');
    const addSkillBtn = document.getElementById('add_skill_btn');
    const skillsTableBody = document.getElementById('skills_table_body');
    const skillsHiddenInput = document.getElementById('skills_hidden_input');

    let skillsList = [];

    if (skillsHiddenInput.value.trim() !== '') {
        skillsList = skillsHiddenInput.value
            .split(',')
            .map(function (skill) {
                return skill.trim();
            })
            .filter(function (skill) {
                return skill !== '';
            });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function renderSkills() {

        skillsTableBody.innerHTML = '';

        if (skillsList.length === 0) {

            const row = document.createElement('tr');

            row.innerHTML =
                '<td colspan="2" style="text-align: center; color: #64748b; padding: 1.5rem;">' +
                'No skills added yet. Type a skill above and click "+ Add Skill".' +
                '</td>';

            skillsTableBody.appendChild(row);

        } else {

            skillsList.forEach(function (skill, index) {

                const row = document.createElement('tr');

                row.innerHTML =
                    '<td><strong>' + escapeHtml(skill) + '</strong></td>' +
                    '<td style="text-align: center;">' +
                    '<button type="button" class="btn-remove-skill" data-index="' + index + '">' +
                    'Remove' +
                    '</button>' +
                    '</td>';

                skillsTableBody.appendChild(row);

            });

        }

        skillsHiddenInput.value = skillsList.join(', ');

    }

    function addSkill() {

        const value = skillInput.value.trim();

        if (value === '') {
            return;
        }

        const newSkills = value.split(',');

        newSkills.forEach(function (skill) {

            skill = skill.trim();

            if (skill === '') {
                return;
            }

            const exists = skillsList.some(function (existingSkill) {
                return existingSkill.toLowerCase() === skill.toLowerCase();
            });

            if (!exists) {
                skillsList.push(skill);
            }

        });

        skillInput.value = '';
        renderSkills();
        skillInput.focus();

    }

    addSkillBtn.addEventListener('click', function () {
        addSkill();
    });

    skillInput.addEventListener('keydown', function (event) {

        if (event.key === 'Enter') {
            event.preventDefault();
            addSkill();
        }

    });

    skillsTableBody.addEventListener('click', function (event) {

        if (event.target.classList.contains('btn-remove-skill')) {

            const index = parseInt(
                event.target.getAttribute('data-index'),
                10
            );

            skillsList.splice(index, 1);
            renderSkills();

        }

    });

    renderSkills();


    const experienceBody = document.getElementById('experience-body');
    const addExperienceBtn = document.getElementById('add-exp-btn');
    const noExperienceMessage = document.getElementById('no-exp-msg');

    let experienceIndex = experienceBody.children.length;

    function updateExperienceMessage() {

        if (experienceBody.children.length === 0) {
            noExperienceMessage.style.display = 'block';
        } else {
            noExperienceMessage.style.display = 'none';
        }

    }

    addExperienceBtn.addEventListener('click', function () {

        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <input
                    type="text"
                    name="experiences[${experienceIndex}][company_name]"
                    required
                    class="form-control"
                    placeholder="Company Name"
                >
            </td>

            <td>
                <input
                    type="text"
                    name="experiences[${experienceIndex}][job_title]"
                    required
                    class="form-control"
                    placeholder="Job Title"
                >
            </td>

            <td>
                <input
                    type="date"
                    name="experiences[${experienceIndex}][start_date]"
                    required
                    class="form-control"
                >
            </td>

            <td>
                <input
                    type="date"
                    name="experiences[${experienceIndex}][end_date]"
                    class="form-control"
                >
            </td>

            <td style="text-align: center;">
                <button
                    type="button"
                    class="btn-remove-experience remove-row-btn"
                >
                    Remove
                </button>
            </td>
        `;

        experienceBody.appendChild(row);

        experienceIndex++;

        updateExperienceMessage();

    });

    experienceBody.addEventListener('click', function (event) {

        if (event.target.classList.contains('remove-row-btn')) {

            const row = event.target.closest('tr');

            if (row) {
                row.remove();
            }

            updateExperienceMessage();

        }

    });

    updateExperienceMessage();

});
</script>

</body>
</html>