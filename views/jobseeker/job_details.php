<!DOCTYPE html>
<html>
<head>
<title>Job Details</title>
<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php
$activePage = 'jobs';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>
    <?php if ($job): ?>
        <h2><?= htmlspecialchars($job['title']) ?></h2>
        <p><strong>Company:</strong> <?= htmlspecialchars(isset($job['company_name']) ? $job['company_name'] : 'N/A') ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars(isset($job['location']) ? $job['location'] : 'N/A') ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars(isset($job['description']) ? $job['description'] : '')) ?></p>
        <hr>
        <h3>Apply for this position</h3>
        <form method="POST" action="index.php?action=apply_job">
            <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
            <label>Cover Letter / Notes:</label><br>
            <textarea name="cover_letter" rows="5" cols="40" required></textarea><br><br>
            <button type="submit">Submit Application</button>
        </form>
    <?php else: ?>
        <p>Job not found.</p>
    <?php endif; ?>
    <br><a href="index.php?action=job_search">Back to Job Search</a>
</body>
</html>