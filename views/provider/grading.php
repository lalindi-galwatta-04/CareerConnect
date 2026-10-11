<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading & Results - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
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
            <a href="index.php?action=manage_course" class="sidebar-sub-btn">Add New Course</a>

            <a href="index.php?action=provider_dashboard&view=roster" class="sidebar-nav-item">
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

            <a href="index.php?action=provider_dashboard&view=grading" class="sidebar-nav-item active">
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
        <!-- Top Title -->
        <div class="admin-page-header">
            <h1 class="admin-page-title">Grading & Assessment Results</h1>
        </div>

        <!-- Grading & Results Card -->
        <div class="card admin-card">
            
            <!-- Filter Controls Bar -->
            <div class="admin-filter-bar" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 1.5rem; gap: 1rem;">
                <div class="admin-filter-group" style="display: flex; align-items: center; gap: 0.75rem;">
                    <label for="courseGradingFilter" class="admin-filter-label" style="font-size: 0.92rem; font-weight: 700; color: #334155; margin: 0; white-space: nowrap;">Filter by Course:</label>
                    <select id="courseGradingFilter" class="admin-select" onchange="filterGrading(this.value)">
                        <option value="all" <?php echo ($selectedCourseId === null) ? 'selected' : ''; ?>>All Completed Offerings</option>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?php echo $c['course_id']; ?>" <?php echo ($selectedCourseId == $c['course_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="admin-filter-right" style="margin-left: auto; text-align: right; display: flex; align-items: center;">
                    <span class="admin-count-badge">
                        Pending Evaluations: <strong id="pendingEvaluationsCount"><?php 
                            $pendingCount = 0;
                            if (!empty($gradingRecords)) {
                                foreach ($gradingRecords as $gr) {
                                    if (empty($gr['final_grade']) || strtolower($gr['final_grade']) === 'pending') {
                                        $pendingCount++;
                                    }
                                }
                            }
                            echo $pendingCount;
                        ?></strong>
                    </span>
                </div>
            </div>

            <!-- Grading Table Container -->
            <div class="admin-table-wrapper">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>STUDENT NAME</th>
                            <th>ENROLLED COURSE</th>
                            <th>COMPLETION STATUS</th>
                            <th>FINAL GRADE</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="gradingTableBody">
                        <?php if (!empty($gradingRecords)): ?>
                            <?php foreach ($gradingRecords as $gr): ?>
                                <tr class="grading-record-row" data-course-id="<?php echo $gr['course_id']; ?>" data-pending="<?php echo (empty($gr['final_grade']) || strtolower($gr['final_grade']) === 'pending') ? '1' : '0'; ?>">
                                    <td class="admin-td-primary">
                                        <?php echo htmlspecialchars($gr['student_name']); ?>
                                    </td>
                                    <td class="admin-td-brand">
                                        <?php echo htmlspecialchars($gr['course_title']); ?>
                                    </td>
                                    <td>
                                        <span class="status status-approved">
                                            <?php echo htmlspecialchars(ucfirst($gr['completion_status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($gr['final_grade']) && strtolower($gr['final_grade']) !== 'pending'): ?>
                                            <span class="admin-td-price" style="font-weight: 800;">
                                                <?php echo htmlspecialchars($gr['final_grade']); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="admin-td-muted" style="font-style: italic;">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="admin-td-actions">
                                        <button type="button" class="btn btn-outline admin-btn-action" onclick="openGradeModal(<?php echo $gr['enrollment_id']; ?>, '<?php echo htmlspecialchars(addslashes($gr['student_name'])); ?>', '<?php echo htmlspecialchars(addslashes($gr['course_title'])); ?>', '<?php echo htmlspecialchars(addslashes($gr['final_grade'] ?? '')); ?>')">
                                            <?php echo (!empty($gr['final_grade']) && strtolower($gr['final_grade']) !== 'pending') ? 'Edit Grade' : 'Assign Grade'; ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Empty State Row -->
                        <tr id="gradingEmptyState" style="<?php echo empty($gradingRecords) ? '' : 'display: none;'; ?>">
                            <td colspan="5" class="admin-empty-state-td">
                                <div class="admin-empty-state-wrapper">
                                    <div class="admin-empty-icon-circle">
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                        </svg>
                                    </div>
                                    <span class="admin-empty-state-text">
                                        No records available for grading in this course offering.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Dynamic Pagination Controls -->
            <div id="gradingPagination" class="custom-pagination-container">
                <div class="pagination-btn-group" id="paginationButtons">
                    <!-- Dynamic Page Buttons Generated via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Grade Modal -->
        <div class="grade-modal-overlay" id="gradeModal">
            <div class="grade-modal-box">
                <h3 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.25rem; color: #0f172a; font-weight: 800;">Assign Course Grade</h3>
                <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1.25rem; line-height: 1.5;">
                    Student: <strong id="modalStudentName" style="color: #0f172a;"></strong><br>
                    Course: <span id="modalCourseTitle" style="color: #0256d0; font-weight: 600;"></span>
                </p>
                <form method="POST" action="index.php?action=provider_dashboard&view=grading">
                    <input type="hidden" name="action_type" value="update_grade">
                    <input type="hidden" name="enrollment_id" id="modalEnrollmentId">
                    
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Final Grade / Evaluation <span class="required" style="color: #ef4444;">*</span></label>
                        <input type="text" name="grade" id="modalGradeInput" placeholder="e.g. A+, A, Distinction, Pass" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" style="padding: 0.5rem 1rem;" onclick="closeGradeModal()">Cancel</button>
                        <button type="submit" class="btn" style="padding: 0.5rem 1.25rem;">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Client-side Instant Filter & Modal Script for Grading -->
    <script>
        let currentPage = 1;
        const rowsPerPage = 5;
        let activeFilter = 'all';

        function renderPagination() {
            const allRows = Array.from(document.querySelectorAll('#gradingTableBody tr.grading-record-row'));
            const emptyState = document.getElementById('gradingEmptyState');
            const pendingCountSpan = document.getElementById('pendingEvaluationsCount');
            const paginationContainer = document.getElementById('gradingPagination');
            const paginationGroup = document.getElementById('paginationButtons');

            let pendingCount = 0;
            const filteredRows = allRows.filter(row => {
                const rowCourseId = String(row.getAttribute('data-course-id') || '').trim();
                const targetFilter = String(activeFilter || 'all').trim();
                const matches = targetFilter === 'all' || targetFilter === '' || rowCourseId === targetFilter;
                if (matches) {
                    const isPending = row.getAttribute('data-pending') === '1';
                    if (isPending) pendingCount++;
                }
                return matches;
            });

            const totalRows = filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

            if (pendingCountSpan) {
                pendingCountSpan.textContent = pendingCount;
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

        function filterGrading(courseId) {
            activeFilter = courseId;
            currentPage = 1;
            renderPagination();
        }

        function openGradeModal(enrollmentId, studentName, courseTitle, currentGrade) {
            document.getElementById('modalEnrollmentId').value = enrollmentId;
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('modalCourseTitle').textContent = courseTitle;
            document.getElementById('modalGradeInput').value = currentGrade || '';
            document.getElementById('gradeModal').classList.add('open');
        }

        function closeGradeModal() {
            document.getElementById('gradeModal').classList.remove('open');
        }

        document.getElementById('gradeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGradeModal();
            }
        });

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
            const initialFilter = document.getElementById('courseGradingFilter') ? document.getElementById('courseGradingFilter').value : 'all';
            activeFilter = initialFilter;
            renderPagination();
        });
    </script>
</body>
</html>
