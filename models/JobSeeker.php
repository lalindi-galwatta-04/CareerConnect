<?php
require_once __DIR__ . '/../config/Database.php';

class JobSeeker {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Get job seeker profile
    public function getProfileByUserId($userId) {
        try {
            $sql = "SELECT u.user_id, u.email, u.phone_number, u.user_type,
                           js.first_name, js.last_name, js.skills,
                           js.education_level, js.years_of_experience
                    FROM user u
                    LEFT JOIN job_seeker js ON u.user_id = js.user_id
                    WHERE u.user_id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($userId));
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$profile || is_null($profile['first_name'])) {
                $insertSql = "INSERT INTO job_seeker
                              (user_id, first_name, last_name, skills, education_level, years_of_experience)
                              VALUES (?, '', '', '', '', 0)
                              ON DUPLICATE KEY UPDATE user_id = user_id";

                $insertStmt = $this->db->prepare($insertSql);
                $insertStmt->execute(array($userId));

                $stmt->execute(array($userId));
                $profile = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $profile;
        } catch (Exception $e) {
            error_log("Profile Fetch Error: " . $e->getMessage());
            return null;
        }
    }

    // Update job seeker profile and work experience
    public function updateProfileWithExperiences(
        $userId,
        $firstName,
        $lastName,
        $phone,
        $education,
        $skills,
        $experiences = array()
    ) {
        try {
            $this->db->beginTransaction();

            $stmt1 = $this->db->prepare(
                "UPDATE user
                 SET phone_number = ?
                 WHERE user_id = ?"
            );

            $stmt1->execute(array(
                $phone,
                $userId
            ));

            $checkStmt = $this->db->prepare(
                "SELECT user_id
                 FROM job_seeker
                 WHERE user_id = ?"
            );

            $checkStmt->execute(array($userId));
            $existingJobSeeker = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingJobSeeker) {
                $stmt2 = $this->db->prepare(
                    "UPDATE job_seeker
                     SET first_name = ?,
                         last_name = ?,
                         education_level = ?,
                         skills = ?
                     WHERE user_id = ?"
                );

                $stmt2->execute(array(
                    $firstName,
                    $lastName,
                    $education,
                    $skills,
                    $userId
                ));
            } else {
                $stmt2 = $this->db->prepare(
                    "INSERT INTO job_seeker
                     (user_id, first_name, last_name, education_level, skills, years_of_experience)
                     VALUES (?, ?, ?, ?, ?, 0)"
                );

                $stmt2->execute(array(
                    $userId,
                    $firstName,
                    $lastName,
                    $education,
                    $skills
                ));
            }

            $stmtDelete = $this->db->prepare(
                "DELETE FROM work_experience
                 WHERE job_seeker_id = ?"
            );

            $stmtDelete->execute(array($userId));

            if (!empty($experiences) && is_array($experiences)) {
                $stmtInsert = $this->db->prepare(
                    "INSERT INTO work_experience
                     (job_seeker_id, company_name, job_title, start_date, end_date, is_current)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );

                foreach ($experiences as $exp) {
                    $companyName = trim($exp['company_name'] ?? '');
                    $jobTitle = trim($exp['job_title'] ?? '');
                    $startDate = $exp['start_date'] ?? '';
                    $isCurrent = !empty($exp['is_current']) ? 1 : 0;

                    if ($companyName === '' || $jobTitle === '' || $startDate === '') {
                        continue;
                    }

                    $endDate = $isCurrent
                        ? null
                        : (!empty($exp['end_date']) ? $exp['end_date'] : null);

                    $stmtInsert->execute(array(
                        $userId,
                        $companyName,
                        $jobTitle,
                        $startDate,
                        $endDate,
                        $isCurrent
                    ));
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            error_log("Profile Update Error: " . $e->getMessage());
            return false;
        }
    }

    // Get work experience
    public function getWorkExperiences($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT experience_id, job_seeker_id, company_name, job_title,
                        start_date, end_date, is_current
                 FROM work_experience
                 WHERE job_seeker_id = ?
                 ORDER BY start_date DESC, experience_id DESC"
            );

            $stmt->execute(array($userId));

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Work Experience Fetch Error: " . $e->getMessage());
            return array();
        }
    }

    // Search jobs
    public function searchJobs($keyword = '') {
        $keyword = trim($keyword);

        try {
            if (empty($keyword)) {
                $sql = "SELECT j.*,
                               COALESCE(c.company_name, 'Hiring Company') AS company_name
                        FROM job_posting j
                        LEFT JOIN company c ON j.company_id = c.user_id
                        ORDER BY j.job_id DESC";

                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            } else {
                $sql = "SELECT j.*,
                               COALESCE(c.company_name, 'Hiring Company') AS company_name
                        FROM job_posting j
                        LEFT JOIN company c ON j.company_id = c.user_id
                        WHERE j.title LIKE ?
                           OR j.description LIKE ?
                           OR j.location LIKE ?
                           OR j.job_type LIKE ?
                        ORDER BY j.job_id DESC";

                $stmt = $this->db->prepare($sql);
                $term = "%" . $keyword . "%";

                $stmt->execute(array(
                    $term,
                    $term,
                    $term,
                    $term
                ));
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return array();
        }
    }

    // Get one job
    public function getJobById($jobId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT j.*,
                        COALESCE(c.company_name, 'Hiring Company') AS company_name
                 FROM job_posting j
                 LEFT JOIN company c ON j.company_id = c.user_id
                 WHERE j.job_id = ?"
            );

            $stmt->execute(array($jobId));

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    // Apply for a job
    public function applyForJob($jobId, $jobseekerId, $coverLetter = '') {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO job_application
                 (job_id, job_seeker_id, status)
                 VALUES (?, ?, 'pending')"
            );

            return $stmt->execute(array(
                $jobId,
                $jobseekerId
            ));
        } catch (Exception $e) {
            return false;
        }
    }

    // Get job applications
    public function getApplications($jobseekerId) {
        if (!$jobseekerId) {
            return array();
        }

        try {
            $sql = "SELECT a.*,
                           a.applied_at AS applied_date,
                           j.title,
                           COALESCE(c.company_name, 'Hiring Company') AS company_name
                    FROM job_application a
                    JOIN job_posting j ON a.job_id = j.job_id
                    LEFT JOIN company c ON j.company_id = c.user_id
                    WHERE a.job_seeker_id = ?
                    ORDER BY a.application_id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($jobseekerId));

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return array();
        }
    }

    // Delete job application
    public function deleteApplication($applicationId, $jobseekerId) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM job_application
                 WHERE application_id = ?
                 AND job_seeker_id = ?"
            );

            return $stmt->execute(array(
                $applicationId,
                $jobseekerId
            ));
        } catch (Exception $e) {
            return false;
        }
    }

    // Get latest career assessment
    public function getLatestAssessment($jobseekerId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT *
                 FROM assessment_result
                 WHERE jobseeker_id = ?
                 ORDER BY assessment_id DESC
                 LIMIT 1"
            );

            $stmt->execute(array($jobseekerId));

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }
}