-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 17, 2023 at 03:47 AM
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
-- Database: `hris_surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(255) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kode`, `nama`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SPK.K', 'Surat Perjanjian Kerja Karyawan', 'adm', NULL, NULL, NULL),
(2, 'SPT', 'Surat Pernyataan', 'adm', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_list`
--

CREATE TABLE `surat_list` (
  `id` int(255) NOT NULL,
  `karyawan_penerima_id` int(255) DEFAULT NULL,
  `karyawan_pembuat_id` int(255) DEFAULT NULL,
  `kategori_id` int(255) DEFAULT NULL,
  `kategori_kode` varchar(50) DEFAULT NULL,
  `no_surat` varchar(100) DEFAULT NULL,
  `perihal` text,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `surat_list`
--

INSERT INTO `surat_list` (`id`, `karyawan_penerima_id`, `karyawan_pembuat_id`, `kategori_id`, `kategori_kode`, `no_surat`, `perihal`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, 'SPK.K', '001/SPK.K/MAHA/XI/2023', 'Kontrak Kerja T. Rizaldi Fadli', NULL, '2023-11-02 15:16:46', '2023-11-02 15:16:46', NULL),
(2, 1, NULL, NULL, 'SPT', '001/SPT/MAHA/XI/2023', 'Surat Pernyataan T. Rizaldi Fadli', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-02 15:16:46', '2023-11-02 15:16:46', NULL),
(3, 2, NULL, NULL, 'SPK.K', '002/SPK.K/MAHA/XI/2023', 'Kontrak Kerja Setia Poetra', NULL, '2023-11-02 15:27:32', '2023-11-02 15:27:32', NULL),
(4, 2, NULL, NULL, 'SPT', '002/SPT/MAHA/XI/2023', 'Surat Pernyataan Setia Poetra', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-02 15:27:32', '2023-11-02 15:27:32', NULL),
(5, 3, NULL, NULL, 'SPT', '003/SPT/MAHA/XI/2023', 'Surat Pernyataan Hazri Fadillah Harahap', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-04 09:59:35', '2023-11-04 09:59:35', NULL),
(6, 4, NULL, NULL, 'SPK.K', '003/SPK.K/MAHA/XI/2023', 'Kontrak Kerja Arsinta Yaufi', NULL, '2023-11-04 10:02:30', '2023-11-04 10:02:30', NULL),
(7, 4, NULL, NULL, 'SPT', '004/SPT/MAHA/XI/2023', 'Surat Pernyataan Arsinta Yaufi', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-04 10:02:30', '2023-11-04 10:02:30', NULL),
(8, 1, NULL, NULL, 'SPK.K', '004/SPK.K/MAHA/XI/2023', 'Kontrak Kerja T. Rizaldi Fadli', NULL, '2023-11-06 16:10:00', '2023-11-06 16:10:00', NULL),
(9, 1, NULL, NULL, 'SPT', '005/SPT/MAHA/XI/2023', 'Surat Pernyataan T. Rizaldi Fadli', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-06 16:10:00', '2023-11-06 16:10:00', NULL),
(10, 5, NULL, NULL, 'SPK.K', '005/SPK.K/MAHA/XI/2023', 'Kontrak Kerja Rahmad Syahputra', NULL, '2023-11-07 09:57:36', '2023-11-07 09:57:36', NULL),
(11, 5, NULL, NULL, 'SPT', '006/SPT/MAHA/XI/2023', 'Surat Pernyataan Rahmad Syahputra', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-07 09:57:36', '2023-11-07 09:57:36', NULL),
(12, 6, NULL, NULL, 'SPK.K', '006/SPK.K/MAHA/XI/2023', 'Kontrak Kerja Elvi Rahmy', NULL, '2023-11-07 10:00:01', '2023-11-07 10:00:01', NULL),
(13, 6, NULL, NULL, 'SPT', '007/SPT/MAHA/XI/2023', 'Surat Pernyataan Elvi Rahmy', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-07 10:00:01', '2023-11-07 10:00:01', NULL),
(14, 6, NULL, NULL, 'SPK.K', '007/SPK.K/MAHA/XI/2023', 'Kontrak Kerja Yanto', NULL, '2023-11-09 08:35:55', '2023-11-09 08:35:55', NULL),
(15, 6, NULL, NULL, 'SPT', '008/SPT/MAHA/XI/2023', 'Surat Pernyataan Yanto', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-09 08:35:55', '2023-11-09 08:35:55', NULL),
(16, 6, NULL, NULL, 'SPT', '009/SPT/MAHA/XI/2023', 'Surat Pernyataan Ivan Satriawan', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-10 13:57:15', '2023-11-10 13:57:15', NULL),
(17, 6, NULL, NULL, 'SPT', '010/SPT/MAHA/XI/2023', 'Surat Pernyataan Haha Hihi', 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera', '2023-11-14 09:11:45', '2023-11-14 09:11:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_list`
--
ALTER TABLE `surat_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_list`
--
ALTER TABLE `surat_list`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
