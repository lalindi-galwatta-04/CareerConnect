<?php
// Retrieve the current action to determine active page state
$currentAction =$_GET['action'] ?? 'coach_dashboard';

// --- DUMMY DATA FALLBACKS ---
if (empty($coach)) {$coach = [
        'coach_name' => 'Lalindi Mihirika',
        'specialization' => 'General Guidance & Career Strategy',
        'hourly_rate' => '1000.00',
        'email' => 'lalindi.mihirika@careerconnect.com'
    ];
}

// Fallback to dummy stats if metrics are uninitialized, empty, or all zeroes
if (empty($metrics) || empty($metrics['total_sessions'])) {$metrics = [
        'total_sessions' => 12,
        'pending_sessions' => 3,
        'completed_sessions' => 8,
        'avg_rating' => 4.8,
        'rated_sessions_count' => 6
    ];
}

if (empty($sessions)) {$sessions = [
        [
            'interaction_id' => 101,
            'first_name' => 'Kavindu',
            'last_name' => 'Perera',
            'session_date' => '2026-10-05 10:00 AM',
            'duration_minutes' => 60,
            'status' => 'scheduled',
            'notes' => 'Discussing resume review and software engineering interview prep.'
        ],
        [
            'interaction_id' => 102,
            'first_name' => 'Dilini',
            'last_name' => 'Fernando',
            'session_date' => '2026-10-02 02:30 PM',
            'duration_minutes' => 45,
            'status' => 'scheduled',
            'notes' => 'Career transition guidance towards product management.'
        ],
        [
            'interaction_id' => 103,
            'first_name' => 'Nipuna',
            'last_name' => 'Silva',
            'session_date' => '2026-09-24 11:00 AM',
            'duration_minutes' => 60,
            'status' => 'completed',
            'notes' => 'Mock behavioral interview completed. Sent action items.'
        ],
        [
            'interaction_id' => 104,
            'first_name' => 'Amaya',
            'last_name' => 'Jayawardena',
            'session_date' => '2026-09-20 04:00 PM',
            'duration_minutes' => 30,
            'status' => 'cancelled',
            'notes' => 'Rescheduled due to client personal emergency.'
        ]
    ];
}

