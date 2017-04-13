-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2017 at 12:00 PM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `realPro`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugReport`
--

CREATE TABLE `bugReport` (
  `bugId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `bugReportText` varchar(5000) NOT NULL,
  `solved` int(1) NOT NULL COMMENT '0 - Not yet; 1 - Yes; 2 - Ignore',
  `creationTime` varchar(50) NOT NULL,
  `lastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bugReport`
--

INSERT INTO `bugReport` (`bugId`, `userId`, `userName`, `bugReportText`, `solved`, `creationTime`, `lastModifiedDate`) VALUES
(1, 1, 'testUser', 'haha', 0, '2017-04-13 02:13:37', '2017-04-13 06:13:37'),
(2, 1, 'testUser', 'ok', 0, '2017-04-13 02:16:00', '2017-04-13 06:16:00'),
(3, 1, 'testUser', '', 0, '2017-04-13 02:20:35', '2017-04-13 06:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `itemName` varchar(500) NOT NULL,
  `itemLink` varchar(500) NOT NULL,
  `totalQty` varchar(10) NOT NULL,
  `qtyLeft` varchar(10) NOT NULL,
  `totalQtyTaken` varchar(10) NOT NULL,
  `itemCost` double NOT NULL,
  `itemShipping` double NOT NULL,
  `profitPerItem` double NOT NULL,
  `itemReceivingPrice` double NOT NULL,
  `cashBackRec` varchar(500) NOT NULL,
  `validBy` timestamp NULL DEFAULT NULL,
  `orderNote` varchar(5000) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `creationTime` varchar(50) NOT NULL,
  `lastModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orderTaken`
--

CREATE TABLE `orderTaken` (
  `orderTakenId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `qtyTaken` int(11) NOT NULL,
  `orderStatus` int(1) NOT NULL COMMENT '0 - reverted; 1 - Claimed; 2 - Arrived; 3 - Send Request by Nurse; //4 - Request Sent by Admin; //5 - Sent by Nurse; //6 - Confirmed arrived by Admin, can surpass 5 and nurse can send payment request; 7 - order complete; 8 - Exception/Close;',
  `lastModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exceptionNote` varchar(5000) NOT NULL,
  `orderTakenTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentrequestbynurse`
--

CREATE TABLE `sentrequestbynurse` (
  `sentReqId` int(11) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `orderTakenArray` varchar(100) NOT NULL,
  `lastModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deliveryConfirmedByAdmin` tinyint(1) NOT NULL,
  `paymentReqSentByNurse` tinyint(1) NOT NULL,
  `bankNote` varchar(5000) NOT NULL,
  `paidByAdmin` tinyint(1) NOT NULL,
  `confirmPaidByNurseAndComplete` tinyint(1) NOT NULL,
  `requestDateAndTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(1000) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userPhone` varchar(10) NOT NULL,
  `userQQ` varchar(50) NOT NULL,
  `userWeChat` varchar(50) NOT NULL,
  `userReferred` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `lastModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userNote` varchar(5000) NOT NULL,
  `registeredTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userEmail`, `userPassword`, `userName`, `userPhone`, `userQQ`, `userWeChat`, `userReferred`, `admin`, `active`, `lastModifiedTime`, `userNote`, `registeredTime`) VALUES
(2, 'admin@admin.com', '$2y$10$Bi/xcaoaBkpq7ErmAZSthu5wXMORRLx2XjExUPBtzvS8W4NzswJAi', 'testAdmin', '3025555555', '13131313131', '', '', 1, 1, '2017-04-12 15:37:10', '', '2017-04-12 11:08:53'),
(1, 'user@user.com', '$2y$10$b6KL8t3VLZ1KXcw44mX1aOKZ5A78HO/yDn0EzaPoTxUuQq1yWrBrC', 'testUser', '3024445555', '1234567', '7654321', '', 0, 1, '2017-04-12 15:37:00', '', '2017-04-12 11:08:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bugReport`
--
ALTER TABLE `bugReport`
  ADD PRIMARY KEY (`bugId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `orderTaken`
--
ALTER TABLE `orderTaken`
  ADD PRIMARY KEY (`orderTakenId`);

--
-- Indexes for table `sentrequestbynurse`
--
ALTER TABLE `sentrequestbynurse`
  ADD PRIMARY KEY (`sentReqId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userEmail`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bugReport`
--
ALTER TABLE `bugReport`
  MODIFY `bugId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orderTaken`
--
ALTER TABLE `orderTaken`
  MODIFY `orderTakenId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sentrequestbynurse`
--
ALTER TABLE `sentrequestbynurse`
  MODIFY `sentReqId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;