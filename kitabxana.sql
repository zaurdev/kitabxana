-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Hazırlanma Vaxtı: 07 May, 2026 saat 19:43
-- Server versiyası: 8.0.45-0ubuntu0.24.04.1
-- PHP Versiyası: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Verilənlər Bazası: `kitabxana`
--

-- --------------------------------------------------------

--
-- Cədvəl üçün cədvəl strukturu `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sxemi çıxarılan cedvel `books`
--

INSERT INTO `books` (`id`, `name`, `description`, `file`, `create_date`) VALUES
(35, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(36, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(37, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(38, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(39, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(40, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(41, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(42, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(43, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(44, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(45, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(46, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(47, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(48, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(49, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(50, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(51, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(52, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(53, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(54, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(55, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(56, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(57, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(58, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(59, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(60, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(61, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(62, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(63, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(64, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(65, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(66, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(67, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(68, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(69, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(70, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(71, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(72, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(73, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(74, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(75, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(76, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(77, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(78, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(79, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(80, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(81, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(82, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(83, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(84, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(85, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(86, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(87, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(88, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(89, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(90, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(91, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(92, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(93, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(94, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(95, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(96, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(97, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(98, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(99, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(100, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(101, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(102, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(103, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(104, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(105, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(106, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(107, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(108, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(109, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(110, 'Zaurun kitabı', 'Bu test kitabıdır', 'uploads/3c9db6cefa68bca40dd8f0e256ada5ef.pdf', '2026-05-07 18:59:37'),
(111, 'Python kitabı', 'Bu bir python kitabıdır', 'uploads/e31006c4fc73f4b5aaa11b816ab4c14c.pdf', '2026-05-07 19:04:21'),
(112, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(113, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47'),
(114, 'Python3', 'Yeni python kitabı', 'uploads/fd22b3b67847e583464a4c512663f1f5.pdf', '2026-05-07 19:06:47');

-- --------------------------------------------------------

--
-- Cədvəl üçün cədvəl strukturu `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sxemi çıxarılan cedvel `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `password`, `is_admin`, `create_date`) VALUES
(1, 'zaurhasanli98@gmail.com', 'Zaur Hasanli', '66999cec482f39aa44db8b346e12b1f8', 1, '2026-04-24 15:42:25');

--
-- Indexes for dumped tables
--

--
-- Cədvəl üçün indekslər `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Cədvəl üçün indekslər `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Cədvəl üçün AUTO_INCREMENT `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Cədvəl üçün AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
