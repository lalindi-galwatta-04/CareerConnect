<?php
// Combine database seekers with demo mock records
$mockupSeekers = [
    [
        'user_id' => 1,
        'first_name' => 'Kasun',
        'last_name' => 'Perera',
        'email' => 'kasun.perera@email.com',
        'phone_number' => '0771234567',
        'skills' => 'React, Node.js, SQL, TypeScript',
        'total_applications' => 4,
        'status' => 'ACTIVE',
        'registered_date' => '2026-09-20'
    ],
    [
        'user_id' => 2,
        'first_name' => 'Sarah',
        'last_name' => 'Fernando',
        'email' => 'sarah.f@email.com',
        'phone_number' => '0719876543',
        'skills' => 'UI/UX Design, Figma, Adobe XD, CSS',
        'total_applications' => 2,
        'status' => 'ACTIVE',
        'registered_date' => '2026-09-21'
    ],
    [
        'user_id' => 3,
        'first_name' => 'Amal',
        'last_name' => 'Silva',
        'email' => 'amal.silva@email.com',
        'phone_number' => '0754433221',
        'skills' => 'Python, Data Analytics, PowerBI, Excel',
        'total_applications' => 0,
        'status' => 'REGISTERED',
        'registered_date' => '2026-09-22'
    ],
    [
        'user_id' => 5,
        'first_name' => 'Nadeesha',
        'last_name' => 'Jayasinghe',
        'email' => 'nadeesha.j@email.com',
        'phone_number' => '0785566778',
        'skills' => 'Digital Marketing, SEO, Content Strategy',
        'total_applications' => 3,
        'status' => 'ACTIVE',
        'registered_date' => '2026-09-23'
    ],
    [
        'user_id' => 6,
        'first_name' => 'Dinesh',
        'last_name' => 'Kumara',
        'email' => 'dinesh.k@email.com',
        'phone_number' => '0723344556',
        'skills' => 'Java, Spring Boot, Microservices, AWS',
        'total_applications' => 5,
        'status' => 'ACTIVE',
        'registered_date' => '2026-09-24'
    ],
    [
        'user_id' => 7,
        'first_name' => 'Chamodi',
        'last_name' => 'Wijesinghe',
        'email' => 'chamodi.w@email.com',
        'phone_number' => '0761122334',
        'skills' => 'Quality Assurance, Selenium, Test Automation',
        'total_applications' => 1,
        'status' => 'ACTIVE',
        'registered_date' => '2026-09-25'
    ]
];

