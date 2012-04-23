-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2012 at 03:06 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xtable`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_class`
--

CREATE TABLE IF NOT EXISTS `table_class` (
  `class_id` int(3) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `table_class`
--

INSERT INTO `table_class` (`class_id`, `class_name`) VALUES
(1, 'Data Handling'),
(3, 'Exception Handling'),
(4, 'Functional'),
(6, 'Performance'),
(7, 'Boundary'),
(8, 'UI'),
(9, 'Usability');

-- --------------------------------------------------------

--
-- Table structure for table `table_client`
--

CREATE TABLE IF NOT EXISTS `table_client` (
  `client_id` int(5) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(48) DEFAULT NULL,
  `client_status` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `table_client`
--

INSERT INTO `table_client` (`client_id`, `client_name`, `client_status`) VALUES
(1, 'Training', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `table_devgroup`
--

CREATE TABLE IF NOT EXISTS `table_devgroup` (
  `devgroup_id` int(2) NOT NULL AUTO_INCREMENT,
  `devgroup_name` varchar(25) NOT NULL,
  PRIMARY KEY (`devgroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `table_devgroup`
--

INSERT INTO `table_devgroup` (`devgroup_id`, `devgroup_name`) VALUES
(1, 'Android'),
(2, 'Apple'),
(3, 'BlackBerry'),
(4, 'Google'),
(5, 'Microsoft'),
(6, 'Mozilla'),
(7, 'Other'),
(8, 'Windows'),
(9, 'NCR');

-- --------------------------------------------------------

--
-- Table structure for table `table_device`
--

CREATE TABLE IF NOT EXISTS `table_device` (
  `device_id` int(3) NOT NULL AUTO_INCREMENT,
  `device_type_id` int(2) DEFAULT NULL,
  `device_group_id` int(2) DEFAULT NULL,
  `device_name` varchar(50) DEFAULT NULL,
  `device_version` varchar(75) DEFAULT NULL,
  `device_mac` varchar(50) NOT NULL,
  `device_udid` varchar(50) NOT NULL,
  `device_serial` varchar(50) NOT NULL,
  `device_location_id` int(1) NOT NULL,
  PRIMARY KEY (`device_id`),
  KEY `device_type_id` (`device_type_id`),
  KEY `device_group_id` (`device_group_id`),
  KEY `device_location_id` (`device_location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176 ;

--
-- Dumping data for table `table_device`
--

INSERT INTO `table_device` (`device_id`, `device_type_id`, `device_group_id`, `device_name`, `device_version`, `device_mac`, `device_udid`, `device_serial`, `device_location_id`) VALUES
(1, 2, 1, 'HTC EVO 4G', 'Android 2.3.3', '', '', '', 1),
(2, 2, 1, 'HTC EVO SHIFT 4G', 'Android 2.2', '', '', '', 1),
(3, 2, 1, 'HTC Incredible', 'Android 2.2', '', '', '', 1),
(4, 2, 1, 'HTC Nexus One', 'Android 2.3.3', '', '', '', 1),
(5, 2, 1, 'HTC Wildfire', 'Android 2.1-update 1', '', '', '', 1),
(6, 2, 1, 'Motorola Atrix', 'Android 2.2.1', '', '', '', 1),
(7, 2, 1, 'Motorola Droid', 'Android 2.1-update 1', '', '', '', 1),
(8, 2, 1, 'Motorola Droid X', 'Android 2.2.1', '', '', '', 1),
(9, 2, 1, 'Samsung Galaxy S - Captivate', 'Android 2.1-update 1', '', '', '', 1),
(10, 2, 2, 'iPhone 2G - I', 'iOS 3.1.3', '', '', '', 1),
(11, 2, 2, 'iPhone 2G - L', 'iOS 3.1.3', '', '', '', 1),
(12, 2, 2, 'iPhone 3G - M', 'iOS 4.2.3', '', '', '', 1),
(13, 2, 2, 'iPhone 4 - J', 'iOS 4.3.3', '', '', '', 1),
(14, 2, 2, 'iPhone 4 - D', 'iOS 4.2.1', '', '', '', 1),
(15, 2, 2, 'iPhone 4 - H', 'iOS 4.3.2', '', '', '', 1),
(16, 2, 2, 'iPhone 4 - K', 'iOS 4.3.3', '', '', '', 1),
(17, 2, 2, 'iPod Touch - A', 'iOS 4.2.1', '', '', '', 1),
(18, 2, 2, 'iPod Touch - B', 'iOS 5.0.1', '', '', '', 1),
(19, 2, 2, 'iPod Touch - C', 'iOS 3.1.3', '', '', '', 1),
(20, 2, 2, 'iPod Touch - F', 'iOS 4.1', '', '', '', 1),
(21, 2, 2, 'iPod Touch - G', 'iOS 4.3', '', '', '', 1),
(22, 2, 3, 'BlackBerry Bold 9650', 'v.5.0', '', '', '', 1),
(23, 2, 3, 'Blackberry Bold 9700', 'v.6.0', '', '', '', 1),
(24, 2, 3, 'Blackberry Curve 8300', 'v4.2.2.166', '', '', '', 1),
(25, 2, 3, 'Blackberry Curve 8320', 'v4.5.0.81', '', '', '', 1),
(26, 2, 3, 'Blackberry Curve 8520', 'v.5.0.0.822', '', '', '', 1),
(27, 2, 3, 'Blackberry Curve 8900', 'v.5.0.0.822', '', '', '', 1),
(28, 2, 3, 'Blackberry Pearl 8110', 'v4.2.1.107', '', '', '', 1),
(29, 2, 3, 'Blackberry Pearl 8130', 'v4.5.0.182', '', '', '', 1),
(30, 2, 3, 'Blackberry Storm 2 9550', 'v5.0.0.713', '', '', '', 1),
(31, 2, 3, 'Blackberry Torch 9800 - A', 'v6.0.0.141', '', '', '', 1),
(32, 2, 3, 'Blackberry Torch 9800 - B', 'v6.0.0.246', '', '', '', 1),
(33, 2, 3, 'Blackberry Torch 9800 - C', 'v6.0.0.246', '', '', '', 1),
(34, 1, 4, 'Chrome', '1', '', '', '', 1),
(35, 1, 6, 'FireFox', '1', '', '', '', 1),
(36, 1, 2, 'Safari', '1', '', '', '', 1),
(37, 2, 7, 'HP Palm Pre', 'hp Web OS 1.2.1', '', '', '', 1),
(38, 2, 7, 'HP Palm Pre 2', 'HP WebOS 2.0', '', '', '', 1),
(39, 2, 7, 'LG KP 500 Cookie GSM', 'N/A', '', '', '', 1),
(40, 2, 7, 'Nokia N97 EU Multimedia Black', 'N/A', '', '', '', 1),
(41, 2, 7, 'Sony Ericcson T610', 'N/A', '', '', '', 1),
(42, 2, 7, 'Sony Ericcson W580 Black', 'N/A', '', '', '', 1),
(43, 2, 7, 'Samsung Tocco Lite S5230 Blac', 'N/A', '', '', '', 1),
(44, 3, 3, 'Blackberry Playbook', 'BBTOS 1.0', '', '', '', 1),
(45, 3, 1, 'Dell Streak', 'Android 1.6', '', '', '', 1),
(46, 3, 2, 'iPad - QA', 'OS 3.2.2', '', '', '', 1),
(47, 3, 2, 'iPad 2 - QA', 'iOS 4.3.3', '', '', '', 1),
(48, 3, 1, 'Motorola Xoom', 'Android 3.0.1', '', '', '', 1),
(49, 3, 1, 'Samsung Galaxy Tab', 'Android 2.2', '', '', '', 1),
(50, 2, 8, 'HTC HD2', 'Windows Mobile OS 5.2', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_devtype`
--

CREATE TABLE IF NOT EXISTS `table_devtype` (
  `devtype_id` int(11) NOT NULL AUTO_INCREMENT,
  `devtype_name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`devtype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `table_devtype`
--

INSERT INTO `table_devtype` (`devtype_id`, `devtype_name`) VALUES
(1, 'Browser'),
(2, 'Phone'),
(3, 'Tablet'),
(4, 'Accessories'),
(5, 'Kiosk');

-- --------------------------------------------------------

--
-- Table structure for table `table_location`
--

CREATE TABLE IF NOT EXISTS `table_location` (
  `location_id` int(5) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(40) DEFAULT NULL,
  `location_abbr` varchar(5) DEFAULT NULL,
  `location_city` varchar(40) DEFAULT NULL,
  `location_country` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `table_location`
--

INSERT INTO `table_location` (`location_id`, `location_name`, `location_abbr`, `location_city`, `location_country`) VALUES
(1, 'New York', 'NY', 'New York', 'United States of America'),
(2, 'London', 'LD', 'London', 'United Kingdom'),
(3, 'Dhaka', 'BD', 'Dhaka', 'Bangladesh'),
(4, 'Italy', 'IT', 'Udine', 'Italy');

-- --------------------------------------------------------

--
-- Table structure for table `table_manual`
--

CREATE TABLE IF NOT EXISTS `table_manual` (
  `manual_id` int(6) NOT NULL AUTO_INCREMENT,
  `manual_tcid` decimal(10,2) DEFAULT NULL,
  `manual_relation_id` int(5) DEFAULT NULL,
  `manual_function_name` varchar(50) DEFAULT NULL,
  `manual_name` varchar(150) DEFAULT NULL,
  `manual_priority_id` int(1) NOT NULL,
  `manual_class_id` int(1) DEFAULT NULL,
  `manual_prereq` varchar(255) DEFAULT NULL,
  `manual_steps` text,
  `manual_expected` text,
  `manual_bdd` text,
  `manual_start` varchar(10) NOT NULL,
  `manual_end` varchar(10) NOT NULL,
  `manual_pauseduration` varchar(10) NOT NULL DEFAULT '0',
  `manual_pausecount` varchar(2) NOT NULL DEFAULT '0',
  `manual_status` int(1) DEFAULT NULL,
  `manual_author_id` int(4) DEFAULT NULL,
  PRIMARY KEY (`manual_id`),
  KEY `manual_class_id` (`manual_class_id`),
  KEY `manual_author_id` (`manual_author_id`),
  KEY `manual_relation_id` (`manual_relation_id`),
  KEY `manual_priority_id` (`manual_priority_id`),
  KEY `manual_status` (`manual_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `table_manual`
--

INSERT INTO `table_manual` (`manual_id`, `manual_tcid`, `manual_relation_id`, `manual_function_name`, `manual_name`, `manual_priority_id`, `manual_class_id`, `manual_prereq`, `manual_steps`, `manual_expected`, `manual_start`, `manual_end`, `manual_pauseduration`, `manual_pausecount`, `manual_status`, `manual_author_id`, `manual_bdd`) VALUES
(1, 1.01, 1, 'FUNCTION ONE', 'Test case example', 1, 1, 'This is an example of a test case.', 'Please create more test cases.', 'All fields are required at this time.', '1334330105', '1334330162', '0', '0', 1, 1, NULL),
(2, 2.01, 1, 'GENERAL INSTRUCTIONS', 'General Instructions', 1, 4, 'In case you didn''t read the README file, please see the instructions below.', 'Create more verticals, clients, and projects via the Administration section.\nManage users via the User Admin section.\nConfigure and manage testing devices (browsers, phones, tablets, internal systems, etc...) via the Device Admin section.\n', 'The README file has more information.', '1334330556', '1334330704', '0', '0', 1, 1, NULL),
(3, 3.01, 1, 'Testing Functions', 'Testing', 3, 6, 'Testing', 'Testing another thing', 'Testing', '1334933017', '1334933071', '0', '0', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_manual_exec`
--

CREATE TABLE IF NOT EXISTS `table_manual_exec` (
  `exec_id` int(10) NOT NULL AUTO_INCREMENT,
  `exec_manual_id` int(6) NOT NULL,
  `exec_creator_id` int(4) NOT NULL,
  `exec_device_id` int(3) DEFAULT NULL,
  `exec_create_date` varchar(10) NOT NULL,
  `exec_user_id` int(4) DEFAULT NULL,
  `exec_start` varchar(10) NOT NULL,
  `exec_end` varchar(10) NOT NULL,
  `exec_pauseduration` varchar(10) NOT NULL DEFAULT '0',
  `exec_pausecount` varchar(2) NOT NULL DEFAULT '0',
  `exec_result` int(1) DEFAULT NULL,
  `exec_device_version` varchar(75) NOT NULL,
  PRIMARY KEY (`exec_id`),
  KEY `exec_manual_id` (`exec_manual_id`),
  KEY `exec_creator_id` (`exec_creator_id`),
  KEY `exec_device_id` (`exec_device_id`),
  KEY `exec_user_id` (`exec_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `table_manual_exec`
--


-- --------------------------------------------------------

--
-- Table structure for table `table_priority`
--

CREATE TABLE IF NOT EXISTS `table_priority` (
  `priority_id` int(1) NOT NULL AUTO_INCREMENT,
  `priority_name` varchar(15) NOT NULL,
  PRIMARY KEY (`priority_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `table_priority`
--

INSERT INTO `table_priority` (`priority_id`, `priority_name`) VALUES
(1, 'Critical'),
(2, 'High'),
(3, 'Medium'),
(4, 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `table_project`
--

CREATE TABLE IF NOT EXISTS `table_project` (
  `project_id` int(4) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(56) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `table_project`
--

INSERT INTO `table_project` (`project_id`, `project_name`) VALUES
(1, 'Training');

-- --------------------------------------------------------

--
-- Table structure for table `table_relation`
--

CREATE TABLE IF NOT EXISTS `table_relation` (
  `relation_id` int(4) NOT NULL AUTO_INCREMENT,
  `r_vertical` int(1) DEFAULT NULL,
  `r_client` int(3) DEFAULT NULL,
  `r_project` int(4) DEFAULT NULL,
  PRIMARY KEY (`relation_id`),
  KEY `r_vertical` (`r_vertical`),
  KEY `r_client` (`r_client`),
  KEY `r_project` (`r_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `table_relation`
--

INSERT INTO `table_relation` (`relation_id`, `r_vertical`, `r_client`, `r_project`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_session`
--

CREATE TABLE IF NOT EXISTS `table_session` (
  `session_id` int(6) NOT NULL AUTO_INCREMENT,
  `session_rnd_id` varchar(75) NOT NULL,
  `session_data` text NOT NULL,
  `session_date` int(10) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19551 ;

--
-- Dumping data for table `table_session`
--

INSERT INTO `table_session` (`session_id`, `session_rnd_id`, `session_data`, `session_date`) VALUES
(19547, '6c6721d49eb5a63930784462a9167f60', '', 1334591932),
(19549, '1b7326481562d69c8b71d0a7abda3d0b', '', 1334933200),
(19550, '6b1e8eec72114e0d51b8b7a072c03dea', '', 1334933427);

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE IF NOT EXISTS `table_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(15) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `table_status`
--

INSERT INTO `table_status` (`status_id`, `status_name`) VALUES
(1, 'Live'),
(2, 'Demo'),
(3, 'In-Progress'),
(4, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `table_ugroup`
--

CREATE TABLE IF NOT EXISTS `table_ugroup` (
  `ugroup_id` int(3) NOT NULL AUTO_INCREMENT,
  `ugroup_name` varchar(25) DEFAULT NULL,
  `ugroup_def_rights` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ugroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `table_ugroup`
--

INSERT INTO `table_ugroup` (`ugroup_id`, `ugroup_name`, `ugroup_def_rights`) VALUES
(1, 'Admin', NULL),
(2, 'QA Lead', NULL),
(3, 'QA Analyst', NULL),
(4, 'QA Tester', NULL),
(5, 'PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE IF NOT EXISTS `table_user` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(30) DEFAULT NULL,
  `user_lastname` varchar(35) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_settings_id` int(3) DEFAULT NULL,
  `user_group_id` int(3) DEFAULT NULL,
  `user_location_id` int(5) DEFAULT NULL,
  `user_status_id` int(1) DEFAULT NULL,
  `user_rights_id` int(5) DEFAULT NULL,
  `user_create_dt` varchar(10) NOT NULL,
  `user_mod_dt` varchar(10) NOT NULL,
  `user_mod_by` int(5) DEFAULT NULL,
  `user_mod_item` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_rights_id` (`user_rights_id`),
  KEY `user_settings_id` (`user_settings_id`),
  KEY `user_group_id` (`user_group_id`),
  KEY `user_location_id` (`user_location_id`),
  KEY `user_mod_by` (`user_mod_by`),
  KEY `user_status_id` (`user_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_settings_id`, `user_group_id`, `user_location_id`, `user_status_id`, `user_rights_id`, `user_create_dt`, `user_mod_dt`, `user_mod_by`, `user_mod_item`) VALUES
(1, 'Admin', 'User', 'admin.user@xtable.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1, 1, 1, 1, '1234567897', '1234567897', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_ustatus`
--

CREATE TABLE IF NOT EXISTS `table_ustatus` (
  `ustatus_id` int(1) NOT NULL AUTO_INCREMENT,
  `ustatus_name` varchar(25) NOT NULL,
  PRIMARY KEY (`ustatus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `table_ustatus`
--

INSERT INTO `table_ustatus` (`ustatus_id`, `ustatus_name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Disabled');

-- --------------------------------------------------------

--
-- Table structure for table `table_vertical`
--

CREATE TABLE IF NOT EXISTS `table_vertical` (
  `vertical_id` int(2) NOT NULL AUTO_INCREMENT,
  `vertical_name` varchar(20) NOT NULL,
  PRIMARY KEY (`vertical_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `table_vertical`
--

INSERT INTO `table_vertical` (`vertical_id`, `vertical_name`) VALUES
(1, 'Training');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_device`
--
ALTER TABLE `table_device`
  ADD CONSTRAINT `table_device_ibfk_3` FOREIGN KEY (`device_location_id`) REFERENCES `table_location` (`location_id`),
  ADD CONSTRAINT `table_device_ibfk_1` FOREIGN KEY (`device_type_id`) REFERENCES `table_devtype` (`devtype_id`),
  ADD CONSTRAINT `table_device_ibfk_2` FOREIGN KEY (`device_group_id`) REFERENCES `table_devgroup` (`devgroup_id`);

--
-- Constraints for table `table_manual`
--
ALTER TABLE `table_manual`
  ADD CONSTRAINT `table_manual_ibfk_1` FOREIGN KEY (`manual_priority_id`) REFERENCES `table_priority` (`priority_id`),
  ADD CONSTRAINT `table_manual_ibfk_2` FOREIGN KEY (`manual_class_id`) REFERENCES `table_class` (`class_id`),
  ADD CONSTRAINT `table_manual_ibfk_3` FOREIGN KEY (`manual_status`) REFERENCES `table_status` (`status_id`),
  ADD CONSTRAINT `table_manual_ibfk_4` FOREIGN KEY (`manual_author_id`) REFERENCES `table_user` (`user_id`),
  ADD CONSTRAINT `table_manual_ibfk_5` FOREIGN KEY (`manual_relation_id`) REFERENCES `table_relation` (`relation_id`);

--
-- Constraints for table `table_manual_exec`
--
ALTER TABLE `table_manual_exec`
  ADD CONSTRAINT `table_manual_exec_ibfk_1` FOREIGN KEY (`exec_user_id`) REFERENCES `table_user` (`user_id`),
  ADD CONSTRAINT `table_manual_exec_ibfk_2` FOREIGN KEY (`exec_device_id`) REFERENCES `table_device` (`device_id`);

--
-- Constraints for table `table_relation`
--
ALTER TABLE `table_relation`
  ADD CONSTRAINT `table_relation_ibfk_3` FOREIGN KEY (`r_project`) REFERENCES `table_project` (`project_id`),
  ADD CONSTRAINT `table_relation_ibfk_1` FOREIGN KEY (`r_vertical`) REFERENCES `table_vertical` (`vertical_id`),
  ADD CONSTRAINT `table_relation_ibfk_2` FOREIGN KEY (`r_client`) REFERENCES `table_client` (`client_id`);

--
-- Constraints for table `table_user`
--
ALTER TABLE `table_user`
  ADD CONSTRAINT `table_user_ibfk_2` FOREIGN KEY (`user_location_id`) REFERENCES `table_location` (`location_id`),
  ADD CONSTRAINT `table_user_ibfk_3` FOREIGN KEY (`user_mod_by`) REFERENCES `table_user` (`user_id`),
  ADD CONSTRAINT `table_user_ibfk_4` FOREIGN KEY (`user_status_id`) REFERENCES `table_ustatus` (`ustatus_id`),
  ADD CONSTRAINT `table_user_ibfk_5` FOREIGN KEY (`user_group_id`) REFERENCES `table_ugroup` (`ugroup_id`);
