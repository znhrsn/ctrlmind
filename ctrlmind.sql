-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 16, 2025 at 01:49 PM
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
-- Database: `ctrlmind`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:10:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.40.2\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.8\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:5:\"0.3.8\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^2.3\";s:10:\"\0*\0package\";E:36:\"Laravel\\Roster\\Enums\\Packages:BREEZE\";s:14:\"\0*\0packageName\";s:14:\"laravel/breeze\";s:10:\"\0*\0version\";s:5:\"2.3.8\";s:6:\"\0*\0dev\";b:1;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.4\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.3.4\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.26.0\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.48.1\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^3.8\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PEST\";s:14:\"\0*\0packageName\";s:12:\"pestphp/pest\";s:10:\"\0*\0version\";s:5:\"3.8.4\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"11.5.33\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.33\";s:6:\"\0*\0dev\";b:1;}i:8;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:38:\"Laravel\\Roster\\Enums\\Packages:ALPINEJS\";s:14:\"\0*\0packageName\";s:8:\"alpinejs\";s:10:\"\0*\0version\";s:6:\"3.15.2\";s:6:\"\0*\0dev\";b:1;}i:9;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"3.4.18\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1765361756;}', 1765448156),
('laravel-cache-mia@li.mail.com|127.0.0.1', 'i:2;', 1765873114),
('laravel-cache-mia@li.mail.com|127.0.0.1:timer', 'i:1765873114;', 1765873114),
('laravel-cache-quote_of_the_day_2025-12-08', 'O:16:\"App\\Models\\Quote\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"quotes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:27;s:4:\"text\";s:50:\"The mind is everything. What you think you become.\";s:6:\"author\";s:6:\"Buddha\";s:10:\"created_at\";s:19:\"2025-12-08 17:52:33\";s:10:\"updated_at\";s:19:\"2025-12-08 17:52:33\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:27;s:4:\"text\";s:50:\"The mind is everything. What you think you become.\";s:6:\"author\";s:6:\"Buddha\";s:10:\"created_at\";s:19:\"2025-12-08 17:52:33\";s:10:\"updated_at\";s:19:\"2025-12-08 17:52:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"text\";i:1;s:6:\"author\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1765306031),
('laravel-cache-quote_of_the_day_2025-12-09', 'O:16:\"App\\Models\\Quote\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"quotes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:29;s:4:\"text\";s:32:\"Hapiness depends upon ourselves.\";s:6:\"author\";s:9:\"Aristotle\";s:10:\"created_at\";s:19:\"2025-12-08 17:56:42\";s:10:\"updated_at\";s:19:\"2025-12-08 17:56:42\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:29;s:4:\"text\";s:32:\"Hapiness depends upon ourselves.\";s:6:\"author\";s:9:\"Aristotle\";s:10:\"created_at\";s:19:\"2025-12-08 17:56:42\";s:10:\"updated_at\";s:19:\"2025-12-08 17:56:42\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"text\";i:1;s:6:\"author\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1765376142),
('laravel-cache-quote_of_the_day_2025-12-10', 'O:16:\"App\\Models\\Quote\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"quotes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:29;s:4:\"text\";s:32:\"Hapiness depends upon ourselves.\";s:6:\"author\";s:9:\"Aristotle\";s:10:\"created_at\";s:19:\"2025-12-08 17:56:42\";s:10:\"updated_at\";s:19:\"2025-12-08 17:56:42\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:29;s:4:\"text\";s:32:\"Hapiness depends upon ourselves.\";s:6:\"author\";s:9:\"Aristotle\";s:10:\"created_at\";s:19:\"2025-12-08 17:56:42\";s:10:\"updated_at\";s:19:\"2025-12-08 17:56:42\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"text\";i:1;s:6:\"author\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1765446604),
('laravel-cache-quote_of_the_day_2025-12-11', 'O:16:\"App\\Models\\Quote\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"quotes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:27;s:4:\"text\";s:50:\"The mind is everything. What you think you become.\";s:6:\"author\";s:6:\"Buddha\";s:10:\"created_at\";s:19:\"2025-12-08 17:52:33\";s:10:\"updated_at\";s:19:\"2025-12-08 17:52:33\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:27;s:4:\"text\";s:50:\"The mind is everything. What you think you become.\";s:6:\"author\";s:6:\"Buddha\";s:10:\"created_at\";s:19:\"2025-12-08 17:52:33\";s:10:\"updated_at\";s:19:\"2025-12-08 17:52:33\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"text\";i:1;s:6:\"author\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1765503322),
('laravel-cache-quote_of_the_day_2025-12-16', 'O:16:\"App\\Models\\Quote\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"quotes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:5:{s:2:\"id\";i:26;s:4:\"text\";s:58:\"Life is what happends when you\'re busy making other plans.\";s:6:\"author\";s:11:\"John Lennon\";s:10:\"created_at\";s:19:\"2025-12-08 17:49:45\";s:10:\"updated_at\";s:19:\"2025-12-08 17:49:45\";}s:11:\"\0*\0original\";a:5:{s:2:\"id\";i:26;s:4:\"text\";s:58:\"Life is what happends when you\'re busy making other plans.\";s:6:\"author\";s:11:\"John Lennon\";s:10:\"created_at\";s:19:\"2025-12-08 17:49:45\";s:10:\"updated_at\";s:19:\"2025-12-08 17:49:45\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"text\";i:1;s:6:\"author\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1765959325);

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"2002f84f-64a9-4f22-a3db-117a146283ff\",\"displayName\":\"App\\\\Notifications\\\\NewClientAssigned\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:8;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:35:\\\"App\\\\Notifications\\\\NewClientAssigned\\\":2:{s:6:\\\"client\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c8f099e0-6aea-4faf-95c0-a5fd23d72eb2\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"},\"createdAt\":1765889088,\"delay\":null}', 0, NULL, 1765889088, 1765889088);

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
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reflection` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `shared_with_consultant` tinyint(1) NOT NULL DEFAULT 0,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `archived_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `user_id`, `quote_id`, `reflection`, `created_at`, `updated_at`, `deleted_at`, `shared_with_consultant`, `archived`, `archived_at`) VALUES
(13, 1, NULL, 'Today felt pretty balanced. I woke up later than usual but still managed to get through my tasks. I spent most of the morning working on my project, and even though I hit a few snags, I figured out some fixes that made me feel productive. In the afternoon, I took a break and went outside for a short walk—it cleared my head and gave me some energy. By evening, I felt tired but satisfied, like I had done enough for the day. Overall, it wasn’t perfect, but it was a good mix of work and rest.', '2025-12-08 05:34:36', '2025-12-08 08:29:00', NULL, 1, 0, NULL),
(15, 1, 30, 'This quote reminds me that even small things I do matter. Sometimes I feel like my actions don’t change much, but they actually do—whether it’s helping someone, finishing a task, or just showing kindness. Acting like what I do makes a difference pushes me to give more effort, because in the end, it really does shape things around me.', '2025-12-08 11:17:06', '2025-12-08 11:34:50', NULL, 1, 0, NULL),
(16, 1, NULL, 'Today felt like a tug-of-war between persistence and fatigue. I spent hours debugging my Laravel chat schema, and while the errors were frustrating, I noticed how much calmer I’ve become about tackling them. Instead of spiraling, I broke the problem down step by step, and that made the process feel manageable.\r\n\r\nOutside of coding, I caught myself thinking about words again—how “impressed” feels different from “shocked,” and how choosing the right one changes the tone of a story. It reminded me why I love journaling: it’s a space to test language until it feels true.\r\n\r\nI’m proud that I pushed through today, even if the progress was small. Sometimes the act of showing up—whether in code or in writing—is the real win.', '2025-12-10 06:57:43', '2025-12-10 06:57:43', NULL, 0, 0, NULL),
(20, 21, NULL, 'Today I slowed down and noticed the small details around me. The sound of rain outside felt steady, almost like background music while I worked. I did not finish everything I planned, but I realized that progress is not always about speed. Sometimes it is about noticing where you are and appreciating it.', '2025-12-16 04:45:52', '2025-12-16 04:46:13', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_user`
--

CREATE TABLE `journal_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `consultant_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `content`, `created_at`, `updated_at`, `sender_id`, `receiver_id`) VALUES
(3, 'Hi! I’m here if you need anything. How can I help today?', '2025-12-10 02:56:39', '2025-12-10 02:56:39', 0, 0),
(4, 'Hi! I’m here if you need anything. How can I help today?', '2025-12-10 09:15:41', '2025-12-10 09:15:41', 3, 1),
(5, 'I am good.', '2025-12-10 09:15:51', '2025-12-10 09:15:51', 1, 3),
(6, 'sda', '2025-12-10 09:18:38', '2025-12-10 09:18:38', 1, 3),
(7, 'typing', '2025-12-10 09:38:10', '2025-12-10 09:38:10', 1, 3),
(8, 'dsjabd', '2025-12-10 09:38:12', '2025-12-10 09:38:12', 1, 3),
(9, 'hello doc', '2025-12-10 09:38:14', '2025-12-10 09:38:14', 1, 3),
(10, 'goodnight', '2025-12-10 09:38:17', '2025-12-10 09:38:17', 1, 3),
(11, 'I am about to go to bed', '2025-12-10 09:38:23', '2025-12-10 09:38:23', 1, 3),
(12, 'alright. goodnight, mia. have a good rest.', '2025-12-10 09:48:59', '2025-12-10 09:48:59', 3, 1),
(13, 'hello, doc. good morning!', '2025-12-10 17:35:54', '2025-12-10 17:35:54', 1, 3),
(14, 'hi, good morning', '2025-12-10 17:36:35', '2025-12-10 17:36:35', 3, 1),
(15, 'Hi! I’m here if you need anything. How can I help today?', '2025-12-11 06:27:54', '2025-12-11 06:27:54', 3, 17),
(16, 'Hi! I’m here if you need anything. How can I help today?', '2025-12-11 06:28:42', '2025-12-11 06:28:42', 9, 16),
(17, 'Hi! I’m here if you need anything. How can I help today?', '2025-12-16 00:16:33', '2025-12-16 00:16:33', 8, 19);

-- --------------------------------------------------------

--
-- Table structure for table `mh_questions`
--

CREATE TABLE `mh_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prompt` varchar(300) NOT NULL,
  `type` enum('scale','single','multi','text') NOT NULL DEFAULT 'text',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mh_responses`
--

CREATE TABLE `mh_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `response_text` text DEFAULT NULL,
  `response_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2025_11_29_175001_create_m_h_questions_table', 1),
(5, '2025_11_29_175015_create_m_h_responses_table', 1),
(6, '2025_12_05_151731_create_quotes_table', 1),
(7, '2025_12_05_184158_drop_user_id_from_quotes_table', 2),
(8, '2025_12_05_184826_create_user_quotes_table', 3),
(9, '2025_12_05_184912_create_journal_entries_table', 3),
(10, '2025_12_06_044538_alter_journal_entries_make_quote_id_nullable', 4),
(11, '2025_12_06_045952_alter_journal_entries_table', 5),
(28, '2025_12_06_103120_create_mood_logs_table', 6),
(29, '2025_12_06_114014_create_quote_user_saves_table', 6),
(30, '2025_12_06_123515_add_archived_columns_to_journal_entries_table', 6),
(31, '2025_12_08_064342_create_messages_table', 6),
(32, '2025_12_08_110949_add_sender_receiver_to_messages_table', 6),
(49, '2025_12_08_130050_create_resources_table', 7),
(50, '2025_12_08_192113_remove_sender_id_from_messages', 7),
(51, '2025_12_10_101046_refactor_messages_table_to_sender_receiver', 7),
(52, '2025_12_10_111719_create_journal_user_table', 8),
(53, '2025_12_10_164316_add_is_pinned_to_user_quotes_table', 9),
(54, '2025_12_10_100118_make_receiver_id_nullable_in_messages', 10),
(55, '2025_12_16_082208_create_notifications_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mood_logs`
--

CREATE TABLE `mood_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mood` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `text`, `author`, `created_at`, `updated_at`) VALUES
(26, 'Life is what happends when you\'re busy making other plans.', 'John Lennon', '2025-12-08 09:49:45', '2025-12-08 09:49:45'),
(27, 'The mind is everything. What you think you become.', 'Buddha', '2025-12-08 09:52:33', '2025-12-08 09:52:33'),
(28, 'It always seems impossible until it\'s done.', 'Nelson Mandela', '2025-12-08 09:55:46', '2025-12-08 09:55:46'),
(29, 'Hapiness depends upon ourselves.', 'Aristotle', '2025-12-08 09:56:42', '2025-12-08 09:56:42'),
(30, 'Act as if what you do makes a difference. It does.', 'William James', '2025-12-08 09:57:40', '2025-12-08 09:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `title`, `description`, `url`, `is_featured`, `created_at`, `updated_at`, `section`) VALUES
(45, 'Understanding Stress vs Anxiety', 'A simple explanation of how stress differs from anxiety and how they affect the mind.', 'https://www.sagemed.co/blog/stress-anxiety-symptoms-causes-relief', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Educational Corner'),
(46, 'What is Burnout?', 'Signs, causes, and recovery strategies for burnout.', 'https://www.webmd.com/mental-health/burnout-symptoms-signs', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Educational Corner'),
(47, 'How Sleep Affects Mental Health', 'Learn how sleep impacts mood, focus, and emotional balance.', 'https://www.columbiapsychiatry.org/news/how-sleep-deprivation-affects-your-mental-health', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Educational Corner'),
(48, '5-Minute Breathing Exercise', 'Guided box breathing to reduce stress and calm the mind.', 'https://www.youtube.com/watch?v=enJyOTvEn4M', 1, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Coping & Self-Care Strategies'),
(49, '10-Minute Mindfulness Meditation', 'A guided meditation to help you stay grounded and present.', 'https://www.youtube.com/watch?v=ENYYb5vIMkU', 1, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Coping & Self-Care Strategies'),
(50, 'Healthy Sleep Habits', 'Practical tips to improve your sleep routine and reduce stress.', 'https://sleepeducation.org/healthy-sleep/healthy-sleep-habits/', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Coping & Self-Care Strategies'),
(51, 'When to Seek Professional Help', 'A guide to recognizing when it’s time to reach out for support.', 'https://www.unicef.org/northmacedonia/stories/mental-health-when-seek-professional-support', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Getting Help'),
(52, 'How to Talk to a Counselor', 'Tips for preparing for your first counseling session.', 'https://mindyourmind.ca/getting-help/talk-counsellor/', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Getting Help'),
(53, 'Support Hotlines & Emergency Contacts', 'A list of important mental health hotlines and crisis support numbers.', 'https://bettergov.ph/philippines/hotlines', 0, '2025-12-14 02:41:51', '2025-12-14 02:41:51', 'Getting Help');

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
('wg5TIPcht5i2ynismYuBLGGdYW0lTjbd9YKq8ZEj', 21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicUV4VXZhWjJKN3FYdjdlaDBibnlPOTdRZVJaZG1hOUhSanZvNEd4eiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9qb3VybmFsIjtzOjU6InJvdXRlIjtzOjEzOiJqb3VybmFsLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjE7fQ==', 1765889173);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `consultant_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `consultant_id`) VALUES
(1, 'Mia Li', 'mia.li@mail.com', NULL, '$2y$12$q/Vx7qywTlASFLFeKuPTyO5AQVf0oq9daaiiSepCkizqs8Oev1juW', 'jJYfdFtsc6bqU0z3uU21Vo77SIhhhSv0MklwPKdBB94glbhwu9QQ2P50wT7g', '2025-12-05 07:26:17', '2025-12-08 00:04:32', 'user', 3),
(3, 'Daniel Smith', 'daniel@example.com', NULL, '$2y$12$RtWDur5GzbkC5IT968WMKuf8RxfbMVQW5NLUOM7ABjLwMmsU7dDbC', 'gjNFmIJEMZdVqaCx7fMsx7qfIxdru5eZppvxDEpl9CZTUVxnJ5B2FUacBmj8', '2025-12-08 00:02:05', '2025-12-08 04:19:11', 'consultant', NULL),
(8, 'Maria Cruz', 'maria@example.com', NULL, '$2y$12$y0fDyavkfMhLaznTSbFi5ObaIm/QJuSPi28Uyei3aCYOsDQrTHr36', NULL, '2025-12-11 05:43:00', '2025-12-11 05:43:00', 'consultant', NULL),
(9, 'Jose Lee', 'jose@example.com', NULL, '$2y$12$tY/mC0NbUqZpiP1D3y04yu1IdLh/03xrYxPJiEEcBTfqzaVqdRDkO', NULL, '2025-12-11 05:43:00', '2025-12-11 05:43:00', 'consultant', NULL),
(18, 'sam', 'sam@example.com', NULL, '$2y$12$YDL8ZedUiFmraIndsZPBSOe72F/xPlnqYQz6tlc0CWcyaANwZJHXS', NULL, '2025-12-11 06:30:19', '2025-12-11 06:30:19', 'user', 9),
(19, 'jennie', 'jennie@example.com', NULL, '$2y$12$G4GQ/H5QursfTaNKpJUjaO1pvjf4mYtYmMikoRJ2LEWjsg4r2QWpu', NULL, '2025-12-11 06:31:32', '2025-12-11 06:31:32', 'user', 8),
(20, 'ben', 'ben@example.com', NULL, '$2y$12$3NfMWDJwM0GVbfpjiHb9deENSTrumFxVHks9Jx8.VzfsNo7G5Kix6', NULL, '2025-12-11 06:32:11', '2025-12-11 06:32:11', 'user', 9),
(21, 'lara', 'lara@example.com', NULL, '$2y$12$Cjbl7RLynRCrv18HGm4LVerxBn0eEIiEEwY5TUtFWXju4f6Tk0EHq', NULL, '2025-12-16 04:44:45', '2025-12-16 04:44:45', 'user', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_quotes`
--

CREATE TABLE `user_quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` bigint(20) UNSIGNED NOT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_quotes`
--

INSERT INTO `user_quotes` (`id`, `user_id`, `quote_id`, `pinned`, `created_at`, `updated_at`, `is_pinned`) VALUES
(16, 1, 30, 1, '2025-12-08 10:22:46', '2025-12-10 18:03:02', 0),
(18, 1, 27, 0, '2025-12-08 10:47:40', '2025-12-10 18:03:04', 0),
(27, 1, 29, 0, '2025-12-10 09:02:57', '2025-12-10 09:11:30', 1),
(29, 1, 26, 0, '2025-12-16 03:50:34', '2025-12-16 03:50:34', 0);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_entries_user_id_foreign` (`user_id`),
  ADD KEY `journal_entries_quote_id_foreign` (`quote_id`);

--
-- Indexes for table `journal_user`
--
ALTER TABLE `journal_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mh_questions`
--
ALTER TABLE `mh_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mh_responses`
--
ALTER TABLE `mh_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mh_responses_user_id_foreign` (`user_id`),
  ADD KEY `mh_responses_question_id_foreign` (`question_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mood_logs`
--
ALTER TABLE `mood_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mood_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_consultant_id_foreign` (`consultant_id`);

--
-- Indexes for table `user_quotes`
--
ALTER TABLE `user_quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_quotes_user_id_quote_id_unique` (`user_id`,`quote_id`),
  ADD KEY `user_quotes_quote_id_foreign` (`quote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `journal_user`
--
ALTER TABLE `journal_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mh_questions`
--
ALTER TABLE `mh_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mh_responses`
--
ALTER TABLE `mh_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `mood_logs`
--
ALTER TABLE `mood_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_quotes`
--
ALTER TABLE `user_quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD CONSTRAINT `journal_entries_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_entries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mh_responses`
--
ALTER TABLE `mh_responses`
  ADD CONSTRAINT `mh_responses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `mh_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mh_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mood_logs`
--
ALTER TABLE `mood_logs`
  ADD CONSTRAINT `mood_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_consultant_id_foreign` FOREIGN KEY (`consultant_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_quotes`
--
ALTER TABLE `user_quotes`
  ADD CONSTRAINT `user_quotes_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quotes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
