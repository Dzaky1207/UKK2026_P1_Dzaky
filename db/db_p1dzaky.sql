/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - db_p1dzaky
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_p1dzaky` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_p1dzaky`;

/*Table structure for table `alat` */

DROP TABLE IF EXISTS `alat`;

CREATE TABLE `alat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int DEFAULT NULL,
  `nama_alat` varchar(255) DEFAULT NULL,
  `jenis_item` enum('bundel','single','bundel_alat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `maksimal_poin_pelanggaran` int DEFAULT NULL,
  `deskripsi` text,
  `kode_slug` varchar(255) DEFAULT NULL,
  `path_foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `harga` bigint DEFAULT NULL,
  `id_lokasi` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id_kategori`),
  KEY `fk_lokasi` (`id_lokasi`),
  CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_lokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `alat` */

insert  into `alat`(`id`,`id_kategori`,`nama_alat`,`jenis_item`,`maksimal_poin_pelanggaran`,`deskripsi`,`kode_slug`,`path_foto`,`created_at`,`updated_at`,`harga`,`id_lokasi`) values 
(1,5,'Buku','single',10,'dajisida','buku','uploads/alat/1775913615_buku.jpeg','2026-04-08 08:43:02',NULL,NULL,NULL),
(8,8,'Monitor','bundel',10,'tes','monitor','uploads/alat/1776132224_monitor.jpeg','2026-04-14 09:03:44',NULL,25000,1),
(16,NULL,'Mouse','single',NULL,NULL,NULL,NULL,'2026-04-15 10:49:13',NULL,20000,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `bundel_alat` */

insert  into `bundel_alat`(`id`,`id_bundle`,`id_alat`,`jumlah`) values 
(8,8,16,10);

/*Table structure for table `detail_peminjaman` */

DROP TABLE IF EXISTS `detail_peminjaman`;

CREATE TABLE `detail_peminjaman` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `id_peminjaman` bigint NOT NULL,
  `id_alat` bigint NOT NULL,
  `jumlah` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `detail_peminjaman` */

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`nama_kategori`,`deskripsi`,`created_at`,`updated_at`) values 
(5,'alat tulis','kksdjjsad',NULL,NULL),
(7,'buku','tesss',NULL,NULL),
(8,'komputer','tes',NULL,NULL);

/*Table structure for table `kondisi_unit` */

DROP TABLE IF EXISTS `kondisi_unit`;

CREATE TABLE `kondisi_unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_unit` varchar(50) DEFAULT NULL,
  `id_pengembalian` int DEFAULT NULL,
  `kondisi` enum('baik','rusak_ringan','rusak_berat','hilang') DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kode_unit` (`kode_unit`),
  KEY `id_pengembalian` (`id_pengembalian`),
  CONSTRAINT `kondisi_unit_ibfk_1` FOREIGN KEY (`kode_unit`) REFERENCES `unit_alat` (`kode_unit`),
  CONSTRAINT `kondisi_unit_ibfk_2` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kondisi_unit` */

insert  into `kondisi_unit`(`id`,`kode_unit`,`id_pengembalian`,`kondisi`,`catatan`,`created_at`,`updated_at`) values 
(1,NULL,23,'baik','approve','2026-04-16 16:16:25','2026-04-16 16:16:25'),
(2,NULL,33,'baik','tes','2026-04-18 19:57:58','2026-04-18 19:57:58'),
(3,NULL,34,'rusak_ringan','tes','2026-04-18 20:04:00','2026-04-18 20:04:00'),
(4,NULL,32,'baik','tes','2026-04-18 20:14:16','2026-04-18 20:14:16'),
(5,NULL,31,'baik','wdoakosd','2026-04-18 20:20:27','2026-04-18 20:20:27'),
(6,NULL,30,'rusak_ringan','wessdasd','2026-04-18 20:26:42','2026-04-18 20:26:42'),
(7,NULL,29,'rusak_ringan','tead[a[asd','2026-04-18 20:41:11','2026-04-18 20:41:11'),
(8,NULL,29,'rusak_ringan','tead[a[asd','2026-04-18 20:42:25','2026-04-18 20:42:25'),
(9,NULL,29,'rusak_ringan','tead[a[asd','2026-04-18 20:42:36','2026-04-18 20:42:36'),
(10,NULL,27,'baik','mohon untuk membayar denda, terimakasih','2026-04-18 21:10:47','2026-04-18 21:10:47'),
(11,NULL,26,'baik','tes','2026-04-18 21:40:36','2026-04-18 21:40:36'),
(12,NULL,26,'baik','tes','2026-04-18 21:44:06','2026-04-18 21:44:06'),
(13,NULL,25,'baik','dwada','2026-04-18 21:44:24','2026-04-18 21:44:24'),
(14,NULL,24,'baik','adwas','2026-04-18 21:45:03','2026-04-18 21:45:03'),
(15,NULL,35,'baik','lkdaaw','2026-04-18 21:49:59','2026-04-18 21:49:59'),
(16,NULL,36,'baik','asdwad','2026-04-18 21:52:53','2026-04-18 21:52:53'),
(17,NULL,37,'baik','dwaddaw','2026-04-18 21:53:12','2026-04-18 21:53:12'),
(18,NULL,37,'baik','dwaddaw','2026-04-18 21:54:36','2026-04-18 21:54:36');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pengguna` (`id_pengguna`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `log_aktivitas` */

insert  into `log_aktivitas`(`id`,`id_pengguna`,`aksi`,`modul`,`deskripsi`,`metadata`,`alamat_ip`,`created_at`,`updated_at`) values 
(1,1,'Buat','Kategori','Kategori buku dibuat',NULL,'127.0.0.1','2026-04-08 08:41:59',NULL),
(2,1,'Buat','Alat','Alat buku ditambahkan',NULL,'127.0.0.1','2026-04-08 08:43:02',NULL),
(3,1,'Ajukan','Peminjaman','Peminjaman 1 diajukan oleh pengguna 7',NULL,'127.0.0.1','2026-04-08 08:54:24',NULL),
(4,1,'Setujui','Peminjaman','Peminjaman 1 disetujui',NULL,'127.0.0.1','2026-04-08 08:54:41',NULL),
(5,1,'Ubah','Peminjaman','Peminjaman 1 diubah',NULL,'127.0.0.1','2026-04-08 08:55:44',NULL),
(6,4,'Ubah','Alat','Alat buku diubah',NULL,'127.0.0.1','2026-04-10 09:25:21',NULL),
(7,1,'Ubah','Alat','Alat buku diubah',NULL,'127.0.0.1','2026-04-10 09:33:27',NULL),
(8,1,'Ubah','Alat','Alat buku diubah',NULL,'127.0.0.1','2026-04-10 09:34:15',NULL),
(9,1,'Buat','Kategori','Kategori komputer dibuat',NULL,'127.0.0.1','2026-04-10 09:41:28',NULL),
(10,1,'Buat','Kategori','Kategori komputer dibuat',NULL,'127.0.0.1','2026-04-10 09:41:58',NULL),
(11,1,'Hapus','Kategori','Kategori komputer dihapus',NULL,'127.0.0.1','2026-04-10 09:42:04',NULL),
(12,1,'Hapus','Kategori','Kategori komputer dihapus',NULL,'127.0.0.1','2026-04-10 09:42:07',NULL),
(13,1,'Buat','Kategori','Kategori alat tulis dibuat',NULL,'127.0.0.1','2026-04-10 09:42:36',NULL),
(14,1,'Buat','Alat','Alat Keyboard ditambahkan',NULL,'127.0.0.1','2026-04-10 10:33:49',NULL),
(15,4,'Hapus','Kategori','Kategori komputer dihapus',NULL,'127.0.0.1','2026-04-10 13:35:03',NULL),
(16,4,'Ubah','Alat','Alat pulpen diubah',NULL,'127.0.0.1','2026-04-10 13:35:35',NULL),
(17,4,'Buat','Kategori','Kategori komputer dibuat',NULL,'127.0.0.1','2026-04-10 13:40:49',NULL),
(18,4,'Hapus','Kategori','Kategori komputer dihapus',NULL,'127.0.0.1','2026-04-10 13:41:10',NULL),
(19,4,'Hapus','Kategori','Kategori buku dihapus',NULL,'127.0.0.1','2026-04-10 13:46:07',NULL),
(20,4,'Buat','Kategori','Kategori buku dibuat',NULL,'127.0.0.1','2026-04-10 13:46:22',NULL),
(21,1,'Ubah','Alat','Alat pulpen diubah',NULL,'127.0.0.1','2026-04-11 20:05:29',NULL),
(22,1,'Ubah','Alat','Alat buku diubah',NULL,'127.0.0.1','2026-04-11 20:10:23',NULL),
(23,1,'Ubah','Alat','Alat pulpen diubah',NULL,'127.0.0.1','2026-04-11 20:17:01',NULL),
(24,1,'Hapus','Alat','Alat pulpen dihapus',NULL,'127.0.0.1','2026-04-11 20:17:13',NULL),
(25,1,'Ubah','Alat','Alat buku diubah',NULL,'127.0.0.1','2026-04-11 20:17:43',NULL),
(26,1,'Ubah','Alat','Alat Pulpen diubah',NULL,'127.0.0.1','2026-04-11 20:18:27',NULL),
(27,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:20:15',NULL),
(28,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:30:02',NULL),
(29,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:34:53',NULL),
(30,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:35:17',NULL),
(31,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:35:27',NULL),
(32,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:42:19',NULL),
(33,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:42:26',NULL),
(34,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:42:49',NULL),
(35,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:46:01',NULL),
(36,1,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-11 20:56:34',NULL),
(37,4,'Buat','Kategori','Kategori komputer dibuat',NULL,'127.0.0.1','2026-04-13 22:04:29',NULL),
(38,4,'Buat','Lokasi','Lokasi Lemari A1 dibuat',NULL,'127.0.0.1','2026-04-13 22:22:59',NULL),
(39,4,'Buat','Lokasi','Lokasi Lemari A1 dibuat',NULL,'127.0.0.1','2026-04-13 22:23:19',NULL),
(40,4,'Hapus','Lokasi','Lokasi Lemari A1 dihapus',NULL,'127.0.0.1','2026-04-13 22:23:39',NULL),
(41,4,'Buat','Lokasi','Lokasi Lemari A2 dibuat',NULL,'127.0.0.1','2026-04-13 22:23:45',NULL),
(42,4,'Ubah','Lokasi','Lokasi Lemari A1 diubah',NULL,'127.0.0.1','2026-04-14 07:31:30',NULL),
(43,4,'Ubah','Lokasi','Lokasi Lemari A2 diubah',NULL,'127.0.0.1','2026-04-14 07:31:39',NULL),
(44,4,'Buat','Alat','Alat Monitor ditambahkan',NULL,'127.0.0.1','2026-04-14 09:03:44',NULL),
(45,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-14 09:22:51',NULL),
(46,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-14 09:23:08',NULL),
(47,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-14 13:06:30',NULL),
(48,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-14 13:15:42',NULL),
(49,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 07:44:24',NULL),
(50,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 08:00:50',NULL),
(51,4,'Hapus','Alat','Alat Mouse dihapus',NULL,'127.0.0.1','2026-04-15 08:02:43',NULL),
(52,4,'Hapus','Alat','Alat Keyboard dihapus',NULL,'127.0.0.1','2026-04-15 08:02:46',NULL),
(53,4,'Ubah','Alat','Alat Buku diubah',NULL,'127.0.0.1','2026-04-15 08:49:25',NULL),
(54,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 08:52:10',NULL),
(55,4,'Buat','Alat','Alat Buku ditambahkan',NULL,'127.0.0.1','2026-04-15 10:30:19',NULL),
(56,4,'Hapus','Alat','Alat Mouse dihapus',NULL,'127.0.0.1','2026-04-15 10:40:50',NULL),
(57,4,'Hapus','Alat','Alat Keyboard dihapus',NULL,'127.0.0.1','2026-04-15 10:40:53',NULL),
(58,4,'Hapus','Alat','Alat Buku dihapus',NULL,'127.0.0.1','2026-04-15 10:40:55',NULL),
(59,4,'Hapus','Alat','Alat Mouse dihapus',NULL,'127.0.0.1','2026-04-15 10:40:57',NULL),
(60,4,'Hapus','Alat','Alat Keyboard dihapus',NULL,'127.0.0.1','2026-04-15 10:40:59',NULL),
(61,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 10:47:43',NULL),
(62,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 10:48:39',NULL),
(63,4,'Ubah','Alat','Alat Monitor diubah',NULL,'127.0.0.1','2026-04-15 10:49:13',NULL);

/*Table structure for table `lokasi` */

DROP TABLE IF EXISTS `lokasi`;

CREATE TABLE `lokasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `lokasi` */

insert  into `lokasi`(`id`,`name`,`created_at`,`updated_at`,`detail`) values 
(1,'Lemari A1',NULL,NULL,'Rak A1'),
(3,'Lemari A2',NULL,NULL,'Rak A2');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `migrations` */

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `denda` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_peminjaman` (`id_peminjaman`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_pengembalian` (`id_pengembalian`),
  CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`),
  CONSTRAINT `pelanggaran_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  CONSTRAINT `pelanggaran_ibfk_3` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pelanggaran` */

insert  into `pelanggaran`(`id`,`id_peminjaman`,`id_pengguna`,`id_pengembalian`,`jenis_pelanggaran`,`poin`,`hari_terlambat`,`deskripsi`,`status`,`created_at`,`updated_at`,`denda`) values 
(1,16,7,29,'terlambat',10,2,'Terlambat 2 hari × 5 poin = 10 poin','aktif','2026-04-18 20:42:36','2026-04-18 20:42:36',0),
(2,16,7,27,'terlambat',20,4,'Terlambat 4 hari','aktif','2026-04-18 21:10:47','2026-04-18 21:10:47',0),
(3,16,7,24,'terlambat',20,4,'Terlambat 4 hari','aktif','2026-04-18 21:45:03','2026-04-18 21:45:03',0),
(4,18,7,35,'terlambat',25,5,'Terlambat 5 hari','aktif','2026-04-18 21:49:59','2026-04-18 21:49:59',0),
(5,20,7,36,'terlambat',15,3,'Terlambat 3 hari','aktif','2026-04-18 21:52:53','2026-04-18 21:52:53',9000),
(6,19,7,37,'terlambat',0,0,'Tidak terlambat','selesai','2026-04-18 21:54:36','2026-04-18 21:54:36',0);

/*Table structure for table `peminjaman` */

DROP TABLE IF EXISTS `peminjaman`;

CREATE TABLE `peminjaman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengguna` int DEFAULT NULL,
  `id_alat` int DEFAULT NULL,
  `kode_unit` varchar(50) DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','dipinjam','dikembalikan','menunggu_pengembalian') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `tujuan` text,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unit` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_alat` (`id_alat`),
  KEY `kode_unit` (`kode_unit`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id`),
  CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`kode_unit`) REFERENCES `unit_alat` (`kode_unit`),
  CONSTRAINT `peminjaman_ibfk_4` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `peminjaman` */

insert  into `peminjaman`(`id`,`id_pengguna`,`id_alat`,`kode_unit`,`id_petugas`,`status`,`tanggal_pinjam`,`tanggal_jatuh_tempo`,`tujuan`,`catatan`,`created_at`,`updated_at`,`unit`) values 
(8,7,1,NULL,1,'dikembalikan','2026-04-11','2026-04-18','wdasdwd','tes','2026-04-11 22:08:41','2026-04-11 22:24:40',NULL),
(9,7,1,NULL,1,'dikembalikan','2026-04-12','2026-04-13','tes','tes','2026-04-12 21:58:41','2026-04-12 21:59:03',NULL),
(10,7,1,NULL,4,'dikembalikan','2026-04-13','2026-04-15','wjj','jwen','2026-04-13 10:19:45','2026-04-15 11:47:51',NULL),
(11,7,1,NULL,6,'dikembalikan','2026-04-13','2026-04-14','tes','tes','2026-04-13 15:23:06','2026-04-13 15:24:02',NULL),
(12,7,1,NULL,6,'dikembalikan','2026-06-16','2026-06-17','minjem','minjem','2026-04-14 08:21:12','2026-04-15 11:47:49',NULL),
(13,11,8,NULL,6,'dikembalikan','2026-04-15','2026-04-24','tes','tes','2026-04-15 11:50:15','2026-04-15 12:58:47',NULL),
(14,11,8,NULL,6,'dikembalikan','2026-04-15','2026-04-24','tes','tes','2026-04-15 13:03:05','2026-04-15 13:03:23',NULL),
(15,7,8,NULL,6,'dikembalikan','2026-04-16','2026-04-17','tes','tes','2026-04-16 23:14:10','2026-04-16 23:16:25',NULL),
(16,7,8,NULL,6,'dikembalikan','2026-04-19','2026-04-21','minjem','tes','2026-04-19 02:34:22','2026-04-19 04:10:47',NULL),
(17,7,1,NULL,6,'dikembalikan','2026-04-19','2026-04-20','minjem','tes','2026-04-19 03:01:32','2026-04-19 03:04:00',NULL),
(18,7,8,NULL,6,'dikembalikan','2026-04-19','2026-04-20','sadksadq','kdaksdjkasd','2026-04-19 04:49:13','2026-04-19 04:49:59',NULL),
(19,7,8,NULL,6,'dikembalikan','2026-04-19','2026-04-20','dwlalkasd','wldasdw','2026-04-19 04:51:28','2026-04-19 04:53:12',NULL),
(20,7,1,NULL,6,'dikembalikan','2026-04-19','2026-04-20','ldw,adladw','dlwasd','2026-04-19 04:51:47','2026-04-19 04:52:53',NULL);

/*Table structure for table `pengembalian` */

DROP TABLE IF EXISTS `pengembalian`;

CREATE TABLE `pengembalian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int DEFAULT NULL,
  `id_petugas` int DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nama_alat` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'menunggu',
  PRIMARY KEY (`id`),
  KEY `id_peminjaman` (`id_peminjaman`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pengembalian` */

insert  into `pengembalian`(`id`,`id_peminjaman`,`id_petugas`,`tanggal_kembali`,`catatan`,`created_at`,`updated_at`,`name`,`nama_alat`,`bukti`,`status`) values 
(22,14,6,'2026-04-15',NULL,'2026-04-15 13:03:23',NULL,NULL,NULL,NULL,'ditolak'),
(23,15,6,'2026-04-16',NULL,'2026-04-16 23:15:18',NULL,NULL,NULL,'uploads/bukti/1776356118_komputer.jpeg','disetujui'),
(24,16,6,'2026-04-25',NULL,'2026-04-19 02:37:32',NULL,NULL,NULL,'uploads/bukti/1776541052_komputer.jpeg','disetujui'),
(25,16,6,'2026-04-25',NULL,'2026-04-19 02:46:44',NULL,NULL,NULL,'uploads/bukti/1776541604_komputer.jpeg','disetujui'),
(26,16,6,'2026-04-23',NULL,'2026-04-19 02:48:19',NULL,NULL,NULL,'uploads/bukti/1776541699_komputer.jpeg','disetujui'),
(27,16,6,'2026-04-25',NULL,'2026-04-19 02:53:00',NULL,NULL,NULL,'uploads/bukti/1776541980_komputer.jpeg','disetujui'),
(28,16,6,'2026-04-18',NULL,'2026-04-19 02:53:45',NULL,NULL,NULL,'uploads/bukti/1776542025_komputer.jpeg','ditolak'),
(29,16,6,'2026-04-23',NULL,'2026-04-19 02:53:52',NULL,NULL,NULL,'uploads/bukti/1776542032_komputer.jpeg','disetujui'),
(30,16,6,'2026-04-19',NULL,'2026-04-19 02:54:06',NULL,NULL,NULL,'uploads/bukti/1776542046_komputer.jpeg','disetujui'),
(31,16,6,'2026-04-18',NULL,'2026-04-19 02:54:38',NULL,NULL,NULL,'uploads/bukti/1776542078_monitor.jpeg','disetujui'),
(32,16,6,'2026-04-18',NULL,'2026-04-19 02:56:05',NULL,NULL,NULL,'uploads/bukti/1776542165_monitor.jpeg','disetujui'),
(33,16,6,'2026-04-18',NULL,'2026-04-19 02:57:06',NULL,NULL,NULL,'uploads/bukti/1776542226_monitor.jpeg','disetujui'),
(34,17,6,'2026-04-18',NULL,'2026-04-19 03:02:17',NULL,NULL,NULL,'uploads/bukti/1776542537_buku.jpeg','disetujui'),
(35,18,6,'2026-04-25',NULL,'2026-04-19 04:49:36',NULL,NULL,NULL,'uploads/bukti/1776548976_bmw.jpeg','disetujui'),
(36,20,6,'2026-04-23',NULL,'2026-04-19 04:52:19',NULL,NULL,NULL,'uploads/bukti/1776549139_buku.jpeg','disetujui'),
(37,19,6,'2026-04-19',NULL,'2026-04-19 04:52:33',NULL,NULL,NULL,'uploads/bukti/1776549153_f30.jpeg','disetujui');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nik`,`name`,`email`,`password`,`no_hp`,`alamat`,`tanggal_lahir`,`role`,`poin_pelanggaran`,`status_diblokir`,`created_at`,`updated_at`) values 
(1,NULL,'dzaky','dzaky@gmail.com','$2y$12$/kD2eKDz3a4prRy.MdGdie4Ws2FvWDZicpwlS7VJZYWNViMhbJ1XS',NULL,NULL,NULL,'admin',0,0,'2026-04-06 04:20:29','2026-04-06 12:02:58'),
(4,NULL,'admin','admin@ukk2026.com','$2y$12$v4TG9Y6sc0IAsTNV/JshZuZyK8g.d3E.f3qpj4kKFjh0RWab3cT5q',NULL,NULL,NULL,'admin',0,0,'2026-04-06 05:20:14','2026-04-18 22:06:33'),
(6,NULL,'petugas','petugas@ukk2026.com','$2y$12$q.l0ofyo/TEG9hBrWc/xL..Lx5qmLFkoKYTOZs0ijE89NuN8UqSUe',NULL,NULL,NULL,'petugas',0,0,'2026-04-07 01:24:03','2026-04-18 22:06:12'),
(7,NULL,'peminjam','peminjam@ukk2026.com','$2y$12$M0rEbtpSCN0CZfQYFmcmU.eE5GbY8oIfRoRAqfHDwOn9wItzap8ZW',NULL,NULL,NULL,'user',90,0,'2026-04-07 02:05:45','2026-04-18 22:05:57'),
(10,NULL,'Paw','paw@gmail.com','$2y$12$LfgkJE5F.FRpgt1EkkUYZeI8hICCjUptn.1NrFlR5fcoXnvfgceeS',NULL,NULL,NULL,'petugas',0,0,'2026-04-07 03:16:15','2026-04-07 04:17:21'),
(11,NULL,'peminjam1','peminjam1@gmail.com','$2y$12$AhZxoxsZvL3vNca0y557e./oR8cSb1dk7d3n/jXVBTvQTrIEKwDAS',NULL,NULL,NULL,'user',0,0,'2026-04-15 00:04:51','2026-04-15 00:04:51');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
