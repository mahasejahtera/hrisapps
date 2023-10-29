-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2023 at 03:01 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengajuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

DROP TABLE IF EXISTS `cabang`;
CREATE TABLE IF NOT EXISTS `cabang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_cabang` char(3) NOT NULL,
  `nama_cabang` varchar(50) NOT NULL,
  `lokasi_cabang` varchar(255) NOT NULL,
  `radius_cabang` smallint NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id`, `kode_cabang`, `nama_cabang`, `lokasi_cabang`, `radius_cabang`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BDG', 'BANDUNG', '-7.3017453427514525,108.2401495272123', 20, NULL, NULL, NULL),
(2, 'TSM', 'Tasikmalaya', '-7.291292253654425, 108.23155080427959', 30, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

DROP TABLE IF EXISTS `departemen`;
CREATE TABLE IF NOT EXISTS `departemen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_dept` char(3) NOT NULL,
  `nama_dept` varchar(50) NOT NULL,
  `is_sub` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `kode_dept`, `nama_dept`, `is_sub`) VALUES
(1, 'KM', 'Komisaris', 0),
(2, 'DU', 'Direktur Utama', 0),
(3, 'DK', 'Direktur Keuangan', 0),
(4, 'GM', 'General Manager', 0),
(5, 'IT', 'Information Technology', 0),
(6, 'TK', 'Teknik', 0),
(7, 'PN', 'Pemasaran', 0),
(8, 'PR', 'Produksi', 0),
(9, 'HR', 'Human Resource Development', 0),
(10, 'SC', 'SCM', 0),
(11, 'KU', 'Keuangan', 0);

-- --------------------------------------------------------

--
-- Table structure for table `departmen_pengajuan`
--

DROP TABLE IF EXISTS `departmen_pengajuan`;
CREATE TABLE IF NOT EXISTS `departmen_pengajuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_dept` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE IF NOT EXISTS `jabatan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) NOT NULL,
  `departemen_id` int DEFAULT NULL,
  `sub_dept` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `departemen_id`, `sub_dept`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Komisaris', 1, NULL, NULL, NULL, NULL),
