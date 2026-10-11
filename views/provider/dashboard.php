<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($currentView === 'courses') ? 'My Courses & Programs' : 'Training Provider Dashboard'; ?> - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <a href="index.php?action=provider_dashboard" class="logo">
            <img src="public/images/logo.png" alt="CareerConnect">
        </a>
        <div class="nav-links">
            <div class="sidebar-section-title">MAIN</div>
            <a href="index.php?action=provider_dashboard" class="sidebar-nav-item <?php echo ($currentView === 'dashboard') ? 'active' : ''; ?>">
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
            <a href="index.php?action=provider_dashboard&view=courses" class="sidebar-nav-item <?php echo ($currentView === 'courses') ? 'active' : ''; ?>">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                </span>
                <span>My Courses</span>
            </a>
            <a href="index.php?action=manage_course" class="sidebar-sub-btn">Add New Course</a>

            <a href="index.php?action=provider_dashboard&view=roster" class="sidebar-nav-item <?php echo ($currentView === 'roster') ? 'active' : ''; ?>">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <span>Student Roster</span>
            </a>

            <a href="index.php?action=provider_dashboard&view=grading" class="sidebar-nav-item <?php echo ($currentView === 'grading') ? 'active' : ''; ?>">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="8" y1="18" x2="8" y2="14"></line>
                        <line x1="12" y1="18" x2="12" y2="11"></line>
                        <line x1="16" y1="18" x2="16" y2="16"></line>
                    </svg>
                </span>
                <span>Grading & Results</span>
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

    <header class="top-header">
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

    <div class="container provider-page">
        <?php if ($currentView === 'courses'): ?>
            <!-- Course Listings Table Card (Only shown on My Courses view) -->
            <div class="card" style="margin-top: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div class="section-card" style="padding:0; border:none; margin:0; background:transparent;">
                        <h2>Your Training Courses & Programs</h2>
                    </div>
                    <a href="index.php?action=manage_course" class="btn">+ Add New Course</a>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table" id="coursesTable">
                        <thead>
                            <tr>
                                <th>Course Title</th>
                                <th>Category</th>
                                <th>Duration</th>
                                <th>Fee</th>
                                <th>Enrollments</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="coursesTableBody">
                            <?php if (empty($courses)): ?>
                                <tr id="emptyCoursesRow">
                                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                        No courses added yet. Click "+ Add New Course" to create one.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($courses as $c): ?>
                                    <tr class="course-table-row">
                                        <td><strong><?php echo htmlspecialchars($c['title']); ?></strong></td>
                                        <td><span class="status status-pending"><?php echo htmlspecialchars($c['category']); ?></span></td>
                                        <td style="color: var(--text-muted);"><?php echo htmlspecialchars($c['duration']); ?></td>
                                        <td style="color: var(--success); font-weight: 700;">LKR <?php echo number_format($c['fee'], 2); ?></td>
                                        <td><span class="status status-approved"><?php echo $c['total_enrollments']; ?> Enrolled</span></td>
                                        <td style="text-align: right; white-space: nowrap;">
                                            <a href="index.php?action=manage_course&id=<?php echo $c['course_id']; ?>" class="btn btn-outline" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; margin-right: 0.3rem;">Edit</a>
                                            <?php if ($c['total_enrollments'] > 0): ?>
                                                <button type="button" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; opacity: 0.5; cursor: not-allowed;" onclick="alert('Cannot delete this course because <?php echo $c['total_enrollments']; ?> student(s) are currently enrolled in it.');">Delete</button>
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

                <!-- Dynamic Pagination Controls -->
                <div id="coursesPagination" class="custom-pagination-container">
                    <div class="pagination-btn-group" id="paginationButtons">
                        <!-- Dynamic Page Buttons Generated via JavaScript -->
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Dashboard Overview & 4 Metric Cards (Only shown on Dashboard view) -->
            <div class="welcome-card">
                <div>
                    <h1>Welcome, <?php echo htmlspecialchars($provider['provider_name'] ?? 'Training Provider'); ?></h1>
                    <p>
                        <strong>Contact Email:</strong> <?php echo htmlspecialchars($provider['contact_email'] ?? $provider['email']); ?> 
                        <span style="margin: 0 0.5rem; opacity: 0.7;">|</span> 
                        <strong>Website:</strong> <?php echo htmlspecialchars($provider['website'] ?? 'N/A'); ?>
                    </p>
                </div>
            </div>

            <!-- Metric Cards 2x2 Centered Grid (2 on top, 2 below) -->
            <div class="provider-stats-grid-2x2">
                <!-- Card 1: TOTAL COURSES -->
                <div class="provider-metric-card" onclick="window.location.href='index.php?action=provider_dashboard&view=courses'" style="cursor: pointer;">
                    <div class="metric-header-title">TOTAL COURSES</div>
                    <div class="metric-main-val"><?php echo $metrics['total_courses'] ?? 0; ?></div>
                    <div class="metric-sub-note">Active Programs</div>
                </div>

                <!-- Card 2: TOTAL ENROLLED -->
                <div class="provider-metric-card" onclick="window.location.href='index.php?action=provider_dashboard&view=roster'" style="cursor: pointer;">
                    <div class="metric-header-title">TOTAL ENROLLED</div>
                    <div class="metric-main-val"><?php echo $metrics['total_students'] ?? 0; ?></div>
                    <div class="metric-sub-note">Job Seekers</div>
                </div>

                <!-- Card 3: ACTIVE LEARNERS -->
                <div class="provider-metric-card" onclick="window.location.href='index.php?action=provider_dashboard&view=roster'" style="cursor: pointer;">
                    <div class="metric-header-title">ACTIVE LEARNERS</div>
                    <div class="metric-main-val"><?php echo $metrics['active_learners'] ?? ($metrics['total_students'] ?? 0); ?></div>
                    <div class="metric-sub-note">In-Progress</div>
                </div>

                <!-- Card 4: COMPLETED -->
                <div class="provider-metric-card" onclick="window.location.href='index.php?action=provider_dashboard&view=grading'" style="cursor: pointer;">
                    <div class="metric-header-title">COMPLETED</div>
                    <div class="metric-main-val"><?php echo $metrics['completed_students'] ?? 0; ?></div>
                    <div class="metric-sub-note">Certified</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Client-side Dynamic Pagination Script (Only runs on Courses view) -->
    <?php if ($currentView === 'courses'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            const rowsPerPage = 5; // 5 courses per page. Once 5 are filled, page 2 is generated dynamically.

            function renderPagination() {
                const rows = Array.from(document.querySelectorAll('#coursesTableBody tr.course-table-row'));
                const totalRows = rows.length;
                const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));
                const paginationContainer = document.getElementById('coursesPagination');
                const paginationGroup = document.getElementById('paginationButtons');

                if (!paginationContainer || !paginationGroup) return;

                // Hide pagination if totalRows is 0 or less than or equal to rowsPerPage
                if (totalRows <= rowsPerPage) {
                    paginationContainer.style.display = 'none';
                    return;
                } else {
                    paginationContainer.style.display = 'flex';
                }

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                // Build dynamic pagination HTML
                let buttonsHtml = '';

                // Prev Button
                const prevDisabled = currentPage === 1 ? 'disabled' : 'is-enabled';
                buttonsHtml += `<button type="button" class="p-btn p-prev ${prevDisabled}" id="btnPrev">Prev</button>`;

                // Generate exact number of page buttons: 1, 2, ... totalPages
                for (let i = 1; i <= totalPages; i++) {
                    const activeClass = i === currentPage ? 'active' : '';
                    buttonsHtml += `<button type="button" class="p-btn p-num ${activeClass}" data-page="${i}">${i}</button>`;
                }

                // Next Button
                const nextDisabled = currentPage === totalPages ? 'disabled' : 'is-enabled';
                buttonsHtml += `<button type="button" class="p-btn p-next ${nextDisabled}" id="btnNext">Next</button>`;

                paginationGroup.innerHTML = buttonsHtml;

                // Show/hide table rows for active page
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;

                rows.forEach((row, index) => {
                    if (index >= startIndex && index < endIndex) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Attach click listeners to generated page numbers
                const numBtns = Array.from(paginationGroup.querySelectorAll('.p-num'));
                numBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const targetPage = parseInt(this.getAttribute('data-page'), 10);
                        if (targetPage !== currentPage) {
                            currentPage = targetPage;
                            renderPagination();
                        }
                    });
                });

                // Attach click listener to Prev Button
                const btnPrev = document.getElementById('btnPrev');
                if (btnPrev && currentPage > 1) {
                    btnPrev.addEventListener('click', function() {
                        currentPage--;
                        renderPagination();
                    });
                }

                // Attach click listener to Next Button
                const btnNext = document.getElementById('btnNext');
                if (btnNext && currentPage < totalPages) {
                    btnNext.addEventListener('click', function() {
                        currentPage++;
                        renderPagination();
                    });
                }
            }

            // Initial render
            renderPagination();
        });
    </script>
    <?php endif; ?>

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