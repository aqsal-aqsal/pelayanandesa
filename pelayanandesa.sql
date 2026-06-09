-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2026 at 01:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelayanandesa`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian_layanan`
--

CREATE TABLE `antrian_layanan` (
  `id` int NOT NULL,
  `jenis_layanan` enum('surat','pengaduan') NOT NULL,
  `id_referensi` int NOT NULL,
  `id_warga` int NOT NULL,
  `prioritas` int DEFAULT '0',
  `waktu_masuk` datetime DEFAULT CURRENT_TIMESTAMP,
  `waktu_mulai_proses` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calon_penerima`
--

CREATE TABLE `calon_penerima` (
  `id_calon` int NOT NULL,
  `id_warga` int NOT NULL,
  `id_program` int NOT NULL,
  `tanggal_usulan` date NOT NULL,
  `status` enum('diusulkan','diproses','terpilih','tidak_terpilih') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diusulkan',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calon_penerima`
--

INSERT INTO `calon_penerima` (`id_calon`, `id_warga`, `id_program`, `tanggal_usulan`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2026-05-20', 'terpilih', '2026-05-20 01:38:22', '2026-06-09 20:24:31'),
(3, 5, 1, '2026-05-26', 'terpilih', '2026-05-26 14:13:02', '2026-06-09 20:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_saw_blt`
--

CREATE TABLE `hasil_saw_blt` (
  `id` int NOT NULL,
  `id_program` int NOT NULL,
  `id_calon` int NOT NULL,
  `nilai_total` decimal(10,5) NOT NULL,
  `ranking` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hasil_saw_blt`
--

INSERT INTO `hasil_saw_blt` (`id`, `id_program`, `id_calon`, `nilai_total`, `ranking`, `created_at`) VALUES
(14, 1, 1, '0.90333', 1, '2026-06-09 20:24:31'),
(15, 1, 3, '0.13667', 2, '2026-06-09 20:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_seleksi_saw`
--

CREATE TABLE `hasil_seleksi_saw` (
  `id_hasil` int NOT NULL,
  `id_program` int NOT NULL,
  `id_calon` int NOT NULL,
  `nilai_preferensi` decimal(8,5) NOT NULL,
  `ranking` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasi_publik`
--

CREATE TABLE `informasi_publik` (
  `id_informasi` int NOT NULL,
  `judul` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_publikasi` date NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informasi_publik`
--

INSERT INTO `informasi_publik` (`id_informasi`, `judul`, `konten`, `file_lampiran`, `tgl_publikasi`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Tes Berita', 'Isi berita', NULL, '2026-05-20', 1, '2026-05-20 00:56:00', '2026-05-20 00:56:00'),
(2, 'tes', 'tes', '1779611313.png', '2026-05-24', 1, '2026-05-24 16:28:33', '2026-05-24 16:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id_jenis_surat` int NOT NULL,
  `kode_surat` varchar(10) DEFAULT NULL,
  `nama_surat` varchar(100) DEFAULT NULL,
  `template_file` varchar(255) DEFAULT NULL,
  `prioritas` int DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id_jenis_surat`, `kode_surat`, `nama_surat`, `template_file`, `prioritas`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Surat Keterangan Domisili', NULL, 3, NULL, '2026-05-19 22:17:57', '2026-05-19 22:17:57'),
(2, NULL, 'Surat Keterangan Tidak Mampu', NULL, 2, NULL, '2026-05-19 22:18:10', '2026-05-19 22:18:10'),
(3, NULL, 'Surat Keterangan Izin Usaha', NULL, 4, NULL, '2026-05-20 11:59:48', '2026-05-20 11:59:48'),
(4, NULL, 'Surat Keterangan Kematian', NULL, 1, NULL, '2026-05-20 12:00:00', '2026-05-20 12:00:00'),
(5, NULL, 'Surat Keterangan Pindah', NULL, 3, NULL, '2026-05-20 12:00:13', '2026-05-20 12:00:13'),
(6, NULL, 'Surat Izin Keramaian', NULL, 3, NULL, '2026-05-20 12:00:33', '2026-05-20 12:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_bantuan`
--

CREATE TABLE `kriteria_bantuan` (
  `id_kriteria` int NOT NULL,
  `nama_kriteria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `tipe_kriteria` enum('benefit','cost') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria_bantuan`
--

INSERT INTO `kriteria_bantuan` (`id_kriteria`, `nama_kriteria`, `bobot`, `tipe_kriteria`, `created_at`, `updated_at`) VALUES
(2, 'Penghasilan', '40.00', 'cost', '2026-05-20 12:09:58', '2026-05-20 12:09:58'),
(3, 'Jumlah Tanggungan', '30.00', 'benefit', '2026-05-21 10:35:03', '2026-05-21 10:35:03'),
(4, 'Kondisi Rumah', '20.00', 'benefit', '2026-05-21 10:35:21', '2026-05-21 10:35:21'),
(5, 'Kepemilikan Kendaraan', '10.00', 'cost', '2026-05-21 10:35:43', '2026-05-21 10:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_kriteria_calon`
--

CREATE TABLE `nilai_kriteria_calon` (
  `id_nilai` int NOT NULL,
  `id_calon` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nilai_asli` decimal(10,3) NOT NULL,
  `nilai_normalisasi` decimal(5,3) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai_kriteria_calon`
--

INSERT INTO `nilai_kriteria_calon` (`id_nilai`, `id_calon`, `id_kriteria`, `nilai_asli`, `nilai_normalisasi`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '30.000', '1.000', '2026-05-21 11:07:04', '2026-06-09 20:23:46'),
(2, 1, 3, '10.000', '1.000', '2026-05-21 11:07:04', '2026-05-21 11:07:25'),
(3, 1, 4, '30.000', '1.000', '2026-05-21 11:07:04', '2026-05-21 11:07:25'),
(4, 1, 5, '30.000', '0.033', '2026-05-21 11:07:04', '2026-06-09 20:23:46'),
(5, 3, 2, '1500000.000', '0.000', '2026-06-09 20:22:48', '2026-06-09 20:24:16'),
(6, 3, 3, '1.000', '0.100', '2026-06-09 20:22:48', '2026-06-09 20:24:16'),
(7, 3, 4, '1.000', '0.033', '2026-06-09 20:22:48', '2026-06-09 20:24:16'),
(8, 3, 5, '1.000', '1.000', '2026-06-09 20:22:48', '2026-06-09 20:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `tipe` enum('wa','email','system') NOT NULL,
  `pesan` text NOT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `status_kirim` enum('pending','sent','failed') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penetapan_bantuan`
--

CREATE TABLE `penetapan_bantuan` (
  `id_penetapan` int NOT NULL,
  `id_program` int NOT NULL,
  `id_calon` int NOT NULL,
  `id_kades` int NOT NULL,
  `no_sk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_penetapan` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `periode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_dana` decimal(12,2) DEFAULT '0.00',
  `status_penyaluran` enum('belum','disalurkan','diterima') COLLATE utf8mb4_unicode_ci DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int NOT NULL,
  `id_warga` int NOT NULL,
  `judul_aduan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_aduan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_aduan` enum('infrastruktur','pelayanan','sosial','keamanan','lingkungan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_prioritas` int DEFAULT '0',
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan_penolakan` text COLLATE utf8mb4_unicode_ci,
  `id_petugas_verif` int DEFAULT NULL,
  `tanggal_aduan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prioritas` int DEFAULT '0',
  `waktu_proses` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `id_warga`, `judul_aduan`, `isi_aduan`, `kategori_aduan`, `file_bukti`, `nilai_prioritas`, `status`, `catatan_penolakan`, `id_petugas_verif`, `tanggal_aduan`, `tanggal_selesai`, `created_at`, `updated_at`, `prioritas`, `waktu_proses`) VALUES
(1, 4, 'Helm Hilang', 'helm hilang di pasar', 'keamanan', '1779210567_images.png', 3, 'diproses', '', 1, '2026-05-20 01:09:27', NULL, '2026-05-20 01:09:27', '2026-05-20 14:00:14', 3, '2026-05-20 14:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_surat`
--

CREATE TABLE `pengajuan_surat` (
  `id_pengajuan` int NOT NULL,
  `id_warga` int NOT NULL,
  `id_jenis_surat` int NOT NULL,
  `no_surat` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci,
  `file_berkas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_prioritas` int DEFAULT '0',
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan_penolakan` text COLLATE utf8mb4_unicode_ci,
  `id_petugas_verif` int DEFAULT NULL,
  `id_kades_ttd` int DEFAULT NULL,
  `tanggal_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_verif` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `qr_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `prioritas` int DEFAULT '0',
  `waktu_proses` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_surat`
--

INSERT INTO `pengajuan_surat` (`id_pengajuan`, `id_warga`, `id_jenis_surat`, `no_surat`, `keperluan`, `file_berkas`, `nilai_prioritas`, `status`, `catatan_penolakan`, `id_petugas_verif`, `id_kades_ttd`, `tanggal_pengajuan`, `tanggal_verif`, `tanggal_selesai`, `created_at`, `updated_at`, `qr_token`, `qr_url`, `is_verified`, `prioritas`, `waktu_proses`) VALUES
(2, 2, 1, 'SK/2/05/2026', 'Urgensi', '1779200327_images.png', 1, 'selesai', '', 1, 3, '2026-05-19 22:18:47', '2026-05-20 00:51:27', '2026-05-20 00:51:41', '2026-05-19 22:18:47', '2026-05-20 00:51:41', 'f5c20763e2b221b315d0932ab0f58934', 'http://localhost/pelayanandesa/public/verify/f5c20763e2b221b315d0932ab0f58934', 1, 3, NULL),
(3, 2, 2, NULL, 'Untuk memenuhi kebutuhan UKT Kampus', '1779200355_images.png', 1, 'menunggu', NULL, NULL, NULL, '2026-05-19 22:19:15', NULL, NULL, '2026-05-19 22:19:15', '2026-05-19 22:19:15', NULL, NULL, 0, 2, NULL),
(5, 4, 1, 'SK/5/05/2026', 'Untuk keperluan pekerjaan', '1779210521_images.png', 1, 'selesai', '', 1, 3, '2026-05-20 01:08:41', '2026-05-20 01:09:56', '2026-05-20 07:38:34', '2026-05-20 01:08:41', '2026-05-20 07:38:34', '75e82e7455387afae9728e3f66708964', 'http://localhost/pelayanandesa/public/verify/75e82e7455387afae9728e3f66708964', 1, 3, NULL),
(6, 4, 5, 'SK/6/05/2026', 'Untuk Pindah Rumah', '1779254180_images.png', 1, 'selesai', '', 1, 3, '2026-05-20 13:16:20', '2026-05-20 13:16:38', '2026-05-20 13:16:58', '2026-05-20 13:16:20', '2026-05-20 13:16:58', 'bba98533419ed83b85b50a7ed86116b4', 'http://localhost/pelayanandesa/public/verify/bba98533419ed83b85b50a7ed86116b4', 1, 3, NULL),
(7, 4, 6, 'SK/7/05/2026', 'Untuk Keperluan Acara Syukuran', '1779256775_images.png', 1, 'selesai', '', 1, 3, '2026-05-20 13:59:35', '2026-05-20 14:00:51', '2026-05-20 14:01:10', '2026-05-20 13:59:35', '2026-05-20 14:01:10', NULL, NULL, 1, 3, NULL),
(8, 4, 6, NULL, 'tes', '1781011508_a-playful-rounded-wordmark-featuring-any_rsID7c4NVVOy4GpbLqQLhQ__8VbQRt2S1C1iiMMDb92sA-removebg-preview.png', 1, 'menunggu', NULL, NULL, NULL, '2026-06-09 21:25:08', NULL, NULL, '2026-06-09 21:25:08', '2026-06-09 21:25:08', NULL, NULL, 0, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL,
  `nama_petugas` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `ttd` varchar(255) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `jabatan`, `ttd`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Petugas', NULL, 1, '2026-05-20 00:48:37', NULL),
(3, 'MULYONO', 'Kepala Desa', '1779668930_2cffa9e5.png', 1, '2026-05-20 00:49:42', '2026-05-25 08:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `program_bantuan`
--

CREATE TABLE `program_bantuan` (
  `id_program` int NOT NULL,
  `nama_program` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber_dana` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_anggaran` decimal(12,2) NOT NULL DEFAULT '0.00',
  `kuota_penerima` int NOT NULL DEFAULT '0',
  `status` enum('aktif','selesai','direncanakan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'direncanakan',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_bantuan`
--

INSERT INTO `program_bantuan` (`id_program`, `nama_program`, `sumber_dana`, `periode`, `total_anggaran`, `kuota_penerima`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MBG', 'APBN', '2026', '1900000000.00', 3000, 'direncanakan', '2026-05-20 01:38:11', '2026-05-20 01:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `label` varchar(255) NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` enum('masyarakat','petugas','kades') DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nik`, `password`, `level`, `status_aktif`, `created_at`, `updated_at`, `email`, `no_hp`) VALUES
(1, 'admin', '$2y$10$bnwW3TJtYEC1dCRKNU.QQO0BU3OU6rh/cBjkoszJY5ReDAoQc2uoe', 'petugas', 1, '2026-05-19 21:26:10', NULL, NULL, NULL),
(2, 'warga', '$2y$10$p403zowaJPWmSiz0EVdrte8LDsOoSBmWlzbF0rAZ83m2Zk8zhiyWu', 'masyarakat', 1, '2026-05-19 21:26:10', NULL, NULL, NULL),
(3, 'kades', '$2y$10$x.9jme.kAgf0964Yf81aieyCJvuDFwGrERw4rc8hC97ezyD5QFhuq', 'kades', 1, '2026-05-19 21:26:10', NULL, NULL, NULL),
(4, '6203011308010004', '$2y$10$lCQ710x5gyCxj4mB2dEffOR6CfSk62qAN5tvztmTh7WK8oRW3SbTu', 'masyarakat', 1, '2026-05-20 01:07:24', NULL, 'aqsalbuana@gmail.com', '081904158932'),
(5, '6303955901532154', '$2y$10$y.gYoW6.z.SIyDrgse9XieBqcwwl/56SQXOCmNgbS2ASDuErD1Mka', 'masyarakat', 1, '2026-05-21 12:40:39', NULL, 'eko.prasetyo@gmail.com', '080174074380'),
(6, '6303055288657460', '$2y$10$E6gm29b5hodUK3R5Kr1v/uz/cglfo5DFR25f5vzAj73l.1nNmr0ie', 'masyarakat', 1, '2026-06-09 20:36:52', NULL, 'ahmad.fauzi@gmail.com', '080718445865'),
(7, '6303494811140890', '$2y$10$YUyb4tcCIPEPoYoDA3pTnOqYU70YSc.sA/rjLaeRt8/TbjxVVGMO.', 'masyarakat', 1, '2026-06-09 20:38:55', NULL, 'budi.santoso@gmail.com', '080766262824');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id_warga` int NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL COMMENT 'L = Laki-laki, P = Perempuan',
  `alamat` text,
  `rt_rw` varchar(10) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `penghasilan` decimal(12,2) DEFAULT NULL,
  `jumlah_tanggungan` int DEFAULT NULL,
  `kondisi_rumah` enum('layak','kurang_layak','tidak_layak') DEFAULT NULL,
  `status_kawin` enum('kawin','belum_kawin','cerai') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id_warga`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `rt_rw`, `pekerjaan`, `penghasilan`, `jumlah_tanggungan`, `kondisi_rumah`, `status_kawin`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator Sistem', NULL, NULL, NULL, 'Kantor Desa', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-19 21:26:10', NULL),
(2, 'warga', 'Riswan', 'Astambul', '2004-01-01', 'L', 'Jl. Desa No. 1', NULL, 'PNS', '2500000.00', 0, NULL, NULL, '2026-05-19 21:26:10', NULL),
(3, 'kades', 'Kepala Desa Astambul', NULL, NULL, NULL, 'Rumah Dinas Kades', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-19 21:26:10', NULL),
(4, '6203011308010004', 'Aqsal Arya Buana', 'Banjarbaru', '2001-08-13', 'L', 'Jl. Indra Sari', '04', 'Tenaga Kontrak', '3400000.00', 1, 'kurang_layak', 'belum_kawin', '2026-05-20 01:07:23', NULL),
(5, '6303955901532154', 'Eko Prasetyo', 'Banyuwangi', '1999-08-06', 'L', 'Jl. Melati No. 12, Astambul', NULL, 'Pedagang', '1500000.00', 1, NULL, NULL, '2026-05-21 12:40:39', NULL),
(7, '6303055288657460', 'Ahmad Fauzi', 'Banjarbaru', '1991-05-26', 'L', 'RT 002 RW 001, Astambul', '01/05', 'Wiraswasta', '1500000.00', 3, 'layak', 'kawin', '2026-06-09 20:36:52', NULL),
(8, '6303494811140890', 'Budi Santoso', 'Banjarbaru', '1990-01-14', 'L', 'Jl. Melati No. 12, Astambul', '03/02', 'Buruh', '500000.00', 1, 'tidak_layak', 'cerai', '2026-06-09 20:38:55', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian_layanan`
--
ALTER TABLE `antrian_layanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_antrian_warga` (`id_warga`);

--
-- Indexes for table `calon_penerima`
--
ALTER TABLE `calon_penerima`
  ADD PRIMARY KEY (`id_calon`),
  ADD KEY `fk_calon_penerima_warga` (`id_warga`),
  ADD KEY `fk_calon_penerima_program` (`id_program`);

--
-- Indexes for table `hasil_saw_blt`
--
ALTER TABLE `hasil_saw_blt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_program_calon` (`id_program`,`id_calon`),
  ADD UNIQUE KEY `uk_program_ranking` (`id_program`,`ranking`),
  ADD KEY `fk_hasil_program` (`id_program`),
  ADD KEY `fk_hasil_calon` (`id_calon`);

--
-- Indexes for table `hasil_seleksi_saw`
--
ALTER TABLE `hasil_seleksi_saw`
  ADD PRIMARY KEY (`id_hasil`),
  ADD UNIQUE KEY `uk_program_calon` (`id_program`,`id_calon`),
  ADD UNIQUE KEY `uk_program_ranking` (`id_program`,`ranking`),
  ADD KEY `fk_hasil_saw_calon` (`id_calon`);

--
-- Indexes for table `informasi_publik`
--
ALTER TABLE `informasi_publik`
  ADD PRIMARY KEY (`id_informasi`),
  ADD KEY `fk_informasi_created_by` (`created_by`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id_jenis_surat`);

--
-- Indexes for table `kriteria_bantuan`
--
ALTER TABLE `kriteria_bantuan`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `nilai_kriteria_calon`
--
ALTER TABLE `nilai_kriteria_calon`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `uk_calon_kriteria` (`id_calon`,`id_kriteria`),
  ADD KEY `fk_nilai_kriteria` (`id_kriteria`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`id_user`);

--
-- Indexes for table `penetapan_bantuan`
--
ALTER TABLE `penetapan_bantuan`
  ADD PRIMARY KEY (`id_penetapan`),
  ADD UNIQUE KEY `uk_no_sk` (`no_sk`),
  ADD KEY `fk_penetapan_program` (`id_program`),
  ADD KEY `fk_penetapan_calon` (`id_calon`),
  ADD KEY `fk_penetapan_kades` (`id_kades`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `fk_pengaduan_warga` (`id_warga`),
  ADD KEY `fk_pengaduan_petugas_verif` (`id_petugas_verif`);

--
-- Indexes for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_pengajuan_warga` (`id_warga`),
  ADD KEY `fk_pengajuan_jenis_surat` (`id_jenis_surat`),
  ADD KEY `fk_pengajuan_petugas_verif` (`id_petugas_verif`),
  ADD KEY `fk_pengajuan_kades_ttd` (`id_kades_ttd`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `program_bantuan`
--
ALTER TABLE `program_bantuan`
  ADD PRIMARY KEY (`id_program`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_user_warga` (`nik`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id_warga`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrian_layanan`
--
ALTER TABLE `antrian_layanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calon_penerima`
--
ALTER TABLE `calon_penerima`
  MODIFY `id_calon` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hasil_saw_blt`
--
ALTER TABLE `hasil_saw_blt`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hasil_seleksi_saw`
--
ALTER TABLE `hasil_seleksi_saw`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi_publik`
--
ALTER TABLE `informasi_publik`
  MODIFY `id_informasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id_jenis_surat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kriteria_bantuan`
--
ALTER TABLE `kriteria_bantuan`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nilai_kriteria_calon`
--
ALTER TABLE `nilai_kriteria_calon`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penetapan_bantuan`
--
ALTER TABLE `penetapan_bantuan`
  MODIFY `id_penetapan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id_pengajuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `program_bantuan`
--
ALTER TABLE `program_bantuan`
  MODIFY `id_program` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id_warga` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrian_layanan`
--
ALTER TABLE `antrian_layanan`
  ADD CONSTRAINT `fk_antrian_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calon_penerima`
--
ALTER TABLE `calon_penerima`
  ADD CONSTRAINT `fk_calon_penerima_program` FOREIGN KEY (`id_program`) REFERENCES `program_bantuan` (`id_program`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calon_penerima_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil_saw_blt`
--
ALTER TABLE `hasil_saw_blt`
  ADD CONSTRAINT `fk_hasil_calon` FOREIGN KEY (`id_calon`) REFERENCES `calon_penerima` (`id_calon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hasil_program` FOREIGN KEY (`id_program`) REFERENCES `program_bantuan` (`id_program`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasil_seleksi_saw`
--
ALTER TABLE `hasil_seleksi_saw`
  ADD CONSTRAINT `fk_hasil_saw_calon` FOREIGN KEY (`id_calon`) REFERENCES `calon_penerima` (`id_calon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hasil_saw_program` FOREIGN KEY (`id_program`) REFERENCES `program_bantuan` (`id_program`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `informasi_publik`
--
ALTER TABLE `informasi_publik`
  ADD CONSTRAINT `fk_informasi_created_by` FOREIGN KEY (`created_by`) REFERENCES `petugas` (`id_petugas`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `nilai_kriteria_calon`
--
ALTER TABLE `nilai_kriteria_calon`
  ADD CONSTRAINT `fk_nilai_calon` FOREIGN KEY (`id_calon`) REFERENCES `calon_penerima` (`id_calon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nilai_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria_bantuan` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penetapan_bantuan`
--
ALTER TABLE `penetapan_bantuan`
  ADD CONSTRAINT `fk_penetapan_calon` FOREIGN KEY (`id_calon`) REFERENCES `calon_penerima` (`id_calon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penetapan_kades` FOREIGN KEY (`id_kades`) REFERENCES `petugas` (`id_petugas`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penetapan_program` FOREIGN KEY (`id_program`) REFERENCES `program_bantuan` (`id_program`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `fk_pengaduan_petugas_verif` FOREIGN KEY (`id_petugas_verif`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengaduan_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  ADD CONSTRAINT `fk_pengajuan_jenis_surat` FOREIGN KEY (`id_jenis_surat`) REFERENCES `jenis_surat` (`id_jenis_surat`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_kades_ttd` FOREIGN KEY (`id_kades_ttd`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_petugas_verif` FOREIGN KEY (`id_petugas_verif`) REFERENCES `petugas` (`id_petugas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengajuan_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria_bantuan` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_warga` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
