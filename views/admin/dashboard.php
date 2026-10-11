<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <a href="index.php?action=admin_dashboard" class="logo">
            <img src="public/images/logo.png" alt="CareerConnect">
        </a>
        <div class="nav-links">
            <div class="sidebar-section-title">MAIN</div>
            <a href="index.php?action=admin_dashboard" class="sidebar-nav-item active">
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
            <a href="index.php?action=admin_dashboard&view=approvals" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </span>
                <span>Entity Approvals</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=seekers" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>
                <span>Job Seekers</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=coaches" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <span>Career Coaches</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=companies" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </span>
                <span>Companies</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=providers" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </span>
                <span>Training Providers</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=jobs" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </span>
                <span>Job Listings</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=courses" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                </span>
                <span>Training Courses</span>
            </a>

            <a href="index.php?action=admin_dashboard&view=users" class="sidebar-nav-item">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <span>User Accounts</span>
            </a>

            <div class="sidebar-bottom">
                <div class="sidebar-section-title">ACCOUNT</div>
                <a href="index.php?action=logout" class="sidebar-nav-item sidebar-logout">
                    <span class="sidebar-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </span>
                    <span>Log Out</span>
                </a>
            </div>
        </div>
    </nav>

    <header class="top-header">
        <div class="user-profile" id="userProfile">
            <button class="user-profile-button" id="profileButton">
                <img src="public/images/user.png" alt="User" class="user-avatar">
                <span class="user-name">System Administrator</span>
                <span class="user-arrow">▼</span>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-user">
                    <img src="public/images/user.png" alt="User">
                    <div class="dropdown-user-info">
                        <strong>System Administrator</strong>
                        <span><?php echo htmlspecialchars($_SESSION['email'] ?? 'admin@careerconnect.com'); ?></span>
                    </div>
                </div>

                <a href="index.php?action=login">+ Add Another Account</a>
                <a href="index.php?action=logout" class="dropdown-logout">Log Out</a>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Dashboard Header -->
        <div class="welcome-card">
            <div>
                <h1>System Control Panel</h1>
                <p>Monitor platform health, active user accounts, entity registrations, and moderate platform content.</p>
            </div>
        </div>

        <!-- Metric Cards Grid -->
        <div class="stats-grid admin-stats-grid">
            <a href="index.php?action=admin_dashboard&view=seekers" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Job Seekers</h3>
                <div class="number"><?php echo $metrics['total_seekers'] ?? 0; ?></div>
            </a>
            <a href="index.php?action=admin_dashboard&view=coaches" class="stat-card stat-success" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Coaches</h3>
                <div class="number"><?php echo $metrics['total_coaches'] ?? 0; ?></div>
            </a>
            <a href="index.php?action=admin_dashboard&view=providers" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Providers</h3>
                <div class="number"><?php echo $metrics['total_providers'] ?? 0; ?></div>
            </a>
            <a href="index.php?action=admin_dashboard&view=companies" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Companies</h3>
                <div class="number"><?php echo $metrics['total_companies'] ?? 0; ?></div>
            </a>
            <a href="index.php?action=admin_dashboard&view=jobs" class="stat-card" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Job Posts</h3>
                <div class="number"><?php echo $metrics['total_jobs'] ?? 0; ?></div>
            </a>
            <a href="index.php?action=admin_dashboard&view=courses" class="stat-card stat-success" style="text-decoration: none; display: block; cursor: pointer;">
                <h3>Courses</h3>
                <div class="number"><?php echo $metrics['total_courses'] ?? 0; ?></div>
            </a>
        </div>

        <!-- Quick Links / Status Cards Grid -->
        <div class="admin-cards-grid">
            <!-- Card 1: Job Seekers -->
            <div class="card admin-action-card">
                <div>
                    <h3>Job Seekers</h3>
                    <p>Manage candidate accounts, CV submissions, and application histories.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=seekers" class="btn">Manage Job Seekers</a>
                </div>
            </div>

            <!-- Card 2: Career Coaches -->
            <div class="card admin-action-card">
                <div>
                    <h3>Career Coaches</h3>
                    <p>Review advisor profiles, hourly consulting rates, and booking sessions.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=coaches" class="btn">Manage Career Coaches</a>
                </div>
            </div>

            <!-- Card 3: Registered Companies -->
            <div class="card admin-action-card">
                <div>
                    <h3>Companies & Employers</h3>
                    <p>Corporate hiring partners, industry affiliations, and vacancy volume.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=companies" class="btn">Manage Companies</a>
                </div>
            </div>

            <!-- Card 4: Training Providers -->
            <div class="card admin-action-card">
                <div>
                    <h3>Training Providers</h3>
                    <p>Oversight of registered vocational and education institutes and course catalogs.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=providers" class="btn">Manage Training Providers</a>
                </div>
            </div>

            <!-- Card 5: Job Listings -->
            <div class="card admin-action-card">
                <div>
                    <h3>Job Listings</h3>
                    <p>Oversight and moderation for active corporate job vacancies and posts.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=jobs" class="btn">Manage Job Listings</a>
                </div>
            </div>

            <!-- Card 6: Training Courses -->
            <div class="card admin-action-card">
                <div>
                    <h3>Training Courses</h3>
                    <p>Oversight of published training courses and vocational certificate programs.</p>
                </div>
                <div class="admin-action-card-footer">
                    <a href="index.php?action=admin_dashboard&view=courses" class="btn">Manage Training Courses</a>
                </div>
            </div>
        </div>

    </div>

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