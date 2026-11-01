<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Overview - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* Transparent Top Header */
        .provider-top-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: transparent;
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 45px;
            z-index: 900;
        }

        .provider-top-header .user-profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 7px 18px 7px 10px;
            border-radius: 9999px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .provider-top-header .user-profile-button:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .provider-top-header .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .provider-top-header .user-name {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .provider-top-header .user-arrow {
            font-size: 11px;
            color: #64748b;
            margin-left: 2px;
        }

        .sidebar-badge {
            background: #0284c7;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            margin-left: auto;
        }

        /* Dashboard Container */
        .dashboard-container {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 95px 45px 50px;
            min-height: 100vh;
        }

        .dashboard-header-title {
            margin-bottom: 24px;
        }

        .dashboard-header-title h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin: 0;
        }

        /* 4 Horizontal Stat Cards */
        .dashboard-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        @media (max-width: 1150px) {
            .dashboard-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .dashboard-stats-row {
                grid-template-columns: 1fr;
            }
        }

        .dashboard-stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px 20px 22px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(9, 40, 83, 0.04);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(9, 40, 83, 0.09);
            border-color: #cbd5e1;
        }

        .stat-card-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #475569;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card-val {
            font-size: 2.35rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-card-sub {
            font-size: 0.92rem;
            font-weight: 600;
            color: #10b981;
        }

        /* Two-Column Main Dashboard Layout */
        .dashboard-main-grid {
            display: grid;
            grid-template-columns: 1.95fr 1fr;
            gap: 22px;
            align-items: start;
        }

        @media (max-width: 1050px) {
            .dashboard-main-grid {
                grid-template-columns: 1fr;
            }
        }

        .dashboard-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(9, 40, 83, 0.04);
            padding: 26px 28px;
        }

        /* Financials Card */
        .financials-card {
            margin-bottom: 22px;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header-flex h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .growth-badge {
            background: #d1fae5;
            color: #065f46;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .financials-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .financial-stat-group {
            display: flex;
            gap: 45px;
            flex-wrap: wrap;
        }

        .financial-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .financial-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
        }

        .financial-amount {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .financial-sparkline {
            width: 190px;
            height: 52px;
            flex-shrink: 0;
        }

        /* Recent Activities Card - Timeline Style */
        .activities-card {
            padding: 24px 28px 26px;
        }

        .live-feed-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #ef4444;
            background: #fee2e2;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .live-feed-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            display: inline-block;
        }

        .timeline-list {
            position: relative;
            margin-top: 18px;
            padding-left: 20px;
        }

        .timeline-list::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 8px;
            bottom: 12px;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #cbd5e1;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #e2e8f0;
        }

        .timeline-item:first-child .timeline-dot {
            background: #0284c7;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.25);
        }

        .timeline-text {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .timeline-time {
            font-size: 0.88rem;
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Enrollment Requests Card */
        .enrollment-card {
            padding: 26px 24px;
            display: flex;
            flex-direction: column;
            margin-bottom: 22px;
        }

        .enrollment-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .pending-count-highlight {
            font-size: 1.05rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 18px;
        }

        .pending-students-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 24px;
        }

        .pending-student-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-outline-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            flex-shrink: 0;
        }

        .student-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }

        .btn-view-pending {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0284c7;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 11px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
        }

        .btn-view-pending:hover {
            background: #0369a1;
            transform: translateY(-1px);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
        }

        /* Quick Actions Card */
        .quick-actions-card {
            padding: 24px 24px;
        }

        .quick-actions-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 14px;
        }

        .quick-actions-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .quick-action-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .quick-action-link:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0284c7;
            transform: translateX(2px);
        }
    </style>
