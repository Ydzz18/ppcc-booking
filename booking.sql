-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 01, 2026 at 02:32 AM
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
  `actor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changed_fields` json DEFAULT NULL,
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
(21, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '12', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 07:51:55'),
(22, 6, 'Andre', 'auth.login', 'App\\Models\\User', '6', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:42:31'),
(23, 6, 'Andre', 'auth.login', 'App\\Models\\User', '6', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:51:47'),
(24, 6, 'Andre', 'updated', 'App\\Models\\User', '6', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:52:18'),
(25, 6, 'Andre', 'auth.logout', 'App\\Models\\User', '6', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:52:18'),
(26, 2, 'Mimi Jardin', 'auth.login', 'App\\Models\\User', '2', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:52:34'),
(27, 2, 'Mimi Jardin', 'auth.logout', 'App\\Models\\User', '2', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 09:59:48'),
(28, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 01:19:51'),
(29, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, 'login', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 01:19:51'),
(30, 5, 'Ydrian', 'deleted', 'App\\Models\\TaskMonitoring', '12', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 01:32:40'),
(31, 5, 'Ydrian', 'deleted', 'App\\Models\\TaskMonitoring', '11', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 01:32:44'),
(32, 5, 'Ydrian', 'deleted', 'App\\Models\\TaskMonitoring', '10', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 01:32:48'),
(33, 6, 'Andre', 'auth.login', 'App\\Models\\User', '6', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 01:34:38'),
(34, 3, 'Aires Rodriguez', 'auth.login', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:22:58'),
(35, 3, 'Aires Rodriguez', 'auth.logout', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:27:00'),
(36, 3, 'Aires Rodriguez', 'updated', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:33:56'),
(37, 3, 'Aires Rodriguez', 'auth.login', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:33:56'),
(38, 3, 'Aires Rodriguez', 'updated', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:34:42'),
(39, 3, 'Aires Rodriguez', 'auth.logout', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:34:42'),
(40, 3, 'Aires Rodriguez', 'auth.login', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 02:36:45'),
(41, 6, 'Andre', 'deleted', 'App\\Models\\TaskMonitoring', '9', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:46:35'),
(42, 6, 'Andre', 'updated', 'App\\Models\\User', '6', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:49:06'),
(43, 6, 'Andre', 'auth.logout', 'App\\Models\\User', '6', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:49:06'),
(44, 2, 'Mimi Jardin', 'auth.login', 'App\\Models\\User', '2', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:49:21'),
(45, 2, 'Mimi Jardin', 'created', 'App\\Models\\TaskMonitoring', '13', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:49:43'),
(46, 2, 'Mimi Jardin', 'auth.logout', 'App\\Models\\User', '2', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:50:11'),
(47, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:50:31'),
(48, 1, 'Admin', 'deleted', 'App\\Models\\TaskMonitoring', '13', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 02:50:40'),
(49, 5, 'Ydrian', 'created', 'App\\Models\\TaskMonitoring', '14', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 03:24:35'),
(50, 1, 'Admin', 'deleted', 'App\\Models\\TaskMonitoring', '14', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 04:00:55'),
(51, 1, 'Admin', 'created', 'App\\Models\\TaskMonitoring', '15', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 04:11:04'),
(52, 3, 'Aires Rodriguez', 'updated', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 06:00:06'),
(53, 3, 'Aires Rodriguez', 'auth.logout', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 06:00:06'),
(54, 1, 'Admin', 'created', 'App\\Models\\Task', '31', '[\"agency\", \"task_name\", \"required_forms_documents\", \"id\"]', 'tasks.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 06:03:21'),
(55, 1, 'Admin', 'created', 'App\\Models\\Task', '32', '[\"agency\", \"task_name\", \"required_forms_documents\", \"id\"]', 'tasks.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 06:06:36'),
(56, 1, 'Admin', 'created', 'App\\Models\\FormItem', '54', '[\"form_name\", \"id\"]', 'forms.store', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 06:09:08'),
(57, 1, 'Admin', 'updated', 'App\\Models\\Task', '19', '[\"required_forms_documents\"]', 'tasks.update', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 06:10:35'),
(58, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 08:10:11'),
(59, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 08:57:49'),
(60, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, 'login', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 08:57:49'),
(61, 3, 'Aires Rodriguez', 'auth.login', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 09:02:45'),
(62, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', '2026-09-29 09:06:44'),
(63, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.1 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36', '2026-09-29 09:26:21'),
(64, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 09:27:33'),
(65, 1, 'Admin', 'deleted', 'App\\Models\\TaskMonitoring', '15', '[\"id\", \"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"date_of_submission\", \"receiving_officer\", \"acknowledgement_receipt_reference_number\", \"submission_decision\", \"submission_notes\"]', 'bookings.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 09:27:50'),
(66, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:31:49'),
(67, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, 'login', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:31:50'),
(68, 5, 'Ydrian', 'updated', 'App\\Models\\User', '3', '[\"role\"]', 'users.update', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 09:32:06'),
(69, 3, 'Aires Rodriguez', 'created', 'App\\Models\\Client', '4', '[\"client_name\", \"business_name\", \"address\", \"residential_address\", \"tin\", \"tel_phone_number\", \"email_address\", \"id_presented\", \"fathers_name\", \"mothers_maiden_name\", \"date_of_birth\", \"place_of_birth\", \"civil_status\", \"religion\", \"capitalization\", \"notes\", \"id\"]', 'clients.store', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:06:37'),
(70, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoring', '16', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:08:04'),
(71, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '8', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:08:53'),
(72, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '9', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:09:27'),
(73, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '10', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:11:00'),
(74, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '11', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:11:13'),
(75, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '12', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 10:11:45'),
(76, 3, 'Aires Rodriguez', 'created', 'App\\Models\\Client', '5', '[\"client_name\", \"business_name\", \"address\", \"residential_address\", \"tin\", \"tel_phone_number\", \"email_address\", \"id_presented\", \"fathers_name\", \"mothers_maiden_name\", \"date_of_birth\", \"place_of_birth\", \"civil_status\", \"religion\", \"capitalization\", \"notes\", \"id\"]', 'clients.store', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:09:22'),
(77, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoring', '17', '[\"date_task_received\", \"client_id\", \"task_id\", \"assigned_responsible_person_id\", \"required_forms_documents\", \"submission_status\", \"id\"]', 'bookings.store', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:09:52'),
(78, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '13', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:10:27'),
(79, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '14', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:10:46'),
(80, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '15', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:11:39'),
(81, 3, 'Aires Rodriguez', 'created', 'App\\Models\\TaskMonitoringFormNote', '16', '[\"task_monitoring_id\", \"form_id\", \"notes_remarks\", \"note_date\", \"note_status\", \"id\"]', 'bookings.form-note.save', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:12:02'),
(82, 3, 'Aires Rodriguez', 'updated', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:23:58'),
(83, 3, 'Aires Rodriguez', 'auth.logout', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-29 11:23:58'),
(84, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-30 01:04:11'),
(85, 5, 'Ydrian', 'auth.login', 'App\\Models\\User', '5', NULL, 'login', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-30 01:04:11'),
(86, 1, 'Admin', 'auth.login', 'App\\Models\\User', '1', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-30 01:05:38'),
(87, 1, 'Admin', 'deleted', 'App\\Models\\Client', '1', '[\"id\", \"client_name\", \"business_name\", \"contact_person\", \"address\", \"residential_address\", \"tin\", \"tel_phone_number\", \"email_address\", \"id_presented\", \"fathers_name\", \"mothers_maiden_name\", \"date_of_birth\", \"place_of_birth\", \"civil_status\", \"religion\", \"capitalization\", \"notes\", \"business_registrations\", \"additional_requirements\"]', 'clients.destroy', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-30 02:21:49'),
(88, 3, 'Aires Rodriguez', 'auth.login', 'App\\Models\\User', '3', NULL, NULL, '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-30 03:10:03'),
(89, 5, 'Ydrian', 'updated', 'App\\Models\\User', '2', '[\"role\"]', 'users.update', '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-30 03:27:19'),
(90, 3, 'Aires Rodriguez', 'updated', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-30 09:13:11'),
(91, 3, 'Aires Rodriguez', 'auth.logout', 'App\\Models\\User', '3', NULL, 'logout', '172.18.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3.1 Safari/605.1.15', '2026-09-30 09:13:11');

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
(2, 'RODELYN DANAS', NULL, 'RODELYN DANAS', 'Narra Palawan', NULL, '123456789', '09563077596', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09 13:03:28', '2026-03-09 13:03:28'),
(3, 'Anna May T. So', NULL, 'Anna May T. So', 'Brooke\'s Point', NULL, '248-504-962', '09175226363', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-10 06:04:50', '2026-03-10 06:04:50'),
(4, 'ARB Gas Station Inc.', 'ARB Gas Station Inc.', NULL, 'Poblacion, Taytay, Palawan', 'Poblacion, Taytay, Palawan', '645-633-799-00000', '09274887674', 'arbgasstationinc@gmail.com', 'n/a', 'n/a', 'n/a', '2024-02-25', 'n/a', 'n/a', 'n/a', '1,500,000.00', NULL, NULL, NULL, '2026-09-29 10:06:37', '2026-09-29 10:06:37'),
(5, 'RLB Properties OPC', 'RLB Properties OPC', NULL, 'Poblacion, Taytay, Palawan', 'N/A', '010-898-393-00000', '0927-488-7674', 'arbgasstationinc@gmail.com', 'N/A', 'N/A', 'N/A', '2025-05-15', 'N/A', 'N/A', 'N/A', '500,000.00', NULL, NULL, NULL, '2026-09-29 11:09:21', '2026-09-29 11:09:21');

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
  `expense_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `form_name`, `expense_amount`, `created_at`, `updated_at`) VALUES
(1, 'Duly Accomplished Application Form', 0.00, '2026-03-02 19:32:23', '2026-03-02 19:32:23'),
(2, 'Certificate of Registration (BIR Form 2303)', 0.00, '2026-03-02 19:33:02', '2026-03-02 19:33:02'),
(3, 'Letter of Request', 0.00, '2026-03-02 19:33:17', '2026-03-02 19:33:17'),
(4, 'Proof of Payment', 0.00, '2026-03-02 19:33:34', '2026-03-02 19:33:34'),
(5, 'Barangay Certification', 0.00, '2026-03-09 13:04:58', '2026-09-28 05:31:14'),
(6, 'Occupancy Permit', 0.00, '2026-03-09 13:05:39', '2026-03-09 13:05:39'),
(7, 'BIR Form 1905', 0.00, '2026-09-28 02:56:40', '2026-09-28 02:56:40'),
(8, 'Lease Contract (For Renting)', 0.00, '2026-09-28 02:59:05', '2026-09-28 02:59:05'),
(9, 'SPA or SEC Cert', 0.00, '2026-09-28 02:59:40', '2026-09-28 02:59:40'),
(10, 'DTI or SEC Registration', 0.00, '2026-09-28 03:00:32', '2026-09-28 03:00:32'),
(12, 'Valid ID', 0.00, '2026-09-28 03:24:26', '2026-09-28 03:24:26'),
(13, 'Mayors Permit', 0.00, '2026-09-28 03:24:26', '2026-09-28 03:24:26'),
(14, 'Last Booklet', 0.00, '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(15, 'Latest ATP', 0.00, '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(17, 'Valid ID of Signatory', 0.00, '2026-09-28 03:25:58', '2026-09-28 03:25:58'),
(18, 'Official Email Address', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(19, 'Letter Request', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(20, 'BIR Form 2303 / COR', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(21, 'Change Address: Lease Contract or Mayors Permit', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(22, 'Original COR', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(23, 'Original Notice to Issue Receipt', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(24, 'Inventory of Unused Receipts', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(25, 'Books if Applicable', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(26, 'DTI or Mayors Closure', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(27, 'Sworn Declaration', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(28, 'TIN of EE', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(29, 'Birth Certificate for EE w/o TIN', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(30, 'Sworn Declaration Form from DTI', 0.00, '2026-09-28 03:35:24', '2026-09-28 03:35:24'),
(31, 'See List from Form', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(32, 'Application Form', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(33, 'Previous Year Business Permit', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(34, 'Previous Year Gross Receipts', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(35, 'Lease Contract or Occupancy Permit', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(36, 'Closure from Barangay', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(37, '3 Years ITR', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(38, 'SSS ER Forms', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(39, 'DTI/SEC Registration', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(40, 'Passbook or Bank Statement', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(41, 'Birth Certificate', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(42, 'Copy of Resignation Letter', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(43, 'Copy of Appointment Letter', 0.00, '2026-09-28 03:40:40', '2026-09-28 03:40:40'),
(44, 'EDD Note from OBGyne', 0.00, '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(45, 'Disbursement Voucher', 0.00, '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(46, 'PHIC ER Forms', 0.00, '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(47, 'HDMF ER Forms', 0.00, '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(48, 'HDMF EE Forms', 0.00, '2026-09-28 03:42:43', '2026-09-28 03:42:43'),
(49, 'Letter Request for Closure', 0.00, '2026-09-28 05:15:53', '2026-09-28 05:15:53'),
(50, 'SSS EE Forms', 0.00, '2026-09-28 05:34:36', '2026-09-28 05:34:36'),
(51, 'DTI', 0.00, '2026-09-28 05:41:13', '2026-09-28 05:41:13'),
(52, 'SSS Registration', 0.00, '2026-09-28 05:41:33', '2026-09-28 05:41:33'),
(53, 'PHIC EE Forms', 0.00, '2026-09-28 05:48:14', '2026-09-28 05:48:14'),
(54, 'BIR Form 1904', 0.00, '2026-09-29 06:09:08', '2026-09-29 06:09:08');

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
(19, '2026_09_28_000018_create_audit_logs_table', 4),
(20, '2026_09_29_000019_create_user_notification_views_table', 5),
(21, '2026_09_30_000020_add_expenses_to_forms_and_task_monitorings_tables', 6);

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
('qz4cNhNONs5IxAl472LlobGFFyNUNzKGkc08tNkh', 1, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzdyR1Jrcjl0Smo1WlRTUnhqZkpBM1VkUVRGbER6ZWFhSXJyWVc2UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6OTA5MC9ub3RpZmljYXRpb25zL2xpdmUiO3M6NToicm91dGUiO3M6MTg6Im5vdGlmaWNhdGlvbnMubGl2ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1790821923);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `agency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
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
(19, 'BIR', 'Enrollment of EE', '[\"28\", \"12\", \"29\", \"54\"]', '2026-09-28 05:36:50', '2026-09-29 06:10:35'),
(20, 'DTI', 'BN Registration', '[\"12\"]', '2026-09-28 05:37:36', '2026-09-28 05:37:36'),
(21, 'SSS', 'EE Maternity Notifications', '[\"44\"]', '2026-09-28 05:38:15', '2026-09-28 05:38:15'),
(22, 'DTI', 'Cancellation', '[\"30\"]', '2026-09-28 05:38:25', '2026-09-28 05:38:25'),
(23, 'SSS', 'EE Maternity Application/Disbursement', '[\"41\", \"45\"]', '2026-09-28 05:39:19', '2026-09-28 05:39:19'),
(24, 'PHIC', 'ER Registration', '[\"46\", \"13\", \"9\", \"17\", \"51\", \"52\"]', '2026-09-28 05:40:42', '2026-09-28 05:42:08'),
(26, 'PHIC', 'EE Registration', '[\"41\", \"53\"]', '2026-09-28 05:48:42', '2026-09-28 05:49:43'),
(27, 'PHIC', 'EE Update (Resignation)', '[\"53\", \"42\", \"43\"]', '2026-09-28 05:51:05', '2026-09-28 05:51:05'),
(28, 'HDMF', 'ER Registration', '[\"47\", \"51\", \"13\", \"9\", \"17\"]', '2026-09-28 05:52:07', '2026-09-28 05:52:07'),
(29, 'HDMF', 'EE Registration', '[\"48\"]', '2026-09-28 05:52:39', '2026-09-28 05:52:39'),
(30, 'HDMF', 'EE Update (Resignation)', '[\"48\"]', '2026-09-28 05:53:15', '2026-09-28 05:53:15'),
(31, 'BIR', 'ATP', '[\"14\", \"15\", \"9\", \"17\"]', '2026-09-29 06:03:21', '2026-09-29 06:03:21'),
(32, 'BIR', 'Registration', '[\"7\", \"8\", \"9\", \"10\", \"12\", \"13\"]', '2026-09-29 06:06:35', '2026-09-29 06:06:35');

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
  `expenses_breakdown` json DEFAULT NULL,
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

INSERT INTO `task_monitorings` (`id`, `date_task_received`, `client_id`, `task_id`, `assigned_responsible_person_id`, `required_forms_documents`, `expenses_breakdown`, `submission_status`, `date_of_submission`, `receiving_officer`, `acknowledgement_receipt_reference_number`, `submission_decision`, `submission_notes`, `created_at`, `updated_at`) VALUES
(16, '2026-09-29', 4, 32, 4, '[\"7\", \"10\", \"8\", \"13\", \"9\", \"12\"]', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-29 10:08:04', '2026-09-29 10:08:04'),
(17, '2026-09-29', 5, 32, 5, '[\"7\", \"10\", \"8\", \"13\", \"9\", \"12\"]', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-29 11:09:52', '2026-09-29 11:09:52');

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
(8, 16, 9, '[September 29, 2026 10:08 AM] Secretary\'s Certificate already notarized', '2026-09-29', 'completed', '2026-09-29 10:08:53', '2026-09-29 10:08:53'),
(9, 16, 10, '[September 29, 2026 10:09 AM] Please see SEC Registration on File (GDrive)', '2026-09-29', 'completed', '2026-09-29 10:09:27', '2026-09-29 10:09:27'),
(10, 16, 8, '[September 29, 2026 10:11 AM] Not Applicable', '2026-09-29', 'completed', '2026-09-29 10:11:00', '2026-09-29 10:11:00'),
(11, 16, 13, NULL, '2026-09-29', 'completed', '2026-09-29 10:11:13', '2026-09-29 10:11:13'),
(12, 16, 12, '[September 29, 2026 10:11 AM] Valid ID of corp\'s signatory', '2026-09-29', 'completed', '2026-09-29 10:11:45', '2026-09-29 10:11:45'),
(13, 17, 10, '[September 29, 2026 11:10 AM] SEC Registration on File (GDrive)', '2026-09-29', 'completed', '2026-09-29 11:10:27', '2026-09-29 11:10:27'),
(14, 17, 8, '[September 29, 2026 11:10 AM] Not Applicable', '2026-09-29', 'completed', '2026-09-29 11:10:46', '2026-09-29 11:10:46'),
(15, 17, 13, NULL, '2026-09-29', 'completed', '2026-09-29 11:11:39', '2026-09-29 11:11:39'),
(16, 17, 9, '[September 29, 2026 11:12 AM] Notarized Secretary\'s Certificate', '2026-09-29', 'completed', '2026-09-29 11:12:02', '2026-09-29 11:12:02');

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
(2, 'Mimi Jardin', 'mimi@gmail.com', NULL, '$2y$12$OzWrIHdDoHzTi29rAkcwJO0KoFs4ckFTvD0K5wrw50Y2sICYWWydy', 'admin', 'active', NULL, '2026-03-02 18:32:15', '2026-09-30 03:27:19'),
(3, 'Aires Rodriguez', 'aires@gmail.com', NULL, '$2y$12$WE005C8fHGJeu7p2UXUvd.7Rm1ulOGv8ors1ueJjSuyM2SNTQiXFa', 'admin', 'active', 'BgcNYQNkhDVwRrntbfyJGG1xW5veAkZOgLG4QKJYPJHsD3FptrQifTTXynYn', '2026-03-02 18:32:47', '2026-09-29 09:32:06'),
(4, 'Bossing Tina', 'tina@gmail.com', NULL, '$2y$12$qJYI7i7UIuNasOfudHUZl.A/dikLn4YF4hje0KRClCQLjqc.gz0DW', 'admin', 'active', NULL, '2026-03-04 20:18:33', '2026-03-04 20:18:33'),
(5, 'Ydrian', 'ydrian@gmail.com', NULL, '$2y$12$qcSp6T.s3MQubm9.8FiuV.gi57h9tu8slZr51RBbuI1cUtENNM5fq', 'admin', 'active', 'KnocGyN1hDc76eHxz4Wnvdyxfj819esPr2W58acdPtHuSjsRNDG2hh65l7zq', '2026-09-28 01:25:11', '2026-09-28 01:25:11'),
(6, 'Andre', 'andre@gmail.com', NULL, '$2y$12$cibmcjy5ph4LdR9ZXzFvI.LDz.8j00F5R.M2HT77.fZED.TAIc6O.', 'admin', 'active', 'ftNSgbZAQTUMVhay4uqWDv8txqSSSC8zEoUr2CTi7kRKJJjH3e18pkIvvsQa', '2026-09-28 01:25:52', '2026-09-28 01:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_views`
--

CREATE TABLE `user_notification_views` (
  `user_id` bigint UNSIGNED NOT NULL,
  `viewed_at` timestamp(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notification_views`
--

INSERT INTO `user_notification_views` (`user_id`, `viewed_at`, `created_at`, `updated_at`) VALUES
(1, '2026-09-30 01:40:05.000000', '2026-09-30 01:40:05', '2026-09-30 01:40:05'),
(3, '2026-09-29 11:09:57.000000', '2026-09-29 11:09:57', '2026-09-29 11:09:57'),
(5, '2026-09-30 01:05:04.000000', '2026-09-30 01:05:04', '2026-09-30 01:05:04');

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
-- Indexes for table `user_notification_views`
--
ALTER TABLE `user_notification_views`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `task_monitorings`
--
ALTER TABLE `task_monitorings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `task_monitoring_form_notes`
--
ALTER TABLE `task_monitoring_form_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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

--
-- Constraints for table `user_notification_views`
--
ALTER TABLE `user_notification_views`
  ADD CONSTRAINT `user_notification_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
