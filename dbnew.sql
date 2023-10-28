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

-- Dumping data for table rencanakerja.karyawans: ~8 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.migrations: ~2 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2023_10_04_072959_create_rencanakerjaas_table', 2),
	(7, '2023_10_23_023541_create_permintaan_table', 3),
	(8, '2023_10_28_024418_create_tugas_table', 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.permintaan: ~7 rows (approximately)
DELETE FROM `permintaan`;
INSERT INTO `permintaan` (`id`, `id_karyawan_penerima`, `id_karyawan_pengirim`, `perihal`, `lokasi`, `waktu`, `jatuh_tempo`, `keterangan_pengirim`, `lampiran_pengirim`, `prioritas`, `lampiran_penerima`, `keterangan_penerima`, `tolak`, `keterangan_tolak`, `status`, `manajer_approval`, `pm_approval`, `hrd_approval`, `direktur_approval`, `komisaris_approval`, `created_at`, `updated_at`) VALUES
	(73, 7, 10, 'ke manajer pm dan direktur', 'asdsad', '2023-10-19', '2023-10-17', 'asdasd', '231027090459Final Prakerja.pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:04:59', '2023-10-27 02:04:59'),
	(74, 2, 10, 'ke manajer biasa', 'asdas', '2023-10-17', '2023-10-12', 'asdsad', '231027092127Link github.pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:21:27', '2023-10-27 02:21:27'),
	(75, 3, 10, 'asdsadsad', 'asdsad', '2023-10-10', '2023-10-03', 'asdsa', '231027092218Curiculum Vitae Ardi Firmansyah__ (1).pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:22:18', '2023-10-27 02:22:18'),
	(76, 8, 10, 'komisa', 'asdsad', '2023-10-25', '2023-10-09', 'asdsa', '231027092335Curiculum Vitae Ardi Firmansyah (1).pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:23:35', '2023-10-27 02:23:35'),
	(77, 8, 7, 'ke komsiarisa', 'Medan', '2023-10-03', '2023-10-06', 'asdsad', '231027092653Curiculum Vitae Ardi Firmansyah (1).pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:26:53', '2023-10-27 02:26:53'),
	(78, 5, 7, 'Meminta ATK', 'Medan', '2023-10-07', '2023-10-11', 'asasd', '231027092745Praktik Mandiri 4_Ardi Firmansyah.pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:27:45', '2023-10-27 02:27:45'),
	(79, 5, 8, 'asdasd', 'asdasd', '2023-10-19', '2023-10-26', 'asdasd', '231027093146Praktik Kerja Mandiri 6_ Ardi Firmansyah.pdf', 'Mendesak', NULL, NULL, 0, NULL, 1, 1, 1, 1, 1, 1, '2023-10-27 02:31:46', '2023-10-27 02:31:46');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.rencanakerjas: ~0 rows (approximately)
DELETE FROM `rencanakerjas`;
INSERT INTO `rencanakerjas` (`id`, `id_karyawan`, `perihal`, `lokasi`, `waktu`, `target_penyelesaian`, `keterangan`, `lampiran`, `prioritas`, `revisi`, `lampiran_revisi`, `ket_revisi`, `status`, `manajer_approval`, `pm_approval`, `hrd_approval`, `direktur_approval`, `komisaris_approval`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Meminta ATK', 'Medan', '2023-10-04', '2023-10-05', 'asdasd', '231026065602Praktik mandiri 5 Ardi.pdf', 'Normal', 0, NULL, NULL, 0, 0, 0, 0, 0, 1, '2023-10-25 23:56:02', '2023-10-25 23:56:02');

-- Dumping structure for table rencanakerja.tugas
CREATE TABLE IF NOT EXISTS `tugas` (
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
  `progress1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_progress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tugas_id_karyawan_penerima_foreign` (`id_karyawan_penerima`),
  KEY `tugas_id_karyawan_pengirim_foreign` (`id_karyawan_pengirim`),
  CONSTRAINT `tugas_id_karyawan_penerima_foreign` FOREIGN KEY (`id_karyawan_penerima`) REFERENCES `karyawans` (`id`),
  CONSTRAINT `tugas_id_karyawan_pengirim_foreign` FOREIGN KEY (`id_karyawan_pengirim`) REFERENCES `karyawans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rencanakerja.tugas: ~3 rows (approximately)
DELETE FROM `tugas`;
INSERT INTO `tugas` (`id`, `id_karyawan_penerima`, `id_karyawan_pengirim`, `perihal`, `lokasi`, `waktu`, `jatuh_tempo`, `keterangan_pengirim`, `lampiran_pengirim`, `prioritas`, `progress1`, `progress2`, `progress3`, `progress4`, `progress5`, `keterangan_progress`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 'Banyakk ha;;;;asd', 'Medan', '2023-10-04', '2023-10-11', 'asdasd', '231028040058e-certificate.pdf', 'Mendesak', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-27 21:00:58', '2023-10-27 21:00:58'),
	(2, 2, 3, 'ASDASD', 'Medan', '2023-10-17', '2023-10-25', 'ASDASDSA', '231028063425Curiculum Vitae Ardi Firmansyahh.pdf', 'Mendesak', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-27 23:34:25', '2023-10-27 23:34:25'),
	(3, 2, 3, 'asd', 'Medan', '2023-10-18', '2023-10-17', 'asdsa', '231028063644Curiculum Vitae Ardi Firmansyah__.pdf', 'Normal', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-27 23:36:44', '2023-10-27 23:36:44'),
	(4, 3, 7, 'sadasd', 'asdsad', '2023-10-07', '2023-10-22', 'asdasd', '231028065656Praktik Mandiri 3_Ardi Firmansyah.pdf', 'Mendesak', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-27 23:56:56', '2023-10-27 23:56:56'),
	(5, 3, 8, 'asdasdasd', 'asdasssssssssssssssssssssssssssssssssssssss', '2023-10-19', '2023-10-17', 'asdasd', '231028071713Praktik Mandiri 4_Ardi Firmansyah.pdf', 'Mendesak', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-28 00:17:13', '2023-10-28 00:17:13'),
	(6, 3, 8, 'asdasdasd', 'asdasssssssssssssssssssssssssssssssssssssss', '2023-10-19', '2023-10-17', 'asdasd', '231028071732Praktik-mandiri-5-Ardi.pdf', 'Mendesak', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-10-28 00:17:32', '2023-10-28 00:17:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
