<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Job Applications - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
    <style>
        .filter-bar {
            margin-bottom: 1.5rem;
        }
        .filter-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 1rem;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .filter-input:focus {
            border-color: #0256d0;
        }
        .no-results-row {
            text-align: center;
            color: #64748b;
            padding: 2rem !important;
            font-style: italic;
        }
    </style>
</head>
<body>

<?php
$activePage = 'applications';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>

    <div class="container">
        <div class="section-card">
            <h1>My Job Applications</h1>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Track and manage all the positions you have applied for.</p>

            <?php
            // Fallback Dummy Applications Data if $applications array is empty
            if (empty($applications)) {
                $applications = array(
                    array(
                        'application_id' => 201,
                        'title' => 'Full Stack Software Engineer',
                        'company_name' => 'TechCorp Solutions',
                        'status' => 'Pending',
                        'applied_at' => '2026-09-18'
                    ),
                    array(
                        'application_id' => 202,
                        'title' => 'Senior Frontend Developer',
                        'company_name' => 'InnovateX Labs',
                        'status' => 'Approved',
                        'applied_at' => '2026-09-05'
                    ),
                    array(
                        'application_id' => 203,
                        'title' => 'Junior UI/UX Designer',
                        'company_name' => 'Creative Pulse Agency',
                        'status' => 'Rejected',
                        'applied_at' => '2026-08-28'
                    )
                );
            }
            ?>

            <!-- Single Search Filter Bar -->
            <div class="filter-bar">
                <input type="text" id="applicationSearchInput" class="filter-input" placeholder="Search by job title, status (e.g. Pending, Approved), or month (e.g. Sep)...">
            </div>

            <?php if (!empty($applications)): ?>
                <table class="table" id="applicationsTable">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="applicationsTableBody">
                        <?php foreach ($applications as $app): ?>
                            <?php 
                                $formattedDate = !empty($app['applied_at']) ? date('M d, Y', strtotime($app['applied_at'])) : (!empty($app['created_at']) ? date('M d, Y', strtotime($app['created_at'])) : 'N/A');
                            ?>
                            <tr class="application-row">
                                <td class="app-title"><strong><?= htmlspecialchars(isset($app['title']) ? $app['title'] : 'N/A') ?></strong></td>
                                <td class="app-company"><?= htmlspecialchars(isset($app['company_name']) ? $app['company_name'] : 'N/A') ?></td>
                                <td class="app-status">
                                    <?php 
                                        $status = strtolower(isset($app['status']) ? $app['status'] : 'applied');
                                        $statusClass = 'status-applied';
                                        if (strpos($status, 'pending') !== false) $statusClass = 'status-pending';
                                        elseif (strpos($status, 'approved') !== false || strpos($status, 'hired') !== false) $statusClass = 'status-approved';
                                        elseif (strpos($status, 'rejected') !== false) $statusClass = 'status-rejected';
                                    ?>
                                    <span class="status <?= $statusClass ?>"><?= htmlspecialchars(isset($app['status']) ? $app['status'] : 'Applied') ?></span>
                                </td>
                                <td class="app-date"><?= htmlspecialchars($formattedDate) ?></td>
                                <td>
                                    <form action="index.php?action=my_applications" method="POST" onsubmit="return confirm('Are you sure you want to withdraw this application?');" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?= isset($app['application_id']) ? $app['application_id'] : (isset($app['id']) ? $app['id'] : '') ?>">
                                        <button type="submit" class="btn btn-danger" style="padding: 0.35rem 0.75rem; font-size: 0.85rem;">Withdraw</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Empty State Row for Search Filters -->
                        <tr id="noResultsRow" style="display: none;">
                            <td colspan="5" class="no-results-row">
                                No job applications found matching your search criteria.
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 2.5rem 1rem; color: #64748b;">
                    <h3>No applications submitted yet</h3>
                    <p style="margin: 0.5rem 0 1.5rem;">Explore open positions and start applying today.</p>
                    <a href="index.php?action=job_search" class="btn">Search Jobs</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Instant Search Filtering Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('applicationSearchInput');
            const tableBody = document.getElementById('applicationsTableBody');
            const rows = Array.from(tableBody.querySelectorAll('.application-row'));
            const noResultsRow = document.getElementById('noResultsRow');

            if (!searchInput) return;

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(row => {
                    const title = row.querySelector('.app-title').textContent.toLowerCase();
                    const company = row.querySelector('.app-company').textContent.toLowerCase();
                    const status = row.querySelector('.app-status').textContent.toLowerCase();
                    const date = row.querySelector('.app-date').textContent.toLowerCase();

                    if (title.includes(query) || company.includes(query) || status.includes(query) || date.includes(query)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (noResultsRow) {
                    noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            });
        });
    </script>

</body>
</html>