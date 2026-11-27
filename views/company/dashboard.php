<?php
/**
 * CareerConnect - Company Dashboard
 * Compact overview with demo chart data. Replace demo arrays with database data later.
 */
$companyName = $company['company_name'] ?? 'Company Account';
$totalApplications = $totalApplications ?? count($dummyApplicants ?? []);
$activeJobs = $activeJobs ?? 0;
$postedJobs = $postedJobs ?? 0;
$draftedJobs = $draftedJobs ?? 0;
$pendingApplications = $pendingApplications ?? 0;
$shortlistedApplications = $shortlistedApplications ?? 0;
$interviewApplications = $interviewApplications ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=5.2">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Dashboard-specific styles; existing site stylesheet and navbar are retained. */
        :root { --cc-navy:#092853; --cc-blue:#065fd5; --cc-muted:#64748b; --cc-border:#e2e8f0; }
        html, body { min-height:100%; }
        body { background:#f5f7fb; }
        .cc-dashboard { width:min(1500px,100%); margin:0 auto; padding:14px 22px 18px; }
        .cc-dashboard-top { display:flex; justify-content:space-between; align-items:center; gap:14px; margin-bottom:14px; }
        .cc-dashboard-top h1 { color:var(--cc-navy); font-size:clamp(1.25rem,2vw,1.7rem); margin:0 0 4px; }
        .cc-dashboard-top p { color:var(--cc-muted); font-size:.85rem; margin:0; }
        .cc-quick-link { display:inline-flex; align-items:center; justify-content:center; gap:7px; border-radius:8px; padding:9px 12px; background:var(--cc-blue); color:#fff; text-decoration:none; font-size:.83rem; font-weight:600; white-space:nowrap; }
        .cc-quick-link:hover { filter:brightness(.94); }
        .cc-stats { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin-bottom:14px; }
        .cc-stat { display:flex; align-items:center; justify-content:space-between; gap:10px; min-width:0; padding:13px 16px; background:#fff; border:1px solid var(--cc-border); border-radius:12px; text-decoration:none; color:inherit; box-shadow:0 2px 7px rgba(15,23,42,.025); transition:transform .15s ease, box-shadow .15s ease; }
        .cc-stat:hover,.cc-chart-link:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(15,23,42,.08); }
        .cc-stat-label { display:block; color:var(--cc-muted); font-size:.78rem; margin-bottom:5px; }
        .cc-stat-value { color:var(--cc-navy); font-size:1.65rem; line-height:1.1; font-weight:750; }
        .cc-stat-icon { display:grid; place-items:center; width:38px; height:38px; border-radius:10px; background:#edf4ff; color:var(--cc-blue); font-size:1.15rem; flex-shrink:0; }
        .cc-section-heading { display:flex; align-items:center; justify-content:space-between; gap:12px; margin:0 0 10px; }
        .cc-section-heading h2 { color:var(--cc-navy); font-size:1rem; margin:0; }
        .cc-section-heading p { color:var(--cc-muted); font-size:.76rem; margin:3px 0 0; }
        .cc-text-link { color:var(--cc-blue); text-decoration:none; font-weight:650; font-size:.8rem; white-space:nowrap; }
        .cc-text-link:hover { text-decoration:underline; }
        .cc-charts { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:13px; }
        .cc-chart-link { display:block; min-width:0; padding:15px 15px 12px; border:1px solid var(--cc-border); border-radius:12px; background:#fff; color:inherit; text-decoration:none; box-shadow:0 2px 7px rgba(15,23,42,.025); transition:transform .15s ease,box-shadow .15s ease; }
        .cc-chart-title-row { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; margin-bottom:7px; }
        .cc-chart-title { color:var(--cc-navy); font-size:.9rem; font-weight:700; margin:0; }
        .cc-chart-period { color:var(--cc-muted); font-size:.7rem; white-space:nowrap; }
        .cc-chart-wrap { position:relative; height:clamp(175px,24vh,230px); width:100%; }
        .cc-chart-footer { display:flex; justify-content:space-between; align-items:center; gap:8px; border-top:1px solid #eef2f7; padding-top:9px; margin-top:7px; color:var(--cc-blue); font-size:.75rem; font-weight:650; }
        .cc-demo-note { color:var(--cc-muted); font-size:.7rem; margin:9px 1px 0; }
        .cc-empty-note { padding:14px; border:1px dashed var(--cc-border); border-radius:10px; color:var(--cc-muted); font-size:.85rem; }
        @media (min-width:1100px) and (min-height:700px) {
            .cc-dashboard { padding-top:10px; }
            .cc-dashboard-top { margin-bottom:10px; }
            .cc-stats { margin-bottom:11px; }
            .cc-chart-wrap { height:clamp(170px,23vh,220px); }
        }
        @media (max-width:1000px) {
            .cc-charts { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .cc-chart-link:last-child { grid-column:1 / -1; }
            .cc-chart-wrap { height:220px; }
        }
        @media (max-width:650px) {
            .cc-dashboard { padding:14px 12px 24px; }
            .cc-dashboard-top { align-items:flex-start; }
            .cc-stats { grid-template-columns:repeat(2,minmax(0,1fr)); gap:9px; }
            .cc-stat { padding:11px; }
            .cc-stat-value { font-size:1.4rem; }
            .cc-stat-icon { width:32px; height:32px; }
            .cc-charts { grid-template-columns:1fr; }
            .cc-chart-link:last-child { grid-column:auto; }
            .cc-chart-wrap { height:230px; }
            .cc-quick-link { padding:8px 9px; font-size:.75rem; }
        }
        @media (max-height:700px) and (min-width:1001px) {
            .cc-dashboard { padding-top:7px; }
            .cc-dashboard-top { margin-bottom:7px; }
            .cc-stats { margin-bottom:8px; }
            .cc-stat { padding:9px 13px; }
            .cc-chart-link { padding:11px 12px 9px; }
            .cc-chart-wrap { height:165px; }
        }
    </style>
</head>
<body>
<?php
$activePage = 'dashboard';
require __DIR__ . '/partials/company_navbar.php';
?>
<header class="top-header">
    <div class="user-profile" id="userProfile">
        <button type="button" class="user-profile-button" onclick="toggleProfileDropdown()">
            <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
                <?php echo htmlspecialchars(strtoupper(substr($companyName, 0, 1))); ?>
            </div>
            <span class="user-name"><?php echo htmlspecialchars($companyName); ?></span>
            <span class="user-arrow">▼</span>
        </button>
        <div class="profile-dropdown" id="profileDropdown">
            <div class="dropdown-user">
                <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-weight:700;">
                    <?php echo htmlspecialchars(strtoupper(substr($companyName, 0, 1))); ?>
                </div>
                <div class="dropdown-user-info">
                    <strong><?php echo htmlspecialchars($companyName); ?></strong>
                    <span><?php echo htmlspecialchars($company['email'] ?? ''); ?></span>
                </div>
            </div>
            <a href="index.php?action=company_profile">Company Profile</a>
            <a href="index.php?action=logout" class="dropdown-logout">Logout</a>
        </div>
    </div>
</header>

<main class="cc-dashboard">
    <section class="cc-dashboard-top">
        <div>
            <h1>Welcome, <?php echo htmlspecialchars($companyName); ?></h1>
            <p>
                <?php if (!empty($company['industry'])): ?>
                    <?php echo htmlspecialchars($company['industry']); ?> · 
                <?php endif; ?>Your recruitment activity at a glance
            </p>
        </div>
        <a class="cc-quick-link" href="index.php?action=manage_job">＋ Post a Job</a>
    </section>

    <section class="cc-stats" aria-label="Recruitment summary">
        <a class="cc-stat" href="index.php?action=applicants">
            <div><span class="cc-stat-label">Total Applications</span><strong class="cc-stat-value"><?php echo htmlspecialchars((string)$totalApplications); ?></strong></div>
            <span class="cc-stat-icon" aria-hidden="true">♙</span>
        </a>
        <a class="cc-stat" href="index.php?action=manage_jobs">
            <div><span class="cc-stat-label">Active Jobs</span><strong class="cc-stat-value"><?php echo htmlspecialchars((string)$activeJobs); ?></strong></div>
            <span class="cc-stat-icon" aria-hidden="true">▣</span>
        </a>
        <a class="cc-stat" href="index.php?action=manage_jobs">
            <div><span class="cc-stat-label">Posted Jobs</span><strong class="cc-stat-value"><?php echo htmlspecialchars((string)$postedJobs); ?></strong></div>
            <span class="cc-stat-icon" aria-hidden="true">↗</span>
        </a>
        <a class="cc-stat" href="index.php?action=manage_jobs">
            <div><span class="cc-stat-label">Draft Jobs</span><strong class="cc-stat-value"><?php echo htmlspecialchars((string)$draftedJobs); ?></strong></div>
            <span class="cc-stat-icon" aria-hidden="true">✎</span>
        </a>
    </section>

    <section aria-labelledby="recruitmentOverviewTitle">
        <div class="cc-section-heading">
            <div>
                <h2 id="recruitmentOverviewTitle">Recruitment Overview</h2>
                <p>Quick insights from your recruitment activity</p>
            </div>
            <a class="cc-text-link" href="index.php?action=company_analytics">Full Recruitment Insights →</a>
        </div>

        <div class="cc-charts">
            <a class="cc-chart-link" href="index.php?action=company_analytics" aria-label="Open recruitment insights for application trends">
                <div class="cc-chart-title-row"><h3 class="cc-chart-title">Application Trends</h3><span class="cc-chart-period">Last 6 months</span></div>
                <div class="cc-chart-wrap"><canvas id="applicationsOverTimeChart" role="img" aria-label="Line chart of applications over six months"></canvas></div>
                <div class="cc-chart-footer"><span>View Recruitment Insights</span><span aria-hidden="true">→</span></div>
            </a>

            <a class="cc-chart-link" href="index.php?action=applicants" aria-label="Open applicants to review application statuses">
                <div class="cc-chart-title-row"><h3 class="cc-chart-title">Application Status</h3><span class="cc-chart-period">Current overview</span></div>
                <div class="cc-chart-wrap"><canvas id="applicationStatusChart" role="img" aria-label="Doughnut chart of application statuses"></canvas></div>
                <div class="cc-chart-footer"><span>Review Applicants</span><span aria-hidden="true">→</span></div>
            </a>

            <a class="cc-chart-link" href="index.php?action=manage_jobs" aria-label="Open job vacancies to manage recruitment">
                <div class="cc-chart-title-row"><h3 class="cc-chart-title">Applications by Job</h3><span class="cc-chart-period">Top 5 vacancies</span></div>
                <div class="cc-chart-wrap"><canvas id="applicationsByVacancyChart" role="img" aria-label="Bar chart of applications by job vacancy"></canvas></div>
                <div class="cc-chart-footer"><span>Manage Job Vacancies</span><span aria-hidden="true">→</span></div>
            </a>
        </div>
        <p class="cc-demo-note">Demo charts: the figures shown in these charts are sample data and are not yet connected to live application records.</p>
    </section>
</main>

<script>
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    const profile = document.getElementById('userProfile');
    if (dropdown && profile) {
        dropdown.classList.toggle('show');
        profile.classList.toggle('open');
    }
}
document.addEventListener('click', function (event) {
    const profile = document.getElementById('userProfile');
    const dropdown = document.getElementById('profileDropdown');
    if (profile && dropdown && !profile.contains(event.target)) {
        dropdown.classList.remove('show');
        profile.classList.remove('open');
    }
});

 document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js did not load. Check your internet connection or CDN access.');
        return;
    }
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
    Chart.defaults.color = '#64748b';

    new Chart(document.getElementById('applicationsOverTimeChart'), {
        type: 'line',
        data: {
            labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            datasets: [{
                label: 'Applications', data: [18, 27, 23, 39, 34, 48],
                borderColor: '#065fd5', backgroundColor: 'rgba(6,95,213,.12)',
                fill: true, tension: .35, pointRadius: 3, pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef2f7' } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('applicationStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending Review', 'Shortlisted', 'Interview Scheduled', 'Rejected'],
            datasets: [{
                data: [28, 19, 12, 9],
                backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444'],
                borderColor: '#ffffff', borderWidth: 3, hoverOffset: 5
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '62%',
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, boxWidth: 8, font: { size: 10 } } } }
        }
    });

    new Chart(document.getElementById('applicationsByVacancyChart'), {
        type: 'bar',
        data: {
            labels: ['Software Engineer', 'UI/UX Designer', 'QA Engineer', 'Data Analyst', 'Product Intern'],
            datasets: [{
                label: 'Applications', data: [46, 32, 27, 21, 14],
                backgroundColor: ['#065fd5', '#2878df', '#4d91e8', '#79acef', '#a5c8f5'],
                borderRadius: 5, maxBarThickness: 22
            }]
        },
        options: {
            indexAxis: 'y', responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0, font: { size: 10 } }, grid: { color: '#eef2f7' } },
                y: { ticks: { font: { size: 10 } }, grid: { display: false } }
            }
        }
    });
});
</script>
</body>
</html>
