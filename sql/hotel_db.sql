-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2024 at 08:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `room_type` varchar(25) DEFAULT NULL,
  `room_no` varchar(25) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `room_type`, `room_no`, `check_in_date`, `check_out_date`, `country`, `STATUS`) VALUES
(71, 70, 'ram', 'khatri', 'sagarregmi012@gmail.com', '9856789965', 'Standard', '401', '2023-07-14', '2023-07-15', 'Nepal', 'Cancelled'),
(72, 64, 'roman', 'yadav', 'uwv@gmail.com', '9876534287', 'Deluxe', '302', '2023-07-20', '2023-07-27', 'Japan', 'Pending'),
(73, 64, 'sagar', 'sagar', 'sagarregmi012@gmail.com', '9856789965', 'Executive', '104', '2023-08-04', '2023-08-05', 'Nepal', 'Pending'),
(74, 1, 'sagar ', 'regmi', 'rom123@gmail.com', '9773465711', 'Suite', '303', '2023-08-18', '2023-08-25', 'France', 'Cancelled'),
(77, 1, 'ram', 'khadka', 'rame@gmail.com', '9876543210', 'Standard', '401', '2023-05-12', '2023-05-15', 'Brazil', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`full_name`, `email`, `mobile_number`, `subject`, `id`) VALUES
('Sagar Regmi', 'sagarregmi012@gmail.com', '97466347646', 'proper housekeeping service not available', 1),
('Roman Timilsina', 'rom123@gmail.com', '9841325678', ' I need 2 double bed room', 13),
('Prabhat Pandey', 'pandey@gmail.com', '9840578954', ' is gym,swmming poll available at morning\r\n', 14);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_no` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_no`, `room_type`, `is_available`) VALUES
(101, 'Standard', 1),
(105, 'standard', 1),
(501, 'Normal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `userid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`userid`, `fname`, `lname`, `email`, `password`, `role`, `image`) VALUES
(1, 'Sagar', 'Regmi', 'abcd@gmail.com', '1234', 'user', NULL),
(64, 'Roman', 'Timalsina', 'roman12@gmail.com', '12345', 'user', NULL),
(70, 'Roman', 'Timalsina', 'rom123@gmail.com', 'roman', 'admin', NULL),
(75, 'Sagar', 'Regmi', 'reg@gmail.com', 'sag', 'admin', NULL),
(76, 'Prabhat', 'pandey', 'pandey@gmail.com', 'pan', 'user', NULL),
(78, 'Roman', 'pandey', 'abcdefg@gmail.com', '111', 'user', NULL),
(79, 'Roman', 'pandey', 'abcdefgh@gmail.com', '222', 'user', NULL),
(80, 'Roman', 'pandey', 'abcdefghi@gmail.com', '111', 'user', NULL),
(82, 'Roman', 'aaaa', 'sss@gmail.com', '123', 'user', NULL),
(83, 'Roman', 'kk', 'kkkk@gmail.com', '1234', 'user', NULL),
(84, '1234', '1234', 'fff@gmail.com', '444', 'user', NULL),
(85, 'Roman', 'svdb', 'mmm@gmail.com', '1234', 'user', NULL),
(86, 'kkk', 'lll', 'lll@gmail.com', '1234', 'user', NULL),
(87, 'nnnbb', ' hvh', 'gggg@gmail.com', 'ggg', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_no`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_data` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
