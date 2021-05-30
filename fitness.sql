-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2021 at 07:01 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `memberid` int(11) NOT NULL AUTO_INCREMENT,
  `membername` varchar(60) NOT NULL,
  `phonenumber` varchar(60) NOT NULL,
  `image` varchar(100) NOT NULL,
  `packageid` int(11) NOT NULL,
  `startpackage` date NOT NULL,
  `endpackage` date NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`memberid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberid`, `membername`, `phonenumber`, `image`, `packageid`, `startpackage`, `endpackage`, `userid`) VALUES
(1, 'tha', '02056150114', 'member-tha-02056150114.jpeg', 2, '2021-05-30', '2020-10-01', 2),
(3, 'thone', '02056150114', 'member-thone-02056150114.jpeg', 2, '2021-05-30', '2020-10-02', 2);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `packageid` int(11) NOT NULL AUTO_INCREMENT,
  `packagename` varchar(60) NOT NULL,
  `price` varchar(60) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`packageid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packageid`, `packagename`, `price`, `description`) VALUES
(1, '1 month', '400000', 'no'),
(2, '3 month', '400000', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `serviceid` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  PRIMARY KEY (`serviceid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`serviceid`, `memberid`, `status`, `checkin`, `checkout`) VALUES
(1, 1, 1, '2021-05-30 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 0, '2021-05-30 00:00:00', '2021-05-30 12:13:17'),
(3, 1, 0, '2021-05-30 00:00:00', '2021-05-30 12:16:11'),
(4, 1, 1, '2021-05-30 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 1, '2021-05-30 12:13:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `username`, `password`) VALUES
(1, 'kk', 'thon', '112222'),
(2, 'admin', 'admin', '123456789');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
