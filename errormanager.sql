-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2016 at 02:59 PM
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
('2014_10_12_100000_create_password_resets_table', 1);

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
(1, 'salifu mutaru', 'salifu.mutaru@vodafone.com', '$2y$10$NL39lrVn4MipQWxHIltaGu8gDzz2FpvzJ608fjnIP9shN9vLlgV.O', 'hxeNnGoNBnIIkd15qZR7PSZhFejRtRVW3gICUj1XLeU5lVpJBfhBVKYkcOd3', '2016-06-17 04:08:36', '2016-06-20 04:41:27', 'superadmin', '', '', 'active'),
(2, 'Dominic Boachie', 'dominic.boachie@vodafone.com', '$2y$10$AgSJf1Z60QQo6cWrEEi2aeu5kQ9jfsaQvZnfZoYEKfpmIyJjuanJK', 'zguRVNIEgq35DFG2kiIpzsUhVucYHCuDlQE056UMnDkVP0VARu6x6kaP28M4', '2016-06-17 04:29:07', '2016-06-18 04:55:49', 'admin', '', '', 'inactive'),
(3, 'Ama Bainson', 'ama.bainson@vodafone.com', '$2y$10$ParFHUTtCLyRCkngfgvCluqlSRF6HWq7UZXeBw4IX6kt3B3TkNzRe', 'bcBoSVUniCcXBOW0izxLmGE8wgZbK9rMwMY1Yp446KFuHLvZZohCzHS83sBZ', '2016-06-17 04:30:27', '2016-06-20 08:15:10', 'admin', 'CRM Core Support', '', 'inactive'),
(4, 'Alexandra Nsiah', 'alex.nsiah@vodafone.com', '$2y$10$RfdPyuiKr3.VrwxuYDxaIuiu1eBkuJs2qE/5L/56JQiqnOxWYW97a', 'QbMIz5xfiSwPKdVZwFfEfhVueVtGXVDF5swVhxLgy1aOMSS7hPnkBJXcGKYz', '2016-06-17 04:31:33', '2016-06-18 04:55:41', 'back_office', '', '', 'inactive'),
(5, 'Adwoa Arhin', 'adwoa.arhin@vodafone.com', '$2y$10$7fJwlLxlBY/MhPntZUio0ePmXYezG8fPWNQT80MUz2wT.BnFyNqPa', 'kqT4869vf125umbIOQ5Y6Ri9sO61G3XjXbtkO5wEzUNm4zVsBXcNYI3mhAEG', '2016-06-17 04:32:36', '2016-06-18 04:55:39', 'front_office', '', '', 'inactive'),
(6, 'Mariam Salis', 'mariam.salis@vodafone.com', '$2y$10$0ZOjyVzKLQm5Y2cgz/2KLOGc2jEbFaiERCTdEmW3JBY66fqUPeTv.', NULL, '2016-06-18 00:07:18', '2016-06-18 04:45:07', 'back_office', '', '', 'active'),
(7, 'Roseline Mensah', 'roseline.mensah@vodafone.com', '$2y$10$DrtLILUCJBPwv6HvZTKXN.8nJrxOVWHmPV4WxJWBW6tOWQ2ebS8ei', NULL, '2016-06-18 02:07:29', '2016-06-18 04:45:15', 'admin', '', '', 'active'),
(8, 'Ivy Appiah', 'ivy.appiah@vodafone.com', '$2y$10$5MPusAJAj4jBEUqDhNhsdepOU.cgNAEQcPhm7Ylh3aS2xAhEPB/2e', NULL, '2016-06-18 04:29:44', '2016-06-18 04:55:55', 'front_office', '', '', 'inactive'),
(9, 'Abunanga Bantu', 'abunanga.bantu@vodafone.com', '$2y$10$kj/vTtS4lDA6jI1Bc7AgROPUVAI2AllH0u9ShkJmLeHkH/TUOPEfy', NULL, '2016-06-18 04:40:25', '2016-06-18 04:55:34', 'back_office', 'Application Developer', '', 'inactive');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
