-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2026 at 12:51 PM
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
  MODIFY `id_calon` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_saw_blt`
--
ALTER TABLE `hasil_saw_blt`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_seleksi_saw`
--
ALTER TABLE `hasil_seleksi_saw`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi_publik`
--
ALTER TABLE `informasi_publik`
  MODIFY `id_informasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id_jenis_surat` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kriteria_bantuan`
--
ALTER TABLE `kriteria_bantuan`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai_kriteria_calon`
--
ALTER TABLE `nilai_kriteria_calon`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_surat`
--
ALTER TABLE `pengajuan_surat`
  MODIFY `id_pengajuan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_bantuan`
--
ALTER TABLE `program_bantuan`
  MODIFY `id_program` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id_warga` int NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_warga` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
