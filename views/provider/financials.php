<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financials & Revenue - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* Specific Styles for Financials & Revenue Screen Matching UI Mockup */
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

        /* Financials Page Container */
        .financials-container {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 95px 45px 50px;
            min-height: 100vh;
        }

        /* Top Header Row with Title & Year Picker */
        .financials-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .financials-title-group {
            display: flex;
            align-items: baseline;
            gap: 12px;
        }

        .financials-title-group h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .financials-subtitle {
            font-size: 1.05rem;
            color: #64748b;
            font-weight: 500;
        }

        .year-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.2s;
        }

        .year-filter-btn:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        /* Filter Controls Bar */
        .financials-filter-bar {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 14px;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 8px rgba(9, 40, 83, 0.03);
            margin-bottom: 24px;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
            max-width: 480px;
        }

        .search-input-wrapper input {
            width: 100%;
            padding: 10px 40px 10px 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.92rem;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .search-input-wrapper input:focus {
            background: #ffffff;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .search-icon-inside {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
        }

        .filter-selects-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .select-pill-wrapper {
            position: relative;
        }

        .select-pill {
            appearance: none;
            -webkit-appearance: none;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 9px 36px 9px 16px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
        }

        .select-pill:focus, .select-pill:hover {
            border-color: #94a3b8;
            background: #ffffff;
        }

        .select-chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #64748b;
            font-size: 10px;
        }

        /* Date Period Popover Dropdown & Calendar Inputs */
        .date-period-wrapper {
            position: relative;
        }

        .date-period-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
        }

        .date-period-toggle-btn:hover, .date-period-toggle-btn.active {
            border-color: #0284c7;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .date-period-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 340px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.12), 0 2px 6px rgba(15, 23, 42, 0.04);
            z-index: 1000;
        }

        .date-period-dropdown.show {
            display: block;
        }

        .dp-header {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dp-presets-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 14px;
        }

        .dp-preset-chip {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            text-align: center;
            transition: all 0.15s;
        }

        .dp-preset-chip:hover, .dp-preset-chip.active {
            background: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
        }

        .dp-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 12px 0 14px;
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .dp-divider::before, .dp-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .dp-divider span {
            padding: 0 8px;
        }

        .date-range-fields {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .date-range-field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 4px;
        }

        .date-range-input {
            width: 100%;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 500;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
        }

        .date-range-input:focus {
            background: #ffffff;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .dp-actions-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-calc-date {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
            transition: all 0.2s;
        }

        .btn-calc-date:hover {
            background: #0369a1;
            transform: translateY(-1px);
        }

        .btn-reset-date {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-reset-date:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .active-period-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            font-size: 0.88rem;
            padding: 10px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        .clear-period-btn {
            background: transparent;
            border: none;
            color: #dc2626;
            font-weight: 700;
            font-size: 0.84rem;
            padding: 3px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .clear-period-btn:hover {
            background: #fee2e2;
        }

        /* 4 Horizontal Stat Cards */
        .financials-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 18px;
            padding: 22px 24px 20px;
            box-shadow: 0 4px 16px rgba(9, 40, 83, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
            position: relative;
            overflow: hidden;
        }

        .stat-card-label {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
        }

        .stat-card-amount {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .stat-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        .stat-subtext {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-mini-wave {
            width: 46px;
            height: 18px;
        }

        .badge-growth {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 6px;
        }

        .badge-pending-chip {
            display: inline-block;
            background: #fef3c7;
            color: #b45309;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 6px;
        }

        /* Earnings History Card */
        .chart-main-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 20px;
            padding: 28px 32px 32px;
            box-shadow: 0 4px 18px rgba(9, 40, 83, 0.04);
            margin-bottom: 24px;
        }

        .chart-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .chart-header-row h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .chart-total-highlight {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
        }

        .chart-svg-container {
            width: 100%;
            height: 220px;
            position: relative;
        }

        /* Transactions Card */
        .transactions-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 20px;
            padding: 28px 32px 32px;
            box-shadow: 0 4px 18px rgba(9, 40, 83, 0.04);
        }

        .transactions-card h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
            margin: 0 0 20px 0;
        }

        .tx-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tx-table th {
            text-align: left;
            padding: 14px 16px;
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .tx-table td {
            padding: 16px;
            font-size: 0.92rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .tx-table tr:hover {
            background: #f8fafc;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .student-circle-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            flex-shrink: 0;
        }

        .badge-slip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #d1fae5;
            color: #065f46;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .tx-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            color: #64748b;
            font-size: 0.92rem;
        }

        .pagination-btns {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s;
        }

        .page-btn.active {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
        }

        .page-btn:hover:not(.active) {
            background: #f8fafc;
            border-color: #94a3b8;
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
            <a href="index.php?action=provider_dashboard" class="sidebar-nav-item">
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

            <a href="index.php?action=financials" class="sidebar-nav-item active">
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

    <!-- Main Financials & Revenue Content Area -->
    <main class="financials-container">
        <!-- Title Row with Year Filter -->
        <div class="financials-header-row">
            <div class="financials-title-group">
                <h1>Financials & Revenue</h1>
                <span class="financials-subtitle">Revenue & Transactions Overview</span>
            </div>

            <button type="button" class="year-filter-btn" onclick="toggleYearSelector()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>This Year (<?php echo (int)($financials['selected_year'] ?? date('Y')); ?>)</span>
                <span style="font-size: 10px; color: #64748b;">▼</span>
            </button>
        </div>

        <!-- Filter Controls Bar -->
        <div class="financials-filter-bar">
            <div class="search-input-wrapper">
                <input type="text" id="txSearchInput" placeholder="Search student, course..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <span class="search-icon-inside">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </div>

            <div class="filter-selects-group">
                <div class="select-pill-wrapper">
                    <select class="select-pill" id="courseFilterSelect" onchange="applyFilters()">
                        <option value="all" <?php echo ($selectedCourse === 'all') ? 'selected' : ''; ?>>Filter by Course (All Courses)</option>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?php echo $c['course_id']; ?>" <?php echo ((string)$selectedCourse === (string)$c['course_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span class="select-chevron">▼</span>
                </div>

                <!-- Date Period Calendar Range Dropdown Popover -->
                <div class="date-period-wrapper" id="datePeriodWrapper">
                    <button type="button" class="date-period-toggle-btn <?php echo (!empty($startDate) && !empty($endDate)) || ($selectedPeriod !== 'all') ? 'active' : ''; ?>" id="datePeriodBtn" onclick="toggleDatePeriodDropdown(event)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>
                            <?php 
                                if (!empty($startDate) && !empty($endDate)) {
                                    echo htmlspecialchars(date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)));
                                } elseif ($selectedPeriod === 'this_month') {
                                    echo 'This Month';
                                } elseif ($selectedPeriod === 'last_30_days') {
                                    echo 'Last 30 Days';
                                } elseif ($selectedPeriod === 'this_year') {
                                    echo 'This Year';
                                } else {
                                    echo 'Date Period';
                                }
                            ?>
                        </span>
                        <span style="font-size: 10px; color: #64748b;">▼</span>
                    </button>

                    <!-- Dropdown Panel -->
                    <div class="date-period-dropdown" id="datePeriodDropdown">
                        <div class="dp-header">
                            <span>Filter by Date Period</span>
                            <span style="font-size: 11px; color: #64748b; font-weight: normal;">Presets & Range</span>
                        </div>

                        <!-- Presets -->
                        <div class="dp-presets-grid">
                            <button type="button" class="dp-preset-chip <?php echo ($selectedPeriod === 'this_month' && empty($startDate)) ? 'active' : ''; ?>" onclick="selectPresetPeriod('this_month')">This Month</button>
                            <button type="button" class="dp-preset-chip <?php echo ($selectedPeriod === 'last_30_days' && empty($startDate)) ? 'active' : ''; ?>" onclick="selectPresetPeriod('last_30_days')">Last 30 Days</button>
                            <button type="button" class="dp-preset-chip <?php echo ($selectedPeriod === 'this_year' && empty($startDate)) ? 'active' : ''; ?>" onclick="selectPresetPeriod('this_year')">This Year</button>
                            <button type="button" class="dp-preset-chip <?php echo ($selectedPeriod === 'all' && empty($startDate)) ? 'active' : ''; ?>" onclick="selectPresetPeriod('all')">All Time</button>
                        </div>

                        <div class="dp-divider"><span>OR CUSTOM DATE RANGE</span></div>

                        <!-- Custom Date Range Calendar Inputs -->
                        <div class="date-range-fields">
                            <div class="date-range-field">
                                <label for="customStartDate">Start Date (Calendar):</label>
                                <input type="date" id="customStartDate" class="date-range-input" value="<?php echo htmlspecialchars($startDate ?? ''); ?>" max="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="date-range-field">
                                <label for="customEndDate">End Date (Calendar):</label>
                                <input type="date" id="customEndDate" class="date-range-input" value="<?php echo htmlspecialchars($endDate ?? ''); ?>" max="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>

                        <div class="dp-actions-row">
                            <button type="button" class="btn-calc-date" onclick="calculateCustomDateRange()">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <span>Calculate</span>
                            </button>
                            <button type="button" class="btn-reset-date" onclick="resetDateRange()">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($startDate) && !empty($endDate)): ?>
            <!-- Active Filter Banner -->
            <div class="active-period-banner">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Calculated for Period: <strong><?php echo date('d M Y', strtotime($startDate)); ?></strong> to <strong><?php echo date('d M Y', strtotime($endDate)); ?></strong></span>
                </div>
                <button type="button" class="clear-period-btn" onclick="resetDateRange()">✕ Clear Filter</button>
            </div>
        <?php endif; ?>

        <!-- 4 Stat Cards in Single Horizontal Row (Real DB Data) -->
        <div class="financials-stats-grid">
            <!-- Card 1: TOTAL REVENUE -->
            <div class="stat-card">
                <div>
                    <div class="stat-card-label">TOTAL REVENUE</div>
                    <div class="stat-card-amount">LKR <?php echo number_format($financials['total_revenue'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-card-footer">
                    <span class="stat-subtext"><?php echo (!empty($startDate) && !empty($endDate)) ? 'Calculated period earnings' : 'Overall platform earnings'; ?></span>
                    <svg class="stat-mini-wave" viewBox="0 0 46 16" fill="none">
                        <path d="M1 13Q 12 16 23 9T 45 4" stroke="#0284c7" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <!-- Card 2: MONTHLY EARNINGS -->
            <div class="stat-card">
                <div>
                    <div class="stat-card-label">MONTHLY EARNINGS</div>
                    <div class="stat-card-amount">LKR <?php echo number_format($financials['monthly_revenue'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-card-footer">
                    <span class="badge-growth"><?php echo htmlspecialchars($financials['growth_rate'] ?? '+12.4% from last month'); ?></span>
                </div>
            </div>

            <!-- Card 3: PENDING VERIFICATIONS -->
            <div class="stat-card">
                <div>
                    <div class="stat-card-label">PENDING VERIFICATIONS</div>
                    <div class="stat-card-amount">LKR <?php echo number_format($financials['pending_amount'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-card-footer">
                    <span class="badge-pending-chip">From <?php echo (int)($pendingCount ?? 0); ?> pending requests</span>
                </div>
            </div>

            <!-- Card 4: AVG. COURSE FEE -->
            <div class="stat-card">
                <div>
                    <div class="stat-card-label">AVG. COURSE FEE</div>
                    <div class="stat-card-amount">LKR <?php echo number_format($financials['avg_fee'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-card-footer">
                    <span class="stat-subtext">Average per active offering</span>
                </div>
            </div>
        </div>

        <?php
            // Prepare Chart Y-axis labels and points dynamically from real DB monthly history
            $monthlyData = $financials['monthly_history'] ?? [];
            $maxRevenue = max(array_values($monthlyData ?: [0]));
            if ($maxRevenue <= 0) {
                $maxRevenue = (float)($financials['total_revenue'] ?? 0);
            }
            if ($maxRevenue <= 0) {
                $chartMax = 100000.0;
            } else {
                $chartMax = ceil($maxRevenue * 1.25);
            }
            $chartMid = $chartMax / 2;

            // X-axis 6 milestone months matching mockup: Jan, Mar, May, Jul, Sep, Nov
            $chartMonths = ['Jan', 'Mar', 'May', 'Jul', 'Sep', 'Nov'];
            $points = [];
            $svgWidth = 840;
            $svgHeight = 170;
            $xSpacing = $svgWidth / 5; // 6 points: index 0 to 5

            for ($i = 0; $i < 6; $i++) {
                $m = $chartMonths[$i];
                $val = (float)($monthlyData[$m] ?? 0);
                $x = round($i * $xSpacing, 1);
                // Invert Y: 0 is at bottom (y=160), max is at top (y=20)
                $y = round(160 - (($val / $chartMax) * 140), 1);
                $points[] = ['x' => $x, 'y' => $y, 'month' => $m, 'val' => $val];
            }

            // Generate smooth SVG cubic bezier path
            $pathD = "M " . $points[0]['x'] . "," . $points[0]['y'];
            for ($i = 0; $i < count($points) - 1; $i++) {
                $p0 = $points[$i];
                $p1 = $points[$i + 1];
                $cp1x = round($p0['x'] + ($p1['x'] - $p0['x']) / 2, 1);
                $cp1y = $p0['y'];
                $cp2x = $cp1x;
                $cp2y = $p1['y'];
                $pathD .= " C $cp1x,$cp1y $cp2x,$cp2y " . $p1['x'] . "," . $p1['y'];
            }
            $fillD = $pathD . " L " . $points[count($points)-1]['x'] . ",170 L " . $points[0]['x'] . ",170 Z";
        ?>

        <!-- Earnings History Card -->
        <div class="chart-main-card">
            <div class="chart-header-row">
                <h2>Earnings History</h2>
                <div class="chart-total-highlight">LKR <?php echo number_format($financials['total_revenue'] ?? 0, 2); ?></div>
            </div>

            <div class="chart-svg-container">
                <svg viewBox="0 0 940 210" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                    <defs>
                        <linearGradient id="earningsGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#0284c7" stop-opacity="0.28"/>
                            <stop offset="100%" stop-color="#0284c7" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>

                    <!-- Y-Axis Labels -->
                    <text x="0" y="24" fill="#64748b" font-size="11" font-weight="600">LKR <?php echo number_format($chartMax, 2); ?></text>
                    <text x="0" y="94" fill="#64748b" font-size="11" font-weight="600">LKR <?php echo number_format($chartMid, 2); ?></text>
                    <text x="60" y="164" fill="#64748b" font-size="11" font-weight="600">LKR 0</text>

                    <!-- Horizontal Grid lines -->
                    <g transform="translate(100, 0)">
                        <line x1="0" y1="20" x2="840" y2="20" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="0" y1="90" x2="840" y2="90" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="0" y1="160" x2="840" y2="160" stroke="#e2e8f0" stroke-width="1.5" />

                        <!-- Area Fill -->
                        <path d="<?php echo $fillD; ?>" fill="url(#earningsGrad)" />

                        <!-- Curved Line -->
                        <path d="<?php echo $pathD; ?>" fill="none" stroke="#0284c7" stroke-width="2.8" stroke-linecap="round" />

                        <!-- Circles on Points -->
                        <?php foreach ($points as $pt): ?>
                            <circle cx="<?php echo $pt['x']; ?>" cy="<?php echo $pt['y']; ?>" r="4.5" fill="#ffffff" stroke="#0284c7" stroke-width="2.5" />
                        <?php endforeach; ?>

                        <!-- X-Axis Month Labels -->
                        <?php foreach ($points as $pt): ?>
                            <text x="<?php echo $pt['x']; ?>" y="195" fill="#64748b" font-size="12" font-weight="600" text-anchor="middle"><?php echo $pt['month']; ?></text>
                        <?php endforeach; ?>
                    </g>
                </svg>
            </div>
        </div>

        <!-- Recent Verified Transactions Card -->
        <div class="transactions-card">
            <h2>Recent Verified Transactions</h2>

            <div style="overflow-x: auto;">
                <table class="tx-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Applied Course</th>
                            <th>Amount</th>
                            <th>Slip Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="txTableBody">
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                    No verified transactions recorded in the database.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $tx): ?>
                                <tr class="tx-row" data-name="<?php echo htmlspecialchars(strtolower($tx['student_name'])); ?>" data-course="<?php echo htmlspecialchars(strtolower($tx['course_title'])); ?>">
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-circle-avatar">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                            <span><?php echo htmlspecialchars($tx['student_name']); ?></span>
                                        </div>
                                    </td>
                                    <td style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($tx['course_title']); ?></td>
                                    <td style="font-weight: 700; color: #0f172a;">LKR <?php echo number_format($tx['course_fee'] ?? 0, 2); ?></td>
                                    <td>
                                        <span class="badge-slip">✓ Verified Slip #<?php echo (int)($tx['enrollment_id'] + 3800); ?></span>
                                    </td>
                                    <td style="color: #64748b;"><?php echo date('d M, h:i A', strtotime($tx['enrolled_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer Pagination -->
            <div class="tx-footer">
                <div>Showing <?php echo count($transactions ?? []); ?> of <?php echo count($transactions ?? []); ?> verified transactions</div>
                <div class="pagination-btns">
                    <button type="button" class="page-btn">Prev</button>
                    <button type="button" class="page-btn active">1</button>
                    <button type="button" class="page-btn">Next</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Real-time client-side table search
        const txSearchInput = document.getElementById('txSearchInput');
        const txRows = Array.from(document.querySelectorAll('#txTableBody tr.tx-row'));

        if (txSearchInput) {
            txSearchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                txRows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const course = row.getAttribute('data-course') || '';
                    if (name.includes(query) || course.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Apply Course Filter
        function applyFilters() {
            const course = document.getElementById('courseFilterSelect').value;
            let url = 'index.php?action=financials';
            const params = [];
            if (course !== 'all') params.push('course_id=' + encodeURIComponent(course));

            <?php if (!empty($startDate) && !empty($endDate)): ?>
                params.push('start_date=' + encodeURIComponent('<?php echo htmlspecialchars($startDate); ?>'));
                params.push('end_date=' + encodeURIComponent('<?php echo htmlspecialchars($endDate); ?>'));
            <?php elseif (!empty($selectedPeriod) && $selectedPeriod !== 'all'): ?>
                params.push('date_period=' + encodeURIComponent('<?php echo htmlspecialchars($selectedPeriod); ?>'));
            <?php endif; ?>

            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            window.location.href = url;
        }

        // Toggle Date Period Popover
        function toggleDatePeriodDropdown(e) {
            e.stopPropagation();
            const dp = document.getElementById('datePeriodDropdown');
            if (dp) {
                dp.classList.toggle('show');
            }
        }

        // Apply Preset Period
        function selectPresetPeriod(period) {
            const course = document.getElementById('courseFilterSelect').value;
            let url = 'index.php?action=financials';
            const params = [];
            if (course !== 'all') params.push('course_id=' + encodeURIComponent(course));
            if (period !== 'all') params.push('date_period=' + encodeURIComponent(period));
            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            window.location.href = url;
        }

        // Calculate by Custom Date Range (Start Date & End Date)
        function calculateCustomDateRange() {
            const start = document.getElementById('customStartDate').value;
            const end = document.getElementById('customEndDate').value;

            if (!start || !end) {
                alert('Please select both Start Date and End Date from the calendar.');
                return;
            }

            if (new Date(start) > new Date(end)) {
                alert('Start Date cannot be later than End Date.');
                return;
            }

            const course = document.getElementById('courseFilterSelect').value;
            let url = 'index.php?action=financials';
            const params = [];
            if (course !== 'all') params.push('course_id=' + encodeURIComponent(course));
            params.push('start_date=' + encodeURIComponent(start));
            params.push('end_date=' + encodeURIComponent(end));

            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            window.location.href = url;
        }

        // Reset Date Range
        function resetDateRange() {
            const course = document.getElementById('courseFilterSelect').value;
            let url = 'index.php?action=financials';
            if (course !== 'all') {
                url += '&course_id=' + encodeURIComponent(course);
            }
            window.location.href = url;
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('datePeriodWrapper');
            const dp = document.getElementById('datePeriodDropdown');
            if (wrapper && dp && !wrapper.contains(e.target)) {
                dp.classList.remove('show');
            }
        });

        function toggleYearSelector() {
            const currentYear = new Date().getFullYear();
            const chosen = prompt("Enter year to inspect earnings history (e.g. " + currentYear + "):", currentYear);
            if (chosen && !isNaN(chosen)) {
                window.location.href = 'index.php?action=financials&year=' + encodeURIComponent(chosen);
            }
        }

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
