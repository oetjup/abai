-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table abai.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_role` varchar(2) DEFAULT NULL,
  `nama_role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table abai.role: ~3 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT IGNORE INTO `role` (`id`, `kode_role`, `nama_role`) VALUES
	(1, '1', 'Admin'),
	(2, '2', 'Dinas'),
	(3, '3', 'Operator Desa');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table abai.ticket
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_ticket` varchar(50) DEFAULT NULL,
  `content_ticket` varchar(255) DEFAULT NULL,
  `file_ticket` varchar(125) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `process_date` datetime DEFAULT NULL,
  `finished_date` datetime DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `handle_by` int(11) DEFAULT NULL,
  `reply_ticket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Dumping data for table abai.ticket: ~7 rows (approximately)
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT IGNORE INTO `ticket` (`id`, `no_ticket`, `content_ticket`, `file_ticket`, `created_by`, `created_date`, `process_date`, `finished_date`, `status`, `handle_by`, `reply_ticket`) VALUES
	(1, '202209130001', 'Mesin ADM tidak bisa cetak KIA', NULL, 3, '2022-09-13 21:15:30', NULL, NULL, '0', NULL, NULL),
	(11, '202209150001', 'Printer Brother tidak terdeteksi di Control Panel', NULL, 3, '2022-09-15 21:19:11', '2022-09-15 21:50:15', '2022-09-15 23:27:30', '2', 1, 'Petugas Desa sudah dipandu untuk mengecek kabel printer dari belakang mesin ADM. Kabel printer lepas dari port. Saat ini sudah terhubung kembali. Printer sudah bisa digunakan'),
	(12, '202209150002', 'Printer KIA tidak sampai lampu hijau', NULL, 3, '2022-09-15 21:19:18', '2022-09-15 21:46:19', NULL, '1', 2, NULL),
	(13, '202209150003', 'Printer Brother tidak terdeteksi total', NULL, 3, '2022-09-15 21:56:20', NULL, NULL, '0', NULL, NULL),
	(21, '202209180001', 'Kartu KIA tertelan printer', '213691a23c8dfdc25ccdbabd06494f29.jpeg', 4, '2022-09-18 16:13:18', '2022-09-18 17:14:21', '2022-09-18 17:15:15', '2', 1, 'Kartu tidak ada yang tertelan. Kabel lan printern ruksak. Saat ini menggunakan kabel type C. dan sudah bisa ngeprint lagi '),
	(22, '202209200001', 'Printer Brother tidak terdeteksi', '54b99baf1aae524939f460e4df4c7b70.jpeg', 4, '2022-09-20 09:17:58', NULL, NULL, '0', NULL, NULL),
	(23, '202209220001', 'gagal konek', '1791a347acf6a806cf85bd23e4703477.jpeg', 4, '2022-09-22 08:03:41', '2022-09-22 08:04:36', NULL, '1', 1, NULL);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;

-- Dumping structure for table abai.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `nama` varchar(125) DEFAULT NULL,
  `id_kel` int(11) DEFAULT NULL,
  `adm_loc` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table abai.user: ~4 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT IGNORE INTO `user` (`id`, `username`, `password`, `role`, `created_at`, `nama`, `id_kel`, `adm_loc`) VALUES
	(1, 'admin', '$2y$10$87QvYJZ7v45/ndgHAWJ9.O.tD7.Gx/8omK6mRhoyN7ZIpPW0UacwK', '1', '2022-09-16 19:52:31', 'Yusuf Hidayat', 0, NULL),
	(2, 'bibob', '$2y$10$P8Va2iy4ezR8lpI3sxCgjuIsVIIztcDl8jpegtL67xotHa4z.Y4Kq', '2', '2022-09-16 19:54:32', 'Bibob Hermawanto', 0, NULL),
	(3, 'didin', '$2y$10$GH3Mm3j63gUqGmY/1taNxu2oKy9jUW3F8XSKZPWscmyairb.a66B.', '3', '2022-09-16 19:57:18', 'Didin', 1, 'Desa Jelegong'),
	(4, 'cepi', '$2y$10$XG7ickJghZ3jFvp1oDALne7YpNzaXqlL4Sa0oU/bXbM6MNLdxdCDW', '3', '2022-09-18 07:19:08', 'Cepi', 2, 'Desa Cilampeni');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
