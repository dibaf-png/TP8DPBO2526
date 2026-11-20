-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2026 at 06:34 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_music_tp`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `debut_year` int DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`, `country`, `debut_year`, `genre`) VALUES
(1, 'Hindia', 'Indonesia', 2018, 'Pop / Indie'),
(2, 'Tulus', 'Indonesia', 2011, 'Pop-jazz'),
(3, 'Shawn Mendes', 'Canada', 2014, 'Pop'),
(4, 'Taylor Swift', 'USA', 2006, 'Country / Pop'),
(5, 'Sheila On 7', 'Indonesia', 1996, 'Pop Rock / Alternatif');

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

CREATE TABLE `concert` (
  `id` int NOT NULL,
  `tour_name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `venue` varchar(150) NOT NULL,
  `concert_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`id`, `tour_name`, `city`, `venue`, `concert_date`) VALUES
(1, 'Konser Lagipula Hidup Akan Berakhir', 'Jakarta', 'Basket Hall Senayan', '2026-05-10'),
(2, 'Tur Manusia', 'Jakarta', 'JIExpo Kemayoran', '2026-11-01'),
(3, 'For Friends and Family Only Tour', 'Toronto', 'Massey Hall', '2026-10-08'),
(4, 'The Eras Tour', 'Singapore', 'Singapore National Stadium', '2024-02-07'),
(5, 'Tunggu Aku Di', 'Bandung', 'Stadion Si Jalak Harupat', '2026-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `setlist`
--

CREATE TABLE `setlist` (
  `id` int NOT NULL,
  `concert_id` int NOT NULL,
  `song_id` int NOT NULL,
  `song_order` int NOT NULL,
  `status` enum('Upcoming','Now Playing','Played','Skipped') NOT NULL DEFAULT 'Upcoming'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setlist`
--

INSERT INTO `setlist` (`id`, `concert_id`, `song_id`, `song_order`, `status`) VALUES
(1, 1, 2, 1, 'Played'),
(2, 1, 3, 2, 'Played'),
(3, 1, 1, 3, 'Now Playing'),
(4, 1, 4, 4, 'Upcoming'),
(5, 2, 5, 1, 'Played'),
(6, 2, 6, 2, 'Played'),
(7, 2, 7, 3, 'Now Playing'),
(9, 3, 12, 1, 'Played'),
(10, 3, 9, 2, 'Played'),
(12, 3, 11, 4, 'Upcoming'),
(13, 4, 13, 1, 'Played'),
(14, 4, 16, 2, 'Played'),
(15, 4, 15, 3, 'Now Playing'),
(16, 4, 14, 4, 'Upcoming'),
(18, 5, 19, 2, 'Skipped'),
(22, 5, 20, 1, 'Upcoming'),
(24, 5, 20, 4, 'Played'),
(25, 5, 20, 3, 'Now Playing');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int NOT NULL,
  `artist_id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `release_year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `artist_id`, `title`, `release_year`) VALUES
(1, 1, 'Cincin', 2023),
(2, 1, 'Mata Air', 2019),
(3, 1, 'Berdansalah, Karir Ini Tak Ada Artinya', 2023),
(4, 1, 'Tarot', 2024),
(5, 2, 'Remedi', 2022),
(6, 2, 'Interaksi', 2022),
(7, 2, 'Kelana', 2022),
(8, 2, 'Nala', 2022),
(9, 3, 'Treat You Better', 2016),
(10, 3, 'Stitches', 2015),
(11, 3, 'Why Why Why', 2024),
(12, 3, 'Imagination', 2015),
(13, 4, 'Cruel Summer', 2019),
(14, 4, 'Guilty as Sin?', 2024),
(15, 4, 'Love Story', 2008),
(16, 4, 'You Belong With Me', 2009),
(17, 5, 'Dan', 1999),
(18, 5, 'Temani Aku', 2000),
(19, 5, 'Hujan Turun', 2011),
(20, 5, 'Film Favorit', 2018);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `concert`
--
ALTER TABLE `concert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setlist`
--
ALTER TABLE `setlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concert_id` (`concert_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `concert`
--
ALTER TABLE `concert`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `setlist`
--
ALTER TABLE `setlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `setlist`
--
ALTER TABLE `setlist`
  ADD CONSTRAINT `setlist_ibfk_1` FOREIGN KEY (`concert_id`) REFERENCES `concert` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setlist_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
