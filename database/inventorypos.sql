-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2021 at 08:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorypos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_c2b_transactions`
--

CREATE TABLE `tbl_c2b_transactions` (
  `id` int(11) NOT NULL,
  `TransactionType` varchar(255) DEFAULT NULL,
  `TransID` varchar(255) DEFAULT NULL,
  `TransTime` varchar(255) DEFAULT NULL,
  `TransAmount` varchar(255) DEFAULT NULL,
  `BusinessShortCode` varchar(255) DEFAULT NULL,
  `BillRefNumber` varchar(255) DEFAULT NULL,
  `InvoiceNumber` varchar(255) DEFAULT NULL,
  `OrgAccountBalance` varchar(255) DEFAULT NULL,
  `ThirdPartyTransID` varchar(255) DEFAULT NULL,
  `MSISDN` varchar(255) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `ResultCode` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_c2b_transactions`
--

INSERT INTO `tbl_c2b_transactions` (`id`, `TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`, `ResultCode`) VALUES
(1, 'C2B', 'PEQ5DVZD21', '20210526122019', '2', NULL, NULL, NULL, NULL, NULL, '254742135639', NULL, NULL, NULL, 0),
(2, 'C2B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1032),
(3, 'C2B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1037),
(4, 'C2B', 'PER4FEN0SY', '20210527151302', '15', NULL, NULL, NULL, NULL, NULL, '254711832883', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catid` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catid`, `category`) VALUES
(1, 'Soft Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `entry_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `location_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`entry_id`, `product_id`, `quantity`, `location_id`) VALUES
(1, 1, 42, 1),
(2, 2, 38, 1),
(3, 3, 89, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phonenumber` varchar(20) NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double NOT NULL,
  `tax` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL,
  `location_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `customer_name`, `customer_phonenumber`, `order_date`, `subtotal`, `tax`, `discount`, `total`, `paid`, `due`, `payment_type`, `location_id`, `user_id`) VALUES
(1, 'John Doe', '', '2021-05-20', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(2, 'Walk-In-Customer', '', '2021-05-20', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(3, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(4, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(5, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(6, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(7, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(8, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(9, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(10, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(11, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(12, 'John Doe', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(13, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(14, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(15, 'Walk-In-Customer', '', '2021-05-21', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(16, 'Walk-In-Customer', '0712345678', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(17, 'Luiz Rey', '0712345678', '2021-05-26', 1500, 240, 0, 1500, 567, 933, 'CASH', 1, 2),
(18, 'Brian Chege', '0741424797', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(19, 'kabiu', '0742135639', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(20, 'Kabiu', '0742135639', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(21, 'Jane Doe', '', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'CASH', 1, 2),
(22, 'Brian Chege', '0741424797', '2021-05-26', 1500, 240, 0, 1500, 1500, 0, 'MPESA', 1, 2),
(23, 'Mike Sagana', '0711832883', '2021-05-27', 15, 2.4, 0, 15, 15, 0, 'MPESA', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_details`
--

CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_date` date NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice_details`
--

INSERT INTO `tbl_invoice_details` (`id`, `invoice_id`, `product_id`, `product_name`, `qty`, `price`, `order_date`, `location_id`) VALUES
(1, 1, 1, 'Fanta', 1, 1500, '2021-05-20', 1),
(2, 2, 1, 'Fanta', 1, 1500, '2021-05-20', 1),
(3, 3, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(4, 4, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(5, 5, 1, 'Fanta', 1, 1500, '2021-05-21', 1),
(6, 6, 1, 'Fanta', 1, 1500, '2021-05-21', 1),
(7, 7, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(8, 8, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(9, 9, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(10, 10, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(11, 11, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(12, 12, 1, 'Fanta', 1, 1500, '2021-05-21', 1),
(13, 13, 1, 'Fanta', 1, 1500, '2021-05-21', 1),
(14, 14, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(15, 15, 2, 'Coke', 1, 1500, '2021-05-21', 1),
(16, 16, 2, 'Coke', 1, 1500, '2021-05-26', 1),
(17, 17, 2, 'Coke', 1, 1500, '2021-05-26', 1),
(18, 18, 2, 'Coke', 1, 1500, '2021-05-26', 1),
(19, 19, 2, 'Coke', 1, 1500, '2021-05-26', 1),
(20, 20, 2, 'Coke', 1, 1500, '2021-05-26', 1),
(21, 21, 1, 'Fanta', 1, 1500, '2021-05-26', 1),
(22, 22, 1, 'Fanta', 1, 1500, '2021-05-26', 1),
(23, 23, 3, 'Krest', 1, 15, '2021-05-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_locations`
--

CREATE TABLE `tbl_locations` (
  `location_id` int(10) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `location_description` varchar(255) NOT NULL,
  `location_type` varchar(100) NOT NULL,
  `phonenumber` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(200) NOT NULL,
  `pcategory` varchar(200) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `punits_of_measure` varchar(250) NOT NULL,
  `pimage` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `pname`, `pcategory`, `purchaseprice`, `saleprice`, `punits_of_measure`, `pimage`) VALUES
(1, 'Fanta', 'Soft Drinks', 1200, 1500, 'crates', '60a6b525918fa.jpg'),
(2, 'Coke', 'Soft Drinks', 1200, 1500, 'crates', '60a6c2b8d20c8.jpg'),
(3, 'Krest', 'Soft Drinks', 10, 15, 'crates', '60af8b8e160b0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receivings`
--

CREATE TABLE `tbl_receivings` (
  `rec_id` int(10) NOT NULL,
  `date_received` date NOT NULL,
  `location_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receiving_details`
--

CREATE TABLE `tbl_receiving_details` (
  `entry_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `receiving_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfers`
--

CREATE TABLE `tbl_transfers` (
  `transfer_id` int(10) NOT NULL,
  `transfer_date` date NOT NULL,
  `from_location_id` int(10) NOT NULL,
  `to_location_id` int(10) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfers_details`
--

CREATE TABLE `tbl_transfers_details` (
  `entry_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `transfer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL,
  `admin_level` int(5) DEFAULT NULL,
  `location_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `password`, `role`, `admin_level`, `location_id`) VALUES
(1, 'superadmin', 'superadmin@gmail.com', '81dc9bdb52d04dc20036dbd83', 'Admin', 2, 1),
(2, 'admin1', 'admin1@gmail.com', '81dc9bdb52d04dc20036dbd83', 'Admin', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_c2b_transactions`
--
ALTER TABLE `tbl_c2b_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_locations`
--
ALTER TABLE `tbl_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `tbl_receivings`
--
ALTER TABLE `tbl_receivings`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_receiving_details`
--
ALTER TABLE `tbl_receiving_details`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `tbl_transfers`
--
ALTER TABLE `tbl_transfers`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `tbl_transfers_details`
--
ALTER TABLE `tbl_transfers_details`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_c2b_transactions`
--
ALTER TABLE `tbl_c2b_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `entry_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_locations`
--
ALTER TABLE `tbl_locations`
  MODIFY `location_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_receivings`
--
ALTER TABLE `tbl_receivings`
  MODIFY `rec_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_receiving_details`
--
ALTER TABLE `tbl_receiving_details`
  MODIFY `entry_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transfers`
--
ALTER TABLE `tbl_transfers`
  MODIFY `transfer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transfers_details`
--
ALTER TABLE `tbl_transfers_details`
  MODIFY `entry_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
