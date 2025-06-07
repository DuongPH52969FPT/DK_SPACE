-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2025 at 07:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysqlday3`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `app_id` int NOT NULL,
  `candidate_id` int NOT NULL,
  `job_id` int NOT NULL,
  `apply_date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`app_id`, `candidate_id`, `job_id`, `apply_date`, `status`) VALUES
(1, 1, 1, '2025-06-01', 'Pending'),
(2, 2, 2, '2025-06-02', 'Accepted'),
(3, 3, 5, '2025-06-03', 'Pending'),
(4, 4, 3, '2025-06-04', 'Rejected'),
(5, 5, 4, '2025-06-05', 'Pending'),
(6, 1, 5, '2025-06-06', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidate_id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `years_exp` int NOT NULL,
  `expected_salary` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `full_name`, `email`, `phone`, `years_exp`, `expected_salary`) VALUES
(1, 'Nguyễn Văn A', 'a.nguyen@example.com', '0912345678', 5, 1500),
(2, 'Trần Thị B', 'b.tran@example.com', '0923456789', 3, 1000),
(3, 'Lê Văn C', 'c.le@example.com', '0934567890', 7, 2000),
(4, 'Phạm Thị D', 'd.pham@example.com', '0945678901', 1, 800),
(5, 'Hoàng Văn E', 'e.hoang@example.com', '0956789012', 4, 1200);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `min_salary` int NOT NULL,
  `max_salary` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `title`, `department`, `min_salary`, `max_salary`) VALUES
(1, 'Backend Developer', 'IT', 1000, 1800),
(2, 'Frontend Developer', 'IT', 900, 1600),
(3, 'HR Executive', 'HR', 700, 1300),
(4, 'Marketing Specialist', 'Marketing', 800, 1400),
(5, 'Project Manager', 'Management', 1500, 2500);

-- --------------------------------------------------------

--
-- Table structure for table `shortlistedcandidates`
--

CREATE TABLE `shortlistedcandidates` (
  `candidate_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `selection_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `candidate_id` (`candidate_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`candidate_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
