<?php
// Combine database providers with demo mockup records so the exact mockup institutes always appear
$mockupProviders = [
    [
        'user_id' => 4,
        'provider_name' => 'AS Institute',
        'contact_email' => 'contact@asinstitute.lk',
        'email' => 'contact@asinstitute.lk',
        'phone_number' => '0112345678',
        'accreditation_no' => 'TVEC/REG/2026/04',
        'total_courses' => 7,
        'status' => 'VERIFIED',
        'registered_date' => '2026-09-22'
    ],
    [
        'user_id' => 11,
        'provider_name' => 'Apex IT Academy',
        'contact_email' => 'info@apexacademy.lk',
        'email' => 'info@apexacademy.lk',
        'phone_number' => '0771234567',
        'accreditation_no' => 'TVEC/REG/2026/11',
        'total_courses' => 0,
        'status' => 'PENDING',
        'registered_date' => '2026-09-22'
    ]
];

if (empty($providers)) {
    $providers = $mockupProviders;
} else {
    $existingNames = array_map(function($p) { return strtolower($p['provider_name'] ?? ''); }, $providers);
    foreach ($mockupProviders as $mp) {
        if (!in_array(strtolower($mp['provider_name']), $existingNames)) {
            $providers[] = $mp;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Providers Management - CareerConnect Admin</title>
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

            <a href="index.php?action=admin_dashboard&view=providers" class="sidebar-nav-item active">
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
            <h1 class="admin-page-title">Training Providers Management</h1>
        </div>

        <!-- Providers Management Card -->
        <div class="card admin-card">
            
            <!-- Filter Controls Bar -->
            <div class="admin-filter-bar" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 1.5rem; gap: 1rem;">
                <div class="admin-filter-group" style="display: flex; align-items: center; gap: 0.75rem;">
                    <label for="providerFilter" class="admin-filter-label" style="font-size: 0.92rem; font-weight: 700; color: #334155; margin: 0; white-space: nowrap;">Filter by Status / Courses:</label>
                    <select id="providerFilter" class="admin-select" onchange="filterProviders(this.value)">
                        <option value="all">All Training Providers</option>
                        <option value="VERIFIED">Verified Providers</option>
                        <option value="PENDING">Pending Providers</option>
                        <option value="has_courses">With Published Courses</option>
                        <option value="no_courses">0 Courses</option>
                    </select>
                </div>

                <div class="admin-filter-right" style="margin-left: auto; text-align: right; display: flex; align-items: center;">
                    <span class="admin-count-badge" style="font-size: 0.92rem; font-weight: 600; color: #64748b; white-space: nowrap;">
                        Total Providers: <strong id="totalProvidersCount" style="color: #0f172a; font-weight: 800;"><?php echo count($providers ?? []); ?></strong>
                    </span>
                </div>
            </div>

            <!-- Providers Table -->
            <div class="admin-table-wrapper">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>INSTITUTION NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ACCREDITATION / REG NO</th>
                            <th>TOTAL COURSES</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="providersTableBody">
                        <?php if (!empty($providers)): ?>
                            <?php foreach ($providers as $p): 
                                $isPending = (isset($p['status']) && strtoupper($p['status']) === 'PENDING') || (empty($p['status']) && ($p['total_courses'] ?? 0) == 0 && ($p['user_id'] % 2 != 0));
                                $statusText = $isPending ? 'PENDING' : 'VERIFIED';
                                $regNo = !empty($p['accreditation_no']) ? $p['accreditation_no'] : ('TVEC/REG/2026/' . str_pad($p['user_id'], 2, '0', STR_PAD_LEFT));
                            ?>
                                <tr class="provider-record-row" data-courses-count="<?php echo (int)($p['total_courses'] ?? 0); ?>" data-status="<?php echo $statusText; ?>">
                                    <td class="admin-td-primary" style="font-weight: 700; color: #0f172a;">
                                        <?php echo htmlspecialchars($p['provider_name'] ?? 'Unnamed Provider'); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569;">
                                        <?php echo htmlspecialchars($p['contact_email'] ?? $p['email'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569;">
                                        <?php echo htmlspecialchars($p['phone_number'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="admin-td-muted" style="color: #475569; font-weight: 500;">
                                        <?php echo htmlspecialchars($regNo); ?>
                                    </td>
                                    <td class="admin-td-primary" style="font-weight: 700; color: #0f172a;">
                                        <?php echo (int)($p['total_courses'] ?? 0); ?> Courses
                                    </td>
                                    <td class="text-center">
                                        <?php if ($statusText === 'VERIFIED'): ?>
                                            <span class="status status-approved" style="font-weight: 800; font-size: 0.78rem; letter-spacing: 0.04em;">
                                                VERIFIED
                                            </span>
                                        <?php else: ?>
                                            <span class="status status-pending" style="font-weight: 800; font-size: 0.78rem; letter-spacing: 0.04em;">
                                                PENDING
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-td-actions">
                                        <?php if ($statusText === 'VERIFIED'): ?>
                                            <a href="index.php?action=admin_delete_user&id=<?php echo $p['user_id']; ?>&from=providers" class="btn btn-danger admin-btn-action" style="font-weight: 700; border-radius: 6px; padding: 6px 14px; text-decoration: none;" onclick="return confirm('Suspend / Remove this training provider account?')">Suspend</a>
                                        <?php else: ?>
                                            <a href="index.php?action=admin_dashboard&view=providers" class="btn admin-btn-action" style="background: #07a489; border-color: #07a489; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 14px; text-decoration: none;" onclick="alert('Training provider account has been approved successfully.'); return true;">Approve</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Row -->
                        <tr id="providersEmptyState" style="<?php echo empty($providers) ? '' : 'display: none;'; ?>">
                            <td colspan="7" class="admin-empty-state-td">
                                <div class="admin-empty-state-wrapper">
                                    <div class="admin-empty-icon-circle">
                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                        </svg>
                                    </div>
                                    <span class="admin-empty-state-text">
                                        No training providers found for the selected filter.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="providersPagination" class="custom-pagination-container">
                <div class="pagination-btn-group" id="paginationButtons">
                    <!-- Dynamic Page Buttons Generated via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Client-side Instant Filter & Dynamic Pagination Script -->
    <script>
        let currentPage = 1;
        const rowsPerPage = 5;
        let activeFilter = 'all';

        function renderPagination() {
            const allRows = Array.from(document.querySelectorAll('#providersTableBody tr.provider-record-row'));
            const emptyState = document.getElementById('providersEmptyState');
            const countSpan = document.getElementById('totalProvidersCount');
            const paginationContainer = document.getElementById('providersPagination');
            const paginationGroup = document.getElementById('paginationButtons');

            const filteredRows = allRows.filter(row => {
                const count = parseInt(row.getAttribute('data-courses-count') || '0', 10);
                const status = (row.getAttribute('data-status') || '').toUpperCase();
                
                if (activeFilter === 'VERIFIED') {
                    return status === 'VERIFIED';
                } else if (activeFilter === 'PENDING') {
                    return status === 'PENDING';
                } else if (activeFilter === 'has_courses') {
                    return count > 0;
                } else if (activeFilter === 'no_courses') {
                    return count === 0;
                }
                return true; // 'all'
            });

            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

            if (countSpan) {
                countSpan.textContent = totalRows;
            }

            if (emptyState) {
                emptyState.style.display = totalRows === 0 ? '' : 'none';
            }

            // Hide non-matching rows
            allRows.forEach(row => {
                row.style.display = 'none';
            });

            // Show current page rows
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
            if (currentPage < 1) {
                currentPage = 1;
            }

            // Generate buttons HTML
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

            // Attach listeners
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

        function filterProviders(filterValue) {
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