</head>
<body>
    <!-- Left Navigation Sidebar -->
    <nav class="navbar">
        <a href="index.php?action=provider_dashboard" class="logo">
            <img src="public/images/logo.png" alt="CareerConnect">
        </a>
        <div class="nav-links">
            <div class="sidebar-section-title">MAIN</div>
            <a href="index.php?action=provider_dashboard" class="sidebar-nav-item active">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="3" y="3" width="8" height="8" rx="2" />
                        <rect x="13" y="3" width="8" height="8" rx="2" />
                        <rect x="3" y="13" width="8" height="8" rx="2" />
                        <rect x="13" y="13" width="8" height="8" rx="2" />
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-section-title">MANAGEMENT</div>
            <a href="index.php?action=provider_dashboard&view=courses" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                </span>
                <span>My Courses</span>
            </a>

            <a href="index.php?action=financials" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 6v12M15 9.5a3.5 3.5 0 0 0-5 0c0 2 3 2.5 3 4.5a3.5 3.5 0 0 1-5 0"></path>
                    </svg>
                </span>
                <span>Financials & Revenue</span>
            </a>

            <a href="index.php?action=enrollment_requests" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </span>
                <span>Enrollment Requests</span>
                <?php if (!empty($pendingCount)): ?>
                    <span class="sidebar-badge"><?php echo (int)$pendingCount; ?></span>
                <?php endif; ?>
            </a>

            <a href="index.php?action=provider_dashboard&view=analytics" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </span>
                <span>Analytics & Breakdown</span>
            </a>

            <div class="sidebar-section-title">ACCOUNT</div>
            <a href="index.php?action=provider_profile" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
                <span>Settings</span>
            </a>

            <!-- Bottom Left Navbar Logout -->
            <div class="sidebar-bottom">
                <a href="index.php?action=logout" class="sidebar-nav-item sidebar-logout">
                    <span class="sidebar-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </span>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Transparent Top Header -->
    <header class="provider-top-header">
        <div class="user-profile" id="userProfile">
            <button class="user-profile-button" id="profileButton">
                <img src="public/images/user.png" alt="User" class="user-avatar">
                <span class="user-name"><?php echo htmlspecialchars($provider['provider_name'] ?? 'Training Provider'); ?></span>
                <span class="user-arrow">▼</span>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-user">
                    <img src="public/images/user.png" alt="User">
                    <div class="dropdown-user-info">
                        <strong><?php echo htmlspecialchars($provider['provider_name'] ?? 'Training Provider'); ?></strong>
                        <span><?php echo htmlspecialchars($provider['contact_email'] ?? $provider['email'] ?? ''); ?></span>
                    </div>
                </div>

                <a href="index.php?action=login">+ Add Another Account</a>
                <a href="index.php?action=logout" class="dropdown-logout">Log Out</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="dashboard-container">
        <!-- Dashboard Overview Title -->
        <div class="dashboard-header-title">
            <h1>Dashboard Overview</h1>
        </div>

        <!-- 4 Stat Cards in Single Horizontal Row (Real DB Data) -->
        <div class="dashboard-stats-row">
            <!-- Card 1: TOTAL COURSES -->
            <div class="dashboard-stat-card" onclick="window.location.href='index.php?action=provider_dashboard&view=courses'">
                <div class="stat-card-title">TOTAL COURSES</div>
                <div class="stat-card-val"><?php echo (int)($metrics['total_courses'] ?? 0); ?></div>
                <div class="stat-card-sub">Active Programs</div>
            </div>

            <!-- Card 2: TOTAL ENROLLED -->
            <div class="dashboard-stat-card" onclick="window.location.href='index.php?action=enrollment_requests'">
                <div class="stat-card-title">TOTAL ENROLLED</div>
                <div class="stat-card-val"><?php echo (int)($metrics['total_students'] ?? 0); ?></div>
                <div class="stat-card-sub">Job Seekers</div>
            </div>

            <!-- Card 3: ACTIVE LEARNERS -->
            <div class="dashboard-stat-card" onclick="window.location.href='index.php?action=enrollment_requests'">
                <div class="stat-card-title">ACTIVE LEARNERS</div>
                <div class="stat-card-val"><?php echo (int)($metrics['active_learners'] ?? 0); ?></div>
                <div class="stat-card-sub">In-Progress</div>
            </div>

            <!-- Card 4: COMPLETED -->
            <div class="dashboard-stat-card" onclick="window.location.href='index.php?action=provider_dashboard&view=grading'">
                <div class="stat-card-title">COMPLETED</div>
                <div class="stat-card-val"><?php echo (int)($metrics['completed_students'] ?? 0); ?></div>
                <div class="stat-card-sub">Certified</div>
            </div>
        </div>

        <!-- Main Dashboard 2-Column Grid -->
        <div class="dashboard-main-grid">
            <!-- Left Column: Financials & Recent Activities -->
            <div class="dashboard-left-col">
                <!-- Financials & Revenue Overview Card -->
                <div class="dashboard-card financials-card" id="financials">
                    <div class="card-header-flex">
                        <h2>Financials & Revenue Overview</h2>
                        <span class="growth-badge">↗ +12.4% vs last month</span>
                    </div>
                    <div class="financials-body">
                        <div class="financial-stat-group">
                            <div class="financial-item">
                                <span class="financial-label">Total Revenue:</span>
                                <span class="financial-amount">LKR <?php echo number_format($financials['total_revenue'] ?? 0, 2); ?></span>
                            </div>
                            <div class="financial-item">
                                <span class="financial-label">Monthly Earnings:</span>
                                <span class="financial-amount">LKR <?php echo number_format($financials['monthly_revenue'] ?? 0, 2); ?></span>
                            </div>
                        </div>

                        <!-- Sparkline Chart SVG -->
                        <div class="financial-sparkline">
                            <svg viewBox="0 0 180 50" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                                <defs>
                                    <linearGradient id="revenueGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="#0284c7" stop-opacity="0.32"/>
                                        <stop offset="100%" stop-color="#0284c7" stop-opacity="0.0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M 0,42 Q 35,46 65,36 T 120,24 T 155,14 L 180,4 L 180,50 L 0,50 Z" fill="url(#revenueGrad)"/>
                                <path d="M 0,42 Q 35,46 65,36 T 120,24 T 155,14 L 180,4" fill="none" stroke="#0284c7" stroke-width="2.6" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities Card (Timeline Feed) -->
                <div class="dashboard-card activities-card" id="analytics">
                    <div class="card-header-flex">
                        <h2>Recent Activities</h2>
                        <span class="live-feed-badge"><span class="live-feed-dot"></span> Live feed</span>
                    </div>
                    <div class="timeline-list">
                        <?php if (empty($recentActivities)): ?>
                            <div style="color: #64748b; font-size: 0.92rem; padding: 1.5rem 0; text-align: center;">
                                No recent transactions or activities recorded in the database.
                            </div>
                        <?php else: ?>
                            <?php foreach ($recentActivities as $act): ?>
                                <div class="timeline-item">
                                    <span class="timeline-dot"></span>
                                    <span class="timeline-text"><?php echo htmlspecialchars($act['text']); ?></span>
                                    <span class="timeline-time"><?php echo htmlspecialchars($act['time']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Enrollment Requests & Quick Actions -->
            <div class="dashboard-right-col">
                <div class="dashboard-card enrollment-card">
                    <h2 class="enrollment-title">Enrollment Requests</h2>
                    <div class="pending-count-highlight"><?php echo (int)($pendingCount ?? 0); ?> Pending Requests</div>

                    <div class="pending-students-list">
                        <?php if (empty($pendingRequests)): ?>
                            <div style="color: #64748b; font-size: 0.92rem; padding: 1rem 0; text-align: center;">
                                No pending requests in database.
                            </div>
                        <?php else: ?>
                            <?php foreach ($pendingRequests as $req): ?>
                                <div class="pending-student-item">
                                    <div class="student-outline-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                    <span class="student-name"><?php echo htmlspecialchars($req['student_name']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <a href="index.php?action=enrollment_requests" class="btn-view-pending">View Pending</a>
                </div>

                <!-- Quick Actions Card -->
                <div class="dashboard-card quick-actions-card">
                    <h3 class="quick-actions-title">Quick Actions</h3>
                    <div class="quick-actions-list">
                        <a href="index.php?action=manage_course&mode=new" class="quick-action-link">
                            <span style="color: #0284c7; font-weight: bold; font-size: 1.1rem;">+</span>
                            <span>Add New Course</span>
                        </a>
                        <a href="index.php?action=provider_dashboard&view=courses" class="quick-action-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            <span>Manage My Courses</span>
                        </a>
                        <a href="index.php?action=provider_profile" class="quick-action-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            <span>Provider Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Profile Dropdown Toggle
        const profileBtn = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const userProfile = document.getElementById('userProfile');

        if (profileBtn && profileDropdown && userProfile) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userProfile.classList.toggle('open');
                profileDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!userProfile.contains(e.target)) {
                    userProfile.classList.remove('open');
                    profileDropdown.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>