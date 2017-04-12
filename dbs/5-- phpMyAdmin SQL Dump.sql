-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2017 at 02:28 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `realPro`
--

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
(1, '4', '1,2,3,4', '2017-04-10 10:40:26', 0),
(2, '4', '2,3,4', '2017-04-10 10:40:44', 0),
(3, '4', '3,4', '2017-04-10 10:44:55', 0),
(4, '4', '4', '2017-04-10 12:09:46', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sentrequestbynurse`
--
ALTER TABLE `sentrequestbynurse`
  ADD PRIMARY KEY (`sentReqId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sentrequestbynurse`
--
ALTER TABLE `sentrequestbynurse`
  MODIFY `sentReqId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;