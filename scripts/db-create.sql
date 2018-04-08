-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2018 at 08:35 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daihoi`
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

-- --------------------------------------------------------

--
-- Table structure for table `maincontact`
--

CREATE TABLE `maincontact` (
  `MainContactId` int(4) NOT NULL,
  `FullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Age` int(4) NOT NULL,
  `Church` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `DateTimeEntered` datetime NOT NULL,
  `AirportTransfer` tinyint(1) NOT NULL DEFAULT '0',
  `Airbed` tinyint(1) NOT NULL DEFAULT '0',
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
  `EarlyBirdSpecial` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Table structure for table `registrant`
--

CREATE TABLE `registrant` (
  `RegistrantId` int(4) NOT NULL,
  `MainContactId` int(4) NOT NULL,
  `FullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Age` int(4) NOT NULL,
  `Relation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `FamilyDiscount` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Airbed` tinyint(1) NOT NULL DEFAULT '0',
  `AirportTransfer` tinyint(1) NOT NULL DEFAULT '0',
  `Fee` decimal(4,0) DEFAULT '0',
  `CheckedIn` tinyint(1) NOT NULL DEFAULT '0',
  `Gender` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Role` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `Firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pensioner` tinyint(1) NOT NULL DEFAULT '0',
  `EarlyBirdSpecial` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vallregos`
-- (See below for the actual view)
--
CREATE TABLE `vallregos` (
`MainContactId` int(4)
,`FullName` varchar(100)
,`Age` int(4)
,`Church` varchar(250)
,`Email` varchar(255)
,`Phone` varchar(15)
,`DateTimeEntered` datetime
,`AirportTransfer` tinyint(1)
,`Airbed` tinyint(1)
,`Comments` varchar(2000)
,`Fee` decimal(4,0)
,`Reference` varchar(30)
,`CheckedIn` tinyint(1)
,`Role` varchar(50)
,`Gender` varchar(1)
,`RName` varchar(100)
,`RAge` int(4)
,`RRelation` varchar(50)
,`RFamilyDiscount` varchar(100)
,`RAirBed` tinyint(1)
,`RAirportTransfer` tinyint(1)
,`RFee` decimal(4,0)
,`RCheckedIn` tinyint(1)
,`RegistrantId` int(4)
,`RRole` varchar(50)
,`RGender` varchar(1)
,`Cancelled` tinyint(1)
,`RCancelled` tinyint(1)
,`RPensioner` tinyint(1)
,`Pensioner` tinyint(1)
,`Empty` char(0)
,`Firstname` varchar(50)
,`Surname` varchar(50)
,`RFirstname` varchar(50)
,`RSurname` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `vallregos`
--
DROP TABLE IF EXISTS `vallregos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vallregos`  AS  select `c`.`MainContactId` AS `MainContactId`,`c`.`FullName` AS `FullName`,`c`.`Age` AS `Age`,`c`.`Church` AS `Church`,`c`.`Email` AS `Email`,`c`.`Phone` AS `Phone`,`c`.`DateTimeEntered` AS `DateTimeEntered`,`c`.`AirportTransfer` AS `AirportTransfer`,`c`.`Airbed` AS `Airbed`,`c`.`Comments` AS `Comments`,`c`.`Fee` AS `Fee`,`c`.`Reference` AS `Reference`,`c`.`CheckedIn` AS `CheckedIn`,`c`.`Role` AS `Role`,`c`.`Gender` AS `Gender`,`r`.`FullName` AS `RName`,`r`.`Age` AS `RAge`,`r`.`Relation` AS `RRelation`,`r`.`FamilyDiscount` AS `RFamilyDiscount`,`r`.`Airbed` AS `RAirBed`,`r`.`AirportTransfer` AS `RAirportTransfer`,`r`.`Fee` AS `RFee`,`r`.`CheckedIn` AS `RCheckedIn`,`r`.`RegistrantId` AS `RegistrantId`,`r`.`Role` AS `RRole`,`r`.`Gender` AS `RGender`,`c`.`Cancelled` AS `Cancelled`,`r`.`Cancelled` AS `RCancelled`,`r`.`Pensioner` AS `RPensioner`,`c`.`Pensioner` AS `Pensioner`,'' AS `Empty`,`c`.`Firstname` AS `Firstname`,`c`.`Surname` AS `Surname`,`r`.`Firstname` AS `RFirstname`,`r`.`Surname` AS `RSurname` from (`maincontact` `c` left join `registrant` `r` on((`r`.`MainContactId` = `c`.`MainContactId`))) order by `c`.`MainContactId`,`r`.`RegistrantId` ;

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
  ADD PRIMARY KEY (`MainContactId`),
  ADD UNIQUE KEY `Reference` (`Reference`);

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
-- Indexes for table `registrant`
--
ALTER TABLE `registrant`
  ADD PRIMARY KEY (`RegistrantId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `auditlog`
  MODIFY `AuditLogId` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `datalog`
--
ALTER TABLE `datalog`
  MODIFY `Id` bigint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `maincontact`
--
ALTER TABLE `maincontact`
  MODIFY `MainContactId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
--
-- AUTO_INCREMENT for table `registrant`
--
ALTER TABLE `registrant`
  MODIFY `RegistrantId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
