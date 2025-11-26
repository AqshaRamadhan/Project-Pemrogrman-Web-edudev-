-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table proyek_web_b.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table proyek_web_b.courses: ~2 rows (approximately)
INSERT INTO `courses` (`id`, `judul`, `deskripsi`) VALUES
	(1, 'Dasar-Dasar HTML & CSS', 'Mempelajari fondasi dari setiap website.'),
	(2, 'Pengantar Basis Data (SQL)', 'Mempelajari query dasar dan relasi antar tabel.');

-- Dumping structure for table proyek_web_b.enrollments
CREATE TABLE IF NOT EXISTS `enrollments` (
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `tgl_enroll` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table proyek_web_b.enrollments: ~2 rows (approximately)
INSERT INTO `enrollments` (`user_id`, `course_id`, `tgl_enroll`) VALUES
	(1, 1, '2025-11-17 19:09:49'),
	(2, 1, '2025-11-17 19:13:16'),
	(2, 2, '2025-11-26 19:19:04'),
	(3, 1, '2025-11-26 14:46:14'),
	(3, 2, '2025-11-26 14:46:11');

-- Dumping structure for table proyek_web_b.modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `judul_modul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_materi` text COLLATE utf8mb4_general_ci,
  `urutan` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table proyek_web_b.modules: ~7 rows (approximately)
INSERT INTO `modules` (`id`, `course_id`, `judul_modul`, `isi_materi`, `urutan`) VALUES
	(1, 1, 'Modul 1: Struktur Dasar HTML5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...', 1),
	(2, 1, 'Modul 2: Selektor dan Properti CSS', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ...', 2),
	(3, 1, 'Modul 3: Box Model dan Layout Dasar', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. ...', 3),
	(4, 1, 'Modul 4: Pengenalan Media Queries', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum. ...', 4),
	(5, 2, 'Bab 1: DDL (Create, Drop)', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia. ...', 1),
	(6, 2, 'Bab 2: DML (Select, Insert, Update)', 'Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse. ...', 2),
	(7, 2, 'Bab 3: Join dan Subquery', 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. ...', 3);

-- Dumping structure for table proyek_web_b.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table proyek_web_b.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
	(1, 'root', '$2y$10$wE9B2o78s/VzY6jYdJ.lJOTw0.4WJz3/4Qd8.4nS3oP', 'Tes', 'user'),
	(2, 'tes', '$2y$10$.6vQsu0FsNNDABRA3U4EueENGuKIsoKeZC5Qzd4wtojc4JvMkhu52', 'Asep', 'user'),
	(3, 'shaaa', '$2y$12$/nWwl7CPxxvwMXKMDBR1ZOJyHqsyQC4xT9yN/rov0cWPuHHyt3ibi', 'aqsha', 'user');

-- Dumping structure for table proyek_web_b.user_progress
CREATE TABLE IF NOT EXISTS `user_progress` (
  `user_id` int NOT NULL,
  `module_id` int NOT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `tgl_selesai` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`module_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table proyek_web_b.user_progress: ~4 rows (approximately)
INSERT INTO `user_progress` (`user_id`, `module_id`, `is_completed`, `tgl_selesai`) VALUES
	(1, 1, 1, NULL),
	(1, 2, 1, NULL),
	(2, 1, 1, '2025-11-17 20:54:32'),
	(2, 2, 1, '2025-11-26 19:18:57'),
	(2, 3, 1, '2025-11-26 19:18:58'),
	(2, 4, 1, '2025-11-17 19:13:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
