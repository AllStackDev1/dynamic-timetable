-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 06:35 AM
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
-- Table structure for table `aca_timeperiod_db`
--

CREATE TABLE `aca_timeperiod_db` (
  `id` int(11) NOT NULL,
  `sz_count` int(2) NOT NULL,
  `sz_title` varchar(20) NOT NULL,
  `sz_starttime` varchar(10) NOT NULL,
  `sz_endtime` varchar(10) NOT NULL,
  `sz_range` varchar(20) NOT NULL,
  `sz_duration` varchar(5) NOT NULL,
  `sz_branchid` varchar(20) NOT NULL,
  `sz_schoolid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aca_timeperiod_db`
--

INSERT INTO `aca_timeperiod_db` (`id`, `sz_count`, `sz_title`, `sz_starttime`, `sz_endtime`, `sz_range`, `sz_duration`, `sz_branchid`, `sz_schoolid`) VALUES
(8, 1, 'Period 1', '6:00 AM', '6:20 AM', '6:00 - 6:20', '20', '5', 'GSISSCHOOL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aca_timeperiod_db`
--
ALTER TABLE `aca_timeperiod_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aca_timeperiod_db`
--
ALTER TABLE `aca_timeperiod_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
