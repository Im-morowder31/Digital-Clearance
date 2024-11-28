-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2024 at 09:11 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital-clearance`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty_users`
--

CREATE TABLE `faculty_users` (
  `id` int NOT NULL,
  `dept_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty_users`
--

INSERT INTO `faculty_users` (`id`, `dept_id`, `password`, `name`) VALUES
(1, '2009998887', '4c157c13dbc5ea957b3f98b9094a1b5e', 'Library'),
(2, '100045768', '1b672093c089293e9e4a784f733ace53', 'OSA'),
(3, '122345342', 'fe23b3e6ffc4d3cf50edb90b90a96f2e', 'Cashier'),
(4, '200987836', '2210242bd27ed116d858ef59016926db', 'Student Council'),
(5, '300908645', 'dc7494443252fb5336d84cb9222cfef9', 'Dean');

-- --------------------------------------------------------

--
-- Table structure for table `student_clearance`
--

CREATE TABLE `student_clearance` (
  `id` int NOT NULL,
  `stud_id` int NOT NULL,
  `Library` int NOT NULL,
  `OSA` int NOT NULL,
  `Cashier` int NOT NULL,
  `Student Council` int NOT NULL,
  `Dean` int NOT NULL,
  `Comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_clearance`
--

INSERT INTO `student_clearance` (`id`, `stud_id`, `Library`, `OSA`, `Cashier`, `Student Council`, `Dean`, `Comment`) VALUES
(1, 200890522, 0, 0, 0, 0, 0, ''),
(2, 200890563, 1, 1, 1, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int NOT NULL,
  `LRN` varchar(255) NOT NULL,
  `Sex` varchar(255) NOT NULL,
  `Civil_Status` varchar(255) NOT NULL,
  `Date_of_Birth` varchar(255) NOT NULL,
  `Place_of_Birth` varchar(255) NOT NULL,
  `Religion` varchar(255) NOT NULL,
  `Nationality` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_Number` varchar(255) NOT NULL,
  `Course` varchar(255) NOT NULL,
  `Section` varchar(255) NOT NULL,
  `stud_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `LRN`, `Sex`, `Civil_Status`, `Date_of_Birth`, `Place_of_Birth`, `Religion`, `Nationality`, `Address`, `Contact_Number`, `Course`, `Section`, `stud_id`) VALUES
(1, '106315', 'Male', 'Single', 'October 15, 2004', 'Mabalacat, Pampanga', 'Christian', 'Filipino', 'Blk 75 lot 18 brgy VDR Dapdap, Bamban, Tarlac', '09123456789', 'BSIT', '3B', 200890522),
(9, '101002563862', 'Male', 'Single', 'October 15, 2004', 'Mabalacat, Pampanga', 'Christian', 'Filipino', 'Blk 75 lot 18 brgy VDR Dapdap, Bamban, Tarlac', '09123456789', 'BSIT', '3A', 200890563);

-- --------------------------------------------------------

--
-- Table structure for table `student_users`
--

CREATE TABLE `student_users` (
  `id` int NOT NULL,
  `stud_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_users`
--

INSERT INTO `student_users` (`id`, `stud_id`, `password`, `name`) VALUES
(1, '0122303926', '47a7d4c8e93337305ff9017722f8fff3', 'John Andre D. Beltran'),
(2, '0121302381', 'f4629b0cb658b6157989389213bc6cae', 'Karl John L. Nucum'),
(6, '200890522', 'c240f465062285655fce1d896d4ef4fb', 'John Paul Dungca'),
(7, '200890563', '4c2a904bafba06591225113ad17b5cec', 'John Doe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty_users`
--
ALTER TABLE `faculty_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_clearance`
--
ALTER TABLE `student_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_users`
--
ALTER TABLE `student_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty_users`
--
ALTER TABLE `faculty_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_clearance`
--
ALTER TABLE `student_clearance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_users`
--
ALTER TABLE `student_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
