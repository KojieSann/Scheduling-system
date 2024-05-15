-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 01:17 PM
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
  `timeIn` varchar(5) DEFAULT NULL,
  `timeOut` varchar(5) DEFAULT NULL,
  `duration` varchar(25) NOT NULL,
  `instructor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `section`, `strand`, `day`, `subject`, `timeIn`, `timeOut`, `duration`, `instructor`) VALUES
(341, 'Kalbo', 'GAS', 'Monday', 'Math', '10:00', '11:00', '', 'Lester Quinagutan'),
(342, 'Kalbo', 'GAS', 'Tuesday', 'Math', '10:00', '11:00', '', 'Lester Quinagutan'),
(343, 'Kalbo', 'GAS', 'Wednesday', 'Math', '10:00', '11:00', '', 'Lester Quinagutan'),
(344, 'Kalbo', 'GAS', 'Thursday', 'Math', '10:00', '11:00', '', 'Lester Quinagutan'),
(345, 'Kalbo', 'GAS', 'Friday', 'Math', '10:00', '01:00', '', 'Lester Quinagutan'),
(346, 'Kalbo', 'GAS', 'Tuesday', 'English101', '11:00', '00:00', '', 'cyd lang kakalampag'),
(347, 'Kalbo', 'GAS', 'Thursday', 'English101', '11:00', '00:00', '', 'cyd lang kakalampag'),
(348, 'Kalbo', 'GAS', 'Friday', 'English101', '11:00', '00:00', '', 'cyd lang kakalampag'),
(349, 'Kalbo', 'GAS', 'Tuesday', 'Math', '11:00', '00:00', '', 'cyd lang kakalampag'),
(350, 'Kalbo', 'GAS', 'Thursday', 'Math', '11:00', '00:00', '', 'cyd lang kakalampag'),
(351, 'Kalbo', 'GAS', 'Friday', 'Math', '11:00', '00:00', '', 'cyd lang kakalampag'),
(352, 'Sampaguita', 'STEM', 'Tuesday', 'English101', '15:00', '16:00', '', 'franz malatik'),
(353, 'Sampaguita', 'STEM', 'Wednesday', 'English101', '15:00', '16:00', '', 'franz malatik'),
(354, 'Kalabaw', 'ABM', 'Tuesday', 'Loving me 101', '10:00', '11:10', '', 'cyd lang kakalampag'),
(355, 'Kalabaw', 'ABM', 'Thursday', 'Loving me 101', '10:00', '11:10', '', 'cyd lang kakalampag'),
(356, 'Kalabaw', 'ABM', 'Friday', 'Loving me 101', '10:00', '11:10', '', 'cyd lang kakalampag'),
(357, ' Sitaw', 'TVL', 'Thursday', 'Loving me 101', '01:00', '01:00', '', 'Dhante Galapon');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_again`
--

CREATE TABLE `schedule_again` (
  `id` int(11) NOT NULL,
  `section` varchar(25) NOT NULL,
  `strand` varchar(25) NOT NULL,
  `no_of_sub` varchar(25) NOT NULL,
  `sem` varchar(25) NOT NULL,
  `school_year` varchar(25) NOT NULL,
  `adviser` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_again`
--

INSERT INTO `schedule_again` (`id`, `section`, `strand`, `no_of_sub`, `sem`, `school_year`, `adviser`) VALUES
(4, 'Sampaguita', 'STEM', '', '2nd', '2020-2023', '1day dawafa'),
(5, 'Kalbo', 'GAS', '', '2nd', '2024-2025', 'Papa  Andrei');

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
(19, 'Sampaguita', '12', 'STEM'),
(24, ' Sitaw', 'Grade 11', 'TVL'),
(25, 'Ampalaya', 'Grade 11', 'STEM'),
(26, 'Kalabaw', 'Grade 11', 'ABM'),
(27, 'Kalbo', 'Grade 12', 'GAS');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `grade_level` varchar(255) NOT NULL,
  `strand` varchar(255) NOT NULL,
  `status` enum('done','in_progress') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `school_year`, `grade_level`, `strand`, `status`) VALUES
(71, 'Math', 'Math101', '2024 - 2025', 'Grade 12', 'GAS', NULL),
(72, 'English101', '202', '2024 - 2025', 'Grade 12', 'GAS, STEM', NULL),
(73, 'Science', 'SCI', '2024 - 2025', 'Grade 12', 'STEM', NULL),
(74, 'PE', 'ICELLE', '2024-2025', 'Grade 12', 'GAS, STEM, ICT, ABM', NULL),
(75, 'Loving me 101', '123', '2021-2025', 'Grade 12', 'GAS, TVL, ABM', NULL);

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
(142, 'Aldrin', '', 'Dayuta', 'Monday, Tuesday', 'PM', 'STEM', 'Math'),
(144, 'Vaugh Nicolai', '', 'De Sagun', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'PM', 'STEM', 'Math'),
(145, 'Dhante', '', 'Galapon', 'Monday, Tuesday, Friday', 'AM-PM', 'STEM', 'Math, Pe'),
(146, '1day', '', 'dawafa', 'Friday', 'AM-PM', 'STEM', 'Math, English101, Science, PE'),
(147, 'Papa ', '', 'Andrei', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'AM', 'STEM', 'English101'),
(148, 'Lester', '', 'Quinagutan', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'AM', 'ICT', 'Math, English101, Science, PE'),
(149, 'franz', '', 'malatik', 'Tuesday, Wednesday', 'AM', 'STEM', 'English101'),
(150, 'cyd lang', '', 'kakalampag', 'Tuesday, Thursday, Friday', 'AM-PM', 'TVL', 'Math, English101, Science, PE'),
(151, 'diwata', 'jabolero', 'andrei', 'Monday, Tuesday', 'PM', 'GAS', 'Math, English101');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `schedule_again`
--
ALTER TABLE `schedule_again`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
