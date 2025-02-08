-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2025 at 08:06 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1220535_db_schema_1220535`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `project_id` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `budget` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `project_leader` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_id`, `title`, `description`, `customer_name`, `budget`, `start_date`, `end_date`, `created_at`, `updated_at`, `project_leader`) VALUES
(1, 'ABCD-12345', 'TAP', 'Creating a Software', 'Tahseen', 5000.00, '2025-01-23', '2025-02-21', '2025-01-02 20:01:42', '2025-01-07 00:23:35', 1000000015),
(2, 'PROJ-00001', 'Website Redesign', 'Redesign the customer-facing website with a modern UI/UX.', 'Acme Corp', 25000.00, '2025-01-10', '2025-03-10', '2025-01-06 22:38:06', '2025-01-07 00:25:38', 1000000007),
(3, 'PROJ-00002', 'Mobile App Development', 'Develop a cross-platform mobile app for e-commerce.', 'Tech Solutions', 50000.00, '2025-02-01', '2025-07-01', '2025-01-06 22:38:06', '2025-01-07 00:28:22', 1000000002),
(4, 'PROJ-00003', 'CRM Implementation', 'Implement a CRM solution for better customer relationship management.', 'Green Ventures', 40000.00, '2025-01-15', '2025-06-15', '2025-01-06 22:38:06', '2025-01-06 22:38:06', NULL),
(5, 'PROJ-00004', 'Data Migration', 'Migrate legacy data to the new cloud database system.', 'Blue Sky IT', 30000.00, '2025-02-20', '2025-05-20', '2025-01-06 22:38:06', '2025-01-06 22:38:06', NULL),
(6, 'PROJ-00005', 'Cybersecurity Audit', 'Conduct a comprehensive cybersecurity audit and provide recommendations.', 'SecureTech', 20000.00, '2025-03-01', '2025-03-31', '2025-01-06 22:38:06', '2025-01-06 22:38:06', NULL),
(7, 'PROJ-00006', 'E-Learning Platform', 'Develop an interactive e-learning platform for high schools.', 'Future Education', 60000.00, '2025-02-01', '2025-08-01', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(8, 'PROJ-00007', 'AI Chatbot Implementation', 'Create an AI-powered chatbot for customer service automation.', 'Tech Innovators', 45000.00, '2025-03-01', '2025-06-30', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(9, 'PROJ-00008', 'ERP System Deployment', 'Deploy an ERP system to streamline operations for a manufacturing company.', 'Global Manufacturing', 75000.00, '2025-01-20', '2025-07-20', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(10, 'PROJ-00009', 'Website SEO Optimization', 'Enhance SEO performance for a corporate website.', 'Web Solutions', 20000.00, '2025-04-01', '2025-05-15', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(11, 'PROJ-00010', 'Cloud Infrastructure Setup', 'Migrate on-premise systems to cloud infrastructure.', 'Cloud Experts', 90000.00, '2025-01-10', '2025-06-10', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(12, 'PROJ-00011', 'Healthcare App Development', 'Build a mobile application for managing patient appointments and records.', 'HealthTech', 55000.00, '2025-02-15', '2025-07-15', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(13, 'PROJ-00012', 'E-Commerce Website', 'Design and develop a robust e-commerce website.', 'Retail Hub', 80000.00, '2025-03-05', '2025-09-05', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(14, 'PROJ-00013', 'Social Media Analytics Tool', 'Create a tool to analyze and visualize social media data.', 'Data Analytics Corp', 50000.00, '2025-02-01', '2025-07-01', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(15, 'PROJ-00014', 'Digital Marketing Campaign', 'Run a digital marketing campaign to boost online sales.', 'Brand Boosters', 30000.00, '2025-04-15', '2025-07-15', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(16, 'PROJ-00015', 'Mobile Game Development', 'Develop a mobile game targeted at young adults.', 'Fun Games Studio', 40000.00, '2025-03-10', '2025-08-10', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(17, 'PROJ-00016', 'Blockchain Solution', 'Implement a blockchain-based solution for supply chain management.', 'Blockchain Innovators', 120000.00, '2025-01-25', '2025-07-25', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(18, 'PROJ-00017', 'Virtual Reality Training Program', 'Develop a VR training program for employees.', 'Future Work', 100000.00, '2025-02-10', '2025-08-10', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(19, 'PROJ-00018', 'Mobile Banking App', 'Develop a secure and user-friendly mobile banking application.', 'BankTech Solutions', 85000.00, '2025-03-20', '2025-09-20', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(20, 'PROJ-00019', 'Smart Home Integration', 'Create an application for controlling smart home devices.', 'SmartLife Co', 60000.00, '2025-02-05', '2025-07-05', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(21, 'PROJ-00020', 'Online Survey Platform', 'Build an online platform for creating and analyzing surveys.', 'SurveyMasters', 35000.00, '2025-03-15', '2025-06-30', '2025-01-06 23:05:38', '2025-01-06 23:05:38', NULL),
(34, 'ABCD-12346', 'World Map', 'Shortest Path', 'Ahmad', 500.00, '2025-01-29', '2025-02-08', '2025-01-15 15:40:06', '2025-01-15 15:47:17', 1000000002);

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` int NOT NULL,
  `project_id` varchar(20) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_files`
--

INSERT INTO `project_files` (`id`, `project_id`, `file_name`, `file_path`, `title`, `uploaded_at`) VALUES
(4, 'ABCD-12346', 'ABCD-12346-AddTask.drawio.png', 'uploads/ABCD-12346-AddTask.drawio.png', 'Project Picture', '2025-01-15 15:40:06'),
(5, 'ABCD-12346', 'ABCD-12346-Payement use case description.docx', 'uploads/ABCD-12346-Payement use case description.docx', 'Project Description ', '2025-01-15 15:40:06'),
(6, 'ABCD-12346', 'ABCD-12346-Phase 3.pdf', 'uploads/ABCD-12346-Phase 3.pdf', 'Extra', '2025-01-15 15:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `task_id` varchar(20) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `project_id` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `effort` decimal(5,2) NOT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `priority` enum('Low','Medium','High') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `number_of_members` int DEFAULT '0',
  `contribution` int DEFAULT '0',
  `progress` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_id`, `task_name`, `description`, `project_id`, `start_date`, `end_date`, `effort`, `status`, `priority`, `created_at`, `updated_at`, `number_of_members`, `contribution`, `progress`) VALUES
(1, '12', 'Create UI', 'Create User Interface for the project', 'PROJ-00002', '2025-01-15', '2025-01-23', 12.00, 'In Progress', 'Low', '2025-01-09 23:28:24', '2025-01-13 21:09:23', 0, 0, 35),
(7, '13', 'Create Database', 'Create Database tables for the application', 'PROJ-00002', '2025-01-15', '2025-01-30', 2.00, 'Pending', 'Medium', '2025-01-10 20:08:09', '2025-01-15 15:52:30', 0, 0, 0),
(8, '14', 'Test', 'Test software', 'PROJ-00002', '2025-01-16', '2025-01-30', 4.00, 'In Progress', 'High', '2025-01-13 21:27:15', '2025-01-14 22:02:09', 1, 50, 2),
(9, '100', 'Create UI', 'Create UI/UX', 'ABCD-12346', '2025-01-17', '2025-01-22', 20.00, 'In Progress', 'Medium', '2025-01-15 15:48:34', '2025-01-15 15:52:58', 1, 40, 5);

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `task_id` varchar(20) NOT NULL,
  `user_id` bigint NOT NULL,
  `role` varchar(255) NOT NULL,
  `contribution_percentage` decimal(5,2) NOT NULL,
  `accepted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_assignments`
--

INSERT INTO `task_assignments` (`task_id`, `user_id`, `role`, `contribution_percentage`, `accepted`) VALUES
('100', 1000000003, 'Analyst', 40.00, 1),
('14', 1000000003, 'Tester', 50.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `birth_date` date NOT NULL,
  `id_number` bigint NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Manager','Project Leader','Team Member') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qualification` enum('High School','Associate Degree','Bachelor''s Degree','Master''s Degree','PhD') NOT NULL,
  `skills` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `address`, `birth_date`, `id_number`, `email`, `role`, `phone`, `qualification`, `skills`, `username`, `password`, `created_at`) VALUES
(1, 7916067958, 'Kareem Masalma', 'Ramallah, Palestine, Sinjle, Ramallah, Palestine', '2004-03-27', 1220535, 'kareemmasalma273@gmail.com', 'Manager', '0599121954', 'Bachelor\'s Degree', 'Backend Developer', 'KareemMS', 'Kareem@123', '2025-01-01 23:36:00'),
(2, 1000000001, 'Ahmad Mohammed', 'Al-Quds Street, Ramallah, Palestine', '1990-05-15', 1234567890, 'ahmad.mohammed@example.com', 'Manager', '0591234567', 'Bachelor\'s Degree', 'Leadership, Project Management', 'ahmad_mohammed', 'Ahmad@123', '2025-01-06 22:46:27'),
(3, 1000000002, 'Mohammad Ali', 'Al-Nasr Street, Nablus, Palestine', '1985-03-20', 2345678901, 'mohammad.ali@example.com', 'Project Leader', '0569876543', 'Master\'s Degree', 'Programming, Data Analysis', 'mohammad_ali', 'Mohammad@123', '2025-01-06 22:46:27'),
(4, 1000000003, 'Noor Youssef', 'Al-Bireh Street, Al-Bireh, Palestine', '1993-07-10', 3456789012, 'noor.youssef@example.com', 'Team Member', '0597654321', 'Bachelor\'s Degree', 'Design, Communication', 'noor_youssef', 'Noor@123', '2025-01-06 22:46:27'),
(5, 1000000004, 'Leila Ibrahim', 'Al-Jamiaa Street, Gaza, Palestine', '1995-11-25', 4567890123, 'leila.ibrahim@example.com', 'Team Member', '0561239876', 'Associate Degree', 'Testing, Documentation', 'leila_ibrahim', 'Leila@123', '2025-01-06 22:46:27'),
(6, 1000000005, 'Khaled Abdullah', 'Al-Karama Street, Hebron, Palestine', '1992-09-05', 5678901234, 'khaled.abdullah@example.com', 'Team Member', '0595432167', 'Bachelor\'s Degree', 'Coding, Troubleshooting', 'khaled_abdullah', 'Khaled@123', '2025-01-06 22:46:27'),
(7, 1000000006, 'Omar Hassan', 'Al-Salam Street, Jericho, Palestine', '1991-06-10', 6789012345, 'omar.hassan@example.com', 'Manager', '0598765432', 'Master\'s Degree', 'Strategic Planning, Team Management', 'omar_hassan', 'Omar@123', '2025-01-06 22:46:27'),
(8, 1000000007, 'Huda Khalil', 'Al-Quds Street, Bethlehem, Palestine', '1990-12-01', 7890123456, 'huda.khalil@example.com', 'Project Leader', '0566547890', 'Bachelor\'s Degree', 'Leadership, Project Coordination', 'huda_khalil', 'Huda@123', '2025-01-06 22:46:27'),
(9, 1000000008, 'Yasmine Saleh', 'Al-Nahda Street, Gaza, Palestine', '1994-08-15', 8901234567, 'yasmine.saleh@example.com', 'Team Member', '0594321098', 'Bachelor\'s Degree', 'Content Writing, Creativity', 'yasmine_saleh', 'Yasmine@123', '2025-01-06 22:46:27'),
(10, 1000000009, 'Ibrahim Fares', 'Al-Jamaa Street, Jenin, Palestine', '1988-03-05', 9012345678, 'ibrahim.fares@example.com', 'Manager', '0563456789', 'PhD', 'Data Analysis, Research', 'ibrahim_fares', 'Ibrahim@123', '2025-01-06 22:46:27'),
(11, 1000000010, 'Fatima Saeed', 'Al-Azhar Street, Tulkarem, Palestine', '1995-04-25', 1234567891, 'fatima.saeed@example.com', 'Team Member', '0596543210', 'Bachelor\'s Degree', 'Design, Communication', 'fatima_saeed', 'Fatima@123', '2025-01-06 22:46:27'),
(12, 1000000011, 'Ali Omar', 'Al-Rasheed Street, Hebron, Palestine', '1993-09-15', 2345678912, 'ali.omar@example.com', 'Project Leader', '0567891234', 'Master\'s Degree', 'Programming, Team Leadership', 'ali_omar', 'Ali@123', '2025-01-06 22:46:27'),
(13, 1000000012, 'Zainab Aref', 'Al-Montazah Street, Nablus, Palestine', '1992-02-20', 3456789123, 'zainab.aref@example.com', 'Team Member', '0593210987', 'Bachelor\'s Degree', 'Documentation, Organization', 'zainab_aref', 'Zainab@123', '2025-01-06 22:46:27'),
(14, 1000000013, 'Hassan Tamer', 'Al-Karama Street, Ramallah, Palestine', '1987-01-30', 4567891234, 'hassan.tamer@example.com', 'Manager', '0569874321', 'Master\'s Degree', 'Leadership, Negotiation', 'hassan_tamer', 'Hassan@123', '2025-01-06 22:46:27'),
(15, 1000000014, 'Salma Nader', 'Al-Zahra Street, Bethlehem, Palestine', '1996-06-18', 5678912345, 'salma.nader@example.com', 'Team Member', '0597894321', 'Associate Degree', 'Testing, Support', 'salma_nader', 'Salma@123', '2025-01-06 22:46:27'),
(16, 1000000015, 'Kareem Adel', 'Al-Quds Street, Jericho, Palestine', '1994-11-11', 6789123456, 'kareem.adel@example.com', 'Project Leader', '0565432198', 'Bachelor\'s Degree', 'Coding, Debugging', 'kareem_adel', 'Kareem@123', '2025-01-06 22:46:27'),
(17, 2198733260, 'Zaid Mousa', 'Ramallah, Palestine, Birzeit, Ramallah, Palestine', '2005-01-03', 123456, 'zaid.mousa@gmail.com', 'Manager', '0598798768', 'Bachelor\'s Degree', 'Programming', 'ZaidMousa', 'Zaid@123', '2025-01-11 17:48:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`),
  ADD KEY `fk_leader` (`project_leader`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_id` (`task_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD PRIMARY KEY (`task_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_leader` FOREIGN KEY (`project_leader`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD CONSTRAINT `task_assignments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `task_assignments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
