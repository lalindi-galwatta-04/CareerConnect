<?php
$activePage = $activePage ?? '';
?>

<nav class="navbar">
    <a href="index.php?action=jobseeker_dashboard" class="logo">
        <img src="public/images/logo.png" alt="CareerConnect Logo">
    </a>

    <div class="nav-links">

        <!-- MAIN -->
        <div class="sidebar-section-title">MAIN</div>

        <a href="index.php?action=jobseeker_dashboard"
           class="sidebar-nav-item <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <rect x="3" y="3" width="8" height="8" rx="2"/>
                    <rect x="13" y="3" width="8" height="8" rx="2"/>
                    <rect x="3" y="13" width="8" height="8" rx="2"/>
                    <rect x="13" y="13" width="8" height="8" rx="2"/>
                </svg>
            </span>

            <span>Dashboard</span>
        </a>

        <!-- CAREER -->
        <div class="sidebar-section-title">CAREER</div>

        <a href="index.php?action=job_search"
           class="sidebar-nav-item <?php echo $activePage === 'jobs' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </span>

            <span>Search Jobs</span>
        </a>

        <a href="index.php?action=my_applications"
           class="sidebar-nav-item <?php echo $activePage === 'applications' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <line x1="7" y1="8" x2="17" y2="8"/>
                    <line x1="7" y1="12" x2="17" y2="12"/>
                    <line x1="7" y1="16" x2="13" y2="16"/>
                </svg>
            </span>

            <span>My Applications</span>
        </a>

        <a href="index.php?action=career_assessment"
           class="sidebar-nav-item <?php echo $activePage === 'assessment' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </span>

            <span>Career Assessment</span>
        </a>

        <!-- DEVELOPMENT -->
        <div class="sidebar-section-title">DEVELOPMENT</div>

        <a href="index.php?action=browse_courses"
           class="sidebar-nav-item <?php echo $activePage === 'courses' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </span>

            <span>Courses</span>
        </a>

        <a href="index.php?action=browse_coaches"
           class="sidebar-nav-item <?php echo $activePage === 'coaches' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
            </span>

            <span>Find & Book Coaches</span>
        </a>

        <!-- ACCOUNT -->
        <div class="sidebar-section-title">ACCOUNT</div>

        <a href="index.php?action=view_jobseeker_profile"
           class="sidebar-nav-item <?php echo $activePage === 'profile' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                    <path d="M4 21a8 8 0 0 1 16 0"/>
                </svg>
            </span>

            <span>My Profile</span>
        </a>

        <!-- LOGOUT -->
        <div class="sidebar-bottom">

            <a href="index.php?action=logout"
               class="sidebar-nav-item sidebar-logout">

                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

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