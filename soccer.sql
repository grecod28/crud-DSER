-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2025 at 11:22 AM
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
-- Database: `soccer`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `name` varchar(36) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`name`, `password`) VALUES
('adrian', '$2y$10$ImRMojSvqJ8YbZezergjcOxfZQRdaYVWIgRbljXNzj9GklC9ABiWa'),
('andres', '$2y$10$JC5fv3B23IqMsNPfeUr3oOshc07oyme7bs8KaQdhjiTIEL0luJ14S'),
('samuel', '$2y$10$cah8jeRAY52xdyZvE2c0J.NBE.E5wL2kKB9YW2I//f8S1Dghsnp3a'),
('santiago', '$2y$10$Qu2AaVSv9eN18LabDgoVpenlwAdwIHlMfN.nOlso.mpcjjkLvoxfu');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `id_team` int(11) DEFAULT NULL,
  `salary` int(11) DEFAULT 2000,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `id_team`, `salary`, `image_path`) VALUES
(11, 'santiago', 8, 4000, 'uploads/29f3c70d18ba1db64a3c9878d1faaaa3.jpeg'),
(12, 'andres', 8, 4000, 'uploads/8f0cee9c1ba54d43f7f2e9d790608ddf.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `create_date` date DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL,
  `account_name` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `create_date`, `address`, `account_name`) VALUES
(6, 'FC Ourense', '2025-11-18', 'Ourense, Ourense', 'andres'),
(7, 'A', '2025-11-18', 'Ourense', 'santiago'),
(8, 'B', '2025-11-18', 'Ourense', 'santiago'),
(9, 'A', '2025-11-20', 'Ourense', 'samuel'),
(10, 'B', '2025-11-20', 'Vigo', 'samuel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_team` (`id_team`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_name` (`account_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`account_name`) REFERENCES `accounts` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
