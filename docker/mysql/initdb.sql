-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Aug 03, 2024 at 11:22 PM
-- Server version: 9.0.1
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `linktrees`
--

CREATE TABLE `linktrees` (
                             `linktree_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
                             `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'This text is shown as the description',
                             `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `view_count` int NOT NULL DEFAULT '0' COMMENT 'The amount of times this entry was accessed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `linktree_entrys`
--

CREATE TABLE `linktree_entrys` (
                                   `linktree_entry_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                                   `linktree_id` int UNSIGNED NOT NULL,
                                   `label` varchar(84) NOT NULL,
                                   `link` text NOT NULL,
                                   `position` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
                             `referral_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                             `user_id` int UNSIGNED NOT NULL COMMENT 'The ID of the user that owns this entry',
                             `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'A unique code that is used for /ref?q=code',
                             `pointer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/' COMMENT 'Points to the Final URL (''/'' is the root path from the aktual webserver)',
                             `view_count` int NOT NULL DEFAULT '0' COMMENT 'The amount of times this referral entry has been accessed',
                             `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                             `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Defines if this referral is enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`referral_id`, `user_id`, `code`, `pointer`, `view_count`, `creation_date`, `enabled`) VALUES
                                                                                                                    (1, 1, 'TEST', '/', 0, '2024-02-25 00:00:00', 1),
                                                                                                                    (3, 1, 'TEST1', '/', 0, '2024-02-25 00:00:00', 1),
                                                                                                                    (5, 1, 'TEST42', '/', 0, '2024-02-27 11:04:20', 1),
                                                                                                                    (6, 1, '42', '/', 15, '2024-02-28 21:30:24', 1),
                                                                                                                    (7, 1, '', '/', 0, '2024-08-03 23:20:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
                          `token_id` int UNSIGNED NOT NULL COMMENT 'The ID of this entry (Primary Key)',
                          `user_id` int UNSIGNED NOT NULL,
                          `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                          `expire_date` datetime NOT NULL COMMENT 'The expire date of this entry',
                          `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `user_id` int UNSIGNED NOT NULL COMMENT 'The database id of this user',
                         `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `passwd_hash` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
                         `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
                         `is_admin` tinyint(1) NOT NULL DEFAULT '0',
                         `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
                         `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation date of this entry',
                         `last_time_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `passwd_hash`, `email`, `description`, `is_admin`, `is_enabled`, `creation_date`, `last_time_updated`) VALUES
    (1, 'Nebalus', '8f4f01976a87d748982de93eeb6ee35d3fbcd3022d5251d798cfc9bdabe5351e', 'nebalus@proton.me', 'Is the default test User', 1, 1, '2024-02-28 21:28:40', '2024-08-03 23:07:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `linktrees`
--
ALTER TABLE `linktrees`
    ADD PRIMARY KEY (`linktree_id`),
  ADD UNIQUE KEY `account` (`user_id`);

--
-- Indexes for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    ADD PRIMARY KEY (`linktree_entry_id`),
  ADD UNIQUE KEY `linktree_id` (`linktree_id`,`position`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
    ADD PRIMARY KEY (`referral_id`),
  ADD UNIQUE KEY `refcode` (`code`) USING BTREE;

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
    ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `linktrees`
--
ALTER TABLE `linktrees`
    MODIFY `linktree_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `linktree_entrys`
--
ALTER TABLE `linktree_entrys`
    MODIFY `linktree_entry_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
    MODIFY `referral_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
    MODIFY `token_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The ID of this entry (Primary Key)';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'The database id of this user', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
