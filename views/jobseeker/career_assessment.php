<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment Test - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=2.0">
    <style>
        .assessment-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .assessment-section h3 {
            font-size: 1rem;
            color: #0d6efd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }
        .question-group {
            margin-bottom: 1.25rem;
        }
        .question-group:last-child {
            margin-bottom: 0;
        }
        .question-label {
            display: block;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .question-select {
            width: 100%;
            padding: 0.65rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #fff;
            font-size: 0.95rem;
            color: #334155;
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
            <h1>Career Assessment Test</h1>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Complete the assessment below to identify your strengths and work preferences.</p>

            <form action="index.php?action=assessment_results" method="POST">
                
                <!-- SECTION 1 -->
                <div class="assessment-section">
                    <h3>SECTION 1: WORK ENVIRONMENT PREFERENCES</h3>
                    
                    <div class="question-group">
                        <label class="question-label" for="q1">1. When you imagine your ideal workplace, which environment appeals to you most?</label>
                        <select name="q1" id="q1" class="question-select" required>
                            <option value="1">A workshop or outdoor setting with tools and equipment</option>
                            <option value="2">A laboratory, research facility, or quiet office for deep thinking </option>
                            <option value="3">A creative studio, art gallery, or flexible workspace</option>
                            <option value="4">A school, hospital, or community center where you interact with people</option>
                            <option value="5">A corporate office, boardroom, or fastpaced business environment </option>
                            <option value="6">A well-organized office with clear procedures and structure </option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q2">2. What type of work tasks do you enjoy most?</label>
                        <select name="q2" id="q2" class="question-select" required>
                            <option value="1">Building, repairing, or working with machinery and tools</option>
                            <option value="2">Researching, analyzing data, or solving complex problems </option>
                            <option value="3">Creating art, writing, designing, or expressing yourself creatively</option>
                            <option value="4">Teaching, counseling, helping, or caring for others</option>
                            <option value="5">Leading teams, selling products, or negotiating deals  </option>
                            <option value="6">Organizing records, managing data, or following established procedures </option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q3">3. How do you prefer to spend your free time?</label>
                        <select name="q3" id="q3" class="question-select" required>
                            <option value="1">Doing outdoor activities, gardening, or DIY projects</option>
                            <option value="2">Reading, learning new skills, or exploring scientific topics</option>
                            <option value="3">Visiting museums, attending concerts, or creative hobbies</option>
                            <option value="4">Volunteering, spending time with friends, or community activities</option>
                            <option value="5">Networking, attending business events, or starting new ventures</option>
                            <option value="6">Planning, organizing events, or maintaining schedules</option>
                        </select>
                    </div>
                </div>

                <!-- SECTION 2 -->
                <div class="assessment-section">
                    <h3>SECTION 2: SKILLS & ABILITIES</h3>

                    <div class="question-group">
                        <label class="question-label" for="q4">4. Which of these skills comes most naturally to you?</label>
                        <select name="q4" id="q4" class="question-select" required>
                            <option value="1">Mechanical skills, using tools, and physical coordination</option>
                            <option value="2">Analytical thinking, research abilities, and logical reasoning </option>
                            <option value="3">Creative expression, imagination, and artistic talent</option>
                            <option value="4">Communication, empathy, and active listening</option>
                            <option value="5">Persuasion, leadership, and strategic thinking</option>
                            <option value="6">Attention to detail, organization, and data management </option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q5">5. What subject did you enjoy most in school?</label>
                        <select name="q5" id="q5" class="question-select" required>
                            <option value="1">Shop class, physical education, or vocational training</option>
                            <option value="2">Science, mathematics, or computer science </option>
                            <option value="3">Art, music, drama, or creative writing</option>
                            <option value="4">Psychology, social studies, or languages</option>
                            <option value="5">Business studies, economics, or marketing</option>
                            <option value="6">Accounting, statistics, or information management</option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q6">6. When faced with a challenge, what is your typical approach?</label>
                        <select name="q6" id="q6" class="question-select" required>
                            <option value="1">Try a hands-on, practical solution using tools or physical action</option>
                            <option value="2">Research the problem deeply and analyze all possible solutions</option>
                            <option value="3">Think creatively and come up with an innovative approach </option>
                            <option value="4">Discuss it with others and seek collaborative input </option>
                            <option value="5">Take charge and lead the way to solve the problem</option>
                            <option value="6">Follow existing procedures and structured methods</option>
                        </select>
                    </div>
                </div>

                <!-- SECTION 3 -->
                <div class="assessment-section">
                    <h3>SECTION 3: PERSONALITY & VALUES</h3>

                    <div class="question-group">
                        <label class="question-label" for="q7">7. Which statement best describes you?</label>
                        <select name="q7" id="q7" class="question-select" required>
                            <option value="1">"I prefer doing things over talking about them"</option>
                            <option value="2">"I love discovering how things work and learning new theories"</option>
                            <option value="3">"I see the world differently and express myself creatively"</option>
                            <option value="4">"I care deeply about others and want to make a difference in their lives" </option>
                            <option value="5">"I have big dreams and the drive to achieve them"</option>
                            <option value="6">"I value order, accuracy, and getting things done correctly"</option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q8">8. What do you value most in a career?</label>
                        <select name="q8" id="q8" class="question-select" required>
                            <option value="1">Working with hands-on projects and seeing tangible results</option>
                            <option value="2">Having intellectual challenges and continuous learning </option>
                            <option value="3">Having creative freedom and selfexpression </option>
                            <option value="4">Making a positive impact on people's lives</option>
                            <option value="5">Achieving success, recognition, and financial rewards</option>
                            <option value="6">Having job security, stability, and clear expectations</option>
                        </select>
                    </div>

                    <div class="question-group">
                        <label class="question-label" for="q9">9. How would your friends describe you?</label>
                        <select name="q9" id="q9" class="question-select" required>
                            <option value="1">Practical, down-to-earth, and action-oriented</option>
                            <option value="2">Curious, intelligent, and always asking "why"</option>
                            <option value="3">Creative, imaginative, and unique </option>
                            <option value="4">Caring, supportive, and a great listener</option>
                            <option value="5">Confident, ambitious, and a natural leader</option>
                            <option value="6">Reliable, organized, and detail-oriented</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; display: flex; gap: 10px;">
                    <button type="submit" class="btn">Submit Assessment</button>
                    <a href="index.php?action=jobseeker_dashboard" class="btn" style="background-color: #64748b;">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>