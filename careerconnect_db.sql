-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2026 at 09:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `careerconnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `access_level` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `department`, `access_level`) VALUES
(5, 'IT & Systems Operations', 3),
(11, 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `career_coach`
--

CREATE TABLE `career_coach` (
  `user_id` int(11) NOT NULL,
  `coach_name` varchar(100) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `specialization` varchar(150) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT 0.00,
  `bio` text DEFAULT NULL,
  `verification_document` varchar(255) DEFAULT NULL,
  `display_title` varchar(255) DEFAULT NULL,
  `workplace` varchar(255) DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `coaching_mode` varchar(100) DEFAULT 'Online / Remote',
  `linkedin_url` varchar(255) DEFAULT NULL,
  `qualifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qualifications`)),
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`)),
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_coach`
--

INSERT INTO `career_coach` (`user_id`, `coach_name`, `full_name`, `specialization`, `hourly_rate`, `bio`, `verification_document`, `display_title`, `workplace`, `experience_years`, `coaching_mode`, `linkedin_url`, `qualifications`, `certifications`, `skills`) VALUES
(1, 'Dr. Sarah Jenkins', NULL, 'Software Engineering & IT Careers', 45.00, 'Senior Career Consultant with 8+ years experience guiding tech graduates into high-paying software engineering roles.', NULL, NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL),
(2, 'John Perera', NULL, 'Business Analysis & Agile Management', 35.00, 'Certified Scrum Master and Business Analyst helping students pivot into product and project management roles.', NULL, NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL),
(8, 'Anujana Madawala ', NULL, 'General Guidance', 50.00, 'Hello', NULL, NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL),
(12, 'lily & co.', NULL, 'QA Career Paths', 5.00, 'Welcome to the world of QA', NULL, NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL),
(14, 'Lalindi Mihirika', 'Lalindi Mihirika', 'General Guidance', 1000.00, 'Hii', NULL, 'QA Engineer', 'Apex Global', 2, 'Online / Remote', '', '[{\"title\":\"BSc (Hons)\",\"institute\":\"UoC\"}]', '[{\"title\":\"ISTQ\",\"issuing_body\":\"ISTQB\"}]', '[{\"name\":\"Interview prep\",\"experience\":4}]'),
(18, 'Coach Test', NULL, 'IT Career Guidance', 0.00, NULL, 'public/uploads/verification/coach_6ab958caca7b1.jpg', NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL),
(20, 'cscs', NULL, 'cs', 0.00, NULL, 'public/uploads/verification/coach_6ab973132d62b.jpg', NULL, NULL, 0, 'Online / Remote', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coach_availability`
--

