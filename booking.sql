-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Sep 28, 2026 at 08:14 AM
-- Server version: 8.0.46
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
CREATE DATABASE IF NOT EXISTS `booking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `booking`;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `actor_id` bigint UNSIGNED DEFAULT NULL,
  `actor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changed_fields` json DEFAULT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `actor_id`, `actor_name`, `event`, `subject_type`, `subject_id`, `changed_fields`, `route_name`, `ip_address`, `user_agent`, `created_at`) VALUES
(4, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', '2026-09-28 06:34:33'),
(5, 1, 'Admin', 'updated', 'App\\Models\\User', '1', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', '2026-09-28 07:14:00'),
(6, 1, 'Admin', 'auth.logout', 'App\\Models\\User', '1', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', '2026-09-28 07:14:00'),
(7, 5, 'Ydrian', 'updated', 'App\\Models\\User', '5', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:14:54'),
(8, 5, 'Ydrian', 'auth.logout', 'App\\Models\\User', '5', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:14:54'),
(9, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:14:59'),
(10, 5, 'Ydrian', 'updated', 'App\\Models\\User', '5', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:16:47'),
(11, 5, 'Ydrian', 'auth.logout', 'App\\Models\\User', '5', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:16:47'),
(12, 2, 'Mimi Jardin', 'auth.login', 'App\\Models\\User', '2', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:16:58'),
(13, 2, 'Mimi Jardin', 'auth.logout', 'App\\Models\\User', '2', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:17:54'),
(14, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:17:59'),
(15, 5, 'Ydrian', 'deleted', 'App\\Models\\Task', '1', '[\"id\", \"agency\", \"task_name\", \"required_forms_documents\"]', 'tasks.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:19:15'),
(16, 5, 'Ydrian', 'deleted', 'App\\Models\\Task', '2', '[\"id\", \"agency\", \"task_name\", \"required_forms_documents\"]', 'tasks.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:19:20'),
(17, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '9', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:20:19'),
(18, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoringFormNote', '7', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:20:52'),
(19, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '10', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:46:43'),
(20, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '11', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:47:32'),
(21, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '12', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-tina@gmail.com|172.18.0.1', 'i:2;', 1790141995),
('laravel-cache-tina@gmail.com|172.18.0.1:timer', 'i:1790141995;', 1790141995);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `residential_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_presented` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathers_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mothers_maiden_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capitalization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `business_registrations` json DEFAULT NULL,
  `additional_requirements` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `business_name`, `contact_person`, `address`, `residential_address`, `tin`, `tel_phone_number`, `email_address`, `id_presented`, `fathers_name`, `mothers_maiden_name`, `date_of_birth`, `place_of_birth`, `civil_status`, `religion`, `capitalization`, `notes`, `business_registrations`, `additional_requirements`, `created_at`, `updated_at`) VALUES
(1, 'The Bored Creations', NULL, 'Omar Rabang', '399 Rizal Avenue Puerto Princesa City', NULL, '0000000000', '09359141800', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 19:14:47', '2026-03-02 19:14:47'),
(2, 'RODELYN DANAS', NULL, 'RODELYN DANAS', 'Narra Palawan', NULL, '123456789', '09563077596', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 13:03:28', '2026-03-09 13:03:28'),
(3, 'Anna May T. So', NULL, 'Anna May T. So', 'Brooke\'s Point', NULL, '248-504-962', '09175226363', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 06:04:50', '2026-03-10 06:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `form_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `form_name`, `created_at`, `updated_at`) VALUES
(1, 'Duly Accomplished Application Form', '2026-03-02 19:32:23', '2026-03-02 19:32:23'),
(2, 'Certificate of Registration (BIR Form 2303)', '2026-03-02 19:33:02', '2026-03-02 19:33:02'),
(3, 'Letter of Request', '2026-03-02 19:33:17', '2026-03-02 19:33:17'),
(4, 'Proof of Payment', '2026-03-02 19:33:34', '2026-03-02 19:33:34'),
(5, 'Barangay Certification', '2026-03-09 13:04:58', '2026-09-28 05:31:14'),
(6, 'Occupancy Permit', '2026-03-09 13:05:39', '2026-03-09 13:05:39'),
(7, 'BIR Form 1905', '2026-09-28 02:56:40', '2026-09-28 02:56:40'),
(8, 'Lease Contract (For Renting)', '2026-09-28 02:59:05', '2026-09-28 02:59:05'),
(9, 'SPA or SEC Cert', '2026-09-28 02:59:40', '2026-09-28 02:59:40'),
(10, 'DTI or SEC Registration', '2026-09-28 03:00:32', '2026-09-28 03:00:32'),
(12, 'Valid ID', '2026-09-28 03:24:26', '2026-09-28 03:24:26'),
(13, 'Mayors Permit', '2026-09-28 03:24:26', '2026-09-28 03:24:26'),
(14, 'Last Booklet', '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(15, 'Latest ATP', '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(17, 'Valid ID of Signatory', '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(18, 'Official Email Address', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(19, 'Letter Request', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(20, 'BIR Form 2303 / COR', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(21, 'Change Address: Lease Contract or Mayors Permit', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(22, 'Original COR', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(23, 'Original Notice to Issue Receipt', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(24, 'Inventory of Unused Receipts', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(25, 'Books if Applicable', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(26, 'DTI or Mayors Closure', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(27, 'Sworn Declaration', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(28, 'TIN of EE', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(29, 'Birth Certificate for EE w/o TIN', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(30, 'Sworn Declaration Form from DTI', '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(31, 'See List from Form', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(32, 'Application Form', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(33, 'Previous Year Business Permit', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(34, 'Previous Year Gross Receipts', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(35, 'Lease Contract or Occupancy Permit', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(36, 'Closure from Barangay', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(37, '3 Years ITR', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(38, 'SSS ER Forms', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(39, 'DTI/SEC Registration', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(40, 'Passbook or Bank Statement', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(41, 'Birth Certificate', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(42, 'Copy of Resignation Letter', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(43, 'Copy of Appointment Letter', '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(44, 'EDD Note from OBGyne', '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(45, 'Disbursement Voucher', '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(46, 'PHIC ER Forms', '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(47, 'HDMF ER Forms', '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(48, 'HDMF EE Forms', '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(49, 'Letter Request for Closure', '2026-09-28 05:15:53', '2026-09-28 05:15:53'),
(50, 'SSS EE Forms', '2026-09-28 05:34:36', '2026-09-28 05:34:36'),
(51, 'DTI', '2026-09-28 05:41:13', '2026-09-28 05:41:13'),
(52, 'SSS Registration', '2026-09-28 05:41:33', '2026-09-28 05:41:33'),
(53, 'PHIC EE Forms', '2026-09-28 05:48:14', '2026-09-28 05:48:14');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_02_000003_add_role_to_users_table', 1),
(5, '2026_03_02_000004_add_status_to_users_table', 1),
(6, '2026_03_02_000005_create_clients_table', 1),
(7, '2026_03_02_000006_create_tasks_table', 1),
(8, '2026_03_02_000007_create_forms_table', 1),
(9, '2026_03_02_000008_create_task_monitorings_table', 1),
(10, '2026_03_02_000009_create_task_monitoring_form_notes_table', 1),
(11, '2026_03_02_000010_add_note_status_to_task_monitoring_form_notes_table', 1),
(12, '2026_03_02_000011_add_contact_person_to_clients_table', 1),
(13, '2026_03_02_000012_change_assigned_responsible_person_fk_to_clients_in_task_monitorings_table', 1),
(14, '2026_03_02_000013_add_submission_status_to_task_monitorings_table', 1),
(15, '2026_03_05_000014_add_submission_fields_to_task_monitorings_table', 1),
(16, '2026_03_05_000015_add_submission_decision_and_notes_to_task_monitorings_table', 1),
(17, '2026_09_24_000016_add_client_information_fields_to_clients_table', 2),
(18, '2026_09_24_000017_add_client_requirements_to_clients_table', 3),
(19, '2026_09_28_000018_create_audit_logs_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2N0a9Ly6e4wdcqI0aPPSAdMGzbW2WvGpQCIbEvtG', 1, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFVJMFNkb2w1eUdDTGx5aU9nMnRpRlFhZ2lUZ05hcUk2T0o2OWY5diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zZXR0aW5ncz90YWI9dXNlcnMiO3M6NToicm91dGUiO3M6MTQ6InNldHRpbmdzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1773959307),
('4C8wpaeKe3usvO7yyYh0pxILbhWgnxpUZJjjzdZN', NULL, '172.18.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEdWa1J6dXJtYWhjTEk5OFJQaXo5YVlOSk9WMm1udTZFa0M5VEhJTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790216760),
('4vLNrMKiVAv2EL32d0Dr9OJf7JEJQUP3JknbXP5T', NULL, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmNReFU1OGNYaFRQYWpWdVF1NFA0Y1FyRXNJVVZUUVc0dDhWcXEzUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773069938),
('5GehHlMeECK12Pqvi5YNNaWEVvaYK1n6e7f5KLCJ', NULL, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDJJaXBnd2lDdEcwU1JMeHowZ0I1a3pCVEtIZGYzUEhoM3MxbzczMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773122901),
('fSi3S9lBDvDo9ooPt5yD63nc7LxdWbQhPV49DPrO', 2, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibm1YeW1xVmprQkRyd0ZzT1M0bDNqTnE2a3hEeFFhRGs3RGhHY09raiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9ib29raW5ncz90YWI9bW9uaXRvcmluZyI7czo1OiJyb3V0ZSI7czoxNDoiYm9va2luZ3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1790216656),
('gDy8Oe19Y83FkSRQ2S3AmBSwjw9V6UYTBA9klMAn', 2, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWhRSG8ySEc3aG1iRkZ4c0xlUjZoUHJuR3M3Znk2RTE1bDdkcjhRSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2Jvb2tpbmdzLzQvZWRpdD9zaG93X3N1Ym1pc3Npb25fZm9ybT0xIjtzOjU6InJvdXRlIjtzOjEzOiJib29raW5ncy5lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1773132736),
('gN2P55p27n59KSDh1aZjlVwUjBuKlF9J5EgXlllP', NULL, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFFMYzg1WmFIcWdVcGUxVGlPRmdOMGI1bDJ5Y3l5N25UZUg1TDFLUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1773144863),
('irwmhJjXpGDvPQcb42wGZftsPK8Afr3fRoCJO2ux', NULL, '172.18.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWE8yTVZPWXl2SEpGekZxa21qMlg0RlJlN0VGQ3ZpejEwUGhDVW11cCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790216737),
('mlhKG9TvasLL4XEQmp3gWkqm8PTVOCEckBAaG95I', NULL, '172.21.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN0Z6cUFxU0lMdjlpYkZJckJZWm9mYThFazdNRWdoNm1BOEZoc2pIayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo3MToiaHR0cDovL2FycC50aGVib3JlZGNyZWF0aW9ucy5jb20vYm9va2luZ3MvNC9lZGl0P3Nob3dfc3VibWlzc2lvbl9mb3JtPTEiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozODoiaHR0cDovL2FycC50aGVib3JlZGNyZWF0aW9ucy5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1773141363),
('pcuctz0cZHV4AyA2xmwLjOorxEoSUU2k2IkPFMXP', NULL, '172.21.0.1', 'Mozilla/5.0 (iPad; CPU OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 [FBAN/FBIOS;FBAV/549.1.0.40.107;FBBV/886965988;FBDV/iPad15,7;FBMD/iPad;FBSN/iPadOS;FBSV/26.2;FBSS/2;FBCR/;FBID/tablet;FBLC/en_US;FBOP/80]', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkt5YnlzdVVXWUtvSkVaWDlLZHp1M1dud0NnUFdINVI3UXdvNnd3aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hcnAudGhlYm9yZWRjcmVhdGlvbnMuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1773062779),
('shITu0Wl57aj9P2wFHD6KdtH8s9mIgQbCs5pY7EC', 1, '172.21.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3RRTDJWWjJYSm1QV1ZtZ1ZiRmRyaEhmQ2NwcnVKQlZVYTdhS3RjMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ib29raW5ncyI7czo1OiJyb3V0ZSI7czoxNDoiYm9va2luZ3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773945395),
('skdsNKDUI5buu5XygCjd8ka2mb2cA3kCbK6NUEJa', 1, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVQ2RWR3T3hLTWNYS3NPUlFuVjR3WmJkdmhmM3pZVU1OZUVaUDBjViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9zZXR0aW5ncyI7czo1OiJyb3V0ZSI7czoxNDoic2V0dGluZ3MuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1790151685),
('TlyX3kjA4ltXmvkzm5UHH9ZrHBDEq6WToQJnTfZ9', NULL, '172.18.0.1', 'curl/8.21.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEhSUUNZS1BxdUNTbWozdERFZ0w2bkt0c0g5MkphRGR6VE9vZnJkNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790216745);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `task_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_forms_documents` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `agency`, `task_name`, `required_forms_documents`, `created_at`, `updated_at`) VALUES
(3, 'SSS', 'Social Security System', '[\"6\", \"5\", \"4\"]', '2026-03-10 06:06:10', '2026-09-28 02:46:53'),
(4, 'BIR', 'Books thru Orus', '[\"7\", \"9\", \"17\"]', '2026-09-28 05:03:07', '2026-09-28 05:03:07'),
(5, 'DTI', 'Accreditation', '[\"31\"]', '2026-09-28 05:13:24', '2026-09-28 05:13:24'),
(6, 'BPLO', 'Closure', '[\"49\", \"36\", \"37\", \"9\", \"17\"]', '2026-09-28 05:16:08', '2026-09-28 05:17:25'),
(7, 'BPLO', 'BP Renewal (Fire, Sanitary, Water Test)', '[\"32\", \"9\", \"17\", \"33\", \"34\", \"35\"]', '2026-09-28 05:18:32', '2026-09-28 05:18:32'),
(8, 'BPLO', 'Update of Info', '[\"5\"]', '2026-09-28 05:19:28', '2026-09-28 05:19:28'),
(9, 'BIR', 'Orus Enrollment', '[\"7\", \"9\", \"17\", \"18\"]', '2026-09-28 05:20:02', '2026-09-28 05:20:02'),
(10, 'BIR', 'eFPS Enrollment', '[\"19\", \"20\", \"17\", \"18\", \"9\"]', '2026-09-28 05:31:20', '2026-09-28 05:31:20'),
(11, 'BIR', 'Update of Information', '[\"21\", \"7\", \"9\", \"17\"]', '2026-09-28 05:32:22', '2026-09-28 05:32:22'),
(12, 'SSS', 'ER Registration', '[\"38\", \"39\", \"13\", \"9\", \"17\"]', '2026-09-28 05:32:42', '2026-09-28 05:32:42'),
(13, 'SSS', 'Enrollment of Account No.', '[\"40\"]', '2026-09-28 05:33:28', '2026-09-28 05:33:28'),
(14, 'BIR', 'Closure', '[\"7\", \"9\", \"17\", \"22\", \"23\", \"24\", \"25\", \"26\"]', '2026-09-28 05:33:29', '2026-09-28 05:33:29'),
(15, 'BIR', 'Tax Clearance', '[\"27\", \"9\", \"17\"]', '2026-09-28 05:34:33', '2026-09-28 05:34:33'),
(16, 'SSS', 'EE Registration', '[\"50\", \"41\"]', '2026-09-28 05:34:55', '2026-09-28 05:37:13'),
(17, 'BIR', 'Non-Vat or Vat Application', '[\"27\", \"9\", \"17\", \"22\", \"24\", \"19\"]', '2026-09-28 05:35:44', '2026-09-28 05:35:44'),
(18, 'SSS', 'EE Update', '[\"50\", \"41\", \"42\", \"43\"]', '2026-09-28 05:36:47', '2026-09-28 05:36:47'),
(19, 'BIR', 'Enrollment of EE', '[\"7\", \"28\", \"12\", \"29\"]', '2026-09-28 05:36:50', '2026-09-28 05:36:50'),
(20, 'DTI', 'BN Registration', '[\"12\"]', '2026-09-28 05:37:36', '2026-09-28 05:37:36'),
(21, 'SSS', 'EE Maternity Notifications', '[\"44\"]', '2026-09-28 05:38:15', '2026-09-28 05:38:15'),
(22, 'DTI', 'Cancellation', '[\"30\"]', '2026-09-28 05:38:25', '2026-09-28 05:38:25'),
(23, 'SSS', 'EE Maternity Application/Disbursement', '[\"41\", \"45\"]', '2026-09-28 05:39:19', '2026-09-28 05:39:19'),
(24, 'PHIC', 'ER Registration', '[\"46\", \"13\", \"9\", \"17\", \"51\", \"52\"]', '2026-09-28 05:40:42', '2026-09-28 05:42:08'),
(26, 'PHIC', 'EE Registration', '[\"41\", \"53\"]', '2026-09-28 05:48:42', '2026-09-28 05:49:43'),
(27, 'PHIC', 'EE Update (Resignation)', '[\"53\", \"42\", \"43\"]', '2026-09-28 05:51:05', '2026-09-28 05:51:05'),
(28, 'HDMF', 'ER Registration', '[\"47\", \"51\", \"13\", \"9\", \"17\"]', '2026-09-28 05:52:07', '2026-09-28 05:52:07'),
(29, 'HDMF', 'EE Registration', '[\"48\"]', '2026-09-28 05:52:39', '2026-09-28 05:52:39'),
(30, 'HDMF', 'EE Update (Resignation)', '[\"48\"]', '2026-09-28 05:53:15', '2026-09-28 05:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `task_monitorings`
--

CREATE TABLE `task_monitorings` (
  `id` bigint UNSIGNED NOT NULL,
  `date_task_received` date NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `assigned_responsible_person_id` bigint UNSIGNED NOT NULL,
  `required_forms_documents` json DEFAULT NULL,
  `submission_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `date_of_submission` date DEFAULT NULL,
  `receiving_officer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acknowledgement_receipt_reference_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_decision` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_monitorings`
--

INSERT INTO `task_monitorings` (`id`, `date_task_received`, `client_id`, `task_id`, `assigned_responsible_person_id`, `required_forms_documents`, `submission_status`, `date_of_submission`, `receiving_officer`, `acknowledgement_receipt_reference_number`, `submission_decision`, `submission_notes`, `created_at`, `updated_at`) VALUES
(9, '2026-09-28', 3, 4, 3, '[\"7\", \"9\", \"17\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-28 07:20:19', '2026-09-28 07:20:19'),
(10, '2026-09-28', 3, 20, 3, '[\"12\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-28 07:46:43', '2026-09-28 07:46:43'),
(11, '2026-09-26', 1, 4, 1, '[\"7\", \"9\", \"17\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-28 07:47:32', '2026-09-28 07:47:32'),
(12, '2026-09-29', 2, 29, 2, '[\"48\"]', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-28 07:51:55', '2026-09-28 07:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `task_monitoring_form_notes`
--

CREATE TABLE `task_monitoring_form_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `task_monitoring_id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED NOT NULL,
  `notes_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `note_date` date DEFAULT NULL,
  `note_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_monitoring_form_notes`
--

INSERT INTO `task_monitoring_form_notes` (`id`, `task_monitoring_id`, `form_id`, `notes_remarks`, `note_date`, `note_status`, `created_at`, `updated_at`) VALUES
(7, 9, 7, NULL, '2026-09-28', 'completed', '2026-09-28 07:20:52', '2026-09-28 07:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requester',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$MsBeiq1zzjLJ2JWyNycvOuee8OwbGknJqZXKMBTtCf8NRtyisDEnO', 'admin', 'active', 'lDOhDQpTLkzx5klzp7CaG2euUtkdTrAarnFu4uigcbWsTmiDqzdb2crPQRAb', '2026-09-23 05:41:52', '2026-09-25 14:41:42'),
(2, 'Mimi Jardin', 'mimi@gmail.com', NULL, '$2y$12$OzWrIHdDoHzTi29rAkcwJO0KoFs4ckFTvD0K5wrw50Y2sICYWWydy', 'requester', 'active', NULL, '2026-03-02 18:32:15', '2026-03-04 20:25:14'),
(3, 'Aires Rodriguez', 'aires@gmail.com', NULL, '$2y$12$WE005C8fHGJeu7p2UXUvd.7Rm1ulOGv8ors1ueJjSuyM2SNTQiXFa', 'approver', 'active', NULL, '2026-03-02 18:32:47', '2026-09-28 01:42:29'),
(4, 'Bossing Tina', 'tina@gmail.com', NULL, '$2y$12$qJYI7i7UIuNasOfudHUZl.A/dikLn4YF4hje0KRClCQLjqc.gz0DW', 'admin', 'active', NULL, '2026-03-04 20:18:33', '2026-03-04 20:18:33'),
(5, 'Ydrian', 'ydrian@gmail.com', NULL, '$2y$12$qcSp6T.s3MQubm9.8FiuV.gi57h9tu8slZr51RBbuI1cUtENNM5fq', 'admin', 'active', 'KnocGyN1hDc76eHxz4Wnvdyxfj819esPr2W58acdPtHuSjsRNDG2hh65l7zq', '2026-09-28 01:25:11', '2026-09-28 01:25:11'),
(6, 'Andre', 'andre@gmail.com', NULL, '$2y$12$cibmcjy5ph4LdR9ZXzFvI.LDz.8j00F5R.M2HT77.fZED.TAIc6O.', 'admin', 'active', 'yixcDJe26yGW8S0S2GG4LRrXhTTNK0rPrDBYUNYToSEYxdEBuOuDvaux2TdV', '2026-09-28 01:25:52', '2026-09-28 01:25:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_actor_id_created_at_index` (`actor_id`,`created_at`),
  ADD KEY `audit_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  ADD KEY `audit_logs_event_created_at_index` (`event`,`created_at`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forms_form_name_unique` (`form_name`);

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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `task_monitorings`
--
ALTER TABLE `task_monitorings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `task_monitoring_form_notes`
--
ALTER TABLE `task_monitoring_form_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
