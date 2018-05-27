-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2014 at 01:10 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cifadblms`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cifakodnegeri`
--

CREATE TABLE IF NOT EXISTS `mdl_cifakodnegeri` (
  `Kod_Negeri` varchar(10) NOT NULL,
  `state_code` varchar(3) NOT NULL,
  `Negeri` varchar(50) NOT NULL,
  `ptkarrangement` int(1) NOT NULL,
  PRIMARY KEY (`Kod_Negeri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mdl_cifakodnegeri`
--

INSERT INTO `mdl_cifakodnegeri` (`Kod_Negeri`, `state_code`, `Negeri`, `ptkarrangement`) VALUES
('09', 'PLS', 'Perlis', 1),
('02', 'KDH', 'Kedah', 2),
('07', 'PNG', 'Pulau Pinang', 3),
('08', 'PRK', 'Perak', 4),
('10', 'SGR', 'Selangor', 5),
('15', 'LBN', 'WP Labuan', 6),
('14', 'KUL', 'WP Kuala Lumpur', 7),
('16', 'PJY', 'WP Putrajaya', 8),
('05', 'NSN', 'Negeri Sembilan', 9),
('04', 'MLK', 'Melaka', 10),
('01', 'JHR', 'Johor', 11),
('06', 'PHG', 'Pahang', 12),
('11', 'TRG', 'Terengganu', 13),
('03', 'KTN', 'Kelantan', 14),
('12', 'SBH', 'Sabah', 15),
('13', 'SRW', 'Sarawak', 16);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
