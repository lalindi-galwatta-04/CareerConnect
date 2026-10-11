<?php
class Coach {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createProfile($user_id, $coach_name = 'New Coach', $specialization = 'General Guidance', $hourly_rate = 0.00, $bio = '') {
        $query = "INSERT INTO Career_coach (user_id, coach_name, full_name, specialization, hourly_rate, bio) 
                  VALUES (:user_id, :coach_name, :full_name, :specialization, :hourly_rate, :bio)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':user_id'       => $user_id,
            ':coach_name'    => $coach_name,
            ':full_name'     => $coach_name,
            ':specialization' => $specialization,
            ':hourly_rate'   => $hourly_rate,
            ':bio'           => $bio
        ]);
    }

    public function getProfile($user_id) {
        $query = "SELECT c.*, u.email, u.phone_number 
                  FROM Career_coach c 
                  JOIN User u ON c.user_id = u.user_id 
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Updated updateProfile supporting both traditional parameters 
     * and the extended $data payload array from the controller.
     */
    public function updateProfile($user_id, $coach_name, $specialization, $hourly_rate, $bio, $data = []) {
        $query = "UPDATE Career_coach 
                  SET coach_name       = :name,
                      full_name        = :full_name,
                      display_title    = :display_title,
                      workplace        = :workplace,
                      experience_years = :experience_years,
                      specialization   = :spec, 
                      hourly_rate      = :rate, 
                      coaching_mode    = :coaching_mode,
                      linkedin_url     = :linkedin_url,
                      bio              = :bio,
                      qualifications   = :qualifications,
                      certifications   = :certifications,
                      skills           = :skills
                  WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name'             => $coach_name,
            ':full_name'        => $data['full_name'] ?? $coach_name,
            ':display_title'    => $data['display_title'] ?? '',
            ':workplace'        => $data['workplace'] ?? '',
            ':experience_years' => $data['experience_years'] ?? 0,
            ':spec'             => $specialization,
            ':rate'             => $hourly_rate,
            ':coaching_mode'    => $data['coaching_mode'] ?? 'Online / Remote',
            ':linkedin_url'     => $data['linkedin_url'] ?? '',
            ':bio'              => $bio,
            ':qualifications'   => $data['qualifications'] ?? '[]',
            ':certifications'   => $data['certifications'] ?? '[]',
            ':skills'           => $data['skills'] ?? '[]',
            ':user_id'          => $user_id
        ]);
    }
    public function getAllCoaches() {
    $query = "SELECT c.*, u.email, u.phone_number
              FROM Career_coach c
              JOIN User u ON c.user_id = u.user_id
              WHERE u.user_type = 'career_coach'
              ORDER BY c.full_name ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}