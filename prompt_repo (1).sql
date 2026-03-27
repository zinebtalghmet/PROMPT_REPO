
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 04:29 PM
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
-- Database: `prompt_repo`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `Title`, `Created_at`) VALUES
(1, 'Code', '2026-03-26 10:21:04'),
(2, 'Marketing', '2026-03-26 10:21:52'),
(4, 'Finance', '2026-03-26 10:22:21'),
(6, 'Sales', '2026-03-26 10:22:45'),
(8, 'Testing', '2026-03-26 14:55:01'),
(9, 'DevOps', '2026-03-26 15:01:08'),
(11, 'Investing', '2026-03-27 10:24:54'),
(12, 'Growth Marketing', '2026-03-27 10:24:54'),
(13, 'Content Marketing', '2026-03-27 10:24:54'),
(14, 'Analytics', '2026-03-27 10:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `prompts`
--

CREATE TABLE `prompts` (
  `Id` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Category_Id` int(11) NOT NULL,
  `Created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`Id`, `Title`, `content`, `User_Id`, `Category_Id`, `Created_at`) VALUES
(3, 'Promot for cofing php', 'hjjfjf fjfjf jfjfkf', 1, 1, '2026-03-26 11:45:41'),
(4, 'Strategie marketing pour ads', 'dfgh ghjk ghjk ghjk', 1, 2, '2026-03-26 11:56:56'),
(5, 'Personal Finance Tracker App', 'Create a personal finance tracking app that allows users to manage income, expenses, and savings. Include features like transaction history, budget categories, monthly reports, and simple charts. Use a clean and minimal UI with a focus on usability and clarity.', 7, 4, '2026-03-26 12:05:16'),
(6, 'Crypto Portfolio Dashboard', 'Design a cryptocurrency portfolio dashboard with real-time price tracking, asset allocation, and performance analytics. Use a dark theme with modern UI components, interactive charts, and clear data visualization.', 1, 4, '2026-03-26 15:07:25'),
(7, 'Email Marketing', 'Design an email marketing platform interface with campaign creation, contact management, templates, and analytics. Focus on ease of use, drag-and-drop features, and modern UI patterns..', 7, 2, '2026-03-26 16:08:45'),
(8, 'Banking Mobile App UI', 'Create a mobile banking app interface with features like account overview, transfers, transaction history, and notifications. Focus on security, simplicity, and a professional design style.', 1, 4, '2026-03-26 16:21:49'),
(11, 'git prompto', 'git push', 1, 1, '2026-03-27 11:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Role` enum('admin','user') DEFAULT 'user',
  `Created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Password`, `Email`, `Role`, `Created_at`) VALUES
(1, 'zineb_tlg', '$2y$10$lQJH9446xo22iEeO2kK.9u8wPur100IwDNYd4c3NyU9//rS54xr36', 'zinebtalghmet2022@gmail.com', 'admin', '2026-03-25 10:15:40'),
(4, 'TALGHMET', '$2y$10$by/QxZpBVn07PJjOqNCF2OgcwooDuLKMMd0vmXpg3HkKFkTcVbK4u', 'ramdankr715@gmail.com', 'user', '2026-03-25 10:23:27'),
(7, 'noaracontact', '$2y$10$VaZY0mnXDNs5XN5bjUM5x..zKKwHAQYh6TpvLY0LP5SnPIseJF7YS', 'noaracontact@gmail.com', 'user', '2026-03-25 10:28:01'),
(8, 'zinabo.1', '$2y$10$nMJslrHojZnCVlBOQbr5wOMkSber.j9e0nwkIaftz7x1mPIyBJLBu', 'zinebtalghmet2023@gmail.com', 'user', '2026-03-27 10:14:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `Category_Id` (`Category_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `prompts_ibfk_2` FOREIGN KEY (`Category_Id`) REFERENCES `categories` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
