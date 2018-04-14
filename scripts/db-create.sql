-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2018 at 07:51 AM
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

CREATE TABLE `AuditLog` (
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

CREATE TABLE `DataLog` (
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

CREATE TABLE `MainContact` (
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

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `Note` (
  `NoteId` int(4) NOT NULL,
  `Notes` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `MainContactId` int(4) NOT NULL,
  `DateTimeEntered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `Payment` (
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

CREATE TABLE `Room` (
  `RoomId` bigint(8) NOT NULL,
  `RoomNumber` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `RoomType` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Capacity` int(4) NOT NULL DEFAULT '0',
  `IsAvailable` tinyint(1) NOT NULL DEFAULT '1',
  `Comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `Room` (`RoomId`, `RoomNumber`, `RoomType`, `Capacity`, `IsAvailable`, `Comments`) VALUES
(1, 'WH 01-01', 'Standard', 1, 1, NULL),
(2, 'WH 01-02', 'Standard', 1, 1, NULL),
(3, 'WH 01-03', 'Standard', 1, 1, NULL),
(4, 'WH 01-04', 'Standard', 1, 1, NULL),
(5, 'WH 01-05', 'Standard', 1, 1, NULL),
(6, 'WH 01-06', 'Standard', 1, 1, NULL),
(7, 'WH 02-01', 'Standard', 1, 1, NULL),
(8, 'WH 02-02', 'Standard', 1, 1, NULL),
(9, 'WH 02-03', 'Standard', 1, 1, NULL),
(10, 'WH 02-04', 'Standard', 1, 1, NULL),
(11, 'WH 02-05', 'Standard', 1, 1, NULL),
(12, 'WH 02-06', 'Standard', 1, 1, NULL),
(13, 'WH 03-01', 'Standard', 1, 1, NULL),
(14, 'WH 03-02', 'Standard', 1, 1, NULL),
(15, 'WH 03-03', 'Standard', 1, 1, NULL),
(16, 'WH 03-04', 'Standard', 1, 1, NULL),
(17, 'WH 03-05', 'Standard', 1, 1, NULL),
(18, 'WH 03-06', 'Standard', 1, 1, NULL),
(19, 'WH 04-01', 'Standard', 1, 1, NULL),
(20, 'WH 04-02', 'Standard', 1, 1, NULL),
(21, 'WH 04-03', 'Standard', 1, 1, NULL),
(22, 'WH 04-04', 'Standard', 1, 1, NULL),
(23, 'WH 04-05', 'Standard', 1, 1, NULL),
(24, 'WH 04-06', 'Standard', 1, 1, NULL),
(25, 'WH 05-01', 'Standard', 1, 1, NULL),
(26, 'WH 05-02', 'Standard', 1, 1, NULL),
(27, 'WH 05-03', 'Standard', 1, 1, NULL),
(28, 'WH 05-04', 'Standard', 1, 1, NULL),
(29, 'WH 05-05', 'Standard', 1, 1, NULL),
(30, 'WH 05-06', 'Standard', 1, 1, NULL),
(31, 'WH 06-01', 'Standard', 1, 1, NULL),
(32, 'WH 06-02', 'Standard', 1, 1, NULL),
(33, 'WH 06-03', 'Standard', 1, 1, NULL),
(34, 'WH 06-04', 'Standard', 1, 1, NULL),
(35, 'WH 06-05', 'Standard', 1, 1, NULL),
(36, 'WH 06-06', 'Standard', 1, 1, NULL),
(37, 'WH 07-01', 'Standard', 1, 1, NULL),
(38, 'WH 07-02', 'Standard', 1, 1, NULL),
(39, 'WH 07-03', 'Standard', 1, 1, NULL),
(40, 'WH 07-04', 'Standard', 1, 1, NULL),
(41, 'WH 07-05', 'Standard', 1, 1, NULL),
(42, 'WH 07-06', 'Standard', 1, 1, NULL),
(43, 'WH 08-01', 'Standard', 1, 1, NULL),
(44, 'WH 08-02', 'Standard', 1, 1, NULL),
(45, 'WH 08-03', 'Standard', 1, 1, NULL),
(46, 'WH 08-04', 'Standard', 1, 1, NULL),
(47, 'WH 08-05', 'Standard', 1, 1, NULL),
(48, 'WH 08-06', 'Standard', 1, 1, NULL),
(49, 'WH 09-01', 'Standard', 1, 1, NULL),
(50, 'WH 09-02', 'Standard', 1, 1, NULL),
(51, 'WH 09-03', 'Standard', 1, 1, NULL),
(52, 'WH 09-04', 'Standard', 1, 1, NULL),
(53, 'WH 09-05', 'Standard', 1, 1, NULL),
(54, 'WH 09-06', 'Standard', 1, 1, NULL),
(55, 'WH 10-01', 'Standard', 1, 1, NULL),
(56, 'WH 10-02', 'Standard', 1, 1, NULL),
(57, 'WH 10-03', 'Standard', 1, 1, NULL),
(58, 'WH 10-04', 'Standard', 1, 1, NULL),
(59, 'WH 10-05', 'Standard', 1, 1, NULL),
(60, 'WH 10-06', 'Standard', 1, 1, NULL),
(61, 'WH 11-01', 'Standard', 1, 1, NULL),
(62, 'WH 11-02', 'Standard', 1, 1, NULL),
(63, 'WH 11-03', 'Standard', 1, 1, NULL),
(64, 'WH 11-04', 'Standard', 1, 1, NULL),
(65, 'WH 11-05', 'Standard', 1, 1, NULL),
(66, 'WH 11-06', 'Standard', 1, 1, NULL),
(67, 'WH 12-01', 'Standard', 1, 1, NULL),
(68, 'WH 12-02', 'Standard', 1, 1, NULL),
(69, 'WH 12-03', 'Standard', 1, 1, NULL),
(70, 'WH 12-04', 'Standard', 1, 1, NULL),
(71, 'WH 12-05', 'Standard', 1, 1, NULL),
(72, 'WH 12-06', 'Standard', 1, 1, NULL),
(73, 'WH 13-01', 'Standard', 1, 1, NULL),
(74, 'WH 13-02', 'Standard', 1, 1, NULL),
(75, 'WH 13-03', 'Standard', 1, 1, NULL),
(76, 'WH 13-04', 'Standard', 1, 1, NULL),
(77, 'WH 13-05', 'Standard', 1, 1, NULL),
(78, 'WH 13-06', 'Standard', 1, 1, NULL),
(79, 'WH 14-01', 'Standard Double', 2, 1, NULL),
(80, 'WH 14-04', 'Standard Double', 2, 1, NULL),
(81, 'WH 16-02', 'Standard Double', 2, 1, NULL),
(82, 'WH 16-03', 'Standard', 1, 1, NULL),
(83, 'WH 16-04', 'Standard', 1, 1, NULL),
(84, 'WH 16-05', 'Standard Double', 2, 1, NULL),
(85, 'WH 16-06', 'Standard', 1, 1, NULL),
(86, 'WH 21-02', 'Standard Double', 2, 1, NULL),
(87, 'WH 21-03', 'Standard', 1, 1, NULL),
(88, 'WH 21-04', 'Standard Double', 2, 1, NULL),
(89, 'WH 21-05', 'Standard Double', 2, 1, NULL),
(90, 'WH 21-06', 'Standard', 1, 1, NULL),
(91, 'WH 22-01', 'Standard', 1, 1, NULL),
(92, 'WH 22-02', 'Standard', 1, 1, NULL),
(93, 'WH 22-03', 'Standard', 1, 1, NULL),
(94, 'WH 22-04', 'Standard', 1, 1, NULL),
(95, 'WH 22-05', 'Standard', 1, 1, NULL),
(96, 'WH 22-06', 'Standard', 1, 1, NULL),
(97, 'WH 24-02', 'Standard', 1, 1, NULL),
(98, 'WH 24-03', 'Standard', 1, 1, NULL),
(99, 'WH 24-05', 'Standard', 1, 1, NULL),
(100, 'WH 24-06', 'Standard', 1, 1, NULL),
(101, 'WH 25-01', 'Standard', 1, 1, NULL),
(102, 'WH 25-02', 'Standard', 1, 1, NULL),
(103, 'WH 25-03', 'Standard', 1, 1, NULL),
(104, 'WH 25-04', 'Standard', 1, 1, NULL),
(105, 'WH 25-05', 'Standard', 1, 1, NULL),
(106, 'WH 25-06', 'Standard', 1, 1, NULL),
(107, 'WH 26-01', 'Standard', 1, 1, NULL),
(108, 'WH 26-02', 'Standard', 1, 1, NULL),
(109, 'WH 26-03', 'Standard', 1, 1, NULL),
(110, 'WH 26-04', 'Standard', 1, 1, NULL),
(111, 'WH 26-05', 'Standard', 1, 1, NULL),
(112, 'WH 26-06', 'Standard', 1, 1, NULL),
(113, 'WH 27-01', 'Standard', 1, 1, NULL),
(114, 'WH 27-02', 'Standard', 1, 1, NULL),
(115, 'WH 27-03', 'Standard', 1, 1, NULL),
(116, 'WH 27-04', 'Standard', 1, 1, NULL),
(117, 'WH 27-05', 'Standard', 1, 1, NULL),
(118, 'WH 27-06', 'Standard', 1, 1, NULL),
(119, 'WH 28-02', 'Standard Double', 2, 1, NULL),
(120, 'WH 28-03', 'Standard', 1, 1, NULL),
(121, 'WH 28-04', 'Standard Double', 2, 1, NULL),
(122, 'WH 28-05', 'Standard Double', 2, 1, NULL),
(123, 'WH 28-06', 'Standard', 1, 1, NULL),
(124, 'WH 29-01', 'Standard', 1, 1, NULL),
(125, 'WH 29-02', 'Standard', 1, 1, NULL),
(126, 'WH 29-03', 'Standard', 1, 1, NULL),
(127, 'WH 29-04', 'Standard', 1, 1, NULL),
(128, 'WH 29-05', 'Standard', 1, 1, NULL),
(129, 'WH 29-06', 'Standard', 1, 1, NULL),
(130, 'WH 30-01', 'Standard', 1, 1, NULL),
(131, 'WH 30-02', 'Standard', 1, 1, NULL),
(132, 'WH 30-03', 'Standard', 1, 1, NULL),
(133, 'WH 30-04', 'Standard', 1, 1, NULL),
(134, 'WH 30-05', 'Standard', 1, 1, NULL),
(135, 'WH 30-06', 'Standard', 1, 1, NULL),
(136, 'WH 33-02', 'Standard ', 1, 1, NULL),
(137, 'WH 33-03', 'Standard', 1, 1, NULL),
(138, 'WH 33-04', 'Standard', 1, 1, NULL),
(139, 'WH 33-05', 'Standard Double', 2, 1, NULL),
(140, 'WH 33-06', 'Standard', 1, 1, NULL),
(141, 'WH 34-01', 'Standard', 1, 1, NULL),
(142, 'WH 34-02', 'Standard', 1, 1, NULL),
(143, 'WH 34-03', 'Standard', 1, 1, NULL),
(144, 'WH 34-04', 'Standard', 1, 1, NULL),
(145, 'WH 34-05', 'Standard', 1, 1, NULL),
(146, 'WH 34-06', 'Standard', 1, 1, NULL),
(147, 'WH 38-01', 'Standard', 1, 1, NULL),
(148, 'WH 38-02', 'Standard', 1, 1, NULL),
(149, 'WH 38-03', 'Standard', 1, 1, NULL),
(150, 'WH 38-04', 'Standard', 1, 1, NULL),
(151, 'WH 38-05', 'Standard', 1, 1, NULL),
(152, 'WH 38-06', 'Standard', 1, 1, NULL),
(153, 'WH 39-02', 'Standard Double', 2, 1, NULL),
(154, 'WH 39-03', 'Standard', 1, 1, NULL),
(155, 'WH 39-04', 'Standard', 1, 1, NULL),
(156, 'WH 39-05', 'Standard Double', 2, 1, NULL),
(157, 'WH 39-06', 'Standard', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roomallocation`
--

CREATE TABLE `RoomAllocation` (
  `RoomAllocationId` bigint(8) NOT NULL,
  `RoomId` int(4) NOT NULL,
  `MainContactId` int(4) NOT NULL,
  `Comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateAllocated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auditlog`
--
ALTER TABLE `AuditLog`
  ADD PRIMARY KEY (`AuditLogId`);

--
-- Indexes for table `datalog`
--
ALTER TABLE `DataLog`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `maincontact`
--
ALTER TABLE `MainContact`
  ADD PRIMARY KEY (`MainContactId`);

--
-- Indexes for table `note`
--
ALTER TABLE `Note`
  ADD PRIMARY KEY (`NoteId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`PaymentId`);

--
-- Indexes for table `room`
--
ALTER TABLE `Room`
  ADD PRIMARY KEY (`RoomId`),
  ADD UNIQUE KEY `RoomNumber` (`RoomNumber`),
  ADD UNIQUE KEY `RoomId` (`RoomId`);

--
-- Indexes for table `roomallocation`
--
ALTER TABLE `RoomAllocation`
  ADD PRIMARY KEY (`RoomAllocationId`),
  ADD UNIQUE KEY `MainContactId` (`MainContactId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `AuditLog`
  MODIFY `AuditLogId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `datalog`
--
ALTER TABLE `DataLog`
  MODIFY `Id` bigint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `maincontact`
--
ALTER TABLE `MainContact`
  MODIFY `MainContactId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `Note`
  MODIFY `NoteId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `Payment`
  MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `roomallocation`
--
ALTER TABLE `RoomAllocation`
  MODIFY `RoomAllocationId` bigint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
