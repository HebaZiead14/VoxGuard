-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 03:51 AM
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
  `voice_script` varchar(255) DEFAULT 'general',
  `audio_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fake_calls`
--

INSERT INTO `fake_calls` (`id`, `user_id`, `caller_name`, `scheduled_at`, `ringtone`, `status`, `created_at`, `updated_at`, `voice_script`, `audio_path`) VALUES
(1, 2, 'Mom', '2026-02-04 01:23:05', 'Default Ringtone', 'pending', '2026-02-03 23:13:05', '2026-02-03 23:13:05', 'general', NULL),
(2, 2, 'Mom', '2026-02-04 04:01:05', 'Default Ringtone', 'pending', '2026-02-04 01:51:05', '2026-02-04 01:51:05', 'general', NULL),
(3, 2, 'Police', '2026-02-04 03:59:53', 'Urgent', 'pending', '2026-02-04 01:57:53', '2026-02-04 01:57:53', 'general', NULL),
(4, 2, 'Police', '2026-02-04 04:07:14', 'Urgent', 'pending', '2026-02-04 02:05:14', '2026-02-04 02:05:14', 'security_check', NULL),
(5, 4, 'Emergency Security', '2026-02-05 07:27:07', 'Default Ringtone', 'pending', '2026-02-05 05:27:02', '2026-02-05 05:27:02', 'general', NULL),
(6, 4, 'Police', '2026-02-05 07:31:11', 'Urgent', 'pending', '2026-02-05 05:29:11', '2026-02-05 05:29:11', 'security_check', NULL),
(7, 6, 'Emergency Security', '2026-02-10 21:48:10', 'Default Ringtone', 'pending', '2026-02-06 15:38:57', '2026-02-10 19:48:05', 'security_check', NULL),
(8, 7, 'Emergency Security', '2026-02-10 21:48:24', 'Default Ringtone', 'pending', '2026-02-10 19:48:19', '2026-02-10 19:48:19', 'general', NULL),
(9, 6, 'Police', '2026-02-10 21:53:10', 'Urgent', 'pending', '2026-02-10 19:51:10', '2026-02-10 19:51:10', 'security_check', NULL),
(10, 7, 'Police', '2026-02-10 21:53:24', 'Urgent', 'pending', '2026-02-10 19:51:24', '2026-02-10 19:51:24', 'security_check', NULL),
(11, 8, 'Emergency Security', '2026-02-25 01:47:42', 'Default Ringtone', 'pending', '2026-02-24 23:47:37', '2026-02-24 23:47:37', 'general', NULL),
(12, 8, 'Police', '2026-02-25 01:54:35', 'Urgent', 'pending', '2026-02-24 23:52:35', '2026-02-24 23:52:35', 'security_check', NULL),
(13, 13, 'Emergency Security', '2026-03-03 08:13:51', 'Default Ringtone', 'pending', '2026-03-03 06:13:46', '2026-03-03 06:13:46', 'general', NULL),
(14, 13, 'Police', '2026-03-03 08:17:07', 'Urgent', 'pending', '2026-03-03 06:15:07', '2026-03-03 06:15:07', 'security_check', NULL),
(15, 16, 'Police', '2026-03-06 02:46:58', 'Urgent', 'pending', '2026-03-06 00:44:58', '2026-03-06 00:44:58', 'security_check', NULL),
(16, 28, 'Police', '2026-04-23 03:34:26', 'Urgent', 'pending', '2026-04-23 01:32:26', '2026-04-23 01:32:26', 'security_check', NULL),
(17, 28, 'Police', '2026-04-23 03:39:06', 'Urgent', 'pending', '2026-04-23 01:37:06', '2026-04-23 01:37:06', 'security_check', 'general_script.mp3'),
(18, 28, 'Police', '2026-04-23 03:43:36', 'Urgent', 'pending', '2026-04-23 01:41:36', '2026-04-23 01:41:36', 'security_check', 'general_script.mp3'),
(19, 28, 'Police', '2026-04-23 03:45:12', 'Urgent', 'pending', '2026-04-23 01:43:12', '2026-04-23 01:43:12', 'police', 'police_call.mp3');

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
(14, '2026_03_14_050638_add_social_ids_to_users_table', 11),
(15, '2026_03_19_052207_add_image_to_trusted_contacts_table', 12),
(16, '2026_03_30_230501_add_status_and_location_to_users_table', 13),
(17, '2026_04_23_025245_add_audio_path_to_fake_calls_table', 14);

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
('hebaziead6@gmail.com', '3693', '2026-04-20 20:08:56'),
('mohammedgamal0@gmail.com', '4011', '2026-04-21 15:53:51'),
('mohammedgamal9160@gmail.com', '2752', '2026-04-20 20:34:49'),
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
(31, 'App\\Models\\User', 9, 'api-token', '655ae4de5daef8af5f21f0d2cfb04f7db9f15b293614a95e49990fd9f9198503', '[\"*\"]', '2026-03-19 04:37:27', NULL, '2026-02-25 01:24:43', '2026-03-19 04:37:27'),
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
(42, 'App\\Models\\User', 15, 'api-token', '20a4fbd5ec177e1775c34bbaceaa656db2cff28a51bd63de26ef3664d50f74ef', '[\"*\"]', '2026-04-19 21:06:40', NULL, '2026-03-05 19:00:57', '2026-04-19 21:06:40'),
(43, 'App\\Models\\User', 15, 'api-token', '48cbd50bac86602b4af2ae280bd8960e0d92fa0d03841613a7ee4c82a71f1ddc', '[\"*\"]', '2026-03-05 19:15:49', NULL, '2026-03-05 19:15:20', '2026-03-05 19:15:49'),
(44, 'App\\Models\\User', 15, 'api-token', '1d1a8a1a28ffe1a6c3dc81327cb09acbb4c282f78ce4a6567093ea3a3260b8f4', '[\"*\"]', '2026-03-05 19:54:50', NULL, '2026-03-05 19:17:08', '2026-03-05 19:54:50'),
(45, 'App\\Models\\User', 15, 'api-token', 'cfe7ab59950868e9877e61c47a4cc6e7e67fe0dd8ed91f6e077349284f233034', '[\"*\"]', '2026-03-05 19:55:43', NULL, '2026-03-05 19:55:25', '2026-03-05 19:55:43'),
(46, 'App\\Models\\User', 15, 'api-token', '6364989694dc4fa4c3bea97acb2ecc8a565665ac1ad30932857221f1f52ea8bc', '[\"*\"]', NULL, NULL, '2026-03-05 20:12:13', '2026-03-05 20:12:13'),
(47, 'App\\Models\\User', 16, 'api-token', '16f9e3f2cb2000769df63828584a7d91632144e95b8ad8faa9a02e3f90a90d79', '[\"*\"]', NULL, NULL, '2026-03-05 20:13:08', '2026-03-05 20:13:08'),
(48, 'App\\Models\\User', 16, 'api-token', '4c937bb659dbafc4d49fc416ca60a3297ca70df4909c6b1fb0d2a847764a35ff', '[\"*\"]', '2026-03-30 21:48:17', NULL, '2026-03-05 20:13:29', '2026-03-30 21:48:17'),
(49, 'App\\Models\\User', 17, 'api-token', 'b4c891fc8fd1eb9cf4c8aedc0e16179c5761be9f44f3878a863434e1b75661a5', '[\"*\"]', NULL, NULL, '2026-03-14 03:29:31', '2026-03-14 03:29:31'),
(50, 'App\\Models\\User', 16, 'api-token', '83374defdc869cb924626ec47a8d03ae3144bf6fd16273b5d8c665760f26ce7b', '[\"*\"]', NULL, NULL, '2026-03-14 03:42:52', '2026-03-14 03:42:52'),
(51, 'App\\Models\\User', 18, 'api-token', '9c1f3750d153a26fb02035d45f0195ae891401d7ce530285d5739875fc92039e', '[\"*\"]', NULL, NULL, '2026-03-14 23:42:30', '2026-03-14 23:42:30'),
(52, 'App\\Models\\User', 18, 'api-token', 'c4e42c98cb6021372ccfbf654dbcc5cb462c1092c53898d975ddbb38b7d34e60', '[\"*\"]', NULL, NULL, '2026-03-14 23:42:49', '2026-03-14 23:42:49'),
(53, 'App\\Models\\User', 19, 'api-token', '4994ec0d3a8c8ea3da0588cf6b1c1e2dcd8dece37a5ab0584934cb13d2a8e505', '[\"*\"]', NULL, NULL, '2026-03-19 06:05:28', '2026-03-19 06:05:28'),
(54, 'App\\Models\\User', 20, 'api-token', 'a31b3da1c90512fa296638c2773c70f07b8183f93fd785535364c8f249af9c1c', '[\"*\"]', '2026-04-12 15:48:00', NULL, '2026-03-30 21:32:20', '2026-04-12 15:48:00'),
(55, 'App\\Models\\User', 21, 'api-token', 'f32af5e5e4f88bfc25a1a627b9d9702f141f1a2f9da5775beaed860cfdca66cb', '[\"*\"]', '2026-03-30 22:14:47', NULL, '2026-03-30 21:54:50', '2026-03-30 22:14:47'),
(56, 'App\\Models\\User', 21, 'api-token', '6739efc3079916b4c58cc6f24434b514cca60fddaa5f7962be42e95eee45ba4b', '[\"*\"]', '2026-04-12 15:47:53', NULL, '2026-03-30 21:58:31', '2026-04-12 15:47:53'),
(57, 'App\\Models\\User', 22, 'api-token', '084b6f970eeedfc21404b8c31f12183e816dbf4060d11385a7dadaa06df9644b', '[\"*\"]', NULL, NULL, '2026-04-12 12:43:18', '2026-04-12 12:43:18'),
(58, 'App\\Models\\User', 22, 'api-token', '645cdd15b61fcd3351c4207c01cbe41c16b2cce0faf6499b1b4f71de81fce1d1', '[\"*\"]', '2026-04-12 16:47:45', NULL, '2026-04-12 12:43:42', '2026-04-12 16:47:45'),
(59, 'App\\Models\\User', 22, 'api-token', '8fd710fcf68f07cfcd025d8906984db5535b6255337adc6a28401069d2fe2829', '[\"*\"]', '2026-04-12 14:57:39', NULL, '2026-04-12 14:53:11', '2026-04-12 14:57:39'),
(60, 'App\\Models\\User', 23, 'api-token', '8266e2a4a432c14f17854f2bea49d172f0d3413ddf9cfc959ef830d45efa4a3a', '[\"*\"]', '2026-04-12 16:33:20', NULL, '2026-04-12 15:51:19', '2026-04-12 16:33:20'),
(61, 'App\\Models\\User', 24, 'api-token', '85ee687f3a3137b26c2ba589b80a4287088a62002f63cabaa712fd8c2b356311', '[\"*\"]', '2026-04-12 18:02:33', NULL, '2026-04-12 16:12:18', '2026-04-12 18:02:33'),
(62, 'App\\Models\\User', 23, 'api-token', '6ddb6a884277a47497b9c50648a10acb6a197458dc72f3371828e0b273b119a4', '[\"*\"]', '2026-04-12 18:26:55', NULL, '2026-04-12 17:20:05', '2026-04-12 18:26:55'),
(63, 'App\\Models\\User', 23, 'api-token', 'd9b78868cec95ab1c99219f8224de10dcecc27a66059064731d985eb2a1021d7', '[\"*\"]', '2026-04-19 21:10:03', NULL, '2026-04-19 21:07:51', '2026-04-19 21:10:03'),
(64, 'App\\Models\\User', 25, 'api-token', 'c7e56de4ee04d03471400cf953b4fe87467a37b9d97857396734de02951eca05', '[\"*\"]', NULL, NULL, '2026-04-20 20:11:29', '2026-04-20 20:11:29'),
(65, 'App\\Models\\User', 25, 'api-token', '8e8297c3e5d181e2daac8c8ae53eeb90ab686c244d03376f83b1064ae4d63ed8', '[\"*\"]', NULL, NULL, '2026-04-20 20:12:02', '2026-04-20 20:12:02'),
(66, 'App\\Models\\User', 26, 'api-token', 'bf18d50207d7e8341e5cf0358d71c0764afda9a6a6801dc2b6c71a8415b65e0b', '[\"*\"]', NULL, NULL, '2026-04-20 20:55:19', '2026-04-20 20:55:19'),
(67, 'App\\Models\\User', 26, 'api-token', 'dd910418216a8abf276d960d751bf893cead453d157490b0810fc363646584ef', '[\"*\"]', NULL, NULL, '2026-04-20 20:55:55', '2026-04-20 20:55:55'),
(68, 'App\\Models\\User', 27, 'api-token', 'cbf221cced99a4f3692327a503664b4433b6f93c68166fbdfb77b3a86da8d480', '[\"*\"]', NULL, NULL, '2026-04-21 15:52:02', '2026-04-21 15:52:02'),
(69, 'App\\Models\\User', 27, 'api-token', '2996cde3fe25443e12d5e9890b9904e2d681815ff04d8c53ee5a172ef2bf94eb', '[\"*\"]', '2026-04-21 16:38:25', NULL, '2026-04-21 15:52:19', '2026-04-21 16:38:25'),
(70, 'App\\Models\\User', 27, 'api-token', 'ff1f6420700cd7fbb049228903e0c01c1a4e72ee2f939c91f52877de3ecbb995', '[\"*\"]', '2026-04-21 23:32:49', NULL, '2026-04-21 16:38:45', '2026-04-21 23:32:49'),
(71, 'App\\Models\\User', 28, 'api-token', '5fc6d9bff116fa5adc72dd44202dd059bc2de8816936825cfc17d7aa40d28775', '[\"*\"]', NULL, NULL, '2026-04-23 01:31:01', '2026-04-23 01:31:01'),
(72, 'App\\Models\\User', 28, 'api-token', 'c4988fbf116b2eece372092ea33862eb707d076f1e6992acd3213bd95901262f', '[\"*\"]', '2026-04-23 01:43:12', NULL, '2026-04-23 01:31:38', '2026-04-23 01:43:12');

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
('jATTWvwZXLmm3yEZIGepQX6NWnV8jfD89HZSvK0h', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlRqcG51OGNvN0dhQjdpRFBWM1F6NUdTRHozNE5CMmdyTG5HZGZpQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2L3Nvcy90cmFjay82MSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776814095),
('uSjMVjvwgutONgllxbTwaPp5SOKrMv3gyrai73uD', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjAxR1pjUXh0MzdxeGZFMkVsdGk0c1F5OWFKVlFnT3JSOEhOeWRmayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2L3Nvcy90cmFjay82MCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776808474),
('xMhD6mJTiJaXNls5LUU9wGNwo2g8qcQ1rU1EdNiq', NULL, '127.0.0.1', 'WhatsApp/2.2613.101 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSk10OW5SM0lGa09tTFY4WVhEMjhKUGVoZDNqY0hPZFRVSnp4bURKcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2L3Nvcy90cmFjay82MSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776810568),
('yfJUI9CltdmjQghzUGc5PAhf9n4CS0XidRXc82nv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFMwMm1YNG1YRWxyYW1CUUZYdU5lVU9wazFoR3Z6SlJ1bk9mUHZUOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2L3Nvcy90cmFjay82MSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776810555),
('YgAoMNyxRZOlX8RXPfC6llpt0o7Qy30AyspXXBSm', NULL, '127.0.0.1', 'WhatsApp/2.2613.101 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2x6Mlc0S2FhcG1Ra3NpeHBXSmRGUEJQVHhscjg2cUh0RDBuM05qUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sZXNpYS1kYW5jZWFibGUtbmV0dGx5Lm5ncm9rLWZyZWUuZGV2L3Nvcy90cmFjay82MSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776810649);

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
(52, 16, 'active', 31.04090000, 31.37850000, 'manual', NULL, '2026-03-06 00:34:29', '2026-03-06 00:34:29'),
(53, 15, 'active', 30.04440000, 31.23570000, 'manual', NULL, '2026-04-19 21:06:41', '2026-04-19 21:06:41'),
(54, 23, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-19 21:08:09', '2026-04-19 21:08:29'),
(55, 23, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-19 21:09:52', '2026-04-21 17:40:25'),
(56, 27, 'resolved', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-21 17:39:06', '2026-04-21 17:40:40'),
(57, 27, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-21 21:02:44', '2026-04-21 21:04:20'),
(58, 27, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-21 21:05:13', '2026-04-21 21:22:32'),
(59, 27, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-21 21:23:10', '2026-04-21 21:53:15'),
(60, 27, 'active', 30.05000000, 31.25000000, 'manual', NULL, '2026-04-21 21:53:26', '2026-04-21 21:56:37'),
(61, 27, 'notified', 30.05000000, 31.25000000, 'manual', 'recordings/sos_61.mp3', '2026-04-21 22:00:14', '2026-04-21 23:27:59'),
(62, 27, 'notified', 30.04440000, 31.23570000, 'manual', 'recordings/sos_62.mp3', '2026-04-21 23:30:18', '2026-04-21 23:30:32');

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
  `image` varchar(255) DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Nearby',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trusted_contacts`
--

INSERT INTO `trusted_contacts` (`id`, `user_id`, `name`, `phone`, `lat`, `lng`, `relation`, `image`, `is_online`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', NULL, 0, 'Nearby', '2026-02-05 06:15:25', '2026-02-05 06:15:25'),
(2, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', NULL, 1, 'Nearby', '2026-02-05 06:16:08', '2026-02-05 06:16:08'),
(3, 4, 'Mohamed Adel', '01551471747', NULL, NULL, 'Brother', NULL, 1, 'Nearby', '2026-02-05 06:29:46', '2026-02-05 06:29:46'),
(4, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', NULL, 1, 'Nearby', '2026-02-05 09:33:09', '2026-02-05 09:33:09'),
(5, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', NULL, 0, 'Nearby', '2026-02-05 09:36:12', '2026-02-05 09:36:12'),
(6, 4, 'Mohamed Adel', '01551471747', 30.04440000, 31.23570000, 'Brother', NULL, 0, 'Nearby', '2026-02-05 23:36:52', '2026-02-05 23:36:52'),
(7, 4, 'Mohamed Adel', '201551471747', 30.04440000, 31.23570000, 'Brother', NULL, 0, 'Nearby', '2026-02-05 23:45:01', '2026-02-05 23:45:01'),
(8, 5, 'Mohamed Adel', '201551471747', 30.04440000, 31.23570000, 'Brother', NULL, 0, 'Nearby', '2026-02-06 15:13:24', '2026-02-06 15:13:24'),
(9, 6, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-06 18:23:39', '2026-02-06 18:23:39'),
(10, 6, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-06 19:35:25', '2026-02-06 19:35:25'),
(11, 7, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-10 19:46:17', '2026-02-10 19:46:17'),
(12, 7, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-10 20:27:14', '2026-02-10 20:27:14'),
(13, 8, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-24 23:50:59', '2026-02-24 23:50:59'),
(14, 9, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-25 00:34:08', '2026-02-25 00:34:08'),
(15, 9, 'Mohamed Adel', '201551471747', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-02-25 01:26:20', '2026-02-25 01:26:20'),
(17, 11, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 00:58:29', '2026-03-03 00:58:29'),
(18, 12, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 01:13:57', '2026-03-03 01:13:57'),
(19, 12, 'Heba Ziead', '201272289429', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 01:36:37', '2026-03-03 01:36:37'),
(20, 12, 'mama', '201222503727', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 05:08:50', '2026-03-03 05:08:50'),
(21, 12, 'shahd', '201141503945', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 05:12:41', '2026-03-03 05:12:41'),
(22, 12, 'Mohamed gamal', '201275858680', NULL, NULL, 'Brother', NULL, 0, 'offline', '2026-03-03 05:15:29', '2026-03-03 05:15:29'),
(23, 13, 'Amira', '201092773039', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 05:19:04', '2026-03-03 05:19:04'),
(24, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-03 05:23:04', '2026-03-03 05:23:04'),
(25, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-05 18:35:28', '2026-03-05 18:35:28'),
(26, 13, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-05 18:46:49', '2026-03-05 18:46:49'),
(27, 15, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-05 19:11:34', '2026-03-05 19:11:34'),
(28, 15, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-05 19:15:42', '2026-03-05 19:15:42'),
(29, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-05 20:14:51', '2026-03-05 20:14:51'),
(30, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Sister', NULL, 0, 'offline', '2026-03-19 04:12:46', '2026-03-19 04:12:46'),
(31, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/w1NlUfo4pid71kO7QndnYEVwQFwd1LFv0KJTRlFr.jpg', 0, 'offline', '2026-03-19 04:14:58', '2026-03-19 04:14:58'),
(32, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/FF3faYdEU93RcrAkosmFEyAOroYqHDXQODjt1Mjt.jpg', 0, 'offline', '2026-03-19 04:24:32', '2026-03-19 04:24:32'),
(33, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/pWSGib6jw1kKfwbgQVDm3HM88PlwjfXShIStvw5R.jpg', 0, 'offline', '2026-03-30 21:30:06', '2026-03-30 21:30:06'),
(34, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/Rn6V4gmhgXk3D4izdvIwG6aJnpGb9u8VUxw1d0Hc.jpg', 0, 'offline', '2026-03-30 21:32:31', '2026-03-30 21:32:31'),
(35, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/KZIIVhWVgyHLbxDWuy3pfqd8rLOBErkcuDqEYFJZ.jpg', 0, 'offline', '2026-03-30 21:44:09', '2026-03-30 21:44:09'),
(36, 16, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/xjKYE9rSBfoMDM6RBk5L4EG6u5EalAkKqlguELaA.jpg', 0, 'offline', '2026-03-30 21:48:17', '2026-03-30 21:48:17'),
(37, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/h1yLcauUmfqhb56hakKHll9ndWt3law8SDda5kx6.jpg', 0, 'offline', '2026-03-30 21:57:25', '2026-03-30 21:57:25'),
(38, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/dLS5J0SDedRqDqg9UaLt4yUuuj8zXhKCnx7GCP9H.jpg', 0, 'offline', '2026-03-30 21:58:51', '2026-03-30 21:58:51'),
(39, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/ORhhdwAFCaTum9d8Vlebli5XELQMoW1cocCHjnMV.jpg', 0, 'offline', '2026-03-30 22:10:04', '2026-03-30 22:10:04'),
(40, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/JmdytY1PbEboVRQ4wJiHTOXkW605T04o5RAEe6E6.jpg', 0, 'offline', '2026-03-30 22:14:37', '2026-03-30 22:14:37'),
(41, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/M0J4TWlJKlD07cCtT8W8IoABwQfVPuUOBkmR4zt2.jpg', 0, 'offline', '2026-03-30 22:16:05', '2026-03-30 22:16:05'),
(42, 21, 'Mohamed Adel', '201551761045', NULL, NULL, 'Brother', 'contacts/Xo1sPJLSHXLH7UnJwVI9m6y4MnC7Zr32kzLQ0JUT.jpg', 0, 'offline', '2026-03-30 22:48:46', '2026-03-30 22:48:46'),
(43, 21, 'heba ziead', '01272289429', NULL, NULL, 'sister', NULL, 0, 'offline', '2026-04-12 14:41:33', '2026-04-12 14:41:33'),
(44, 22, 'heba ziead', '01272289429', NULL, NULL, 'sister', NULL, 0, 'offline', '2026-04-12 14:41:55', '2026-04-12 14:41:55'),
(45, 22, 'heba ziead', '01272289429', NULL, NULL, 'sister', 'contacts/YHVZlDjkC0863c05i4E3T0cwW2F7T8ux580sMTO4.jpg', 0, 'offline', '2026-04-12 14:42:29', '2026-04-12 14:42:29'),
(46, 22, 'heba ziead', '01272289429', NULL, NULL, 'sister', 'contacts/Chbx5tX9aqCLCkbaoyvELQKF1i5i0VaC1J7WBpjC.jpg', 0, 'offline', '2026-04-12 14:55:11', '2026-04-12 14:55:11'),
(47, 23, 'heba ziead', '01272289429', NULL, NULL, 'sister', 'contacts/qv2QtjylPmoUfnq1VJDrEDjTE7baM9dTqfekWTkd.jpg', 0, 'offline', '2026-04-12 15:53:55', '2026-04-12 15:53:55'),
(48, 23, 'heba ziead', '01272289429', NULL, NULL, 'sister', 'contacts/H70c4Azsnuqzo6hieeTLK00PsLmEQcas1Nkq1Pmt.jpg', 0, 'offline', '2026-04-12 15:57:14', '2026-04-12 15:57:14'),
(49, 23, 'heba ziead', '01000000000', NULL, NULL, 'sister', 'contacts/qxKvpzT0YPP5HY7jPnp3BPIvw5Fv5C5aafDjZydA.jpg', 0, 'offline', '2026-04-12 16:13:09', '2026-04-12 16:13:09'),
(50, 24, 'heba ziead', '01000000000', NULL, NULL, 'sister', 'contacts/QXNSq2etPcuWx48E0So5jspqyxDaXDfIRjpSbfZL.jpg', 0, 'offline', '2026-04-12 16:35:19', '2026-04-12 16:35:19'),
(51, 23, 'heba ziead', '01000000000', NULL, NULL, 'sister', 'contacts/FkIjFZMgOsPppz5he1K3oSOIkEsaXcOldFmivIFm.jpg', 0, 'offline', '2026-04-12 17:20:29', '2026-04-12 17:20:29'),
(52, 23, 'heba ziead', '01000000000', NULL, NULL, 'sister', 'contacts/2ECJ3tbd24QmulGqtTam5xaEhmwUj5GcLFQWGrVE.jpg', 0, 'offline', '2026-04-12 18:26:45', '2026-04-12 18:26:45'),
(53, 23, 'heba ziead', '01272289429', NULL, NULL, 'sister', NULL, 0, 'offline', '2026-04-19 21:09:35', '2026-04-19 21:09:35'),
(54, 27, 'heba ziead', '01272289429', NULL, NULL, 'sister', NULL, 0, 'offline', '2026-04-21 21:05:01', '2026-04-21 21:05:01'),
(55, 27, 'heba ziead', '201272289429', NULL, NULL, 'sister', NULL, 0, 'offline', '2026-04-21 21:23:00', '2026-04-21 21:23:00');

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
  `emergency_threshold` int(11) NOT NULL DEFAULT 120,
  `last_seen` timestamp NULL DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `profile_image`, `password`, `google_id`, `facebook_id`, `social_type`, `blood_type`, `allergies`, `medical_conditions`, `remember_token`, `created_at`, `updated_at`, `language`, `fake_call_enabled`, `panic_button_enabled`, `notifications_enabled`, `phone_numder`, `voice_password_enabled`, `current_heart_rate`, `current_motion`, `emergency_threshold`, `last_seen`, `latitude`, `longitude`) VALUES
(1, 'Heba', 'Ziad', 'heba@voxguard.com', NULL, NULL, '$2y$12$Eqtvjus6zhXg0ROIQhun6.gNGoHpD73zt.i/bDKuNZTzlURReekIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-29 23:48:08', '2026-01-30 00:05:43', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(3, 'Heba', 'Ziad', 'final.success@gmail.com', NULL, NULL, '$2y$12$vzt081ztR/S1DDG5z847F.xru8kHIUSrFSuN5huhwy8KzfmEL.6Ia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-05 04:43:56', '2026-02-05 04:43:56', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(4, 'Heba', 'Ziad', 'final@gmail.com', '+201551471741', NULL, '$2y$12$IAKNV4tf3Ai8YIE.cVrY4ueSRPaRZbx1aM2VfTFz6yqCgS1Djgohy', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-05 04:54:42', '2026-02-05 23:31:09', 'Egypt', 1, 1, 0, NULL, 1, 135, 'Still', 120, NULL, NULL, NULL),
(6, 'Heba', 'Ziad', 'mero@gmail.com', '+201551471741', NULL, '$2y$12$.YoQ4s/OZMal0WuC7im5DeAhebItLz.48MbKcQFw.VIkeg9R628gq', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-06 15:35:03', '2026-02-06 19:09:59', 'Egypt', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(7, 'Heba', 'Ziad', 'heba@gmail.com', '+201551471741', NULL, '$2y$12$s1Wop9YkLs1sNsFg6e/kvOOyhn3qKXGtWaNTnkGfryGJUaUucgXYC', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-10 19:40:38', '2026-02-10 20:33:11', 'Egypt', 0, 1, 1, NULL, 1, 135, 'Still', 120, NULL, NULL, NULL),
(9, 'Heba', 'Ziad', 'sara@gmail.com', '+201551471741', NULL, '$2y$12$nu3gcIzhuGbLqrOlSMvij.pYkRgVEL97GNMXd1bx6VHDhzPVyf9Lm', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-02-24 23:57:00', '2026-02-25 01:25:49', 'en', 0, 1, 1, NULL, 1, 135, 'Still', 120, NULL, NULL, NULL),
(10, 'may', 'Mohamed', 'MAY@gmail.com', '01272289099', NULL, '$2y$12$cj6eGjeO3LFHtNXyyeBFaOPWXk2UHISU0TAmSKfGULoL8aEaupVKO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 01:24:31', '2026-02-25 01:24:31', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(13, 'Roaa', 'ELmetwaly', 'sally@gmail.com', '+201551471741', NULL, '$2y$12$RxGvOeVymAIka64J8QMZue104GDlus.xqyPzZRK7gO0mJQgoLLbhS', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-03-03 05:17:10', '2026-03-03 06:12:30', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(15, 'Sally', 'Ziead', 'sallyz@gmail.com', '01014826185', NULL, '$2y$12$0YXGE0bBrDzbtjWfNEt/QOqhdjQpL0QswZq/Xfmg603t53tFzXyBW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-05 19:00:41', '2026-03-05 19:00:41', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(16, 'Eally', 'Ziead', 'salz@gmail.com', '01014826189', NULL, '$2y$12$3hF.e3Kc7eF3IMzcyRM8JO6ZUBU605ocuw.CCqCjyPAIuLY7F99X2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-05 20:13:08', '2026-03-05 20:13:08', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(20, 'Mohamed', 'Adel', 'MohamedAdel@gmail.com', '201551761045', NULL, '$2y$12$MhllAHtuFp7ZTVCHTlXR.O9lC7HILstjemu7geZZ6KRhVgrsHARfa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 21:32:20', '2026-03-30 21:43:14', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, '2026-03-30 21:43:14', 30.04440000, 31.23570000),
(21, 'ema', 'Adel', 'ema@gmail.com', '01272289867', NULL, '$2y$12$7TWE2GbI7JtKfJ7ASOXVpu6OtPBcd2FGDFjnPGZDxmtkhvEOcGzXC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-30 21:54:50', '2026-04-12 15:47:53', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, '2026-04-12 15:47:53', 30.04440000, 31.23570000),
(22, 'heba', 'ziead', 'hebaziead6@gmail.com', '01272289429', NULL, '$2y$12$GhlJsH.Xix4qDsq3qAtOTe8MQdrqREpWIxRZ3fnT5mFi1LiGL0mLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-12 12:43:17', '2026-04-12 12:43:17', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, '2026-04-12 18:25:55', NULL, NULL),
(23, 'hanna', 'Elmansouray', 'hanna@gmail.com', '01222503727', NULL, '$2y$12$r7g7hPZsDYtBshxVc2i6KehW1tFjnSKna6ktDHFnzy.OT77Gh3.kC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-12 15:51:19', '2026-04-12 15:51:19', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(24, 'test', 'Elmansouray', 'test@gmail.com', '01000000000', NULL, '$2y$12$pUXdy/1t.CFjejjMz/AfRu7ofN3CEavvy7ctHbO3I3hzLG/rAqLCu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-12 16:12:18', '2026-04-12 16:12:18', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(25, 'Mohamed', 'Elmansouray', 'mohammedgamal9160@gmail.com', '01275858680', NULL, '$2y$12$QuTopzWCZFGK9GfUuuIFGOBwY/oLmdlDustJP491zDLnv9Ro2Tonm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-20 20:11:28', '2026-04-20 20:11:28', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(27, 'Roaa', 'ELmetwaly', 'roaa@example.com', '201551471741', 'http://127.0.0.1:8000/storage/profiles/pZTEJhu9vt3l91Zdjp0Iv85se0gpyfdcMxXv5qwe.jpg', '$2y$12$NHTb7X6U2/KGoJSnDkt1KujzD38cl2iHl6TnldU7tzA0pPDrlXI3i', NULL, NULL, NULL, 'O Positive', 'Peanuts', 'None', NULL, '2026-04-21 15:52:02', '2026-04-21 17:03:28', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL),
(28, 'mamy', 'Elmansouray', 'mamy@gmail.com', '201011956677', NULL, '$2y$12$xFvpNlY9BeeTCoYJm2K/J.eIZSC3JLFadHjDzGzBHEWf2we.5uzDy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-23 01:31:01', '2026-04-23 01:31:01', 'en', 0, 1, 1, NULL, 1, NULL, NULL, 120, NULL, NULL, NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `safety_timers`
--
ALTER TABLE `safety_timers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sos_alerts`
--
ALTER TABLE `sos_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trusted_contacts`
--
ALTER TABLE `trusted_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
