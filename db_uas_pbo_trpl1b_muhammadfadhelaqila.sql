-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2026 at 03:04 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_trpl1b_muhammadfadhelaqila`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_karyawan`
--

CREATE TABLE `tabel_karyawan` (
  `id_karyawan` int NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `departemen` varchar(50) NOT NULL,
  `hari_kerja_masuk` int NOT NULL,
  `gaji_dasar_per_hari` decimal(10,2) NOT NULL,
  `jenis_karyawan` enum('Kontrak','Tetap','Magang') NOT NULL,
  `durasi_kontrak_bulan` int DEFAULT NULL,
  `agensi_penyalur` varchar(100) DEFAULT NULL,
  `tunjangan_kesehatan` decimal(10,2) DEFAULT NULL,
  `opsi_saham_id` varchar(50) DEFAULT NULL,
  `uang_saku_bulanan` decimal(10,2) DEFAULT NULL,
  `sertifikat_kampus_merdeka` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_karyawan`
--

INSERT INTO `tabel_karyawan` (`id_karyawan`, `nama_karyawan`, `departemen`, `hari_kerja_masuk`, `gaji_dasar_per_hari`, `jenis_karyawan`, `durasi_kontrak_bulan`, `agensi_penyalur`, `tunjangan_kesehatan`, `opsi_saham_id`, `uang_saku_bulanan`, `sertifikat_kampus_merdeka`) VALUES
(1, 'Muhammad Fadhel Aqila', 'IT Engineering', 22, 250000.00, 'Tetap', NULL, NULL, 500000.00, 'ESOP-001', NULL, NULL),
(2, 'Ahmad Subarjo', 'Human Resources', 20, 200000.00, 'Tetap', NULL, NULL, 450000.00, 'ESOP-002', NULL, NULL),
(3, 'Siti Aminah', 'Finance', 21, 220000.00, 'Tetap', NULL, NULL, 450000.00, 'ESOP-003', NULL, NULL),
(4, 'Budi Doremi', 'Marketing', 19, 190000.00, 'Tetap', NULL, NULL, 400000.00, 'ESOP-004', NULL, NULL),
(5, 'Citra Lestari', 'Operations', 23, 210000.00, 'Tetap', NULL, NULL, 500000.00, 'ESOP-005', NULL, NULL),
(6, 'Dedi Kurniawan', 'Legal', 22, 240000.00, 'Tetap', NULL, NULL, 500000.00, 'ESOP-006', NULL, NULL),
(7, 'Eka Putri', 'IT Support', 20, 180000.00, 'Tetap', NULL, NULL, 400000.00, 'ESOP-007', NULL, NULL),
(8, 'Rian Hidayat', 'Procurement', 22, 170000.00, 'Kontrak', 12, 'PT Mitratama Solusindo', NULL, NULL, NULL, NULL),
(9, 'Dewi Sartika', 'Creative Design', 18, 165000.00, 'Kontrak', 6, 'PT Kreatif Bangsa', NULL, NULL, NULL, NULL),
(10, 'Fajar Nusantara', 'Security', 24, 130000.00, 'Kontrak', 24, 'PT Garda Nusantara', NULL, NULL, NULL, NULL),
(11, 'Gita Gutawa', 'Public Relations', 15, 180000.00, 'Kontrak', 6, 'PT Bakat Prima', NULL, NULL, NULL, NULL),
(12, 'Hendra Wijaya', 'Logistics', 22, 150000.00, 'Kontrak', 12, 'PT Mitratama Solusindo', NULL, NULL, NULL, NULL),
(13, 'Indah Permata', 'Customer Service', 21, 140000.00, 'Kontrak', 12, 'PT Interkontinental', NULL, NULL, NULL, NULL),
(14, 'Joko Susilo', 'General Affairs', 23, 135000.00, 'Kontrak', 6, 'PT Garda Nusantara', NULL, NULL, NULL, NULL),
(15, 'Kevin Sanjaya', 'IT Engineering', 20, 90000.00, 'Magang', NULL, NULL, NULL, NULL, 1500000.00, 'MSIB-BATCH-6-PBO'),
(16, 'Lesti Kejora', 'Data Analyst', 22, 95000.00, 'Magang', NULL, NULL, NULL, NULL, 1800000.00, 'MSIB-BATCH-6-DATA'),
(17, 'Rizky Billar', 'UI/UX Design', 19, 85000.00, 'Magang', NULL, NULL, NULL, NULL, 1500000.00, 'KAMPUS-MERDEKA-DESIGN'),
(18, 'Megawati Putri', 'Marketing Admin', 17, 80000.00, 'Magang', NULL, NULL, NULL, NULL, 1200000.00, 'KAMPUS-MERDEKA-MKT'),
(19, 'Nadiem Makarim', 'Product Management', 20, 100000.00, 'Magang', NULL, NULL, NULL, NULL, 2000000.00, 'MSIB-BATCH-6-PM'),
(20, 'Prabowo Subianto', 'Business Development', 21, 95000.00, 'Magang', NULL, NULL, NULL, NULL, 1800000.00, 'MSIB-BATCH-6-BD');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