CREATE TABLE `coach_availability` (
  `slot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slot_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coach_availability`
--

INSERT INTO `coach_availability` (`slot_id`, `user_id`, `slot_date`, `start_time`, `end_time`, `is_booked`, `created_at`) VALUES
(3, 14, '2026-09-30', '14:00:00', '15:00:00', 0, '2026-09-26 16:49:28'),
(4, 14, '2026-10-01', '19:00:00', '20:00:00', 0, '2026-09-26 16:49:28'),
(5, 14, '2026-10-02', '21:30:00', '22:00:00', 0, '2026-09-26 16:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `coach_interaction`
--

CREATE TABLE `coach_interaction` (
  `interaction_id` int(11) NOT NULL,
  `job_seeker_id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `session_date` datetime NOT NULL,
  `duration_minutes` int(11) DEFAULT 60,
  `notes` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `status` enum('scheduled','completed','cancelled') DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coach_interaction`
--

INSERT INTO `coach_interaction` (`interaction_id`, `job_seeker_id`, `coach_id`, `session_date`, `duration_minutes`, `notes`, `rating`, `status`) VALUES
(2, 4, 1, '2026-09-15 14:00:00', 45, 'Great session on technical portfolio building and GitHub repository optimization.', 4, 'completed'),
(4, 4, 1, '2026-09-20 16:00:00', 30, 'Cancelled by client due to academic timetable conflict.', NULL, 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `registration_document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`user_id`, `company_name`, `industry`, `website`, `location`, `description`, `registration_number`, `registration_document`) VALUES
(10, 'Future Tech Pvt Ltd', 'IT & Services', '', 'Nugegoda', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `provider_id`, `title`, `category`, `duration`, `fee`, `description`, `created_at`) VALUES
(2, 9, 'Python for Beginners ', 'Programming', '8 weeks', 15.00, 'Printed tutes are provided', '2026-09-22 06:29:55'),
(3, 9, 'Software Architectures', 'Software Development Fundamentals', '4 weeks', 10.00, 'Essential Software Development Basics', '2026-09-22 07:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollment`
--

CREATE TABLE `course_enrollment` (
  `enrollment_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `job_seeker_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed','cancelled') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_application`
--

CREATE TABLE `job_application` (
  `application_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_seeker_id` int(11) NOT NULL,
  `status` enum('pending','reviewed','shortlisted','rejected') DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `job_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `opening_date` date NOT NULL,
  `closing_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `flyer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`job_id`, `company_id`, `title`, `job_type`, `location`, `salary_range`, `description`, `requirements`, `opening_date`, `closing_date`, `created_at`, `status`, `flyer`) VALUES
(2, 10, 'QA Engineer', 'Remote', 'Nugegoda', '30000 - 50000', 'Visit our website to see requirements', 'Visit our website to see requirements', '2026-09-01', '2026-12-05', '2026-09-22 07:27:22', 'posted', NULL),
(3, 10, 'Data Analyst', 'Full-Time', 'Orion City', '60000 - 75000', 'Visit our website', 'Visit our website', '2026-06-01', '2026-12-01', '2026-09-22 07:52:29', 'posted', NULL),
(7, 10, 'Software Engineer', 'Full-Time', 'Jaffna', '', 'Develop software', 'BSc in SE', '2026-09-04', '2027-01-04', '2026-09-25 06:48:46', 'posted', NULL),
(9, 10, 'Electronics Engineer', 'Part-Time', 'Galle', '', 'Create electronics components', 'BSc in Electronics', '2026-09-30', '2026-10-30', '2026-09-25 13:27:10', 'posted', NULL),
(11, 10, 'Project Manager Intern', 'Full-Time', 'Colombo', '', 'Manage projects', 'PMP', '2026-09-26', '2026-12-26', '2026-09-25 20:24:13', 'posted', NULL),
(13, 10, 'Senior Developer', 'Full-Time', 'Colombo', '', 'Develop Software', 'BSc Hons in Computer Science', '2026-09-18', '2026-11-26', '2026-09-26 10:00:58', 'posted', NULL),
(14, 10, 'Web Master', 'Internship', 'Mathara', '', 'Designing and maintaining the company website', 'BSc in Web Technology', '2026-09-01', '2026-09-25', '2026-09-26 11:15:59', 'draft', NULL),
(15, 10, 'System Analyst', 'Full-Time', 'Galle', '', 'Collect user requirements', 'BSc in Information Systems', '2026-09-26', '2026-12-26', '2026-09-26 13:50:15', 'posted', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_seeker`
--

CREATE TABLE `job_seeker` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `skills` text DEFAULT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_seeker`
--

INSERT INTO `job_seeker` (`user_id`, `first_name`, `last_name`, `skills`, `education_level`, `years_of_experience`) VALUES
(4, 'Priya', 'Fernando', 'Java, Python, Data Analytics', 'Undergraduate - Information Systems', 0),
(7, 'Anujana', 'Madawala', NULL, NULL, 0),
(13, 'Oshi', '', '', '', 0),
(19, 'Seeker', 'Test', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `training_provider`
--

CREATE TABLE `training_provider` (
  `user_id` int(11) NOT NULL,
  `provider_name` varchar(150) NOT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `accreditation` varchar(150) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `registration_document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_provider`
--

INSERT INTO `training_provider` (`user_id`, `provider_name`, `contact_email`, `accreditation`, `website`, `description`, `email`, `registration_number`, `registration_document`) VALUES
(9, 'ABC Institute', 'trainer1@careerconnect.com', NULL, 'www.abc_inst.com', 'We are leading software company in SL', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `user_type` enum('job_seeker','company','career_coach','training_provider','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'account_status',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password_hash`, `phone_number`, `user_type`, `created_at`, `approval_status`) VALUES
(1, 'coach.sarah@careerconnect.com', '$2y$10$e.xK7uJd5wK8C.2Yn3hXg.0w5R9aV1L2M3N4O5P6Q7R8S9T0U1V2W', '0771234567', 'career_coach', '2026-09-22 07:45:34', 'approved'),
(2, 'coach.john@careerconnect.com', '$2y$10$e.xK7uJd5wK8C.2Yn3hXg.0w5R9aV1L2M3N4O5P6Q7R8S9T0U1V2W', '0772345678', 'career_coach', '2026-09-22 07:45:34', 'approved'),
(4, 'seeker.priya@gmail.com', '$2y$10$e.xK7uJd5wK8C.2Yn3hXg.0w5R9aV1L2M3N4O5P6Q7R8S9T0U1V2W', '0774567890', 'job_seeker', '2026-09-22 07:45:34', 'approved'),
(5, 'admin@careerconnect.com', '$2y$10$e.xK7uJd5wK8C.2Yn3hXg.0w5R9aV1L2M3N4O5P6Q7R8S9T0U1V2W', '0775678901', 'admin', '2026-09-22 07:45:34', 'approved'),
(6, 'lalindi@careerconnect.com', '$2y$10$pJNugOF./0o8MLYVEooyNODW3/bnS8gTZhSTp1oCBAoKRlxG9CrXG', '0715349249', 'career_coach', '2026-09-22 07:45:34', 'approved'),
(7, 'seeker123@careerconnect.com', '$2y$10$kEONtpSSBGbeMzKbuFFRJ.ykeVhLk9T7LXAlURo7gjhyQRHU1rHva', '0718268880', 'job_seeker', '2026-09-22 07:45:34', 'approved'),
(8, 'coach.anujana@careerconnect.com', '$2y$10$bP9k0YpwPEaQoeB1wjzf6OjYoFpctqTnGbwvuM61PvAa2XB5dLGH.', '0717675310', 'career_coach', '2026-09-22 07:45:34', 'approved'),
(9, 'trainer1@careerconnect.com', '$2y$10$TdBvattPLL28ZTklF/V47ukLrqejmrZBA/xzGTJ6N5Wror7pkvfqO', '0715349244', 'training_provider', '2026-09-22 07:45:34', 'approved'),
(10, 'company1@careerconnect.com', '$2y$10$EsISYdB5dcPeJ/hS7G8k3udV8aqudqJjrK8mRJ0d839IYNqSNeTWC', '0112076644', 'company', '2026-09-22 07:45:34', 'approved'),
(11, 'admin1@careerconnect.com', '$2y$10$DwZGR7tTRUs/0npNm0VDi.6QzrM6pnsnuS32ivNeqjgpptXl9Eg3S', '0718268881', 'admin', '2026-09-22 07:45:34', 'approved'),
(12, 'lily@careerconnect.com', '$2y$10$CChBHOiwjLxAJFBDt7.8MODu0YtQxgf/JN4HiQpgVcJc72xkloEDi', '0715349249', 'career_coach', '2026-09-22 09:14:01', 'approved'),
(13, 'seeker1@careerconnect.com', '$2y$10$vHf40/oZCjWHfr5itUW50.fNx39aIGRzTHoR3FFL7Gew/82NoIr2q', '0717675310', 'job_seeker', '2026-09-22 10:27:05', 'approved'),
(14, 'coach2@careerconnect.com', '$2y$10$sbfBnQVOACnaSYiYEKmaLubI35M8PMXn2orZS.tFPYHaVkMmN7KAK', '0771234567', 'career_coach', '2026-09-26 14:15:47', 'approved'),
(17, 'd@gv.b', '$2y$10$ng5vJqNqlm1rY8G3dFYME.mc8xc58oc8xnobTpYXrEKslengWcOiG', 'f', 'training_provider', '2026-09-27 16:16:05', 'pending'),
(18, 'coach5@careercoach.com', '$2y$10$IJnBps5bnu3a04CbX8RAQO6oDfqU.bbtj9WQn9IflZOc2Nt1vaZgS', '0771234567', 'career_coach', '2026-09-27 17:56:26', 'pending'),
(19, 'seeker5@careercoach.com', '$2y$10$Az/IWJbFkFD2APd3Zgu57OoH1EiVNzO9lndX4lZNGygNAowAWSpji', '0112345678', 'job_seeker', '2026-09-27 17:57:56', 'approved'),
(20, 'fs@fd.dv', '$2y$10$GS2BGxuR7AS811jiN9wfZumRjszivgLx82ooV0djpL55L.G5Sli3O', 'csc', 'career_coach', '2026-09-27 19:48:34', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `experience_id` int(11) NOT NULL,
  `job_seeker_id` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `job_title` varchar(150) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `career_coach`
--
ALTER TABLE `career_coach`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `coach_availability`
--
ALTER TABLE `coach_availability`
  ADD PRIMARY KEY (`slot_id`),
  ADD UNIQUE KEY `unique_coach_slot` (`user_id`,`slot_date`,`start_time`,`end_time`);

--
-- Indexes for table `coach_interaction`
--
ALTER TABLE `coach_interaction`
  ADD PRIMARY KEY (`interaction_id`),
  ADD KEY `job_seeker_id` (`job_seeker_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `job_seeker_id` (`job_seeker_id`);

--
-- Indexes for table `job_application`
--
ALTER TABLE `job_application`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `job_seeker_id` (`job_seeker_id`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `job_seeker`
--
ALTER TABLE `job_seeker`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `training_provider`
--
ALTER TABLE `training_provider`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`experience_id`),
  ADD KEY `job_seeker_id` (`job_seeker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coach_availability`
--
ALTER TABLE `coach_availability`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coach_interaction`
--
ALTER TABLE `coach_interaction`
  MODIFY `interaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_application`
--
ALTER TABLE `job_application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `career_coach`
--
ALTER TABLE `career_coach`
  ADD CONSTRAINT `career_coach_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `coach_availability`
--
ALTER TABLE `coach_availability`
  ADD CONSTRAINT `coach_availability_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `coach_interaction`
--
ALTER TABLE `coach_interaction`
  ADD CONSTRAINT `coach_interaction_ibfk_1` FOREIGN KEY (`job_seeker_id`) REFERENCES `job_seeker` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coach_interaction_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `career_coach` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `training_provider` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  ADD CONSTRAINT `course_enrollment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_enrollment_ibfk_2` FOREIGN KEY (`job_seeker_id`) REFERENCES `job_seeker` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_application`
--
ALTER TABLE `job_application`
  ADD CONSTRAINT `job_application_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_posting` (`job_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_application_ibfk_2` FOREIGN KEY (`job_seeker_id`) REFERENCES `job_seeker` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD CONSTRAINT `job_posting_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_seeker`
--
ALTER TABLE `job_seeker`
  ADD CONSTRAINT `job_seeker_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `training_provider`
--
ALTER TABLE `training_provider`
  ADD CONSTRAINT `training_provider_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD CONSTRAINT `fk_work_exp_job_seeker` FOREIGN KEY (`job_seeker_id`) REFERENCES `job_seeker` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
