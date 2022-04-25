-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2022 at 08:29 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atek_issuer`
--

-- --------------------------------------------------------

--
-- Table structure for table `card_inventories`
--

CREATE TABLE `card_inventories` (
  `card_inventory_id` bigint(20) UNSIGNED NOT NULL,
  `card_pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_cvv_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_issued` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration_settings`
--

CREATE TABLE `configuration_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `otp_validity` int(11) NOT NULL,
  `otp_validity_unit` bigint(20) UNSIGNED NOT NULL,
  `otp_digit_count` int(11) NOT NULL,
  `session_validity` int(11) NOT NULL,
  `session_validity_unit` bigint(20) UNSIGNED NOT NULL,
  `min_kyc_account_balance_limit` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust_balances`
--

CREATE TABLE `cust_balances` (
  `cust_balance_id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `acc_balance` double NOT NULL,
  `chip_balance` double NOT NULL,
  `total_balance` double NOT NULL,
  `eligible_limit` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kyc_infos`
--

CREATE TABLE `cust_kyc_infos` (
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kyc_type_id` bigint(20) UNSIGNED NOT NULL,
  `ovd_type_id` bigint(20) UNSIGNED NOT NULL,
  `ovd_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust_tnxes`
--

CREATE TABLE `cust_tnxes` (
  `tnx_id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `tnx_type_id` bigint(20) UNSIGNED NOT NULL,
  `tnx_amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_cards`
--

CREATE TABLE `issue_cards` (
  `issue_card_id` bigint(20) UNSIGNED NOT NULL,
  `cust_id` bigint(20) UNSIGNED NOT NULL,
  `card_pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_cvv_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_expiry` datetime NOT NULL,
  `is_blocked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_types`
--

CREATE TABLE `kyc_types` (
  `kyc_type_id` bigint(20) UNSIGNED NOT NULL,
  `kyc_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc_types`
--

INSERT INTO `kyc_types` (`kyc_type_id`, `kyc_type_name`, `created_at`, `updated_at`) VALUES
(1, 'Min KYC', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(2, 'Full KYC', '2022-04-26 00:59:30', '2022-04-26 00:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_04_25_000002_create_unit_types_table', 1),
(6, '2022_04_25_000003_create_ovd_types_table', 1),
(7, '2022_04_25_000004_create_kyc_types_table', 1),
(8, '2022_04_25_00005_create_tnx_types_table', 1),
(9, '2022_04_25_185825_create_user_sessions_table', 1),
(10, '2022_04_25_185845_create_cust_kyc_infos_table', 1),
(11, '2022_04_25_185857_create_cust_balances_table', 1),
(12, '2022_04_25_185917_create_cust_tnxes_table', 1),
(13, '2022_04_25_185934_create_issue_cards_table', 1),
(14, '2022_04_25_190007_create_configuration_settings_table', 1),
(15, '2022_04_25_190023_create_card_inventories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ovd_types`
--

CREATE TABLE `ovd_types` (
  `ovd_type_id` bigint(20) UNSIGNED NOT NULL,
  `ovd_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ovd_types`
--

INSERT INTO `ovd_types` (`ovd_type_id`, `ovd_type_name`, `created_at`, `updated_at`) VALUES
(1, 'Aadhar Card', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(2, 'Pan Card', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(3, 'Voter Card', '2022-04-26 00:59:30', '2022-04-26 00:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tnx_types`
--

CREATE TABLE `tnx_types` (
  `tnx_type_id` bigint(20) UNSIGNED NOT NULL,
  `tnx_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tnx_types`
--

INSERT INTO `tnx_types` (`tnx_type_id`, `tnx_type_name`, `created_at`, `updated_at`) VALUES
(1, 'Credit', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(2, 'Debit', '2022-04-26 00:59:30', '2022-04-26 00:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `unit_types`
--

CREATE TABLE `unit_types` (
  `unit_type_id` bigint(20) UNSIGNED NOT NULL,
  `unit_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_types`
--

INSERT INTO `unit_types` (`unit_type_id`, `unit_type_name`, `created_at`, `updated_at`) VALUES
(1, 'Hour', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(2, 'Minute', '2022-04-26 00:59:30', '2022-04-26 00:59:30'),
(3, 'Second', '2022-04-26 00:59:30', '2022-04-26 00:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `user_session_id` bigint(20) UNSIGNED NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_created_at` datetime NOT NULL,
  `otp_expires_at` datetime NOT NULL,
  `session_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_created_at` datetime DEFAULT NULL,
  `session_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_inventories`
--
ALTER TABLE `card_inventories`
  ADD PRIMARY KEY (`card_inventory_id`);

--
-- Indexes for table `configuration_settings`
--
ALTER TABLE `configuration_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configuration_settings_otp_validity_unit_foreign` (`otp_validity_unit`),
  ADD KEY `configuration_settings_session_validity_unit_foreign` (`session_validity_unit`);

--
-- Indexes for table `cust_balances`
--
ALTER TABLE `cust_balances`
  ADD PRIMARY KEY (`cust_balance_id`),
  ADD KEY `cust_balances_cust_id_foreign` (`cust_id`);

--
-- Indexes for table `cust_kyc_infos`
--
ALTER TABLE `cust_kyc_infos`
  ADD PRIMARY KEY (`cust_id`),
  ADD KEY `cust_kyc_infos_kyc_type_id_foreign` (`kyc_type_id`),
  ADD KEY `cust_kyc_infos_ovd_type_id_foreign` (`ovd_type_id`);

--
-- Indexes for table `cust_tnxes`
--
ALTER TABLE `cust_tnxes`
  ADD PRIMARY KEY (`tnx_id`),
  ADD KEY `cust_tnxes_cust_id_foreign` (`cust_id`),
  ADD KEY `cust_tnxes_tnx_type_id_foreign` (`tnx_type_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `issue_cards`
--
ALTER TABLE `issue_cards`
  ADD PRIMARY KEY (`issue_card_id`),
  ADD KEY `issue_cards_cust_id_foreign` (`cust_id`);

--
-- Indexes for table `kyc_types`
--
ALTER TABLE `kyc_types`
  ADD PRIMARY KEY (`kyc_type_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ovd_types`
--
ALTER TABLE `ovd_types`
  ADD PRIMARY KEY (`ovd_type_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tnx_types`
--
ALTER TABLE `tnx_types`
  ADD PRIMARY KEY (`tnx_type_id`);

--
-- Indexes for table `unit_types`
--
ALTER TABLE `unit_types`
  ADD PRIMARY KEY (`unit_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`user_session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card_inventories`
--
ALTER TABLE `card_inventories`
  MODIFY `card_inventory_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuration_settings`
--
ALTER TABLE `configuration_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_balances`
--
ALTER TABLE `cust_balances`
  MODIFY `cust_balance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kyc_infos`
--
ALTER TABLE `cust_kyc_infos`
  MODIFY `cust_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_tnxes`
--
ALTER TABLE `cust_tnxes`
  MODIFY `tnx_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_cards`
--
ALTER TABLE `issue_cards`
  MODIFY `issue_card_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_types`
--
ALTER TABLE `kyc_types`
  MODIFY `kyc_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ovd_types`
--
ALTER TABLE `ovd_types`
  MODIFY `ovd_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tnx_types`
--
ALTER TABLE `tnx_types`
  MODIFY `tnx_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit_types`
--
ALTER TABLE `unit_types`
  MODIFY `unit_type_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `user_session_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `configuration_settings`
--
ALTER TABLE `configuration_settings`
  ADD CONSTRAINT `configuration_settings_otp_validity_unit_foreign` FOREIGN KEY (`otp_validity_unit`) REFERENCES `unit_types` (`unit_type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `configuration_settings_session_validity_unit_foreign` FOREIGN KEY (`session_validity_unit`) REFERENCES `unit_types` (`unit_type_id`) ON DELETE CASCADE;

--
-- Constraints for table `cust_balances`
--
ALTER TABLE `cust_balances`
  ADD CONSTRAINT `cust_balances_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `cust_kyc_infos` (`cust_id`) ON DELETE CASCADE;

--
-- Constraints for table `cust_kyc_infos`
--
ALTER TABLE `cust_kyc_infos`
  ADD CONSTRAINT `cust_kyc_infos_kyc_type_id_foreign` FOREIGN KEY (`kyc_type_id`) REFERENCES `kyc_types` (`kyc_type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cust_kyc_infos_ovd_type_id_foreign` FOREIGN KEY (`ovd_type_id`) REFERENCES `ovd_types` (`ovd_type_id`) ON DELETE CASCADE;

--
-- Constraints for table `cust_tnxes`
--
ALTER TABLE `cust_tnxes`
  ADD CONSTRAINT `cust_tnxes_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `cust_kyc_infos` (`cust_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cust_tnxes_tnx_type_id_foreign` FOREIGN KEY (`tnx_type_id`) REFERENCES `tnx_types` (`tnx_type_id`) ON DELETE CASCADE;

--
-- Constraints for table `issue_cards`
--
ALTER TABLE `issue_cards`
  ADD CONSTRAINT `issue_cards_cust_id_foreign` FOREIGN KEY (`cust_id`) REFERENCES `cust_kyc_infos` (`cust_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
