<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entity Approvals - CareerConnect Admin</title>
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
            <a href="index.php?action=admin_dashboard&view=approvals" class="sidebar-nav-item active">
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
        <!-- Top Title -->
        <div class="admin-page-header">
            <h1 class="admin-page-title">Entity Approvals & Verification</h1>
        </div>

        <?php if (isset($_GET['approved'])): ?>
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.1rem; color: #07a489;">&#10003;</span> Entity account approved successfully! Status marked as Completed.
            </div>
        <?php elseif (isset($_GET['rejected'])): ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 18px; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.1rem; color: #dc2626;">&#10007;</span> Entity account registration has been rejected. Notification recorded.
            </div>
        <?php endif; ?>

        <!-- Entity Approvals Card -->
        <div class="card admin-card">
            
            <!-- Filter Controls Bar -->
            <div class="admin-filter-bar" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 1.5rem; gap: 1rem;">
                <div class="admin-filter-group" style="display: flex; align-items: center; gap: 0.75rem;">
                    <label for="entityTypeFilter" class="admin-filter-label" style="font-size: 0.92rem; font-weight: 700; color: #334155; margin: 0; white-space: nowrap;">Filter by Entity:</label>
                    <select id="entityTypeFilter" class="admin-select" onchange="filterEntities(this.value)">
                        <option value="all">All Registered Entities</option>
                        <option value="Company">Companies</option>
                        <option value="Career Coach">Career Coaches</option>
                        <option value="Training Provider">Training Providers</option>
                    </select>
                </div>

                <div class="admin-filter-right" style="margin-left: auto; text-align: right; display: flex; align-items: center;">
                    <span class="admin-count-badge">
                        Total Verified Entities: <strong id="totalEntitiesCount"><?php echo count($entities ?? []); ?></strong>
                    </span>
                </div>
            </div>

            <!-- Entities Table -->
            <div class="admin-table-wrapper">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>ENTITY TYPE</th>
                            <th>ENTITY NAME</th>
                            <th>CONTACT EMAIL</th>
                            <th>DETAILS / FIELD</th>
                            <th class="text-center">DOCUMENT</th>
                            <th>REGISTERED DATE</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="entitiesTableBody">
                        <?php if (!empty($entities)): ?>
                            <?php foreach ($entities as $ent): 
                                $rawStatus = strtolower($ent['approval_status'] ?? $ent['status'] ?? 'pending');
                                $isExplicitlyApproved = !empty($_SESSION['approved_ids'][$ent['user_id']]) || (!empty($ent['email']) && !empty($_SESSION['approved_emails'][strtolower($ent['email'])]));

                                $isEntApproved = false;
                                $isEntRejected = false;

                                if ($isExplicitlyApproved || $rawStatus === 'approved' || $rawStatus === 'verified') {
                                    $isEntApproved = true;
                                } elseif ($rawStatus === 'rejected') {
                                    $isEntRejected = true;
                                }
                            ?>
                                <tr class="entity-record-row" data-type="<?php echo htmlspecialchars($ent['entity_type']); ?>">
                                    <td>
    <span style="font-weight:700;color:#000;text-transform:uppercase;font-size:12px;">
        <?php echo htmlspecialchars($ent['entity_type']); ?>
    </span>
