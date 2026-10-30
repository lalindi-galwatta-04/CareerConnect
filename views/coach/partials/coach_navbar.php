<?php
$activePage = $activePage ?? '';
?>
<nav class="navbar">
    <a href="index.php?action=coach_dashboard" class="logo">
        <img src="public/images/logo.png" alt="CareerConnect Logo">
    </a>

    <div class="nav-links">

        <!-- MAIN -->
        <div class="sidebar-section-title">MAIN</div>

        <a href="index.php?action=coach_dashboard"
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

        <a href="index.php?action=coach_availability"
           class="sidebar-nav-item <?php echo $activePage === 'availability' ? 'active' : ''; ?>">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <line x1="16" y1="3" x2="16" y2="7"/>
                    <line x1="8" y1="3" x2="8" y2="7"/>
                    <line x1="3" y1="11" x2="21" y2="11"/>

                </svg>
            </span>

            <span>Availability</span>

        </a>


        <a href="index.php?action=coach_dashboard#coaching-sessions"
           class="sidebar-nav-item">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <circle cx="12" cy="12" r="9"/>
                    <polyline points="12 7 12 12 15 14"/>

                </svg>
            </span>

            <span>Coaching Sessions</span>

        </a>


        <a href="index.php?action=coach_dashboard#reviews-feedback"
           class="sidebar-nav-item">

            <span class="sidebar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>

                </svg>
            </span>

            <span>Reviews & Feedback</span>

        </a>


        <a href="index.php?action=coach_reports"
           class="sidebar-nav-item <?php echo $activePage === 'reports' ? 'active' : ''; ?>">

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

            <span>Reports & Analytics</span>

        </a>


        <!-- ACCOUNT -->
        <div class="sidebar-section-title">ACCOUNT</div>

        <a href="index.php?action=coach_profile"
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

            <span>Profile</span>

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