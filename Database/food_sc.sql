-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2020 at 05:27 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_sc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` char(16) NOT NULL,
  `password` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerid` varchar(12) NOT NULL,
  `name` char(60) NOT NULL,
  `dormitory` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `sex` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerid`, `name`, `dormitory`, `password`, `sex`, `age`, `phone`, `qq`, `email`) VALUES
('1', 'hahah', '3#420', '356a192b7913b04c54574d18c28d46e6395428ab', 1, 2, '7410498286', '', ''),
('320180915555', 'zhang san', '4#123', '4e72d9caec529c5cadf0a9dd5d3799831ce631f6', 0, 0, '13193475349', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `foodid` int(10) UNSIGNED NOT NULL,
  `title` char(100) DEFAULT NULL,
  `catid` int(10) UNSIGNED DEFAULT NULL,
  `price` float(4,2) NOT NULL,
  `stock` int(10) UNSIGNED DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `rest` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`foodid`, `title`, `catid`, `price`, `stock`, `status`, `description`, `rest`) VALUES
(1, 'sweet and sour chop', 1, 49.99, 4, 1, 'chop cooked with sugar and vinegar', 'Zhilan Yuan'),
(2, 'braised meat', 3, 34.99, 19, 1, 'a kind of braised pork.', 'Qingzhen restruant'),
(3, 'fried chicken wings', 2, 39.99, 36, 1, 'chicken wings which are fried', 'Yushu Yuan');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `catid` int(10) UNSIGNED NOT NULL,
  `catname` char(60) NOT NULL,
  `phone` char(20) DEFAULT NULL,
  `address` char(100) DEFAULT NULL,
  `recommend` int(10) UNSIGNED DEFAULT NULL,
  `password` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`catid`, `catname`, `phone`, `address`, `recommend`, `password`) VALUES
(1, 'Zhilan Yuan', '123123123', 'west', 0, 'aa92b1d81d3ace799263be028825d6eae985f58e'),
(2, 'Yushu Yuan', '18234234234', 'east', 1, '1a007c4767c86eb944624e95c21a6a2acb60342c'),
(3, 'QIngzhen restaurant', '18232131231', 'south', 1, '4399be6c0ab0de802b0470340ddf6ba1c13289ea'),
(4, 'Jiaoshi restaurant', '1832423432', 'west', 1, '54c07330c2a825a0b2d5b66faf330439f74a13e8');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `amount` float(6,2) DEFAULT NULL,
  `date` date NOT NULL,
  `order_status` char(10) DEFAULT NULL,
  `ship_name` char(60) NOT NULL,
  `ship_customerid` char(80) NOT NULL,
  `ship_dormitory` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `amount`, `date`, `order_status`, `ship_name`, `ship_customerid`, `ship_dormitory`) VALUES
(20, 99.98, '2020-12-11', 'CANCEL', 'hahah', '1', '3#420'),
(32, 134.97, '2020-12-11', 'MIX', 'hahah', '1', '3#420'),
(34, 34.99, '2020-12-11', 'PAID', 'hahah', '1', '3#420'),
(36, 79.98, '2020-12-11', 'DONE', 'hahah', '1', '3#420'),
(37, 39.99, '2020-12-11', 'PARTIAL', 'hahah', '1', '3#420');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `foodid` int(10) UNSIGNED NOT NULL,
  `item_price` float(4,2) NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL,
  `item_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderid`, `foodid`, `item_price`, `quantity`, `item_status`) VALUES
(20, 1, 49.99, 2, 'CANCEL'),
(32, 1, 49.99, 2, 'CANCEL'),
(32, 2, 34.99, 1, 'PAID'),
(34, 2, 34.99, 1, 'PAID'),
(36, 3, 39.99, 2, 'DONE'),
(37, 3, 39.99, 1, 'PARTIAL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerid`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`foodid`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderid`,`foodid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `foodid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `catid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
