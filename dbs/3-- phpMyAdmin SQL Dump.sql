-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2017 at 02:26 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `realPro`
--

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
  `itemCost` double NOT NULL,
  `itemShipping` double NOT NULL,
  `profitPerItem` double NOT NULL,
  `itemReceivingPrice` double NOT NULL,
  `cashBackRec` varchar(500) NOT NULL,
  `validBy` timestamp NULL DEFAULT NULL,
  `orderNote` varchar(5000) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `itemName`, `itemLink`, `totalQty`, `qtyLeft`, `itemCost`, `itemShipping`, `profitPerItem`, `itemReceivingPrice`, `cashBackRec`, `validBy`, `orderNote`, `closed`, `creationDate`) VALUES
(1, 'Dell 27 Mornitor', 'www.amazon.com/dell', '30', '30', 26, 0, 3, 29, 'www.cashbackwatch.com', '2017-04-09 15:07:38', '一单最多下3个', 0, '2017-04-09 11:07:39'),
(2, 'Test2', 'www.dell.com', 'ALL IN', 'ALL IN', 0, 0, 0, 0, '', '2017-04-09 16:44:35', '', 0, '2017-04-09 12:44:36'),
(3, 'Amaon1', 'https://www.amazon.com', '23', '23', 20, 2, 3, 25, '', '2017-04-09 16:56:35', '', 0, '2017-04-09 12:56:36'),
(4, 'ceshi2', 'http://www.amazon.com', '', '', 0, 0, 0, 0, '', '2017-04-09 05:00:39', '', 0, '2017-04-09 13:00:43'),
(5, '??', 'https://www.dell.com', '23', '23', 0, 0, 0, 0, '', '2017-04-10 16:06:26', '', 0, '2017-04-10 00:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `orderTaken`
--

CREATE TABLE `orderTaken` (
  `orderTakenId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `qtyTaken` int(11) NOT NULL,
  `orderStatus` int(1) NOT NULL COMMENT '1 - Claimed; 2 - Arrived; 3 - Send Request by Nurse; 4 - Request Sent by Admin; 5 - Sent by Nurse; 6 - Confirmed sent by Admin, can surpass 5; 6 - Confirmed Arrived by Admin, can send payment request; 8 - Exception/Close',
  `orderTakenTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exceptionNote` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentrequestbynurse`
--

CREATE TABLE `sentrequestbynurse` (
  `sentReqId` int(11) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `orderTakenArray` varchar(100) NOT NULL,
  `requestDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deliveryConfirmedByAdmin` tinyint(1) NOT NULL
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
  `registredDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userNote` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userEmail`, `userPassword`, `userName`, `userPhone`, `userQQ`, `userWeChat`, `userReferred`, `admin`, `active`, `registredDate`, `userNote`) VALUES
(2, '1@2.com', '$2y$10$JXj7uf6UasaMmjwU3HFW8eoRBhccLEots2ueYSPrGQkCKAaXxMP4q', 'an', '222', '22', '', '', 0, 0, '2017-04-08 08:05:55', ''),
(11, '21@d', '$2y$10$NJqSBp5Oq0kv94gb64bYT.j9uGiXTqcMvUvwDOg3rwwDIreEKgIOq', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:13:19', ''),
(5, '23@fds', '$2y$10$sjQ6KOo74AerxuR/hFU7Eepg6MlK8Ui7k0AVWQz4DfWmdcRvZHEVa', '2', '323', '2', '', '', 0, 0, '2017-04-08 08:07:42', ''),
(9, '3@e', '$2y$10$dAQpdRCyNi1biwdpfxgSC.cbZ3BAYQ0shsWm3Kep.1yyDZSL7LpQK', 'hahaha', '2147483647', '321312', '', '', 0, 0, '2017-04-08 23:10:49', ''),
(6, '3@fdsa', '$2y$10$9e8dl4N0737YXb75utoPBelxcYdtZ.I6tgX4ouhBVnNZOt5u1fK..', '3', '323', '2', '', '', 0, 0, '2017-04-08 08:08:05', ''),
(12, '4122@fds', '$2y$10$h1rlZl1hcKWLiKu8PGeWDOQLPQsqBHjVVn2vZZA9i7BkjOQB78M6W', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:13:28', ''),
(13, '4122@fds4', '$2y$10$fJMncReShqO6F8fVzNAcZ.0yDJmpoFPwnPYoYrZazPTUstB5zMEuG', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:13:40', ''),
(14, '4122@fds43', '$2y$10$ZHU6A6Ul3HJwaSrF3yhpjO8TQ/0mmFPPnBCtvbwk.pcsCI/NuGdyq', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:13:44', ''),
(15, '4122@fds43222', '$2y$10$CqN3VwzlkNcHxK5LzbOyAO2obJ77XThEwSByCTFckXE/brgM/ufSK', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:14:33', ''),
(16, '4122@fds43222222', '$2y$10$zYySnhsVrVDtEG0DfIeeV.A0We9D1JDa7lmcSztOYdr17c723eyOC', '123', '3092873280', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:15:28', ''),
(3, 'admin@admin.com', '$2y$10$3Hau.jo.TG24AkkNT0TS3ezaSe85m0C8o3e3.NFdgkYyMXgKXqom6', '123', '321', '123', '', '', 1, 1, '2017-04-08 08:08:43', ''),
(8, 'caoyiqin1993@gmail.com', '$2y$10$gF8Y7wjYc/jj.HqeOIwIDOP/OClqnfK7HPePgdvYXJs8N9xT.1B5m', 'emma', '302', '2347894278ry', '', 'shabi', 0, 1, '2017-04-08 21:44:33', ''),
(1, 'dingdannumber1@gmail.com', '$2y$10$lDlBXdnvOK/OdsvT8l1q2eanjfR/GPCjIi9emU70uouMjAG1T46TS', 'Haha', '0', '222', '', '', 0, 0, '2017-04-08 06:52:43', ''),
(7, 'nisapi@sapi.com', '$2y$10$4t9W9Sd2hwzIzxk5/rYoTetvZrSORICTnmRS9mDHrUVnrvA9XQw/C', 'caonima', '333', '22', '', '', 0, 0, '2017-04-08 11:07:04', ''),
(4, 'user@user.com', '$2y$10$5Er38dGbBcZUnoxk8oJFqeiwDViAGdrihk5Zu4ErDd46A9UE36OG.', '2', '323', '2', '', '', 0, 1, '2017-04-08 08:08:47', ''),
(10, 'weishenme@m', '$2y$10$Tj.6i63Hv.zh2cPmj61lNu6yWwB0dhAKfVPru9OisopC8bYd9aGwC', '123', '2147483647', '3212132', 'dsa', '', 0, 0, '2017-04-08 23:11:58', '');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;