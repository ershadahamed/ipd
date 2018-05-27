-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2015 at 06:44 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shapedblms`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cifasupport`
--

CREATE TABLE IF NOT EXISTS `mdl_cifasupport` (
`id` bigint(20) unsigned NOT NULL,
  `supportid` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'auto created',
  `usertype` bigint(10) unsigned NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `category` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '0=None',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `timecreated` bigint(10) unsigned NOT NULL DEFAULT '0',
  `status` bigint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1=open, 2=close, 3=pending',
  `createdby` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'auto created',
  `deleted` bigint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1= deleted, 0 = available'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mdl_cifasupport`
--

INSERT INTO `mdl_cifasupport` (`id`, `supportid`, `usertype`, `userid`, `category`, `description`, `timecreated`, `status`, `createdby`, `deleted`) VALUES
(1, 'S001', 5, 315, 2, 'youtube subscription', 1432711128, 3, '2', 0),
(2, 'S002', 5, 313, 5, 'testing', 1432712382, 1, '2', 0),
(3, 'S00003', 6, 8, 1, 'asdsadsadsdsadasdasdasdsad', 1432715989, 2, '2', 1),
(4, 'S004', 5, 313, 7, 'testing to write this', 1432719235, 1, '2', 0),
(5, 'S005', 5, 322, 1, 'sdfsdfsd', 1434439832, 0, '2', 0),
(6, 'S006', 5, 314, 2, 'aaxAXAxaXa', 1435024956, 0, '2', 0),
(7, 'S007', 5, 314, 11, 'cdcdscsdcsdc', 1435025176, 0, '2', 0),
(8, 'S008', 5, 315, 2, 'Financial des', 1438746361, 1, '2', 0),
(9, 'S00009', 5, 315, 3, 'asdasdasdasdasdasdas', 1438746570, 0, '2', 1),
(10, 'S00010', 6, 8, 13, 'xsxsxsxsxsxsxs sxsx sxsxs', 1438767752, 1, '2', 0),
(11, 'S00011', 6, 8, 9, 'ready to use it', 1438767890, 2, '2', 0),
(12, 'S00012', 6, 8, 14, 'sad lagi lagi', 1438768715, 3, '2', 0),
(13, 'S00013', 5, 325, 2, 'test', 1439255703, 1, '2', 0),
(14, 'S00014', 6, 11, 3, 'Financial description', 1439260496, 1, '2', 0),
(15, 'S00015', 6, 11, 13, 'Social media desc', 1439260534, 1, '2', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_cifasupport`
--
ALTER TABLE `mdl_cifasupport`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_cifasupport`
--
ALTER TABLE `mdl_cifasupport`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
