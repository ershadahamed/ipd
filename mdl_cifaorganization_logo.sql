-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2015 at 09:59 AM
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
-- Table structure for table `mdl_cifaorganization_logo`
--

CREATE TABLE IF NOT EXISTS `mdl_cifaorganization_logo` (
`id` bigint(10) unsigned NOT NULL,
  `organizationid` bigint(10) unsigned NOT NULL DEFAULT '0',
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `path_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) unsigned NOT NULL DEFAULT '0',
  `timemodified` bigint(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mdl_cifaorganization_logo`
--

INSERT INTO `mdl_cifaorganization_logo` (`id`, `organizationid`, `logo`, `path_logo`, `timecreated`, `timemodified`) VALUES
(1, 10, '11401297_1621992051379511_4712050077441069982_n.jpg', 'logo/11401297_1621992051379511_4712050077441069982_n.jpg', 1434594436, 1434600167);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_cifaorganization_logo`
--
ALTER TABLE `mdl_cifaorganization_logo`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_cifaorganization_logo`
--
ALTER TABLE `mdl_cifaorganization_logo`
MODIFY `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