(2, 'Direktur Utama', 2, NULL, NULL, NULL, NULL),
(3, 'Secretary', 2, NULL, NULL, NULL, NULL),
(4, 'Legal Officer', 2, NULL, NULL, NULL, NULL),
(5, 'QHSE', 2, NULL, NULL, NULL, NULL),
(6, 'General Manager', 4, NULL, NULL, NULL, NULL),
(7, 'Civil Manager', 6, 'civil', NULL, NULL, NULL),
(8, 'Civil SPV', 6, 'civil', NULL, NULL, NULL),
(9, 'Civil Technician', 6, 'civil', NULL, NULL, NULL),
(10, 'ME Manager', 6, 'me', NULL, NULL, NULL),
(11, 'ME SPV', 6, 'me', NULL, NULL, NULL),
(12, 'ME Technician', 6, 'me', NULL, NULL, NULL),
(13, 'Administrator Teknik', 6, NULL, NULL, NULL, NULL),
(14, 'Drafter', 6, NULL, NULL, NULL, NULL),
(15, 'Production Manager', 8, NULL, NULL, NULL, NULL),
(16, 'Production SPV', 8, NULL, NULL, NULL, NULL),
(17, 'Bussines Relation', 8, NULL, NULL, NULL, NULL),
(18, 'SCM', 8, NULL, NULL, NULL, NULL),
(19, 'Administrator Produksi', 8, NULL, NULL, NULL, NULL),
(20, 'IT Manager', 5, NULL, NULL, NULL, NULL),
(21, 'IT SPV', 5, NULL, NULL, NULL, NULL),
(22, 'IT Technician', 5, NULL, NULL, NULL, NULL),
(23, 'IT Programming', 5, NULL, NULL, NULL, NULL),
(24, 'Content Creator', 5, NULL, NULL, NULL, NULL),
(25, 'Administrator IT', 5, NULL, NULL, NULL, NULL),
(26, 'Marketing Manager', 7, NULL, NULL, NULL, NULL),
(27, 'Marketing SPV', 7, NULL, NULL, NULL, NULL),
(28, 'Estimator', 7, NULL, NULL, NULL, NULL),
(29, 'Bussines Relation', 7, NULL, NULL, NULL, NULL),
(30, 'Surveyor', 7, NULL, NULL, NULL, NULL),
(31, 'Digital Marketing', 7, NULL, NULL, NULL, NULL),
(32, 'Administrator Marketing', 7, NULL, NULL, NULL, NULL),
(33, 'HRD Manager', 9, NULL, NULL, NULL, NULL),
(34, 'HRD SPV', 9, NULL, NULL, NULL, NULL),
(35, 'Recruitment & Training', 9, NULL, NULL, NULL, NULL),
(36, 'Absensi & Payroll', 9, NULL, NULL, NULL, NULL),
(37, 'Administrator HRD', 9, NULL, NULL, NULL, NULL),
(38, 'Office Boy', 9, NULL, NULL, NULL, NULL),
(39, 'Driver Office', 9, NULL, NULL, NULL, NULL),
(40, 'SCM Manager', 10, NULL, NULL, NULL, NULL),
(41, 'SCM SPV', 10, NULL, NULL, NULL, NULL),
(42, 'Procurement', 10, NULL, NULL, NULL, NULL),
(43, 'Purchasing', 10, NULL, NULL, NULL, NULL),
(44, 'Logistic', 10, NULL, NULL, NULL, NULL),
(45, 'Administrator SCM', 10, NULL, NULL, NULL, NULL),
(46, 'Driver & Project Support', 10, NULL, NULL, NULL, NULL),
(47, 'Finance Manager', 11, NULL, NULL, NULL, NULL),
(48, 'Finance SPV', 11, NULL, NULL, NULL, NULL),
(49, 'Accounting & Cashier', 11, NULL, NULL, NULL, NULL),
(50, 'Audit & ADM', 11, NULL, NULL, NULL, NULL),
(51, 'Collection Officer', 11, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE IF NOT EXISTS `karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `inisial` varchar(4) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kode_dept` char(3) DEFAULT NULL,
  `kode_cabang` char(3) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `signature` varchar(200) DEFAULT NULL,
  `pakta_integritas_check` tinyint(1) DEFAULT '0',
  `pakta_integritas_check_date` date DEFAULT NULL,
  `status_karyawan` varchar(50) DEFAULT NULL,
  `project` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `lama_kontrak_num` varchar(10) DEFAULT NULL,
  `lama_kontrak_waktu` varchar(100) DEFAULT NULL,
  `mulai_kontrak` date DEFAULT NULL,
  `akhir_kontrak` date DEFAULT NULL,
  `kontrak_check` tinyint(1) DEFAULT '0',
  `kontrak_check_date` date DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '1' COMMENT '1 = karyawan\r\n2 = manajer\r\n3 = general manager\r\n4 = direktur\r\n5 = komisaris',
  `status` int NOT NULL DEFAULT '0' COMMENT '0 = suspend login\r\n1 = pengisian data\r\n2 = suspend data\r\n3 = aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_dept` (`kode_dept`) USING BTREE,
  KEY `kode_cabang` (`kode_cabang`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nik`, `inisial`, `username`, `nama_lengkap`, `email`, `jabatan`, `no_hp`, `foto`, `kode_dept`, `kode_cabang`, `password`, `signature`, `pakta_integritas_check`, `pakta_integritas_check_date`, `status_karyawan`, `project`, `salary`, `lama_kontrak_num`, `lama_kontrak_waktu`, `mulai_kontrak`, `akhir_kontrak`, `kontrak_check`, `kontrak_check_date`, `remember_token`, `role_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, '', '12345', 'Adam Abdi Al Ala S.Kom', '', '', '089670444322', '12345.jpg', '2', 'TSM', '$2y$10$./iIwmc2h2HjB49QcsfXc.KvMVM117IGBEEZX8Mc9JfDgr4JvQd02', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(2, '8979879789', '', '12346', 'Fitriani Nur', '', '9', '0', '12346.png', '2', 'TSM', '$2y$10$u.Cpy.8nxTlHUJFMB2lHTeSyQpOw2Zx7MRu2fuT/nndxMigccZWFW', NULL, 0, NULL, 'pkwt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2023-09-26 10:48:18', NULL),
(3, NULL, '', '12347', 'Qiana', '', '9', '0', NULL, '2', 'BDG', '$2y$10$u.Cpy.8nxTlHUJFMB2lHTeSyQpOw2Zx7MRu2fuT/nndxMigccZWFW', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(4, '3242342', '', '12349', 'Daffa', '', '9', '0899999', '12349.jpg', '2', 'BDG', '$2y$10$u.Cpy.8nxTlHUJFMB2lHTeSyQpOw2Zx7MRu2fuT/nndxMigccZWFW', NULL, 0, NULL, 'tetap', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2023-09-26 10:47:46', NULL),
(5, NULL, '', '23-01', 'Atep', '', '9', '0892317171717', '23-01.jpeg', '2', 'TSM', '$2y$10$fk4AWSzlHR9q5NKfPSIY3uzkieLY/x98WxFzSmDokP.2nku8dV9rG', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2023-09-22 16:58:50', NULL),
(6, NULL, '', '8888', 'Hilman Firdaus', '', '9', '098787657567', '8888.jpg', '2', 'TSM', '$2y$10$u.Cpy.8nxTlHUJFMB2lHTeSyQpOw2Zx7MRu2fuT/nndxMigccZWFW', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(9, '30923001', '', NULL, 'T. Rizaldi Fadli', 't.rizaldifadli2001@gmail.com', '1', NULL, NULL, '2', 'BDG', '$2y$10$IjyUppTR7TsAIxnU6AZdjOzfj4XIXzEZFVnnRPiH33.YoRbdg9LV6', '9_651650a2ac392.png', 1, '2023-09-29', 'pkwt', 'Pembuatan Aplikasi HRIS', '3300000', NULL, NULL, '2023-09-01', '2024-08-31', 1, '2023-09-29', NULL, 1, 2, '2023-09-20 15:17:19', '2023-09-29 11:44:56', NULL),
(13, NULL, '', NULL, 'Ziba', 'ziba.indo@gmail.com', '2', NULL, NULL, '2', 'BDG', '$2y$10$IjyUppTR7TsAIxnU6AZdjOzfj4XIXzEZFVnnRPiH33.YoRbdg9LV6', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 0, '2023-10-02 19:53:51', '2023-10-02 19:53:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nomor_pengajuan`
--

DROP TABLE IF EXISTS `nomor_pengajuan`;
CREATE TABLE IF NOT EXISTS `nomor_pengajuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomor_terakhir` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `tahun` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nomor_pengajuan`
--

INSERT INTO `nomor_pengajuan` (`id`, `nomor_terakhir`, `id_pengajuan`, `tahun`, `created_at`, `updated_at`) VALUES
(3, 2, 15, 2023, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

DROP TABLE IF EXISTS `pengajuan`;
CREATE TABLE IF NOT EXISTS `pengajuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `kode`, `nama`) VALUES
(1, 'PFN', 'Pengajuan Format dan Nomor Surat'),
(2, 'PIK', 'Pengajuan Izin Kegiatan'),
(3, 'PIC', 'Pengajuan Izin Cuti'),
(4, 'PMJ', 'Pengajuan Izin Meninggalkan Jam Kerja'),
(5, 'PPK', 'Pengajuan Pelatihan Karyawan'),
(6, 'PPP', 'Pengajuan Peraturan Perusahaan'),
(7, 'PRK', 'Pengajuan Rekrutmen Karyawan'),
(8, 'PMK', 'Pengajuan Mutasi Karyawan'),
(9, 'PM', 'Pengajuan Material'),
(10, 'PPK', 'Pengajuan Perlengkapan'),
(11, 'PPL', 'Pengajuan Peralatan'),
(12, 'PVBJ', 'Pengajuan Vendor/Jasa Borong'),
(13, 'Pmcloud', 'Pengajuan Mcloud'),
(14, 'PDK', 'Pengajuan Direksi Keet, Kendaraan, Alat Berat'),
(15, 'HO', 'Pengajuan Hutang Operasional'),
(16, 'PUPH', 'Pengajuan Upah Pekerja Harian'),
(17, 'PIT', 'Pengajuan Inventaris Teknik'),
(18, 'PKP', 'Pengajuan Kas Proyek'),
(19, 'PDP', 'Pengajuan Departemen Pemasaran'),
(20, 'PIK', 'Pengajuan Inventaris Pemasaran'),
(21, 'PPP', 'Pengajuan Promosi Penjualan'),
(22, 'PVBJ(K)', 'Pengajuan Vendor/Jasa Borong Khusus'),
(23, 'PM(K)', 'Pengajuan Material Khusus'),
(24, 'VJB', 'Pengajuan Vendor/Jasa Borong'),
(25, 'PPI', 'Pengajuan Pinjaman'),
(26, 'PIK', 'Pengajuan Inventaris'),
(27, 'PKF', 'Pengajuan Kas Foundry'),
(28, 'RAB', 'Rancangan Anggaran Biaya'),
(29, 'PPKY', 'Pengajuan Pelatihan Karyawan'),
(30, 'PIP', 'Pengajuan Inventaris Perusahaan'),
(31, 'OPK', 'Pengajuan Operasional Kantor'),
(32, 'PPN', 'Pengajuan Penomoran Surat'),
(33, 'OPJ', 'Pengajuan Operasional Jasa'),
(34, 'PKG', 'Pengajuan Kenaikan Gaji'),
(35, 'PKMP', 'Pengajuan Kendaraan, Mesin dan Peralatan Kantor'),
(36, 'POF', 'Pengajuan Operasional Foundry'),
(37, 'PTK', 'Pengajuan Tunjangan Karyawan'),
(38, 'PPK', 'Pengajuan Perlengkapan Kantor'),
(39, 'PKP', 'Peralihan Kas Perusahaan'),
(40, 'AKN', 'Rencana Anggaran Biaya Kantor'),
(41, 'PPB', 'Permohonan Penggantian Biaya'),
(42, 'PPBOK', 'Permohonan Penggantian Biaya Ops Kantor'),
(43, 'PPBST', 'Permohonan Penggantian Biaya Tanpa HO'),
(44, 'PPBK', 'Permohonan Pergantian Biaya Khusus'),
(45, 'PIS', 'Pengajuan Inventaris Teknik'),
(46, 'FDH', 'Form Data Harga'),
(47, 'PHB', 'Pengajuan Pembayaran Hutang'),
(48, 'PIP', 'Pengajuan Jasa atau Vendor'),
(49, 'IK', 'Pengajuan Inventaris Keuangan'),
(50, 'OP', 'Pengajuan Operasional Keuangan'),
(51, 'PPPR', 'Pengajuan Peraturan Perusahaan'),
(52, 'PDK', 'Pengajuan Departemen Keuangan'),
(53, 'PPP', 'Pengajuan Pembayaran Pajak'),
(54, 'PKS', 'Pengajuan Komisi Sales'),
(55, 'PPD', 'Pengajuan Promosi Penjualan Direksi');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_izin`
--

DROP TABLE IF EXISTS `pengajuan_izin`;
CREATE TABLE IF NOT EXISTS `pengajuan_izin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` char(5) DEFAULT NULL,
  `tgl_izin` date DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT 'i : izin s : sakit',
  `keterangan` varchar(255) DEFAULT NULL,
  `status_approved` char(1) DEFAULT '0' COMMENT '0 : Pending 1: Disetuji 2: Ditolak',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pengajuan_izin`
--

INSERT INTO `pengajuan_izin` (`id`, `nik`, `tgl_izin`, `status`, `keterangan`, `status_approved`) VALUES
(2, '12345', '2023-02-23', 'i', 'Jenguk Saudara yang Sakit', '2'),
(3, '12345', '2023-02-23', 's', 'Mag', '0'),
(4, '12345', '2023-02-23', 'i', 'Mau Ke Rumah Saudara', '0'),
(5, '12346', '2023-03-14', 'i', 'Harus Datang Ke Acara Pernikahan Saudara', '2'),
(6, '8888', '2023-03-21', 'i', 'Ada Acara Keluarga', '1');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

DROP TABLE IF EXISTS `presensi`;
CREATE TABLE IF NOT EXISTS `presensi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` char(5) NOT NULL,
  `tgl_presensi` date NOT NULL,
  `jam_in` time NOT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) NOT NULL,
  `foto_out` varchar(255) DEFAULT NULL,
  `lokasi_in` text NOT NULL,
  `lokasi_out` text,
  `kode_jam_kerja` char(4) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `nik`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `kode_jam_kerja`) VALUES
(34, '12345', '2023-06-21', '07:24:08', NULL, '12345-2023-06-21-in.png', NULL, '-7.2912792500000005,108.231705', NULL, 'JK01'),
(35, '12346', '2023-06-21', '07:24:59', NULL, '12346-2023-06-21-in.png', NULL, '-7.2912792500000005,108.231705', NULL, 'JK02'),
(36, '12346', '2023-06-24', '23:18:23', '23:18:40', '12346-2023-06-24-in.png', '12346-2023-06-24-out.png', '-7.2912792500000005,108.231705', '-7.2912792500000005,108.231705', 'JK02'),
(38, '12346', '2023-06-01', '22:21:17', NULL, '12346-2023-07-01-in.png', NULL, '-7.291343656579396,108.23141258245495', NULL, 'JK02'),
(39, '12345', '2023-08-01', '07:24:08', NULL, '12345-2023-06-21-in.png', NULL, '-7.2912792500000005,108.231705', NULL, 'JK01');

-- --------------------------------------------------------

--
-- Table structure for table `submit_pengajuan`
--

DROP TABLE IF EXISTS `submit_pengajuan`;
CREATE TABLE IF NOT EXISTS `submit_pengajuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomor` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `due_date` date NOT NULL,
  `id_karyawan` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `perihal_pekerjaan` text COLLATE utf8mb4_general_ci NOT NULL,
  `total_biaya` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submit_pengajuan`
--

INSERT INTO `submit_pengajuan` (`id`, `nomor`, `tanggal`, `due_date`, `id_karyawan`, `id_pengajuan`, `perihal_pekerjaan`, `total_biaya`, `created_at`, `updated_at`) VALUES
(1, '008/HO.MEPMADINA/MAHA.TK.NF/VIII/2023', '2023-10-13', '2023-10-13', 9, 15, 'sgdfgdg', 222333, '2023-10-13 03:19:08', '2023-10-13 03:19:08'),
(2, '008/HO.MEPMADINA/MAHA.TK.NF/VIII/2023', '2023-10-15', '2023-10-15', 9, 15, 'Testing', 124322, '2023-10-15 06:43:38', '2023-10-15 06:43:38'),
(3, 'dtfthfghgf', '2023-10-22', '2023-10-22', 9, 31, 'fdgdfgd', 43, '2023-10-22 13:28:52', '2023-10-22 13:28:52'),
(4, '001/HO.MEPMADINA/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'Testing', 100000, '2023-10-25 22:56:26', '2023-10-25 22:56:26'),
(5, '001/HO.TEST/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'TEST', 10000, '2023-10-25 23:09:36', '2023-10-25 23:09:36'),
(6, '001/HO.TEST2/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'TEST2', 1000000, '2023-10-25 23:10:30', '2023-10-25 23:10:30'),
(7, '001/HO.TEST2/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'TEST2', 1000000, '2023-10-25 23:11:24', '2023-10-25 23:11:24'),
(8, '002/HO.TEST3/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'TEST3', 1000000, '2023-10-25 23:12:50', '2023-10-25 23:12:50'),
(9, '003/HO.TEST4/MAHA.IT.NF/X/2023', '2023-10-25', '2023-10-25', 9, 15, 'TEST4', 1000000, '2023-10-25 23:16:05', '2023-10-25 23:16:05'),
(10, '001/OPK.COBA/MAHA.2.NF/X/2023', '2023-10-26', '2023-10-26', 9, 31, 'TEST2', 100000, '2023-10-26 20:52:05', '2023-10-26 20:52:05'),
(11, '004/PPK.56464/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'Testing', 1000000, '2023-10-28 07:20:57', '2023-10-28 07:20:57'),
(12, '004/PPK.56464/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'Testing', 1000000, '2023-10-28 07:24:33', '2023-10-28 07:24:33'),
(13, '004/PPK.test/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'Testing', 100000, '2023-10-28 07:24:51', '2023-10-28 07:24:51'),
(14, '004/PPK.Coba/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'Test', 123444, '2023-10-28 23:02:36', '2023-10-28 23:02:36'),
(15, '004/PPK.TESTIng/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'sgdfgdg', 77777, '2023-10-28 23:17:53', '2023-10-28 23:17:53'),
(16, '004/PPK.TESTIng/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 5, 'sgdfgdg', 77777, '2023-10-28 23:19:35', '2023-10-28 23:19:35'),
(17, '004/HO.xdfsfsf/MAHA.IT.NF/X/2023', '2023-10-28', '2023-10-28', 9, 15, 'ghgfhf', 10000, '2023-10-28 23:19:58', '2023-10-28 23:19:58'),
(18, '005/PPK.MEPMADINA/MAHA../X/2023', '2023-10-29', '2023-10-29', 9, 5, 'TEST2', 100000, '2023-10-29 11:33:13', '2023-10-29 11:33:13'),
(19, '005/PPK.ffff/MAHA.2./X/2023', '2023-10-29', '2023-10-29', 9, 5, 'TEST', 4444, '2023-10-29 11:33:56', '2023-10-29 11:33:56'),
(20, '005/PPK.ffff/MAHA.2./X/2023', '2023-10-29', '2023-10-29', 9, 5, 'TEST', 4444, '2023-10-29 11:36:48', '2023-10-29 11:36:48'),
(21, '001/HO.inimau/MAHA.2./X/2023', '2023-10-29', '2023-10-29', 9, 15, 'test', 10000, '2023-10-29 11:37:08', '2023-10-29 11:37:08'),
(22, '001/HO.inimau/MAHA.2./X/2023', '2023-10-29', '2023-10-29', 9, 15, 'test', 10000, '2023-10-29 11:39:31', '2023-10-29 11:39:31'),
(23, '001/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 12222, '2023-10-29 11:39:50', '2023-10-29 11:39:50'),
(24, '001/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 12222, '2023-10-29 11:42:00', '2023-10-29 11:42:00'),
(25, '001/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 12222, '2023-10-29 11:46:25', '2023-10-29 11:46:25'),
(26, '001/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 12222, '2023-10-29 11:46:32', '2023-10-29 11:46:32'),
(27, '001/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 12222, '2023-10-29 11:47:33', '2023-10-29 11:47:33'),
(28, '001/HO.MEPMADINA/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-30', 9, 15, 'Teeeeeeeeeessss', 100000, '2023-10-29 11:51:24', '2023-10-29 11:51:24'),
(29, '002/HO.test/MAHA.2.NF/X/2023', '2023-10-29', '2023-10-29', 9, 15, 'cffgfdg', 100000, '2023-10-29 12:21:13', '2023-10-29 12:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Adam Adifa', 'adam@gmail.com', NULL, '$2y$10$IjyUppTR7TsAIxnU6AZdjOzfj4XIXzEZFVnnRPiH33.YoRbdg9LV6', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
