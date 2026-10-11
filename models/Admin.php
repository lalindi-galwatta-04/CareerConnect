<?php
class AdminModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. System Overview Metrics
    public function getSystemMetrics() {
        $metrics = [];

        // Count Users by Role
        $queryUsers = "SELECT user_type, COUNT(*) as count FROM User GROUP BY user_type";
        $stmt = $this->conn->prepare($queryUsers);
        $stmt->execute();
        $userCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $metrics['total_seekers'] = $userCounts['job_seeker'] ?? 0;
        $metrics['total_coaches'] = $userCounts['career_coach'] ?? 0;
        $metrics['total_providers'] = $userCounts['training_provider'] ?? 0;
        $metrics['total_companies'] = $userCounts['company'] ?? 0;

        // Count Job Postings
        $queryJobs = "SELECT COUNT(*) FROM Job_posting";
        $stmtJobs = $this->conn->prepare($queryJobs);
        $stmtJobs->execute();
        $metrics['total_jobs'] = $stmtJobs->fetchColumn();

        // Count Courses
        $queryCourses = "SELECT COUNT(*) FROM Course";
        $stmtCourses = $this->conn->prepare($queryCourses);
        $stmtCourses->execute();
        $metrics['total_courses'] = $stmtCourses->fetchColumn();

        return $metrics;
    }

    // 2. Read All Users
    public function getAllUsers() {
        $query = "SELECT user_id, email, phone_number, user_type, created_at 
                  FROM User 
                  WHERE user_type != 'admin' 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 3. Delete User (Cascades through child profile tables automatically)
    public function deleteUser($user_id) {
        $query = "DELETE FROM User WHERE user_id = :user_id AND user_type != 'admin'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':user_id' => $user_id]);
    }

    // 4. Content Moderation: Read All Jobs
    public function getAllJobs() {
        $query = "SELECT j.*, c.company_name 
                  FROM Job_posting j 
                  JOIN Company c ON j.company_id = c.user_id 
                  ORDER BY j.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 5. Content Moderation: Delete Job
    public function deleteJob($job_id) {
        $query = "DELETE FROM Job_posting WHERE job_id = :job_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':job_id' => $job_id]);
    }

    // 6. Content Moderation: Read All Courses
    public function getAllCourses() {
        $query = "SELECT c.*, tp.provider_name 
                  FROM Course c 
                  JOIN Training_provider tp ON c.provider_id = tp.user_id 
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 7. Content Moderation: Delete Course
    public function deleteCourse($course_id) {
        $query = "DELETE FROM Course WHERE course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':course_id' => $course_id]);
    }

    // 8. Entity Approvals & Verification List
    public function getEntityApprovals() {
        // Companies
        $queryCo = "SELECT 'Company' as entity_type, c.user_id, c.company_name as name, c.industry as detail, c.location, u.email, u.phone_number, u.created_at, 'Verified' as status 
                    FROM Company c 
                    JOIN User u ON c.user_id = u.user_id";
        $stmtCo = $this->conn->prepare($queryCo);
        $stmtCo->execute();
        $companies = $stmtCo->fetchAll();

        // Coaches
        $queryCc = "SELECT 'Career Coach' as entity_type, cc.user_id, cc.coach_name as name, cc.specialization as detail, 'Remote / Online' as location, u.email, u.phone_number, u.created_at, 'Verified' as status 
                    FROM Career_coach cc 
                    JOIN User u ON cc.user_id = u.user_id";
        $stmtCc = $this->conn->prepare($queryCc);
        $stmtCc->execute();
        $coaches = $stmtCc->fetchAll();

        // Training Providers
        $queryTp = "SELECT 'Training Provider' as entity_type, tp.user_id, tp.provider_name as name, tp.website as detail, 'Institute Campus' as location, u.email, u.phone_number, u.created_at, 'Verified' as status 
                    FROM Training_provider tp 
                    JOIN User u ON tp.user_id = u.user_id";
        $stmtTp = $this->conn->prepare($queryTp);
        $stmtTp->execute();
        $providers = $stmtTp->fetchAll();

        $allEntities = array_merge($companies, $coaches, $providers);
        usort($allEntities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return $allEntities;
    }

    // 9. Read All Training Providers with Course Counts & Details
    public function getAllTrainingProviders() {
        try {
            $query = "SELECT tp.user_id, tp.provider_name, tp.contact_email, tp.website, tp.description,
                             u.email, u.phone_number, u.created_at as registered_date,
                             (SELECT COUNT(*) FROM Course c WHERE c.provider_id = tp.user_id) as total_courses
                      FROM Training_provider tp
                      JOIN User u ON tp.user_id = u.user_id
                      ORDER BY u.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [];
        } catch (Exception $e) {
            return [];
        }
    }

    // 10. Read All Job Seekers with Application Counts
    public function getAllJobSeekers() {
        try {
            $query = "SELECT js.user_id, js.first_name, js.last_name, js.skills, js.bio,
                             u.email, u.phone_number, u.created_at as registered_date,
                             (SELECT COUNT(*) FROM Job_application ja WHERE ja.jobseeker_id = js.user_id) as total_applications
                      FROM Job_seeker js
                      JOIN User u ON js.user_id = u.user_id
                      ORDER BY u.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [];
        } catch (Exception $e) {
            return [];
        }
    }

    // 11. Read All Career Coaches with Session/Booking Counts
    public function getAllCareerCoaches() {
        try {
            $query = "SELECT cc.user_id, cc.coach_name, cc.specialization, cc.hourly_rate, cc.bio,
                             u.email, u.phone_number, u.created_at as registered_date,
                             (SELECT COUNT(*) FROM Coach_session cs WHERE cs.coach_id = cc.user_id) as total_sessions
                      FROM Career_coach cc
                      JOIN User u ON cc.user_id = u.user_id
                      ORDER BY u.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [];
        } catch (Exception $e) {
            return [];
        }
    }

    // 12. Read All Companies with Active Job Post Counts
    public function getAllCompanies() {
        try {
            $query = "SELECT c.user_id, c.company_name, c.industry, c.location, c.website, c.description,
                             u.email, u.phone_number, u.created_at as registered_date,
                             (SELECT COUNT(*) FROM Job_posting jp WHERE jp.company_id = c.user_id) as total_jobs
                      FROM Company c
                      JOIN User u ON c.user_id = u.user_id
                      ORDER BY u.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return !empty($results) ? $results : [];
        } catch (Exception $e) {
            return [];
        }
    }
}