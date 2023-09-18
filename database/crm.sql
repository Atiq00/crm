-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2022 at 06:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `canned_messages`
--

CREATE TABLE `canned_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_password_resets`
--

CREATE TABLE `customer_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `assigned_user_id`, `created_at`, `updated_at`) VALUES
(1, 'General', 2, '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `code`, `title`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'customer_send_ticket_created', 'Send email to customer, when Ticket is Created!', 'Your Ticket has been received', 'Our Support Team will reply in 1-2 business working days. <br> Title : {{ticket_title}} <br> Thanks for reaching out us', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'forget_password', 'when customer/admin or any user forgets password', 'Password Reset Email', 'Click the below link to reset your account password. <a href=\"{{reset_link}}\">Reset Password</a>', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(3, 'agent_send_ticket_auto_assigned', 'When a ticket is created by customer/admin and auto assigned by system', 'New Ticket has been auto assigned to you by system', 'Ticket has been auto assigned to you by system. <br> <a href=\"{{ticket_url}}\">View Ticket</a>', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(4, 'ticket_replied_agent', 'Send an Email to Customer, when agent replies to a ticket', 'Your Ticket has been replied', '<p>Hi, Your ticket has been replied by our agent. <a href=\"{{ticket_customer_url}}\">Click Here</a> to view Ticket.</p>', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(5, 'ticket_replied_customer', 'Sends an Email to Agent, when customer replies to ticket', 'Customer reply to a Ticket', '<p>Hi, Customer has replied to a ticket. <a href=\"{{ticket_agent_url}}\">Click Here</a> to view Ticket.</p>', '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kb_categories`
--

CREATE TABLE `kb_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kb_sub_categories`
--

CREATE TABLE `kb_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_bases`
--

