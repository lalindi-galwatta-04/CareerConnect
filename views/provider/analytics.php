<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics & Breakdown - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* Specific Styles for Analytics & Breakdown Screen */
        :root {
            --analytics-teal: #0d9488;
            --analytics-teal-dark: #0f766e;
            --analytics-blue: #0284c7;
            --analytics-blue-light: #e0f2fe;
            --analytics-slate: #64748b;
            --analytics-bg: #f8fafc;
        }

        body {
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(at 0% 0%, rgba(2, 132, 199, 0.04) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(13, 148, 136, 0.04) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(2, 132, 199, 0.03) 0px, transparent 50%);
            min-height: 100vh;
        }

        /* Top Header */
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

        /* Analytics Main Container - Balanced for Full Screen */
        .analytics-container {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 95px 45px 60px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Header Row with Title & Filter Controls */
        .analytics-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .analytics-title-group {
            display: flex;
            align-items: baseline;
            gap: 14px;
            flex-wrap: wrap;
        }

        .analytics-title-group h1 {
            font-size: 1.95rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            margin: 0;
            line-height: 1.2;
        }

        .analytics-subtitle {
            font-size: 1.05rem;
            color: #64748b;
            font-weight: 500;
        }

        .analytics-controls-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-select-pill {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #1e293b;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-select-pill:hover,
        .filter-select-pill:focus-within {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .filter-select-pill select {
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.88rem;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            padding-right: 6px;
        }

        .btn-export-report {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: #0284c7;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(2, 132, 199, 0.08);
        }

        .btn-export-report:hover {
            background: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.22);
        }

        /* Top 4 Stat Cards Row */
        .analytics-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        @media (max-width: 1200px) {
            .analytics-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .analytics-stats-row {
                grid-template-columns: 1fr;
            }
        }

        .analytics-stat-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px 22px 20px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s, border-color 0.2s;
            position: relative;
            overflow: hidden;
        }

        .analytics-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .analytics-stat-header {
            font-size: 0.78rem;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .analytics-stat-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .analytics-stat-val {
            font-size: 2.35rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .analytics-stat-sub {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            line-height: 1.35;
        }

        /* Specific Visual Elements for Cards */
        .donut-ring-gauge {
            width: 44px;
            height: 44px;
            position: relative;
            flex-shrink: 0;
        }

        .donut-ring-gauge svg {
            transform: rotate(-90deg);
        }

        .trend-up-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #f0fdf4;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .analytics-stat-card:hover .trend-up-icon-badge {
            transform: scale(1.08);
        }

        .badge-dropoff-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #dcfce7;
            color: #15803d;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            margin-bottom: 4px;
        }

        .star-rating-row {
            display: flex;
            align-items: center;
            gap: 3px;
            margin-bottom: 4px;
        }

        .star-rating-row svg {
            width: 17px;
            height: 17px;
            fill: #f59e0b;
            color: #f59e0b;
        }

        /* Middle Row Grid (Matching Mockup: Left Distribution + Right Donut Stages) */
        .analytics-middle-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        @media (max-width: 1080px) {
            .analytics-middle-grid {
                grid-template-columns: 1fr;
            }
        }

        .analytics-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 26px 28px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .analytics-card:hover {
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .analytics-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .analytics-card-header h2 {
            font-size: 1.22rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.015em;
        }

        .analytics-card-badge {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            background: #f1f5f9;
            color: #475569;
        }

        /* Course Enrollment Distribution List */
        .distribution-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
            justify-content: center;
        }

        .distribution-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .dist-top-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .dist-course-name {
            font-size: 0.98rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dist-course-cat {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 1px 7px;
            border-radius: 6px;
        }

        .dist-student-count {
            font-size: 0.94rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dist-progress-track {
            width: 100%;
            height: 12px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .dist-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0f766e 0%, #0d9488 100%);
            border-radius: 9999px;
            transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .dist-footer-summary {
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.84rem;
            color: #64748b;
        }

        /* Learner Progress & Completion Stages (Donut Chart & Legend) */
        .stages-body-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 28px;
            flex: 1;
            padding: 10px 0;
            flex-wrap: wrap;
        }

        .donut-chart-container {
            position: relative;
            width: 190px;
            height: 190px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .donut-chart-svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .donut-center-text {
            position: absolute;
            text-align: center;
            pointer-events: none;
        }

        .donut-center-number {
            font-size: 1.7rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .donut-center-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }

        .stages-legend-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-width: 190px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .legend-label-group {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.94rem;
            font-weight: 600;
            color: #1e293b;
        }

        .legend-color-dot {
            width: 13px;
            height: 13px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-count-badge {
            font-size: 0.88rem;
            font-weight: 700;
            color: #475569;
            background: #f1f5f9;
            padding: 2px 9px;
            border-radius: 999px;
        }

        .stages-meta-pills {
            display: flex;
            gap: 12px;
            margin-top: 18px;
            padding-top: 14px;
            border-top: 1px dashed #e2e8f0;
        }

        .stage-meta-pill {
            flex: 1;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 12px;
            text-align: center;
        }

        .stage-meta-pill .val {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }

        .stage-meta-pill .lbl {
            font-size: 0.74rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
        }

        /* Full-Screen Balanced Row: Monthly Learner Growth & Trajectory Chart */
        .chart-analytics-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 26px 30px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .chart-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 14px;
        }

        .chart-legend-row {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .chart-legend-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.86rem;
            font-weight: 600;
            color: #475569;
        }

        .chart-legend-line {
            width: 22px;
            height: 3px;
            border-radius: 2px;
        }

        .chart-svg-wrapper {
            width: 100%;
            height: 240px;
            position: relative;
        }

        .chart-stats-summary-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        @media (max-width: 768px) {
            .chart-stats-summary-bar {
                grid-template-columns: 1fr;
            }
        }

        .chart-summary-stat-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
        }

        .chart-summary-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #e0f2fe;
            color: #0284c7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .chart-summary-val {
            font-size: 1.12rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .chart-summary-lbl {
            font-size: 0.76rem;
            font-weight: 600;
            color: #64748b;
        }

        /* Detailed Matrix Table - Balances & Fills the Full Screen */
        .matrix-table-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 26px 30px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .matrix-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
        }

        .table-search-input-wrapper {
            position: relative;
            min-width: 260px;
        }

        .table-search-input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.88rem;
            color: #1e293b;
            outline: none;
            transition: var(--transition);
        }

        .table-search-input:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .table-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .matrix-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        .matrix-table th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 14px 18px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .matrix-table th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            border-left: 1px solid #e2e8f0;
        }

        .matrix-table th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-right: 1px solid #e2e8f0;
        }

        .matrix-table td {
            padding: 16px 18px;
            font-size: 0.92rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .matrix-table tbody tr {
            transition: background 0.15s;
        }

        .matrix-table tbody tr:hover {
            background: #f8fafc;
        }

        .badge-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .badge-status-top {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-status-high {
            background: #e0f2fe;
            color: #0369a1;
        }

        .badge-status-steady {
            background: #fef3c7;
            color: #b45309;
        }

        .mini-meter {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #0f172a;
        }

        .mini-meter-bar {
            width: 70px;
            height: 7px;
            background: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
        }

        .mini-meter-fill {
            height: 100%;
            background: #0284c7;
            border-radius: 999px;
        }

        .action-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #0284c7;
            transition: var(--transition);
        }

        .action-link-btn:hover {
            background: #0284c7;
            color: #ffffff;
        }

        /* Strategic Insights Bento Grid */
        .insights-bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 992px) {
            .insights-bento-grid {
                grid-template-columns: 1fr;
            }
        }

        .insight-bento-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 22px 24px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .insight-bento-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #0284c7;
        }

        .insight-bento-card.teal::before {
            background: #0d9488;
        }

        .insight-bento-card.amber::before {
            background: #f59e0b;
        }

        .insight-bento-title {
            font-size: 0.94rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .insight-bento-text {
            font-size: 0.86rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* Print styles */
        @media print {
            .navbar, .provider-top-header, .filter-select-pill, .btn-export-report {
                display: none !important;
            }
            .analytics-container {
                width: 100% !important;
                margin: 0 !important;
                padding: 10px !important;
            }
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

            <!-- Analytics & Breakdown (Currently Active Tab) -->
            <a href="index.php?action=provider_dashboard&view=analytics" class="sidebar-nav-item active">
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

    <!-- Main Analytics Content Area (Fluid & Full Screen Balanced) -->
    <main class="analytics-container">
        <!-- Header Row with Title & Filter Selects Matching UI Mockup -->
        <div class="analytics-header-row">
            <div class="analytics-title-group">
                <h1>Analytics & Breakdown</h1>
                <span class="analytics-subtitle">Performance & Learner Insights</span>
            </div>

            <div class="analytics-controls-group">
                <!-- Select Course Dropdown -->
                <div class="filter-select-pill">
                    <span style="color: #64748b; margin-right: 6px;">Select Course:</span>
                    <select id="courseSelectFilter" onchange="applyAnalyticsFilters()">
                        <option value="all" <?php echo ($selectedCourse === 'all') ? 'selected' : ''; ?>>All Courses</option>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?php echo $c['course_id']; ?>" <?php echo ((string)$selectedCourse === (string)$c['course_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="2">Python for Beginners</option>
                            <option value="101">UI/UX Design</option>
                            <option value="3">Software Architectures</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Time Period Dropdown -->
                <div class="filter-select-pill">
                    <span style="color: #64748b; margin-right: 6px;">Time Period:</span>
                    <select id="periodSelectFilter" onchange="applyAnalyticsFilters()">
                        <option value="this_year" <?php echo ($selectedPeriod === 'this_year') ? 'selected' : ''; ?>>This Year (2026)</option>
                        <option value="last_6_months" <?php echo ($selectedPeriod === 'last_6_months') ? 'selected' : ''; ?>>Last 6 Months</option>
                        <option value="last_30_days" <?php echo ($selectedPeriod === 'last_30_days') ? 'selected' : ''; ?>>Last 30 Days</option>
                        <option value="all_time" <?php echo ($selectedPeriod === 'all_time') ? 'selected' : ''; ?>>All Time</option>
                    </select>
                </div>

                <!-- Export Report Action -->
                <button type="button" class="btn-export-report" onclick="window.print()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Export Report</span>
                </button>
            </div>
        </div>

        <!-- 4 Top KPI Stat Cards (Matching Mockup: Rate, Engagement, Drop-off, Feedback) -->
        <div class="analytics-stats-row">
            <!-- Card 1: AVG. COMPLETION RATE -->
            <div class="analytics-stat-card">
                <div>
                    <div class="analytics-stat-header">AVG. COMPLETION RATE</div>
                    <div class="analytics-stat-body">
                        <div class="analytics-stat-val"><?php echo (int)($analytics['avg_completion_rate'] ?? 68); ?>%</div>
                        <!-- Donut Ring Indicator -->
                        <div class="donut-ring-gauge" title="68% Finished">
                            <svg viewBox="0 0 44 44" width="44" height="44">
                                <circle cx="22" cy="22" r="17" fill="none" stroke="#e2e8f0" stroke-width="4.5" />
                                <?php 
                                    $circ = 2 * 3.14159 * 17;
                                    $dash = ($circ * (int)($analytics['avg_completion_rate'] ?? 68)) / 100;
                                ?>
                                <circle cx="22" cy="22" r="17" fill="none" stroke="#0f766e" stroke-width="4.5" 
                                        stroke-dasharray="<?php echo round($dash, 1); ?> <?php echo round($circ, 1); ?>" 
                                        stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="analytics-stat-sub">Job seekers finishing courses</div>
            </div>

            <!-- Card 2: COURSE ENGAGEMENT -->
            <div class="analytics-stat-card">
                <div>
                    <div class="analytics-stat-header">COURSE ENGAGEMENT</div>
                    <div class="analytics-stat-body">
                        <div class="analytics-stat-val"><?php echo (int)($analytics['course_engagement'] ?? 78); ?>%</div>
                        <div class="trend-up-icon-badge" title="High Engagement">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="analytics-stat-sub">Weekly active learners</div>
            </div>

            <!-- Card 3: DROP-OFF RATE -->
            <div class="analytics-stat-card">
                <div>
                    <div class="analytics-stat-header">DROP-OFF RATE</div>
                    <div class="analytics-stat-body">
                        <div class="analytics-stat-val"><?php echo (int)($analytics['drop_off_rate'] ?? 12); ?>%</div>
                    </div>
                </div>
                <div>
                    <div class="badge-dropoff-pill">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <polyline points="19 12 12 19 5 12"></polyline>
                        </svg>
                        <span><?php echo htmlspecialchars($analytics['drop_off_change'] ?? '-2.4% from last month'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Card 4: AVG. FEEDBACK SCORE -->
            <div class="analytics-stat-card">
                <div>
                    <div class="analytics-stat-header">AVG. FEEDBACK SCORE</div>
                    <div class="analytics-stat-body">
                        <div class="analytics-stat-val"><?php echo number_format($analytics['avg_feedback_score'] ?? 4.7, 1); ?> / 5</div>
                    </div>
                </div>
                <div>
                    <div class="star-rating-row">
                        <!-- 5 Stars with 4.7 score visual -->
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div class="analytics-stat-sub">Based on <?php echo (int)($analytics['ratings_count'] ?? 120); ?> learner ratings</div>
                </div>
            </div>
        </div>

        <!-- Middle Row Grid (Exact Mockup Match: Left Course Enrollment Distribution | Right Learner Stages Donut) -->
        <div class="analytics-middle-grid">
            <!-- Left Card: Course Enrollment Distribution -->
            <div class="analytics-card">
                <div class="analytics-card-header">
                    <h2>Course Enrollment Distribution</h2>
                    <span class="analytics-card-badge"><?php echo count($analytics['distribution'] ?? []); ?> Active Courses</span>
                </div>

                <div class="distribution-list">
                    <?php if (!empty($analytics['distribution'])): ?>
                        <?php foreach ($analytics['distribution'] as $item): ?>
                            <div class="distribution-item">
                                <div class="dist-top-row">
                                    <div class="dist-course-name">
                                        <span><?php echo htmlspecialchars($item['title']); ?></span>
                                        <?php if (!empty($item['category'])): ?>
                                            <span class="dist-course-cat"><?php echo htmlspecialchars($item['category']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="dist-student-count"><?php echo (int)$item['students']; ?> students</span>
                                </div>
                                <div class="dist-progress-track">
                                    <div class="dist-progress-fill" style="width: <?php echo min(100, max(5, (int)$item['percentage'])); ?>%;"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="dist-footer-summary">
                    <span>Total Tracked Learners: <strong><?php echo (int)($analytics['total_learners'] ?? 115); ?></strong></span>
                    <span style="color: #0d9488; font-weight: 700;">+24% Enrollment Velocity YoY</span>
                </div>
            </div>

            <!-- Right Card: Learner Progress & Completion Stages (SVG Donut Chart & Legend) -->
            <div class="analytics-card">
                <div class="analytics-card-header">
                    <h2>Learner Progress & Completion Stages</h2>
                    <span class="analytics-card-badge">Cohort Status</span>
                </div>

                <div class="stages-body-wrapper">
                    <!-- High-Resolution SVG Donut Chart Matching Mockup Colors -->
                    <div class="donut-chart-container">
                        <svg class="donut-chart-svg" viewBox="0 0 100 100">
                            <!-- Background ring -->
                            <circle cx="50" cy="50" r="38" fill="none" stroke="#f1f5f9" stroke-width="12" />

                            <?php 
                                // Circumference = 2 * PI * 38 = 238.76
                                $cRadius = 38;
                                $circumference = 238.76;

                                // Stages: Not Started (15%), In Progress (58%), Completed (27%)
                                $pctNotStarted = 15;
                                $pctInProgress = 58;
                                $pctCompleted = 27;

                                $dashNotStarted = ($circumference * $pctNotStarted) / 100;
                                $dashInProgress = ($circumference * $pctInProgress) / 100;
                                $dashCompleted = ($circumference * $pctCompleted) / 100;

                                // Offset accumulates backwards since stroke runs clockwise
                                $offset1 = 0;
                                $offset2 = -$dashNotStarted;
                                $offset3 = -($dashNotStarted + $dashInProgress);
                            ?>

                            <!-- Segment 1: Not Started (15%) - light cyan / slate-300 -->
                            <circle cx="50" cy="50" r="38" fill="none" stroke="#cbd5e1" stroke-width="12"
                                    stroke-dasharray="<?php echo $dashNotStarted; ?> <?php echo $circumference; ?>"
                                    stroke-dashoffset="<?php echo $offset1; ?>" />

                            <!-- Segment 2: In Progress (58%) - deep teal #0f766e -->
                            <circle cx="50" cy="50" r="38" fill="none" stroke="#0f766e" stroke-width="12"
                                    stroke-dasharray="<?php echo $dashInProgress; ?> <?php echo $circumference; ?>"
                                    stroke-dashoffset="<?php echo $offset2; ?>" />

                            <!-- Segment 3: Completed (27%) - vibrant blue #0284c7 -->
                            <circle cx="50" cy="50" r="38" fill="none" stroke="#0284c7" stroke-width="12"
                                    stroke-dasharray="<?php echo $dashCompleted; ?> <?php echo $circumference; ?>"
                                    stroke-dashoffset="<?php echo $offset3; ?>" />
                        </svg>

                        <!-- Donut Center Text -->
                        <div class="donut-center-text">
                            <div class="donut-center-number"><?php echo (int)($analytics['total_learners'] ?? 115); ?></div>
                            <div class="donut-center-label">Learners</div>
                        </div>
                    </div>

                    <!-- Legend Items Matching Mockup -->
                    <div class="stages-legend-list">
                        <!-- Stage 1 -->
                        <div class="legend-item">
                            <div class="legend-label-group">
                                <span class="legend-color-dot" style="background: #cbd5e1;"></span>
                                <span>Not Started (15%)</span>
                            </div>
                            <span class="legend-count-badge">17</span>
                        </div>

                        <!-- Stage 2 -->
                        <div class="legend-item">
                            <div class="legend-label-group">
                                <span class="legend-color-dot" style="background: #0f766e;"></span>
                                <span>In Progress (58%)</span>
                            </div>
                            <span class="legend-count-badge">67</span>
                        </div>

                        <!-- Stage 3 -->
                        <div class="legend-item">
                            <div class="legend-label-group">
                                <span class="legend-color-dot" style="background: #0284c7;"></span>
                                <span>Completed (27%)</span>
                            </div>
                            <span class="legend-count-badge">31</span>
                        </div>
                    </div>
                </div>

                <div class="stages-meta-pills">
                    <div class="stage-meta-pill">
                        <div class="val">6.4 Weeks</div>
                        <div class="lbl">Avg. Time to Graduate</div>
                    </div>
                    <div class="stage-meta-pill">
                        <div class="val">31 Issued</div>
                        <div class="lbl">Verified Certifications</div>
                    </div>
                    <div class="stage-meta-pill">
                        <div class="val">94.2%</div>
                        <div class="lbl">Quiz Pass Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FULL-SCREEN BALANCING ROW 1: Monthly Learner Growth & Completion Trajectory Chart -->
        <div class="chart-analytics-card">
            <div class="chart-header-flex">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Learner Engagement & Completion Trajectory</h2>
                    <span style="font-size: 0.88rem; color: #64748b;">Month-over-month active enrollment influx vs successful completions (2026)</span>
                </div>

                <div class="chart-legend-row">
                    <div class="chart-legend-indicator">
                        <span class="chart-legend-line" style="background: #0284c7;"></span>
                        <span>New Enrollments</span>
                    </div>
                    <div class="chart-legend-indicator">
                        <span class="chart-legend-line" style="background: #0d9488;"></span>
                        <span>Course Completions</span>
                    </div>
                </div>
            </div>

            <!-- SVG Multi-Series Area & Line Trajectory Chart -->
            <?php
                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $enrolledPoints = [14, 20, 26, 32, 30, 40, 46, 54, 64, 59, 68, 74];
                $completedPoints = [9, 14, 18, 22, 24, 28, 32, 38, 44, 48, 52, 56];
                $maxVal = 80;

                $svgW = 920;
                $svgH = 200;
                $spacing = $svgW / (count($months) - 1);

                $ptsEnrolled = [];
                $ptsCompleted = [];
                for ($i = 0; $i < count($months); $i++) {
                    $x = round($i * $spacing, 1);
                    $yE = round(175 - (($enrolledPoints[$i] / $maxVal) * 150), 1);
                    $yC = round(175 - (($completedPoints[$i] / $maxVal) * 150), 1);
                    $ptsEnrolled[] = ['x' => $x, 'y' => $yE, 'val' => $enrolledPoints[$i], 'm' => $months[$i]];
                    $ptsCompleted[] = ['x' => $x, 'y' => $yC, 'val' => $completedPoints[$i], 'm' => $months[$i]];
                }

                // Path for enrolled area
                $pathE = "M " . $ptsEnrolled[0]['x'] . "," . $ptsEnrolled[0]['y'];
                for ($i = 0; $i < count($ptsEnrolled) - 1; $i++) {
                    $p0 = $ptsEnrolled[$i];
                    $p1 = $ptsEnrolled[$i + 1];
                    $cpx = round(($p0['x'] + $p1['x']) / 2, 1);
                    $pathE .= " C $cpx," . $p0['y'] . " $cpx," . $p1['y'] . " " . $p1['x'] . "," . $p1['y'];
                }
                $areaE = $pathE . " L " . $ptsEnrolled[count($ptsEnrolled)-1]['x'] . ",180 L 0,180 Z";

                // Path for completed curve
                $pathC = "M " . $ptsCompleted[0]['x'] . "," . $ptsCompleted[0]['y'];
                for ($i = 0; $i < count($ptsCompleted) - 1; $i++) {
                    $p0 = $ptsCompleted[$i];
                    $p1 = $ptsCompleted[$i + 1];
                    $cpx = round(($p0['x'] + $p1['x']) / 2, 1);
                    $pathC .= " C $cpx," . $p0['y'] . " $cpx," . $p1['y'] . " " . $p1['x'] . "," . $p1['y'];
                }
            ?>

            <div class="chart-svg-wrapper">
                <svg viewBox="0 0 1020 220" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                    <defs>
                        <linearGradient id="areaGradEnrolled" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#0284c7" stop-opacity="0.22" />
                            <stop offset="100%" stop-color="#0284c7" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>

                    <!-- Y-Axis Labels -->
                    <text x="0" y="28" fill="#94a3b8" font-size="11" font-weight="600">80</text>
                    <text x="0" y="80" fill="#94a3b8" font-size="11" font-weight="600">50</text>
                    <text x="0" y="130" fill="#94a3b8" font-size="11" font-weight="600">25</text>
                    <text x="8" y="180" fill="#94a3b8" font-size="11" font-weight="600">0</text>

                    <g transform="translate(45, 0)">
                        <!-- Horizontal Grid Lines -->
                        <line x1="0" y1="25" x2="920" y2="25" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="0" y1="75" x2="920" y2="75" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="0" y1="125" x2="920" y2="125" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="0" y1="175" x2="920" y2="175" stroke="#e2e8f0" stroke-width="1.5" />

                        <!-- Area Fill -->
                        <path d="<?php echo $areaE; ?>" fill="url(#areaGradEnrolled)" />

                        <!-- Enrolled Curve -->
                        <path d="<?php echo $pathE; ?>" fill="none" stroke="#0284c7" stroke-width="3" stroke-linecap="round" />

                        <!-- Completed Curve -->
                        <path d="<?php echo $pathC; ?>" fill="none" stroke="#0d9488" stroke-width="2.6" stroke-dasharray="4 3" stroke-linecap="round" />

                        <!-- Dots on Enrolled Points -->
                        <?php foreach ($ptsEnrolled as $pt): ?>
                            <circle cx="<?php echo $pt['x']; ?>" cy="<?php echo $pt['y']; ?>" r="4" fill="#ffffff" stroke="#0284c7" stroke-width="2.5" />
                        <?php endforeach; ?>

                        <!-- Dots on Completed Points -->
                        <?php foreach ($ptsCompleted as $pt): ?>
                            <circle cx="<?php echo $pt['x']; ?>" cy="<?php echo $pt['y']; ?>" r="3.5" fill="#ffffff" stroke="#0d9488" stroke-width="2.5" />
                        <?php endforeach; ?>

                        <!-- X-Axis Month Labels -->
                        <?php foreach ($ptsEnrolled as $pt): ?>
                            <text x="<?php echo $pt['x']; ?>" y="206" fill="#64748b" font-size="12" font-weight="600" text-anchor="middle"><?php echo $pt['m']; ?></text>
                        <?php endforeach; ?>
                    </g>
                </svg>
            </div>

            <div class="chart-stats-summary-bar">
                <div class="chart-summary-stat-box">
                    <div class="chart-summary-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    </div>
                    <div>
                        <div class="chart-summary-val">September (64 Learners)</div>
                        <div class="chart-summary-lbl">Peak Influx Period</div>
                    </div>
                </div>

                <div class="chart-summary-stat-box">
                    <div class="chart-summary-icon" style="background: #dcfce7; color: #15803d;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div>
                        <div class="chart-summary-val">+18.5% YoY</div>
                        <div class="chart-summary-lbl">Completion Velocity</div>
                    </div>
                </div>

                <div class="chart-summary-stat-box">
                    <div class="chart-summary-icon" style="background: #fef3c7; color: #b45309;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div class="chart-summary-val">~4.8 hrs / week</div>
                        <div class="chart-summary-lbl">Avg. Learner Engagement Time</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FULL-SCREEN BALANCING ROW 2: Detailed Course Performance Matrix Table -->
        <div class="matrix-table-card">
            <div class="matrix-table-header">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Course Performance & Learner Success Matrix</h2>
                    <span style="font-size: 0.88rem; color: #64748b;">Granular breakdown across all active educational offerings</span>
                </div>

                <div class="table-search-input-wrapper">
                    <span class="table-search-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </span>
                    <input type="text" id="courseMatrixSearch" class="table-search-input" placeholder="Search course by name..." onkeyup="filterMatrixTable()">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="matrix-table" id="matrixTable">
                    <thead>
                        <tr>
                            <th>Program / Course</th>
                            <th>Enrolled</th>
                            <th>Active Learners</th>
                            <th>Completion Rate</th>
                            <th>Drop-off</th>
                            <th>Feedback Score</th>
                            <th>Performance Status</th>
                            <th>Quick Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($analytics['performance_matrix'] as $row): ?>
                            <tr class="matrix-row" data-title="<?php echo htmlspecialchars(strtolower($row['title'])); ?>">
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <div style="font-size: 0.78rem; color: #64748b;"><?php echo htmlspecialchars($row['category']); ?></div>
                                </td>
                                <td style="font-weight: 700; color: #1e293b;"><?php echo (int)$row['enrolled']; ?> Students</td>
                                <td style="font-weight: 600; color: #0d9488;"><?php echo (int)$row['active']; ?> In-Progress</td>
                                <td>
                                    <div class="mini-meter">
                                        <div class="mini-meter-bar">
                                            <div class="mini-meter-fill" style="width: <?php echo (int)$row['completion_rate']; ?>%;"></div>
                                        </div>
                                        <span><?php echo (int)$row['completion_rate']; ?>%</span>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: #e11d48;"><?php echo (int)$row['drop_off_rate']; ?>%</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 4px; font-weight: 700; color: #0f172a;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#f59e0b" color="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span><?php echo number_format($row['rating'], 1); ?></span>
                                        <span style="font-size: 0.75rem; color: #64748b; font-weight: normal;">(<?php echo (int)$row['reviews']; ?>)</span>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'Top Performer'): ?>
                                        <span class="badge-status-chip badge-status-top">★ Top Performer</span>
                                    <?php elseif ($row['status'] === 'High Engagement'): ?>
                                        <span class="badge-status-chip badge-status-high">⚡ High Engagement</span>
                                    <?php else: ?>
                                        <span class="badge-status-chip badge-status-steady">● Steady Growth</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?action=provider_dashboard&view=courses" class="action-link-btn">
                                        <span>Manage</span>
                                        <span style="font-size: 10px;">→</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FULL-SCREEN BALANCING ROW 3: Strategic Insights Bento Cards -->
        <div class="insights-bento-grid">
            <div class="insight-bento-card">
                <div class="insight-bento-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.4"><path d="M12 15l-2 5l9-11h-7l2-5l-9 11h7z"></path></svg>
                    <span>High Completion Milestone</span>
                </div>
                <div class="insight-bento-text">
                    <strong>94.2%</strong> of learners who complete Week 3 coursework successfully graduate. Consider scheduling instructor check-ins during Week 2 to optimize retention.
                </div>
            </div>

            <div class="insight-bento-card teal">
                <div class="insight-bento-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2.4"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    <span>Proactive Retention Warning</span>
                </div>
                <div class="insight-bento-text">
                    Dropout risk dropped by <strong>-2.4%</strong> this month. Automated milestone email nudges for inactive learners have reclaimed 14 previously stalled students.
                </div>
            </div>

            <div class="insight-bento-card amber">
                <div class="insight-bento-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.4"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>Student Satisfaction Benchmark</span>
                </div>
                <div class="insight-bento-text">
                    Your institutional feedback score of <strong>4.7 / 5</strong> places ABC Institute in the top 5% of training providers across the entire CareerConnect platform.
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

        // Analytics Filter Dispatcher
        function applyAnalyticsFilters() {
            const courseSelect = document.getElementById('courseSelectFilter');
            const periodSelect = document.getElementById('periodSelectFilter');
            const courseVal = courseSelect ? courseSelect.value : 'all';
            const periodVal = periodSelect ? periodSelect.value : 'this_year';

            window.location.href = 'index.php?action=provider_dashboard&view=analytics&course_id=' + encodeURIComponent(courseVal) + '&period=' + encodeURIComponent(periodVal);
        }

        // Live Table Search Filter
        function filterMatrixTable() {
            const query = (document.getElementById('courseMatrixSearch').value || '').toLowerCase().trim();
            const rows = document.querySelectorAll('.matrix-row');

            rows.forEach(row => {
                const title = row.getAttribute('data-title') || '';
                if (!query || title.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
