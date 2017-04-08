-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 08, 2017 at 05:03 AM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

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
  `validBy` varchar(100) DEFAULT NULL,
  `orderNote` varchar(5000) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `itemName`, `itemLink`, `totalQty`, `qtyLeft`, `itemCost`, `itemShipping`, `profitPerItem`, `itemReceivingPrice`, `cashBackRec`, `validBy`, `orderNote`, `closed`, `creationDate`) VALUES
(1, '21', '231', '32', '', 2, 3, 4, 9, '44', '2017-04-03 08:12:50', '4', 0, '2017-04-03 08:12:57'),
(2, '321', '22', '', '', 321, 0, 2, 323, '32', '2017-04-06 06:13:22', '31', 0, '2017-04-03 08:13:29'),
(3, '321', '21', '', '41', 222, 0, 3, 225, '2', '2038-01-09 00:00:00', '2', 0, '2017-04-05 23:05:01'),
(4, '321', '21', '', '', 222, 0, 3, 225, '2', '2038-01-09 00:00:00', '2', 0, '2017-04-03 08:17:50'),
(5, '321', '321', '432', '', 1, 2, 3, 6, '22', '2017-04-03 08:18:08', '222', 0, '2017-04-03 08:18:10'),
(6, '321', '321', '432', '1705', 1, 2, 3, 6, '22', '2017-04-03 08:18:28', '222', 0, '2017-04-05 23:05:07'),
(7, '321', '21', 'ALL IN', '', 321, 21, 3, 345, '2', '2017-04-03 08:24:07', '3', 0, '2017-04-03 08:24:07'),
(8, '321', '21', '322', '', 321, 21, 3, 345, '2', '2017-04-03 08:24:23', '3', 0, '2017-04-03 08:24:23'),
(9, '321', '21', 'ALL IN', '2232', 321, 21, 3, 345, '2', '2017-04-03 08:24:27', '3', 0, '2017-04-05 23:07:47'),
(10, '321', '22', 'ALL IN', '', 22, 0, 3, 25, '221', '2017-04-03 08:34:00', '321', 0, '2017-04-03 08:34:42'),
(11, '321', '2', '3', '', 2, 4, 2, 8, '3', 'Tue Jul 30 2041 04:4', '21', 0, '2017-04-03 08:46:29'),
(12, '321', '2', '3', '', 2, 4, 2, 8, '3', 'Tue Jul 30 2041 04:43:06 GMT-0400', '21', 0, '2017-04-03 08:47:49'),
(13, 'DFU', '2', '3', '3', 4, 1, 2, 7, '4', '1491356386395', '12', 0, '2017-04-04 21:39:47'),
(14, 'dasvdsdsa', 'e2', '222', '222', 3, 2, 4, 9, '123', '1491358522267', 'dsa', 0, '2017-04-04 22:15:24'),
(15, 'wqd', 'sadsa', '3', '3', 44, 44, 2, 90, '', '1491358687963', '', 0, '2017-04-04 22:18:08'),
(16, '321321', '321321', '321321', '321544', 321321, 321321, 321321, 963963, '312321', '1491359168538', '321321', 0, '2017-04-05 23:07:39'),
(17, 'kk', 'kk', '2', '2', 2, 2, 2, 6, '2', '2017-04-04 08:27:50', '2', 0, '2017-04-04 22:27:56'),
(18, 'daos', 'dwqno', '22', '22', 33, 2123, 412321, 414477, 'ckm', '2017-04-05 10:01:24', 'wapokdwa', 0, '2017-04-05 22:01:25');

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

--
-- Dumping data for table `orderTaken`
--

