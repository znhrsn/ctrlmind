-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 12:52 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
