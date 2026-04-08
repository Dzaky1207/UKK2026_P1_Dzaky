/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - db_peminjaman
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_peminjaman` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_peminjaman`;

/*Table structure for table `alat` */

DROP TABLE IF EXISTS `alat`;

CREATE TABLE `alat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int DEFAULT NULL,
  `nama_alat` varchar(255) DEFAULT NULL,
  `jenis_item` enum('individu','bundel') DEFAULT NULL,
  `maksimal_poin_pelanggaran` int DEFAULT NULL,
  `deskripsi` text,
  `kode_slug` varchar(255) DEFAULT NULL,
  `path_foto` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `alat` */

/*Table structure for table `banding` */

DROP TABLE IF EXISTS `banding`;

CREATE TABLE `banding` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int DEFAULT NULL,
  `ditinjau_oleh` int DEFAULT NULL,
  `alasan` text,
  `status` enum('diajukan','diterima','ditolak') DEFAULT NULL,
  `poin_dikurangi` int DEFAULT NULL,
  `catatan_admin` text,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ditinjau_pada` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `ditinjau_oleh` (`ditinjau_oleh`),
  CONSTRAINT `banding_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  CONSTRAINT `banding_ibfk_2` FOREIGN KEY (`ditinjau_oleh`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `banding` */

/*Table structure for table `bundel_alat` */

DROP TABLE IF EXISTS `bundel_alat`;

CREATE TABLE `bundel_alat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bundle` int DEFAULT NULL,
  `id_alat` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_alat` (`id_alat`),
  CONSTRAINT `bundel_alat_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `bundel_alat` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kategori` */

/*Table structure for table `kondisi_unit` */

DROP TABLE IF EXISTS `kondisi_unit`;

CREATE TABLE `kondisi_unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_unit` varchar(50) DEFAULT NULL,
  `id_pengembalian` int DEFAULT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak_berat','hilang') DEFAULT NULL,
  `catatan` text,
  `dicatat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kode_unit` (`kode_unit`),
  KEY `id_pengembalian` (`id_pengembalian`),
  CONSTRAINT `kondisi_unit_ibfk_1` FOREIGN KEY (`kode_unit`) REFERENCES `unit_alat` (`kode_unit`),
  CONSTRAINT `kondisi_unit_ibfk_2` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kondisi_unit` */

/*Table structure for table `konfigurasi_aplikasi` */

DROP TABLE IF EXISTS `konfigurasi_aplikasi`;

CREATE TABLE `konfigurasi_aplikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_konfigurasi` varchar(255) DEFAULT NULL,
  `poin_terlambat` int DEFAULT NULL,
  `poin_rusak` int DEFAULT NULL,
  `poin_hilang` int DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `konfigurasi_aplikasi` */

/*Table structure for table `log_aktivitas` */

DROP TABLE IF EXISTS `log_aktivitas`;

CREATE TABLE `log_aktivitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int DEFAULT NULL,
  `aksi` varchar(100) DEFAULT NULL,
  `modul` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `metadata` text,
  `alamat_ip` varchar(45) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `log_aktivitas` */

/*Table structure for table `pelanggaran` */

DROP TABLE IF EXISTS `pelanggaran`;

CREATE TABLE `pelanggaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL,
  `id_pengembalian` int DEFAULT NULL,
  `jenis_pelanggaran` enum('terlambat','rusak','hilang') DEFAULT NULL,
  `poin` int DEFAULT NULL,
  `hari_terlambat` int DEFAULT NULL,
  `deskripsi` text,
  `status` enum('aktif','selesai') DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_peminjaman` (`id_peminjaman`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_pengembalian` (`id_pengembalian`),
  CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`),
  CONSTRAINT `pelanggaran_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  CONSTRAINT `pelanggaran_ibfk_3` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pelanggaran` */

/*Table structure for table `peminjaman` */

DROP TABLE IF EXISTS `peminjaman`;

CREATE TABLE `peminjaman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int DEFAULT NULL,
  `id_alat` int DEFAULT NULL,
  `kode_unit` varchar(50) DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','dipinjam','selesai') DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `tujuan` text,
  `catatan` text,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `diperbarui_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_alat` (`id_alat`),
  KEY `kode_unit` (`kode_unit`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id`),
  CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`kode_unit`) REFERENCES `unit_alat` (`kode_unit`),
  CONSTRAINT `peminjaman_ibfk_4` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `peminjaman` */

/*Table structure for table `pengembalian` */

DROP TABLE IF EXISTS `pengembalian`;

CREATE TABLE `pengembalian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `catatan` text,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_peminjaman` (`id_peminjaman`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pengembalian` */

/*Table structure for table `penyelesaian_pelanggaran` */

DROP TABLE IF EXISTS `penyelesaian_pelanggaran`;

CREATE TABLE `penyelesaian_pelanggaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pelanggaran` int DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `deskripsi` text,
  `diselesaikan_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_pelanggaran` (`id_pelanggaran`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `penyelesaian_pelanggaran_ibfk_1` FOREIGN KEY (`id_pelanggaran`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penyelesaian_pelanggaran_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penyelesaian_pelanggaran` */

/*Table structure for table `unit_alat` */

DROP TABLE IF EXISTS `unit_alat`;

CREATE TABLE `unit_alat` (
  `kode_unit` varchar(50) NOT NULL,
  `id_alat` int DEFAULT NULL,
  `status` enum('tersedia','dipinjam','rusak') DEFAULT NULL,
  `catatan` text,
  `dibuat_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_unit`),
  KEY `id_alat` (`id_alat`),
  CONSTRAINT `unit_alat_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `unit_alat` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `tanggal_lahir` date DEFAULT NULL,
  `role` enum('admin','petugas','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `poin_pelanggaran` int DEFAULT '0',
  `status_diblokir` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nik`,`name`,`email`,`password`,`no_hp`,`alamat`,`tanggal_lahir`,`role`,`poin_pelanggaran`,`status_diblokir`,`created_at`,`updated_at`) values 
(1,NULL,'dzaky','dzaky@gmail.com','$2y$12$/kD2eKDz3a4prRy.MdGdie4Ws2FvWDZicpwlS7VJZYWNViMhbJ1XS',NULL,NULL,NULL,'admin',0,0,'2026-04-06 04:20:29','2026-04-06 12:02:58'),
(4,NULL,'admin','admin@gmail.com','$2y$12$5evJuYk/C43yV5Ze8zDHROFzsqIQIdOjGPqOrjexro1jNqOW5uBHW',NULL,NULL,NULL,'admin',0,0,'2026-04-06 05:20:14','2026-04-07 09:01:27'),
(6,NULL,'petugas','petugas@gmail.com','$2y$12$TlsD4wIgNUs9MOIqYeQnAugnPYHLlJqMNbsaeqVmmzEIkALnQ7tfO',NULL,NULL,NULL,'petugas',0,0,'2026-04-07 01:24:03','2026-04-07 09:02:41'),
(7,NULL,'peminjam','peminjam@gmail.com','$2y$12$HD8MRtlXSoXxlFG.FbDtMuGNUHaQnYOAeQONhn5k5DsV0oH.m2S9K',NULL,NULL,NULL,'user',0,0,'2026-04-07 02:05:45','2026-04-07 09:07:59'),
(10,NULL,'Paw','paw@gmail.com','$2y$12$LfgkJE5F.FRpgt1EkkUYZeI8hICCjUptn.1NrFlR5fcoXnvfgceeS',NULL,NULL,NULL,'petugas',0,0,'2026-04-07 03:16:15','2026-04-07 04:17:21');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
