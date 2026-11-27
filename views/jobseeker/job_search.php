<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Jobs - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
    <style>
        .search-bar {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
        }
        .search-bar input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 1rem;
        }
        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .job-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .job-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .job-title {
            font-size: 1.25rem;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }
        .company-name {
            color: #64748b;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .job-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .badge {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }
        .badge-type {
            background-color: rgba(2, 86, 208, 0.1);
            color: #0256d0;
            border: 1px solid rgba(2, 86, 208, 0.2);
        }
        .badge-duration {
            background-color: rgba(100, 116, 139, 0.1);
            color: #475569;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }
        .job-desc {
            color: #334155;
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }
    </style>
</head>
<body>
<?php
$activePage = 'jobs';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>


    <div class="container">
        <div class="card">
            <h1>Search Available Jobs</h1>
            <p style="color: #64748b;">Find opportunities that match your skills and qualifications.</p>
            
            <form action="index.php" method="GET" class="search-bar">
                <input type="hidden" name="action" value="job_search">
                <input type="text" name="q" placeholder="Search by job title or keywords..." value="<?= htmlspecialchars(isset($keyword) ? $keyword : '') ?>">
                <button type="submit" class="btn">Search</button>
            </form>
        </div>

        <div class="section-card">
            <h2>Available Jobs</h2>

            <?php if (!empty($jobs)): ?>
                <div class="job-grid">
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card">
                            <div>
                                <h3 class="job-title"><?= htmlspecialchars(isset($job['title']) ? $job['title'] : 'Untitled Position') ?></h3>
                                <div class="company-name"><?= htmlspecialchars(isset($job['company_name']) ? $job['company_name'] : 'Company Confidential') ?></div>

                                <!-- Job Type and Duration/Deadline Badges -->
                                <div class="job-badges">
                                    <span class="badge badge-type">💼 <?= htmlspecialchars($job['job_type'] ?? 'Full-Time') ?></span>
                                    <span class="badge badge-duration">⏳ Deadline: <?= htmlspecialchars(!empty($job['application_deadline']) ? date('M d, Y', strtotime($job['application_deadline'])) : 'Open Until Filled') ?></span>
                                </div>
                                
                                <p class="job-desc"><?= htmlspecialchars(isset($job['description']) ? $job['description'] : 'No description provided.') ?></p>
                            </div>
                            <div>
                                <a href="index.php?action=job_details&id=<?= $job['job_id'] ?>" class="btn" style="width: 100%; text-align: center;">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>No jobs found</h3>
                    <p style="margin-top: 0.5rem;">Try clearing your search query or check back later for new openings.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>