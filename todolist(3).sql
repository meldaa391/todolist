-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 05:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int NOT NULL,
  `taskid` int NOT NULL,
  `subtask` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`id`, `taskid`, `subtask`, `created_at`) VALUES
(26, 34, 'meldaaprynt cann', '2025-04-08 08:43:40'),
(27, 34, 'halloo mahardhika', '2025-04-09 02:43:26'),
(28, 38, 'haiii', '2025-04-09 03:57:15'),
(31, 42, 'sman 2 cimahi', '2025-04-10 17:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int NOT NULL,
  `userid` int NOT NULL,
  `tasklabel` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `taskstatus` enum('open','close') COLLATE utf8mb4_general_ci NOT NULL,
  `creatadet` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `priority` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Medium'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskid`, `userid`, `tasklabel`, `taskstatus`, `creatadet`, `deadline`, `notes`, `priority`) VALUES
(34, 0, 'buku', 'close', '2025-02-22 07:55:53', '2025-02-01', NULL, 'High'),
(37, 7, 'tes', 'open', '2025-04-09 03:05:38', '2025-04-17', NULL, 'Medium'),
(38, 5, 'LIEUR AMPUN', 'open', '2025-04-09 03:57:07', '2025-04-08', NULL, 'Medium'),
(40, 8, 'smkn 2 bandung', 'open', '2025-04-09 11:26:58', '2025-04-09', NULL, 'Low'),
(41, 10, 'riki sayang meldaa', 'open', '2025-04-09 13:36:29', '2025-04-08', NULL, 'High'),
(42, 9, 'smkn 5 bandunggg', 'close', '2025-04-09 13:38:34', '2025-04-09', NULL, 'Medium');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `email`, `password`) VALUES
(1, 'meldaapryntt', 'melda', 'mldaapr@gmail.com', '$2y$10$sDFRYL1euyQPDfjJsR48relUrlXfum23ObdEH/UWAva1R6As59MVC'),
(5, 'meldaapry', 'mlda', 'meldapy@gmail.com', '$2y$10$rDyeE8cfC0Bwi5I3TUKD7eGsBdTqmjxa9cC4K1DT7xk4abJfJvqHS'),
(6, 'tes', 'tes', 'tes2@gmail.com', '$2y$10$njNmv6OCNhxXqOvW1Ym9lu2/P2UwmVFi5aXwwT7RCHkSGIPSCw.uG'),
(7, 'asep', 'asep', 'asep@d', '$2y$10$QCjitxD0ZyO94Lxnjk2wfuGg.sjEWHHwA9H7Jm3l4eJP8AbUH6ASC'),
(8, 'meldaapryn', 'meldaaa', 'meldacan@gmail.com', '$2y$10$cOT6zKq2s3g0I9mV6Hbq8.6qknxnKelhOgv4Nd7q6UeyO1CcXfauq'),
(9, 'meldaapriyanti', 'meldaa', 'meldaaprynti@gmail.com', '$2y$10$85kYJVoyY.vUNEZQADbPCuOb03FLwIS2Oh5M0dUSVVsOlfuYnrW9W'),
(10, 'rikimllna', 'riki', 'rikimlln@gmail.com', '$2y$10$WDu5TsgF8kSutq4dT6Y9rew16evQo6CQxyJjWBzgWTw5YakoaROBO'),
(11, 'aqilaraisa', 'aqila', 'aqila@gmail.com', '$2y$10$P63L8wWcJgjGSxGv2gpBMODhdQJuRTNlLxpUdzy0ZLUKjiRu1UznC'),
(12, 'raisaa', 'rais', 'raisa@gmail.com', '$2y$10$p79K0y8WVF6C/K5dgvMpqO8kJEtH/7m42L4zQrNLwopSLoKUmzsza'),
(13, 'melda', 'mld', 'ml@gmail.com', '$2y$10$bZUfPnxdQvZ1zCzTRZKA.ebMn0VqBB9ZSPhgdux0Zf3X6lU9DS96i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taskid` (`taskid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`taskid`) REFERENCES `tasks` (`taskid`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
