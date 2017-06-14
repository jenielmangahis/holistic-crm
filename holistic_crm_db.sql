-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 14, 2017 at 11:08 AM
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
(1, NULL, NULL, NULL, 'controllers', 1, 310),
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
(35, 1, NULL, NULL, 'Pages', 70, 89),
(36, 35, NULL, NULL, 'index', 71, 72),
(37, 35, NULL, NULL, 'view', 73, 74),
(38, 35, NULL, NULL, 'add', 75, 76),
(39, 35, NULL, NULL, 'edit', 77, 78),
(40, 35, NULL, NULL, 'delete', 79, 80),
(41, 35, NULL, NULL, 'isAuthorized', 81, 82),
(42, 1, NULL, NULL, 'Slides', 90, 109),
(43, 42, NULL, NULL, 'index', 91, 92),
(44, 42, NULL, NULL, 'view', 93, 94),
(45, 42, NULL, NULL, 'add', 95, 96),
(46, 42, NULL, NULL, 'edit', 97, 98),
(47, 42, NULL, NULL, 'delete', 99, 100),
(48, 42, NULL, NULL, 'isAuthorized', 101, 102),
(51, 1, NULL, NULL, 'Careers', 110, 129),
(52, 51, NULL, NULL, 'index', 111, 112),
(53, 51, NULL, NULL, 'view', 113, 114),
(54, 51, NULL, NULL, 'add', 115, 116),
(55, 51, NULL, NULL, 'edit', 117, 118),
(56, 51, NULL, NULL, 'delete', 119, 120),
(57, 51, NULL, NULL, 'isAuthorized', 121, 122),
(58, 1, NULL, NULL, 'Debug', 130, 137),
(59, 58, NULL, NULL, 'debugFtpGet', 131, 132),
(60, 58, NULL, NULL, 'debugThreaded', 133, 134),
(61, 58, NULL, NULL, 'isAuthorized', 135, 136),
(62, 1, NULL, NULL, 'Profile', 138, 149),
(63, 62, NULL, NULL, 'index', 139, 140),
(64, 62, NULL, NULL, 'edit', 141, 142),
(65, 62, NULL, NULL, 'change_profile_photo', 143, 144),
(66, 62, NULL, NULL, 'isAuthorized', 145, 146),
(67, 1, NULL, NULL, 'ResetPassword', 150, 155),
(68, 67, NULL, NULL, 'index', 151, 152),
(69, 67, NULL, NULL, 'isAuthorized', 153, 154),
(70, 1, NULL, NULL, 'Services', 156, 175),
(71, 70, NULL, NULL, 'index', 157, 158),
(72, 70, NULL, NULL, 'view', 159, 160),
(73, 70, NULL, NULL, 'add', 161, 162),
(74, 70, NULL, NULL, 'edit', 163, 164),
(75, 70, NULL, NULL, 'delete', 165, 166),
(76, 70, NULL, NULL, 'isAuthorized', 167, 168),
(77, 1, NULL, NULL, 'UserEntities', 176, 197),
(78, 77, NULL, NULL, 'index', 177, 178),
(79, 77, NULL, NULL, 'view', 179, 180),
(80, 77, NULL, NULL, 'add', 181, 182),
(81, 77, NULL, NULL, 'edit', 183, 184),
(82, 77, NULL, NULL, 'delete', 185, 186),
(83, 77, NULL, NULL, 'agency_users', 187, 188),
(84, 77, NULL, NULL, 'agency_add', 189, 190),
(85, 77, NULL, NULL, 'agency_edit', 191, 192),
(86, 77, NULL, NULL, 'agency_delete', 193, 194),
(87, 77, NULL, NULL, 'isAuthorized', 195, 196),
(88, 35, NULL, NULL, 'publish', 83, 84),
(89, 35, NULL, NULL, 'unpublish', 85, 86),
(90, 70, NULL, NULL, 'publish', 169, 170),
(91, 70, NULL, NULL, 'unpublish', 171, 172),
(92, 1, NULL, NULL, 'CompanyDetails', 198, 211),
(93, 92, NULL, NULL, 'index', 199, 200),
(94, 92, NULL, NULL, 'view', 201, 202),
(95, 92, NULL, NULL, 'add', 203, 204),
(96, 92, NULL, NULL, 'edit', 205, 206),
(97, 92, NULL, NULL, 'delete', 207, 208),
(98, 92, NULL, NULL, 'isAuthorized', 209, 210),
(99, 1, NULL, NULL, 'Plans', 212, 231),
(100, 99, NULL, NULL, 'index', 213, 214),
(101, 99, NULL, NULL, 'view', 215, 216),
(102, 99, NULL, NULL, 'add', 217, 218),
(103, 99, NULL, NULL, 'edit', 219, 220),
(104, 99, NULL, NULL, 'delete', 221, 222),
(105, 99, NULL, NULL, 'isAuthorized', 223, 224),
(106, 42, NULL, NULL, 'jsonUpdateSort', 103, 104),
(107, 42, NULL, NULL, 'publish', 105, 106),
(108, 42, NULL, NULL, 'unpublish', 107, 108),
(109, 51, NULL, NULL, 'publish', 123, 124),
(110, 51, NULL, NULL, 'unpublish', 125, 126),
(111, 51, NULL, NULL, 'frontview', 127, 128),
(112, 35, NULL, NULL, 'frontview', 87, 88),
(113, 70, NULL, NULL, 'frontview', 173, 174),
(114, 1, NULL, NULL, 'MenuItems', 232, 249),
(115, 114, NULL, NULL, 'index', 233, 234),
(116, 114, NULL, NULL, 'view', 235, 236),
(117, 114, NULL, NULL, 'add', 237, 238),
(118, 114, NULL, NULL, 'edit', 239, 240),
(119, 114, NULL, NULL, 'delete', 241, 242),
(120, 114, NULL, NULL, 'isAuthorized', 243, 244),
(121, 1, NULL, NULL, 'Menus', 250, 263),
(122, 121, NULL, NULL, 'index', 251, 252),
(123, 121, NULL, NULL, 'view', 253, 254),
(124, 121, NULL, NULL, 'add', 255, 256),
(125, 121, NULL, NULL, 'edit', 257, 258),
(126, 121, NULL, NULL, 'delete', 259, 260),
(127, 121, NULL, NULL, 'isAuthorized', 261, 262),
(128, 99, NULL, NULL, 'publish', 225, 226),
(129, 99, NULL, NULL, 'unpublish', 227, 228),
(130, 99, NULL, NULL, 'frontview', 229, 230),
(131, 114, NULL, NULL, 'jsonUpdateSort', 245, 246),
(132, 114, NULL, NULL, 'update', 247, 248),
(133, 1, NULL, NULL, 'PlanGroups', 264, 277),
(134, 133, NULL, NULL, 'index', 265, 266),
(135, 133, NULL, NULL, 'view', 267, 268),
(136, 133, NULL, NULL, 'add', 269, 270),
(137, 133, NULL, NULL, 'edit', 271, 272),
(138, 133, NULL, NULL, 'delete', 273, 274),
(139, 133, NULL, NULL, 'isAuthorized', 275, 276),
(140, 1, NULL, NULL, 'PlanCategories', 278, 293),
(141, 140, NULL, NULL, 'index', 279, 280),
(142, 140, NULL, NULL, 'view', 281, 282),
(143, 140, NULL, NULL, 'add', 283, 284),
(144, 140, NULL, NULL, 'edit', 285, 286),
(145, 140, NULL, NULL, 'delete', 287, 288),
(146, 140, NULL, NULL, 'isAuthorized', 289, 290),
(147, 62, NULL, NULL, 'change_password', 147, 148),
(148, 140, NULL, NULL, 'frontview', 291, 292),
(149, 14, NULL, NULL, 'request_forgot_password', 45, 46),
(150, 1, NULL, NULL, 'Widgets', 294, 309),
(151, 150, NULL, NULL, 'index', 295, 296),
(152, 150, NULL, NULL, 'view', 297, 298),
(153, 150, NULL, NULL, 'add', 299, 300),
(154, 150, NULL, NULL, 'edit', 301, 302),
(155, 150, NULL, NULL, 'delete', 303, 304),
(156, 150, NULL, NULL, 'isAuthorized', 305, 306),
(157, 150, NULL, NULL, 'update', 307, 308);

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
(1, 'Type01', '2017-06-14 16:55:03', '2017-06-14 16:55:03');

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
(1, 'test', '2017-06-14 17:01:12', '2017-06-14 17:01:12');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
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
-- AUTO_INCREMENT for table `lead_types`
--
ALTER TABLE `lead_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
