-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 21, 2026 at 09:42 AM
-- Server version: 8.0.45
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT IGNORE INTO `clients` (`id`, `client_name`, `contact_person`, `address`, `tin`, `tel_phone_number`, `created_at`, `updated_at`) VALUES
(1, 'The Bored Creations', 'Omar Rabang', '399 Rizal Avenue Puerto Princesa City', '0000000000', '09359141800', '2026-03-02 19:14:47', '2026-03-02 19:14:47'),
(2, 'RODELYN DANAS', 'RODELYN DANAS', 'Narra Palawan', '123456789', '09563077596', '2026-03-09 13:03:28', '2026-03-09 13:03:28'),
(3, 'Anna May T. So', 'Anna May T. So', 'Brooke\'s Point', '248-504-962', '09175226363', '2026-03-10 06:04:50', '2026-03-10 06:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `form_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT IGNORE INTO `forms` (`id`, `form_name`, `created_at`, `updated_at`) VALUES
(1, 'Duly Accomplished Application Form', '2026-03-02 19:32:23', '2026-03-02 19:32:23'),
(2, 'Certificate of Registration (BIR Form 2303)', '2026-03-02 19:33:02', '2026-03-02 19:33:02'),
(3, 'Letter of Request', '2026-03-02 19:33:17', '2026-03-02 19:33:17'),
(4, 'Proof of Payment', '2026-03-02 19:33:34', '2026-03-02 19:33:34'),
(5, 'Barangay certificate', '2026-03-09 13:04:58', '2026-03-09 13:04:58'),
(6, 'Occupancy Permit', '2026-03-09 13:05:39', '2026-03-09 13:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_02_000003_add_role_to_users_table', 2),
(5, '2026_03_02_000004_add_status_to_users_table', 3),
(6, '2026_03_02_000005_create_clients_table', 4),
(7, '2026_03_02_000006_create_tasks_table', 5),
(8, '2026_03_02_000007_create_forms_table', 6),
(9, '2026_03_02_000008_create_task_monitorings_table', 7),
(10, '2026_03_02_000009_create_task_monitoring_form_notes_table', 8),
(11, '2026_03_02_000010_add_note_status_to_task_monitoring_form_notes_table', 9),
(12, '2026_03_02_000011_add_contact_person_to_clients_table', 10),
(13, '2026_03_02_000012_change_assigned_responsible_person_fk_to_clients_in_task_monitorings_table', 11),
(14, '2026_03_02_000013_add_submission_status_to_task_monitorings_table', 12),
(15, '2026_03_05_000014_add_submission_fields_to_task_monitorings_table', 13),
(16, '2026_03_05_000015_add_submission_decision_and_notes_to_task_monitorings_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2N0a9Ly6e4wdcqI0aPPSAdMGzbW2WvGpQCIbEvtG', 1, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFVJMFNkb2w1eUdDTGx5aU9nMnRpRlFhZ2lUZ05hcUk2T0o2OWY5diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zZXR0aW5ncz90YWI9dXNlcnMiO3M6NToicm91dGUiO3M6MTQ6InNldHRpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1773959307),
('4vLNrMKiVAv2EL32d0Dr9OJf7JEJQUP3JknbXP5T', NULL, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmNReFU1OGNYaFRQYWpWdVF1NFA0Y1FyRXNJVVZUUVc0dDhWcXEzUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773069938),
('5GehHlMeECK12Pqvi5YNNaWEVvaYK1n6e7f5KLCJ', NULL, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDJJaXBnd2lDdEcwU1JMeHowZ0I1a3pCVEtIZGYzUEhoM3MxbzczMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773122901),
('gDy8Oe19Y83FkSRQ2S3AmBSwjw9V6UYTBA9klMAn', 2, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWhRSG8ySEc3aG1iRkZ4c0xlUjZoUHJuR3M3Znk2RTE1bDdkcjhRSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2Jvb2tpbmdzLzQvZWRpdD9zaG93X3N1Ym1pc3Npb25fZm9ybT0xIjtzOjU6InJvdXRlIjtzOjEzOiJib29raW5ncy5lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1773132736),
('gN2P55p27n59KSDh1aZjlVwUjBuKlF9J5EgXlllP', NULL, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFFMYzg1WmFIcWdVcGUxVGlPRmdOMGI1bDJ5Y3l5N25UZUg1TDFLUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1773144863),
('mlhKG9TvasLL4XEQmp3gWkqm8PTVOCEckBAaG95I', NULL, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN0Z6cUFxU0lMdjlpYkZJckJZWm9mYThFazdNRWdoNm1BOEZoc2pIayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo3MToiaHR0cDovL2FycC50aGVib3JlZGNyZWF0aW9ucy5jb20vYm9va2luZ3MvNC9lZGl0P3Nob3dfc3VibWlzc2lvbl9mb3JtPTEiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozODoiaHR0cDovL2FycC50aGVib3JlZGNyZWF0aW9ucy5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1773141363),
('pcuctz0cZHV4AyA2xmwLjOorxEoSUU2k2IkPFMXP', NULL, '172.21.0.1', 'Mozilla/5.0 (iPad; CPU OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS;FBAV/549.1.0.40.107;FBBV/886965988;FBDV/iPad15,7;FBMD/iPad;FBSN/iPadOS;FBSV/26.2;FBSS/2;FBCR/;FBID/tablet;FBLC/en_US;FBOP/80]', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkt5YnlzdVVXWUtvSkVaWDlLZHp1M1dud0NnUFdINVI3UXdvNnd3aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773062779),
('shITu0Wl57aj9P2wFHD6KdtH8s9mIgQbCs5pY7EC', 1, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3RRTDJWWjJYSm1QV1ZtZ1ZiRmRyaEhmQ2NwcnVKQlZVYTdhS3RjMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoxNDoiYm9va2luZ3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773945395);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT IGNORE INTO `tasks` (`id`, `task_name`, `created_at`, `updated_at`) VALUES
(1, 'BIR Tax Clearance', '2026-03-02 19:26:05', '2026-03-02 19:26:05'),
(2, 'Business Permit', '2026-03-09 13:04:19', '2026-03-09 13:04:19'),
(3, 'Social Security System', '2026-03-10 06:06:10', '2026-03-10 06:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `task_monitorings`
--

CREATE TABLE IF NOT EXISTS `task_monitorings` (
  `id` bigint UNSIGNED NOT NULL,
  `date_task_received` date NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `assigned_responsible_person_id` bigint UNSIGNED NOT NULL,
  `required_forms_documents` json DEFAULT NULL,
  `submission_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `date_of_submission` date DEFAULT NULL,
  `receiving_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acknowledgement_receipt_reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_decision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_monitorings`
--

INSERT IGNORE INTO `task_monitorings` (`id`, `date_task_received`, `client_id`, `task_id`, `assigned_responsible_person_id`, `required_forms_documents`, `submission_status`, `date_of_submission`, `receiving_officer`, `acknowledgement_receipt_reference_number`, `submission_decision`, `submission_notes`, `created_at`, `updated_at`) VALUES
(1, '2026-03-02', 1, 1, 1, '[\"2\", \"1\", \"3\", \"4\"]', 'completed', '2026-03-05', 'Bong Go', '12345', 'accepted', 'waiting for maleta.', '2026-03-02 19:56:15', '2026-03-05 19:46:39'),
(2, '2026-03-12', 1, 1, 1, '[\"1\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-03-02 20:04:55', '2026-03-02 20:04:55'),
(3, '2026-03-05', 1, 1, 1, '[\"2\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-03-05 05:18:16', '2026-03-05 05:18:16'),
(4, '2026-03-10', 2, 2, 2, '[\"5\", \"6\"]', 'pending', '2026-03-10', 'mayor danao', '12345', 'pending', '[March 09, 2026 01:40 PM] test\n[March 09, 2026 01:40 PM] test 2', '2026-03-09 13:07:21', '2026-03-09 13:40:55'),
(5, '2026-03-10', 3, 3, 3, '[]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-03-10 08:34:25', '2026-03-10 08:34:25'),
(6, '2026-03-10', 3, 3, 3, '[\"5\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-03-10 08:40:29', '2026-03-10 08:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `task_monitoring_form_notes`
--

CREATE TABLE IF NOT EXISTS `task_monitoring_form_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `task_monitoring_id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `notes_remarks` text COLLATE utf8mb4_unicode_ci,
  `note_date` date DEFAULT NULL,
  `note_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_monitoring_form_notes`
--

INSERT IGNORE INTO `task_monitoring_form_notes` (`id`, `task_monitoring_id`, `form_id`, `notes_remarks`, `note_date`, `note_status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'hindi pa nya nasusubmit wala pang pirma\r\nwala pang pera\r\nnangutang pa kay lola\r\nbukas nalang\r\n[March 02, 2026 09:24 PM] ilam kanimo', '2026-03-02', 'completed', '2026-03-02 21:03:55', '2026-03-05 18:05:30'),
(2, 1, 1, NULL, '2026-03-02', 'completed', '2026-03-02 21:37:57', '2026-03-05 17:26:50'),
(3, 1, 3, NULL, '2026-03-02', 'completed', '2026-03-02 21:38:02', '2026-03-02 21:38:02'),
(4, 1, 4, NULL, '2026-03-02', 'completed', '2026-03-02 21:38:08', '2026-03-02 21:38:08'),
(5, 4, 5, '[March 09, 2026 01:12 PM] hay nako, pautang\r\n[March 09, 2026 01:14 PM] namatay ang pusa namin', '2026-03-09', 'completed', '2026-03-09 13:12:31', '2026-03-09 13:14:54'),
(6, 4, 6, '[March 09, 2026 01:15 PM] nagbakasyon si engineer', '2026-03-09', 'completed', '2026-03-09 13:15:41', '2026-03-09 13:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requester',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Omar Rabang', 'omarkleng@gmail.com', NULL, '$2y$12$.xSyl20.GP4euhK3McLtW.KPEcFNjT2Ye5GTKXq.ujybM/W5IJESC', 'admin', 'active', 'pFx3VAhW8Rp16Dnylwxkbi56J2XXZlE80rwTwiVINRJnQ5TRWSF3AO7b4R1G', '2026-02-28 11:43:24', '2026-03-01 20:01:43'),
(2, 'Mimi Jardin', 'mimi@gmail.com', NULL, '$2y$12$OzWrIHdDoHzTi29rAkcwJO0KoFs4ckFTvD0K5wrw50Y2sICYWWydy', 'requester', 'active', NULL, '2026-03-02 18:32:15', '2026-03-04 20:25:14'),
(3, 'Aires Rodriguez', 'aires@gmail.com', NULL, '$2y$12$WE005C8fHGJeu7p2UXUvd.7Rm1ulOGv8ors1ueJjSuyM2SNTQiXFa', 'requester', 'active', NULL, '2026-03-02 18:32:47', '2026-03-04 20:30:24'),
(4, 'Bossing Tina', 'tina@gmail.com', NULL, '$2y$12$qJYI7i7UIuNasOfudHUZl.A/dikLn4YF4hje0KRClCQLjqc.gz0DW', 'admin', 'active', NULL, '2026-03-04 20:18:33', '2026-03-04 20:18:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_monitorings`
--
ALTER TABLE `task_monitorings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_monitorings_client_id_foreign` (`client_id`),
  ADD KEY `task_monitorings_task_id_foreign` (`task_id`),
  ADD KEY `task_monitorings_assigned_responsible_person_id_foreign` (`assigned_responsible_person_id`);

--
-- Indexes for table `task_monitoring_form_notes`
--
ALTER TABLE `task_monitoring_form_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_monitoring_form_notes_task_monitoring_id_form_id_unique` (`task_monitoring_id`,`form_id`),
  ADD KEY `task_monitoring_form_notes_form_id_foreign` (`form_id`);

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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_monitorings`
--
ALTER TABLE `task_monitorings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `task_monitoring_form_notes`
--
ALTER TABLE `task_monitoring_form_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_monitorings`
--
ALTER TABLE `task_monitorings`
  ADD CONSTRAINT `task_monitorings_assigned_responsible_person_id_foreign` FOREIGN KEY (`assigned_responsible_person_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `task_monitorings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `task_monitorings_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `task_monitoring_form_notes`
--
ALTER TABLE `task_monitoring_form_notes`
  ADD CONSTRAINT `task_monitoring_form_notes_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_monitoring_form_notes_task_monitoring_id_foreign` FOREIGN KEY (`task_monitoring_id`) REFERENCES `task_monitorings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
