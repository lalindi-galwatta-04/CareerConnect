<?php

$companyName = $company['company_name'] ?? 'Company Account';

$totalApplications = $totalApplications ?? count($dummyApplicants ?? []);
$activeJobs = $activeJobs ?? 0;
$postedJobs = $postedJobs ?? 0;
$draftedJobs = $draftedJobs ?? 0;

$today = date('Y-m-d');

function dashboardApplicantStatusStyle($status) {
    switch ($status) {
        case 'Shortlisted':
            return [
                'background' => '#e6f4ea',
                'color' => '#137333'
            ];

        case 'Interview Scheduled':
            return [
                'background' => '#e8f0fe',
                'color' => '#174ea6'
            ];

        case 'Rejected':
            return [
                'background' => '#fce8e6',
                'color' => '#c5221f'
            ];

        default:
            return [
                'background' => '#fff4d6',
                'color' => '#8a6300'
            ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Company Dashboard - CareerConnect</title>

    <link
        rel="stylesheet"
        href="public/css/style.css?v=5.0"
    >

</head>

<body>

<?php
$activePage = 'dashboard';
require __DIR__ . '/partials/company_navbar.php';
?>

<header class="top-header">

    <div
        class="user-profile"
        id="userProfile"
    >

        <button
            type="button"
            class="user-profile-button"
            onclick="toggleProfileDropdown()"
        >

            <div
                class="user-avatar"
                style="display:flex;align-items:center;justify-content:center;font-weight:700;"
            >
                <?php
                    echo htmlspecialchars(
                        strtoupper(
                            substr($companyName, 0, 1)
                        )
                    );
                ?>
            </div>

            <span class="user-name">
                <?php echo htmlspecialchars($companyName); ?>
            </span>

            <span class="user-arrow">
                ▼
            </span>

        </button>

        <div
            class="profile-dropdown"
            id="profileDropdown"
        >

            <div class="dropdown-user">

                <div
                    class="user-avatar"
                    style="display:flex;align-items:center;justify-content:center;font-weight:700;"
                >
                    <?php
                        echo htmlspecialchars(
                            strtoupper(
                                substr($companyName, 0, 1)
                            )
                        );
                    ?>
                </div>

                <div class="dropdown-user-info">

                    <strong>
                        <?php echo htmlspecialchars($companyName); ?>
                    </strong>

                    <span>
                        <?php echo htmlspecialchars($company['email'] ?? ''); ?>
                    </span>

                </div>

            </div>

            <a href="index.php?action=company_profile">
                Company Profile
            </a>

            <a
                href="index.php?action=logout"
                class="dropdown-logout"
            >
                Logout
            </a>

        </div>

    </div>

</header>

<main class="container">

    <div class="welcome-card">

        <div>

            <h1>
                Welcome,
                <?php echo htmlspecialchars($companyName); ?>
            </h1>

            <?php if (!empty($company['industry'])): ?>

                <p style="margin-top:10px;">

                    <strong>
                        Industry:
                    </strong>

                    <?php echo htmlspecialchars($company['industry']); ?>

                </p>

            <?php endif; ?>

        </div>

    </div>


    <div
        class="stats-grid"
        style="margin-top:30px;"
    >

        <div class="stat-card">

            <div>

                <p>
                    Total Applications
                </p>

                <h2>
                    <?php echo htmlspecialchars($totalApplications); ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div>

                <p>
                    Active Jobs
                </p>

                <h2>
                    <?php echo htmlspecialchars($activeJobs); ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div>

                <p>
                    Posted Jobs
                </p>

                <h2>
                    <?php echo htmlspecialchars($postedJobs); ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div>

                <p>
                    Drafted Jobs
                </p>

                <h2>
                    <?php echo htmlspecialchars($draftedJobs); ?>
                </h2>

            </div>

        </div>

    </div>


    <!-- RECENT JOBS -->

    <div
        id="jobs"
        class="section-card"
        style="margin-top:30px;"
    >

        <div
            style="display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:20px;"
        >

            <div>

                <h2 style="margin-bottom:5px;">
                    Recent Jobs
                </h2>

            </div>

            <a
                href="index.php?action=manage_jobs"
                class="btn btn-secondary"
            >
                View All Jobs
            </a>

        </div>


        <?php if (!empty($jobs)): ?>

            <div style="overflow-x:auto;">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Job Title
                            </th>

                            <th>
                                Opening Date
                            </th>

                            <th>
                                Closing Date
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach (array_slice($jobs, 0, 2) as $job): ?>

                        <?php

                        $jobStatus =
                            strtolower(
                                $job['status'] ?? 'draft'
                            );

                        if ($jobStatus === 'draft') {

                            $displayStatus = 'Draft';

                        } elseif (
                            !empty($job['opening_date']) &&
                            $job['opening_date'] > $today
                        ) {

                            $displayStatus = 'Upcoming';

                        } elseif (
                            !empty($job['closing_date']) &&
                            $job['closing_date'] < $today
                        ) {

                            $displayStatus = 'Closed';

                        } else {

                            $displayStatus = 'Active';

                        }

                        ?>

                        <tr>

                            <td>

                                <strong>
                                    <?php
                                        echo htmlspecialchars(
                                            $job['title'] ?? ''
                                        );
                                    ?>
                                </strong>

                            </td>

                            <td>

                                <?php
                                    echo htmlspecialchars(
                                        $job['opening_date'] ?? ''
                                    );
                                ?>

                            </td>

                            <td>

                                <?php
                                    echo htmlspecialchars(
                                        $job['closing_date'] ?? ''
                                    );
                                ?>

                            </td>

                            <td>

                                <?php
                                    echo htmlspecialchars(
                                        $displayStatus
                                    );
                                ?>

                            </td>

                            <td>

                                <a
                                    href="index.php?action=manage_job&id=<?php echo urlencode($job['job_id']); ?>"
                                    class="btn btn-secondary"
                                >
                                    Edit
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h3>
                    No Jobs Created Yet
                </h3>

                <p>
                    Create and save your first job vacancy to get started.
                </p>

                <a
                    href="index.php?action=manage_job"
                    class="btn"
                    style="margin-top:15px;"
                >
                    + New Job
                </a>

            </div>

        <?php endif; ?>

    </div>


    <!-- RECENT APPLICATIONS -->

    <div
        id="applications"
        class="section-card"
        style="margin-top:30px;"
    >

        <div
            style="display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:20px;"
        >

            <div>

                <h2 style="margin-bottom:5px;">
                    Recent Applications
                </h2>

            </div>

            <a
                href="index.php?action=applicants"
                class="btn btn-secondary"
            >
                View Applicants
            </a>

        </div>


        <?php if (!empty($dummyApplicants)): ?>

            <div style="overflow-x:auto;">

                <table style="min-width:800px;">

                    <thead>

                        <tr>

                            <th>
                                Candidate
                            </th>

                            <th>
                                Applied Position
                            </th>

                            <th>
                                Applied Date
                            </th>

                            <th>
                                Status
                            </th>

                            <th style="text-align:right;">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach (array_slice($dummyApplicants, 0, 2) as $applicant): ?>

                        <?php

                        $applicantStatus =
                            $applicantStatuses[$applicant['key']]
                            ?? 'Pending Review';

                        $statusStyle =
                            dashboardApplicantStatusStyle(
                                $applicantStatus
                            );

                        ?>

                        <tr>

                            <td>

                                <strong>
                                    <?php
                                        echo htmlspecialchars(
                                            $applicant['name']
                                        );
                                    ?>
                                </strong>

                                <div
                                    style="font-size:12px;color:var(--text-muted);margin-top:4px;"
                                >
                                    <?php
                                        echo htmlspecialchars(
                                            $applicant['email']
                                        );
                                    ?>
                                </div>

                            </td>

                            <td>

                                <?php
                                    echo htmlspecialchars(
                                        $applicant['job']
                                    );
                                ?>

                            </td>

                            <td>

                                <?php
                                    echo htmlspecialchars(
                                        $applicant['applied_date']
                                    );
                                ?>

                            </td>

                            <td>

                                <span
                                    style="
                                        display:inline-block;
                                        padding:5px 10px;
                                        border-radius:20px;
                                        font-size:11px;
                                        font-weight:600;
                                        white-space:nowrap;
                                        background:<?php echo $statusStyle['background']; ?>;
                                        color:<?php echo $statusStyle['color']; ?>;
                                    "
                                >
                                    <?php
                                        echo htmlspecialchars(
                                            $applicantStatus
                                        );
                                    ?>
                                </span>

                            </td>

                            <td style="text-align:right;">

                                <a
                                    href="index.php?action=candidate_review&candidate=<?php echo urlencode($applicant['key']); ?>"
                                    class="btn btn-secondary"
                                    style="font-size:12px;padding:7px 12px;"
                                >
                                    Review
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty-state">

                <h3>
                    No Recent Applications
                </h3>

                <p>
                    Applications submitted by job seekers will be displayed here.
                </p>

            </div>

        <?php endif; ?>

    </div>


    <!-- ANALYTICS -->

    <div
        id="analytics"
        class="section-card"
        style="margin-top:30px;"
    >

        <div
            style="display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:20px;"
        >

            <div>

                <h2 style="margin-bottom:5px;">
                    Recruitment Overview
                </h2>

            </div>

            <a
                href="index.php?action=company_analytics"
                class="btn btn-secondary"
            >
                View Analytics
            </a>

        </div>


        <div
            style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;"
        >

            <div>

                <strong>
                    Total Applications
                </strong>

                <p
                    style="font-size:24px;font-weight:700;margin-top:8px;"
                >
                    <?php echo htmlspecialchars($totalApplications); ?>
                </p>

            </div>


            <div>

                <strong>
                    Pending Review
                </strong>

                <p
                    style="font-size:24px;font-weight:700;margin-top:8px;"
                >
                    <?php echo htmlspecialchars($pendingApplications ?? 0); ?>
                </p>

            </div>


            <div>

                <strong>
                    Shortlisted
                </strong>

                <p
                    style="font-size:24px;font-weight:700;margin-top:8px;"
                >
                    <?php echo htmlspecialchars($shortlistedApplications ?? 0); ?>
                </p>

            </div>


            <div>

                <strong>
                    Interviews Scheduled
                </strong>

                <p
                    style="font-size:24px;font-weight:700;margin-top:8px;"
                >
                    <?php echo htmlspecialchars($interviewApplications ?? 0); ?>
                </p>

            </div>

        </div>

    </div>

</main>


<script>

function toggleProfileDropdown() {

    const dropdown =
        document.getElementById('profileDropdown');

    const profile =
        document.getElementById('userProfile');

    dropdown.classList.toggle('show');
    profile.classList.toggle('open');

}


document.addEventListener(
    'click',
    function(event) {

        const profile =
            document.getElementById('userProfile');

        const dropdown =
            document.getElementById('profileDropdown');

        if (!profile.contains(event.target)) {

            dropdown.classList.remove('show');
            profile.classList.remove('open');

        }

    }
);

</script>

</body>
</html>