-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2024 at 09:24 AM
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
(3, 121300331, 1, 0, 0, 0, 0, ''),
(4, 121300314, 0, 0, 0, 0, 0, ''),
(5, 121302381, 0, 0, 0, 0, 0, ''),
(6, 122303926, 0, 0, 0, 0, 0, '');

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
(10, '0000', 'Male', 'Single', 'September 6, 2003', 'Angeles City, Pampanga', 'Roman Catholic', 'Filipino', 'Brgy. Santiago Concepcion, Tarlac', '09052564546', 'BSIT', 'CCIS7E', 121300331),
(11, '0000', 'Male', 'Single', 'December 6, 2002', 'Concepcion, Tarlac', 'Roman Catholic', 'Filipino', 'Brgy. Minane Concepcion, Tarlac', '09917928078', 'BSIT', 'CCIS7E', 121300314),
(12, '0000', 'Male', 'Single', 'September 30, 2003', 'Calumpit, Bulacan', 'Roman Catholic', 'Filipino', 'Mabalacat City Pampanga', '09765742023', 'BSIT', 'CCIS7E', 121302381),
(13, '0000', 'Male', 'Single', 'May 9, 2001', 'Angeles city, Pampanga', 'Roman Catholic', 'Filipino', '1106 cubul sapalibutad, Angeles city', '09942072292', 'BSIT', 'CCIS7E', 122303926);

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
(8, '0121300331', 'a23ce8b43ad54109d361bd8b63d30fb3', 'Ram Yturralde'),
(9, '0121300314', '47bdef85adbe8fb68bbc809aaf55c8cc', 'Louis Tiomico'),
(10, '0121302381', 'f4629b0cb658b6157989389213bc6cae', 'Karl John Nucum'),
(11, '0122303926', '47a7d4c8e93337305ff9017722f8fff3', 'John Andre Beltran');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_users`
--
ALTER TABLE `student_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
