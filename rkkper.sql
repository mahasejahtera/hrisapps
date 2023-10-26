-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.29 - MySQL Community Server - GPL
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

-- Dumping structure for table rencanakerja.karyawans
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_dept` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.karyawans: ~10 rows (approximately)
DELETE FROM `karyawans`;
INSERT INTO `karyawans` (`id`, `nama`, `email`, `kode_dept`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 'asdas', 'asdsad', 'TK', '1', NULL, NULL),
	(2, 'ASDSAD', 'SADSAD', 'TK', '2', NULL, NULL),
	(3, 'ASDASD', 'ASDASD', 'GM', '3', NULL, NULL),
	(4, 'aaaaaaaa', 'asassad', 'IT', '1', NULL, NULL),
	(5, 'AAAAAA', 'SSSS', 'IT', '2', NULL, NULL),
	(6, 'AA', 'AA', 'DU', '1', NULL, NULL),
	(7, 'Lord', 'AAA', 'DU', '4', NULL, NULL),
	(8, 'AA', 'AAA', 'KM', '5', NULL, NULL),
	(9, 'AAA', 'AAA', 'HR', '1', NULL, NULL),
	(10, 'AA', 'AAA', 'HR', '2', NULL, NULL);

-- Dumping structure for table rencanakerja.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.migrations: ~3 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2023_10_04_072959_create_rencanakerjaas_table', 2),
	(7, '2023_10_23_023541_create_permintaan_table', 3);

-- Dumping structure for table rencanakerja.permintaan
CREATE TABLE IF NOT EXISTS `permintaan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_karyawan_penerima` bigint unsigned NOT NULL,
  `id_karyawan_pengirim` bigint unsigned NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_pengirim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_pengirim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioritas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran_penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tolak` tinyint(1) NOT NULL DEFAULT '0',
  `keterangan_tolak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `manajer_approval` tinyint(1) NOT NULL DEFAULT '0',
  `pm_approval` tinyint(1) NOT NULL DEFAULT '0',
  `hrd_approval` tinyint(1) NOT NULL DEFAULT '0',
  `direktur_approval` tinyint(1) NOT NULL DEFAULT '0',
  `komisaris_approval` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_id_karyawan_penerima_foreign` (`id_karyawan_penerima`),
  KEY `permintaan_id_karyawan_pengirim_foreign` (`id_karyawan_pengirim`),
  CONSTRAINT `permintaan_id_karyawan_penerima_foreign` FOREIGN KEY (`id_karyawan_penerima`) REFERENCES `karyawans` (`id`),
  CONSTRAINT `permintaan_id_karyawan_pengirim_foreign` FOREIGN KEY (`id_karyawan_pengirim`) REFERENCES `karyawans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.permintaan: ~15 rows (approximately)
DELETE FROM `permintaan`;
INSERT INTO `permintaan` (`id`, `id_karyawan_penerima`, `id_karyawan_pengirim`, `perihal`, `lokasi`, `waktu`, `jatuh_tempo`, `keterangan_pengirim`, `lampiran_pengirim`, `prioritas`, `lampiran_penerima`, `keterangan_penerima`, `tolak`, `keterangan_tolak`, `status`, `manajer_approval`, `pm_approval`, `hrd_approval`, `direktur_approval`, `komisaris_approval`, `created_at`, `updated_at`) VALUES
	(1, 1, 6, 'asdsa', 'asdasd', '2023-10-19', '2023-10-12', 'asdsa', '231023041711Final Prakerja.pdf', 'Normal', NULL, NULL, 0, 'aaaaaa', 3, 1, 1, 1, 1, 1, '2023-10-22 21:17:11', '2023-10-22 23:44:04'),
	(2, 4, 1, 'asdsad', 'Medan', '2023-10-17', '2023-10-18', 'asdasd', '231024075310Praktik-mandiri-5-Ardi.pdf', 'Penting', 'C:\\Users\\ardif\\AppData\\Local\\Temp\\phpF6FC.tmp', 'aaaaaa', 0, 'aasdasd', 3, 1, 1, 1, 1, 1, '2023-10-24 00:53:10', '2023-10-24 01:02:42'),
	(3, 4, 1, 'Minta File', 'Medan', '2023-10-04', '2023-10-11', 'asdas', '231024081438Praktik-mandiri-5-Ardi.pdf', 'Penting', '231024081748Praktik Kerja Mandiri 6_ Ardi Firmansyah.pdf', 'asdasdsa', 0, NULL, 4, 1, 1, 1, 1, 1, '2023-10-24 01:14:38', '2023-10-24 01:17:48'),
	(4, 5, 4, 'Meminta Contoj', 'Medan', '2023-10-19', '2023-10-16', 'asadas', '231025020721Link github.pdf', 'Normal', NULL, NULL, 0, NULL, 1, 0, 0, 0, 0, 0, '2023-10-24 19:07:21', '2023-10-24 19:07:21'),
	(5, 2, 1, 'Contoh ke Manajer', 'Medan Sekayang', '2023-10-20', '2023-10-17', 'Laasdasdas', '231025021826Final Prakerja.pdf', 'Mendesak', '231025023307Final Prakerja.pdf', 'aasdsad', 0, 'Contoh TOLAK', 4, 0, 1, 1, 1, 1, '2023-10-24 19:18:26', '2023-10-24 19:33:07'),
	(6, 5, 2, 'Contoh manajer pribadi', 'Medan', '2023-10-10', '2023-10-11', 'asdasd', '231025025450Curiculum Vitae Ardi Firmansyah__.pdf', 'Mendesak', NULL, NULL, 0, 'Tidak bagus', 3, 1, 1, 1, 1, 1, '2023-10-24 19:54:50', '2023-10-24 19:59:03'),
	(7, 5, 2, 'Contoh Diterima', 'asdas', '2023-10-03', '2023-10-04', 'asdas', '231025030402e-certificate.pdf', 'Mendesak', '231025030421Praktik-mandiri-5-Ardi.pdf', 'Bagus', 0, NULL, 4, 1, 1, 1, 1, 1, '2023-10-24 20:04:02', '2023-10-24 20:04:21'),
	(8, 3, 2, 'Contoh ke GM', 'Medan Sekayang', '2023-10-12', '2023-10-12', 'AAAADSAAAA', '231025033141Praktik Mandiri 3_Ardi Firmansyah.pdf', 'Normal', NULL, NULL, 0, 'Tidak baguss', 3, 1, 1, 1, 1, 1, '2023-10-24 20:31:41', '2023-10-24 20:35:10'),
	(9, 3, 2, 'Contoh ke GM Diterima', 'Medan Sekayang', '2023-10-18', '2023-10-12', 'asdasdas', '231025033627Praktik mandiri 5 Ardi.pdf', 'Mendesak', '231025033722e-certificate.pdf', 'Bagussa', 0, NULL, 4, 1, 1, 1, 1, 1, '2023-10-24 20:36:27', '2023-10-24 20:37:22'),
	(10, 10, 3, 'Contoh Pribadi GM', 'Medan', '2023-10-19', '2023-10-24', 'ASDAS', '231025034831Curiculum Vitae Ardi Firmansyah__.pdf', 'Mendesak', '231025042531Praktik mandiri 5 Ardi.pdf', 'asdddasdsaasasass', 0, 'sadas', 4, 1, 1, 1, 1, 1, '2023-10-24 20:48:31', '2023-10-24 21:25:31'),
	(11, 5, 10, 'Contoh HRD Pribadi', 'Medan Sekayang', '2023-10-13', '2023-10-27', 'aasdaddasddda', '231025043444Curiculum Vitae Ardi Firmansyah (1).pdf', 'Normal', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-24 21:34:44', '2023-10-24 21:34:44'),
	(12, 7, 2, 'Contoh KE dIREKTUR', 'Medan Sekayang', '2023-10-26', '2023-10-30', 'ASDASD', '231025064502Curiculum Vitae Ardi Firmansyah__.pdf', 'Normal', '231025064946Link github.pdf', 'Leidwwasd', 0, 'Tidak bagusss', 4, 0, 0, 0, 0, 0, '2023-10-24 23:45:02', '2023-10-24 23:49:46'),
	(13, 5, 7, 'Contoh Direktur Pribadi', 'Medan', '2023-10-13', '2023-10-12', 'asdaaasddasd', '231025065547Curiculum Vitae Ardi Firmansyah__.pdf', 'Penting', '231025065810Praktik-mandiri-5-Ardi.pdf', 'FIleya', 0, NULL, 4, 1, 1, 1, 1, 1, '2023-10-24 23:55:47', '2023-10-24 23:58:10'),
	(14, 8, 5, 'Contoh ke Komisaris', 'Medan Sekayang', '2023-10-19', '2023-10-12', 'asdasddasssssssd', '231025071056Final Prakerja.pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-25 00:10:56', '2023-10-25 00:10:56'),
	(15, 7, 8, 'Minta HO', 'Medan', '2023-10-12', '2023-10-18', 'asdasd', '231025080919Praktik-mandiri-5-Ardi.pdf', 'Mendesak', NULL, NULL, 0, 'asasdasd', 3, 1, 1, 1, 1, 1, '2023-10-25 01:09:19', '2023-10-25 01:09:45');

-- Dumping structure for table rencanakerja.personal_access_tokens
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

-- Dumping data for table rencanakerja.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table rencanakerja.rencanakerjas
CREATE TABLE IF NOT EXISTS `rencanakerjas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_karyawan` bigint unsigned NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_penyelesaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioritas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisi` tinyint(1) NOT NULL DEFAULT '0',
  `lampiran_revisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket_revisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `manajer_approval` tinyint(1) NOT NULL DEFAULT '0',
  `pm_approval` tinyint(1) NOT NULL DEFAULT '0',
  `hrd_approval` tinyint(1) NOT NULL DEFAULT '0',
  `direktur_approval` tinyint(1) NOT NULL DEFAULT '0',
  `komisaris_approval` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rencanakerjas_id_karyawan_foreign` (`id_karyawan`),
  CONSTRAINT `rencanakerjas_id_karyawan_foreign` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawans` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.rencanakerjas: ~0 rows (approximately)
DELETE FROM `rencanakerjas`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
