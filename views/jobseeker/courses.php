<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
</head>
<body>
<?php
$activePage = 'courses';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>

    <!-- Main Content Container -->
    <div class="container">

        <!-- Welcome Banner -->
        <div class="welcome-card">
            <div>
                <h1>Explore Professional Courses</h1>
                <p>Enhance your skills with certified courses from top training providers.</p>
            </div>
        </div>

        <?php
        // Fallback Dummy Data if database has no course records
        if (empty($courses) && empty($_GET['search']) && empty($_GET['category'])) {
            $courses = array(
                array(
                    'course_id' => 1,
                    'title' => 'Full-Stack Web Development Bootcamp',
                    'category' => 'Technology',
                    'duration' => '12 Weeks',
                    'fee' => 40000.00,
                    'provider_name' => 'Tech Academy Int.',
                    'description' => 'Master HTML, CSS, JavaScript, PHP, and SQL. Build real-world projects and get industry certified.'
                ),
                array(
                    'course_id' => 2,
                    'title' => 'Data Science & Machine Learning Fundamentals',
                    'category' => 'Data & AI',
                    'duration' => '8 Weeks',
                    'fee' => 35000.00,
                    'provider_name' => 'DataCraft Institute',
                    'description' => 'Learn Python, Pandas, Data Visualization, and predictive machine learning models with hands-on labs.'
                ),
                array(
                    'course_id' => 3,
                    'title' => 'Agile Project Management & Scrum Master',
                    'category' => 'Management',
                    'duration' => '4 Weeks',
                    'fee' => 40000.00,
                    'provider_name' => 'Global Agile Institute',
                    'description' => 'Gain deep knowledge in Agile frameworks, sprint planning, and prepare for Scrum Master certification.'
                ),
                array(
                    'course_id' => 4,
                    'title' => 'UI/UX Design Essentials with Figma',
                    'category' => 'Design',
                    'duration' => '6 Weeks',
                    'fee' => 35000.00,
                    'provider_name' => 'Creative Design Hub',
                    'description' => 'Learn wireframing, prototyping, user testing, and visual design principles to craft intuitive apps.'
                )
            );
        }
        ?>

        <!-- Search and Filter Card -->
        <div class="section-card">
            <h2>Search Courses</h2>
            <form action="index.php" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
                <input type="hidden" name="action" value="browse_courses">
                
                <div style="flex: 2; min-width: 220px;">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by course title or keyword..." 
                        value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>"
                        style="width: 100%; padding: 0.65rem 1rem; border-radius: 8px; border: 1px solid var(--card-border, #2a2d3d); background: var(--input-bg, #1e2130); color: #888;"
                    >
                </div>

                <div style="flex: 1; min-width: 160px;">
                    <select 
                        name="category" 
                        style="width: 100%; padding: 0.65rem 1rem; border-radius: 8px; border: 1px solid var(--card-border, #2a2d3d); background: var(--input-bg, #1e2130); color: #888;"
                    >
                        <option value="">All Categories</option>
                        <option value="Technology" <?= (isset($_GET['category']) && $_GET['category'] === 'Technology') ? 'selected' : '' ?>>Technology</option>
                        <option value="Data & AI" <?= (isset($_GET['category']) && $_GET['category'] === 'Data & AI') ? 'selected' : '' ?>>Data & AI</option>
                        <option value="Management" <?= (isset($_GET['category']) && $_GET['category'] === 'Management') ? 'selected' : '' ?>>Management</option>
                        <option value="Design" <?= (isset($_GET['category']) && $_GET['category'] === 'Design') ? 'selected' : '' ?>>Design</option>
                    </select>
                </div>

                <button type="submit" class="btn" style="padding: 0.65rem 1.5rem;">Search</button>
                <a href="index.php?action=browse_courses" class="btn btn-secondary" style="padding: 0.65rem 1rem; text-decoration: none; text-align: center;">Reset</a>
            </form>
        </div>

        <!-- Available Courses Grid -->
        <div class="section-card">
            <h2>Available Courses</h2>

            <?php if (!empty($courses)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1.25rem;">
                    <?php foreach ($courses as $c): ?>
                        <div style="background-color: var(--input-bg, #1e2130); border: 1px solid var(--card-border, #2a2d3d); padding: 1.5rem; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; gap: 0.5rem;">
                                    <h3 style="margin: 0; font-size: 1.15rem; color: #ffffff;"><?= htmlspecialchars($c['title']) ?></h3>
                                    <span style="background-color: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); font-size: 0.75rem; font-weight: bold; padding: 0.25rem 0.55rem; border-radius: 6px; white-space: nowrap;">
                                        <?= htmlspecialchars($c['category']) ?>
                                    </span>
                                </div>

                                <p style="color: #20c997; font-weight: 600; font-size: 0.88rem; margin: 0.3rem 0;">
                                    🏢 <?= htmlspecialchars(isset($c['provider_name']) ? $c['provider_name'] : 'Training Provider') ?>
                                </p>

                                <div style="display: flex; gap: 1rem; color: var(--text-muted, #888); font-size: 0.8rem; margin: 0.5rem 0 0.8rem;">
                                    <span>⏱️ <?= htmlspecialchars($c['duration']) ?></span>
                                    <span>💵 <?= is_numeric($c['fee']) ? 'Rs' . number_format($c['fee'], 2) : htmlspecialchars($c['fee']) ?></span>
                                </div>

                                <p style="color: var(--text-muted, #ccc); font-size: 0.85rem; line-height: 1.4; margin-bottom: 1.25rem;">
                                    <?= htmlspecialchars($c['description']) ?>
                                </p>
                            </div>

                            <a href="index.php?action=enroll_course&id=<?= (int)$c['course_id'] ?>" class="btn" style="display: block; text-align: center; text-decoration: none; padding: 0.6rem 1rem; width: 100%; box-sizing: border-box;">
                                🎓 Enroll Now
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2.5rem 1rem; color: #64748b;">
                    <h3>No courses found matching your criteria.</h3>
                    <p style="margin-top: 0.5rem;">Try adjusting your search keyword or clearing filters.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>