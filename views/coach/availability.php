<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Availability - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.0">
    <style>
        /* Sidebar layout offset fix */
        .main-content-wrapper {
            margin-left: 260px; /* Offset for fixed vertical sidebar */
            padding: 1.5rem 2rem;
            min-height: calc(100vh - 70px);
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            .main-content-wrapper {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Navbar Active State Styles */
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
        .nav-links a.active {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            font-weight: 700 !important;
        }

        /* MS Teams Style Calendar Container Layout */
        .teams-calendar-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 1.5rem;
            width: 100%;
        }

        @media (max-width: 1100px) {
            .teams-calendar-wrapper {
                grid-template-columns: 1fr;
            }
        }

        /* Teams Calendar Grid Header */
        .teams-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            background: #ffffff;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        /* Week Grid View */
        .teams-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            background: #ffffff;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            width: 100%;
            box-sizing: border-box;
        }

        .teams-day-column {
            border-right: 1px solid #f1f5f9;
            padding: 0.5rem;
            min-height: 480px;
            display: flex;
            flex-direction: column;
        }
        .teams-day-column:last-child { border-right: none; }

        .teams-day-header {
            text-align: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 0.75rem;
        }
        .teams-day-header.today {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        /* Slot Cards inside Calendar */
        .teams-slot-card {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
            position: relative;
        }
        .teams-slot-card.booked {
            background: #fef2f2;
            border-left-color: #dc2626;
            color: #991b1b;
        }

        .teams-slot-time {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.15rem;
        }

        /* Mini Month Picker Sidebar */
        .mini-calendar {
            background: #ffffff;
            padding: 1.2rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            height: fit-content;
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
                <a href="index.php?action=coach_profile">Profile</a>
                <a href="index.php?action=coach_availability" class="active">Availability</a>
                <a href="index.php?action=coach_dashboard#coaching-sessions">Coaching Sessions</a>
                <a href="index.php?action=coach_dashboard#reviews-feedback">Reviews & Feedback</a>
                <a href="index.php?action=logout" class="dropdown-logout">Logout</a>
            </div>
        </div>
    </header>

    <?php
        $activePage = 'availability';
        if (file_exists(__DIR__ . '/partials/coach_navbar.php')) {
            require __DIR__ . '/partials/coach_navbar.php';
        } else {
            $currentAction = $_GET['action'] ?? 'coach_availability';
            echo '<nav class="navbar">
                <a href="index.php?action=coach_dashboard" class="logo"><img src="logo.png" alt="CareerConnect"></a>
                <div class="nav-links">
                    <a href="index.php?action=coach_dashboard">Home</a>
                    <a href="index.php?action=coach_profile">Profile</a>
                    <a href="index.php?action=coach_availability" class="active">Availability</a>
                    <a href="index.php?action=logout" class="logout-link">Logout</a>
                </div>
            </nav>';
        }
    ?>

    <!-- Wrapper with left offset to prevent navbar/sidebar overlapping -->
    <div class="main-content-wrapper">

        <?php if (!empty($message)): ?>
            <div style="background: rgba(52, 211, 153, 0.15); border: 1px solid #34d399; color: #065f46; padding: 0.8rem; border-radius: 8px; margin-bottom: 1rem; text-align:center; font-weight: 600;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #991b1b; padding: 0.8rem; border-radius: 8px; margin-bottom: 1rem; text-align:center; font-weight: 600;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php
            // Calculate Week Range (Mon - Sun) based on selected date
            $selected_date = $_GET['date'] ?? date('Y-m-d');
            $ts = strtotime($selected_date);
            $dayOfWeek = date('N', $ts); // 1 (Mon) to 7 (Sun)
            $weekStart = strtotime("-" . ($dayOfWeek - 1) . " days", $ts);
        ?>

        <!-- TEAMS CALENDAR LAYOUT WRAPPER -->
        <div class="teams-calendar-wrapper">
            
            <!-- SIDEBAR: Date Switcher & Slot Creator -->
            <div class="mini-calendar">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.25rem;">Calendar Controls</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.2rem;">
                    Pick a day to add slots or view weekly schedule.
                </p>

                <form id="dateForm" method="GET" action="index.php">
                    <input type="hidden" name="action" value="coach_availability">
                    <div class="form-group">
                        <label for="slot_date" style="font-size: 0.85rem; font-weight: 600;">Jump to Date</label>
                        <input type="date" id="datePicker" name="date" 
                               value="<?php echo htmlspecialchars($selected_date); ?>" 
                               style="width: 100%; padding: 0.6rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;" 
                               onchange="document.getElementById('dateForm').submit();">
                    </div>
                </form>

                <hr style="border-color: #e2e8f0; margin: 1.25rem 0;">
                
                <h4 style="font-size: 0.95rem; margin-bottom: 0.8rem;">Add Slot for <?php echo date('M d, Y', strtotime($selected_date)); ?></h4>
                <form action="index.php?action=coach_availability" method="POST">
                    <input type="hidden" name="action_type" value="add">
                    <input type="hidden" name="slot_date" value="<?php echo htmlspecialchars($selected_date); ?>">

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <label style="font-size: 0.82rem; font-weight: 600;">Start Time</label>
                        <input type="time" name="start_time" value="09:00" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <label style="font-size: 0.82rem; font-weight: 600;">End Time</label>
                        <input type="time" name="end_time" value="10:00" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;" required>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 0.5rem; padding: 0.6rem; font-weight: 600;">+ Add Time Slot</button>
                </form>
            </div>

            <!-- MAIN SECTION: MS Teams Style Weekly Grid View -->
            <div>
                <!-- Header Toolbar -->
                <div class="teams-header-bar">
                    <div style="font-weight: 700; font-size: 1.05rem; color: #1e293b;">
                        Week of <?php echo date('M d, Y', $weekStart); ?> – <?php echo date('M d, Y', strtotime("+6 days", $weekStart)); ?>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="index.php?action=coach_availability&date=<?php echo date('Y-m-d', strtotime('-7 days', $ts)); ?>" class="btn btn-outline" style="padding: 0.35rem 0.8rem; font-size: 0.82rem;">&larr; Prev Week</a>
                        <a href="index.php?action=coach_availability&date=<?php echo date('Y-m-d'); ?>" class="btn btn-outline" style="padding: 0.35rem 0.8rem; font-size: 0.82rem;">Today</a>
                        <a href="index.php?action=coach_availability&date=<?php echo date('Y-m-d', strtotime('+7 days', $ts)); ?>" class="btn btn-outline" style="padding: 0.35rem 0.8rem; font-size: 0.82rem;">Next Week &rarr;</a>
                    </div>
                </div>

                <!-- 7-Day Columns Grid -->
                <div class="teams-grid">
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        $currentDayTimestamp = strtotime("+$i days", $weekStart);
                        $dateStr = date('Y-m-d', $currentDayTimestamp);
                        $isToday = ($dateStr === date('Y-m-d'));
                        $isSelected = ($dateStr === $selected_date);

                        // Fetch slots for this specific day in the week
                        $daySlotsStmt = $this->db->prepare("SELECT * FROM coach_availability WHERE user_id = ? AND slot_date = ? ORDER BY start_time ASC");
                        $daySlotsStmt->execute([$user_id, $dateStr]);
                        $daySlots = $daySlotsStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <div class="teams-day-column" style="<?php echo $isSelected ? 'background: #f8fafc; border: 1px dashed #2563eb; border-radius: 8px;' : ''; ?>">
                            <div class="teams-day-header <?php echo $isToday ? 'today' : ''; ?>">
                                <a href="index.php?action=coach_availability&date=<?php echo $dateStr; ?>" style="text-decoration: none; color: inherit;">
                                    <div><?php echo date('D', $currentDayTimestamp); ?></div>
                                    <div style="font-size: 1.1rem; font-weight: 700;"><?php echo date('d', $currentDayTimestamp); ?></div>
                                </a>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.4rem; flex-grow: 1;">
                                <?php if (!empty($daySlots)): ?>
                                    <?php foreach ($daySlots as $slot): ?>
                                        <?php 
                                            $isBooked = (bool)$slot['is_booked'];
                                            $startTime = date('g:i A', strtotime($slot['start_time']));
                                            $endTime = date('g:i A', strtotime($slot['end_time']));
                                        ?>
                                        <div class="teams-slot-card <?php echo $isBooked ? 'booked' : ''; ?>">
                                            <div class="teams-slot-time"><?php echo $startTime; ?></div>
                                            <div style="font-size: 0.7rem; opacity: 0.8;">to <?php echo $endTime; ?></div>
                                            <div style="margin-top: 0.2rem; font-weight: 600;">
                                                <?php echo $isBooked ? '🔴 Booked' : '🟢 Available'; ?>
                                            </div>
                                            
                                            <!-- Delete Slot Form -->
                                            <?php if (!$isBooked): ?>
                                                <form action="index.php?action=coach_availability" method="POST" style="margin-top: 0.3rem;">
                                                    <input type="hidden" name="action_type" value="delete">
                                                    <input type="hidden" name="slot_id" value="<?php echo $slot['slot_id']; ?>">
                                                    <input type="hidden" name="slot_date" value="<?php echo $selected_date; ?>">
                                                    <button type="submit" onclick="return confirm('Remove this slot?');" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:0.65rem; padding:0; text-decoration:underline;">Delete</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div style="text-align: center; color: #cbd5e1; font-size: 0.75rem; margin-top: 2rem;">No slots</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>

        </div>
    </div>

    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.classList.toggle('show');
        }
        window.addEventListener('click', function(e) {
            const userProfile = document.getElementById('userProfile');
            const dropdown = document.getElementById('profileDropdown');
            if (userProfile && dropdown && !userProfile.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>