-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2015 at 07:31 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Create user for the application
--
-- CREATE USER 'tally64g_tallyho'@'localhost' IDENTIFIED BY 'c!90zog*t^P';
-- GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'tally64g_tallyho'@'localhost'; 
-- 	WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;


--
-- Database: `tally64g_tallyho`
--
CREATE DATABASE IF NOT EXISTS `tally64g_tallyho` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tally64g_tallyho`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `set`;
DROP TABLE IF EXISTS `match`;
DROP TABLE IF EXISTS `participant`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `tour`;
DROP TABLE IF EXISTS `contact`;
DROP TABLE IF EXISTS `membership`;
DROP TABLE IF EXISTS `organization`;
DROP TABLE IF EXISTS `player`;
DROP TABLE IF EXISTS `payment`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `lookup`;
DROP TABLE IF EXISTS `translation`;

--
--	Table structure for table `category`
--
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `category` int(2) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `draw_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mdraw_size` tinyint(4) DEFAULT NULL,
  `qdraw_size` tinyint(2) NOT NULL COMMENT 'Updated when draw is saved',
  `qdraw_levels` tinyint(3) unsigned DEFAULT NULL,
  `mdraw_direct` tinyint(3) unsigned DEFAULT NULL,
  `is_aita` tinyint(1) DEFAULT false,
  `tie_breaker` tinyint(4) DEFAULT NULL,
  `score_type` tinyint(4) DEFAULT NULL,
  `is_paid` boolean DEFAULT false,
  `member_fee` int(11),
  `others_fee` int(11),
  PRIMARY KEY (`id`),
  KEY `fk_category_tour1_idx` (`tour_id`),
  KEY `comboTourCategoryFK` (`tour_id`,`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `org_id` int(10),
  `given_name` varchar(32) NOT NULL,
  `family_name` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `picture` varchar(256),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `org_id` (`org_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` int(2) DEFAULT NULL,
  `type` varchar(45) NOT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL COMMENT 'Qualifying last round:-1\nQualifying penultimate round: -2\nMain round 1: 1\nMain round 2: 2\n So on.',
  `sequence` int(11) NOT NULL COMMENT '1 - 1st day 1st match\n2 - 1st day 2nd match and so on',
  `start_date` datetime,
  `court_no` tinyint,
  `player11` int(11) DEFAULT NULL,
  `player12` int(11) DEFAULT NULL,
  `player21` int(11) DEFAULT NULL,
  `player22` int(11) DEFAULT NULL,
  `winner` tinyint(2) DEFAULT NULL,
  `tour_id` int(11) NOT NULL,
  `category` int(2) NOT NULL,
  `scorer` int(10) DEFAULT NULL,
  `game_score1` tinyint(2) DEFAULT NULL,
  `game_score2` tinyint(2) DEFAULT NULL,
  `tie_break1` tinyint(2) DEFAULT NULL,
  `tie_break2` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tourcat` (`tour_id`,`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT '	' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `player_id` int(10) NOT NULL COMMENT 'Player ID',
  `org_id` int(11) NOT NULL COMMENT 'Organization ID',
  `regn_no` varchar(12)  COMMENT 'Membership No',
  `rank` tinyint(2)  COMMENT 'Rank',
  `points` int(8)  COMMENT 'Points' DEFAULT 0, 
  `since` date  COMMENT 'Member since',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT 'Tallyho Club Membership' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(45) NOT NULL COMMENT 'Organization Name',
  `address_line_1` varchar(45) NOT NULL COMMENT 'Address line 1',
  `address_line_2` varchar(45) NOT NULL COMMENT 'Address line 2',
  `city` varchar(45) NOT NULL COMMENT 'City',
  `state` int(11) NOT NULL COMMENT '1-AN\n2-AP\n3-AR\n4-AS\n5-BR\n6-CH\n7-CG\n8-GA\n9-GJ\n10-HR\n11-HP\n12-JK\n13-JH\n14-KA\n15-KL\n16-MP\n17-MH \n18-MN\n19-MG\n20-MZ \n21-NL\n22-DL\n23-OD\n24-PY\n25-PB\n26-RJ\n27-SK\n28-TN\n29-TR\n30-UP\n31-UK\n32-WB\n33-DN\n34-DD\n35-LD',
  `postal_code` int(10) DEFAULT NULL,
  `telephone` varchar(12) DEFAULT NULL COMMENT 'Limit to 12 digits covers pretty much everything.',
  `no_courts` int(2) DEFAULT NULL,
  `main_contact` int(10) NOT NULL,
  `logo` varchar(256),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT 'Hosting & Tallyho' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(10) NOT NULL,
  `tour_id` int(10) NOT NULL,
  `category` int(2) NOT NULL,
  `seed_points` int(8) NOT NULL DEFAULT 0,
  `seed` int(3) DEFAULT '999',
  `wild_card` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(1) COMMENT 'NULL or 0 - unpaid, 1 - paid',
  `fee_paid` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `player_id` (`player_id`,`tour_id`,`category`),
  KEY `tour_id` (`tour_id`),
  KEY `tour_id_category` (`tour_id`,`category`) COMMENT 'Combined key for tour_id and category'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(10) NOT NULL, 
  `participant_id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `amount` decimal(6,2) DEFAULT 0.00 COMMENT 'Always positive',
  `mode` tinyint(1) COMMENT '0-cash, 1-cheque, 2-online',
  `direction` tinyint COMMENT '1:credit, -1: debit ',
  `free_text` varchar(50),
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- Table structure for table `player`
--
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'Optional Foreign Key',
  `given_name` varchar(32) NOT NULL,
  `family_name` varchar(32) NOT NULL,
  `email` varchar(128),
  `aita_no` varchar(6) DEFAULT NULL,
  `aita_points` int(11) DEFAULT '0',
  `state` int(11) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` decimal(10,0) DEFAULT NULL,
  `picture` varchar(256),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `set`
--

CREATE TABLE IF NOT EXISTS `set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `set_no` tinyint(4) DEFAULT NULL,
  `team1` tinyint(4) DEFAULT NULL,
  `team2` tinyint(4) DEFAULT NULL,
  `match_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_set_match1_idx` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE IF NOT EXISTS `tour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(45) DEFAULT NULL,
  `level` int(2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `enrolby_date` date DEFAULT NULL,
  `referee` varchar(45) DEFAULT NULL,
  `court_type` int(2) DEFAULT NULL,
  `is_aita` tinyint(1) DEFAULT false,
  `status` int(2) DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `no_courts` int(2) DEFAULT NULL,
  `type` tinyint(1) DEFAULT 1 COMMENT '1:all paid, 2:free, 3:some paid',
  PRIMARY KEY (`id`),
  KEY `fk_tour_host1_idx` (`org_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT 'Tournaments' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `message` varbinary(255) NOT NULL,
  `translation` varchar(255) NOT NULL,
  `language` varchar(5) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`message`,`language`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(64) CHARACTER SET latin1 NOT NULL,
  `activationKey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `lastvisit` int(11) NOT NULL DEFAULT '0',
  `lastaction` int(11) NOT NULL DEFAULT '0',
  `lastpasswordchange` int(11) NOT NULL DEFAULT '0',
  `failedloginattempts` int(11) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `notifyType` enum('None','Digest','Instant','Threshold') DEFAULT 'Instant',
  `email` varchar(128) DEFAULT NULL,
  `type` int(4) DEFAULT NULL,
  -- `terms_agreed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Developer Table
--

create table if not exists `developer` (
`id` int(11) not null auto_increment,
`user_id` int(11) not null,
`given_name` varchar(32) not null,
`family_name` varchar(32) not null,
`company_name` varchar(64),
`email` varchar(250) not null,
`phone` varchar(12),
primary key(id)
);

--
-- Application Table
--

create table if not exists `application` (
`id` varchar(36) not null,
`developer_id` int(11) not null,
`description` varchar(128) not null,
`secret_key` varchar(36) not null,
`type` tinyint(1) not null comment '1:trial 2:unlimited 3:fixed period 4:fixed volume',
`no_requests` int(11),
`start_date` date not null,
`end_date` date not null default '9999-12-31',
`active_flag` tinyint(1),
primary key(id)
);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_FK_01` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `category_tour_category` FOREIGN KEY (`tour_id`, `category`) REFERENCES `category` (`tour_id`, `category`) ON DELETE CASCADE,
  ADD CONSTRAINT `Match_FK_01` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `set`
--
ALTER TABLE `set`
  ADD CONSTRAINT `fk_set_match1` FOREIGN KEY (`match_id`) REFERENCES `match` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `fk_tour_host1` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
 
--
-- Lookup values used across the application (Config data)
--
INSERT INTO `lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, 'Clay', 1, 'CourtType', 1),
(2, 'Hard', 2, 'CourtType', 2),
(3, 'Grass', 3, 'CourtType', 3),
(4, 'Mat', 4, 'CourtType', 4),
(5, 'Draft', 1, 'TourStatus', 1),
(6, 'Inviting', 2, 'TourStatus', 2),
(7, 'Upcoming', 3, 'TourStatus', 3),
(8, 'Ongoing', 4, 'TourStatus', 4),
(9, 'Over', 5, 'TourStatus', 5),
(10, 'Talent Series', 1, 'TourLevel', 1),
(11, 'Champion Series', 2, 'TourLevel', 2),
(12, 'Super Series', 3, 'TourLevel', 3),
(13, 'National Series', 4, 'TourLevel', 4),
(14, 'Others', 5, 'TourLevel', 5),
(15, 'Admin', 1, '_UserType', 1),
(16, 'Organizer', 2, 'UserType', 2),
(17, 'Player', 3, 'UserType', 1),
(18, 'Under 12 Boys Singles', 1, 'AgeGroup', 1),
(19, 'Under 12 Girls Singles', 2, 'AgeGroup', 2),
(20, 'Under 14 Boys Singles', 3, 'AgeGroup', 3),
(21, 'Under 14 Girls Singles', 4, 'AgeGroup', 4),
(22, 'Under 16 Boys Singles', 5, 'AgeGroup', 5),
(23, 'Under 16 Girls Singles', 6, 'AgeGroup', 6),
(24, 'Under 18 Boys Singles', 7, 'AgeGroup', 7),
(25, 'Under 18 Girls Singles', 8, 'AgeGroup', 8),
(26, 'Under 12 Boys Doubles', 9, 'AgeGroup', 9),
(27, 'Under 12 Girls Doubles', 10, 'AgeGroup', 10),
(28, 'Under 14 Boys Doubles', 11, 'AgeGroup', 11),
(29, 'Under 14 Girls Doubles', 12, 'AgeGroup', 12),
(30, 'Under 16 Boys Doubles', 13, 'AgeGroup', 13),
(31, 'Under 16 Girls Doubles', 14, 'AgeGroup', 14),
(32, 'Under 18 Boys Doubles', 15, 'AgeGroup', 15),
(33, 'Under 18 Girls Doubles', 16, 'AgeGroup', 16),
(34, 'Men Singles', 17, 'AgeGroup', 17),
(35, 'Women Singles', 18, 'AgeGroup', 18),
(36, 'Not paid', 1, 'PaymentStatus', 1),
(37, 'Paid', 2, 'PaymentStatus', 2),
(38, 'Boy', 1, 'Gender', 1),
(39, 'Girl', 2, 'Gender', 2),
(40, 'Andaman & Nicobar', 1, 'State', 1),
(41, 'Andhra Pradesh', 2, 'State', 2),
(42, 'Arunachal Pradesh', 3, 'State', 3),
(43, 'Assam', 4, 'State', 4),
(44, 'Bihar', 5, 'State', 5),
(45, 'Chandigarh', 6, 'State', 6),
(46, 'Chhattisgarh', 7, 'State', 7),
(47, 'Goa', 8, 'State', 8),
(48, 'Gujarat', 9, 'State', 9),
(49, 'Haryana', 10, 'State', 10),
(50, 'Himachal Pradesh', 11, 'State', 11),
(51, 'Jammu and Kashmir', 12, 'State', 12),
(52, 'Jharkhand', 13, 'State', 13),
(53, 'Karnataka', 14, 'State', 14),
(54, 'Kerala', 15, 'State', 15),
(55, 'Madhya Pradesh', 16, 'State', 16),
(56, 'Maharashtra', 17, 'State', 17),
(57, 'Manipur', 18, 'State', 18),
(58, 'Meghalaya', 19, 'State', 19),
(59, 'Mizoram', 20, 'State', 20),
(60, 'Nagaland', 21, 'State', 21),
(61, 'New Delhi', 22, 'State', 22),
(62, 'Orissa', 23, 'State', 23),
(63, 'Puducherry', 24, 'State', 24),
(64, 'Punjab', 25, 'State', 25),
(65, 'Rajasthan', 26, 'State', 26),
(66, 'Sikkim', 27, 'State', 27),
(67, 'Tamil Nadu', 28, 'State', 28),
(68, 'Tripura', 29, 'State', 29),
(69, 'Uttar Pradesh', 30, 'State', 30),
(70, 'Uttarakhand', 31, 'State', 31),
(71, 'West Bengal', 32, 'State', 32),
(72, 'Dadra and Nagar Haveli', 33, 'State', 33),
(73, 'Daman and Diu', 34, 'State', 34),
(74, 'Lakshadweep', 35, 'State', 35),
(75, 'Not prepared', 0, 'DrawStatus', 1),
(76, 'Seeded', 1, 'DrawStatus', 2),
(77, 'Prepared', 2, 'DrawStatus', 3),
(78, 'Single-Point', 0, 'TieBreakerRule', 1),
(79, 'Regular', 1, 'TieBreakerRule', 2),
(80, 'Best of 15 Games', 1, 'ScoringRule', 1),
(81, 'Best of 3 Mini-sets', 2, 'ScoringRule', 2),
(82, 'Best of 3 Sets', 3, 'ScoringRule', 3),
(83, 'Best of 5 Sets', 4, 'ScoringRule', 4),
(84, 'One set only', 5, 'ScoringRule', 5),
(85, 'Not scheduled', 0, 'MatchStatus', 1),
(86, 'Scheduled', 1, 'MatchStatus', 2),
(87, 'Ongoing', 2, 'MatchStatus', 3),
(88, 'Finished', 3, 'MatchStatus', 4),
(89, 'All Paid', 1, 'TourType', 1),
(90, 'All Free', 2, 'TourType', 2),
(91, 'Some Free', 3, 'TourType', 3),
(101, '30 Days Trial', 1, 'ApplicationType', 1),
(102, 'Unlimited Use', 2, 'ApplicationType', 2),
(103, 'Limited Period', 3, 'ApplicationType', 3),
(104, 'Limited Requests', 4, 'ApplicationType', 4)
;

--
-- Admin of the application is hardcoded
--
-- Password is Ol1verTw!st

INSERT INTO `user` (`id`, `username`, `password`, `activationKey`, `createtime`, `lastvisit`, `lastaction`, `lastpasswordchange`, `failedloginattempts`, `superuser`, `status`, `notifyType`, `email`, `type`) VALUES
(1, 'admin', '$2a$13$XLhpUd8zA3wXWspZVNluH.Di0xUUp58TfjZwEDccRPFrlX3jMIzAm', '1', 1426502499, 1426708112, 0, 1426502497, 0, 0, 1, 'Instant', 'admin@tallyho.in', 1);
