-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 02:21 PM
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
-- Database: `mysqlday8`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follower_id` int DEFAULT NULL,
  `followee_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`follower_id`, `followee_id`) VALUES
(101, 102),
(101, 103),
(102, 104),
(103, 105),
(104, 101);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `likes` int DEFAULT NULL,
  `hashtags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `created_at`, `likes`, `hashtags`) VALUES
(1, 101, 'Bài viết về thể hình', '2025-06-14 14:07:14', 120, 'fitness,workout'),
(2, 102, 'Ăn uống lành mạnh', '2025-06-14 14:07:14', 75, 'health,fitness'),
(3, 103, 'Chạy bộ buổi sáng', '2025-06-14 14:07:14', 50, 'running,fitness,morning'),
(4, 104, 'Tập yoga tại nhà', '2025-06-14 14:07:14', 90, 'yoga,home,fitness'),
(5, 105, 'Mẹo giảm cân nhanh', '2025-06-14 14:07:14', 200, 'diet,weightloss,fitness');

-- --------------------------------------------------------

--
-- Table structure for table `postviews`
--

CREATE TABLE `postviews` (
  `view_id` bigint NOT NULL,
  `post_id` int DEFAULT NULL,
  `viewer_id` int DEFAULT NULL,
  `view_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `postviews`
--

INSERT INTO `postviews` (`view_id`, `post_id`, `viewer_id`, `view_time`) VALUES
(1, 1, 102, '2025-06-14 08:00:00'),
(2, 1, 103, '2025-06-14 09:30:00'),
(3, 2, 104, '2025-06-14 10:00:00'),
(4, 2, 105, '2025-06-14 10:15:00'),
(5, 3, 101, '2025-06-13 18:00:00'),
(6, 3, 102, '2025-06-13 18:05:00'),
(7, 4, 103, '2025-06-13 18:10:00'),
(8, 5, 104, '2025-06-12 12:00:00'),
(9, 5, 105, '2025-06-12 13:00:00'),
(10, 5, 101, '2025-06-12 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `created_at`) VALUES
(101, 'alice', '2025-06-14 21:07:00'),
(102, 'bob', '2025-06-14 21:07:00'),
(103, 'charlie', '2025-06-14 21:07:00'),
(104, 'david', '2025-06-14 21:07:00'),
(105, 'eva', '2025-06-14 21:07:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `postviews`
--
ALTER TABLE `postviews`
  ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `postviews`
--
ALTER TABLE `postviews`
  MODIFY `view_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
