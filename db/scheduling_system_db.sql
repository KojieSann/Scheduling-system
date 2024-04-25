-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 11:35 AM
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
-- Database: `scheduling_system_db`
--

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
(6, 'tyrtydawdw', 'nbbb', 'TVL'),
(7, 'bsit311daw', '3rdDAWD', 'GAS'),
(8, 'dad', 'dwadADWA', 'STEM'),
(9, 'dawd', 'awdaww', 'STEM'),
(10, 'dawdaaaaaaaaa', 'awdawdaadwdaDAWD', 'TVL'),
(12, 'bsit311', '3rd', 'TVL'),
(13, 'dad', 'dwad', 'STEM'),
(14, 'bsit311aaa', '3rd', 'TVL'),
(15, 'tyrty', 'nbbb', 'STEM'),
(16, 'dawd', 'adawda', 'GAS'),
(17, 'dwad', 'awdawd', 'STEM');

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
(60, 'dawd', 'awd', '2004', 'Grade 11', 'STEM', NULL),
(61, 'dawd', 'awd', '2004', 'Grade 11', 'TVL, ICT', NULL),
(62, 'dawd', 'awd', '2004', 'Grade 11', 'ABM', NULL),
(63, 'dawd', 'awd', '2004', 'Grade 11', 'HUMSS', NULL),
(64, 'dawd', 'awd', '2004', 'Grade 11', 'HE', NULL);

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
(121, 'daw', 'daw', 'dawd', 'Monday, Friday', 'AM-PM', 'TVL', 'tewtwet, tewtwet'),
(122, 'daw', 'daw', 'dawd', 'Friday', 'AM-PM', 'TVL', 'hhhhhh'),
(123, 'dawd', 'dawda', 'dawd', 'Monday', 'PM', 'GAS', 'hhhhhh'),
(124, 'dawd', 'dawda', 'dawd', 'Monday', 'PM', 'GAS', 'ENGLISH'),
(125, 'dawd', 'dawda', 'dawd', 'Monday', 'PM', 'GAS', 'ENGLISH'),
(127, 'dawd', 'dawda', 'dawd', 'Tuesday', 'PM', 'GAS', 'ENGLISH'),
(128, 'dawd', 'dawda', 'dawd', 'Tuesday', 'PM', 'GAS', 'ENGLISH'),
(129, 'dawd', 'awd', 'daw', 'Monday', 'PM', 'STEM', 'tewtwet, tewtwet'),
(137, 'daw', 'dawd', 'wadw', 'Monday, Tuesday', 'PM', 'STEM', 'tewtwet, tewtwet, English, Math'),
(138, 'dwa', 'adwaw', 'dawdwa', 'Monday, Tuesday, Wednesday, Thursday, Friday', 'AM-PM', 'TVL', 'tewtwet, tewtwet, English, Math'),
(139, 'dawd', 'awdaw', 'dawda', 'Monday, Tuesday', 'PM', 'TVL', 'tewtwet, tewtwet, English'),
(140, 'Aldrin', '', 'Dayuta', 'Monday, Tuesday', 'PM', 'STEM', 'English, Math');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'admin', '123'),
(3, 'admin', '123456');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
