<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* Specific Styles for My Courses Screen Matching UI Mockup */
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

        /* Courses Main Container Card */
        .courses-page-container {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 95px 45px 50px;
            min-height: 100vh;
        }

        .courses-main-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 36px 40px 48px;
            box-shadow: 0 6px 24px rgba(9, 40, 83, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.85);
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Row */
        .courses-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .courses-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .btn-add-course {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0284c7;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
            transition: all 0.2s ease;
        }

        .btn-add-course:hover {
            background: #0369a1;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
            color: #ffffff;
        }

        /* Filter Controls Bar */
        .courses-filter-bar {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .courses-search-wrapper {
            width: 250px;
        }

        .courses-search-input {
            width: 100%;
            height: 40px;
            padding: 0 16px;
            font-size: 0.92rem;
            color: #0f172a;
            background: #ffffff;
            border: 1px solid #94a3b8;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .courses-search-input:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .courses-search-input::placeholder {
            color: #94a3b8;
        }

        .courses-dropdown-wrapper {
            position: relative;
        }

        .courses-select {
            height: 40px;
            padding: 0 36px 0 16px;
            font-size: 0.92rem;
            font-weight: 500;
            color: #334155;
            background: #ffffff;
            border: 1px solid #94a3b8;
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: border-color 0.2s;
        }

        .courses-select:focus {
            border-color: #0284c7;
        }

        .dropdown-chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #64748b;
            font-size: 11px;
        }

        /* 3-Column Courses Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 26px;
        }

        @media (max-width: 1200px) {
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Individual Course Card */
        .course-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(9, 40, 83, 0.09);
            border-color: #94a3b8;
        }

        /* Card Banner (Colored Top) */
        .course-card-banner {
            height: 165px;
            width: 100%;
            position: relative;
        }

        /* Card Body (White Bottom) */
        .course-card-body {
            background: #ffffff;
            padding: 20px 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            min-height: 98px;
            gap: 14px;
            position: relative;
        }

        .course-card-content {
            flex: 1;
            min-width: 0;
        }

        .course-card-title {
            font-size: 1.18rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.35;
            margin: 0;
            word-wrap: break-word;
        }

        .course-card-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            font-size: 0.82rem;
            color: #64748b;
        }

        .course-card-meta-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        /* Kebab Options Button */
        .course-kebab-container {
            position: relative;
            flex-shrink: 0;
        }

        .course-kebab-btn {
            background: transparent;
            border: none;
            padding: 6px 4px;
            cursor: pointer;
            color: #0f172a;
            display: flex;
            flex-direction: column;
            gap: 3px;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }

        .course-kebab-btn:hover {
            background: #f1f5f9;
            color: #0284c7;
        }

        .course-kebab-dot {
            width: 4px;
            height: 4px;
            background: currentColor;
            border-radius: 50%;
        }

        /* Floating Action Menu */
        .course-action-menu {
            position: absolute;
            bottom: 35px;
            right: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(9, 40, 83, 0.12);
            padding: 6px;
            min-width: 185px;
            display: none;
            z-index: 100;
        }

        .course-action-menu.active {
            display: block;
            animation: menuFadeIn 0.15s ease-out;
        }

        @keyframes menuFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .course-action-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: #334155;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .course-action-item:hover {
            background: #f1f5f9;
            color: #0284c7;
        }

        .course-action-item.text-danger {
            color: #dc2626;
        }

        .course-action-item.text-danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .course-menu-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 4px 0;
        }

        /* List View (Toggleable) */
        .courses-list-view {
            display: none;
            overflow-x: auto;
        }

        .courses-list-view.active {
            display: block;
        }

        /* Empty State */
        .courses-empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
        }

        .courses-empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .courses-empty-desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 20px;
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
            <a href="index.php?action=provider_dashboard&view=courses" class="sidebar-nav-item active">
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

    <!-- Top Header -->
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
    <main class="courses-page-container">
        <div class="courses-main-card">
            <!-- Header Row -->
            <div class="courses-header-row">
                <h1 class="courses-title">My Courses</h1>
                <a href="index.php?action=manage_course&mode=new" class="btn-add-course">+ Add New Course</a>
            </div>

            <!-- Filter Controls Bar -->
            <div class="courses-filter-bar">
                <!-- Search Box -->
                <div class="courses-search-wrapper">
                    <input type="text" id="courseSearchInput" class="courses-search-input" placeholder="Search" autocomplete="off">
                </div>

                <!-- Sort By Dropdown -->
                <div class="courses-dropdown-wrapper">
                    <select id="courseSortSelect" class="courses-select">
                        <option value="last_accessed">Sort by last accessed</option>
                        <option value="title_asc">Title (A - Z)</option>
                        <option value="title_desc">Title (Z - A)</option>
                        <option value="enrollments_desc">Most Enrolled</option>
                        <option value="fee_desc">Highest Fee</option>
                    </select>
                    <span class="dropdown-chevron">▼</span>
                </div>

                <!-- View Switcher Dropdown (Card / List) -->
                <div class="courses-dropdown-wrapper">
                    <select id="courseViewSelect" class="courses-select">
                        <option value="card">Card</option>
                        <option value="list">List</option>
                    </select>
                    <span class="dropdown-chevron">▼</span>
                </div>
            </div>

            <?php
            // Harmonious vibrant palette dynamically assigned to courses from the database
            $palette = [
                '#0e4a95', // Deep Royal Blue
                '#12734e', // Forest Green
                '#3c35a6', // Deep Indigo / Purple
                '#b05704', // Warm Ochre / Saddle Brown
                '#177373', // Deep Pine Teal
                '#7a132b', // Crimson / Burgundy
                '#0284c7', // Sky Blue
                '#6b21a8', // Purple
                '#c2410c', // Rust Amber
                '#0f766e', // Persian Green
            ];
            ?>

            <!-- Card Grid View (Active by Default) -->
            <div class="courses-grid" id="coursesGrid">
                <?php if (empty($courses)): ?>
                    <div class="courses-empty-state" id="emptyCoursesGrid">
                        <div class="courses-empty-title">No Courses Added Yet</div>
                        <p class="courses-empty-desc">You haven't published any training courses yet. Start by adding your first course.</p>
                        <a href="index.php?action=manage_course&mode=new" class="btn-add-course">+ Add New Course</a>
                    </div>
                <?php else: ?>
                    <?php 
                    $cardIndex = 0;
                    foreach ($courses as $c): 
                        $bannerColor = $palette[$cardIndex % count($palette)];
                        $cardIndex++;
                        $normalizedTitle = strtolower(trim($c['title']));
                    ?>
                        <div class="course-card" 
                             data-title="<?php echo htmlspecialchars($normalizedTitle); ?>" 
                             data-category="<?php echo htmlspecialchars(strtolower($c['category'] ?? '')); ?>"
                             data-created="<?php echo strtotime($c['created_at'] ?? 'now'); ?>" 
                             data-enrollments="<?php echo (int)($c['total_enrollments'] ?? 0); ?>" 
                             data-fee="<?php echo (float)($c['fee'] ?? 0); ?>">
                            
                            <!-- Top Colored Banner Block -->
                            <div class="course-card-banner" style="background-color: <?php echo $bannerColor; ?>;"></div>

                            <!-- Bottom White Content Block -->
                            <div class="course-card-body">
                                <div class="course-card-content" onclick="window.location.href='index.php?action=manage_course&id=<?php echo $c['course_id']; ?>'" style="cursor: pointer;">
                                    <h2 class="course-card-title"><?php echo htmlspecialchars($c['title']); ?></h2>
                                    <div class="course-card-meta">
                                        <span class="course-card-meta-badge"><?php echo htmlspecialchars($c['category'] ?? 'Course'); ?></span>
                                        <span>•</span>
                                        <span><?php echo (int)($c['total_enrollments'] ?? 0); ?> Enrolled</span>
                                    </div>
                                </div>

                                <!-- Kebab Action Menu Trigger -->
                                <div class="course-kebab-container">
                                    <button type="button" class="course-kebab-btn" aria-label="Course actions" onclick="toggleCourseMenu(event, '<?php echo $c['course_id']; ?>')">
                                        <span class="course-kebab-dot"></span>
                                        <span class="course-kebab-dot"></span>
                                        <span class="course-kebab-dot"></span>
                                    </button>

                                    <!-- Floating Popup Action Menu -->
                                    <div class="course-action-menu" id="courseMenu-<?php echo $c['course_id']; ?>">
                                        <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>" class="course-action-item">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            Course Profile & Management
                                        </a>

                                        <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>&mode=edit" class="course-action-item">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                            </svg>
                                            Edit Details
                                        </a>

                                        <a href="index.php?action=provider_dashboard&view=roster&course_id=<?php echo $c['course_id']; ?>" class="course-action-item">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                            </svg>
                                            Student Roster
                                        </a>

                                        <a href="index.php?action=provider_dashboard&view=grading&course_id=<?php echo $c['course_id']; ?>" class="course-action-item">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                            Grading & Results
                                        </a>

                                        <div class="course-menu-divider"></div>

                                        <?php if (($c['total_enrollments'] ?? 0) > 0): ?>
                                            <button type="button" class="course-action-item text-danger" onclick="alert('Cannot delete this course because <?php echo $c['total_enrollments']; ?> student(s) are currently enrolled.');">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                Delete Course
                                            </button>
                                        <?php else: ?>
                                            <a href="index.php?action=delete_course&id=<?php echo $c['course_id']; ?>" class="course-action-item text-danger" onclick="return confirm('Are you sure you want to delete this course?')">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                Delete Course
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- List View (Alternative View Table) -->
            <div class="courses-list-view" id="coursesListView">
                <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                            <th style="padding: 12px 14px;">Course Title</th>
                            <th style="padding: 12px 14px;">Category</th>
                            <th style="padding: 12px 14px;">Duration</th>
                            <th style="padding: 12px 14px;">Fee</th>
                            <th style="padding: 12px 14px;">Enrollments</th>
                            <th style="padding: 12px 14px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="coursesListTbody">
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No courses available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($courses as $c): ?>
                                <tr class="course-list-row" 
                                    data-title="<?php echo htmlspecialchars(strtolower($c['title'])); ?>"
                                    data-created="<?php echo strtotime($c['created_at'] ?? 'now'); ?>"
                                    data-enrollments="<?php echo (int)($c['total_enrollments'] ?? 0); ?>"
                                    data-fee="<?php echo (float)($c['fee'] ?? 0); ?>"
                                    style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 14px 14px; font-weight: 700; color: #0f172a;">
                                        <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>" style="color: #0284c7; text-decoration: none;" title="Open Course Profile"><?php echo htmlspecialchars($c['title']); ?></a>
                                    </td>
                                    <td style="padding: 14px 14px;"><span class="status status-pending"><?php echo htmlspecialchars($c['category'] ?? 'N/A'); ?></span></td>
                                    <td style="padding: 14px 14px; color: #64748b;"><?php echo htmlspecialchars($c['duration'] ?? 'N/A'); ?></td>
                                    <td style="padding: 14px 14px; font-weight: 700; color: #07a489;">LKR <?php echo number_format($c['fee'], 2); ?></td>
                                    <td style="padding: 14px 14px;"><span class="status status-approved"><?php echo (int)$c['total_enrollments']; ?> Enrolled</span></td>
                                    <td style="padding: 14px 14px; text-align: right; white-space: nowrap;">
                                        <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; margin-right: 0.3rem;" title="View Course Profile & Curriculum">Profile</a>
                                        <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>&mode=edit" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; margin-right: 0.3rem;" title="Edit Course Info">Edit</a>
                                        <a href="index.php?action=provider_dashboard&view=roster&course_id=<?php echo $c['course_id']; ?>" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; margin-right: 0.3rem;">Roster</a>
                                        <?php if (($c['total_enrollments'] ?? 0) > 0): ?>
                                            <button type="button" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; opacity: 0.5; cursor: not-allowed;" onclick="alert('Cannot delete course with active enrollments.');">Delete</button>
                                        <?php else: ?>
                                            <a href="index.php?action=delete_course&id=<?php echo $c['course_id']; ?>" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.82rem;" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Interactive Scripts for Filtering, Sorting, View Toggle, and Dropdowns -->
    <script>
        // Kebab Menu Toggle
        function toggleCourseMenu(event, courseId) {
            event.stopPropagation();
            const targetMenu = document.getElementById('courseMenu-' + courseId);
            const allMenus = document.querySelectorAll('.course-action-menu');
            
            allMenus.forEach(menu => {
                if (menu !== targetMenu) {
                    menu.classList.remove('active');
                }
            });

            if (targetMenu) {
                targetMenu.classList.toggle('active');
            }
        }

        // Close dropdown menus when clicking outside
        document.addEventListener('click', function(e) {
            const activeMenus = document.querySelectorAll('.course-action-menu.active');
            activeMenus.forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });

            // Profile dropdown
            const userProfile = document.getElementById('userProfile');
            const profileDropdown = document.getElementById('profileDropdown');
            if (userProfile && profileDropdown && !userProfile.contains(e.target)) {
                userProfile.classList.remove('open');
                profileDropdown.classList.remove('show');
            }
        });

        // Profile Button Toggle
        const profileBtn = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const userProfile = document.getElementById('userProfile');
        if (profileBtn && profileDropdown && userProfile) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userProfile.classList.toggle('open');
                profileDropdown.classList.toggle('show');
            });
        }

        // Real-time Live Search
        const searchInput = document.getElementById('courseSearchInput');
        const courseCards = Array.from(document.querySelectorAll('.course-card'));
        const courseListRows = Array.from(document.querySelectorAll('.course-list-row'));

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();

                // Filter Cards
                courseCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const category = card.getAttribute('data-category') || '';
                    if (title.includes(query) || category.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Filter List Rows
                courseListRows.forEach(row => {
                    const title = row.getAttribute('data-title') || '';
                    if (title.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Sorting Logic
        const sortSelect = document.getElementById('courseSortSelect');
        const gridContainer = document.getElementById('coursesGrid');
        const listTbody = document.getElementById('coursesListTbody');

        if (sortSelect && gridContainer) {
            sortSelect.addEventListener('change', function() {
                const sortBy = this.value;
                const cards = Array.from(gridContainer.querySelectorAll('.course-card'));
                const rows = listTbody ? Array.from(listTbody.querySelectorAll('.course-list-row')) : [];

                const sortFn = (a, b) => {
                    if (sortBy === 'title_asc') {
                        return (a.getAttribute('data-title') || '').localeCompare(b.getAttribute('data-title') || '');
                    } else if (sortBy === 'title_desc') {
                        return (b.getAttribute('data-title') || '').localeCompare(a.getAttribute('data-title') || '');
                    } else if (sortBy === 'enrollments_desc') {
                        return parseInt(b.getAttribute('data-enrollments') || 0, 10) - parseInt(a.getAttribute('data-enrollments') || 0, 10);
                    } else if (sortBy === 'fee_desc') {
                        return parseFloat(b.getAttribute('data-fee') || 0) - parseFloat(a.getAttribute('data-fee') || 0);
                    } else {
                        // last_accessed / newest first
                        return parseInt(b.getAttribute('data-created') || 0, 10) - parseInt(a.getAttribute('data-created') || 0, 10);
                    }
                };

                cards.sort(sortFn).forEach(card => gridContainer.appendChild(card));
                if (listTbody) {
                    rows.sort(sortFn).forEach(row => listTbody.appendChild(row));
                }
            });
        }

        // View Switcher (Card vs List)
        const viewSelect = document.getElementById('courseViewSelect');
        const cardGridView = document.getElementById('coursesGrid');
        const listView = document.getElementById('coursesListView');

        if (viewSelect && cardGridView && listView) {
            viewSelect.addEventListener('change', function() {
                if (this.value === 'list') {
                    cardGridView.style.display = 'none';
                    listView.classList.add('active');
                } else {
                    cardGridView.style.display = 'grid';
                    listView.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>
