<?php

class CompanyModel {
	private $conn;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function getProfile($user_id) {
		$query = "SELECT c.*, u.email, u.phone_number
				  FROM Company c
				  JOIN User u ON c.user_id = u.user_id
				  WHERE c.user_id = :user_id";

		$stmt = $this->conn->prepare($query);

		$stmt->execute([
			':user_id' => $user_id
		]);

		return $stmt->fetch();
	}

	public function updateProfile($user_id, $name, $industry, $website, $location, $description) {
		$query = "UPDATE Company
				  SET company_name = :name,
					  industry = :industry,
					  website = :website,
					  location = :location,
					  description = :description
				  WHERE user_id = :user_id";

		$stmt = $this->conn->prepare($query);

		return $stmt->execute([
			':name' => $name,
			':industry' => $industry,
			':website' => $website,
			':location' => $location,
			':description' => $description,
			':user_id' => $user_id
		]);
	}

	public function getJobsByCompany($company_id) {
		$query = "SELECT
					j.*,
					COUNT(ja.application_id) AS total_applications
				  FROM Job_posting j
				  LEFT JOIN Job_application ja
				  ON j.job_id = ja.job_id
				  WHERE j.company_id = :company_id
				  GROUP BY j.job_id
				  ORDER BY j.created_at DESC";

		$stmt = $this->conn->prepare($query);

		$stmt->execute([
			':company_id' => $company_id
		]);

		return $stmt->fetchAll();
	}

	public function getJobById($job_id, $company_id) {
		$query = "SELECT *
				  FROM Job_posting
				  WHERE job_id = :job_id
				  AND company_id = :company_id";

		$stmt = $this->conn->prepare($query);

		$stmt->execute([
			':job_id' => $job_id,
			':company_id' => $company_id
		]);

		return $stmt->fetch();
	}

	public function createJob(
		$company_id,
		$title,
		$job_type,
		$location,
		$salary,
		$description,
		$requirements,
		$opening_date,
		$closing_date,
		$status,
		$flyer
	) {
		$query = "INSERT INTO Job_posting
				  (
					company_id,
					title,
					job_type,
					location,
					salary_range,
					description,
					requirements,
					opening_date,
					closing_date,
					status,
					flyer
				  )
				  VALUES
				  (
					:company_id,
					:title,
					:job_type,
					:location,
					:salary,
					:description,
					:requirements,
					:opening_date,
					:closing_date,
					:status,
					:flyer
				  )";

		$stmt = $this->conn->prepare($query);

		return $stmt->execute([
			':company_id' => $company_id,
			':title' => $title,
			':job_type' => $job_type,
			':location' => $location,
			':salary' => $salary,
			':description' => $description,
			':requirements' => $requirements,
			':opening_date' => $opening_date,
			':closing_date' => $closing_date,
			':status' => $status,
			':flyer' => $flyer
		]);
	}

	public function updateJob(
		$job_id,
		$company_id,
		$title,
		$job_type,
		$location,
		$salary,
		$description,
		$requirements,
		$opening_date,
		$closing_date,
		$flyer
	) {
		$query = "UPDATE Job_posting
				  SET title = :title,
					  job_type = :job_type,
					  location = :location,
					  salary_range = :salary,
					  description = :description,
					  requirements = :requirements,
					  opening_date = :opening_date,
					  closing_date = :closing_date,
					  flyer = :flyer
				  WHERE job_id = :job_id
				  AND company_id = :company_id";

		$stmt = $this->conn->prepare($query);

		return $stmt->execute([
			':title' => $title,
			':job_type' => $job_type,
			':location' => $location,
			':salary' => $salary,
			':description' => $description,
			':requirements' => $requirements,
			':opening_date' => $opening_date,
			':closing_date' => $closing_date,
			':flyer' => $flyer,
			':job_id' => $job_id,
			':company_id' => $company_id
		]);
	}

	public function updateJobStatus($job_id, $company_id, $status) {
		$query = "UPDATE Job_posting
				  SET status = :status
				  WHERE job_id = :job_id
				  AND company_id = :company_id";

		$stmt = $this->conn->prepare($query);

		return $stmt->execute([
			':status' => $status,
			':job_id' => $job_id,
			':company_id' => $company_id
		]);
	}

	public function deleteJob($job_id, $company_id) {
		$query = "DELETE FROM Job_posting
				  WHERE job_id = :job_id
				  AND company_id = :company_id";

		$stmt = $this->conn->prepare($query);

		return $stmt->execute([
			':job_id' => $job_id,
			':company_id' => $company_id
		]);
	}

	public function getCompanyMetrics($company_id) {
		$query = "SELECT
					COUNT(DISTINCT ja.application_id) AS total_applications,

					COUNT(DISTINCT CASE
						WHEN j.status = 'posted'
						AND j.opening_date <= CURDATE()
						AND j.closing_date >= CURDATE()
						THEN j.job_id
					END) AS active_jobs,

					COUNT(DISTINCT CASE
						WHEN j.status = 'posted'
						THEN j.job_id
					END) AS posted_jobs,

					COUNT(DISTINCT CASE
						WHEN j.status = 'draft'
						THEN j.job_id
					END) AS drafted_jobs

				  FROM Job_posting j
				  LEFT JOIN Job_application ja
				  ON j.job_id = ja.job_id
				  WHERE j.company_id = :company_id";

		$stmt = $this->conn->prepare($query);

		$stmt->execute([
			':company_id' => $company_id
		]);

		return $stmt->fetch();
	}
}