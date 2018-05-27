-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2015 at 06:43 PM
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
-- Table structure for table `mdl_cifasupport_attachment`
--

CREATE TABLE IF NOT EXISTS `mdl_cifasupport_attachment` (
`id` bigint(20) unsigned NOT NULL,
  `usertype` bigint(2) unsigned NOT NULL DEFAULT '5' COMMENT '5=user; 6=organization',
  `userid` bigint(10) unsigned NOT NULL DEFAULT '0',
  `timecreated` bigint(20) unsigned NOT NULL DEFAULT '0',
  `timemodified` bigint(10) unsigned NOT NULL DEFAULT '0',
  `attachmentid` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` bigint(10) NOT NULL DEFAULT '0',
  `attachment_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment` text COLLATE utf8_unicode_ci NOT NULL,
  `attachment_path` text COLLATE utf8_unicode_ci NOT NULL,
  `createdby` bigint(3) NOT NULL DEFAULT '0',
  `status` bigint(2) NOT NULL DEFAULT '0' COMMENT '0=active 1=inactive'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mdl_cifasupport_attachment`
--

INSERT INTO `mdl_cifasupport_attachment` (`id`, `usertype`, `userid`, `timecreated`, `timemodified`, `attachmentid`, `category`, `attachment_desc`, `attachment`, `attachment_path`, `createdby`, `status`) VALUES
(1, 5, 315, 1438706618, 1439139069, 'AT00001', 8, 'Proof of payment yo', 'oter shapeipd.txt', 'logo/oter shapeipd.txt', 2, 0),
(2, 5, 315, 1438736160, 1439138976, 'AT00002', 9, 'AT00002: User details', '10799457_814800238583816_1709259_n.jpg', 'logo/10799457_814800238583816_1709259_n.jpg', 2, 0),
(3, 6, 8, 1438736196, 0, 'AT00003', 10, 'sadasdasdasdasd', '', '', 2, 0),
(4, 6, 8, 1438808348, 1439139336, 'AT00004', 11, 'cert. delivery courier', 'Step upload user to offline exam.pdf', 'logo/Step upload user to offline exam.pdf', 2, 0),
(6, 5, 315, 1439136132, 1439136935, 'AT00005', 14, 'e-learning', 'img022.jpg', 'logo/img022.jpg', 2, 0),
(7, 5, 315, 1439137603, 1439138752, 'AT00007', 12, 'In-person desc', '20150210_112223.jpg', 'logo/20150210_112223.jpg', 2, 0),
(8, 5, 315, 1439138700, 1439138731, 'AT00008', 17, 'xxx', '10799457_814800238583816_1709259_n.jpg', 'logo/10799457_814800238583816_1709259_n.jpg', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_cifasupport_attachment`
--
ALTER TABLE `mdl_cifasupport_attachment`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_cifasupport_attachment`
--
ALTER TABLE `mdl_cifasupport_attachment`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
