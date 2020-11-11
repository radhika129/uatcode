-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 01:42 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emart`
--

-- --------------------------------------------------------

--
-- Table structure for table `seller_details`
--

CREATE TABLE `seller_details` (
  `id` int(10) NOT NULL,
  `seller_id` int(10) DEFAULT NULL,
  `seller_email` varchar(120) DEFAULT NULL,
  `seller_image` varchar(200) DEFAULT NULL,
  `seller_alternate_number` bigint(10) DEFAULT NULL,
  `alternate_contact_verified` varchar(3) DEFAULT 'Yes',
  `seller_address1` varchar(300) DEFAULT NULL,
  `seller_address2` varchar(300) DEFAULT NULL,
  `seller_city` varchar(100) DEFAULT NULL,
  `seller_pin` int(6) DEFAULT NULL,
  `seller_state` int(5) DEFAULT NULL,
  `seller_country` int(5) DEFAULT NULL,
  `seller_business_name` varchar(30) DEFAULT NULL,
  `seller_gst` varchar(25) DEFAULT NULL,
  `seller_panname` varchar(30) DEFAULT NULL,
  `seller_pannum` varchar(10) DEFAULT NULL,
  `updatedby` int(10) DEFAULT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `beneficiary_name` varchar(40) DEFAULT NULL,
  `account_number` bigint(20) DEFAULT NULL,
  `ifsc_code` varchar(12) DEFAULT NULL,
  `cheque_image` varchar(120) DEFAULT NULL,
  `bank_account_verified` varchar(3) NOT NULL DEFAULT 'No',
  `kyc_application_status` varchar(15) NOT NULL DEFAULT 'Pending',
  `accept_online_payments` tinyint(1) NOT NULL DEFAULT 0,
  `pan_card_image` varchar(30) DEFAULT NULL,
  `gst_certificate_image` varchar(40) DEFAULT NULL,
  `gst_verified` varchar(3) NOT NULL DEFAULT 'No',
  `address_proof_image` varchar(40) DEFAULT NULL,
  `kyc_completed` tinyint(1) NOT NULL DEFAULT 0,
  `logistics_integrated` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller_details`
--

INSERT INTO `seller_details` (`id`, `seller_id`, `seller_email`, `seller_image`, `seller_alternate_number`, `alternate_contact_verified`, `seller_address1`, `seller_address2`, `seller_city`, `seller_pin`, `seller_state`, `seller_country`, `seller_business_name`, `seller_gst`, `seller_panname`, `seller_pannum`, `updatedby`, `created_datetime`, `updated_datetime`, `beneficiary_name`, `account_number`, `ifsc_code`, `cheque_image`, `bank_account_verified`, `kyc_application_status`, `accept_online_payments`, `pan_card_image`, `gst_certificate_image`, `gst_verified`, `address_proof_image`, `kyc_completed`, `logistics_integrated`) VALUES
(1, 1, 'mohan123@gmail.com', 'defaultpic.jpg', 9857415851, 'Yes', 'Temp Address 1', 'Temp Address Second', 'Jaipur', 122002, 33, 101, 'My Business 2', 'Text or in percentage', 'Mohan kumar', '1230abc48s', NULL, '2020-09-09 09:58:18', '2020-09-09 09:58:18', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(2, 2, 'ram@gmail.com', 'seller1.jpg', 7458965478, 'Yes', 'jaipur', 'jaipur', 'jaipur', 122002, 33, 101, 'Ram Sharma', '01AAAAA1234AAZA', 'Ram Kumar', 'AAAAA1234A', NULL, '2020-09-12 03:29:06', '2020-09-12 03:29:06', 'Ram Kumar', 123456789123456789, 'SBII0JAIPUR', NULL, 'No', 'Submitted', 1, 'pancard20201012426572.png', 'gst20201008170332.png', 'No', 'address20201012426572.png', 0, 'No'),
(3, 3, 'mohan@gmail.com', '', 9078965478, 'Yes', 'address 1', 'address 2', 'Jaipur', 122002, NULL, NULL, 'Mohan12', 'Free or in %', 'Mohan Kumar', '12ecy4f787', NULL, '2020-09-16 11:02:27', '2020-09-16 11:02:27', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(4, 4, NULL, NULL, NULL, 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-16 11:50:17', '2020-09-16 11:50:17', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(5, 5, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-16 12:03:07', '2020-09-16 12:03:07', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(6, 10, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-17 04:04:59', '2020-09-17 04:04:59', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(7, 11, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'ganesh', NULL, NULL, NULL, NULL, '2020-09-18 17:12:57', '2020-09-18 17:12:57', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(8, 12, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'ganesh', NULL, NULL, NULL, NULL, '2020-09-23 14:29:16', '2020-09-23 14:29:16', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(9, 13, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'rohan', NULL, NULL, NULL, NULL, '2020-10-03 11:44:13', '2020-10-03 11:44:13', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(10, 14, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'ram', NULL, NULL, NULL, NULL, '2020-10-06 12:41:23', '2020-10-06 12:41:23', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(11, 15, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'Sohan', NULL, NULL, NULL, NULL, '2020-10-07 08:14:48', '2020-10-07 08:14:48', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No'),
(13, 18, NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, NULL, NULL, 'Khushal', NULL, NULL, NULL, NULL, '2020-10-12 12:52:16', '2020-10-12 12:52:16', NULL, NULL, NULL, NULL, 'No', 'Pending', 0, NULL, NULL, 'No', NULL, 0, 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `seller_details`
--
ALTER TABLE `seller_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `seller_details`
--
ALTER TABLE `seller_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
