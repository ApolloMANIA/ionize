-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 07:49 PM
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
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `crypster_level` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `username`, `password_hash`, `crypster_level`) VALUES
('eshankumar02122005@gmail.com', 'Apollo', '$2y$10$TxItFUfjE/3wLBh8XpsR2efSq7teqKwr4Q1GJakTNONhN992eZNQa', 8),
('chinar120605@gmail.com', 'babushka', '$2y$10$T95Zk/qS/IUYxuW3HVe9guKl.0kPoHgZYhODEDInu4QBPzvGc2wze', 13),
('aftab@gmail.com', 'Bro', '$2y$10$Qc2PcHMYuH8KYO3.bOuq5.1aUdOu8gZnXy2gkeO1daaZ9cWQe.WiC', 20),
('greg@mendel.com', 'gregory', '$2y$10$fShmOf6CT4Rt3s8vSpsYx./rcXsRzVRozuhH0Um3EpPaQH.eMeLIq', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
