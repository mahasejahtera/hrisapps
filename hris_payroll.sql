-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 20, 2023 at 03:13 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hris_payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonus_jenis`
--

CREATE TABLE `bonus_jenis` (
  `id` int(11) NOT NULL,
  `nama_bonus` varchar(50) DEFAULT NULL,
  `tipe_bonus` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bonus_jenis`
--

INSERT INTO `bonus_jenis` (`id`, `nama_bonus`, `tipe_bonus`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tahunan', 1, '2023-11-20 09:47:41', '2023-11-20 09:47:41', NULL),
(2, 'THR', 1, '2023-11-20 09:47:47', '2023-11-20 09:47:47', NULL),
(3, 'Tunjangan', 2, '2023-11-20 09:47:53', '2023-11-20 10:08:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bonus_karyawan`
--

CREATE TABLE `bonus_karyawan` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(255) NOT NULL,
  `jenis_bonus_id` int(255) NOT NULL,
  `jumlah_bonus` int(11) DEFAULT NULL,
  `bulan_bonus` tinyint(4) DEFAULT NULL,
  `tahun_bonus` year(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bonus_karyawan`
--

INSERT INTO `bonus_karyawan` (`id`, `karyawan_id`, `jenis_bonus_id`, `jumlah_bonus`, `bulan_bonus`, `tahun_bonus`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 200000, 11, 2023, '2023-11-20 10:10:01', '2023-11-20 10:10:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(255) NOT NULL,
  `jumlah_pinjam` int(11) DEFAULT NULL,
  `bulan_pinjam` tinyint(4) DEFAULT NULL,
  `tahun_pinjam` year(4) DEFAULT NULL,
  `jumlah_cicilan` int(11) DEFAULT NULL,
  `lama_cicilan` tinyint(4) DEFAULT NULL,
  `total_dibayar` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `bulan_dibayar` tinyint(1) DEFAULT '0',
  `is_lunas` tinyint(1) UNSIGNED ZEROFILL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `karyawan_id`, `jumlah_pinjam`, `bulan_pinjam`, `tahun_pinjam`, `jumlah_cicilan`, `lama_cicilan`, `total_dibayar`, `bulan_dibayar`, `is_lunas`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 100000, 11, 2023, 50000, 2, NULL, 0, 0, '2023-11-17 21:28:27', '2023-11-17 21:28:27', NULL),
(2, 5, 100000, 11, 2023, 10000, 10, NULL, 0, 0, '2023-11-20 09:46:49', '2023-11-20 09:46:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `potongan_jenis`
--

CREATE TABLE `potongan_jenis` (
  `id` int(255) NOT NULL,
  `nama_potongan` varchar(255) NOT NULL,
  `tipe` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 = tetap\r\n2 = lain-lain',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `potongan_jenis`
--

INSERT INTO `potongan_jenis` (`id`, `nama_potongan`, `tipe`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'ergert', 1, '2023-11-17 10:44:18', '2023-11-17 10:44:18', NULL),
(5, 'hgfhj', 1, '2023-11-17 11:19:45', '2023-11-17 11:19:45', NULL),
(6, 'huhu', 2, '2023-11-19 23:17:07', '2023-11-19 23:17:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `potongan_karyawan`
--

CREATE TABLE `potongan_karyawan` (
  `id` int(255) NOT NULL,
  `karyawan_id` int(255) NOT NULL,
  `jenis_potongan_id` int(255) NOT NULL,
  `total_potongan` varchar(255) DEFAULT NULL,
  `jml_potongan` varchar(255) DEFAULT NULL,
  `bulan_mulai` int(3) DEFAULT NULL,
  `tahun_mulai` year(4) DEFAULT NULL,
  `lama_potongan` int(255) DEFAULT NULL COMMENT 'lama potongan dalam bulan',
  `sisa_bulan_potongan` int(244) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `potongan_karyawan`
--

INSERT INTO `potongan_karyawan` (`id`, `karyawan_id`, `jenis_potongan_id`, `total_potongan`, `jml_potongan`, `bulan_mulai`, `tahun_mulai`, `lama_potongan`, `sisa_bulan_potongan`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, '100000', '20000', 11, 2023, 5, 5, 1, '2023-11-17 16:01:52', '2023-11-17 16:01:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonus_jenis`
--
ALTER TABLE `bonus_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_karyawan`
--
ALTER TABLE `bonus_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`),
  ADD KEY `jenis_bonus_id` (`jenis_bonus_id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- Indexes for table `potongan_jenis`
--
ALTER TABLE `potongan_jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `potongan_karyawan`
--
ALTER TABLE `potongan_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`),
  ADD KEY `jenis_potongan_id` (`jenis_potongan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonus_jenis`
--
ALTER TABLE `bonus_jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bonus_karyawan`
--
ALTER TABLE `bonus_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `potongan_jenis`
--
ALTER TABLE `potongan_jenis`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `potongan_karyawan`
--
ALTER TABLE `potongan_karyawan`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
