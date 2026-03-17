-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 05:27 AM
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
-- Database: `voxguard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_logs`
--

CREATE TABLE `alert_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alert_logs`
--

INSERT INTO `alert_logs` (`id`, `user_id`, `lat`, `long`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '31.0415', '31.3547', 'Sent Successfully', '2026-02-03 21:23:35', '2026-02-03 21:23:35'),
(2, 4, '31.0415', '31.3547', 'Sent Successfully', '2026-02-06 01:08:51', '2026-02-06 01:08:51'),
(3, 4, '31.0415', '31.3547', 'Live Alert Sent Successfully', '2026-02-06 01:25:50', '2026-02-06 01:25:50'),
(4, 4, '31.0415', '31.3547', 'Live Alert Sent Successfully', '2026-02-06 01:28:19', '2026-02-06 01:28:19'),
(5, 5, '31.0415', '31.3547', 'Live Alert Triggered via Panic Button', '2026-02-06 15:12:14', '2026-02-06 15:12:14'),
(6, 9, '31.0415', '31.3547', 'Live Alert Triggered via Panic Button', '2026-02-25 00:34:22', '2026-02-25 00:34:22'),
(7, 12, '31.0415', '31.3547', 'Live Alert Triggered via Panic Button', '2026-03-03 02:17:11', '2026-03-03 02:17:11'),
(8, 13, '31.0415', '31.3547', 'Live Alert Triggered via Panic Button', '2026-03-03 06:14:11', '2026-03-03 06:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `user_id`, `first_name`, `last_name`, `phone`, `relation`, `created_at`, `updated_at`) VALUES
(11, 1, 'Heba', 'Mohamed', '201272289429', 'Personal', '2026-02-04 03:48:59', '2026-02-04 03:48:59'),
(12, 4, 'Mohamed', 'Aboasy', '+201551471747', 'Brother', '2026-02-05 05:26:03', '2026-02-05 05:26:03'),
(13, 4, 'Mohamed', 'Aboasy', '+201551471747', 'Brother', '2026-02-05 06:12:15', '2026-02-05 06:12:15'),
(14, 4, 'Mohamed', 'Aboasy', '+2201551471747', 'Brother', '2026-02-05 23:45:21', '2026-02-05 23:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fake_calls`
--

CREATE TABLE `fake_calls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `caller_name` varchar(255) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `ringtone` varchar(255) NOT NULL DEFAULT 'default_ringtone',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voice_script` varchar(255) DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fake_calls`
--

INSERT INTO `fake_calls` (`id`, `user_id`, `caller_name`, `scheduled_at`, `ringtone`, `status`, `created_at`, `updated_at`, `voice_script`) VALUES
(1, 2, 'Mom', '2026-02-04 01:23:05', 'Default Ringtone', 'pending', '2026-02-03 23:13:05', '2026-02-03 23:13:05', 'general'),
(2, 2, 'Mom', '2026-02-04 04:01:05', 'Default Ringtone', 'pending', '2026-02-04 01:51:05', '2026-02-04 01:51:05', 'general'),
(3, 2, 'Police', '2026-02-04 03:59:53', 'Urgent', 'pending', '2026-02-04 01:57:53', '2026-02-04 01:57:53', 'general'),
(4, 2, 'Police', '2026-02-04 04:07:14', 'Urgent', 'pending', '2026-02-04 02:05:14', '2026-02-04 02:05:14', 'security_check'),
(5, 4, 'Emergency Security', '2026-02-05 07:27:07', 'Default Ringtone', 'pending', '2026-02-05 05:27:02', '2026-02-05 05:27:02', 'general'),
(6, 4, 'Police', '2026-02-05 07:31:11', 'Urgent', 'pending', '2026-02-05 05:29:11', '2026-02-05 05:29:11', 'security_check'),
(7, 6, 'Emergency Security', '2026-02-10 21:48:10', 'Default Ringtone', 'pending', '2026-02-06 15:38:57', '2026-02-10 19:48:05', 'security_check'),
(8, 7, 'Emergency Security', '2026-02-10 21:48:24', 'Default Ringtone', 'pending', '2026-02-10 19:48:19', '2026-02-10 19:48:19', 'general'),
(9, 6, 'Police', '2026-02-10 21:53:10', 'Urgent', 'pending', '2026-02-10 19:51:10', '2026-02-10 19:51:10', 'security_check'),
(10, 7, 'Police', '2026-02-10 21:53:24', 'Urgent', 'pending', '2026-02-10 19:51:24', '2026-02-10 19:51:24', 'security_check'),
(11, 8, 'Emergency Security', '2026-02-25 01:47:42', 'Default Ringtone', 'pending', '2026-02-24 23:47:37', '2026-02-24 23:47:37', 'general'),
(12, 8, 'Police', '2026-02-25 01:54:35', 'Urgent', 'pending', '2026-02-24 23:52:35', '2026-02-24 23:52:35', 'security_check'),
(13, 13, 'Emergency Security', '2026-03-03 08:13:51', 'Default Ringtone', 'pending', '2026-03-03 06:13:46', '2026-03-03 06:13:46', 'general'),
(14, 13, 'Police', '2026-03-03 08:17:07', 'Urgent', 'pending', '2026-03-03 06:15:07', '2026-03-03 06:15:07', 'security_check'),
(15, 16, 'Police', '2026-03-06 02:46:58', 'Urgent', 'pending', '2026-03-06 00:44:58', '2026-03-06 00:44:58', 'security_check');

-- --------------------------------------------------------

--
-- Table structure for table `global_zones`
--

CREATE TABLE `global_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius` int(11) NOT NULL DEFAULT 500,
  `type` enum('safe','danger') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `global_zones`
--

INSERT INTO `global_zones` (`id`, `name`, `latitude`, `longitude`, `radius`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Safe Zone - Police Station', 30.04440000, 31.23570000, 500, 'safe', '2026-02-24 20:32:08', '2026-02-24 20:32:08'),
(2, 'Danger Area - Warning', 30.05000000, 31.24000000, 300, 'danger', '2026-02-24 20:32:08', '2026-02-24 20:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location_text` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','reviewed','action_taken','closed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `user_id`, `type`, `description`, `location_text`, `latitude`, `longitude`, `media_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'Harassment', 'Someone is following me', '123 Main street', NULL, NULL, 'uploads/incidents/1770397648_heba.jpg', 'pending', '2026-02-06 17:07:28', '2026-02-06 17:07:28'),
(2, 7, 'Harassment', 'I saw a blue car following me near the park', 'Main street, Anytown', NULL, NULL, 'uploads/incidents/1770767546_Fruit Classifier 2025-12-02 00-32-18.mp4', 'pending', '2026-02-10 23:52:26', '2026-02-10 23:52:26'),
(3, 9, 'Harassment', 'I saw a blue car following me near the park', 'Main street, Anytown', NULL, NULL, 'uploads/incidents/1771977838_Fruit Classifier 2025-12-02 00-32-18.mp4', 'pending', '2026-02-25 00:03:58', '2026-02-25 00:03:58'),
(4, 16, 'Harassment', 'I saw a blue car following me near the park', 'Main street, Anytown', NULL, NULL, NULL, 'pending', '2026-03-06 00:42:59', '2026-03-06 00:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_03_130114_add_timer_to_voice_passwords_table', 2),
(5, '2026_02_03_220215_add_details_to_emergency_contacts_table', 3),
(6, '2026_02_03_225205_create_safety_timers_table', 4),
(7, '2026_02_04_034618_add_status_to_fake_calls_table', 5),
(8, '2026_02_04_040034_add_voice_script_to_fake_calls_table', 6),
(9, '2026_02_05_042202_add_profile_fields_to_users_table', 7),
(10, '2026_02_05_082422_add_location_to_trusted_contacts_table', 8),
(12, '2026_02_05_214455_add_heart_rate_monitoring_to_users', 9),
(13, '2026_02_24_222643_create_global_zones_table', 10),
(14, '2026_03_14_050638_add_social_ids_to_users_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('Aya@gmail.com', '7869', '2026-03-14 23:48:37'),
('salz@gmail.com', '3515', '2026-03-14 23:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api-token', 'd23b09879679ae14d853e667a3512b198d51d22be617bb360037a50c1a3b55f4', '[\"*\"]', NULL, NULL, '2026-01-29 23:48:08', '2026-01-29 23:48:08'),
(2, 'App\\Models\\User', 1, 'api-token', 'c20b112a5f4618827d5ec5cefaae7937a4b1e4d1eaa6fcfe36e12825a7591fb1', '[\"*\"]', NULL, NULL, '2026-01-29 23:50:00', '2026-01-29 23:50:00'),
(10, 'App\\Models\\User', 3, 'api-token', 'eeba29de45122b5efcee0a4048ca22e4c9ec141e628458db0fefb1a6506e7338', '[\"*\"]', NULL, NULL, '2026-02-05 04:43:56', '2026-02-05 04:43:56'),
(13, 'App\\Models\\User', 4, 'api-token', 'e1f2bc36a640017c170044da3f452e26b3d4a5487988ff6de9389e1db6b1e89c', '[\"*\"]', '2026-02-06 00:03:03', NULL, '2026-02-05 06:12:01', '2026-02-06 00:03:03'),
(14, 'App\\Models\\User', 4, 'api-token', '0599803c5db76c741513c3e8609a3616ab346c88b113f07c82483c53e5cc8948', '[\"*\"]', '2026-02-06 01:28:16', NULL, '2026-02-05 07:09:49', '2026-02-06 01:28:16'),
(15, 'App\\Models\\User', 5, 'api-token', '72f50bab962df5e299753ea59607c8b0b80ae2a625401da084fce51372fc1e7c', '[\"*\"]', NULL, NULL, '2026-02-06 14:36:31', '2026-02-06 14:36:31'),
(16, 'App\\Models\\User', 5, 'api-token', 'db18ef570984e387fc39748daa959668f2f23f8badffe4d970cff78e7d0043a9', '[\"*\"]', '2026-02-06 15:30:53', NULL, '2026-02-06 14:37:46', '2026-02-06 15:30:53'),
(17, 'App\\Models\\User', 6, 'api-token', 'b6ef7d8e8eff99ae6f926ec841c10f022354ffb7c26d4f61f489a2380e98d481', '[\"*\"]', '2026-02-10 20:28:15', NULL, '2026-02-06 15:35:03', '2026-02-10 20:28:15'),
(19, 'App\\Models\\User', 6, 'api-token', 'cc2d3bbac7c3233033ea96a1b095f9ce40b20b6b222d50c5aa53c075ff176644', '[\"*\"]', '2026-02-06 19:58:11', NULL, '2026-02-06 17:05:01', '2026-02-06 19:58:11'),
(20, 'App\\Models\\User', 7, 'api-token', 'ea34dac4c1717c844aa81001818b8de1bbae82ff6a01cf97fb13d3ab67b14d0a', '[\"*\"]', NULL, NULL, '2026-02-10 19:40:40', '2026-02-10 19:40:40'),
(22, 'App\\Models\\User', 7, 'api-token', 'bc5b75fb0cec2faa0f115334104ff12d3bf2d157373baea2cfa7a6da65444adc', '[\"*\"]', '2026-02-25 00:49:33', NULL, '2026-02-10 20:32:18', '2026-02-25 00:49:33'),
(23, 'App\\Models\\User', 7, 'api-token', '8402c55de25d7dc602f5dbfd066c5b93a58894015d1ed6114a8743c7a8478054', '[\"*\"]', '2026-02-20 19:23:23', NULL, '2026-02-20 15:00:29', '2026-02-20 19:23:23'),
(24, 'App\\Models\\User', 7, 'api-token', 'cf4057abd45e4cfaa494be8350d5d7ee83609b41da18449c53b795f599f3ff09', '[\"*\"]', '2026-02-24 22:47:06', NULL, '2026-02-24 22:46:39', '2026-02-24 22:47:06'),
(27, 'App\\Models\\User', 9, 'api-token', 'c1d28f80385670080b5be79d842ded2427e1ca1bd0f135beed59aafc4687d3c2', '[\"*\"]', NULL, NULL, '2026-02-24 23:57:00', '2026-02-24 23:57:00'),
(29, 'App\\Models\\User', 9, 'api-token', '85dbc38e007a69c316e15ccc9885266972d8107188a67e02636ce64e8dd95189', '[\"*\"]', '2026-02-25 01:23:23', NULL, '2026-02-25 00:02:31', '2026-02-25 01:23:23'),
(30, 'App\\Models\\User', 10, 'api-token', '796f0b83e734ec7d9de04117774b2dddf7fa6861cb7fe9d9e99565168d280d30', '[\"*\"]', NULL, NULL, '2026-02-25 01:24:31', '2026-02-25 01:24:31'),
(31, 'App\\Models\\User', 9, 'api-token', '655ae4de5daef8af5f21f0d2cfb04f7db9f15b293614a95e49990fd9f9198503', '[\"*\"]', '2026-02-25 01:26:30', NULL, '2026-02-25 01:24:43', '2026-02-25 01:26:30'),
(32, 'App\\Models\\User', 11, 'api-token', '917f76f4b400bd56c20664ed898ee72deb764a3524619aa7a088c0a033ae91f5', '[\"*\"]', NULL, NULL, '2026-03-01 12:33:46', '2026-03-01 12:33:46'),
(33, 'App\\Models\\User', 11, 'api-token', '319a280737740ad59f7fae97c8ac3dbf6ad5bbb143726459eda7a06196a9f87d', '[\"*\"]', '2026-03-01 12:44:42', NULL, '2026-03-01 12:34:43', '2026-03-01 12:44:42'),
(34, 'App\\Models\\User', 11, 'api-token', 'd1d2360ce9e5450f6ccce4b9a3662fbbea4ad8067c243cecc1d3e1eac116d815', '[\"*\"]', '2026-03-03 01:07:17', NULL, '2026-03-03 00:29:57', '2026-03-03 01:07:17'),
(35, 'App\\Models\\User', 12, 'api-token', 'bc435fcee03f547548fe61fea8a39cd8aeb4d5de381680c5d6f893513054ea70', '[\"*\"]', NULL, NULL, '2026-03-03 01:13:23', '2026-03-03 01:13:23'),
(36, 'App\\Models\\User', 12, 'api-token', 'df7ee2e9a8be8822662429ad53283808c41ef7f1a85859bcdf61843fca40bef1', '[\"*\"]', '2026-03-03 06:11:09', NULL, '2026-03-03 01:13:35', '2026-03-03 06:11:09'),
(37, 'App\\Models\\User', 13, 'api-token', '132aa4d47994949b4fcde2d01770eab8a2b17a9fc6187ff04556e5f8e3d1c6ac', '[\"*\"]', '2026-03-05 18:46:49', NULL, '2026-03-03 05:17:11', '2026-03-05 18:46:49'),
(38, 'App\\Models\\User', 13, 'api-token', 'b411414becca17453bde996ae2ee16abfff48f859307612c3368bcad50bbc0d1', '[\"*\"]', '2026-03-03 06:16:55', NULL, '2026-03-03 06:09:52', '2026-03-03 06:16:55'),
(39, 'App\\Models\\User', 14, 'api-token', '1587fc1c43aa6885fb45f2113acd6e934d2ba1afdd1bc1f0a55ccdcb42867fcb', '[\"*\"]', NULL, NULL, '2026-03-05 17:53:21', '2026-03-05 17:53:21'),
(40, 'App\\Models\\User', 14, 'api-token', 'fd951456c0a06e4c8e033acd01aac44785e50eef3e82c8302e47bb94e5315522', '[\"*\"]', '2026-03-05 18:57:24', NULL, '2026-03-05 17:53:43', '2026-03-05 18:57:24'),
(41, 'App\\Models\\User', 15, 'api-token', 'cd04e966458fefdf6fb631362a1e17bb606d9ef6f882c17bfa6c2551b27c4376', '[\"*\"]', NULL, NULL, '2026-03-05 19:00:41', '2026-03-05 19:00:41'),
(42, 'App\\Models\\User', 15, 'api-token', '20a4fbd5ec177e1775c34bbaceaa656db2cff28a51bd63de26ef3664d50f74ef', '[\"*\"]', '2026-03-06 00:35:09', NULL, '2026-03-05 19:00:57', '2026-03-06 00:35:09'),
(43, 'App\\Models\\User', 15, 'api-token', '48cbd50bac86602b4af2ae280bd8960e0d92fa0d03841613a7ee4c82a71f1ddc', '[\"*\"]', '2026-03-05 19:15:49', NULL, '2026-03-05 19:15:20', '2026-03-05 19:15:49'),
(44, 'App\\Models\\User', 15, 'api-token', '1d1a8a1a28ffe1a6c3dc81327cb09acbb4c282f78ce4a6567093ea3a3260b8f4', '[\"*\"]', '2026-03-05 19:54:50', NULL, '2026-03-05 19:17:08', '2026-03-05 19:54:50'),
(45, 'App\\Models\\User', 15, 'api-token', 'cfe7ab59950868e9877e61c47a4cc6e7e67fe0dd8ed91f6e077349284f233034', '[\"*\"]', '2026-03-05 19:55:43', NULL, '2026-03-05 19:55:25', '2026-03-05 19:55:43'),
(46, 'App\\Models\\User', 15, 'api-token', '6364989694dc4fa4c3bea97acb2ecc8a565665ac1ad30932857221f1f52ea8bc', '[\"*\"]', NULL, NULL, '2026-03-05 20:12:13', '2026-03-05 20:12:13'),
(47, 'App\\Models\\User', 16, 'api-token', '16f9e3f2cb2000769df63828584a7d91632144e95b8ad8faa9a02e3f90a90d79', '[\"*\"]', NULL, NULL, '2026-03-05 20:13:08', '2026-03-05 20:13:08'),
(48, 'App\\Models\\User', 16, 'api-token', '4c937bb659dbafc4d49fc416ca60a3297ca70df4909c6b1fb0d2a847764a35ff', '[\"*\"]', '2026-03-06 00:45:45', NULL, '2026-03-05 20:13:29', '2026-03-06 00:45:45'),
(49, 'App\\Models\\User', 17, 'api-token', 'b4c891fc8fd1eb9cf4c8aedc0e16179c5761be9f44f3878a863434e1b75661a5', '[\"*\"]', NULL, NULL, '2026-03-14 03:29:31', '2026-03-14 03:29:31'),
(50, 'App\\Models\\User', 16, 'api-token', '83374defdc869cb924626ec47a8d03ae3144bf6fd16273b5d8c665760f26ce7b', '[\"*\"]', NULL, NULL, '2026-03-14 03:42:52', '2026-03-14 03:42:52'),
(51, 'App\\Models\\User', 18, 'api-token', '9c1f3750d153a26fb02035d45f0195ae891401d7ce530285d5739875fc92039e', '[\"*\"]', NULL, NULL, '2026-03-14 23:42:30', '2026-03-14 23:42:30'),
(52, 'App\\Models\\User', 18, 'api-token', 'c4e42c98cb6021372ccfbf654dbcc5cb462c1092c53898d975ddbb38b7d34e60', '[\"*\"]', NULL, NULL, '2026-03-14 23:42:49', '2026-03-14 23:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `safety_timers`
--

CREATE TABLE `safety_timers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('active','completed','triggered','canceled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `safety_timers`
--

INSERT INTO `safety_timers` (`id`, `user_id`, `expires_at`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, '2026-02-06 03:16:04', 'canceled', '2026-02-06 01:15:04', '2026-02-06 01:17:10'),
(3, 6, '2026-02-06 17:47:23', 'active', '2026-02-06 15:46:23', '2026-02-06 15:46:23'),
(4, 7, '2026-02-10 21:51:07', 'canceled', '2026-02-10 19:50:07', '2026-02-10 19:50:57'),
(7, 13, '2026-03-03 08:15:24', 'canceled', '2026-03-03 06:14:24', '2026-03-03 06:14:37'),
(8, 16, '2026-03-06 02:46:31', 'canceled', '2026-03-06 00:45:31', '2026-03-06 00:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('51qJvvxMd20BIziQOK9MhWRsKiqM1bVU6uUztR8M', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDBZb214NW5seThHVWQ5WktkY0hyMXhpcHMxWFZPZk1ZQVNhQmhvQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772524734),
('5jAjGgGZMhDP2exWCUBVYaujfkqLyFBwj3WmHixW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWRubWtqaE9sNjl3ekdBU0Y1VmtuY0lVSVRJckx1N01JemNVM3JQWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769745343),
('6zcXeAVdJ4m95bHRaY92kFb2oWR1HINF2gADBLnb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiampidFp3YUx0dWR4bW5DTTBPZ3dTbWh5THlkaUoxaG1rTFFvU09KWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770752416),
('AHvfYyGWsOZHrm4qAwHM4V1WvjcnB9xxoy2I1IsB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYk55ak1LaDJtenRVUWZmd1h3MEZiZm0xZFdSMjdnTlRDYTdGV2xxTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771599114),
('aWqAnpG98UFyCxcrXJU815GuKZUqyC4hjEMK0325', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzBGMEdPN2g0aWVURFpHTDY1MFBOQWgxOE4xMkk0NUp5bU10Rm9GYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771973146),
('bznoXOB5SiZ9xMzYDeQVMZTCjpAonLngjGbUg26S', NULL, '127.0.0.1', 'WhatsApp/2.2587.10 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialhKRG1nUGNoMWUwOFlNbHRkaUxVQjVtaWZBd2pYRk9HRE5udnc0QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770275099),
('C0njXTIEwQvGIk7ZwjXOn5JBE4cymARXAf5MJqgm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1U4dFBYYm1tVm5GM1J1aTNkanJwdVdyeFFQS2hId2FZQktoczJlNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770120629),
('cKgZR6H6T7141GZRmu1uGBhL1LSi4wUYt2so9Kbl', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMW80UHVnbHNFT3ZncFJVMXoxYjBJc3Y4TGhhV3J5MWhVd2JEYkRiMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770179816),
('DnZQGVrAcAGpxkurGQs2stBSqU3HwwCKTCbAEWYZ', NULL, '127.0.0.1', 'PostmanRuntime/7.51.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0R6M2VhWnluYkxlclFjd214eFI1TEZDa3l6UkhvRzF5UmdrTlVvaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770392411),
('GC82KRTGYXPlON5mwFgwf7qWxPs86vGBCTeV3Tgn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1NpeVVyTGZYZ0lyRmlDSk13empRM0JiYW9LNEIyTzdHY083Z2UyQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770169859),
('gNbLicMM3AIhViPmzdpwnDgezLG48ytj6vf9gz9X', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS3h6SjE5Q3ROOUxtU1dER2hTNE1hcjBWbjVOb1JwM0N4S3lseWRiUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772733010),
('Ij5ZPMbUW4GMIK5V2VHrx6dugyXIr1CTK6cQYv3y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmxmQnB2aFJPRjN1MkVsS3VUUWYyR2tsTHpqSHc5UUVST1FORnM2cCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772497689),
('kqohBFYNoUFoR1SvxuZpTCPyEwaI6mfNPxqfLqjd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidU9UTmVaYkFPaENEaFdYNzNHc1BhOTdrRTgwcFIzV0Q5dTQwcVVPUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770387682),
('s7cBLwX00oPGtm2F3zBnyFLaJ1EF5crmhoGA90Nj', NULL, '127.0.0.1', 'PostmanRuntime/7.51.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDNkeWw5YVMxUmlrSXRScVRmZkIwOFB2eUtncHJQdnlxNkxmWTFJNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770166614),
('v8pF2dFJS3iQGMHxV2mMvWAr4Ewi3caJPdKREogk', NULL, '127.0.0.1', 'WhatsApp/2.2587.9 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW41d1l0SFBwNm5VdUtPZ2dzcGZlQkoyN2tqMFphRXN3c2dSZ0ZLOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770179776),
('VAnag3IuAEoAqlf1In3nibYZt3S9stMxJrlc0yAM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWo4a2FvSzRRMFZrOTlMVmZjMXQ1ZjRaV3gzN21CNDFWSlV0bTF2ayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772368345),
('vqbOW5MVP1ZKtUBr5dkxnNnd2oDJtCo8HCtZH9Sg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlhHUWNYb051eGlEamgxVlYzNERGNVRtY0VSaVlZUXJDUWk2QnBuTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770260739);

-- --------------------------------------------------------

--
-- Table structure for table `sos_alerts`
--

CREATE TABLE `sos_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `trigger_type` varchar(255) NOT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sos_alerts`
--

INSERT INTO `sos_alerts` (`id`, `user_id`, `status`, `latitude`, `longitude`, `trigger_type`, `audio_path`, `created_at`, `updated_at`) VALUES
(1, 2, 'active', 30.04440000, 31.23570000, 'manual', 'recordings/OhV3HT6IsyUftnnTodyrs2EdllJJ1wxKB7cOaZqp.mp4', '2026-02-04 02:57:59', '2026-02-04 03:22:46'),
(2, 2, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-04 04:00:51', '2026-02-04 04:00:51'),
(3, 2, 'resolved', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-04 04:40:18', '2026-02-04 05:07:32'),
(4, 4, 'resolved', 30.04440000, 31.23570000, 'ai_voice', NULL, '2026-02-05 07:12:22', '2026-02-05 07:17:56'),
(5, 4, 'active', 30.04550000, 31.23680000, 'voice_password', NULL, '2026-02-05 07:31:56', '2026-02-05 23:21:43'),
(6, 4, 'active', 30.04440000, 31.23570000, 'voice_password', NULL, '2026-02-05 09:37:46', '2026-02-05 09:37:46'),
(7, 4, 'resolved', 30.05000000, 31.25000000, 'manual', NULL, '2026-02-05 21:18:59', '2026-02-25 01:23:12'),
(8, 4, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-05 23:52:52', '2026-02-05 23:52:52'),
(9, 7, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-10 20:23:08', '2026-02-10 20:23:08'),
(10, 7, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-10 20:27:20', '2026-02-10 20:27:20'),
(11, 7, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-02-11 00:18:41', '2026-03-03 01:07:17'),
(12, 7, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-02-11 00:30:08', '2026-03-03 01:14:12'),
(13, 7, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-11 00:45:02', '2026-02-11 00:45:02'),
(14, 7, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-25 00:49:33', '2026-02-25 00:49:33'),
(15, 9, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-02-25 00:50:49', '2026-02-25 00:50:49'),
(16, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:15:08', '2026-03-03 01:15:08'),
(17, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:23:07', '2026-03-03 01:23:07'),
(18, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:31:06', '2026-03-03 01:31:06'),
(19, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:36:46', '2026-03-03 01:36:46'),
(20, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:40:42', '2026-03-03 01:40:42'),
(21, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 01:57:07', '2026-03-03 01:57:07'),
(22, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 02:09:57', '2026-03-03 02:09:57'),
(23, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 02:29:27', '2026-03-03 02:29:27'),
(24, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 02:30:39', '2026-03-03 02:30:39'),
(25, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 02:34:56', '2026-03-03 02:34:56'),
(26, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 02:43:50', '2026-03-03 02:43:50'),
(27, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:09:18', '2026-03-03 03:09:18'),
(28, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:31:34', '2026-03-03 03:31:34'),
(29, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:33:35', '2026-03-03 03:33:35'),
(30, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:34:21', '2026-03-03 03:34:21'),
(31, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:36:43', '2026-03-03 03:36:43'),
(32, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:43:43', '2026-03-03 03:43:43'),
(33, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 03:55:58', '2026-03-03 03:55:58'),
(34, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:00:02', '2026-03-03 04:00:02'),
(35, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:03:24', '2026-03-03 04:03:24'),
(36, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:16:27', '2026-03-03 04:16:27'),
(37, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:21:22', '2026-03-03 04:21:22'),
(38, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:29:05', '2026-03-03 04:29:05'),
(39, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:32:19', '2026-03-03 04:32:19'),
(40, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:40:43', '2026-03-03 04:40:43'),
(41, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:41:37', '2026-03-03 04:41:37'),
(42, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:43:44', '2026-03-03 04:43:44'),
(43, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 04:59:16', '2026-03-03 04:59:16'),
(44, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 05:09:06', '2026-03-03 05:09:06'),
(45, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 05:12:52', '2026-03-03 05:12:52'),
(46, 12, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 05:15:35', '2026-03-03 05:15:35'),
(47, 13, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 05:19:26', '2026-03-03 05:19:26'),
(48, 13, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 05:23:12', '2026-03-03 05:23:12'),
(49, 13, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-03 06:15:27', '2026-03-03 06:15:27'),
(50, 14, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-05 18:56:00', '2026-03-05 18:56:00'),
(51, 15, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-03-05 19:01:21', '2026-03-05 19:01:21'),
(52, 16, 'active', 31.04090000, 31.37850000, 'manual', NULL, '2026-03-06 00:34:29', '2026-03-06 00:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `destination_name` varchar(255) NOT NULL,
  `destination_lat` decimal(10,8) NOT NULL,
  `destination_long` decimal(11,8) NOT NULL,
  `estimated_time` int(11) NOT NULL,
  `safety_notes` text DEFAULT NULL,
  `trusted_contact_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('started','reached','stopped','emergency') NOT NULL DEFAULT 'started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `user_id`, `destination_name`, `destination_lat`, `destination_long`, `estimated_time`, `safety_notes`, `trusted_contact_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 'نادي جزيرة الورد', 31.04090000, 31.37850000, 15, 'راكبة ميكروباص أبيض، رقم اللوحة 1234', 1, 'emergency', '2026-03-06 00:08:40', '2026-03-06 00:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `trusted_contacts`
--

CREATE TABLE `trusted_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lng` decimal(11,8) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Nearby',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trusted_contacts`
--

INSERT INTO `trusted_contacts` (`id`, `user_id`, `name`, `phone`, `lat`, `lng`, `relation`, `is_online`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', 0, 'Nearby', '2026-02-05 06:15:25', '2026-02-05 06:15:25'),
(2, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', 1, 'Nearby', '2026-02-05 06:16:08', '2026-02-05 06:16:08'),
(3, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', 1, 'Nearby', '2026-02-05 06:29:46', '2026-02-05 06:29:46'),
(4, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', 1, 'Nearby', '2026-02-05 09:33:09', '2026-02-05 09:33:09'),
(5, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', 0, 'Nearby', '2026-02-05 09:36:12', '2026-02-05 09:36:12'),
(6, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', 0, 'Nearby', '2026-02-05 23:36:52', '2026-02-05 23:36:52'),
(7, 4, 'Mohamed Adel', '201551471747', 30.04440000, 31.23570000, 'Brother', 0, 'Nearby', '2026-02-05 23:45:01', '2026-02-05 23:45:01'),
(8, 5, 'Mohamed Adel', '201551471747', 30.04440000, 31.23570000, 'Brother', 0, 'Nearby', '2026-02-06 15:13:24', '2026-02-06 15:13:24'),
(9, 6, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-06 18:23:39', '2026-02-06 18:23:39'),
(10, 6, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-06 19:35:25', '2026-02-06 19:35:25'),
(11, 7, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-10 19:46:17', '2026-02-10 19:46:17'),
(12, 7, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-10 20:27:14', '2026-02-10 20:27:14'),
(13, 8, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-24 23:50:59', '2026-02-24 23:50:59'),
(14, 9, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-25 00:34:08', '2026-02-25 00:34:08'),
(15, 9, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', 0, 'offline', '2026-02-25 01:26:20', '2026-02-25 01:26:20'),
(17, 11, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 00:58:29', '2026-03-03 00:58:29'),
(18, 12, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 01:13:57', '2026-03-03 01:13:57'),
(19, 12, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 01:36:37', '2026-03-03 01:36:37'),
(20, 12, 'mama', '201222503727', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 05:08:50', '2026-03-03 05:08:50'),
(21, 12, 'shahd', '201141503945', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 05:12:41', '2026-03-03 05:12:41'),
(22, 12, 'Mohamed gamal', '201275858680', NULL, NULL, 'Brother', 0, 'offline', '2026-03-03 05:15:29', '2026-03-03 05:15:29'),
(23, 13, 'Amira', '201092773039', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 05:19:04', '2026-03-03 05:19:04'),
(24, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-03 05:23:04', '2026-03-03 05:23:04'),
(25, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-05 18:35:28', '2026-03-05 18:35:28'),
(26, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-05 18:46:49', '2026-03-05 18:46:49'),
(27, 15, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-05 19:11:34', '2026-03-05 19:11:34'),
(28, 15, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-05 19:15:42', '2026-03-05 19:15:42'),
(29, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', 0, 'offline', '2026-03-05 20:14:51', '2026-03-05 20:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `social_type` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'en',
  `fake_call_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `panic_button_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `notifications_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `phone_numder` varchar(20) DEFAULT NULL,
  `voice_password_enabled` tinyint(4) NOT NULL DEFAULT 1,
  `current_heart_rate` int(11) DEFAULT NULL,
  `current_motion` varchar(255) DEFAULT NULL,
  `emergency_threshold` int(11) NOT NULL DEFAULT 120
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `profile_image`, `password`, `google_id`, `facebook_id`, `social_type`, `blood_type`, `allergies`, `medical_conditions`, `remember_token`, `created_at`, `updated_at`, `language`, `fake_call_enabled`, `panic_button_enabled`, `notifications_enabled`, `phone_numder`, `voice_password_enabled`, `current_heart_rate`, `current_motion`, `emergency_threshold`) VALUES
(1, 'Heba', 'Ziad', 'heba@voxguard.com', NULL, NULL, '$2y$12$Eqtvjus6zhXg0ROIQhun6.gNGoHpD73zt.i/bDKuNZTzlURReekIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 23:48:08', '2026-01-30 00:05:43', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(3, 'Heba', 'Ziad', 'final.success@gmail.com', NULL, NULL, '$2y$12$vzt081ztR/S1DDG5z847F.xru8kHIUSrFSuN5huhwy8KzfmEL.6Ia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-05 04:43:56', '2026-02-05 04:43:56', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(4, 'Heba', 'Ziad', 'final@gmail.com', '+201551471741', NULL, '$2y$12$IAKNV4tf3Ai8YIE.cVrY4ueSRPaRZbx1aM2VfTFz6yqCgS1Djgohy', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-05 04:54:42', '2026-02-05 23:31:09', 'Egypt', 1, 1, 0, NULL, 1, 135, 'Still', 120),
(6, 'Heba', 'Ziad', 'mero@gmail.com', '+201551471741', NULL, '$2y$12$.YoQ4s/OZMal0WuC7im5DeAhebItLz.48MbKcQFw.VIkeg9R628gq', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-06 15:35:03', '2026-02-06 19:09:59', 'Egypt', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(7, 'Heba', 'Ziad', 'heba@gmail.com', '+201551471741', NULL, '$2y$12$s1Wop9YkLs1sNsFg6e/kvOOyhn3qKXGtWaNTnkGfryGJUaUucgXYC', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-10 19:40:38', '2026-02-10 20:33:11', 'Egypt', 0, 1, 1, NULL, 1, 135, 'Still', 120),
(9, 'Heba', 'Ziad', 'sara@gmail.com', '+201551471741', NULL, '$2y$12$nu3gcIzhuGbLqrOlSMvij.pYkRgVEL97GNMXd1bx6VHDhzPVyf9Lm', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-24 23:57:00', '2026-02-25 01:25:49', 'en', 0, 1, 1, NULL, 1, 135, 'Still', 120),
(10, 'may', 'Mohamed', 'MAY@gmail.com', '01272289099', NULL, '$2y$12$cj6eGjeO3LFHtNXyyeBFaOPWXk2UHISU0TAmSKfGULoL8aEaupVKO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 01:24:31', '2026-02-25 01:24:31', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(13, 'Roaa', 'ELmetwaly', 'sally@gmail.com', '+201551471741', NULL, '$2y$12$RxGvOeVymAIka64J8QMZue104GDlus.xqyPzZRK7gO0mJQgoLLbhS', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-03-03 05:17:10', '2026-03-03 06:12:30', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(15, 'Sally', 'Ziead', 'sallyz@gmail.com', '01014826185', NULL, '$2y$12$0YXGE0bBrDzbtjWfNEt/QOqhdjQpL0QswZq/Xfmg603t53tFzXyBW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-05 19:00:41', '2026-03-05 19:00:41', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(16, 'Eally', 'Ziead', 'salz@gmail.com', '01014826189', NULL, '$2y$12$3hF.e3Kc7eF3IMzcyRM8JO6ZUBU605ocuw.CCqCjyPAIuLY7F99X2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-05 20:13:08', '2026-03-05 20:13:08', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(17, 'Heba', 'Ziad', 'heba_test@gmail.com', NULL, NULL, '$2y$12$an9im9bJiSo614Edl4jaPO4lcaWuL5iAXVn0WjyTxkIJR5iYyxoba', '109876543210123456', NULL, 'google', NULL, NULL, NULL, NULL, '2026-03-14 03:29:31', '2026-03-14 03:29:31', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120),
(18, 'Aya', 'Ziead', 'Aya@gmail.com', '01272289429', NULL, '$2y$12$DbE.wYS5gmk1e5SH8I7qlutD5QMmAhu8MhM2xg98LCxZzwnxA5eES', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-14 23:42:30', '2026-03-14 23:42:30', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120);

-- --------------------------------------------------------

--
-- Table structure for table `voice_passwords`
--

CREATE TABLE `voice_passwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phrase` varchar(255) NOT NULL,
  `sensitivity` int(11) NOT NULL DEFAULT 50,
  `timer_duration` int(11) NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voice_passwords`
--

INSERT INTO `voice_passwords` (`id`, `user_id`, `phrase`, `sensitivity`, `timer_duration`, `created_at`, `updated_at`) VALUES
(1, 2, 'Help Me Now', 85, 5, '2026-02-03 10:22:27', '2026-02-03 11:19:50'),
(2, 4, 'Help Me Now', 85, 5, '2026-02-05 05:27:02', '2026-02-05 05:27:02'),
(3, 6, 'Help Me Now', 85, 5, '2026-02-06 15:39:20', '2026-02-06 15:39:20'),
(4, 7, 'Help Me Now', 85, 5, '2026-02-10 19:48:19', '2026-02-10 19:48:19'),
(5, 8, 'Help Me Now', 85, 5, '2026-02-24 23:47:37', '2026-02-24 23:47:37'),
(6, 13, 'Help Me Now', 85, 5, '2026-03-03 06:13:46', '2026-03-03 06:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius` int(11) NOT NULL DEFAULT 250,
  `type` enum('safe','moderate','high_alert') NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `crowd_level` varchar(255) NOT NULL DEFAULT 'medium',
  `lighting` varchar(255) NOT NULL DEFAULT 'medium',
  `is_automatic` tinyint(1) NOT NULL DEFAULT 0,
  `notify_family` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `user_id`, `name`, `latitude`, `longitude`, `radius`, `type`, `category`, `crowd_level`, `lighting`, `is_automatic`, `notify_family`, `created_at`, `updated_at`) VALUES
(26, NULL, 'Zamalek', 30.06680000, 31.22430000, 700, 'safe', 'Residential', 'medium', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(27, NULL, 'Maadi', 29.96530000, 31.27610000, 900, 'safe', 'Residential', 'medium', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(28, NULL, 'New Cairo', 30.01690000, 31.46070000, 1200, 'safe', 'Residential', 'low', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(29, NULL, 'Helwan Industrial Area', 29.84480000, 31.29610000, 1000, 'high_alert', 'Industrial', 'low', 'poor', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(30, NULL, 'Ezbet El Haggana', 30.04500000, 31.27650000, 900, 'high_alert', 'High-Density', 'high', 'poor', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(31, NULL, 'Garden City', 30.04650000, 31.23420000, 600, 'safe', 'Residential', 'low', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(32, NULL, 'Mansoura Downtown', 31.04040000, 31.37850000, 700, 'moderate', 'Commercial', 'high', 'medium', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(33, NULL, 'Mansoura University Area', 31.04210000, 31.35860000, 800, 'safe', 'Commercial', 'high', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(34, NULL, 'Talkha Area', 31.05390000, 31.37780000, 900, 'moderate', 'Residential', 'medium', 'medium', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(35, NULL, 'Industrial Mansoura', 31.05650000, 31.36300000, 1000, 'high_alert', 'Industrial', 'low', 'poor', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(36, NULL, 'Mansoura Popular Area', 31.03800000, 31.37900000, 900, 'high_alert', 'High-Density', 'high', 'poor', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(37, NULL, 'Mansoura Residential District', 31.04100000, 31.37700000, 700, 'safe', 'Residential', 'medium', 'good', 1, 1, '2026-03-05 21:19:02', '2026-03-05 21:19:02'),
(38, 16, 'My University', 31.04210000, 31.35860000, 500, 'safe', 'Personal', 'medium', 'medium', 0, 1, '2026-03-05 21:44:31', '2026-03-05 21:44:31'),
(39, 16, 'My University', 31.04210000, 31.35860000, 500, 'safe', 'Personal', 'medium', 'medium', 0, 1, '2026-03-05 21:45:26', '2026-03-05 21:45:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_logs`
--
ALTER TABLE `alert_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emergency_contacts_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fake_calls`
--
ALTER TABLE `fake_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_zones`
--
ALTER TABLE `global_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `safety_timers`
--
ALTER TABLE `safety_timers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `safety_timers_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sos_alerts`
--
ALTER TABLE `sos_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trusted_contacts`
--
ALTER TABLE `trusted_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `voice_passwords`
--
ALTER TABLE `voice_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert_logs`
--
ALTER TABLE `alert_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fake_calls`
--
ALTER TABLE `fake_calls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `global_zones`
--
ALTER TABLE `global_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `safety_timers`
--
ALTER TABLE `safety_timers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sos_alerts`
--
ALTER TABLE `sos_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trusted_contacts`
--
ALTER TABLE `trusted_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `voice_passwords`
--
ALTER TABLE `voice_passwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD CONSTRAINT `emergency_contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `safety_timers`
--
ALTER TABLE `safety_timers`
  ADD CONSTRAINT `safety_timers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
