<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find a Career Coach - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .coach-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .coach-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            border-top: 4px solid #0d6efd;
        }
        .coach-card h4 { margin-bottom: 0.5rem; font-size: 1.2rem; }
        .price-tag {
            font-size: 1.1rem;
            font-weight: bold;
            color: #198754;
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>

<?php
$activePage = 'coaches';
require __DIR__ . '/partials/jobseeker_navbar.php';
require __DIR__ . '/partials/jobseeker_header.php';
?>


<div class="container">
    <div class="welcome-card">
        <div>
        <h1>Find & Book a Career Coach</h1>
        <p>Connect with experienced mentors to accelerate your career growth.</p>
        </div>
    </div>

    <?php
        // Fallback Dummy Coach Data if $coaches array is empty
        if (empty($coaches)) {
            $coaches = array(
                array(
                    'user_id' => 101,
                    'full_name' => 'Keerthi Perera',
                    'expertise' => 'Software Engineering & Tech Leadership',
                    'experience' => '12+ Years Experience',
                    'rate' => 'Rs.2000 / hr',
                    'bio' => 'Ex-FAANG Senior Engineering Manager helping devs transition into tech lead roles and pass system design interviews.'
                ),
                array(
                    'user_id' => 102,
                    'full_name' => 'Sarah Fernando',
                    'expertise' => 'Resume Building & Interview Prep',
                    'experience' => '8 Years Experience',
                    'rate' => 'Rs.1500 / hr',
                    'bio' => 'HR Specialist & Talent Acquisition Lead focusing on resume optimization, mock interviews, and salary negotiation.'
                ),
                array(
                    'user_id' => 103,
                    'full_name' => 'Nadeesha Jayasinghe',
                    'expertise' => 'Product Management & Agile Coaching',
                    'experience' => '10 Years Experience',
                    'rate' => 'Rs.1800 / hr',
                    'bio' => 'Product Strategy Advisor helping professionals pivot into Product Management and master portfolio building.'
                ),
                array(
                    'user_id' => 104,
                    'full_name' => 'Ajith Karunarathna',
                    'expertise' => 'Data Science & AI Career Paths',
                    'experience' => '7 Years Experience',
                    'rate' => 'Rs.2500 / hr',
                    'bio' => 'Lead Data Scientist helping aspiring data analysts and AI engineers transition from academic backgrounds to industry roles.'
                )
            );
        }

        //Fallback Dummy Booked Sessions if $myBookings array is empty
        if (empty($myBookings)) {
            $myBookings = array(
                array(
                    'interaction_id' => 1,
                    'coach_name' => 'Keerthi Perera',
                    'specialization' => 'Software Engineering & Tech Leadership',
                    'session_date' => '2026-10-05 10:00 AM',
                    'status' => 'confirmed',
                    'rating' => null
                ),
                array(
                    'interaction_id' => 2,
                    'coach_name' => 'Sarah Fernando',
                    'specialization' => 'Resume Building & Interview Prep',
                    'session_date' => '2026-09-20 02:30 PM',
                    'status' => 'completed',
                    'rating' => 5
                )
            );
        }
        ?>

    <!-- Section Card 1: Available Coaches -->
        <div class="section-card">
            <h2>Available Coaches</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1.25rem;">
                <?php foreach ($coaches as $coach): ?>
                    <div style="background-color: var(--input-bg, #1e2130); border: 1px solid var(--card-border, #2a2d3d); padding: 1.5rem; border-radius: 12px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <h3 style="margin: 0; font-size: 1.15rem; color: #888;"><?= htmlspecialchars($coach['full_name']) ?></h3>
                                <?php if (!empty($coach['rate'])): ?>
                                    <span style="background-color: rgba(25, 135, 84, 0.2); color: #20c997; border: 1px solid rgba(32, 201, 151, 0.3); font-size: 0.78rem; font-weight: bold; padding: 0.25rem 0.55rem; border-radius: 6px;"><?= htmlspecialchars($coach['rate']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <p style="color: #a855f7; font-weight: 600; font-size: 0.88rem; margin: 0.2rem 0;"><?= htmlspecialchars(!empty($coach['specialization']) ? $coach['specialization'] : 'Career Guidance') ?></p>
                            
                            <?php if (!empty($coach['experience'])): ?>
                                <p style="color: var(--text-muted, #888); font-size: 0.8rem; margin-bottom: 0.75rem;">📅 <?= htmlspecialchars($coach['experience']) ?></p>
                            <?php endif; ?>

                            <?php if (!empty($coach['bio'])): ?>
                                <p style="color: var(--text-muted, #ccc); font-size: 0.85rem; line-height: 1.4; margin-bottom: 1.25rem;"><?= htmlspecialchars($coach['bio']) ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Book Session Button -->
                        <a href="index.php?action=book_session&coach_id=<?= (int)$coach['user_id'] ?>" class="btn" style="display: block; text-align: center; text-decoration: none; padding: 0.6rem 1rem; width: 100%; box-sizing: border-box;">
                            📅 Book Session
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>



        <!-- Job Seeker's Booked Sessions & Rating Form (UC-10) -->
        <div class="section-card">
            <h3>My Booked Coaching Sessions</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Coach</th>
                        <th>Specialization</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Rate & Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($myBookings)): ?>
                        <?php foreach ($myBookings as $b): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($b['coach_name']); ?></td>
                                <td><?php echo htmlspecialchars($b['specialization']); ?></td>
                                <td><?php echo htmlspecialchars($b['session_date']); ?></td>
                                <td><strong><?php echo ucfirst($b['status']); ?></strong></td>
                                <td>
                                    <?php if ($b['status'] === 'completed'): ?>
                                        <?php if ($b['rating']): ?>
                                            <span style="color: #ffc107;">
                                                <?php echo str_repeat('★', $b['rating']) . str_repeat('☆', 5 - $b['rating']); ?>
                                            </span>
                                        <?php else: ?>
                                            <form action="index.php?action=submit_feedback" method="POST" style="display: flex; gap: 5px;">
                                                <input type="hidden" name="interaction_id" value="<?php echo $b['interaction_id']; ?>">
                                                <select name="rating" required style="width: 70px;">
                                                    <option value="5">5 ★</option>
                                                    <option value="4">4 ★</option>
                                                    <option value="3">3 ★</option>
                                                    <option value="2">2 ★</option>
                                                    <option value="1">1 ★</option>
                                                </select>
                                                <input type="text" name="notes" placeholder="Write feedback..." required style="padding: 2px 5px;">
                                                <button type="submit" class="btn" style="padding: 2px 8px; font-size: 12px;">Submit</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span style="color: #999;">Available after session completion</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align: center; color: #777;">You have no active or past session bookings.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>