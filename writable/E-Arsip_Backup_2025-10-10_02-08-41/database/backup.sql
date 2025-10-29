SET FOREIGN_KEY_CHECKS = 0;

-- Struktur tabel `tbl_arsip`
DROP TABLE IF EXISTS `tbl_arsip`;
CREATE TABLE `tbl_arsip` (
  `id_arsip` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_upload` date DEFAULT NULL,
  `tgl_update` date DEFAULT NULL,
  `file_arsip` varchar(255) DEFAULT NULL,
  `id_dep` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_user_upload` varchar(255) DEFAULT NULL,
  `klasifikasi` enum('rahasia','terbatas','umum') DEFAULT 'umum',
  `ukuran_arsip` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_arsip`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_arsip`
INSERT INTO `tbl_arsip` VALUES ('76', '31', 'wdqd', '2025-10-08', '2025-10-08', 'screenshot_2025-09-12_140619_29b442.png', '9', '18', 'administrator', 'umum', '48693');
INSERT INTO `tbl_arsip` VALUES ('77', '22', 'cs', '2025-10-09', NULL, 'screenshot_2025-09-16_151416_6eb649.png', '10', '18', 'administrator', 'terbatas', '163462');
INSERT INTO `tbl_arsip` VALUES ('78', '22', 'vsdcv', '2025-10-09', NULL, 'screenshot_2025-09-17_094151_9c86f1.png', '10', '18', 'administrator', 'rahasia', '5598');
INSERT INTO `tbl_arsip` VALUES ('79', '41', 'Head printer', '2025-10-09', NULL, 'whatsapp_image_2025-09-04_at_102148_d9b359.jpeg', '23', '12', 'hendra', 'umum', '115837');


-- Struktur tabel `tbl_arsip_akses`
DROP TABLE IF EXISTS `tbl_arsip_akses`;
CREATE TABLE `tbl_arsip_akses` (
  `id_akses` int(11) NOT NULL AUTO_INCREMENT,
  `id_arsip` int(11) DEFAULT NULL,
  `id_dep` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_akses`),
  KEY `id_arsip` (`id_arsip`),
  KEY `id_dep` (`id_dep`),
  CONSTRAINT `tbl_arsip_akses_ibfk_1` FOREIGN KEY (`id_arsip`) REFERENCES `tbl_arsip` (`id_arsip`) ON DELETE CASCADE,
  CONSTRAINT `tbl_arsip_akses_ibfk_2` FOREIGN KEY (`id_dep`) REFERENCES `tbl_dep` (`id_dep`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_arsip_akses`
INSERT INTO `tbl_arsip_akses` VALUES ('44', '77', '9');
INSERT INTO `tbl_arsip_akses` VALUES ('45', '77', '10');


-- Struktur tabel `tbl_audit_trail`
DROP TABLE IF EXISTS `tbl_audit_trail`;
CREATE TABLE `tbl_audit_trail` (
  `id_audit` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_audit`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tbl_audit_trail_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_audit_trail`
INSERT INTO `tbl_audit_trail` VALUES ('3', NULL, NULL, 'Tambah User', 'User baru ditambahkan: tes2_qc', NULL, NULL, '2025-09-23 08:36:45');
INSERT INTO `tbl_audit_trail` VALUES ('4', NULL, NULL, 'Tambah User', 'User baru ditambahkan: tes3_qc', NULL, NULL, '2025-09-23 08:38:56');
INSERT INTO `tbl_audit_trail` VALUES ('5', NULL, NULL, 'Hapus User', 'User dihapus: tes3_qc', NULL, NULL, '2025-09-23 09:18:32');
INSERT INTO `tbl_audit_trail` VALUES ('6', NULL, NULL, 'Tambah User', 'User baru ditambahkan: tes3_rnd', NULL, NULL, '2025-09-23 09:26:38');
INSERT INTO `tbl_audit_trail` VALUES ('7', NULL, NULL, 'Hapus User', 'User dihapus: tes3_rnd', NULL, NULL, '2025-09-23 09:27:28');
INSERT INTO `tbl_audit_trail` VALUES ('8', '18', 'administrator', 'Update User', 'User diperbarui: dini_qa', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 09:46:40');
INSERT INTO `tbl_audit_trail` VALUES ('9', '18', 'administrator', 'Hapus User', 'User dihapus: tes2_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 09:46:50');
INSERT INTO `tbl_audit_trail` VALUES ('10', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 09:58:05');
INSERT INTO `tbl_audit_trail` VALUES ('11', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 09:58:49');
INSERT INTO `tbl_audit_trail` VALUES ('12', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: hth.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 10:10:24');
INSERT INTO `tbl_audit_trail` VALUES ('13', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dadas.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 10:19:41');
INSERT INTO `tbl_audit_trail` VALUES ('14', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: dadas.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 10:20:22');
INSERT INTO `tbl_audit_trail` VALUES ('15', '18', 'administrator', 'Hapus User', 'User dihapus: tes_qc', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 10:23:05');
INSERT INTO `tbl_audit_trail` VALUES ('16', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: hth.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 10:26:15');
INSERT INTO `tbl_audit_trail` VALUES ('22', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: teswwwww.jpg', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 14:32:12');
INSERT INTO `tbl_audit_trail` VALUES ('23', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: teswwwww.jpg', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 14:33:10');
INSERT INTO `tbl_audit_trail` VALUES ('24', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: aaaaaa.docx', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 14:43:01');
INSERT INTO `tbl_audit_trail` VALUES ('25', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: aaaaaa.docx', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 15:10:19');
INSERT INTO `tbl_audit_trail` VALUES ('26', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: teswwwww.jpg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 15:10:30');
INSERT INTO `tbl_audit_trail` VALUES ('27', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: aaaaaa.docx', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 15:13:42');
INSERT INTO `tbl_audit_trail` VALUES ('28', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: aaaaaa.docx', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:14:13');
INSERT INTO `tbl_audit_trail` VALUES ('29', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: aaaaaa.docx', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:14:28');
INSERT INTO `tbl_audit_trail` VALUES ('30', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: teswwwww.jpg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:14:34');
INSERT INTO `tbl_audit_trail` VALUES ('31', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: aaaaaa.docx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 15:14:34');
INSERT INTO `tbl_audit_trail` VALUES ('32', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: tes12222.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:15:00');
INSERT INTO `tbl_audit_trail` VALUES ('33', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: tes12.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:15:03');
INSERT INTO `tbl_audit_trail` VALUES ('34', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: tes4_.jpg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:15:06');
INSERT INTO `tbl_audit_trail` VALUES ('35', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: tes_update_1758253819.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-23 15:15:09');
INSERT INTO `tbl_audit_trail` VALUES ('36', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: teswwwww.jpg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-23 15:16:36');
INSERT INTO `tbl_audit_trail` VALUES ('37', '18', 'administrator', 'Download Arsip', 'File diakses/didownload: tes_update_1758253819.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-24 08:10:47');
INSERT INTO `tbl_audit_trail` VALUES ('38', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: edasd.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-24 09:25:58');
INSERT INTO `tbl_audit_trail` VALUES ('43', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: afhsdhfsdf.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 09:31:10');
INSERT INTO `tbl_audit_trail` VALUES ('44', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 09:57:21');
INSERT INTO `tbl_audit_trail` VALUES ('45', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apaaa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 09:59:55');
INSERT INTO `tbl_audit_trail` VALUES ('46', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apaaa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:00:44');
INSERT INTO `tbl_audit_trail` VALUES ('47', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:00:49');
INSERT INTO `tbl_audit_trail` VALUES ('48', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:01:08');
INSERT INTO `tbl_audit_trail` VALUES ('49', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:03:12');
INSERT INTO `tbl_audit_trail` VALUES ('50', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:03:27');
INSERT INTO `tbl_audit_trail` VALUES ('51', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:03:34');
INSERT INTO `tbl_audit_trail` VALUES ('52', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:13:25');
INSERT INTO `tbl_audit_trail` VALUES ('53', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:13:33');
INSERT INTO `tbl_audit_trail` VALUES ('54', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:16:32');
INSERT INTO `tbl_audit_trail` VALUES ('55', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:26:15');
INSERT INTO `tbl_audit_trail` VALUES ('56', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:26:27');
INSERT INTO `tbl_audit_trail` VALUES ('57', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:30:04');
INSERT INTO `tbl_audit_trail` VALUES ('58', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:30:20');
INSERT INTO `tbl_audit_trail` VALUES ('59', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:30:29');
INSERT INTO `tbl_audit_trail` VALUES ('60', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:31:24');
INSERT INTO `tbl_audit_trail` VALUES ('61', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: apa.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:37:14');
INSERT INTO `tbl_audit_trail` VALUES ('62', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: apa_itu.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:37:50');
INSERT INTO `tbl_audit_trail` VALUES ('63', '18', 'administrator', 'Update Arsip', 'File arsip diperbarui: pkop_1758772053.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:47:33');
INSERT INTO `tbl_audit_trail` VALUES ('64', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: npwp.pdf', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 10:58:58');
INSERT INTO `tbl_audit_trail` VALUES ('65', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: tes', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-25 15:34:55');
INSERT INTO `tbl_audit_trail` VALUES ('66', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: KEU', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 15:35:26');
INSERT INTO `tbl_audit_trail` VALUES ('67', '18', 'administrator', 'Hapus Departemen', 'Departemen dihapus: tes', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-25 15:35:32');
INSERT INTO `tbl_audit_trail` VALUES ('68', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: ters.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-25 15:51:33');
INSERT INTO `tbl_audit_trail` VALUES ('69', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: tes_rnd', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-25 16:05:36');
INSERT INTO `tbl_audit_trail` VALUES ('73', '18', 'administrator', 'Hapus User', 'User dihapus: teszz_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:45:26');
INSERT INTO `tbl_audit_trail` VALUES ('74', '18', 'administrator', 'Update User', 'User diperbarui: dwiky_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:45:36');
INSERT INTO `tbl_audit_trail` VALUES ('75', '18', 'administrator', 'Update User', 'User diperbarui: dwiky_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:45:45');
INSERT INTO `tbl_audit_trail` VALUES ('76', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: hanin_rnd', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:46:57');
INSERT INTO `tbl_audit_trail` VALUES ('77', '18', 'administrator', 'Update User', 'User diperbarui: hanin_rnd', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:47:12');
INSERT INTO `tbl_audit_trail` VALUES ('78', '18', 'administrator', 'Hapus User', 'User dihapus: hanin_rnd', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:48:15');
INSERT INTO `tbl_audit_trail` VALUES ('79', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: hanin_rnd', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:48:24');
INSERT INTO `tbl_audit_trail` VALUES ('80', '28', 'hanin_rnd', 'Upload Arsip', 'Arsip diupload: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 08:50:08');
INSERT INTO `tbl_audit_trail` VALUES ('81', '28', 'hanin_rnd', 'Hapus Arsip', 'Arsip dihapus: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 09:49:18');
INSERT INTO `tbl_audit_trail` VALUES ('82', '28', 'hanin_rnd', 'Upload Arsip', 'Arsip diupload: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 09:49:29');
INSERT INTO `tbl_audit_trail` VALUES ('83', '28', 'hanin_rnd', 'Upload Arsip', 'Arsip diupload: tes2.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 09:56:51');
INSERT INTO `tbl_audit_trail` VALUES ('84', '28', 'hanin_rnd', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 47', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 13:32:48');
INSERT INTO `tbl_audit_trail` VALUES ('85', '28', 'hanin_rnd', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 47', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-26 13:32:52');
INSERT INTO `tbl_audit_trail` VALUES ('86', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 47', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 14:10:20');
INSERT INTO `tbl_audit_trail` VALUES ('87', '18', 'administrator', 'Edit Departemen', 'Departemen diupdate: REG (ID: 11)', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-26 15:05:21');
INSERT INTO `tbl_audit_trail` VALUES ('92', '18', 'administrator', 'Update User', 'User diperbarui: dahniar_p3', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-27 09:09:58');
INSERT INTO `tbl_audit_trail` VALUES ('93', '29', 'tes_qc', 'Update Profile', 'User memperbarui profilnya sendiri: tes_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-27 10:37:59');
INSERT INTO `tbl_audit_trail` VALUES ('94', '29', 'test', 'Update Profile', 'User memperbarui profilnya sendiri: test', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-27 11:05:16');
INSERT INTO `tbl_audit_trail` VALUES ('98', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: ID 40', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-27 12:54:05');
INSERT INTO `tbl_audit_trail` VALUES ('100', '18', 'administrator', 'Update User', 'User diperbarui: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 09:03:02');
INSERT INTO `tbl_audit_trail` VALUES ('101', '18', 'administrator', 'Hapus User', 'User dihapus: dahniar_p3', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 09:07:04');
INSERT INTO `tbl_audit_trail` VALUES ('102', '18', 'administrator', 'Hapus User', 'User dihapus: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 09:07:06');
INSERT INTO `tbl_audit_trail` VALUES ('103', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 09:19:30');
INSERT INTO `tbl_audit_trail` VALUES ('108', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: ID 40', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 09:35:31');
INSERT INTO `tbl_audit_trail` VALUES ('109', '18', 'administrator', 'Update User', 'User diperbarui: ayyu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:04:59');
INSERT INTO `tbl_audit_trail` VALUES ('110', '18', 'administrator', 'Hapus User', 'User dihapus: ayyu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:05:36');
INSERT INTO `tbl_audit_trail` VALUES ('111', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:05:47');
INSERT INTO `tbl_audit_trail` VALUES ('113', '18', 'administrator_qc', 'Update Profile', 'User memperbarui profilnya sendiri: administrator_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:18:28');
INSERT INTO `tbl_audit_trail` VALUES ('115', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dwa.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 10:26:59');
INSERT INTO `tbl_audit_trail` VALUES ('116', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: aaaaaaafwe.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 10:28:17');
INSERT INTO `tbl_audit_trail` VALUES ('117', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dwefr.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 10:31:19');
INSERT INTO `tbl_audit_trail` VALUES ('118', '18', 'administrator', 'Update User', 'User diperbarui: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:31:54');
INSERT INTO `tbl_audit_trail` VALUES ('119', '18', 'administrator', 'Update User', 'User diperbarui: ayu', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:31:59');
INSERT INTO `tbl_audit_trail` VALUES ('120', '18', 'administrator', 'Hapus User', 'User dihapus: ayu', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:32:03');
INSERT INTO `tbl_audit_trail` VALUES ('121', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:32:38');
INSERT INTO `tbl_audit_trail` VALUES ('122', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: deefw.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 10:33:24');
INSERT INTO `tbl_audit_trail` VALUES ('123', '18', 'administrator', 'Update User', 'User diperbarui: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:35:54');
INSERT INTO `tbl_audit_trail` VALUES ('124', '18', 'administrator', 'Update User', 'User diperbarui: dini_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:49:04');
INSERT INTO `tbl_audit_trail` VALUES ('125', '18', 'administrator', 'Update User', 'User diperbarui: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:49:24');
INSERT INTO `tbl_audit_trail` VALUES ('126', '18', 'administrator', 'Hapus User', 'User dihapus: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:49:28');
INSERT INTO `tbl_audit_trail` VALUES ('127', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: SEFA', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:49:44');
INSERT INTO `tbl_audit_trail` VALUES ('128', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 10:57:54');
INSERT INTO `tbl_audit_trail` VALUES ('129', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: tes1 (Departemen: 0)', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 11:13:11');
INSERT INTO `tbl_audit_trail` VALUES ('130', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: tes2 (Departemen: 0)', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 11:13:24');
INSERT INTO `tbl_audit_trail` VALUES ('131', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: gheh (Departemen: 9)', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:15:51');
INSERT INTO `tbl_audit_trail` VALUES ('132', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: ht6i7 (Departemen: 10)', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:15:59');
INSERT INTO `tbl_audit_trail` VALUES ('133', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: hendra (Departemen: 25)', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:16:24');
INSERT INTO `tbl_audit_trail` VALUES ('134', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: tes3 (Departemen: 10)', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 11:16:27');
INSERT INTO `tbl_audit_trail` VALUES ('135', '18', 'administrator', 'Tambah Kategori', 'Kategori baru ditambahkan: Penagihan (Departemen: 9)', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:47:13');
INSERT INTO `tbl_audit_trail` VALUES ('136', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: nike_qc', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:48:05');
INSERT INTO `tbl_audit_trail` VALUES ('137', '18', 'administrator', 'Hapus User', 'User dihapus: nike_qc', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 11:48:14');
INSERT INTO `tbl_audit_trail` VALUES ('138', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: fwe.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 13:10:41');
INSERT INTO `tbl_audit_trail` VALUES ('140', '18', 'administrator', 'Hapus User', 'User dihapus: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 13:29:43');
INSERT INTO `tbl_audit_trail` VALUES ('143', '18', 'administrator', 'Hapus User', 'User dihapus: dini_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 13:36:51');
INSERT INTO `tbl_audit_trail` VALUES ('144', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: ayu_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 14:12:05');
INSERT INTO `tbl_audit_trail` VALUES ('145', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dewd.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 14:44:39');
INSERT INTO `tbl_audit_trail` VALUES ('146', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dweq.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 14:45:24');
INSERT INTO `tbl_audit_trail` VALUES ('147', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: das.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 14:47:16');
INSERT INTO `tbl_audit_trail` VALUES ('148', '18', 'administrator', 'Update User', 'User diperbarui: dwiky_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 14:48:27');
INSERT INTO `tbl_audit_trail` VALUES ('150', '18', 'administrator', 'Hapus User', 'User dihapus: dwiky_qa', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 14:53:28');
INSERT INTO `tbl_audit_trail` VALUES ('151', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: geghy.jpg', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 14:58:08');
INSERT INTO `tbl_audit_trail` VALUES ('152', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: tes22.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:22:45');
INSERT INTO `tbl_audit_trail` VALUES ('153', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:22:48');
INSERT INTO `tbl_audit_trail` VALUES ('154', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:22:50');
INSERT INTO `tbl_audit_trail` VALUES ('155', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: dwv.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 15:23:24');
INSERT INTO `tbl_audit_trail` VALUES ('156', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: 1111_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:23:48');
INSERT INTO `tbl_audit_trail` VALUES ('157', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 60', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 15:23:53');
INSERT INTO `tbl_audit_trail` VALUES ('158', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 60', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 15:24:16');
INSERT INTO `tbl_audit_trail` VALUES ('160', '18', 'administrator', 'Hapus User', 'User dihapus: 1111_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:25:00');
INSERT INTO `tbl_audit_trail` VALUES ('161', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: fefs.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 15:26:53');
INSERT INTO `tbl_audit_trail` VALUES ('162', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: 333_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:27:52');
INSERT INTO `tbl_audit_trail` VALUES ('164', '18', 'administrator', 'Hapus User', 'User dihapus: 333_qc', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:47:52');
INSERT INTO `tbl_audit_trail` VALUES ('165', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: 123.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:53:47');
INSERT INTO `tbl_audit_trail` VALUES ('166', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: fefs.png', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:53:53');
INSERT INTO `tbl_audit_trail` VALUES ('167', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: fsfsafr.jpg', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-29 15:56:13');
INSERT INTO `tbl_audit_trail` VALUES ('168', '35', 'ayu_qc', 'Upload Arsip', 'Arsip diupload: 123.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-29 15:58:54');
INSERT INTO `tbl_audit_trail` VALUES ('169', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: klasifikasi.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:01:29');
INSERT INTO `tbl_audit_trail` VALUES ('170', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: ewffaddfd.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:12:25');
INSERT INTO `tbl_audit_trail` VALUES ('171', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: 4gvasgf.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:15:34');
INSERT INTO `tbl_audit_trail` VALUES ('172', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: 4gvasgf.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:19:03');
INSERT INTO `tbl_audit_trail` VALUES ('173', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: ewffaddfd.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:19:05');
INSERT INTO `tbl_audit_trail` VALUES ('174', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: klasifikasi.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:19:07');
INSERT INTO `tbl_audit_trail` VALUES ('175', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: 123.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:19:09');
INSERT INTO `tbl_audit_trail` VALUES ('176', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: fsfsafr.jpg', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:19:11');
INSERT INTO `tbl_audit_trail` VALUES ('177', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: 123123.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:03');
INSERT INTO `tbl_audit_trail` VALUES ('178', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: dwv.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:06');
INSERT INTO `tbl_audit_trail` VALUES ('179', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: geghy.jpg', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:08');
INSERT INTO `tbl_audit_trail` VALUES ('180', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: das.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:10');
INSERT INTO `tbl_audit_trail` VALUES ('181', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: dweq.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:12');
INSERT INTO `tbl_audit_trail` VALUES ('182', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: dewd.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:14');
INSERT INTO `tbl_audit_trail` VALUES ('183', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: fwe.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:16');
INSERT INTO `tbl_audit_trail` VALUES ('184', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes1.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:27:47');
INSERT INTO `tbl_audit_trail` VALUES ('185', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes2.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:28:18');
INSERT INTO `tbl_audit_trail` VALUES ('186', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes3.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:28:39');
INSERT INTO `tbl_audit_trail` VALUES ('187', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes4.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 09:41:16');
INSERT INTO `tbl_audit_trail` VALUES ('188', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 72', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-30 10:29:41');
INSERT INTO `tbl_audit_trail` VALUES ('189', '35', 'ayu_qc', 'Upload Arsip', 'Arsip diupload: tes.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', '2025-09-30 11:35:20');
INSERT INTO `tbl_audit_trail` VALUES ('190', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: screenshot_2025-09-12_133314_0d29e1.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:56:36');
INSERT INTO `tbl_audit_trail` VALUES ('191', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: screenshot_2025-09-12_134256_a14764.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:56:36');
INSERT INTO `tbl_audit_trail` VALUES ('192', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: screenshot_2025-09-12_140619_29b442.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:56:36');
INSERT INTO `tbl_audit_trail` VALUES ('193', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: screenshot_2025-09-12_133314_0d29e1.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:59:39');
INSERT INTO `tbl_audit_trail` VALUES ('194', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:59:39');
INSERT INTO `tbl_audit_trail` VALUES ('195', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes2.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:59:45');
INSERT INTO `tbl_audit_trail` VALUES ('196', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes1.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 13:59:45');
INSERT INTO `tbl_audit_trail` VALUES ('197', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 76', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 14:08:01');
INSERT INTO `tbl_audit_trail` VALUES ('198', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes3.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-08 15:45:46');
INSERT INTO `tbl_audit_trail` VALUES ('199', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: screenshot_2025-09-16_151416_6eb649.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-09 09:22:15');
INSERT INTO `tbl_audit_trail` VALUES ('200', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: screenshot_2025-09-17_094151_9c86f1.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-09 09:22:15');
INSERT INTO `tbl_audit_trail` VALUES ('201', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: putri_p3', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-09 11:12:16');
INSERT INTO `tbl_audit_trail` VALUES ('202', '38', 'putri_p3', 'Tambah Kategori', 'Kategori baru ditambahkan: Penjualan (Departemen: 23)', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-09 11:15:33');
INSERT INTO `tbl_audit_trail` VALUES ('203', '12', 'hendra_p3', 'Upload Arsip', 'Arsip diupload: whatsapp_image_2025-09-04_at_102148_d9b359.jpeg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-09 11:17:34');
INSERT INTO `tbl_audit_trail` VALUES ('204', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes4.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-09 13:19:45');
INSERT INTO `tbl_audit_trail` VALUES ('205', '18', 'administrator', 'Hapus Arsip', 'Arsip dihapus: screenshot_2025-09-12_134256_a14764.png', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-09 14:10:02');


-- Struktur tabel `tbl_dep`
DROP TABLE IF EXISTS `tbl_dep`;
CREATE TABLE `tbl_dep` (
  `id_dep` int(11) NOT NULL AUTO_INCREMENT,
  `nama_dep` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_dep`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_dep`
INSERT INTO `tbl_dep` VALUES ('9', 'QC');
INSERT INTO `tbl_dep` VALUES ('10', 'RND');
INSERT INTO `tbl_dep` VALUES ('11', 'REG');
INSERT INTO `tbl_dep` VALUES ('12', 'NBL');
INSERT INTO `tbl_dep` VALUES ('13', 'BETA');
INSERT INTO `tbl_dep` VALUES ('18', 'PKRT');
INSERT INTO `tbl_dep` VALUES ('20', 'QA');
INSERT INTO `tbl_dep` VALUES ('23', 'P3');
INSERT INTO `tbl_dep` VALUES ('25', 'KEU');
INSERT INTO `tbl_dep` VALUES ('26', 'SEFA');


-- Struktur tabel `tbl_kategori`
DROP TABLE IF EXISTS `tbl_kategori`;
CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `id_dep` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `nama_kategori` (`nama_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_kategori`
INSERT INTO `tbl_kategori` VALUES ('22', '0', 'TES');
INSERT INTO `tbl_kategori` VALUES ('23', '0', 'TESA');
INSERT INTO `tbl_kategori` VALUES ('27', '9', 'tes111');
INSERT INTO `tbl_kategori` VALUES ('28', '9', '123123');
INSERT INTO `tbl_kategori` VALUES ('29', '9', 'tttes');
INSERT INTO `tbl_kategori` VALUES ('30', '9', 'tte');
INSERT INTO `tbl_kategori` VALUES ('31', '9', '3333');
INSERT INTO `tbl_kategori` VALUES ('32', '10', 'ts');
INSERT INTO `tbl_kategori` VALUES ('33', '0', 'tes1');
INSERT INTO `tbl_kategori` VALUES ('34', '0', 'tes2');
INSERT INTO `tbl_kategori` VALUES ('35', '9', 'gheh');
INSERT INTO `tbl_kategori` VALUES ('36', '10', 'ht6i7');
INSERT INTO `tbl_kategori` VALUES ('37', '25', 'hendra');
INSERT INTO `tbl_kategori` VALUES ('38', '10', 'tes3');
INSERT INTO `tbl_kategori` VALUES ('39', '9', 'Penagihan');
INSERT INTO `tbl_kategori` VALUES ('40', '20', 'tesqa');
INSERT INTO `tbl_kategori` VALUES ('41', '23', 'Penjualan');


-- Struktur tabel `tbl_user`
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` int(1) DEFAULT NULL,
  `id_dep` int(11) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_user`
INSERT INTO `tbl_user` VALUES ('12', 'hendra', '$2y$10$q/TuQZnA5xSIDLgrQCIPcOzlmgPXsz.IMVEIM8KW4H.I5PpwQXVky', '2', '23', 'hendra_p3');
INSERT INTO `tbl_user` VALUES ('18', 'administrator', '$2y$10$joJ73kor1Rj8xQ3zlTujBerDvIAmDX2jkp93vDuGCVt7Irat2TpM.', '0', '0', 'administrator');
INSERT INTO `tbl_user` VALUES ('28', 'hanin', '$2y$10$Ot1oWKIIMPtqxYWAtFPoBuGDznVoUK0GEwKO9nW3CfoLmhrOouXc2', '1', '10', 'hanin_rnd');
INSERT INTO `tbl_user` VALUES ('29', 'test', '$2y$10$Kq427RLbbE6xqtI5mlM5lOpui/7/NPGLN3EdsqMRm836KBSzBcURO', '2', '9', 'test_qc');
INSERT INTO `tbl_user` VALUES ('35', 'ayu', '$2y$10$lkCtnIeysbBJwW2c6AbxDOcBlQNHM.aIvkfEu8iZyp.KGkI9bE9LG', '1', '9', 'ayu_qc');
INSERT INTO `tbl_user` VALUES ('38', 'Putri', '$2y$10$ZtEJB3UnTR1UDQjR0LoVCOK1aJJXHrDQ7cHSXV5lHN1/NOCmx5LZq', '1', '23', 'putri_p3');


SET FOREIGN_KEY_CHECKS = 1;