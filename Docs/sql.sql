-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               9.4.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tuan-coffee
CREATE DATABASE IF NOT EXISTS `tuan-coffee` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tuan-coffee`;

-- Dumping structure for table tuan-coffee.daftar_mejas
CREATE TABLE IF NOT EXISTS `daftar_mejas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_meja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_meja` enum('tersedia','tidak_tersedia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daftar_mejas_nama_meja_unique` (`nama_meja`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.daftar_mejas: ~15 rows (approximately)
DELETE FROM `daftar_mejas`;
INSERT INTO `daftar_mejas` (`id`, `nama_meja`, `qr_code_path`, `status_meja`, `created_at`, `updated_at`) VALUES
	(1, 'Meja 01', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(2, 'Meja 02', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(3, 'Meja 03', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(4, 'Meja 04', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(5, 'Meja 05', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(6, 'Meja 06', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(7, 'Meja 07', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(8, 'Meja 08', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(9, 'Meja 09', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(10, 'Meja 10', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(11, 'Meja 11', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(12, 'Meja 12', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(13, 'Meja 13', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(14, 'Meja 14', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(15, 'Meja 15', NULL, 'tersedia', '2025-11-23 06:24:40', '2025-11-23 06:24:40');

-- Dumping structure for table tuan-coffee.daftar_menus
CREATE TABLE IF NOT EXISTS `daftar_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `url_gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tersedia` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daftar_menus_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `daftar_menus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.daftar_menus: ~0 rows (approximately)
DELETE FROM `daftar_menus`;
INSERT INTO `daftar_menus` (`id`, `kategori_id`, `nama_menu`, `deskripsi`, `url_gambar`, `tersedia`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Kopi Susu', 'Kopi susu dengan gula aren pilihan.', NULL, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(2, 1, 'Americano', 'Espresso dengan tambahan air.', NULL, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(3, 2, 'Teh Lemon', 'Teh segar dengan perasan lemon.', NULL, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(4, 3, 'Kentang Goreng', 'Kentang goreng renyah disajikan dengan saus.', NULL, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40');

-- Dumping structure for table tuan-coffee.detail_pesanans
CREATE TABLE IF NOT EXISTS `detail_pesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint unsigned NOT NULL,
  `varian_menu_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL,
  `harga_saat_pesan` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pesanans_pesanan_id_foreign` (`pesanan_id`),
  KEY `detail_pesanans_varian_menu_id_foreign` (`varian_menu_id`),
  CONSTRAINT `detail_pesanans_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pesanans_varian_menu_id_foreign` FOREIGN KEY (`varian_menu_id`) REFERENCES `varian_menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.detail_pesanans: ~99 rows (approximately)
DELETE FROM `detail_pesanans`;
INSERT INTO `detail_pesanans` (`id`, `pesanan_id`, `varian_menu_id`, `jumlah`, `harga_saat_pesan`, `created_at`, `updated_at`) VALUES
	(1, 1, 4, 2, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(2, 2, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(3, 2, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(4, 3, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(5, 3, 5, 1, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(6, 4, 1, 1, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(7, 4, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(8, 5, 2, 2, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(9, 5, 5, 1, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(10, 6, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(11, 7, 5, 2, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(12, 7, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(13, 7, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(14, 8, 1, 1, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(15, 8, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(16, 9, 2, 1, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(17, 9, 5, 1, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(18, 9, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(19, 10, 5, 2, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(20, 10, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(21, 11, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(22, 12, 2, 1, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(23, 12, 5, 1, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(24, 13, 3, 1, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(25, 13, 4, 1, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(26, 13, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(27, 14, 5, 2, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(28, 15, 4, 2, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(29, 15, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(30, 16, 3, 1, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(31, 16, 5, 1, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(32, 17, 3, 1, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(33, 18, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(34, 18, 3, 2, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(35, 18, 6, 2, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(36, 19, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(37, 19, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(38, 20, 3, 1, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(39, 21, 6, 2, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(40, 22, 4, 1, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(41, 22, 7, 1, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(42, 23, 2, 1, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(43, 23, 7, 2, 22000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(44, 24, 2, 1, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(45, 24, 3, 2, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(46, 24, 6, 2, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(47, 25, 3, 2, 15000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(48, 25, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(49, 26, 4, 1, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(50, 27, 2, 1, 20000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(51, 27, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(52, 28, 1, 2, 18000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(53, 28, 4, 1, 17000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(54, 28, 6, 2, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(55, 29, 5, 2, 12000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(56, 30, 6, 1, 14000.00, '2025-11-23 06:24:41', '2025-11-23 06:24:41'),
	(57, 31, 1, 1, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(58, 31, 4, 1, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(59, 31, 6, 1, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(60, 32, 4, 2, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(61, 32, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(62, 33, 1, 1, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(63, 34, 4, 1, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(64, 35, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(65, 35, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(66, 35, 7, 2, 22000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(67, 36, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(68, 37, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(69, 37, 7, 1, 22000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(70, 38, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(71, 38, 4, 2, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(72, 38, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(73, 39, 1, 1, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(74, 39, 2, 2, 20000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(75, 39, 7, 1, 22000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(76, 40, 4, 2, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(77, 40, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(78, 41, 1, 2, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(79, 41, 2, 1, 20000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(80, 42, 6, 1, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(81, 43, 5, 2, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(82, 43, 6, 1, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(83, 44, 1, 1, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(84, 44, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(85, 45, 7, 1, 22000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(86, 46, 2, 1, 20000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(87, 46, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(88, 46, 4, 1, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(89, 47, 1, 2, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(90, 47, 4, 1, 17000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(91, 47, 6, 2, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(92, 48, 1, 2, 18000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(93, 48, 2, 2, 20000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(94, 48, 6, 1, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(95, 49, 2, 2, 20000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(96, 49, 5, 2, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(97, 49, 6, 1, 14000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(98, 50, 3, 1, 15000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42'),
	(99, 50, 5, 1, 12000.00, '2025-11-23 06:24:42', '2025-11-23 06:24:42');

-- Dumping structure for table tuan-coffee.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table tuan-coffee.kategori_menus
CREATE TABLE IF NOT EXISTS `kategori_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_menus_nama_kategori_unique` (`nama_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.kategori_menus: ~3 rows (approximately)
DELETE FROM `kategori_menus`;
INSERT INTO `kategori_menus` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
	(1, 'Kopi', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(2, 'Non-Kopi', '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(3, 'Makanan Ringan', '2025-11-23 06:24:40', '2025-11-23 06:24:40');

-- Dumping structure for table tuan-coffee.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_06_19_090458_create_daftar_mejas_table', 1),
	(6, '2025_06_19_090459_create_kategori_menus_table', 1),
	(7, '2025_06_19_090512_create_daftar_menus_table', 1),
	(8, '2025_06_19_090520_create_varian_menus_table', 1),
	(9, '2025_06_19_090538_create_pesanans_table', 1),
	(10, '2025_06_19_090545_create_detail_pesanans_table', 1),
	(11, '2025_06_19_091713_create_permission_tables', 1),
	(12, '2025_06_19_191330_add_qr_code_path_to_daftar_mejas_table', 1),
	(13, '2025_06_28_003103_add_payment_method_to_pesanans_table', 1);

-- Dumping structure for table tuan-coffee.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.model_has_permissions: ~0 rows (approximately)
DELETE FROM `model_has_permissions`;

-- Dumping structure for table tuan-coffee.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.model_has_roles: ~0 rows (approximately)
DELETE FROM `model_has_roles`;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3),
	(4, 'App\\Models\\User', 4);

-- Dumping structure for table tuan-coffee.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table tuan-coffee.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.permissions: ~0 rows (approximately)
DELETE FROM `permissions`;

-- Dumping structure for table tuan-coffee.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table tuan-coffee.pesanans
CREATE TABLE IF NOT EXISTS `pesanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `daftar_meja_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pesanan` enum('baru','diproses','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baru',
  `status_bayar` enum('menunggu','lunas','gagal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanans_daftar_meja_id_foreign` (`daftar_meja_id`),
  KEY `pesanans_user_id_foreign` (`user_id`),
  CONSTRAINT `pesanans_daftar_meja_id_foreign` FOREIGN KEY (`daftar_meja_id`) REFERENCES `daftar_mejas` (`id`),
  CONSTRAINT `pesanans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.pesanans: ~49 rows (approximately)
DELETE FROM `pesanans`;
INSERT INTO `pesanans` (`id`, `daftar_meja_id`, `user_id`, `nama_pelanggan`, `total_bayar`, `metode_pembayaran`, `status_pesanan`, `status_bayar`, `created_at`, `updated_at`) VALUES
	(1, 7, 2, NULL, 34000.00, NULL, 'diproses', 'lunas', '2025-11-16 20:34:27', '2025-11-23 06:24:41'),
	(2, 5, 2, NULL, 80000.00, NULL, 'selesai', 'lunas', '2025-11-10 10:59:59', '2025-11-23 06:24:41'),
	(3, 4, NULL, 'Zamira Pratiwi', 48000.00, NULL, 'baru', 'lunas', '2025-11-11 04:02:16', '2025-11-23 06:24:41'),
	(4, 6, 2, NULL, 62000.00, NULL, 'dibatalkan', 'gagal', '2025-11-04 17:44:14', '2025-11-23 06:24:41'),
	(5, 15, 2, NULL, 52000.00, NULL, 'selesai', 'lunas', '2025-11-04 14:49:42', '2025-11-23 06:24:41'),
	(6, 7, NULL, 'Galar Hidayanto', 36000.00, NULL, 'dibatalkan', 'gagal', '2025-11-01 22:06:06', '2025-11-23 06:24:41'),
	(7, 12, NULL, 'Suci Lailasari S.E.I', 82000.00, NULL, 'dibatalkan', 'gagal', '2025-11-03 02:34:59', '2025-11-23 06:24:41'),
	(8, 6, NULL, 'Nalar Harsanto Nainggolan', 32000.00, NULL, 'diproses', 'lunas', '2025-11-11 11:25:48', '2025-11-23 06:24:41'),
	(9, 13, NULL, 'Perkasa Maryanto Thamrin', 46000.00, NULL, 'selesai', 'lunas', '2025-11-16 20:02:01', '2025-11-23 06:24:41'),
	(10, 12, NULL, 'Gandi Eman Simbolon', 68000.00, NULL, 'selesai', 'lunas', '2025-11-22 10:41:19', '2025-11-23 06:24:41'),
	(11, 6, NULL, 'Karya Latif Maryadi', 36000.00, NULL, 'dibatalkan', 'gagal', '2025-11-07 09:19:14', '2025-11-23 06:24:41'),
	(12, 4, 2, NULL, 32000.00, NULL, 'dibatalkan', 'gagal', '2025-11-04 02:28:43', '2025-11-23 06:24:41'),
	(13, 4, NULL, 'Aswani Maheswara', 76000.00, NULL, 'baru', 'lunas', '2025-11-22 04:19:26', '2025-11-23 06:24:41'),
	(14, 1, NULL, 'Okta Asmianto Dongoran M.Ak', 24000.00, NULL, 'baru', 'lunas', '2025-10-31 05:06:45', '2025-11-23 06:24:41'),
	(15, 5, NULL, 'Lili Wahyuni', 48000.00, NULL, 'baru', 'lunas', '2025-10-30 18:31:03', '2025-11-23 06:24:41'),
	(16, 9, NULL, 'Rini Farida', 27000.00, NULL, 'dibatalkan', 'gagal', '2025-11-15 09:44:59', '2025-11-23 06:24:41'),
	(17, 5, NULL, 'Kayun Niyaga Damanik M.TI.', 15000.00, NULL, 'selesai', 'lunas', '2025-11-07 23:11:22', '2025-11-23 06:24:41'),
	(18, 2, 2, NULL, 94000.00, NULL, 'baru', 'lunas', '2025-11-05 21:28:17', '2025-11-23 06:24:41'),
	(19, 2, NULL, 'Vanya Nurdiyanti', 80000.00, NULL, 'selesai', 'lunas', '2025-11-10 05:02:45', '2025-11-23 06:24:41'),
	(20, 11, NULL, 'Kambali Rajata', 15000.00, NULL, 'baru', 'lunas', '2025-10-29 18:41:25', '2025-11-23 06:24:41'),
	(21, 10, 2, NULL, 28000.00, NULL, 'dibatalkan', 'gagal', '2025-11-09 06:53:15', '2025-11-23 06:24:41'),
	(22, 15, 2, NULL, 39000.00, NULL, 'dibatalkan', 'gagal', '2025-11-18 20:10:01', '2025-11-23 06:24:41'),
	(23, 1, NULL, 'Gatra Pradipta S.Psi', 64000.00, NULL, 'baru', 'lunas', '2025-11-18 19:13:37', '2025-11-23 06:24:41'),
	(24, 7, NULL, 'Azalea Permata', 78000.00, NULL, 'diproses', 'lunas', '2025-10-26 02:45:07', '2025-11-23 06:24:41'),
	(25, 13, 2, NULL, 44000.00, NULL, 'baru', 'lunas', '2025-11-14 03:06:45', '2025-11-23 06:24:41'),
	(26, 10, NULL, 'Anita Nuraini', 17000.00, NULL, 'diproses', 'lunas', '2025-10-24 04:40:26', '2025-11-23 06:24:41'),
	(27, 12, 2, NULL, 34000.00, NULL, 'dibatalkan', 'gagal', '2025-11-05 10:48:41', '2025-11-23 06:24:41'),
	(28, 4, 2, NULL, 81000.00, NULL, 'diproses', 'lunas', '2025-10-31 11:33:35', '2025-11-23 06:24:41'),
	(29, 7, NULL, 'Vicky Andriani', 24000.00, NULL, 'dibatalkan', 'gagal', '2025-10-24 03:38:08', '2025-11-23 06:24:41'),
	(30, 8, NULL, 'Raina Lidya Prastuti', 14000.00, NULL, 'dibatalkan', 'gagal', '2025-10-28 13:26:37', '2025-11-23 06:24:41'),
	(31, 11, NULL, 'Jumari Ramadan', 49000.00, NULL, 'diproses', 'lunas', '2025-11-17 16:47:29', '2025-11-23 06:24:41'),
	(32, 2, NULL, 'Zelaya Yuniar M.TI.', 46000.00, NULL, 'selesai', 'lunas', '2025-11-10 00:25:46', '2025-11-23 06:24:42'),
	(33, 15, NULL, 'Ghaliyati Purwanti', 18000.00, NULL, 'dibatalkan', 'gagal', '2025-10-25 03:38:49', '2025-11-23 06:24:42'),
	(34, 11, 2, NULL, 17000.00, NULL, 'baru', 'lunas', '2025-11-13 20:26:27', '2025-11-23 06:24:42'),
	(35, 9, NULL, 'Unjani Nurdiyanti', 71000.00, NULL, 'diproses', 'lunas', '2025-11-07 16:24:44', '2025-11-23 06:24:42'),
	(36, 12, 2, NULL, 12000.00, NULL, 'baru', 'lunas', '2025-11-19 21:00:43', '2025-11-23 06:24:42'),
	(37, 7, NULL, 'Danu Endra Nababan', 37000.00, NULL, 'selesai', 'lunas', '2025-11-03 08:17:58', '2025-11-23 06:24:42'),
	(38, 10, NULL, 'Dina Novi Andriani M.M.', 61000.00, NULL, 'dibatalkan', 'gagal', '2025-11-06 22:33:17', '2025-11-23 06:24:42'),
	(39, 14, 2, NULL, 80000.00, NULL, 'selesai', 'lunas', '2025-11-12 15:04:59', '2025-11-23 06:24:42'),
	(40, 3, NULL, 'Raina Fujiati S.E.', 46000.00, NULL, 'dibatalkan', 'gagal', '2025-10-25 12:58:16', '2025-11-23 06:24:42'),
	(41, 8, NULL, 'Aslijan Firgantoro', 56000.00, NULL, 'selesai', 'lunas', '2025-10-29 04:40:37', '2025-11-23 06:24:42'),
	(42, 6, NULL, 'Wasis Yahya Mahendra S.T.', 14000.00, NULL, 'diproses', 'lunas', '2025-11-15 22:58:00', '2025-11-23 06:24:42'),
	(43, 1, NULL, 'Kajen Sihombing', 38000.00, NULL, 'baru', 'lunas', '2025-11-07 06:40:24', '2025-11-23 06:24:42'),
	(44, 13, NULL, 'Ganep Asmuni Zulkarnain S.Kom', 33000.00, NULL, 'selesai', 'lunas', '2025-11-17 18:35:43', '2025-11-23 06:24:42'),
	(45, 9, 2, NULL, 22000.00, NULL, 'diproses', 'lunas', '2025-11-18 10:29:40', '2025-11-23 06:24:42'),
	(46, 10, NULL, 'Gaduh Praba Saragih', 52000.00, NULL, 'diproses', 'lunas', '2025-11-17 07:48:38', '2025-11-23 06:24:42'),
	(47, 2, 2, NULL, 81000.00, NULL, 'dibatalkan', 'gagal', '2025-11-21 01:13:35', '2025-11-23 06:24:42'),
	(48, 8, 2, NULL, 90000.00, NULL, 'dibatalkan', 'gagal', '2025-11-07 00:58:13', '2025-11-23 06:24:42'),
	(49, 15, NULL, 'Kairav Damanik S.Kom', 78000.00, NULL, 'diproses', 'lunas', '2025-11-12 23:39:02', '2025-11-23 06:24:42'),
	(50, 6, NULL, 'Hamima Agustina', 27000.00, NULL, 'selesai', 'lunas', '2025-11-16 16:34:35', '2025-11-23 06:24:42');

-- Dumping structure for table tuan-coffee.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.roles: ~2 rows (approximately)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2025-11-23 06:24:38', '2025-11-23 06:24:38'),
	(2, 'karyawan', 'web', '2025-11-23 06:24:38', '2025-11-23 06:24:38'),
	(3, 'pelayan', 'web', '2025-11-23 06:24:38', '2025-11-23 06:24:38'),
	(4, 'pengguna', 'web', '2025-11-23 06:24:38', '2025-11-23 06:24:38');

-- Dumping structure for table tuan-coffee.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.role_has_permissions: ~0 rows (approximately)
DELETE FROM `role_has_permissions`;

-- Dumping structure for table tuan-coffee.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.users: ~4 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@tuan.com', NULL, '$2y$12$5.VbfG.zjHVP8vOxEyXtoeLSRPWYfg3XlSyrf.wucdtwXYHXy5ppm', NULL, '2025-11-23 06:24:39', '2025-11-23 06:24:39'),
	(2, 'karyawan', 'karyawan@tuan.com', NULL, '$2y$12$TPYJqrFwpOUlIYObcvJWIOcNAfBBpo0VCxMfKp.K4itE41YhBJ2vW', NULL, '2025-11-23 06:24:39', '2025-11-23 06:24:39'),
	(3, 'Pelayan', 'pelayan@tuan.com', NULL, '$2y$12$u7UyXCf7lTFCOC55lak08OMUnnPeqw5HuYjGiSe1yGCyIZirB7I6C', NULL, '2025-11-23 06:24:39', '2025-11-23 06:24:39'),
	(4, 'Pengguna', 'pengguna@tuan.com', NULL, '$2y$12$F.9DdW5hYpsnXy/BNrWtpOJWW8p9u4BNe//mtXCPoZmvLx1fhn5iO', NULL, '2025-11-23 06:24:40', '2025-11-23 06:24:40');

-- Dumping structure for table tuan-coffee.varian_menus
CREATE TABLE IF NOT EXISTS `varian_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `daftar_menu_id` bigint unsigned NOT NULL,
  `nama_varian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `tersedia` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `varian_menus_daftar_menu_id_foreign` (`daftar_menu_id`),
  CONSTRAINT `varian_menus_daftar_menu_id_foreign` FOREIGN KEY (`daftar_menu_id`) REFERENCES `daftar_menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tuan-coffee.varian_menus: ~7 rows (approximately)
DELETE FROM `varian_menus`;
INSERT INTO `varian_menus` (`id`, `daftar_menu_id`, `nama_varian`, `harga`, `tersedia`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Panas', 18000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(2, 1, 'Dingin', 20000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(3, 2, 'Panas', 15000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(4, 2, 'Dingin', 17000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(5, 3, 'Panas', 12000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(6, 3, 'Dingin', 14000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40'),
	(7, 4, 'Original', 22000.00, 1, '2025-11-23 06:24:40', '2025-11-23 06:24:40');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
