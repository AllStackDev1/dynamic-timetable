-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 06:20 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ikolilu_tt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_timetable_tb`
--

CREATE TABLE `acc_timetable_tb` (
  `id` int(11) NOT NULL,
  `sz_range` varchar(20) NOT NULL,
  `sz_count` int(2) NOT NULL,
  `sz_itemid` varchar(50) NOT NULL,
  `sz_item` varchar(100) NOT NULL,
  `sz_teacherid` varchar(50) NOT NULL,
  `sz_teachername` varchar(100) NOT NULL,
  `sz_day` varchar(10) NOT NULL,
  `sz_roomno` varchar(20) NOT NULL,
  `sz_group` varchar(10) NOT NULL,
  `sz_class` varchar(20) NOT NULL,
  `sz_branchid` varchar(20) NOT NULL,
  `sz_schoolid` varchar(50) NOT NULL,
  `sz_term` varchar(20) NOT NULL,
  `sz_acayear` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_timetable_tb`
--
ALTER TABLE `acc_timetable_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_timetable_tb`
--
ALTER TABLE `acc_timetable_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
