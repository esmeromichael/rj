-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2016 at 09:21 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Branded', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Generics', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `category` int(12) NOT NULL,
  `date_manufactured` date NOT NULL,
  `date_expired` date NOT NULL,
  `item_cost` decimal(24,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qoh` decimal(24,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `item_id`, `item_name`, `brand`, `qty`, `category`, `date_manufactured`, `date_expired`, `item_cost`, `status`, `created_at`, `updated_at`, `qoh`) VALUES
(1, 0, 'Robust Extreme', 'Uniliver', '0.00', 1, '2016-01-15', '2016-01-16', '20.00', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00'),
(2, 0, 'Coi Herbal Capsule', 'Daplin Daplin', '0.00', 1, '0000-00-00', '0000-00-00', '0.00', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT '0.00',
  `category` int(11) NOT NULL,
  `date_manufactured` date NOT NULL,
  `date_expired` date NOT NULL,
  `item_cost` decimal(24,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `brand`, `qty`, `category`, `date_manufactured`, `date_expired`, `item_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Robust Extreme', 'Uniliver', '0.00', 1, '0000-00-00', '0000-00-00', '2.00', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Coi Herbal Capsule', 'Daplin Daplin', '0.00', 1, '0000-00-00', '0000-00-00', '0.00', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `po_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qoh` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `qty` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `date_manufactured` date NOT NULL,
  `date_expired` date NOT NULL,
  `unit_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total` decimal(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_headers`
--

CREATE TABLE `purchase_headers` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `po_date` date NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `doc_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(10) NOT NULL,
  `so_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` decimal(24,2) NOT NULL DEFAULT '0.00',
  `price` decimal(24,2) NOT NULL DEFAULT '0.00',
  `total` decimal(24,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_headers`
--

CREATE TABLE `sale_headers` (
  `id` int(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `so_date` date NOT NULL,
  `total` decimal(24,2) NOT NULL DEFAULT '0.00',
  `cash` decimal(24,2) NOT NULL DEFAULT '0.00',
  `change_amount` decimal(24,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('Inactive','Active') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `status`) VALUES
(1, 'Grace Poe', 'Vietnam', 'Active'),
(2, 'Rodrigo Duterte', 'sdasd', 'Active'),
(3, 'Mar Roxas', 'Phil', NULL),
(4, 'Meriam Santiago', 'Phil', NULL),
(5, 'Jejomar Binay', 'Phil', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `created_at`, `updated_at`) VALUES
(1, 'a', '0cc175b9c0f1b6a831c399e269772661', 'a', 'a', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'b', '92eb5ffee6ae2fec3ad71c777531578f', 'b', 'b', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'c', '4a8a08f09d37b73795649038408b5f33', 'c', 'c', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_headers`
--
ALTER TABLE `purchase_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_headers`
--
ALTER TABLE `sale_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_headers`
--
ALTER TABLE `purchase_headers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sale_headers`
--
ALTER TABLE `sale_headers`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
