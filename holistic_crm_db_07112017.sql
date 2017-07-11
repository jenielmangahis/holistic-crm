-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 11, 2017 at 12:14 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `holistic_crm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_phinxlog`
--

DROP TABLE IF EXISTS `acl_phinxlog`;
CREATE TABLE `acl_phinxlog` (
  `version` bigint(20) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
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
CREATE TABLE `acos` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(34, 1, NULL, NULL, 'Migrations', 52, 53),
(58, 1, NULL, NULL, 'Debug', 54, 61),
(59, 58, NULL, NULL, 'debugFtpGet', 55, 56),
(60, 58, NULL, NULL, 'debugThreaded', 57, 58),
(61, 58, NULL, NULL, 'isAuthorized', 59, 60),
(62, 1, NULL, NULL, 'Profile', 62, 73),
(63, 62, NULL, NULL, 'index', 63, 64),
(64, 62, NULL, NULL, 'edit', 65, 66),
(65, 62, NULL, NULL, 'change_profile_photo', 67, 68),
(66, 62, NULL, NULL, 'isAuthorized', 69, 70),
(67, 1, NULL, NULL, 'ResetPassword', 74, 79),
(68, 67, NULL, NULL, 'index', 75, 76),
(69, 67, NULL, NULL, 'isAuthorized', 77, 78),
(147, 62, NULL, NULL, 'change_password', 71, 72),
(149, 14, NULL, NULL, 'request_forgot_password', 45, 46),
(158, 1, NULL, NULL, 'Allocations', 80, 93),
(159, 158, NULL, NULL, 'index', 81, 82),
(160, 158, NULL, NULL, 'view', 83, 84),
(161, 158, NULL, NULL, 'add', 85, 86),
(162, 158, NULL, NULL, 'edit', 87, 88),
(163, 158, NULL, NULL, 'delete', 89, 90),
(164, 158, NULL, NULL, 'isAuthorized', 91, 92),
(165, 1, NULL, NULL, 'LeadTypes', 94, 107),
(166, 165, NULL, NULL, 'index', 95, 96),
(167, 165, NULL, NULL, 'view', 97, 98),
(168, 165, NULL, NULL, 'add', 99, 100),
(169, 165, NULL, NULL, 'edit', 101, 102),
(170, 165, NULL, NULL, 'delete', 103, 104),
(171, 165, NULL, NULL, 'isAuthorized', 105, 106),
(172, 1, NULL, NULL, 'Sources', 108, 121),
(173, 172, NULL, NULL, 'index', 109, 110),
(174, 172, NULL, NULL, 'view', 111, 112),
(175, 172, NULL, NULL, 'add', 113, 114),
(176, 172, NULL, NULL, 'edit', 115, 116),
(177, 172, NULL, NULL, 'delete', 117, 118),
(178, 172, NULL, NULL, 'isAuthorized', 119, 120),
(179, 1, NULL, NULL, 'Statuses', 122, 135),
(180, 179, NULL, NULL, 'index', 123, 124),
(181, 179, NULL, NULL, 'view', 125, 126),
(182, 179, NULL, NULL, 'add', 127, 128),
(183, 179, NULL, NULL, 'edit', 129, 130),
(184, 179, NULL, NULL, 'delete', 131, 132),
(185, 179, NULL, NULL, 'isAuthorized', 133, 134),
(186, 1, NULL, NULL, 'Leads', 136, 151),
(187, 186, NULL, NULL, 'index', 137, 138),
(188, 186, NULL, NULL, 'view', 139, 140),
(189, 186, NULL, NULL, 'add', 141, 142),
(190, 186, NULL, NULL, 'edit', 143, 144),
(191, 186, NULL, NULL, 'delete', 145, 146),
(192, 186, NULL, NULL, 'isAuthorized', 147, 148),
(193, 1, NULL, NULL, 'InterestTypes', 152, 165),
(194, 193, NULL, NULL, 'index', 153, 154),
(195, 193, NULL, NULL, 'view', 155, 156),
(196, 193, NULL, NULL, 'add', 157, 158),
(197, 193, NULL, NULL, 'edit', 159, 160),
(198, 193, NULL, NULL, 'delete', 161, 162),
(199, 193, NULL, NULL, 'isAuthorized', 163, 164),
(200, 186, NULL, NULL, 'register', 149, 150);

-- --------------------------------------------------------

--
-- Table structure for table `allocations`
--

DROP TABLE IF EXISTS `allocations`;
CREATE TABLE `allocations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `allocations`
--

INSERT INTO `allocations` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Allocation A', '2017-06-20 12:37:09', '2017-06-20 12:37:09'),
(2, 'Allocation B', '2017-06-20 12:37:25', '2017-06-20 12:37:25'),
(3, 'Test01', '2017-06-21 11:50:40', '2017-06-21 11:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
CREATE TABLE `aros` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL,
  `aro_id` int(11) NOT NULL,
  `aco_id` int(11) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(180) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Master Admin', '2016-01-08 03:01:24', '2016-07-24 19:53:52'),
(2, 'User', '2016-01-08 03:01:33', '2016-07-24 19:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `interest_types`
--

DROP TABLE IF EXISTS `interest_types`;
CREATE TABLE `interest_types` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `interest_types`
--

INSERT INTO `interest_types` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Interest Type A', '2017-06-20 12:37:33', '2017-06-20 12:37:33'),
(2, 'Interest Type B', '2017-06-20 12:37:37', '2017-06-20 12:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `allocation_id` int(11) NOT NULL,
  `allocation_date` date NOT NULL,
  `firstname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `lead_action` text CHARACTER SET ucs2 COLLATE ucs2_unicode_ci,
  `city` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `interest_type_id` int(11) NOT NULL,
  `followup_date` date NOT NULL,
  `followup_action_reminder_date` date NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `status_id`, `source_id`, `allocation_id`, `allocation_date`, `firstname`, `surname`, `email`, `phone`, `address`, `lead_action`, `city`, `state`, `interest_type_id`, `followup_date`, `followup_action_reminder_date`, `notes`, `created`, `modified`) VALUES
