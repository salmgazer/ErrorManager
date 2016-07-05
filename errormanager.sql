-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2016 at 09:56 PM
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
(52, 'FC_file.csv', 3, 'new', '2016-07-05 23:17:39', '2016-07-05 23:17:39', 'Resubmit', 0, NULL, 'no'),
(53, 'In Progress.csv', 3, 'new', '2016-07-05 23:18:42', '2016-07-05 23:18:42', 'In progress', 0, 'FC', 'no'),
(54, 'In Progress - ID.csv', 3, 'new', '2016-07-05 23:19:11', '2016-07-05 23:19:11', 'In progress', 0, 'FAILED', 'yes');

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
  `operation` enum('Resubmit','Force complete','Cancel') COLLATE utf8_unicode_ci DEFAULT NULL,
  `scenario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `by_scenario` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `oc_id`, `tried`, `status`, `user_id`, `created_at`, `updated_at`, `bulk_id`, `operation`, `scenario`, `by_scenario`, `action`) VALUES
(5, '64212', 'yes', 'failed', 3, '2016-07-05 23:57:27', '2016-07-06 00:52:51', NULL, 'Cancel', 'Billing.CBS.ActivateSubscriber', 'no', NULL),
(7, '787898', 'yes', 'failed', 3, '2016-07-06 00:09:15', '2016-07-06 00:52:49', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(8, '90875', 'yes', 'success', 3, '2016-07-06 00:09:23', '2016-07-06 00:52:48', NULL, 'Resubmit', '|', 'yes', NULL),
(9, '656778', 'yes', 'failed', 3, '2016-07-06 00:10:03', '2016-07-06 00:52:46', NULL, 'Force complete', 'Billing.CBS.ActivateSubscriber', 'no', NULL),
(10, '58989', 'yes', 'failed', 3, '2016-07-06 00:15:37', '2016-07-06 02:11:00', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(11, '900099', 'yes', 'failed', 3, '2016-07-06 00:19:37', '2016-07-06 00:52:43', NULL, 'Cancel', NULL, 'no', NULL),
(12, '889900', 'yes', 'success', 3, '2016-07-06 00:30:10', '2016-07-06 00:52:41', NULL, 'Resubmit', 'Time out', 'yes', NULL),
(13, '566322', 'no', NULL, 3, '2016-07-06 00:57:02', '2016-07-06 00:57:02', NULL, 'Force complete', NULL, 'no', NULL),
(14, '565679', 'no', NULL, 3, '2016-07-06 01:15:11', '2016-07-06 01:15:11', NULL, 'Resubmit', NULL, 'no', NULL);

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
('2016_06_20_191431_create_bulk_files_table', 3),
('2016_07_02_152802_create_apps_table', 4),
('2016_07_02_152834_create_has_apps_table', 4);

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
(1, 'salifu mutaru', 'salifu.mutaru@vodafone.com', '$2y$10$ChiwYQ2WSHVM310meYcDiuJyw/S8ATWS6SS4rsAL7qajSxNtvzoVO', 'aRwWhaOJzPBncoyaynVhovuVqHfyLLcA64Qze7LK2GMe14F8ZhJJOMNqvH80', '2016-06-17 04:08:36', '2016-07-06 00:40:18', 'superadmin', '', '', 'active'),
(2, 'Dominic Boachie', 'dominic.boachie@vodafone.com', '$2y$10$AgSJf1Z60QQo6cWrEEi2aeu5kQ9jfsaQvZnfZoYEKfpmIyJjuanJK', 'zguRVNIEgq35DFG2kiIpzsUhVucYHCuDlQE056UMnDkVP0VARu6x6kaP28M4', '2016-06-17 04:29:07', '2016-07-05 22:38:51', 'admin', '', '', 'active'),
(3, 'Ama Bainson', 'ama.bainson@vodafone.com', '$2y$10$bIZAMA0xMvObB2YJDhG7Z.J4Tw3Ri3ZIdtlRH8VMrp6mFELqnJwYu', 'ErgbhM0dgvN0e6XWlo3Iawgs2EooDtzvONNPj6ykWzeFat7t3R8uXLBfL955', '2016-06-17 04:30:27', '2016-07-06 00:38:30', 'admin', 'CRM Core Support', '', 'active'),
(4, 'Alexandra Nsiah', 'alex.nsiah@vodafone.com', '$2y$10$RfdPyuiKr3.VrwxuYDxaIuiu1eBkuJs2qE/5L/56JQiqnOxWYW97a', 'QbMIz5xfiSwPKdVZwFfEfhVueVtGXVDF5swVhxLgy1aOMSS7hPnkBJXcGKYz', '2016-06-17 04:31:33', '2016-07-05 22:38:21', 'back_office', '', '', 'active'),
(5, 'Adwoa Arhin', 'adwoa.arhin@vodafone.com', '$2y$10$7fJwlLxlBY/MhPntZUio0ePmXYezG8fPWNQT80MUz2wT.BnFyNqPa', 'kqT4869vf125umbIOQ5Y6Ri9sO61G3XjXbtkO5wEzUNm4zVsBXcNYI3mhAEG', '2016-06-17 04:32:36', '2016-07-05 22:15:24', 'admin', 'CRM Core Support', '', 'inactive'),
(6, 'Mariam Salis', 'mariam.salis@vodafone.com', '$2y$10$0ZOjyVzKLQm5Y2cgz/2KLOGc2jEbFaiERCTdEmW3JBY66fqUPeTv.', NULL, '2016-06-18 00:07:18', '2016-06-18 04:45:07', 'front_office', '', '', 'active'),
(7, 'Roseline Mensah', 'roseline.mensah@vodafone.com', '$2y$10$DrtLILUCJBPwv6HvZTKXN.8nJrxOVWHmPV4WxJWBW6tOWQ2ebS8ei', NULL, '2016-06-18 02:07:29', '2016-06-28 10:32:30', 'admin', '', '', 'inactive'),
(8, 'Ivy Appiah', 'ivy.appiah@vodafone.com', '$2y$10$.d6kgGuVEYScPFJFvzCoMeDwiLfyKibOmuKO.1LhmGAkKTOqj85i.', 'HPm27Fx1T77IO6XgJSG1WrskyQgLPduaXjwW6vzt8rsYLFtnkZ6eAcUryEAT', '2016-06-18 04:29:44', '2016-06-29 12:59:29', 'front_office', '', '', 'active'),
(9, 'Abunanga Bantu', 'abunanga.bantu@vodafone.com', '$2y$10$NaeBj0sTn8VeimajxChmHO927nYgzb.Mr9ywgoo3P39W.F0OGd6V2', 'NaXfIntyDwf4PVGjsesqTSndZhV380VppE7BrUUIGVwkEUryagoQ8TIxrZJN', '2016-06-18 04:40:25', '2016-07-05 00:25:14', 'front_office', 'Application Developer', '', 'active'),
(10, 'Isaac Joel', 'issac.joel@vodafone.com', '$2y$10$rFry/T.xLPPNhyZRro4su.xruYnhH9m1mpIzsokeEgmZiHzvK3nkK', NULL, '2016-06-28 07:31:59', '2016-07-05 22:38:30', 'admin', 'IT Intern', '', 'inactive'),
(11, 'John Kennedy', 'john.kennedy@vodafone.com', '$2y$10$vG.pfVUErnAxtD/sLUi1G.ayDYHmIaEUIP7a0IjJHgSNy7.paNsQS', NULL, '2016-06-29 12:24:26', '2016-07-05 22:38:39', 'admin', 'CRM Core Support', '', 'inactive'),
(12, 'Ali Njie', 'ali.njie@vodafone.com', '$2y$10$/6HR/BZtUa6oTedJ4wSgiefv6aKG16bPPoZaUiOOuRold54oPoRze', NULL, '2016-07-05 22:40:01', '2016-07-05 22:40:51', 'admin', 'ITHelpDesk', '', 'inactive');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