</td>
                                    <td class="admin-td-primary">
                                        <?php echo htmlspecialchars($ent['name'] ?? 'Unnamed Entity'); ?>
                                    </td>
                                    <td class="admin-td-muted">
                                        <?php echo htmlspecialchars($ent['email']); ?>
                                    </td>
                                    <td class="admin-td-date">
                                        <?php echo htmlspecialchars($ent['detail'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($ent['document'])): 
                                            $docHref = (strpos($ent['document'], 'public/') === 0 || strpos($ent['document'], '/') === 0) 
                                                ? htmlspecialchars($ent['document']) 
                                                : 'public/uploads/verification/' . htmlspecialchars($ent['document']);
                                        ?>
                                            <a href="<?php echo $docHref; ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 9px; border-radius: 6px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.78rem; font-weight: 700; text-decoration: none;" title="Open Verification Document in new tab">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>
                                                View Doc
                                            </a>
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-size: 0.78rem; font-style: italic;">No Doc</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-td-date">
                                        <?php echo htmlspecialchars(date('M d, Y', strtotime($ent['created_at']))); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($isEntApproved): ?>
                                            <span class="status status-approved">
                                                &#10003; Approved
                                            </span>
                                        <?php elseif ($isEntRejected): ?>
                                            <span class="status status-rejected" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; font-weight:700; border-radius:9999px; padding:4px 10px; font-size:12px;">
                                                &#10007; Rejected
                                            </span>
                                        <?php else: ?>
                                            <span class="status status-pending" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a; font-weight:700; border-radius:9999px; padding:4px 10px; font-size:12px;">
                                                Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-td-actions" style="white-space: nowrap;">
                                        <?php if ($isEntApproved): ?>
                                            <span class="status-badge-completed" style="font-weight: 700; color: #07a489; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; font-size: 0.82rem;">&#10003; Approved</span>
                                        <?php elseif ($isEntRejected): ?>
                                            <div style="display:inline-flex; align-items:center; gap:6px;">
                                                <span style="font-weight: 700; color: #dc2626; background: #fef2f2; border: 1px solid #fecaca; padding: 6px 10px; border-radius: 6px; font-size: 0.82rem;" title="<?php echo htmlspecialchars($ent['rejection_reason'] ?? 'No reason provided'); ?>">&#10007; Rejected</span>
                                                <a href="index.php?action=admin_update_approval&id=<?php echo $ent['user_id']; ?>&status=approved&from=approvals<?php echo !empty($ent['email']) ? '&email=' . urlencode($ent['email']) : ''; ?>" class="btn admin-btn-action" style="background: #0ea5e9; border-color: #0ea5e9; color: #ffffff; font-weight: 600; border-radius: 6px; padding: 5px 10px; font-size: 0.78rem; text-decoration: none;" title="Re-approve this account">Re-Approve</a>
                                            </div>
                                        <?php else: ?>
                                            <div style="display:inline-flex; align-items:center; gap:6px;">
                                                <a href="index.php?action=admin_update_approval&id=<?php echo $ent['user_id']; ?>&status=approved&from=approvals<?php echo !empty($ent['email']) ? '&email=' . urlencode($ent['email']) : ''; ?>" class="btn admin-btn-action" style="background: #07a489; border-color: #07a489; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 12px; text-decoration: none; font-size: 0.82rem;">Approve</a>
                                                <button type="button" onclick="openRejectModal(<?php echo $ent['user_id']; ?>, '<?php echo htmlspecialchars(addslashes($ent['name'] ?? 'Entity'), ENT_QUOTES); ?>', '<?php echo htmlspecialchars(addslashes($ent['email'] ?? ''), ENT_QUOTES); ?>')" class="btn" style="background: #ef4444; border-color: #ef4444; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 6px 12px; font-size: 0.82rem; cursor: pointer; border: none;">Reject</button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Row -->
                        <tr id="entitiesEmptyState" style="<?php echo empty($entities) ? '' : 'display: none;'; ?>">
                            <td colspan="8" class="admin-empty-state-td">
                                <div class="admin-empty-state-wrapper">
                                    <div class="admin-empty-icon-circle">
                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                    </div>
                                    <span class="admin-empty-state-text">
                                        No registered entities found for the selected category.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="approvalsPagination" class="custom-pagination-container">
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
            const allRows = Array.from(document.querySelectorAll('#entitiesTableBody tr.entity-record-row'));
            const emptyState = document.getElementById('entitiesEmptyState');
            const countSpan = document.getElementById('totalEntitiesCount');
            const paginationContainer = document.getElementById('approvalsPagination');
            const paginationGroup = document.getElementById('paginationButtons');

            const filteredRows = allRows.filter(row => {
                const rowType = (row.getAttribute('data-type') || '').trim().toLowerCase().replace(/[-_ ]/g, '');
                const filterType = (activeFilter || 'all').trim().toLowerCase().replace(/[-_ ]/g, '');
                return filterType === 'all' || filterType === '' || rowType === filterType;
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

        function filterEntities(type) {
            activeFilter = type;
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
    <!-- Rejection Reason Modal -->
    <div id="rejectModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center; backdrop-filter: blur(3px);">
        <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 480px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; margin: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 1.15rem; color: #1e293b; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span style="color: #ef4444;">&#9888;</span> Reject Registration
                </h3>
                <button type="button" onclick="closeRejectModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <form action="index.php?action=admin_update_approval" method="POST">
                <input type="hidden" name="user_id" id="rejectUserId" value="">
                <input type="hidden" name="approval_status" value="rejected">
                <input type="hidden" name="from" value="approvals">
                
                <p style="margin: 0 0 12px 0; font-size: 0.9rem; color: #475569;">
                    Are you sure you want to reject <strong id="rejectEntityName">this entity</strong>? An in-app notification with your reason will be delivered when this user signs in.
                </p>
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 6px;">
                        Reason for Rejection <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="rejection_reason" id="rejectReasonInput" required rows="4" placeholder="Explain why the registration was rejected (e.g., Unverifiable credentials, incomplete business information, invalid certificate)..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-family: inherit; box-sizing: border-box; resize: vertical;"></textarea>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeRejectModal()" style="padding: 9px 16px; border: 1px solid #cbd5e1; background: #f8fafc; color: #475569; border-radius: 6px; font-weight: 600; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 9px 18px; border: none; background: #ef4444; color: #ffffff; border-radius: 6px; font-weight: 700; cursor: pointer;">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openRejectModal(userId, entityName, email) {
        document.getElementById('rejectUserId').value = userId;
        document.getElementById('rejectEntityName').innerText = entityName + (email ? ' (' + email + ')' : '');
        document.getElementById('rejectReasonInput').value = '';
        var modal = document.getElementById('rejectModal');
        modal.style.display = 'flex';
    }

    function closeRejectModal() {
        var modal = document.getElementById('rejectModal');
        modal.style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        var modal = document.getElementById('rejectModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    </script>
</body>
</html>