INSERT INTO `orderTaken` (`orderTakenId`, `orderId`, `userId`, `qtyTaken`, `orderStatus`, `orderTakenTime`, `exceptionNote`) VALUES
(1, 0, 0, 0, 0, '2017-04-05 00:47:36', ''),
(2, 1, 0, 0, 3, '2017-04-07 03:54:08', ''),
(3, 1, 0, 0, 3, '2017-04-07 03:54:08', ''),
(4, 1, 8, 321, 3, '2017-04-07 02:38:53', ''),
(5, 1, 8, 231321, 3, '2017-04-07 02:38:53', ''),
(6, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(7, 1, 8, 321, 3, '2017-04-07 02:38:53', ''),
(8, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(9, 1, 8, 321, 3, '2017-04-07 02:38:53', ''),
(10, 1, 8, 321, 3, '2017-04-07 02:38:53', ''),
(11, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(12, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(13, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(14, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(15, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(16, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(17, 1, 8, 0, 3, '2017-04-07 02:38:53', ''),
(18, 2, 8, 0, 3, '2017-04-07 01:57:34', ''),
(19, 3, 8, 0, 3, '2017-04-07 02:58:48', ''),
(20, 4, 8, 2, 2, '2017-04-07 02:50:34', ''),
(21, 5, 8, 0, 2, '2017-04-07 02:50:31', ''),
(22, 6, 8, 22, 1, '2017-04-05 00:47:36', ''),
(23, 7, 8, 321, 1, '2017-04-05 00:47:36', ''),
(24, 8, 8, 21, 1, '2017-04-05 00:47:36', ''),
(25, 9, 8, 31, 1, '2017-04-05 00:47:36', ''),
(26, 10, 8, 21, 2, '2017-04-07 02:42:15', ''),
(27, 11, 8, 0, 1, '2017-04-05 00:47:36', ''),
(28, 12, 8, 0, 1, '2017-04-05 00:47:36', ''),
(29, 14, 8, 0, 1, '2017-04-05 00:47:36', ''),
(30, 13, 8, 0, 1, '2017-04-05 00:47:36', ''),
(31, 15, 8, 0, 0, '2017-04-05 00:47:36', ''),
(32, 2, 0, 21, 3, '2017-04-07 01:55:52', ''),
(33, 6, 0, 321, 8, '2017-04-05 23:05:07', 'FUCK'),
(34, 3, 0, 41, 8, '2017-04-05 23:05:01', 'FUCK!'),
(35, 9, 0, 2232, 8, '2017-04-05 23:07:47', 'FUCK'),
(36, 5, 0, 33, 3, '2017-04-07 03:54:35', ''),
(37, 16, 0, 223, 8, '2017-04-05 23:07:39', 'FUCK!');

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

--
-- Dumping data for table `sentrequestbynurse`
--

INSERT INTO `sentrequestbynurse` (`sentReqId`, `userId`, `orderTakenArray`, `requestDate`, `deliveryConfirmedByAdmin`) VALUES
(1, '', '2', '2017-04-07 00:59:00', 0),
(2, '', '2', '2017-04-07 01:00:18', 0),
(3, '', '2', '2017-04-07 01:00:34', 0),
(4, '', '2', '2017-04-07 01:55:52', 0),
(5, '', '2', '2017-04-07 01:56:16', 0),
(6, '', '2', '2017-04-07 01:56:52', 0),
(7, '8', '2', '2017-04-07 01:57:34', 0),
(8, '8', '2', '2017-04-07 01:58:06', 0),
(9, '8', '2', '2017-04-07 01:59:27', 0),
(10, '8', '2', '2017-04-07 02:00:10', 0),
(11, '8', '2', '2017-04-07 02:00:13', 0),
(12, '8', '0', '2017-04-07 02:38:53', 0),
(13, '8', '0', '2017-04-07 02:42:24', 0),
(14, '8', '3', '2017-04-07 02:58:48', 0),
(15, '', '1,1', '2017-04-07 03:54:08', 0),
(16, '', '5', '2017-04-07 03:54:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(1000) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userPhone` int(10) NOT NULL,
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
(1, 'dingdannumber1@gmail.com', 'mindfreak', 'dsadsa', 0, 'sadsa', '', '', 0, 0, '2017-04-02 04:35:05', ''),
(2, 'dingdannumber1@gmail.com', 'mindfreak', 'dsadsa', 0, 'sadsa', '', '', 0, 0, '2017-04-02 04:46:10', ''),
(3, 'dingdannumber1@gmail.com', 'mindfreak', 'fe', 0, 'dsadawa', '', '', 0, 0, '2017-04-02 04:48:13', ''),
(4, 'h@h.com', 'mindfreak', 'wodelaojia', 3022222, 'dsadsa', 'wa', '', 1, 1, '2017-04-02 19:59:48', ''),
(5, '', '', '', 0, '', '', '', 0, 0, '2017-04-02 20:39:59', ''),
(6, 'ha@k.com', 'mindfreak', '321', 21, '3', '', '', 0, 0, '2017-04-03 03:34:06', ''),
(7, 'dsad', 'mindfreak', 'dsa', 0, 'dsa', '', '', 0, 0, '2017-04-03 04:15:20', ''),
(8, 'dsa', 'w', 'w', 0, 'w', '', '', 0, 1, '2017-04-03 23:12:34', '');

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
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `orderTaken`
--
ALTER TABLE `orderTaken`
  MODIFY `orderTakenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `sentrequestbynurse`
--
ALTER TABLE `sentrequestbynurse`
  MODIFY `sentReqId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;