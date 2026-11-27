<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Results - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
    <style>
        .result-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 2rem;
            margin-top: 1.5rem;
            text-align: center;
        }
        .score-badge {
            display: inline-block;
            background: #0d6efd;
            color: #fff;
            font-size: 2.5rem;
            font-weight: bold;
            padding: 1rem 2rem;
            border-radius: 50px;
            margin: 1rem 0;
        }
        .feedback-text {
            color: #334155;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
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
$activePage = 'assessment';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>
    <div class="container">
        <div class="card">
            <h1>Career Assessment Results</h1>
            <p style="color: #64748b;">Review your test scores and personalized career recommendations.</p>

            <?php if (!empty($result)): ?>
                <div class="result-card">
                    <h2>Overall Assessment Score</h2>
                    <div class="score-badge">
                        <?= htmlspecialchars(isset($result['score']) ? $result['score'] : 'N/A') ?>%
                    </div>
                    
                    <div class="feedback-text">
                        <h3>Feedback & Recommendations</h3>
                        <p><?= htmlspecialchars(isset($result['feedback']) ? $result['feedback'] : 'Your results suggest strong potential in technical and hands-on operational roles.') ?></p>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="index.php?action=career_assessment" class="btn">Retake Assessment</a>
                        <a href="index.php?action=jobseeker_dashboard" class="btn" style="background-color: #64748b;">Back to Dashboard</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>No assessment records found</h3>
                    <p style="margin: 0.5rem 0 1.5rem;">Take the test first to discover your top career paths and skill recommendations.</p>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="index.php?action=career_assessment" class="btn">Take Assessment</a>
                        <a href="index.php?action=jobseeker_dashboard" class="btn" style="background-color: #64748b;">Back to Dashboard</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>