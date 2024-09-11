-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2024 at 10:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendancesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `eventid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `userid`, `eventid`, `status`, `updated_at`, `created_at`) VALUES
(1, '5', '5', 'present', '2024-09-11 18:54:28', '2024-09-11 18:54:05'),
(2, '5', '6', 'present', '2024-09-11 18:54:28', '2024-09-11 18:54:05'),
(3, '7', '7', 'present', '2024-09-11 21:24:42', '2024-09-11 21:24:42'),
(4, '7', '7', 'present', '2024-09-11 21:26:22', '2024-09-11 21:26:22'),
(5, '7', '7', 'present', '2024-09-11 21:38:26', '2024-09-11 21:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `eventdate` varchar(255) NOT NULL,
  `starttime` varchar(255) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'upcoming',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `eventdate`, `starttime`, `endtime`, `status`, `updated_at`, `created_at`) VALUES
(5, 'Thanksgiving Service', '2024-09-29', '07:05', '10:00', 'upcoming', '2024-09-11 16:00:37', '2024-09-11 16:00:37'),
(6, 'Naming Ceremony', '2024-09-02', '08:11', '09:15', 'past', '2024-09-11 17:11:25', '2024-09-11 17:11:18'),
(7, 'Midweek Service', '2024-09-11', '16:00', '20:00', 'upcoming', '2024-09-11 20:01:09', '2024-09-11 20:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `membership` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `membership`, `role`, `phone`, `password`, `updated_at`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'member', 'admin', '2348123456789', '25d55ad283aa400af464c76d713c07ad', '2024-09-11 12:05:54', '2024-09-11 12:05:54'),
(5, 'Eldieloa', 'Minakora', 'elect@gmail.com', 'deacon', 'admin', '1234567890122', '25d55ad283aa400af464c76d713c07ad', '2024-09-11 16:49:46', '2024-09-11 16:46:03'),
(6, 'John', 'Destiny', 'johnlane@doe.com', 'pastor', 'user', '1234567890', '25d55ad283aa400af464c76d713c07ad', '2024-09-11 16:52:09', '2024-09-11 16:52:09'),
(7, 'ken', 'wills', 'ken@test.com', 'member', 'user', '1234567890', '25d55ad283aa400af464c76d713c07ad', '2024-09-11 19:14:52', '2024-09-11 19:14:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
