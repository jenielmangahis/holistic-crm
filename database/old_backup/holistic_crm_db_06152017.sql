-- phpMyAdmin SQL Dump
-- version 4.0.10.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2017 at 02:56 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `holistic_crm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_phinxlog`
--

DROP TABLE IF EXISTS `acl_phinxlog`;
CREATE TABLE IF NOT EXISTS `acl_phinxlog` (
  `version` bigint(20) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acl_phinxlog`
--

INSERT INTO `acl_phinxlog` (`version`, `start_time`, `end_time`) VALUES
(20141229162641, '2016-01-07 18:56:40', '2016-01-07 18:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=193 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 166),
(2, 1, NULL, NULL, 'Groups', 2, 15),
(3, 2, NULL, NULL, 'index', 3, 4),
(4, 2, NULL, NULL, 'view', 5, 6),
(5, 2, NULL, NULL, 'add', 7, 8),
(6, 2, NULL, NULL, 'edit', 9, 10),
(7, 2, NULL, NULL, 'delete', 11, 12),
(8, 2, NULL, NULL, 'isAuthorized', 13, 14),
(9, 1, NULL, NULL, 'Main', 16, 25),
(10, 9, NULL, NULL, 'index', 17, 18),
(11, 9, NULL, NULL, 'filter', 19, 20),
(12, 9, NULL, NULL, 'isAuthorized', 21, 22),
(13, 9, NULL, NULL, 'cell', 23, 24),
(14, 1, NULL, NULL, 'Users', 26, 47),
(15, 14, NULL, NULL, 'index', 27, 28),
(16, 14, NULL, NULL, 'dashboard', 29, 30),
(17, 14, NULL, NULL, 'view', 31, 32),
(18, 14, NULL, NULL, 'add', 33, 34),
(19, 14, NULL, NULL, 'edit', 35, 36),
(20, 14, NULL, NULL, 'delete', 37, 38),
(21, 14, NULL, NULL, 'login', 39, 40),
(22, 14, NULL, NULL, 'logout', 41, 42),
(23, 14, NULL, NULL, 'isAuthorized', 43, 44),
(24, 1, NULL, NULL, 'Acl', 48, 49),
(25, 1, NULL, NULL, 'Bake', 50, 51),
(26, 1, NULL, NULL, 'DebugKit', 52, 67),
(27, 26, NULL, NULL, 'Panels', 53, 58),
(28, 27, NULL, NULL, 'index', 54, 55),
(29, 27, NULL, NULL, 'view', 56, 57),
(30, 26, NULL, NULL, 'Requests', 59, 62),
(31, 30, NULL, NULL, 'view', 60, 61),
(32, 26, NULL, NULL, 'Toolbar', 63, 66),
(33, 32, NULL, NULL, 'clearCache', 64, 65),
(34, 1, NULL, NULL, 'Migrations', 68, 69),
(58, 1, NULL, NULL, 'Debug', 70, 77),
(59, 58, NULL, NULL, 'debugFtpGet', 71, 72),
(60, 58, NULL, NULL, 'debugThreaded', 73, 74),
(61, 58, NULL, NULL, 'isAuthorized', 75, 76),
(62, 1, NULL, NULL, 'Profile', 78, 89),
(63, 62, NULL, NULL, 'index', 79, 80),
(64, 62, NULL, NULL, 'edit', 81, 82),
(65, 62, NULL, NULL, 'change_profile_photo', 83, 84),
(66, 62, NULL, NULL, 'isAuthorized', 85, 86),
(67, 1, NULL, NULL, 'ResetPassword', 90, 95),
(68, 67, NULL, NULL, 'index', 91, 92),
(69, 67, NULL, NULL, 'isAuthorized', 93, 94),
(147, 62, NULL, NULL, 'change_password', 87, 88),
(149, 14, NULL, NULL, 'request_forgot_password', 45, 46),
(158, 1, NULL, NULL, 'Allocations', 96, 109),
(159, 158, NULL, NULL, 'index', 97, 98),
(160, 158, NULL, NULL, 'view', 99, 100),
(161, 158, NULL, NULL, 'add', 101, 102),
(162, 158, NULL, NULL, 'edit', 103, 104),
(163, 158, NULL, NULL, 'delete', 105, 106),
(164, 158, NULL, NULL, 'isAuthorized', 107, 108),
(165, 1, NULL, NULL, 'LeadTypes', 110, 123),
(166, 165, NULL, NULL, 'index', 111, 112),
(167, 165, NULL, NULL, 'view', 113, 114),
(168, 165, NULL, NULL, 'add', 115, 116),
(169, 165, NULL, NULL, 'edit', 117, 118),
(170, 165, NULL, NULL, 'delete', 119, 120),
(171, 165, NULL, NULL, 'isAuthorized', 121, 122),
(172, 1, NULL, NULL, 'Sources', 124, 137),
(173, 172, NULL, NULL, 'index', 125, 126),
(174, 172, NULL, NULL, 'view', 127, 128),
(175, 172, NULL, NULL, 'add', 129, 130),
(176, 172, NULL, NULL, 'edit', 131, 132),
(177, 172, NULL, NULL, 'delete', 133, 134),
(178, 172, NULL, NULL, 'isAuthorized', 135, 136),
(179, 1, NULL, NULL, 'Statuses', 138, 151),
(180, 179, NULL, NULL, 'index', 139, 140),
(181, 179, NULL, NULL, 'view', 141, 142),
(182, 179, NULL, NULL, 'add', 143, 144),
(183, 179, NULL, NULL, 'edit', 145, 146),
(184, 179, NULL, NULL, 'delete', 147, 148),
(185, 179, NULL, NULL, 'isAuthorized', 149, 150),
(186, 1, NULL, NULL, 'Leads', 152, 165),
(187, 186, NULL, NULL, 'index', 153, 154),
(188, 186, NULL, NULL, 'view', 155, 156),
(189, 186, NULL, NULL, 'add', 157, 158),
(190, 186, NULL, NULL, 'edit', 159, 160),
(191, 186, NULL, NULL, 'delete', 161, 162),
(192, 186, NULL, NULL, 'isAuthorized', 163, 164);

-- --------------------------------------------------------

--
-- Table structure for table `allocations`
--

DROP TABLE IF EXISTS `allocations`;
CREATE TABLE IF NOT EXISTS `allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`,`rght`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Groups', 1, NULL, 1, 8),
(2, NULL, 'Groups', 2, NULL, 9, 12),
(3, 1, 'Users', 1, NULL, 6, 7),
(4, NULL, 'Groups', 3, NULL, 13, 14),
(5, NULL, 'Groups', 4, NULL, 15, 16),
(6, 2, 'Users', 2, NULL, 10, 11),
(7, 1, 'Users', 3, NULL, 2, 3),
(8, 1, 'Users', 4, NULL, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) NOT NULL,
  `aco_id` int(11) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `aro_id` (`aro_id`,`aco_id`),
  KEY `aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Master Admin', '2016-01-08 03:01:24', '2016-07-24 19:53:52'),
(2, 'User', '2016-01-08 03:01:33', '2016-07-24 19:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `allocation_id` int(11) NOT NULL,
  `allocation_date` date NOT NULL,
  `firstname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `interest_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `followup_date` date NOT NULL,
  `followup_action_reminder_date` date NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lead_types`
--

DROP TABLE IF EXISTS `lead_types`;
CREATE TABLE IF NOT EXISTS `lead_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lead_types`
--

INSERT INTO `lead_types` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Type01', '2017-06-14 16:55:03', '2017-06-14 16:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
CREATE TABLE IF NOT EXISTS `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`, `created`, `modified`) VALUES
(1, 'test', '2017-06-14 17:01:12', '2017-06-14 17:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `photo` text COLLATE utf8_unicode_ci,
  `group_id` int(11) NOT NULL,
  `reset_code` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `username`, `password`, `photo`, `group_id`, `reset_code`, `created`, `modified`) VALUES
(1, 'Holistic', 'Holistic', 'Holistic', 'admin@holisticwebpresence.com', 'admin', '$2y$10$mYGUizPndXHwttfHVUDAmuKng4jNGZI4O0PicQMFlQRvI.sEMphB6', '1496085384_579772.jpg', 1, NULL, '2016-01-08 03:01:56', '2017-06-01 04:16:21');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