CREATE TABLE `knowledge_bases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `helpful_yes` int(11) NOT NULL DEFAULT 0,
  `helpful_no` int(11) NOT NULL DEFAULT 0,
  `views` bigint(20) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_04_10_122142_create_permission_tables', 1),
(4, '2020_04_10_145818_create_settings_table', 1),
(5, '2020_04_11_125840_create_faq_table', 1),
(6, '2020_04_12_075923_create_departments_table', 1),
(7, '2020_04_12_080021_create_priority_table', 1),
(8, '2020_04_12_112043_create_customers_table', 1),
(9, '2020_04_12_120000_create_tickets_table', 1),
(10, '2020_04_14_164951_knowledge_bases', 1),
(11, '2020_04_23_100000_create_password_resets_table', 1),
(12, '2020_05_03_263808_create_canned_messages', 1),
(13, '2021_06_18_174336_update_v1_1', 1),
(14, '2021_07_15_094922_create_email_templates_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'users.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(3, 'users.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(4, 'users.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(5, 'users.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(6, 'kb.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(7, 'kb.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(8, 'kb.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(9, 'kb.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(10, 'kb.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(11, 'kb_category.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(12, 'kb_category.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(13, 'kb_category.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(14, 'kb_category.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(15, 'kb_category.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(16, 'faq_category.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(17, 'faq_category.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(18, 'faq_category.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(19, 'faq_category.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(20, 'faq_category.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(21, 'faq.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(22, 'faq.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(23, 'faq.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(24, 'faq.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(25, 'faq.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(26, 'department.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(27, 'department.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(28, 'department.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(29, 'department.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(30, 'department.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(31, 'priority.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(32, 'priority.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(33, 'priority.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(34, 'priority.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(35, 'priority.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(36, 'ticket.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(37, 'ticket.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(38, 'ticket.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(39, 'ticket.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(40, 'ticket.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(41, 'ticket.reply_ticket', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(42, 'ticket_assigned_only', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(43, 'ticket.assign_user', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(44, 'ticket_canned_messages.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(45, 'ticket_canned_messages.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(46, 'ticket_canned_messages.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(47, 'ticket_canned_messages.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(48, 'ticket_canned_messages.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(49, 'customer.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(50, 'customer.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(51, 'customer.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(52, 'customer.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(53, 'customer.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(54, 'role.*', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(55, 'role.index', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(56, 'role.create', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(57, 'role.edit', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(58, 'role.delete', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `color`, `color_text`, `created_at`, `updated_at`) VALUES
(1, 'low', 'rgba(91, 92, 94, 1)', 'rgba(255, 255, 255, 1)', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'medium', 'rgba(33, 127, 243, 1)', 'rgba(255, 255, 255, 1)', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(3, 'high', 'rgba(245, 54, 92, 1)', 'rgba(255, 255, 255, 1)', '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'Agent', 'web', '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(37, 2),
(41, 2),
(42, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(10000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'date_format', 'd M, Y', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'datetime_format', 'd M, Y', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(3, 'site_title', 'CRM', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(4, 'site_description', 'Description for your portal !', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(5, 'site_logo', 'site_logo.png', '2022-09-07 05:16:42', '2022-09-07 06:42:16'),
(6, 'site_favicon', 'favicon.png', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(7, 'RECAPTCH_TYPE', NULL, '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(8, 'GOOGLE_RECAPTCHA_KEY', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(9, 'GOOGLE_RECAPTCHA_SECRET', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(10, 'USER_REOPEN_ISSUE', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(11, 'CUSTOMER_CLOSE_TICKET', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(12, 'ticket_default_assigned_user_id', '2', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(13, 'social_media_facebook', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(14, 'social_media_instagram', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(15, 'social_media_twitter', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(16, 'social_media_youtube', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(17, 'social_media_pinterest', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(18, 'social_media_envato', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(19, 'default_lang', 'en', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(20, 'theme_color', 'rgba(89, 160, 247, 1)', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(21, 'theme_color_dark', 'rgba(24, 71, 128, 1)', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(22, 'popular_categories', '[]', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(23, 'home_featured_categories', '[]', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(24, 'home_categories', '[]', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(25, 'home_max_articles', '10', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(26, 'mail_driver', 'sendmail', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(27, 'mail_host', 'smtp.mailtrap.io', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(28, 'mail_port', '2525', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(29, 'mail_from_address', 'mrasul@touchstone.com.pk', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(30, 'mail_from_name', '', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(31, 'mail_encryption', 'tls', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(32, 'MAIL_USERNAME', NULL, '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(33, 'MAIL_PASSWORD', NULL, '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(34, 'frontend_logo', 'frontend_logo.png', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(35, 'frontend_dark_logo', 'frontend_dark_logo.png', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(36, 'frontend_favicon', 'frontend_favicon.png', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(37, 'frontend_home_header', 'frontend_home_header.jpg', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(38, 'EMAIL_USER_TICKET_CREATE_CUSTOMER', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(39, 'EMAIL_USER_TICKET_CREATE_AGENT', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(40, 'EMAIL_TICKET_AGENT_REPLIED', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(41, 'EMAIL_TICKET_CUSTOMER_REPLIED', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(42, 'auto_assign_user', 'yes', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(43, 'ultimatedesk_version', '1.4', '2022-09-07 05:16:42', '2022-09-07 05:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_reply` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '2022-09-07 05:16:41', '$2y$10$B4bPMhhaKssIrbe4Y4wjW.E8CpDD4UiRPsFllpxjzYUl2b2jSk4aa', '1.jpg', 'BIfFmo84mx0h0DZPURvFX59VyIfTxS74CAxt3LzMbuB3AWYpGpgARYBtE0w1', '2022-09-07 05:16:42', '2022-09-07 05:16:42'),
(2, 'Agent', 'agent@gmail.com', '2022-09-07 05:16:42', '$2y$10$EEKxIjKozfL8jJCO2sU4eOO058bitshDBnaFYtWqagM..8PZrFfGK', '1.jpg', NULL, '2022-09-07 05:16:42', '2022-09-07 05:16:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canned_messages`
--
ALTER TABLE `canned_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `customer_password_resets`
--
ALTER TABLE `customer_password_resets`
  ADD KEY `customer_password_resets_email_index` (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_categories`
--
ALTER TABLE `kb_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kb_sub_categories`
--
ALTER TABLE `kb_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `knowledge_bases`
--
ALTER TABLE `knowledge_bases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `canned_messages`
--
ALTER TABLE `canned_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_categories`
--
ALTER TABLE `kb_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kb_sub_categories`
--
ALTER TABLE `kb_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knowledge_bases`
--
ALTER TABLE `knowledge_bases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
