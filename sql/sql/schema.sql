-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2025 at 10:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products_at_simption`
--
CREATE DATABASE IF NOT EXISTS `products_at_simption` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `products_at_simption`;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_types`
--

DROP TABLE IF EXISTS `attendance_types`;
CREATE TABLE IF NOT EXISTS `attendance_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `short_desc` varchar(512) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_types`
--

INSERT INTO `attendance_types` (`id`, `slug`, `title`, `short_desc`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 'rfid', 'RFID Attendance', 'Contactless RFID-based attendance systems for fast scanning.', '<p>RFID attendance systems use tags/cards and readers to record presence. Ideal for large institutions and factories. Features include bulk reads, logging, and export.</p>', 'att_rfid.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(2, 'face', 'Face Recognition Attendance', 'Biometric face recognition for secure attendance.', '<p>Face recognition systems use camera + ML models to identify users with high accuracy. Option for temperature check and mask detection.</p>', 'att_face.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(3, 'fingerprint', 'Fingerprint Attendance', 'Classic biometric fingerprint-based attendance units.', '<p>Fingerprint readers are compact and reliable. Good for small-to-medium offices. Provide template storage and tamper-proof logs.</p>', 'att_fingerprint.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(4, 'qr', 'qr code attendance', 'QR code based self-attendance using mobile phones.', '<p>Generate QR codes per session or user; scan via mobile or scanner. Works well for remote or soft-attendance use-cases.</p>', 'att_qr.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(5, 'barcode', 'Barcode Attendance', 'Barcode scanning attendance for printed cards.', '<p>Barcode readers integrate easily with legacy systems. Low cost and simple to deploy.</p>', 'att_barcode.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(6, 'geo', 'Geo-fencing Self Attendance', 'Location based self-attendance using geofencing.', '<p>Geo-fencing requires mobile GPS. Ensures attendance only within predefined geolocation boundaries.</p>', 'att_geo.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(7, 'manual', 'Manual From Software', 'Manual entry and admin-corrected attendance.', '<p>Admin portal for manual corrections, leave entries, and approvals. Useful for exceptions and one-off edits.</p>', 'att_manual.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Attendance Management Systems', 'attendance', '2025-10-16 03:48:52'),
(2, 'Lanyards & Ribbons', 'lanyard', '2025-10-16 03:48:52'),
(3, 'Badges & Reels', 'badge', '2025-10-16 03:48:52'),
(4, 'ERP Software', 'erp', '2025-10-16 03:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `city`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Greenfield School', 'Delhi', 'client_greenfield.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(2, 'Rising College', 'Mumbai', 'client_rising.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(3, 'Alpha Institute', 'Bangalore', 'client_alpha.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'abhishek', 'hello@gmail.com', 'price', 'tell me the price of id cards', '2025-10-15 12:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `erp_modules`
--

DROP TABLE IF EXISTS `erp_modules`;
CREATE TABLE IF NOT EXISTS `erp_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `erp_modules`
--

INSERT INTO `erp_modules` (`id`, `slug`, `title`, `description`) VALUES
(1, 'school', 'School Management System', 'Complete school ERP with admissions, exams, fees, and HR.'),
(2, 'attendance', 'Attendance Management System', 'Module to centralize and analyze attendance across devices.'),
(3, 'college', 'College Management System', 'Higher-education ERP for departments, courses, and grading.'),
(4, 'payroll', 'Payroll Management System', 'Payroll, payslips, and statutory reports.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`),
  KEY `idx_category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'RFID PVC Card - Standard', 'RFID compatible PVC ID card, printable both sides.', 120.00, 'id_rfid_pvc.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(2, NULL, 'UV Printed PVC Card', 'Premium UV printing for high durability.', 180.00, 'id_uv_pvc.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(3, NULL, 'Polyester Lanyard - 20mm', 'Soft polyester with metal swivel hook.', 40.00, 'lanyard_poly.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(5, NULL, 'Plastic Badge - 75x50mm', 'Durable plastic badge with pin.', 35.00, 'badge_plastic.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(6, NULL, 'Metal Badge - Premium', 'Premium metal finish badge with enamel.', 150.00, 'badge_metal.png', '2025-10-08 00:21:44', '2025-10-15 07:14:53'),
(11, 1, 'RFID Attendance Machine', 'Advanced card reader technology with student display. Fully integrated with school software.', 6499.00, 'machine_rfid.png', '2025-10-16 03:50:36', '2025-10-16 03:50:36'),
(12, 1, 'Face Recognition Machine', 'High-security biometric device for touchless attendance.', 9999.00, 'machine_face.png', '2025-10-16 03:50:36', '2025-10-16 03:50:36'),
(13, 1, 'Fingerprint Scanner Unit', 'Reliable and fast biometric scanner for staff and student check-ins.', 4999.00, 'machine_finger.png', '2025-10-16 03:50:36', '2025-10-16 03:50:36'),
(14, 1, 'QR/Barcode Scanner', 'Handheld or fixed scanner for quick entry and attendance logging.', 2500.00, 'scanner_qr.png', '2025-10-16 03:50:36', '2025-10-16 03:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `quote_requests`
--

DROP TABLE IF EXISTS `quote_requests`;
CREATE TABLE IF NOT EXISTS `quote_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(200) DEFAULT NULL,
  `interests` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quote_requests`
--

INSERT INTO `quote_requests` (`id`, `name`, `email`, `phone`, `company`, `interests`, `message`, `status`, `created_at`) VALUES
(1, 'Abhishek Choudhary', 'abhishekcse2004@gmail.com', '08305978787', 'Rajiv Gandhi Proudyogiki Vishwavidyala, Bhopal', 'Attendance Systems', 'tell me about ir', 'New', '2025-10-15 12:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) DEFAULT 0,
  `verify_code` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_verified`, `is_admin`, `verify_code`, `created_at`, `updated_at`) VALUES
(1, 'Abhishek Choudhary', 'abhishekcse2004@gmail.com', '$2y$10$F9kvQN.BtiXWkHn/Th7mPOMBoFa9jO6YjWDhqFSkOhCftOvgRiatC', 1, 0, NULL, '2025-10-08 03:07:44', '2025-10-15 07:14:53'),
(3, 'anshu', 'a@gmail.com', '$2y$10$lxcLEYIR50pCt7q9DfOR4eRYXJCud1FkxnR.lxffNs83JZYpEiLIm', 1, 0, 'af0a0819f5a8f751c09fa423bd8d9501', '2025-10-15 07:54:29', '2025-10-15 07:55:38'),
(4, 'Umar Farooq', 'mohdumarfarooq.24@gmail.com', '$2y$10$tJ0GvJ7.s.mX8v.2w.i5/eG6p.c.e.f.d.b.a.9hG8j.7kF', 1, 1, NULL, '2025-10-15 09:12:11', '2025-10-15 09:12:11'),
(5, 'Admin', 'admin@test.com', '$2y$10$pYp.m27xU2H3ybiBVgTuqOyqHYVxOTV/0x.BE9lSQrwWSCE4kQ4Ym', 1, 1, NULL, '2025-10-15 09:22:12', '2025-10-15 09:31:55'),
(6, 'Abhi', 'hello@gmail.com', '$2y$10$jlaDt.0sbudBvPkVmSVjUOJ95VTL7AZVDqO9i1eEGUP1LWAAJpBqS', 1, 0, '9d24eb1fc8b45cfb07e5109d7ef48af7', '2025-10-15 10:00:12', '2025-10-15 10:01:04'),
(7, 'Aman', 'anujchoudhary7108@gmail.com', '$2y$10$o5zhY5oCxAWKMLLtDfB8ZuGKGyIiW7ujvFb30DXWetdMs5k48BH6a', 1, 0, NULL, '2025-10-15 10:14:29', '2025-10-15 10:15:06');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
