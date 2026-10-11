<?php
$activePage = $activePage ?? '';
?>
<nav class="navbar">
	<a href="index.php?action=company_dashboard" class="logo">
		<img src="public/images/logo.png" alt="CareerConnect Logo">
	</a>
	<div class="nav-links">

        <!-- MAIN -->
        <div class="sidebar-section-title">MAIN</div>

        <a href="index.php?action=company_dashboard"
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


        <!-- MANAGEMENT -->
        <div class="sidebar-section-title">MANAGEMENT</div>

        <a href="index.php?action=manage_jobs"
           class="sidebar-nav-item <?php echo $activePage === 'jobs' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <rect x="3" y="7" width="18" height="13" rx="2"/>
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    <path d="M3 12h18"/>

                </svg>
            </span>

            <span>Manage Jobs</span>

        </a>


        <a href="index.php?action=applicants"
           class="sidebar-nav-item <?php echo $activePage === 'applicants' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                </svg>
            </span>

            <span>Applicants</span>

        </a>


        <a href="index.php?action=company_analytics"
           class="sidebar-nav-item <?php echo $activePage === 'analytics' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <line x1="18" y1="20" x2="18" y2="10"/>
                    <line x1="12" y1="20" x2="12" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="14"/>

                </svg>
            </span>

            <span>Analytics</span>

        </a>


        <!-- ACCOUNT -->
        <div class="sidebar-section-title">ACCOUNT</div>

        <a href="index.php?action=company_profile"
           class="sidebar-nav-item <?php echo $activePage === 'profile' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>

                    <circle cx="12" cy="12" r="3"/>

                </svg>
            </span>

            <span>Company Profile</span>

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