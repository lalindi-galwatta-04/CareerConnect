<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Availability - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.0">
    <style>
        .availability-page {
    width: calc(100% - 260px);
    max-width: none;
    margin-left: 260px;
    padding: 5rem 3rem 3rem;
    box-sizing: border-box;
}
.availability-container {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 2rem;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
}
        @media (max-width: 768px) {
            .availability-container { grid-template-columns: 1fr; }
        }
        .slot-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .slot-badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
        }
        .badge-available { background: rgba(52, 211, 153, 0.2); color: #34d399; }
        .badge-booked { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        
        .action-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
        }
        .btn-edit { color: #38bdf8; border: 1px solid #38bdf8; }
        .btn-delete { color: #ef4444; border: 1px solid #ef4444; }
        .btn-disabled { opacity: 0.4; cursor: not-allowed; border-color: #666; color: #999; }

        /* Custom Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .modal-content {
            background: #f1f1f2;
            padding: 1.8rem;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <header class="top-header">
    <div class="user-profile" id="userProfile">
        <button type="button" class="user-profile-button" onclick="toggleProfileDropdown()">
            <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
                <?php 
                    $displayName = $coachName ?? $coach['full_name'] ?? $coach['coach_name'] ?? 'Coach';
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

            <a href="index.php?action=coach_profile">My Profile</a>
            <a href="index.php?action=logout" class="dropdown-logout">Logout</a>
        </div>
    </div>
</header>
<?php
$activePage = 'availability';
require __DIR__ . '/partials/coach_navbar.php';
?>
   <div class="container availability-page">
        <?php if (!empty($message)): ?>
            <div style="background: rgba(52, 211, 153, 0.15); border: 1px solid #34d399; color: #34d399; padding: 0.8rem; border-radius: 8px; margin-bottom: 1rem; text-align:center;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 0.8rem; border-radius: 8px; margin-bottom: 1rem; text-align:center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="availability-container">
            
            <!-- LEFT COLUMN: Date Picker / Selector -->
            <div class="card">
                <h3>Select Date</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.2rem;">
                    Choose a date to view or add available time slots.
                </p>

                <form id="dateForm" method="GET" action="index.php">
                    <input type="hidden" name="action" value="coach_availability">
                    <div class="form-group">
                        <label for="slot_date">Date</label>
                        <input type="date" id="datePicker" name="date" 
                               value="<?php echo htmlspecialchars($selected_date); ?>" 
                               min="<?php echo date('Y-m-d'); ?>" 
                               style="width: 100%; padding: 0.6rem;" 
                               onchange="document.getElementById('dateForm').submit();">
                    </div>
                </form>

                <!-- ADD NEW AVAILABILITY FORM -->
                <hr style="border-color: rgba(255,255,255,0.08); margin: 1.5rem 0;">
                
                <h3>Add Slot for <?php echo date('M d, Y', strtotime($selected_date)); ?></h3>
                <form action="index.php?action=coach_availability" method="POST" style="margin-top: 1rem;">
                    <input type="hidden" name="action_type" value="add">
                    <input type="hidden" name="slot_date" value="<?php echo htmlspecialchars($selected_date); ?>">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="start_time" value="09:00" required>
                        </div>
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" name="end_time" value="10:00" required>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 0.8rem;">+ Add Time Slot</button>
                </form>
            </div>

            <!-- RIGHT COLUMN: Slot Management -->
            <div class="card">
                <h3>Slots for <?php echo date('l, M d, Y', strtotime($selected_date)); ?></h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.2rem;">
                    Manage time windows. Booked slots cannot be deleted.
                </p>

                <div class="slots-list">
                    <?php if (!empty($slots)): ?>
                        <?php foreach ($slots as $slot): ?>
                            <?php 
                                $isBooked = (bool)$slot['is_booked'];
                                $formattedStart = date('g:i A', strtotime($slot['start_time']));
                                $formattedEnd = date('g:i A', strtotime($slot['end_time']));
                            ?>
                            <div class="slot-card">
                                <div>
                                    <strong style="font-size: 1rem;"><?php echo $formattedStart . ' - ' . $formattedEnd; ?></strong>
                                    <div style="margin-top: 0.25rem;">
                                        <?php if ($isBooked): ?>
                                            <span class="slot-badge badge-booked">Booked by Job Seeker</span>
                                        <?php else: ?>
                                            <span class="slot-badge badge-available">Available</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 0.4rem;">
                                    <!-- EDIT BUTTON -->
                                    <?php if (!$isBooked): ?>
                                        <button class="action-btn btn-edit" 
                                                onclick="openEditModal(<?php echo $slot['slot_id']; ?>, '<?php echo $slot['start_time']; ?>', '<?php echo $slot['end_time']; ?>')">
                                            Edit
                                        </button>
                                    <?php endif; ?>

                                    <!-- DELETE FORM -->
                                    <form action="index.php?action=coach_availability" method="POST" onsubmit="return confirm('Are you sure you want to remove this slot?');">
                                        <input type="hidden" name="action_type" value="delete">
                                        <input type="hidden" name="slot_id" value="<?php echo $slot['slot_id']; ?>">
                                        <input type="hidden" name="slot_date" value="<?php echo htmlspecialchars($selected_date); ?>">

                                        <?php if ($isBooked): ?>
                                            <button type="button" class="action-btn btn-disabled" disabled title="Cannot delete a booked session">Delete</button>
                                        <?php else: ?>
                                            <button type="submit" class="action-btn btn-delete">Delete</button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; color: var(--text-muted); padding: 3rem 1rem;">
                            <p>No availability slots set for this date.</p>
                            <small>Use the form on the left to add slots.</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- EDIT SLOT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3 style="margin-bottom: 1rem;">Edit Time Slot</h3>
            <form action="index.php?action=coach_availability" method="POST">
                <input type="hidden" name="action_type" value="edit">
                <input type="hidden" id="edit_slot_id" name="slot_id">
                <input type="hidden" name="slot_date" value="<?php echo htmlspecialchars($selected_date); ?>">

                <div class="form-group" style="margin-bottom: 0.8rem;">
                    <label>Start Time</label>
                    <input type="time" id="edit_start_time" name="start_time" required>
                </div>

                <div class="form-group" style="margin-bottom: 1.2rem;">
                    <label>End Time</label>
                    <input type="time" id="edit_end_time" name="end_time" required>
                </div>

                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-outline" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn">Update Slot</button>
                </div>
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
    
        function openEditModal(slotId, startTime, endTime) {
            document.getElementById('edit_slot_id').value = slotId;
            document.getElementById('edit_start_time').value = startTime;
            document.getElementById('edit_end_time').value = endTime;
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal if user clicks outside modal contents
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>