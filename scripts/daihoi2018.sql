-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 10:20 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daihoi2018`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CurrentTimeMelbourne` () RETURNS DATETIME NO SQL
RETURN AddTime(CURRENT_TIMESTAMP, '02:00:00')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--

CREATE TABLE `auditlog` (
  `AuditLogId` int(4) NOT NULL,
  `Type` varchar(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Either M or R',
  `Id` int(4) NOT NULL COMMENT 'Either the RegistrantId or MainContactId',
  `ChangeText` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datalog`
--

CREATE TABLE `datalog` (
  `Id` bigint(8) NOT NULL,
  `jsonData` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Status` smallint(1) DEFAULT NULL COMMENT '1 = inserted main, 2 errors,  3 inserted members',
  `Reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ClientBrowser` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `messageId` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `datalog`
--

INSERT INTO `datalog` (`Id`, `jsonData`, `DateTime`, `IP`, `Status`, `Reference`, `ClientBrowser`, `messageId`) VALUES
(68, '{"Firstname":"Vương","Surname":"Vũ","Age":"78","Role":"Pastor","Gender":"M","Church":"Hội Thánh Tin Lành Quê Hương (CMA) NSW","Email":"kyle@instil.org.au","Phone":"+61395485689","Airbed":false,"AirportTransfer":true,"Fee":405,"Registrants":[{"Firstname":"Vương","Surname":"Vũ","Age":1,"Role":"Church member","Gender":"M","Relation":"Grandfather","DiscountFamily":"-","Airbed":false,"AirportTransfer":false,"Fee":30,"Cancelled":false,"DiscountAmount":0,"Pensioner":false,"EarlyBirdSpecial":true}],"Comments":"","Reference":"MELBOURNE2018","Cancelled":false,"DiscountAmount":0,"Pensioner":false,"EarlyBirdSpecial":true,"State":"TAS"}', '2018-04-08 20:06:40', '::1', 3, 'LFED', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', NULL),
(69, '{"Firstname":"Thi","Surname":"Diệp","Age":"36","Role":"Deacon","Gender":"M","Church":"Hội Thánh Tin Lành Salisbury (VECA) SA","Email":"kyle@instil.org.au","Phone":"+61395485689","Airbed":false,"AirportTransfer":false,"Fee":380,"Registrants":[{"Firstname":"Phạm","Surname":"Hòa","Age":12,"Role":"Hội viên Hội thánh","Gender":"","Relation":"Mother","DiscountFamily":"-","Airbed":false,"AirportTransfer":true,"Fee":355,"Cancelled":false,"DiscountAmount":0,"Pensioner":false,"EarlyBirdSpecial":true}],"Comments":"","Reference":"MELBOURNE2018","Cancelled":false,"DiscountAmount":0,"Pensioner":true,"EarlyBirdSpecial":true,"State":"WA"}', '2018-04-08 20:08:23', '::1', 3, 'XEBC', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maincontact`
--

CREATE TABLE `maincontact` (
  `MainContactId` int(4) NOT NULL,
  `FullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Age` int(4) NOT NULL,
  `Church` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateTimeEntered` datetime NOT NULL,
  `AirportTransfer` tinyint(1) NOT NULL DEFAULT '0',
  `Comments` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fee` decimal(4,0) DEFAULT '0',
  `Reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `CheckedIn` tinyint(1) NOT NULL DEFAULT '0',
  `Role` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Gender` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `Firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pensioner` tinyint(1) NOT NULL DEFAULT '0',
  `EarlyBirdSpecial` tinyint(4) DEFAULT '0',
  `State` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Relation` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FamilyDiscount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GroupLeaderMainContactId` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `maincontact`
--

INSERT INTO `maincontact` (`MainContactId`, `FullName`, `Age`, `Church`, `Email`, `Phone`, `DateTimeEntered`, `AirportTransfer`, `Comments`, `Fee`, `Reference`, `CheckedIn`, `Role`, `Gender`, `Cancelled`, `Firstname`, `Surname`, `Pensioner`, `EarlyBirdSpecial`, `State`, `Relation`, `FamilyDiscount`, `GroupLeaderMainContactId`) VALUES
(3, 'Vương Vũ', 78, 'Hội Thánh Tin Lành Quê Hương (CMA) NSW', 'kyle@instil.org.au', '+61395485689', '2018-04-08 20:06:40', 1, '', '405', 'LFEDDX0003', 0, 'Pastor', 'M', 0, 'Vương', 'Vũ', 0, 1, 'TAS', NULL, NULL, NULL),
(4, 'Vương Vũ', 1, 'Hội Thánh Tin Lành Quê Hương (CMA) NSW', NULL, NULL, '2018-04-08 20:06:40', 0, NULL, '30', 'LFEDDX0003', 0, 'Church member', 'M', 0, 'Vương', 'Vũ', 0, 1, 'TAS', 'Grandfather', '-', 3),
(5, 'Thi Diệp', 36, 'Hội Thánh Tin Lành Salisbury (VECA) SA', 'kyle@instil.org.au', '+61395485689', '2018-04-08 20:08:23', 0, '', '380', 'XEBCDX0005', 0, 'Deacon', 'M', 0, 'Thi', 'Diệp', 1, 1, 'WA', NULL, NULL, NULL),
(6, 'Phạm Hòa', 12, 'Hội Thánh Tin Lành Salisbury (VECA) SA', NULL, NULL, '2018-04-08 20:08:23', 1, NULL, '355', 'XEBCDX0005', 0, 'Hội viên Hội thánh', '', 0, 'Phạm', 'Hòa', 0, 1, 'WA', 'Mother', '-', 5);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `NoteId` int(4) NOT NULL,
  `Notes` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `MainContactId` int(4) NOT NULL,
  `DateTimeEntered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentId` int(11) NOT NULL,
  `PaidAmount` decimal(10,0) NOT NULL DEFAULT '0',
  `PaidDate` datetime NOT NULL,
  `DateEntered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Notes` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MainContactId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RoomId` bigint(8) NOT NULL,
  `RoomNumber` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `RoomType` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Capacity` int(4) NOT NULL DEFAULT '0',
  `IsAvailable` tinyint(1) NOT NULL DEFAULT '1',
  `Comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roomallocation`
--

CREATE TABLE `roomallocation` (
  `RoomAllocationId` bigint(8) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `MainContactId` int(4) DEFAULT NULL,
  `RegistrantId` int(4) DEFAULT NULL,
  `Comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vroomoccupancy`
-- (See below for the actual view)
--
CREATE TABLE `vroomoccupancy` (
`RoomId` bigint(8)
,`RoomNumber` varchar(30)
,`RoomType` varchar(50)
,`Capacity` int(4)
,`IsAvailable` tinyint(1)
,`Comments` varchar(500)
,`Occupants` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `vroomoccupancy`
--
DROP TABLE IF EXISTS `vroomoccupancy`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vroomoccupancy`  AS  select `r`.`RoomId` AS `RoomId`,`r`.`RoomNumber` AS `RoomNumber`,`r`.`RoomType` AS `RoomType`,`r`.`Capacity` AS `Capacity`,`r`.`IsAvailable` AS `IsAvailable`,`r`.`Comments` AS `Comments`,(select count(0) from `roomallocation` `a` where (`a`.`RoomId` = `r`.`RoomId`)) AS `Occupants` from `room` `r` where (1 = 1) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auditlog`
--
ALTER TABLE `auditlog`
  ADD PRIMARY KEY (`AuditLogId`);

--
-- Indexes for table `datalog`
--
ALTER TABLE `datalog`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `maincontact`
--
ALTER TABLE `maincontact`
  ADD PRIMARY KEY (`MainContactId`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`NoteId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `auditlog`
  MODIFY `AuditLogId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `datalog`
--
ALTER TABLE `datalog`
  MODIFY `Id` bigint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `maincontact`
--
ALTER TABLE `maincontact`
  MODIFY `MainContactId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `NoteId` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
