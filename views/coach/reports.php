<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics & Reports - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.0">
    <style>
        .main-content-wrapper {
            margin-left: 260px;
            padding: 1.5rem 2rem;
            min-height: calc(100vh - 70px);
            box-sizing: border-box;
        }
        @media (max-width: 1024px) {
            .main-content-wrapper { margin-left: 0; padding: 1rem; }
        }
        .nav-links a {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-links a:hover { background-color: #f1f5f9; color: #1e40af; }
        .nav-links a.active { background-color: #eff6ff !important; color: #2563eb !important; font-weight: 700 !important; }

        .filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .metrics-overview {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 768px) {
            .metrics-overview { grid-template-columns: 1fr; }
        }
        .metric-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1.2rem;
            border-left: 4px solid #2563eb;
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
                <span class="user-name"><?php echo htmlspecialchars($displayName); ?></span>
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
                <a href="index.php?action=coach_availability">Availability</a>
                <a href="index.php?action=coach_reports" class="active">Reports & Analytics</a>
                <a href="index.php?action=logout" class="dropdown-logout">Logout</a>
            </div>
        </div>
    </header>

    <?php
        $activePage = 'reports';
        if (file_exists(__DIR__ . '/partials/coach_navbar.php')) {
            require __DIR__ . '/partials/coach_navbar.php';
        } else {
            echo '<nav class="navbar">
                <a href="index.php?action=coach_dashboard" class="logo"><img src="logo.png" alt="CareerConnect"></a>
                <div class="nav-links">
                    <a href="index.php?action=coach_dashboard">Home</a>
                    <a href="index.php?action=coach_profile">Profile</a>
                    <a href="index.php?action=coach_availability">Availability</a>
                    <a href="index.php?action=coach_reports" class="active">Reports</a>
                    <a href="index.php?action=logout" class="logout-link">Logout</a>
                </div>
            </nav>';
        }
    ?>

    <div class="main-content-wrapper">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <div>
                <h2>Coaching Performance Analytics & Reports</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Generate customized reports by date range and session status.</p>
            </div>
            <div>
                <a href="index.php?action=coach_reports&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>&report_status=<?php echo $statusParam; ?>&export=csv" class="btn" style="background: #0f172a; color: #fff; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">📥 Download CSV Report</a>
            </div>
        </div>

        <!-- Filter Parameter Form -->
        <div class="filter-card">
            <form method="GET" action="index.php" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) 120px; gap: 1rem; align-items: flex-end;">
                <input type="hidden" name="action" value="coach_reports">
                
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size: 0.85rem; font-weight: 600;">Start Date</label>
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" style="width: 100%; padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px;" required>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size: 0.85rem; font-weight: 600;">End Date</label>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" style="width: 100%; padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px;" required>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-size: 0.85rem; font-weight: 600;">Session Status</label>
                    <select name="report_status" style="width: 100%; padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 6px; background:#fff;">
                        <option value="all" <?php echo $statusParam === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                        <option value="scheduled" <?php echo $statusParam === 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                        <option value="completed" <?php echo $statusParam === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $statusParam === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn" style="width: 100%; padding: 0.6rem; font-weight: 600;">Filter</button>
                </div>
            </form>
        </div>

        <!-- Summary Metrics Cards -->
        <div class="metrics-overview">
            <div class="metric-box">
                <h3 style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">Total Filtered Sessions</h3>
                <div style="font-size: 1.8rem; font-weight: 700; color: #1e293b;"><?php echo $totalSessions; ?></div>
            </div>
            <div class="metric-box" style="border-left-color: #10b981;">
                <h3 style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">Completed Sessions</h3>
                <div style="font-size: 1.8rem; font-weight: 700; color: #10b981;"><?php echo $completedCount; ?></div>
            </div>
            <div class="metric-box" style="border-left-color: #6366f1;">
                <h3 style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.3rem;">Estimated Earnings (LKR)</h3>
                <div style="font-size: 1.8rem; font-weight: 700; color: #6366f1;">Rs. <?php echo number_format($totalEarnings, 2); ?></div>
            </div>
        </div>

        <!-- Detailed Report Table -->
        <div class="card" style="background:#ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Report Data Breakdown</h3>
            <div style="overflow-x: auto;">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                            <th style="padding: 0.75rem;">Client Name</th>
                            <th style="padding: 0.75rem;">Email</th>
                            <th style="padding: 0.75rem;">Date & Time</th>
                            <th style="padding: 0.75rem;">Duration</th>
                            <th style="padding: 0.75rem;">Status</th>
                            <th style="padding: 0.75rem;">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reportData)): ?>
                            <?php foreach ($reportData as $row): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 0.75rem;"><strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong></td>
                                    <td style="padding: 0.75rem; color: var(--text-muted);"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td style="padding: 0.75rem;"><?php echo htmlspecialchars($row['session_date']); ?></td>
                                    <td style="padding: 0.75rem;"><?php echo htmlspecialchars($row['duration_minutes'] ?? 60); ?> mins</td>
                                    <td style="padding: 0.75rem;">
                                        <?php 
                                            $st = strtolower($row['status']);
                                            $badge = 'status-pending';
                                            if ($st === 'completed') $badge = 'status-approved';
                                            if ($st === 'cancelled') $badge = 'status-rejected';
                                        ?>
                                        <span class="status <?php echo $badge; ?>" style="font-size: 0.75rem; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight:600;"><?php echo ucfirst($row['status']); ?></span>
                                    </td>
                                    <td style="padding: 0.75rem; color: var(--text-muted); max-width: 250px;"><?php echo htmlspecialchars($row['notes'] ?? 'None'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No session records found matching the selected parameters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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