if (empty($feedbacks)) {$feedbacks = [
        [
            'first_name' => 'Nipuna',
            'last_name' => 'Silva',
            'rating' => 5,
            'notes' => 'Lalindi provided invaluable feedback on my interview technique. Highly recommend her coaching session!',
            'session_date' => '2026-09-24'
        ],
        [
            'first_name' => 'Sahan',
            'last_name' => 'Gunawardena',
            'rating' => 4,
            'notes' => 'Great structured advice on career mapping and resume improvements.',
            'session_date' => '2026-09-18'
        ],
        [
            'first_name' => 'Tharushi',
            'last_name' => 'De Silva',
            'rating' => 5,
            'notes' => 'Extremely helpful session. Helped me narrow down my career goals efficiently.',
            'session_date' => '2026-09-10'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.0">
    <style>

        /* Navbar Links Styling */
.nav-links a {
    display: inline-block;
    padding: 0.6rem 1.2rem;
    color: #475569;
    text-decoration: none;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.nav-links a:hover {
    background-color: #f1f5f9;
    color: #1e40af;
}

/* Active Navigation Link (Highlighted State) */
.nav-links a.active {
    background-color: #eff6ff !important;
    color: #2563eb !important;
    font-weight: 700 !important;
}
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
        $activePage = 'dashboard';
        require __DIR__ . '/partials/coach_navbar.php';
    ?>
   
    <div class="container">
        <!-- Overview & Summary Metrics Header -->
        <div class="welcome-card">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($coach['coach_name'] ?? 'Coach'); ?></h1>
                <p>
                    <strong>Specialization:</strong> <?php echo htmlspecialchars($coach['specialization'] ?? 'N/A'); ?> 
                    <span style="margin: 0 0.5rem; opacity: 0.5;">|</span> 
                    <strong>Rate:</strong> <span style="color: #f5f5f5;">LKR <?php echo htmlspecialchars($coach['hourly_rate'] ?? '0.00'); ?>/hr</span>
                </p>
            </div>
        </div>

        <!-- Metric Cards Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <div class="number"><?php echo $metrics['total_sessions']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending Sessions</h3>
                <div class="number"><?php echo $metrics['pending_sessions']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Completed Sessions</h3>
                <div class="number"><?php echo $metrics['completed_sessions']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Average Rating</h3>
                <div class="number">
                    <?php echo number_format($metrics['avg_rating'], 1) . ' / 5.0'; ?>
                </div>
                <small style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">
                    (<?php echo $metrics['rated_sessions_count']; ?> reviews)
                </small>
            </div>
        </div>

        <!-- Session List with Filters -->
        <div class="card" id="coaching-sessions">
            <div class="section-card" style="padding:0; border:none; margin-bottom: 1.5rem; background:transparent;">
                <h2>Coaching Sessions</h2>
            </div>
            
            <!-- Filter Pills Navigation -->
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <a href="index.php?action=coach_dashboard&status=all#coaching-sessions" 
                   class="btn <?php echo ($statusFilter ?? 'all') === 'all' ? '' : 'btn-outline'; ?>" 
                   style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 20px;">All</a>
                <a href="index.php?action=coach_dashboard&status=scheduled#coaching-sessions" 
                   class="btn <?php echo ($statusFilter ?? '') === 'scheduled' ? '' : 'btn-outline'; ?>" 
                   style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 20px;">Scheduled</a>
                <a href="index.php?action=coach_dashboard&status=completed#coaching-sessions" 
                   class="btn <?php echo ($statusFilter ?? '') === 'completed' ? '' : 'btn-outline'; ?>" 
                   style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 20px;">Completed</a>
                <a href="index.php?action=coach_dashboard&status=cancelled#coaching-sessions" 
                   class="btn <?php echo ($statusFilter ?? '') === 'cancelled' ? '' : 'btn-outline'; ?>" 
                   style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: 20px;">Cancelled</a>
            </div>

            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Date & Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Session Notes</th>
                            <th style="min-width: 220px;">Manage Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sessions)): ?>
                            <?php foreach ($sessions as$session): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($session['first_name'] . ' ' .$session['last_name']); ?></strong></td>
                                    <td style="color: var(--text-muted);"><?php echo htmlspecialchars($session['session_date']); ?></td>
                                    <td><?php echo htmlspecialchars($session['duration_minutes']); ?> mins</td>
                                    <td>
                                        <?php 
                                            $st = strtolower($session['status']);$badgeClass = 'status-pending';
                                            if ($st === 'completed')$badgeClass = 'status-approved';
                                            if ($st === 'cancelled')$badgeClass = 'status-rejected';
                                        ?>
                                        <span class="status <?php echo $badgeClass; ?>">
                                            <?php echo ucfirst($session['status']); ?>
                                        </span>
                                    </td>
                                    <td style="color: var(--text-muted); max-width: 200px;">
                                        <?php echo htmlspecialchars($session['notes'] ?? 'None'); ?>
                                    </td>
                                    <td>
                                        <form action="index.php?action=conduct_session" method="POST" style="display: flex; flex-direction: column; gap: 0.4rem;">
                                            <input type="hidden" name="interaction_id" value="<?php echo $session['interaction_id']; ?>">
                                            <input type="hidden" name="filter_status" value="<?php echo htmlspecialchars($statusFilter ?? 'all'); ?>">
                                            
                                            <textarea name="notes" placeholder="Add session notes..." style="width: 100%; min-height: 45px; padding: 0.4rem; font-size: 0.85rem; resize: vertical;"><?php echo htmlspecialchars($session['notes'] ?? ''); ?></textarea>
                                            
                                            <div style="display: flex; gap: 0.4rem;">
                                                <select name="status" style="padding: 0.3rem 0.5rem; font-size: 0.82rem; flex: 1;">
                                                    <option value="scheduled" <?php if($session['status']=='scheduled') echo 'selected'; ?>>Scheduled</option>
                                                    <option value="completed" <?php if($session['status']=='completed') echo 'selected'; ?>>Completed</option>
                                                    <option value="cancelled" <?php if($session['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                                                </select>
                                                <button type="submit" class="btn" style="padding: 0.3rem 0.75rem; font-size: 0.82rem;">Save</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No sessions found for this status.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Feedback & Ratings Display -->
        <div class="card" id="reviews-feedback">
            <div class="section-card" style="padding:0; border:none; margin-bottom: 1.5rem; background:transparent;">
                <h2>Client Reviews & Feedback</h2>
            </div>
            
            <?php if (!empty($feedbacks)): ?>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($feedbacks as$review): ?>
                        <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.07); border-radius: 10px; padding: 1.2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
                                <strong><?php echo htmlspecialchars($review['first_name'] . ' ' .$review['last_name']); ?></strong>
                                <span style="color: #fbbf24; font-size: 1.1rem; letter-spacing: 2px;">
                                    <?php 
                                        $rating = (int)$review['rating'];
                                        echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
                                    ?>
                                </span>
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 0.5rem; line-height: 1.5;">
                                <?php echo htmlspecialchars($review['notes'] ?? 'No written notes provided.'); ?>
                            </p>
                            <small style="color: rgba(255, 255, 255, 0.4); font-size: 0.8rem;"><?php echo htmlspecialchars($review['session_date']); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: var(--text-muted); font-size: 0.95rem; padding: 1rem 0;">No client reviews or ratings received yet.</p>
            <?php endif; ?>
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