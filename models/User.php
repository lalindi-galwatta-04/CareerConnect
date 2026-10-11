<?php
class User {
    private $conn;
    private $table_name = "User";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Authenticate user credentials
    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password_hash'])) {
                return $row;
            }
        }
        return false;
    }

    // Register a new user
    	// Register a new user
	public function register($email, $password, $phone_number, $user_type) {
		$allowedRoles = [
			'job_seeker',
			'career_coach',
			'company',
			'training_provider'
		];

		if (!in_array($user_type, $allowedRoles, true)) {
			return false;
		}

		$approval_status = $user_type === 'job_seeker' ? 'approved' : 'pending';
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$query = "INSERT INTO `User`
				  (email, password_hash, phone_number, user_type, approval_status)
				  VALUES
				  (:email, :password_hash, :phone_number, :user_type, :approval_status)";

		$stmt = $this->conn->prepare($query);

		if ($stmt->execute([
			':email' => $email,
			':password_hash' => $password_hash,
			':phone_number' => $phone_number,
			':user_type' => $user_type,
			':approval_status' => $approval_status
		])) {
			return $this->conn->lastInsertId();
		}

		return false;
	}
}