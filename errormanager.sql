-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2016 at 02:27 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `errormanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulk_files`
--

CREATE TABLE `bulk_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('processed','new') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `success_rate` double NOT NULL DEFAULT '0',
  `action` enum('RETRY','FC','FAILED') COLLATE utf8_unicode_ci DEFAULT NULL,
  `by_id` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bulk_files`
--

INSERT INTO `bulk_files` (`id`, `filename`, `user_id`, `status`, `created_at`, `updated_at`, `operation`, `success_rate`, `action`, `by_id`) VALUES
(44, 'FC_file.csv', 3, 'processed', '2016-06-27 10:43:45', '2016-06-27 10:46:20', 'Resubmit', 0.47368421052632, NULL, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` int(10) UNSIGNED NOT NULL,
  `oc_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tried` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `status` enum('success','failed') COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bulk_id` int(10) UNSIGNED DEFAULT NULL,
  `operation` enum('Resubmit','Force complete','Cancel') COLLATE utf8_unicode_ci NOT NULL,
  `scenario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `by_scenario` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `oc_id`, `tried`, `status`, `user_id`, `created_at`, `updated_at`, `bulk_id`, `operation`, `scenario`, `by_scenario`, `action`) VALUES
(1031, '33632', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1032, '98800', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', NULL, 'yes', NULL),
(1033, '645444', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', NULL, 'yes', NULL),
(1034, '357998', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1035, '433477', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1036, '333444', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1037, '56745', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1038, '336887', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1039, '4345865', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1040, '3347777', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1041, '4445666', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1042, '893300', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1043, '5666000', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1044, '3545799', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1045, '346', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1046, '345', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Communications.SMTP.SendEmail', 'yes', NULL),
(1047, '3589', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1048, '3333', 'yes', 'success', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1049, '990000', 'yes', 'failed', 3, '2016-06-27 10:46:20', '2016-06-27 10:46:20', 44, 'Resubmit', 'Billing.CBS.ActivateSubscriber', 'yes', NULL),
(1050, '34545', 'yes', 'success', 3, '2016-06-27 10:50:18', '2016-06-27 11:18:28', NULL, 'Resubmit', NULL, 'no', NULL),
(1051, '3334223', 'yes', 'failed', 3, '2016-06-27 11:06:45', '2016-06-27 11:19:49', NULL, 'Force complete', NULL, 'no', NULL),
(1052, '233909', 'yes', 'success', 3, '2016-06-27 11:07:01', '2016-06-27 11:20:28', NULL, 'Cancel', NULL, 'no', NULL),
(1053, '323232', 'yes', 'failed', 9, '2016-06-27 12:42:50', '2016-06-27 12:49:07', NULL, 'Resubmit', NULL, 'no', NULL),
(1054, '9900990', 'yes', 'success', 9, '2016-06-27 12:48:30', '2016-06-27 12:49:19', NULL, 'Cancel', NULL, 'no', NULL),
(1055, '8181813', 'yes', 'failed', 9, '2016-06-27 12:48:40', '2016-06-27 12:49:10', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(1056, '7777888', 'yes', 'success', 9, '2016-06-27 12:56:59', '2016-06-27 13:05:15', NULL, 'Resubmit', '|', 'yes', NULL),
(1057, '7897689', 'yes', 'failed', 9, '2016-06-27 12:57:20', '2016-06-27 13:05:18', NULL, 'Force complete', NULL, 'no', NULL),
(1058, '6554411', 'yes', 'success', 3, '2016-06-27 13:51:45', '2016-06-27 14:09:07', NULL, 'Cancel', NULL, 'no', NULL),
(1059, '443311', 'yes', 'failed', 3, '2016-06-27 13:51:55', '2016-06-27 14:09:09', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(1060, '7787800', 'yes', 'success', 3, '2016-06-27 14:30:38', '2016-06-27 14:30:43', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(1061, '411111', 'yes', 'failed', 3, '2016-06-28 10:37:30', '2016-06-28 10:37:34', NULL, 'Force complete', NULL, 'no', NULL),
(1062, '45545411', 'yes', 'success', 3, '2016-06-28 10:37:43', '2016-06-28 10:37:46', NULL, 'Resubmit', '|', 'yes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_06_20_172749_create_errors_table', 2),
('2016_06_20_191431_create_bulk_files_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('admin','superadmin','front_office','back_office') COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `type`, `role`, `phone`, `status`) VALUES
(1, 'salifu mutaru', 'salifu.mutaru@vodafone.com', '$2y$10$NL39lrVn4MipQWxHIltaGu8gDzz2FpvzJ608fjnIP9shN9vLlgV.O', 'Z2E8kFMKnb8EekeYheRUxJ4U94DvnK33f7zSWpCoHHU4VxWevsayGt7FHm73', '2016-06-17 04:08:36', '2016-06-28 10:35:14', 'superadmin', '', '', 'active'),
(2, 'Dominic Boachie', 'dominic.boachie@vodafone.com', '$2y$10$AgSJf1Z60QQo6cWrEEi2aeu5kQ9jfsaQvZnfZoYEKfpmIyJjuanJK', 'zguRVNIEgq35DFG2kiIpzsUhVucYHCuDlQE056UMnDkVP0VARu6x6kaP28M4', '2016-06-17 04:29:07', '2016-06-18 04:55:49', 'admin', '', '', 'inactive'),
(3, 'Ama Bainson', 'ama.bainson@vodafone.com', '$2y$10$LtgD19/19Sl9/uglWpZA7utzHogqrqFOrsY7mcaQh/mU3SgzOLwF.', 'JtbDOLOiZeZeQipw9ajAAJT5kfZEOywGyS6GG4pnfXVYdMeeBq9f6gBLcEzO', '2016-06-17 04:30:27', '2016-06-28 10:36:01', 'admin', 'CRM Core Support', '', 'active'),
(4, 'Alexandra Nsiah', 'alex.nsiah@vodafone.com', '$2y$10$RfdPyuiKr3.VrwxuYDxaIuiu1eBkuJs2qE/5L/56JQiqnOxWYW97a', 'QbMIz5xfiSwPKdVZwFfEfhVueVtGXVDF5swVhxLgy1aOMSS7hPnkBJXcGKYz', '2016-06-17 04:31:33', '2016-06-18 04:55:41', 'back_office', '', '', 'inactive'),
(5, 'Adwoa Arhin', 'adwoa.arhin@vodafone.com', '$2y$10$7fJwlLxlBY/MhPntZUio0ePmXYezG8fPWNQT80MUz2wT.BnFyNqPa', 'kqT4869vf125umbIOQ5Y6Ri9sO61G3XjXbtkO5wEzUNm4zVsBXcNYI3mhAEG', '2016-06-17 04:32:36', '2016-06-18 04:55:39', 'front_office', '', '', 'inactive'),
(6, 'Mariam Salis', 'mariam.salis@vodafone.com', '$2y$10$0ZOjyVzKLQm5Y2cgz/2KLOGc2jEbFaiERCTdEmW3JBY66fqUPeTv.', NULL, '2016-06-18 00:07:18', '2016-06-18 04:45:07', 'front_office', '', '', 'active'),
(7, 'Roseline Mensah', 'roseline.mensah@vodafone.com', '$2y$10$DrtLILUCJBPwv6HvZTKXN.8nJrxOVWHmPV4WxJWBW6tOWQ2ebS8ei', NULL, '2016-06-18 02:07:29', '2016-06-28 10:32:30', 'admin', '', '', 'inactive'),
(8, 'Ivy Appiah', 'ivy.appiah@vodafone.com', '$2y$10$5MPusAJAj4jBEUqDhNhsdepOU.cgNAEQcPhm7Ylh3aS2xAhEPB/2e', '8KH38V6Kc1f3NcdYTjw5rasd88H4gw5eGUuvPtHUozOzo1qzjkvUWscs94Td', '2016-06-18 04:29:44', '2016-06-28 08:16:01', 'front_office', '', '', 'inactive'),
(9, 'Abunanga Bantu', 'abunanga.bantu@vodafone.com', '$2y$10$NaeBj0sTn8VeimajxChmHO927nYgzb.Mr9ywgoo3P39W.F0OGd6V2', 'NaXfIntyDwf4PVGjsesqTSndZhV380VppE7BrUUIGVwkEUryagoQ8TIxrZJN', '2016-06-18 04:40:25', '2016-06-28 10:50:01', 'back_office', 'Application Developer', '', 'active'),
(10, 'Isaac Joel', 'issac.joel@vodafone.com', '$2y$10$rFry/T.xLPPNhyZRro4su.xruYnhH9m1mpIzsokeEgmZiHzvK3nkK', NULL, '2016-06-28 07:31:59', '2016-06-28 07:32:51', 'admin', 'IT Intern', '', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_files`
--
ALTER TABLE `bulk_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oc_id` (`oc_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_files`
--
ALTER TABLE `bulk_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1063;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
