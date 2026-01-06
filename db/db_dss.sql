-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jan 2026 pada 12.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dss`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatives`
--

CREATE TABLE `alternatives` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alternatives`
--

INSERT INTO `alternatives` (`id`, `name`, `created_at`) VALUES
(40, 'A1', '2026-01-03 03:18:57'),
(41, 'A2', '2026-01-03 03:19:14'),
(42, 'A3', '2026-01-03 03:19:30'),
(43, 'A4', '2026-01-03 03:19:50'),
(44, 'A5', '2026-01-03 03:20:16'),
(45, 'A6', '2026-01-03 03:20:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternative_scores`
--

CREATE TABLE `alternative_scores` (
  `id` int(11) NOT NULL,
  `alternative_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alternative_scores`
--

INSERT INTO `alternative_scores` (`id`, `alternative_id`, `criteria_id`, `score`) VALUES
(197, 40, 11, 5),
(198, 40, 12, 5),
(199, 40, 13, 4),
(200, 40, 14, 5),
(201, 40, 15, 4),
(202, 41, 11, 4),
(203, 41, 12, 4),
(204, 41, 13, 2),
(205, 41, 14, 3),
(206, 41, 15, 2),
(207, 42, 11, 5),
(208, 42, 12, 4),
(209, 42, 13, 5),
(210, 42, 14, 4),
(211, 42, 15, 4),
(212, 43, 11, 3),
(213, 43, 12, 3),
(214, 43, 13, 1),
(215, 43, 14, 2),
(216, 43, 15, 2),
(217, 44, 11, 4),
(218, 44, 12, 4),
(219, 44, 13, 3),
(220, 44, 14, 4),
(221, 44, 15, 3),
(222, 45, 11, 4),
(223, 45, 12, 3),
(224, 45, 13, 2),
(225, 45, 14, 3),
(226, 45, 15, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `criterias`
--

CREATE TABLE `criterias` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 1,
  `type` enum('benefit','cost') NOT NULL DEFAULT 'benefit',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `criterias`
--

INSERT INTO `criterias` (`id`, `code`, `name`, `weight`, `type`, `description`, `created_at`, `updated_at`) VALUES
(11, 'C1', 'Akreditasi', 4, 'benefit', '', '2026-01-02 20:15:45', '2026-01-02 20:15:45'),
(12, 'C2', 'Fasilitas', 5, 'benefit', '', '2026-01-02 20:15:57', '2026-01-02 20:15:57'),
(13, 'C3', 'Biaya', 3, 'cost', '', '2026-01-02 20:16:18', '2026-01-02 20:16:18'),
(14, 'C4', 'Reputasi', 4, 'benefit', '', '2026-01-02 20:16:28', '2026-01-02 20:16:28'),
(15, 'C5', 'Jarak', 2, 'cost', '', '2026-01-02 20:16:36', '2026-01-02 20:16:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `last_login`, `created_at`) VALUES
(1, 'Zikra', 'zikrafatira73@gmail.com', '123456', 'admin', '2026-01-05 11:16:46', '2026-01-01 00:39:30'),
(3, 'users', 'user@gmail.com', 'user123', 'user', '2026-01-05 12:18:51', '2026-01-05 18:16:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `alternative_scores`
--
ALTER TABLE `alternative_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_alt_criteria` (`alternative_id`,`criteria_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indeks untuk tabel `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `alternative_scores`
--
ALTER TABLE `alternative_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT untuk tabel `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alternative_scores`
--
ALTER TABLE `alternative_scores`
  ADD CONSTRAINT `alternative_scores_ibfk_1` FOREIGN KEY (`alternative_id`) REFERENCES `alternatives` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alternative_scores_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
