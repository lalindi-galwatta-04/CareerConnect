<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Requests - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
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

        .requests-container {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 95px 45px 50px;
            min-height: 100vh;
        }

        .requests-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 34px 38px 40px;
            box-shadow: 0 6px 24px rgba(9, 40, 83, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.85);
            max-width: 1400px;
            margin: 0 auto;
        }

        .requests-header {
            display: flex;
            align-items: baseline;
            gap: 14px;
            margin-bottom: 24px;
        }

        .requests-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .requests-subtitle {
            font-size: 1.05rem;
            color: #64748b;
            font-weight: 500;
        }

        .requests-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .requests-search-box {
            position: relative;
            width: 280px;
        }

        .requests-search-input {
            width: 100%;
            height: 40px;
            padding: 0 16px 0 38px;
            font-size: 0.92rem;
            color: #0f172a;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .requests-search-input:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .requests-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .requests-filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .requests-select {
            height: 40px;
            padding: 0 32px 0 14px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #334155;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            position: relative;
        }

        .requests-select:focus {
            border-color: #0284c7;
        }

        .select-wrapper {
            position: relative;
        }

        .select-chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #64748b;
            font-size: 11px;
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
        }

        .requests-table th {
            text-align: left;
            padding: 14px 16px;
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .requests-table td {
            padding: 16px;
            font-size: 0.92rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .requests-table tr:hover {
            background: #f8fafc;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .student-circle-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            flex-shrink: 0;
        }

        .badge-verified {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 3px;
        }

        .doc-link {
            color: #0284c7;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .doc-link:hover {
            text-decoration: underline;
        }

        .btn-approve {
            background: #059669;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 7px 16px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            margin-right: 6px;
        }

        .btn-approve:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        .btn-reject {
            background: #dc2626;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 7px 16px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }

        .btn-reject:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            font-size: 0.9rem;
            color: #64748b;
        }

        .pagination-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }

        .page-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .page-btn.active {
            background: #092853;
            color: #ffffff;
            border-color: #092853;
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

            <a href="index.php?action=enrollment_requests" class="sidebar-nav-item active">
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
    <main class="requests-container">
        <div class="requests-card">
            <!-- Header -->
            <div class="requests-header">
                <h1 class="requests-title">Enrollment Requests</h1>
                <span class="requests-subtitle"><?php echo (int)($pendingCount ?? 0); ?> Pending Registrations</span>
            </div>

            <!-- Filter Controls Bar -->
            <div class="requests-filter-bar">
                <div class="requests-search-box">
                    <svg class="requests-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="requestsSearchInput" class="requests-search-input" placeholder="Search" autocomplete="off">
                </div>

                <div class="requests-filter-group">
                    <div class="select-wrapper">
                        <select id="courseFilterSelect" class="requests-select" onchange="filterRequests()">
                            <option value="all">Filter by Course (All)</option>
                            <?php if (!empty($courses)): ?>
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?php echo $c['course_id']; ?>" <?php echo (isset($_GET['course_id']) && $_GET['course_id'] == $c['course_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($c['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="select-chevron">▼</span>
                    </div>

                    <div class="select-wrapper">
                        <select id="statusFilterSelect" class="requests-select" onchange="filterRequests()">
                            <option value="all">Status (All)</option>
                            <option value="active" <?php echo (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : ''; ?>>Status (Active / Approved)</option>
                            <option value="completed" <?php echo (isset($_GET['status']) && $_GET['status'] == 'completed') ? 'selected' : ''; ?>>Status (Completed)</option>
                            <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : ''; ?>>Status (Cancelled / Rejected)</option>
                        </select>
                        <span class="select-chevron">▼</span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div style="overflow-x: auto;">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Applied Course</th>
                            <th>Payment Method</th>
                            <th>Submitted Date</th>
                            <th>Document</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTableBody">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                    No enrollment requests found in the database.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $req): ?>
                                <tr class="request-row" data-course-id="<?php echo $req['course_id']; ?>" data-name="<?php echo htmlspecialchars(strtolower($req['student_name'])); ?>" data-course="<?php echo htmlspecialchars(strtolower($req['course_title'])); ?>">
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-circle-avatar">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                            <span><?php echo htmlspecialchars($req['student_name']); ?></span>
                                        </div>
                                    </td>
                                    <td style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($req['course_title']); ?></td>
                                    <td>
                                        <div>Bank Transfer</div>
                                    </td>
                                    <td style="color: #64748b;"><?php echo date('d M, h:i A', strtotime($req['enrolled_at'])); ?></td>
                                    <td>
                                        <span style="color: #64748b;">✓ N/A</span>
                                    </td>
                                    <td style="text-align: right; white-space: nowrap;">
                                        <form method="POST" action="index.php?action=enrollment_requests" style="display: inline-block;">
                                            <input type="hidden" name="action_type" value="update_status">
                                            <input type="hidden" name="enrollment_id" value="<?php echo $req['enrollment_id']; ?>">
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="btn-approve" onclick="return confirm('Approve this student enrollment?');">Approve</button>
                                        </form>

                                        <form method="POST" action="index.php?action=enrollment_requests" style="display: inline-block;">
                                            <input type="hidden" name="action_type" value="update_status">
                                            <input type="hidden" name="enrollment_id" value="<?php echo $req['enrollment_id']; ?>">
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-reject" onclick="return confirm('Reject this student enrollment?');">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="table-footer">
                <div>Showing <?php echo count($requests ?? []); ?> of <?php echo count($requests ?? []); ?> requests</div>
                <div class="pagination-group">
                    <button type="button" class="page-btn">Prev</button>
                    <button type="button" class="page-btn active">1</button>
                    <button type="button" class="page-btn">Next</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Real-time search filter
        const searchInput = document.getElementById('requestsSearchInput');
        const rows = Array.from(document.querySelectorAll('#requestsTableBody tr.request-row'));

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                rows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const course = row.getAttribute('data-course') || '';
                    if (name.includes(query) || course.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        function filterRequests() {
            const courseId = document.getElementById('courseFilterSelect').value;
            const status = document.getElementById('statusFilterSelect').value;
            let url = 'index.php?action=enrollment_requests';
            const params = [];
            if (courseId !== 'all') params.push('course_id=' + encodeURIComponent(courseId));
            if (status !== 'all') params.push('status=' + encodeURIComponent(status));
            if (params.length > 0) {
                url += '&' + params.join('&');
            }
            window.location.href = url;
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
    </script>
</body>
</html>