(1, 1, 2, 1, '2017-07-05', 'Bry', 'Yobi', 'bryyobi@gmail.com', '5454', 'This is my address', 'This is a testing phase, test update again please', 'City01', 'California', 1, '2017-07-20', '2017-07-21', '<p>dfdf</p>\r\n', '2017-06-21 16:10:08', '2017-07-11 03:13:43'),
(2, 2, 4, 3, '2017-06-22', 'Test', 'Name', 'test@test.com', '5118969', 'This is the address', '', 'City02', 'FC', 0, '2017-06-07', '2017-06-07', '<p>Test</p>\r\n', '2017-06-21 16:10:52', '2017-06-21 16:10:52'),
(3, 2, 2, 1, '2017-07-11', 'Bry', 'Bio', 'brybio@gmail.com', '5114879', 'This is my address', 'Test', 'City01', 'ST01', 1, '2017-07-18', '2017-07-18', '<p>This is only a test...</p>\r\n', '2017-07-11 16:24:29', '2017-07-11 16:54:53'),
(4, 1, 2, 1, '2017-07-11', 'ggfg', 'fgfg', 'brybioxxx@gmail.com', '', 'This is the address', NULL, '', '', 2, '2017-07-26', '2017-07-27', '<p>sdfsdfsd</p>\r\n', '2017-07-11 16:40:44', '2017-07-11 16:44:47'),
(5, 1, 2, 1, '2017-07-11', 'Jen', 'Bio', 'jenbio@test.com', '5114885', '', 'test', '', '', 1, '2017-07-12', '2017-07-20', '<p>dfdsf</p>\r\n', '2017-07-11 16:56:19', '2017-07-11 16:57:21'),
(6, 1, 2, 1, '2017-07-10', 'Test Date', 'Bio', 'bio@test.com', '5118596', 'This is my address', 'Test', '', '', 1, '2017-07-27', '2017-07-28', '<p>Testing</p>\r\n', '2017-07-11 03:01:40', '2017-07-11 03:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `lead_types`
--

DROP TABLE IF EXISTS `lead_types`;
CREATE TABLE `lead_types` (
  `id` int(11) NOT NULL,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `lead_types`
--

INSERT INTO `lead_types` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Lead Type A', '2017-06-14 16:55:03', '2017-06-20 12:37:53'),
(2, 'Lead Type B', '2017-06-20 12:37:46', '2017-06-20 12:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
CREATE TABLE `sources` (
  `id` int(11) NOT NULL,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`, `created`, `modified`) VALUES
(2, 'Source A', '2017-06-20 12:36:54', '2017-06-20 12:36:54'),
(3, 'Source B', '2017-06-20 12:36:59', '2017-06-20 12:36:59'),
(4, 'Test 01', '2017-06-21 15:19:38', '2017-06-21 15:19:38'),
(5, 'Test 02', '2017-06-21 15:19:46', '2017-06-21 15:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(180) COLLATE utf16_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Status A', '2017-06-20 12:38:13', '2017-06-20 12:38:13'),
(2, 'Status B', '2017-06-20 12:38:18', '2017-06-20 12:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `username`, `password`, `photo`, `group_id`, `reset_code`, `created`, `modified`) VALUES
(1, 'Holistic', 'Holistic', 'Holistic', 'admin@holisticwebpresence.com', 'admin', '$2y$10$mYGUizPndXHwttfHVUDAmuKng4jNGZI4O0PicQMFlQRvI.sEMphB6', '1496085384_579772.jpg', 1, NULL, '2016-01-08 03:01:56', '2017-06-01 04:16:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acl_phinxlog`
--
ALTER TABLE `acl_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `acos`
--
ALTER TABLE `acos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lft` (`lft`,`rght`),
  ADD KEY `alias` (`alias`);

--
-- Indexes for table `allocations`
--
ALTER TABLE `allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lft` (`lft`,`rght`),
  ADD KEY `alias` (`alias`);

--
-- Indexes for table `aros_acos`
--
ALTER TABLE `aros_acos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aro_id` (`aro_id`,`aco_id`),
  ADD KEY `aco_id` (`aco_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interest_types`
--
ALTER TABLE `interest_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_types`
--
ALTER TABLE `lead_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `allocations`
--
ALTER TABLE `allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `interest_types`
--
ALTER TABLE `interest_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `lead_types`
--
ALTER TABLE `lead_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