if (empty($seekers)) {
    $seekers = $mockupSeekers;
} else {
    $existingEmails = array_map(function($s) { return strtolower($s['email'] ?? ''); }, $seekers);
    foreach ($mockupSeekers as $ms) {
        if (!in_array(strtolower($ms['email']), $existingEmails)) {
            $seekers[] = $ms;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seekers Management - CareerConnect Admin</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <a href="index.php?action=admin_dashboard" class="logo">
            <img src="public/images/logo.png" alt="CareerConnect">
        </a>
        <div class="nav-links">
            <div class="sidebar-section-title">MAIN</div>
            <a href="index.php?action=admin_dashboard" class="sidebar-nav-item">
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

            <a href="index.php?action=admin_dashboard&view=seekers" class="sidebar-nav-item active">
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
        <!-- Top Title -->
        <div class="admin-page-header">
            <h1 class="admin-page-title">Job Seekers Management</h1>
        </div>

        <?php if (isset($_GET['approved'])): ?>
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.1rem; color: #07a489;">&#10003;</span> Job Seeker account approved successfully! Status marked as Completed.
            </div>
        <?php endif; ?>

        <!-- Job Seekers Management Card -->
        <div class="card admin-card">
            
            <!-- Filter Controls Bar -->
            <div class="admin-filter-bar" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 1.5rem; gap: 1rem;">
                <div class="admin-filter-group" style="display: flex; align-items: center; gap: 0.75rem;">
                    <label for="seekerFilter" class="admin-filter-label" style="font-size: 0.92rem; font-weight: 700; color: #334155; margin: 0; white-space: nowrap;">Filter by Applications / Status:</label>
                    <select id="seekerFilter" class="admin-select" onchange="filterSeekers(this.value)">
                        <option value="all">All Job Seekers</option>
                        <option value="has_applications">Active Applicants (>0)</option>
                        <option value="no_applications">No Applications (0)</option>
                        <option value="ACTIVE">Active Profiles</option>
                        <option value="REGISTERED">Registered Users</option>
                    </select>
                </div>

                <div class="admin-filter-right" style="margin-left: auto; text-align: right; display: flex; align-items: center;">
                    <span class="admin-count-badge" style="font-size: 0.92rem; font-weight: 600; color: #64748b; white-space: nowrap;">
                        Total Job Seekers: <strong id="totalSeekersCount" style="color: #0f172a; font-weight: 800;"><?php echo count($seekers ?? []); ?></strong>
                    </span>
                </div>
            </div>

            <!-- Job Seekers Table -->
            <div class="admin-table-wrapper">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>JOB SEEKER NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>KEY SKILLS / SPECIALTY</th>
                            <th>APPLICATIONS</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="seekersTableBody">
                        <?php if (!empty($seekers)): ?>
                            <?php foreach ($seekers as $s): 
                                $fullName = trim(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? ''));
                                if (empty($fullName)) $fullName = $s['name'] ?? 'Candidate #' . $s['user_id'];
                                $appCount = (int)($s['total_applications'] ?? 0);
                                $isExplicitlyApproved = !empty($_SESSION['approved_ids'][$s['user_id']]) || (!empty($s['email']) && !empty($_SESSION['approved_emails'][strtolower($s['email'])]));
                                $isDbApproved = (isset($s['approval_status']) && strtolower($s['approval_status']) === 'approved');
                                $isDbPending = (isset($s['approval_status']) && strtolower($s['approval_status']) === 'pending');

                                if ($isDbPending && !$isExplicitlyApproved) {
                                    $isApproved = false;
                                } elseif ($isExplicitlyApproved || $isDbApproved) {
                                    $isApproved = true;
                                } else {
                                    $isApproved = (isset($s['status']) && strtoupper($s['status']) === 'ACTIVE') && empty($s['approval_status']);
                                }

                                $status = $isApproved ? 'ACTIVE' : 'REGISTERED';
                                $skills = !empty($s['skills']) ? $s['skills'] : (!empty($s['education_level']) ? $s['education_level'] : (!empty($s['bio']) ? $s['bio'] : 'General Profile'));
                            ?>
                                <tr class="seeker-record-row" data-app-count="<?php echo $appCount; ?>" data-status="<?php echo $status; ?>">
                                    <td class="admin-td-primary" style="font-weight: 700; color: #0f172a;">
                                        <?php echo htmlspecialchars($fullName); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569;">
                                        <?php echo htmlspecialchars($s['email'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569;">
                                        <?php echo htmlspecialchars($s['phone_number'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($skills); ?>">
                                        <?php echo htmlspecialchars($skills); ?>
                                    </td>
                                    <td class="admin-td-primary" style="font-weight: 700; color: #0f172a;">
                                        <?php echo $appCount; ?> Applications
                                    </td>
                                    <td class="text-center">
                                        <?php if ($status === 'ACTIVE'): ?>
                                            <span class="status status-approved" style="font-weight: 800; font-size: 0.78rem; letter-spacing: 0.04em;">
                                                ACTIVE
                                            </span>
                                        <?php else: ?>
                                            <span class="status status-pending" style="font-weight: 800; font-size: 0.78rem; letter-spacing: 0.04em;">
                                                REGISTERED
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-td-actions">
                                        <?php if ($isApproved): ?>
                                            <span class="status-badge-completed" style="font-weight: 700; color: #07a489; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; font-size: 0.82rem;">&#10003; Completed</span>
                                        <?php else: ?>
                                            <a href="index.php?action=admin_update_approval&id=<?php echo $s['user_id']; ?>&status=approved&from=seekers<?php echo !empty($s['email']) ? '&email=' . urlencode($s['email']) : ''; ?>" class="btn admin-btn-action" style="background: #07a489; border-color: #07a489; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 14px; text-decoration: none;">Approve</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Row -->
                        <tr id="seekersEmptyState" style="<?php echo empty($seekers) ? '' : 'display: none;'; ?>">
                            <td colspan="7" class="admin-empty-state-td">
                                <div class="admin-empty-state-wrapper">
                                    <div class="admin-empty-icon-circle">
                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                    <span class="admin-empty-state-text">
                                        No job seekers found for the selected filter.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="seekersPagination" class="custom-pagination-container">
                <div class="pagination-btn-group" id="paginationButtons"></div>
            </div>
        </div>
    </div>

    <!-- Client-side Instant Filter & Dynamic Pagination Script -->
    <script>
        let currentPage = 1;
        const rowsPerPage = 5;
        let activeFilter = 'all';

        function renderPagination() {
            const allRows = Array.from(document.querySelectorAll('#seekersTableBody tr.seeker-record-row'));
            const emptyState = document.getElementById('seekersEmptyState');
            const countSpan = document.getElementById('totalSeekersCount');
            const paginationContainer = document.getElementById('seekersPagination');
            const paginationGroup = document.getElementById('paginationButtons');

            const filteredRows = allRows.filter(row => {
                const count = parseInt(row.getAttribute('data-app-count') || '0', 10);
                const status = (row.getAttribute('data-status') || '').toUpperCase();
                
                if (activeFilter === 'has_applications') {
                    return count > 0;
                } else if (activeFilter === 'no_applications') {
                    return count === 0;
                } else if (activeFilter === 'ACTIVE') {
                    return status === 'ACTIVE';
                } else if (activeFilter === 'REGISTERED') {
                    return status === 'REGISTERED';
                }
                return true;
            });

            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

            if (countSpan) {
                countSpan.textContent = totalRows;
            }

            if (emptyState) {
                emptyState.style.display = totalRows === 0 ? '' : 'none';
            }

            allRows.forEach(row => {
                row.style.display = 'none';
            });

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            filteredRows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            if (!paginationContainer || !paginationGroup) return;

            if (totalRows <= rowsPerPage) {
                paginationContainer.style.display = 'none';
                return;
            } else {
                paginationContainer.style.display = 'flex';
            }

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }
            if (currentPage < 1) {
                currentPage = 1;
            }

            let buttonsHtml = '';
            const prevDisabled = currentPage === 1 ? 'disabled' : 'is-enabled';
            buttonsHtml += `<button type="button" class="p-btn p-prev ${prevDisabled}" id="btnPrev">Prev</button>`;

            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                buttonsHtml += `<button type="button" class="p-btn p-num ${activeClass}" data-page="${i}">${i}</button>`;
            }

            const nextDisabled = currentPage === totalPages ? 'disabled' : 'is-enabled';
            buttonsHtml += `<button type="button" class="p-btn p-next ${nextDisabled}" id="btnNext">Next</button>`;

            paginationGroup.innerHTML = buttonsHtml;

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

            const btnPrev = document.getElementById('btnPrev');
            if (btnPrev && currentPage > 1) {
                btnPrev.addEventListener('click', function() {
                    currentPage--;
                    renderPagination();
                });
            }

            const btnNext = document.getElementById('btnNext');
            if (btnNext && currentPage < totalPages) {
                btnNext.addEventListener('click', function() {
                    currentPage++;
                    renderPagination();
                });
            }
        }

        function filterSeekers(filterValue) {
            activeFilter = filterValue;
            currentPage = 1;
            renderPagination();
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

        document.addEventListener('DOMContentLoaded', function() {
            renderPagination();
        });
    </script>
</body>
</html>
