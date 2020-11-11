-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2020 at 12:46 PM
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
-- Table structure for table `cash_movements`
--

CREATE TABLE `cash_movements` (
  `cash_movement_id` bigint(20) NOT NULL,
  `linked_movement` bigint(20) DEFAULT NULL,
  `order_id` varchar(20) NOT NULL,
  `entry_side` varchar(10) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `opening_balance` float DEFAULT NULL,
  `amount` double NOT NULL,
  `amount_currency` varchar(3) NOT NULL DEFAULT 'INR',
  `dr_cr_Indicator` varchar(1) DEFAULT NULL,
  `closing_balance` float DEFAULT NULL,
  `movement_type` int(1) DEFAULT NULL,
  `payment_reference` varchar(30) NOT NULL,
  `movement_status` varchar(20) NOT NULL,
  `created_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_modification_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `value_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `movement_description` varchar(50) DEFAULT NULL,
  `movement_date` timestamp NULL DEFAULT current_timestamp(),
  `settled_amount` double DEFAULT NULL,
  `service_charge` float DEFAULT NULL,
  `service_tax` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_movements`
--

INSERT INTO `cash_movements` (`cash_movement_id`, `linked_movement`, `order_id`, `entry_side`, `seller_id`, `opening_balance`, `amount`, `amount_currency`, `dr_cr_Indicator`, `closing_balance`, `movement_type`, `payment_reference`, `movement_status`, `created_date_time`, `last_modification_datetime`, `order_date`, `value_date`, `movement_description`, `movement_date`, `settled_amount`, `service_charge`, `service_tax`) VALUES
(20201023150444105, NULL, '2020091515370115465', 'seller', 1, 367.55, -10.325, 'INR', 'D', 357.225, 4, '12456', '2', '2020-10-23 09:34:43', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150444180, NULL, '2020091515370115465', 'seller', 1, 0, 500, 'INR', 'C', 0, 1, '12456', '3', '2020-10-23 09:34:43', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150444463, 20201023150444105, '2020091515370115465', 'offset', 1, 0, 500, 'INR', 'C', 0, 4, '12456', '2', '2020-10-23 09:34:43', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150444589, 20201023150444180, '2020091515370115465', 'offset', 1, 0, 500, 'INR', 'D', 0, 1, '12456', '3', '2020-10-23 09:34:43', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150521150, 20201023150521728, '2020091515370115465', 'offset', 1, 357.225, 50, 'INR', 'C', 307.225, 2, 'null', '2', '2020-10-23 09:35:20', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150521728, NULL, '2020091515370115465', 'seller', 1, 357.225, -50, 'INR', 'D', 307.225, 2, 'null', '2', '2020-10-23 09:35:20', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150538434, NULL, '2020091515370115465', 'seller', 1, 307.225, -11.8, 'INR', 'D', 295.425, 3, 'Prepaid', '2', '2020-10-23 09:35:37', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023150538449, 20201023150538434, '2020091515370115465', 'offset', 1, 307.225, 11.8, 'INR', 'C', 295.425, 3, 'Prepaid', '2', '2020-10-23 09:35:37', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023151259200, 20201023151259274, '2020091515370115465', 'offset', 1, 0, 50, 'INR', 'C', 0, 2, 'null', '2', '2020-10-23 09:42:58', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201023151259274, NULL, '2020091515370115465', 'seller', 1, 295.425, -50, 'INR', 'D', 245.425, 2, 'null', '2', '2020-10-23 09:42:58', '2020-11-05 10:44:11', '2020-10-21 18:30:00', '2020-10-22 18:30:00', NULL, NULL, NULL, NULL, NULL),
(20201029170004401, 20201029170004946, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:30:03', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170004665, 20201029170004764, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:30:03', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170004764, NULL, '2020102915020585800', 'seller', 1, 245.425, -26.845, 'INR', 'D', 218.58, 4, '597266', '2', '2020-10-29 11:30:03', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170004946, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:30:03', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170057381, 20201029170057867, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:30:56', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170057609, 20201029170057895, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:30:56', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170057867, NULL, '2020102915020585800', 'seller', 1, 218.58, -26.845, 'INR', 'D', 191.735, 4, '597266', '2', '2020-10-29 11:30:56', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170057895, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:30:56', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170128112, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:31:27', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170128596, NULL, '2020102915020585800', 'seller', 1, 191.735, -26.845, 'INR', 'D', 164.89, 4, '597266', '2', '2020-10-29 11:31:27', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170128788, 20201029170128596, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:31:27', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170128807, 20201029170128112, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:31:27', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170151105, 20201029170151919, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:31:50', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170151277, NULL, '2020102915020585800', 'seller', 1, 164.89, -26.845, 'INR', 'D', 138.045, 4, '597266', '2', '2020-10-29 11:31:50', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170151755, 20201029170151277, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:31:50', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170151919, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:31:50', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170207113, 20201029170207901, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:32:06', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170207201, 20201029170207311, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:32:06', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170207311, NULL, '2020102915020585800', 'seller', 1, 138.045, -26.845, 'INR', 'D', 111.2, 4, '597266', '2', '2020-10-29 11:32:06', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170207901, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:32:06', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170352300, 20201029170352855, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:33:51', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170352387, 20201029170352794, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:33:51', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170352794, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:33:51', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170352855, NULL, '2020102915020585800', 'seller', 1, 111.2, -26.845, 'INR', 'D', 84.355, 4, '597266', '2', '2020-10-29 11:33:51', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170423284, NULL, '2020102915020585800', 'seller', 1, 84.355, -26.845, 'INR', 'D', 57.51, 4, '597266', '2', '2020-10-29 11:34:22', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170423305, 20201029170423284, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:34:22', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170423533, 20201029170423650, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:34:22', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170423650, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:34:22', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170547450, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:35:46', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170547779, 20201029170547963, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:35:46', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170547963, NULL, '2020102915020585800', 'seller', 1, 57.51, -26.845, 'INR', 'D', 30.665, 4, '597266', '2', '2020-10-29 11:35:46', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170547969, 20201029170547450, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:35:46', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170656100, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:36:55', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170656669, 20201029170656675, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:36:55', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170656675, NULL, '2020102915020585800', 'seller', 1, 30.665, -26.845, 'INR', 'D', 3.82, 4, '597266', '2', '2020-10-29 11:36:55', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170656942, 20201029170656100, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:36:55', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170732205, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:37:31', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170732260, 20201029170732205, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:37:31', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170732474, 20201029170732870, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:37:31', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170732870, NULL, '2020102915020585800', 'seller', 1, 3.82, -26.845, 'INR', 'D', -23.025, 4, '597266', '2', '2020-10-29 11:37:31', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170846187, 20201029170846602, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 11:38:45', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170846321, 20201029170846656, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 11:38:45', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029170846602, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 11:38:45', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, NULL, NULL, NULL),
(20201029170846656, NULL, '2020102915020585800', 'seller', 1, -23.025, -26.845, 'INR', 'D', -49.87, 4, '597266', '2', '2020-10-29 11:38:45', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, NULL, NULL, NULL),
(20201029175429297, 20201029175429735, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 12:24:28', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, 0, NULL, NULL),
(20201029175429529, NULL, '2020102915020585800', 'seller', 1, -49.87, -26.845, 'INR', 'D', -76.715, 4, '597266', '2', '2020-10-29 12:24:28', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175429735, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 12:24:28', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, 0, NULL, NULL),
(20201029175429849, 20201029175429529, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 12:24:28', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175538161, 20201029175538248, '2020102917550685979', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597691', '1', '2020-10-29 12:25:37', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:25:36', NULL, NULL, 0, NULL, NULL),
(20201029175538248, NULL, '2020102917550685979', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597691', '1', '2020-10-29 12:25:37', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:25:36', NULL, NULL, 0, NULL, NULL),
(20201029175538276, NULL, '2020102917550685979', 'seller', 1, -76.715, -26.845, 'INR', 'D', -103.56, 4, '597691', '2', '2020-10-29 12:25:37', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:25:36', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175538571, 20201029175538276, '2020102917550685979', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597691', '2', '2020-10-29 12:25:37', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:25:36', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175645304, NULL, '2020102915020585800', 'seller', 1, 0, 1300, 'INR', 'C', 0, 1, '597266', '1', '2020-10-29 12:26:44', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, 0, NULL, NULL),
(20201029175645350, 20201029175645926, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'C', 0, 4, '597266', '2', '2020-10-29 12:26:44', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175645620, 20201029175645304, '2020102915020585800', 'offset', 1, 0, 1300, 'INR', 'D', 0, 1, '597266', '1', '2020-10-29 12:26:44', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', NULL, NULL, 0, NULL, NULL),
(20201029175645926, NULL, '2020102915020585800', 'seller', 1, -103.56, -26.845, 'INR', 'D', -130.405, 4, '597266', '2', '2020-10-29 12:26:44', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 09:32:30', 'Gateway Charges', NULL, 1300, NULL, NULL),
(20201029175844213, 20201029175844305, '2020102917581391847', 'offset', 1, 0, 8500, 'INR', 'C', 0, 4, '597697', '2', '2020-10-29 12:28:43', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:28:42', 'Gateway Charges', NULL, 8500, NULL, NULL),
(20201029175844305, NULL, '2020102917581391847', 'seller', 1, -130.405, -175.525, 'INR', 'D', -305.93, 4, '597697', '2', '2020-10-29 12:28:43', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:28:42', 'Gateway Charges', NULL, 8500, NULL, NULL),
(20201029175844524, NULL, '2020102917581391847', 'seller', 1, 0, 8500, 'INR', 'C', 0, 1, '597697', '1', '2020-10-29 12:28:43', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:28:42', NULL, NULL, 0, NULL, NULL),
(20201029175844942, 20201029175844524, '2020102917581391847', 'offset', 1, 0, 8500, 'INR', 'D', 0, 1, '597697', '1', '2020-10-29 12:28:43', '2020-11-05 10:44:11', '2020-10-28 18:30:00', '2020-10-29 12:28:42', NULL, NULL, 0, NULL, NULL),
(20201030120454192, NULL, '2020103012042083423', 'seller', 1, 0, 500, 'INR', 'C', 0, 1, '598268', '1', '2020-10-30 06:34:53', '2020-11-05 10:44:11', '2020-10-29 18:30:00', '2020-10-30 06:34:51', NULL, NULL, 0, NULL, NULL),
(20201030120454433, 20201030120454977, '2020103012042083423', 'offset', 1, 0, 500, 'INR', 'C', 0, 4, '598268', '2', '2020-10-30 06:34:53', '2020-11-05 10:44:11', '2020-10-29 18:30:00', '2020-10-30 06:34:51', 'Gateway Charges', NULL, 500, NULL, NULL),
(20201030120454898, 20201030120454192, '2020103012042083423', 'offset', 1, 0, 500, 'INR', 'D', 0, 1, '598268', '1', '2020-10-30 06:34:53', '2020-11-05 10:44:11', '2020-10-29 18:30:00', '2020-10-30 06:34:51', NULL, NULL, 0, NULL, NULL),
(20201030120454977, NULL, '2020103012042083423', 'seller', 1, -305.93, -10.325, 'INR', 'D', -316.255, 4, '598268', '2', '2020-10-30 06:34:53', '2020-11-05 10:44:11', '2020-10-29 18:30:00', '2020-10-30 06:34:51', 'Gateway Charges', NULL, 500, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_movements`
--
ALTER TABLE `cash_movements`
  ADD PRIMARY KEY (`cash_movement_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_movements`
--
ALTER TABLE `cash_movements`
  MODIFY `cash_movement_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20201030120454978;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
