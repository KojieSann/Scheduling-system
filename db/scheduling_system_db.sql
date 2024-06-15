-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2024 at 02:47 PM
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
-- Database: `scheduling_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `section` varchar(30) NOT NULL,
  `strand` varchar(30) NOT NULL,
  `day` varchar(30) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `duration` varchar(30) NOT NULL,
  `instructor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `section`, `strand`, `day`, `subject`, `time`, `duration`, `instructor`) VALUES
(450, ' Sitaw', 'TVL', 'Monday', 'Science', '10:00 AM - 11:00 AM', '60 minutes', 'Andrei Belamide'),
(451, ' Sitaw', 'TVL', 'Tuesday', 'Science', '10:00 AM - 11:30 AM', '90 minutes', 'Andrei Belamide'),
(452, ' Sitaw', 'TVL', 'Monday', 'Art', '10:00 AM - 11:00 AM', '60 minutes', 'Lester Quinagutan'),
(453, ' Sitaw', 'TVL', 'Tuesday', 'Art', '10:00 AM - 11:00 AM', '60 minutes', 'Lester Quinagutan'),
(454, ' Sitaw', 'TVL', 'Wednesday', 'Art', '10:00 AM - 11:00 AM', '60 minutes', 'Lester Quinagutan'),
(455, ' Sitaw', 'TVL', 'Thursday', 'Art', '10:00 AM - 11:00 AM', '60 minutes', 'Lester Quinagutan'),
(456, ' Sitaw', 'TVL', 'Friday', 'Art', '10:00 AM - 11:00 AM', '60 minutes', 'Lester Quinagutan'),
(457, 'Ampalaya', 'STEM', 'Monday', 'English101', '08:00 AM - 11:30 AM', '210 Minutes', 'Juan Dela cruz'),
(458, 'Ampalaya', 'STEM', 'Tuesday', 'English101', '09:00 AM - 11:00 AM', '120 Minutes', 'Juan Dela cruz'),
(459, 'Ampalaya', 'STEM', 'Wednesday', 'English101', '12:00 AM - 11:30 AM', '690 Minutes', 'Juan Dela cruz'),
(460, 'Ampalaya', 'STEM', 'Thursday', 'English101', '04:00 PM - 09:00 PM', '300 Minutes', 'Juan Dela cruz'),
(461, 'Ampalaya', 'STEM', 'Friday', 'English101', '11:00 AM - 12:00 AM', '-660 Minutes', 'Juan Dela cruz');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_again`
--

CREATE TABLE `schedule_again` (
  `id` int(11) NOT NULL,
  `section` varchar(25) NOT NULL,
  `strand` varchar(25) NOT NULL,
  `grade_level` varchar(250) NOT NULL,
  `sem` varchar(25) NOT NULL,
  `school_year` varchar(25) NOT NULL,
  `adviser` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_again`
--

INSERT INTO `schedule_again` (`id`, `section`, `strand`, `grade_level`, `sem`, `school_year`, `adviser`) VALUES
(32, ' Sitaw', 'TVL', 'Grade 11', '1st', '2024-2025', 'Lester Quinagutan'),
(33, 'Ampalaya', 'STEM', 'Grade 11', '1st', '2024-2025', 'Andrei Belamide');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `grade_level` varchar(255) NOT NULL,
  `strand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `grade_level`, `strand`) VALUES
(24, ' Sitaw', 'Grade 11', 'TVL'),
(25, 'Ampalaya', 'Grade 11', 'STEM'),
(26, 'Kalabaw', 'Grade 11', 'ABM');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `grade_level` varchar(255) NOT NULL,
  `strand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `grade_level`, `strand`) VALUES
(71, 'Math', 'Math101', 'Grade 12', 'GAS'),
(72, 'English101', '202', 'Grade 12', 'GAS, STEM'),
(73, 'Science', 'SCI', 'Grade 12', 'GAS, STEM, TVL, ICT, ABM'),
(74, 'PE', 'ICELLE', 'Grade 12', 'GAS, STEM, ICT, ABM'),
(77, 'Art', 'Art101', 'Grade 11', 'GAS, STEM, TVL, ICT, ABM, HUMSS, HE');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `day` varchar(50) DEFAULT NULL,
  `time` varchar(255) NOT NULL,
  `strand` enum('GAS','STEM','TVL','ICT','ABM') NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `middle_name`, `last_name`, `day`, `time`, `strand`, `subject`) VALUES
(158, 'Lester', '', 'Quinagutan', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'AM-PM', 'GAS', 'Math'),
(159, 'Andrei', '', 'Belamide', 'Monday, Tuesday', 'PM', 'TVL', 'English101'),
(160, 'Juan', 'lol', 'Dela cruz', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'AM', 'STEM', 'Math, English101'),
(161, 'adsf', 'ddd', 'ghgg', 'Monday', 'PM', 'STEM', 'Math, English101, Science'),
(162, 'u6yu56', 'dvfsdxvdf', '323232', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'PM', 'ICT', 'Math, English101'),
(163, 'gbg', '', 'bgbgf', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'PM', 'STEM', 'English101'),
(164, 'jjj', 'jb', 'bnm', 'Monday, Tuesday', 'AM-PM', 'STEM', 'English101');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'user1', 'user123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_again`
--
ALTER TABLE `schedule_again`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=462;

--
-- AUTO_INCREMENT for table `schedule_again`
--
ALTER TABLE `schedule_again`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
