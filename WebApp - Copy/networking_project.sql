-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2018 at 05:43 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `networking_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `current_availability`
--

CREATE TABLE `current_availability` (
  `mac` varchar(20) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT '0',
  `last_modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current_availability`
--

INSERT INTO `current_availability` (`mac`, `availability`, `last_modified`) VALUES
('48:A9:1C:E7:9A:22', 1, '2018-12-06 17:47:43'),
('24:24:0E:60:1a:7e', 1, '2018-12-06 17:48:51');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `sno` int(11) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `device_name` varchar(20) DEFAULT NULL,
  `mac` varchar(20) DEFAULT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`sno`, `fname`, `lname`, `device_name`, `mac`, `email`) VALUES
(5, 'Dhruv', 'Gupta', 'iphone1', '48:A9:1C:E7:9A:22', 'ddhruvgupta@gmail.com'),
(6, 'Dhruv', 'Gupta', 'Ipad1', '24:24:0E:60:1a:7e', 'ddhruvgupta@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `mac` varchar(20) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`mac`, `availability`, `time`) VALUES
('48:A9:1C:E7:9A:22', 0, '2018-11-01 02:19:04'),
('48:A9:1C:E7:9A:22', 1, '2018-11-01 02:21:50'),
('24:24:0E:60:1A:7E', 1, '2018-11-01 02:22:13'),
('48:A9:1C:E7:9A:22', 0, '2018-11-01 02:25:56'),
('48:A9:1C:E7:9A:22', 1, '2018-11-03 01:18:09'),
('48:A9:1C:E7:9A:22', 0, '2018-11-03 10:59:08'),
('48:A9:1C:E7:9A:22', 1, '2018-11-03 13:29:43'),
('48:A9:1C:E7:9A:22', 1, '2018-12-06 17:47:43'),
('24:24:0E:60:1a:7e', 1, '2018-12-06 17:48:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `mac` (`mac`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
