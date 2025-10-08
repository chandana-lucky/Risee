-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 08, 2025 at 05:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rise`
--

-- --------------------------------------------------------

--
-- Table structure for table `plant_stage`
--

CREATE TABLE `plant_stage` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plant_name` varchar(100) DEFAULT NULL,
  `stage` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `min_day` int(11) DEFAULT NULL,
  `max_day` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plant_stages`
--

CREATE TABLE `plant_stages` (
  `id` int(11) NOT NULL,
  `min_day` int(11) NOT NULL,
  `max_day` int(11) NOT NULL,
  `stage_name` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plant_stages`
--

INSERT INTO `plant_stages` (`id`, `min_day`, `max_day`, `stage_name`, `image_url`, `user_id`) VALUES
(1, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', NULL),
(2, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', NULL),
(3, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', NULL),
(4, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', NULL),
(5, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', NULL),
(11, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', 2),
(12, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', 1),
(13, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', 3),
(14, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', 5),
(15, 1, 6, 'Seed in Sand', 'crt/stage1_seed.png', 4),
(16, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', 2),
(17, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', 1),
(18, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', 3),
(19, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', 5),
(20, 7, 12, 'Sprouting Leaf', 'crt/stage2_sprout.png', 4),
(21, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', 2),
(22, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', 1),
(23, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', 3),
(24, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', 5),
(25, 13, 18, 'Leaf Grows', 'crt/stage3_leaf.png', 4),
(26, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', 2),
(27, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', 1),
(28, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', 3),
(29, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', 5),
(30, 19, 24, 'Stem Forms', 'crt/stage4_stem.png', 4),
(31, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', 2),
(32, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', 1),
(33, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', 3),
(34, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', 5),
(35, 25, 30, 'Full Plant', 'crt/stage5_fullplant.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'john', 'john@example.com', '12345l', '2025-07-22 05:45:39'),
(2, 'chandana', 'chandana@example.com', 'newpassword123', '2025-07-25 03:03:07'),
(3, 'KR', 'kr@example.com', 'kr@123', '2025-07-29 08:50:26'),
(4, 'RK', 'rkchandu@exmaple.com', '123456', '2025-07-29 09:11:03'),
(5, 'Vijaya', 'luckychandana826@gmail.com', '1234', '2025-07-29 09:18:19'),
(6, 'hithesh', 'lucky@gmail.com', 'Lucky', '2025-08-14 06:22:06'),
(7, 'Chetan', 'chetan123@gmail.com', '1234', '2025-09-14 05:15:29'),
(8, 'chandana', 'chandanakr1987.sse@saveetha.com', 'harshi123', '2025-10-03 04:42:33'),
(10, 'Harshitha', 'harshi@gmail.com', 'omsairam', '2025-10-03 04:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'planned',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `task_name`, `status`, `created_at`, `updated_at`) VALUES
(64, 1, 'chapter51', 'completed', '2025-07-31 15:07:30', '2025-08-02 03:35:26'),
(65, 1, 'chapter51', 'completed', '2025-07-31 15:15:51', '2025-08-02 03:18:45'),
(66, 5, 'hide', 'completed', '2025-07-31 15:21:36', '2025-09-14 05:06:10'),
(67, 5, 'hide', 'completed', '2025-07-31 15:30:47', '2025-08-01 10:05:59'),
(68, 5, 'hides', 'completed', '2025-07-31 16:37:18', '2025-08-01 10:05:59'),
(69, 5, 'hides', 'completed', '2025-07-31 16:37:18', '2025-08-01 10:05:59'),
(70, 5, 'hides', 'completed', '2025-07-31 16:37:18', '2025-08-01 10:05:59'),
(71, 5, 'hides', 'completed', '2025-07-31 16:38:17', '2025-08-01 10:05:59'),
(72, 1, 'Read Java Notes', 'completed', '2025-08-01 03:13:31', '2025-08-02 03:49:57'),
(73, 5, 'running', 'completed', '2025-08-01 03:53:33', '2025-08-01 10:05:59'),
(74, 5, 'running', 'completed', '2025-08-01 03:54:20', '2025-08-01 10:05:59'),
(75, 5, 'running', 'completed', '2025-08-01 03:54:23', '2025-08-01 10:05:59'),
(76, 5, 'running', 'completed', '2025-08-01 04:00:45', '2025-08-01 10:05:59'),
(77, 5, 'running', 'completed', '2025-08-01 04:02:42', '2025-08-01 10:05:59'),
(78, 5, 'running', 'completed', '2025-08-01 04:10:47', '2025-08-01 10:05:59'),
(79, 5, 'running', 'completed', '2025-08-01 04:29:37', '2025-08-01 10:05:59'),
(80, 5, 'runnning', 'completed', '2025-08-01 04:52:35', '2025-08-01 10:05:59'),
(81, 5, 'readwrite', 'completed', '2025-08-01 07:26:55', '2025-08-01 10:05:59'),
(82, 5, 'runninggg', 'completed', '2025-08-01 07:29:24', '2025-08-01 10:05:59'),
(83, 5, 'runningrun', 'completed', '2025-08-01 07:30:19', '2025-08-01 10:05:59'),
(84, 5, 'easywriting', 'completed', '2025-08-01 08:44:35', '2025-08-02 04:08:35'),
(85, 5, 'yeeedf', 'completed', '2025-08-01 08:50:17', '2025-08-02 03:12:10'),
(86, 5, 'hmmmmde', 'completed', '2025-08-01 09:31:09', '2025-09-14 08:18:35'),
(87, 5, 'xmljava', 'completed', '2025-08-02 04:16:16', '2025-08-02 04:19:35'),
(88, 1, 'gheei', 'completed', '2025-08-02 04:34:48', '2025-08-02 04:37:26'),
(89, 1, 'shdhej', 'completed', '2025-08-02 04:35:48', '2025-08-02 04:50:01'),
(90, 5, 'gdhhe', 'completed', '2025-08-02 04:42:27', '2025-08-02 04:43:40'),
(91, 1, 'given', 'completed', '2025-08-05 05:56:26', '2025-08-05 05:58:27'),
(92, 5, 'eating', 'completed', '2025-08-05 12:05:29', '2025-08-05 12:07:03'),
(93, 1, 'vnnj', 'completed', '2025-08-07 06:17:11', '2025-08-07 06:19:25'),
(94, 6, 'sleeping', 'completed', '2025-08-14 06:26:46', '2025-08-14 06:28:19'),
(95, 5, 'hshshsg', 'completed', '2025-08-16 10:55:02', '2025-08-16 10:58:43'),
(96, 5, 'gaming', 'completed', '2025-08-16 11:02:33', '2025-08-16 11:24:01'),
(97, 5, 'hffyytr', 'completed', '2025-08-16 11:08:58', '2025-08-16 12:48:20'),
(98, 5, 'tasking', 'completed', '2025-08-16 16:00:13', '2025-08-22 07:00:40'),
(99, 5, 'ygtyy', 'completed', '2025-08-22 06:58:08', '2025-08-28 09:47:34'),
(100, 4, 'drawing', 'completed', '2025-08-28 09:57:33', '2025-08-28 09:58:52'),
(101, 4, 'Reading', 'completed', '2025-08-28 10:27:22', '2025-08-28 10:33:19'),
(102, 4, 'painting', 'completed', '2025-08-28 14:03:22', '2025-08-28 14:57:43'),
(103, 4, 'disk', 'completed', '2025-08-28 16:12:34', '2025-09-14 15:10:26'),
(104, 4, 'ttee', 'completed', '2025-09-01 11:18:05', '2025-09-14 15:11:40'),
(105, 4, 'playing', 'completed', '2025-09-13 15:23:11', '2025-09-14 15:38:30'),
(106, 7, 'hiking', 'completed', '2025-09-14 05:16:05', '2025-09-14 15:06:32'),
(107, 1, 'hides', 'pending', '2025-09-14 13:10:03', '2025-09-14 13:10:06'),
(108, 4, 'plays', 'completed', '2025-09-14 15:09:53', '2025-09-14 15:39:49'),
(109, 4, 'peace', 'completed', '2025-09-23 13:15:38', '2025-10-07 14:56:25'),
(110, 4, 'rain', 'pending', '2025-09-23 13:20:48', '2025-09-23 13:20:51'),
(111, 5, 'peacc', 'completed', '2025-09-23 15:26:55', '2025-09-23 15:27:33'),
(112, 4, 'healing', 'completed', '2025-10-03 04:38:08', '2025-10-03 04:39:15'),
(113, 4, 'Writing', 'pending', '2025-10-07 14:55:19', '2025-10-07 14:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `completed_level` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `user_id`, `completed_level`, `updated_at`) VALUES
(1, 1, 19, '2025-07-29 10:17:36'),
(2, 1, 19, '2025-07-29 10:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `user_id` int(11) NOT NULL,
  `total_completed` int(11) NOT NULL DEFAULT 0,
  `stage_name` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`user_id`, `total_completed`, `stage_name`, `image_url`, `updated_at`) VALUES
(1, 5, 'Seed in Sand', 'crt/stage1_seed.png', '2025-08-05 15:41:23'),
(2, 10, 'Sprouting Leaf', 'crt/stage2_sprout.png', '2025-08-05 15:41:23'),
(3, 14, 'Leaf Grows', 'crt/stage3_leaf.png', '2025-08-05 15:41:23'),
(4, 20, 'Stem Forms', 'crt/stage4_stem.png', '2025-08-05 15:41:23'),
(5, 27, 'Full Plant', 'crt/stage5_fullplant.png', '2025-08-05 15:41:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `plant_stage`
--
ALTER TABLE `plant_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `plant_stages`
--
ALTER TABLE `plant_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `plant_stage`
--
ALTER TABLE `plant_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plant_stages`
--
ALTER TABLE `plant_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plant_stage`
--
ALTER TABLE `plant_stage`
  ADD CONSTRAINT `plant_stage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
