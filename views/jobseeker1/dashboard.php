<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
</head>
<body>
<?php require __DIR__ . '/partials/jobseeker_navbar.php'; ?>
<?php require __DIR__ . '/partials/jobseeker_header.php'; ?>

<div class="container">
    <!-- Welcome Header Card -->
    <div class="welcome-card">
        <div>
            <h1>Welcome, <?= htmlspecialchars(isset($profile['first_name']) ? $profile['first_name'] : 'Job Seeker', ENT_QUOTES, 'UTF-8') ?>!</h1>
            <p>Track your applications, profile health, and career activities.</p>
        </div>
    </div>

    <?php
        
        // Fallback Dummy Applications Data matching my_application.php
        if (empty($applications)) {
            $applications = array(
                array(
                    'application_id' => 201,
                    'title' => 'Full Stack Software Engineer',
                    'company_name' => 'TechCorp Solutions',
                    'status' => 'Pending',
                    'applied_date' => '2026-09-18'
                ),
                array(
                    'application_id' => 202,
                    'title' => 'Senior Frontend Developer',
                    'company_name' => 'InnovateX Labs',
                    'status' => 'Approved',
                    'applied_date' => '2026-09-05'
                ),
                array(
                    'application_id' => 203,
                    'title' => 'Junior UI/UX Designer',
                    'company_name' => 'Creative Pulse Agency',
                    'status' => 'Rejected',
                    'applied_date' => '2026-08-28'
                )
            );
        }
        // Analytics & Stats Grid
        $totalApps = count($applications);
        $pendingApps = 0;
        $acceptedApps = 0;

        foreach ($applications as $app) {
            $status = strtolower(isset($app['status']) ? $app['status'] : '');
            if ($status === 'pending') $pendingApps++;
            if ($status === 'accepted' || $status === 'approved') $acceptedApps++;
        }

        // Calculate profile completeness
        $completeness = 20;
        if (!empty($profile['first_name'])) $completeness += 20;
        if (!empty($profile['last_name'])) $completeness += 20;
        if (!empty($profile['phone_number'])) $completeness += 20;
if (!empty($profile['education_level'])) $completeness += 20;
        if (!empty($profile['skills'])) $completeness += 20;
    ?>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Applications</h3>
            <div class="number"><?= $totalApps ?></div>
        </div>
        <div class="stat-card stat-success">
            <h3>Profile Completeness</h3>
            <div class="number"><?= $completeness ?>%</div>
        </div>
        <div class="stat-card">
            <h3>Pending Review</h3>
            <div class="number"><?= $pendingApps ?></div>
        </div>
        <div class="stat-card stat-success">
            <h3>Shortlisted</h3>
            <div class="number"><?= $acceptedApps ?></div>
        </div>
    </div>

    <!-- Recent Job Applications Section -->
    <div class="section-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
            <h2>Recent Job Applications</h2>
            
            <!-- Real-time Job Title Filter Input --><div style="display: flex; align-items: center; gap: 0.75rem;">
    <input 
        type="text" 
        id="appliedJobFilter" 
        placeholder="Filter applied jobs by title..." 
        onkeyup="filterAppliedJobs()"
        style="
            width: 300px;
            height: 46px;
            padding: 0 1rem;
            border: 1.5px solid #d6deea;
            border-radius: 10px;
            background: #ffffff;
            color: #334155;
            font-size: 0.95rem;
            outline: none;
            box-sizing: border-box;
        "
    >

    <button 
        type="button" 
        class="btn"
        onclick="filterAppliedJobs()"
        style="
            height: 46px;
            padding: 0 1.5rem;
            margin: 0;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
        "
    >
        Search
    </button>
    </div>
        
        <?php if (empty($applications)): ?>
            <p style="color: var(--text-muted);">No applications submitted yet. <a href="index.php?action=job_search" style="color: #a855f7;">Browse open positions</a> to apply!</p>
        <?php else: ?>
            <table class="table" id="appliedJobsTable">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Applied Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <?php 
                        $statusClass = 'status-pending';
                        $statusLower = strtolower(isset($app['status']) ? $app['status'] : '');
                        if ($statusLower === 'accepted' || $statusLower === 'approved') {
                            $statusClass = 'status-approved';
                        } elseif ($statusLower === 'rejected') {
                            $statusClass = 'status-rejected';
                        } elseif ($statusLower === 'applied') {
                            $statusClass = 'status-applied';
                        }
                    ?>
                    <tr>
                        <td class="job-title-cell"><strong><?= htmlspecialchars(isset($app['title']) ? $app['title'] : '') ?></strong></td>
                        <td><?= htmlspecialchars(isset($app['company_name']) ? $app['company_name'] : 'N/A') ?></td>
                        <td><span class="status <?= $statusClass ?>"><?= htmlspecialchars(isset($app['status']) ? $app['status'] : 'Pending') ?></span></td>
                        <td><?= htmlspecialchars(isset($app['applied_date']) ? $app['applied_date'] : 'N/A') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <p id="noMatchesText" style="display: none; color: var(--text-muted); margin-top: 1rem;">
                No applied jobs found matching that title.
            </p>

            <?php if (count($applications) > 5): ?>
                <br>
                <a href="index.php?action=my_applications" class="btn" style="font-size: 0.85rem; padding: 0.5rem 1rem;">View All Applications &rarr;</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Filter Script -->
    <script>
    function filterAppliedJobs() {
        const filterValue = document.getElementById('appliedJobFilter').value.toLowerCase();
        const table = document.getElementById('appliedJobsTable');
        if (!table) return;

        const rows = table.getElementsByTagName('tr');
        let matchesCount = 0;

        for (let i = 1; i < rows.length; i++) {
            const titleCell = rows[i].getElementsByClassName('job-title-cell')[0];
            if (titleCell) {
                const titleText = titleCell.textContent || titleCell.innerText;
                if (titleText.toLowerCase().includes(filterValue)) {
                    rows[i].style.display = '';
                    matchesCount++;
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        const noMatchesMsg = document.getElementById('noMatchesText');
        if (noMatchesMsg) {
            noMatchesMsg.style.display = matchesCount === 0 ? 'block' : 'none';
        }
    }
    </script>


</body>
</html>
