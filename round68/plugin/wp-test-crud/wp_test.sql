-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 04:25 PM
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
-- Database: `r68_wordpress_chitkar`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_test`
--

CREATE TABLE `wp_test` (
  `id` int(11) NOT NULL,
  `fk` varchar(64) NOT NULL,
  `fv` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wp_test`
--

INSERT INTO `wp_test` (`id`, `fk`, `fv`) VALUES
(1, 'address', '1428 Elm St'),
(2, 'address8766', '8757 Elm St'),
(3, 'address1932', '5093 Elm St'),
(4, 'address8946', '3646 Elm St'),
(5, 'address9957', '4151 Elm St');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_test`
--
ALTER TABLE `wp_test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_test`
--
ALTER TABLE `wp_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
