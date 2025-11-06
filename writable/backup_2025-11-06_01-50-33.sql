SET FOREIGN_KEY_CHECKS = 0;

-- Struktur tabel `pesan_bantuan`
DROP TABLE IF EXISTS `pesan_bantuan`;
CREATE TABLE `pesan_bantuan` (
  `id_pesan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `subjek` varchar(255) DEFAULT NULL,
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca') DEFAULT 'baru',
  `created_at` datetime DEFAULT current_timestamp(),
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pesan`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `pesan_bantuan`
INSERT INTO `pesan_bantuan` VALUES ('15', '18', '42', NULL, 'halo', 'dibaca', '2025-10-29 15:06:24', '0');
INSERT INTO `pesan_bantuan` VALUES ('16', '43', '18', NULL, 'sqwdqwd\r\n', 'baru', '2025-10-30 15:12:21', '0');
INSERT INTO `pesan_bantuan` VALUES ('17', '42', '18', NULL, 'ada masalah', 'dibaca', '2025-11-01 11:15:49', '0');
INSERT INTO `pesan_bantuan` VALUES ('18', '42', NULL, NULL, 'coba', 'baru', '2025-11-01 12:37:06', '0');
INSERT INTO `pesan_bantuan` VALUES ('19', '42', NULL, 'Percakapan Umum', 'coba', 'baru', '2025-11-01 12:40:31', '0');
INSERT INTO `pesan_bantuan` VALUES ('20', '18', NULL, 'Percakapan Umum', 'edwfdef', 'baru', '2025-11-01 12:41:29', '0');
INSERT INTO `pesan_bantuan` VALUES ('21', '42', NULL, 'Percakapan Umum', 'pesan masuk', 'baru', '2025-11-03 11:07:55', '0');
INSERT INTO `pesan_bantuan` VALUES ('22', '42', '18', 'input user', 'ada kendala di input user', 'dibaca', '2025-11-03 04:38:02', '0');
INSERT INTO `pesan_bantuan` VALUES ('23', '42', '18', 'input user', 'ada kendala di input user', 'dibaca', '2025-11-03 07:20:54', '0');
INSERT INTO `pesan_bantuan` VALUES ('24', '42', '18', 'input', 'ada', 'dibaca', '2025-11-03 07:52:19', '0');
INSERT INTO `pesan_bantuan` VALUES ('25', '18', '42', 'Percakapan Umum', 'tesssssssssssssssssssss', 'dibaca', '2025-11-05 05:00:37', '0');
INSERT INTO `pesan_bantuan` VALUES ('26', '42', '18', 'Percakapan Umum', 'ad', 'baru', '2025-11-05 06:20:05', '0');
INSERT INTO `pesan_bantuan` VALUES ('27', '42', '18', 'Percakapan Umum', 'ya', 'baru', '2025-11-05 06:31:46', '0');
INSERT INTO `pesan_bantuan` VALUES ('28', '42', '18', 'Percakapan Umum', 'ok', 'baru', '2025-11-05 06:31:58', '0');
INSERT INTO `pesan_bantuan` VALUES ('29', '42', '18', 'Percakapan Umum', 'halo', 'baru', '2025-11-05 06:54:37', '0');
INSERT INTO `pesan_bantuan` VALUES ('30', '18', '42', 'Percakapan Umum', 'ya', 'baru', '2025-11-05 06:54:48', '0');
INSERT INTO `pesan_bantuan` VALUES ('31', '18', '42', 'Percakapan Umum', 'halo', 'baru', '2025-11-05 06:59:27', '0');
INSERT INTO `pesan_bantuan` VALUES ('32', '18', '42', 'Percakapan Umum', 'yuhu', 'baru', '2025-11-05 06:59:44', '0');
INSERT INTO `pesan_bantuan` VALUES ('33', '42', '18', 'Percakapan Umum', 'ya', 'baru', '2025-11-05 07:01:58', '0');
INSERT INTO `pesan_bantuan` VALUES ('34', '18', '42', 'Percakapan Umum', 'ok', 'baru', '2025-11-05 07:03:24', '0');
INSERT INTO `pesan_bantuan` VALUES ('35', '18', '42', 'Percakapan Umum', 'ada', 'baru', '2025-11-05 07:05:05', '0');
INSERT INTO `pesan_bantuan` VALUES ('36', '18', '42', 'Percakapan Umum', 'apa', 'baru', '2025-11-05 07:10:32', '0');
INSERT INTO `pesan_bantuan` VALUES ('37', '42', '18', 'Percakapan Umum', 'yaa', 'baru', '2025-11-05 07:12:07', '0');
INSERT INTO `pesan_bantuan` VALUES ('38', '42', '18', 'Percakapan Umum', 'ok', 'baru', '2025-11-05 07:23:38', '0');
INSERT INTO `pesan_bantuan` VALUES ('39', '42', '18', 'Percakapan Umum', 'ada', 'baru', '2025-11-05 07:35:57', '0');
INSERT INTO `pesan_bantuan` VALUES ('40', '18', '42', 'Percakapan Umum', 'ya', 'baru', '2025-11-05 07:37:40', '0');
INSERT INTO `pesan_bantuan` VALUES ('41', '18', '42', 'Percakapan Umum', 'tes', 'baru', '2025-11-05 07:39:25', '0');
INSERT INTO `pesan_bantuan` VALUES ('42', '42', '18', 'Percakapan Umum', 'kenapa ya ', 'baru', '2025-11-05 07:39:48', '0');
INSERT INTO `pesan_bantuan` VALUES ('43', '18', '42', 'Percakapan Umum', 'berhasil', 'baru', '2025-11-05 07:42:00', '0');
INSERT INTO `pesan_bantuan` VALUES ('44', '43', '18', 'default', 'kop', 'baru', '2025-11-05 09:13:51', '0');


-- Struktur tabel `tbl_arsip`
DROP TABLE IF EXISTS `tbl_arsip`;
CREATE TABLE `tbl_arsip` (
  `id_arsip` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_upload` datetime DEFAULT current_timestamp(),
  `tgl_update` date DEFAULT NULL,
  `file_arsip` varchar(255) DEFAULT NULL,
  `path_arsip` varchar(255) NOT NULL,
  `id_dep` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_user_upload` varchar(255) DEFAULT NULL,
  `klasifikasi` enum('rahasia','terbatas','umum') DEFAULT 'umum',
  `ukuran_arsip` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_arsip`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_arsip`
INSERT INTO `tbl_arsip` VALUES ('179', '86', '', '2025-11-05 11:19:18', NULL, 'surat.pdf', 'uploads/keu/surat_keluar/', '27', '18', 'administrator', 'umum', '136568');
INSERT INTO `tbl_arsip` VALUES ('180', '86', 'dwd', '2025-11-05 13:23:08', NULL, 'wdd_081b2d.docx', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'terbatas', '17128');
INSERT INTO `tbl_arsip` VALUES ('181', '86', 'dw', '2025-11-05 13:23:08', NULL, 'few_b378a8.xlsx', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'umum', '18111');
INSERT INTO `tbl_arsip` VALUES ('182', '86', 'fewf', '2025-11-05 13:55:16', NULL, 'grg_349100.pdf', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'umum', '1254679');
INSERT INTO `tbl_arsip` VALUES ('183', '86', 'gver', '2025-11-05 13:55:16', NULL, 'ervb_2d64c7.pdf', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'terbatas', '463534');
INSERT INTO `tbl_arsip` VALUES ('184', '86', '', '2025-11-05 14:07:05', NULL, 'rasa_a7fbc4.png', 'uploads/keu/surat_keluar/', '27', '43', 'dahniar', 'terbatas', '708003');
INSERT INTO `tbl_arsip` VALUES ('185', '86', 'DW', '2025-11-05 14:23:55', NULL, 'email_53cb64.htm', 'uploads/keu/surat_keluar/', '27', '43', 'dahniar', 'umum', '409081');
INSERT INTO `tbl_arsip` VALUES ('186', '86', 'rb', '2025-11-05 14:26:54', NULL, 'fwe_722374.jpeg', 'uploads/keu/surat_keluar/', '27', '43', 'dahniar', 'umum', '75442');
INSERT INTO `tbl_arsip` VALUES ('187', '86', '', '2025-11-05 14:46:07', NULL, 'ok_0d90cc.jpeg', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'umum', '136675');
INSERT INTO `tbl_arsip` VALUES ('188', '86', '', '2025-11-05 14:46:07', NULL, 'whatsapp_image_2025-11-04_at_141841_00da07.jpeg', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'umum', '86126');
INSERT INTO `tbl_arsip` VALUES ('189', '86', '', '2025-11-05 15:16:05', NULL, 'TTC-2505-000051_archive_1d91e5.pdf', 'uploads/keu/surat_keluar/', '27', '18', 'administrator', 'umum', '17128');


-- Struktur tabel `tbl_arsip_akses`
DROP TABLE IF EXISTS `tbl_arsip_akses`;
CREATE TABLE `tbl_arsip_akses` (
  `id_akses` int(11) NOT NULL AUTO_INCREMENT,
  `id_arsip` int(11) DEFAULT NULL,
  `id_dep` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tipe_akses` enum('departemen','user') NOT NULL,
  PRIMARY KEY (`id_akses`),
  KEY `id_arsip` (`id_arsip`),
  KEY `id_dep` (`id_dep`),
  CONSTRAINT `tbl_arsip_akses_ibfk_1` FOREIGN KEY (`id_arsip`) REFERENCES `tbl_arsip` (`id_arsip`) ON DELETE CASCADE,
  CONSTRAINT `tbl_arsip_akses_ibfk_2` FOREIGN KEY (`id_dep`) REFERENCES `tbl_dep` (`id_dep`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_arsip_akses`
INSERT INTO `tbl_arsip_akses` VALUES ('111', '180', '27', NULL, 'departemen');
INSERT INTO `tbl_arsip_akses` VALUES ('112', '183', '28', NULL, 'departemen');
INSERT INTO `tbl_arsip_akses` VALUES ('113', '183', NULL, '43', 'user');
INSERT INTO `tbl_arsip_akses` VALUES ('114', '184', '27', NULL, 'departemen');
INSERT INTO `tbl_arsip_akses` VALUES ('115', '184', NULL, '42', 'user');


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
) ENGINE=InnoDB AUTO_INCREMENT=467 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_audit_trail`
INSERT INTO `tbl_audit_trail` VALUES ('402', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: KEU', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:18');
INSERT INTO `tbl_audit_trail` VALUES ('403', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: P3', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:22');
INSERT INTO `tbl_audit_trail` VALUES ('404', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: HRD', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:28');
INSERT INTO `tbl_audit_trail` VALUES ('405', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: QC', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:37');
INSERT INTO `tbl_audit_trail` VALUES ('406', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: QA', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:40');
INSERT INTO `tbl_audit_trail` VALUES ('407', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: REGIS', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:45');
INSERT INTO `tbl_audit_trail` VALUES ('408', '18', 'administrator', 'Gagal Tambah Departemen', 'Nama departemen sudah ada: REGIS', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:45');
INSERT INTO `tbl_audit_trail` VALUES ('409', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: RND', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:19:56');
INSERT INTO `tbl_audit_trail` VALUES ('410', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: NBL', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:20:01');
INSERT INTO `tbl_audit_trail` VALUES ('411', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: BETA', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:20:05');
INSERT INTO `tbl_audit_trail` VALUES ('412', '18', 'administrator', 'Tambah Departemen', 'Departemen baru ditambahkan: SEFA', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:20:09');
INSERT INTO `tbl_audit_trail` VALUES ('413', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: dwiky_keu', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 14:20:44');
INSERT INTO `tbl_audit_trail` VALUES ('414', '42', 'dwiky_keu', 'Tambah Kategori', 'Kategori baru: Surat Keluar (Departemen: 27, Parent: )', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 15:00:44');
INSERT INTO `tbl_audit_trail` VALUES ('415', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: 28042025_f402bb_56536c_881c4f_5d97a7.xlsx', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 15:00:55');
INSERT INTO `tbl_audit_trail` VALUES ('416', '42', 'dwiky_keu', 'Tambah User', 'User baru ditambahkan: dahniar_keu', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 15:01:41');
INSERT INTO `tbl_audit_trail` VALUES ('417', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa file baru: ID 163', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-29 15:24:41');
INSERT INTO `tbl_audit_trail` VALUES ('418', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: kebijakan-layanan-it-support-perusahaan_7f75e9_d4ac79_c5d2ba_2_8c2639_7f4e6b.pptx', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 15:39:07');
INSERT INTO `tbl_audit_trail` VALUES ('419', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: modul_training_it_serialisasi_agregasi_2_e30757.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-29 15:39:42');
INSERT INTO `tbl_audit_trail` VALUES ('420', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: print_test_79640e.xlsx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 08:54:22');
INSERT INTO `tbl_audit_trail` VALUES ('421', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: print_test_1e4e1e.xlsx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-30 11:24:53');
INSERT INTO `tbl_audit_trail` VALUES ('422', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: quote_pn_0103_idn_01_2025_da892b.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-30 13:29:42');
INSERT INTO `tbl_audit_trail` VALUES ('423', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: suhendra_9bac89.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-30 15:43:35');
INSERT INTO `tbl_audit_trail` VALUES ('424', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: modul_training_it_serialisasi_agregasi_41d579.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-30 15:45:28');
INSERT INTO `tbl_audit_trail` VALUES ('425', '18', 'administrator', 'Update Arsip', 'File arsip diperbarui: _1761875947.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 08:59:07');
INSERT INTO `tbl_audit_trail` VALUES ('426', '18', 'administrator', 'Update Akses Arsip', 'Akses diperbarui untuk arsip ID 170', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 08:59:08');
INSERT INTO `tbl_audit_trail` VALUES ('427', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa rename atau file baru: ID 169', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 10:04:08');
INSERT INTO `tbl_audit_trail` VALUES ('428', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa rename atau file baru: ID 169', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 10:04:24');
INSERT INTO `tbl_audit_trail` VALUES ('429', '18', 'administrator', 'Update Arsip', 'Data arsip diperbarui tanpa rename atau file baru: ID 169', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 10:09:18');
INSERT INTO `tbl_audit_trail` VALUES ('430', '18', 'administrator', 'Update Arsip', 'File di-rename jadi suhen.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 11:18:09');
INSERT INTO `tbl_audit_trail` VALUES ('431', '18', 'administrator', 'Update Arsip', 'File baru diupload: suhen.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 11:18:54');
INSERT INTO `tbl_audit_trail` VALUES ('432', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: tes_bba89b.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 13:25:07');
INSERT INTO `tbl_audit_trail` VALUES ('433', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: quote_pn_0103_idn_01_2025_780cb8.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-31 15:05:55');
INSERT INTO `tbl_audit_trail` VALUES ('434', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: win_p3', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-11-01 08:35:37');
INSERT INTO `tbl_audit_trail` VALUES ('435', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: aaaaaa_68de330923d09_6240b8.docx', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-11-01 08:36:29');
INSERT INTO `tbl_audit_trail` VALUES ('436', '18', 'administrator', 'Edit Departemen', 'Departemen diupdate: SEFAa (ID: 36)', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-11-01 11:16:52');
INSERT INTO `tbl_audit_trail` VALUES ('437', '18', 'administrator', 'Edit Departemen', 'Departemen diupdate: SEFA (ID: 36)', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-11-01 11:16:55');
INSERT INTO `tbl_audit_trail` VALUES ('438', '42', 'dwiky_keu', 'Update Arsip', 'File di-rename jadi tes_rename.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-03 09:14:04');
INSERT INTO `tbl_audit_trail` VALUES ('439', '18', 'administrator', 'Hapus Arsip Multiple', 'Arsip dihapus: tes_rename.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:20:28');
INSERT INTO `tbl_audit_trail` VALUES ('440', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: ds_fb9cdb.xlsx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:21:36');
INSERT INTO `tbl_audit_trail` VALUES ('441', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: adf_282cd7.xlsx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:21:36');
INSERT INTO `tbl_audit_trail` VALUES ('442', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: winp3_217d15.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:21:36');
INSERT INTO `tbl_audit_trail` VALUES ('443', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: ttc-2505-000051_1d16e2.rtf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:25:51');
INSERT INTO `tbl_audit_trail` VALUES ('444', '18', 'administrator', 'Tambah User', 'User baru ditambahkan: hendra_keu', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-03 14:26:17');
INSERT INTO `tbl_audit_trail` VALUES ('445', '18', 'administrator', 'Update Arsip', 'File di-rename jadi tessss.rtf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 09:48:58');
INSERT INTO `tbl_audit_trail` VALUES ('446', '18', 'administrator', 'Update Akses Arsip', 'Akses diperbarui untuk arsip ID 177', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 09:48:58');
INSERT INTO `tbl_audit_trail` VALUES ('447', '18', 'administrator', 'Update Arsip', 'File di-rename jadi ui.rtf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 09:57:35');
INSERT INTO `tbl_audit_trail` VALUES ('448', '18', 'administrator', 'Update Akses Arsip', 'Akses diperbarui untuk arsip ID 177', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 09:57:35');
INSERT INTO `tbl_audit_trail` VALUES ('449', '18', 'administrator', 'Update Akses Arsip', 'Akses diperbarui untuk arsip ID 177', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 09:59:02');
INSERT INTO `tbl_audit_trail` VALUES ('450', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: suhendra_6b9e70.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 10:26:06');
INSERT INTO `tbl_audit_trail` VALUES ('451', '18', 'administrator', 'Update Arsip', 'File di-rename jadi ssss.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 11:14:34');
INSERT INTO `tbl_audit_trail` VALUES ('452', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: quote_pn_0103_idn_01_2025_773665.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 11:19:18');
INSERT INTO `tbl_audit_trail` VALUES ('453', '18', 'administrator', 'Edit Arsip', 'Arsip diperbarui: quote_pn_0103_idn_01_2025_773665.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 11:20:03');
INSERT INTO `tbl_audit_trail` VALUES ('454', '18', 'administrator', 'Edit Arsip', 'Arsip diperbarui: quote_pn_0103_idn_01_2025_773665.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 11:20:27');
INSERT INTO `tbl_audit_trail` VALUES ('455', '18', 'administrator', 'Edit Arsip', 'Arsip diperbarui: surat.pdf', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-05 11:26:34');
INSERT INTO `tbl_audit_trail` VALUES ('456', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: wdd_081b2d.docx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 13:23:08');
INSERT INTO `tbl_audit_trail` VALUES ('457', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: few_b378a8.xlsx', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 13:23:08');
INSERT INTO `tbl_audit_trail` VALUES ('458', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: grg_349100.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 13:55:16');
INSERT INTO `tbl_audit_trail` VALUES ('459', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: ervb_2d64c7.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 13:55:16');
INSERT INTO `tbl_audit_trail` VALUES ('460', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: rasa_a7fbc4.png', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 14:07:05');
INSERT INTO `tbl_audit_trail` VALUES ('461', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: email_53cb64.htm', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 14:23:55');
INSERT INTO `tbl_audit_trail` VALUES ('462', '43', 'dahniar_keu', 'Upload Arsip', 'Arsip diupload: fwe_722374.jpeg', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-05 14:26:54');
INSERT INTO `tbl_audit_trail` VALUES ('463', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: ok_0d90cc.jpeg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-05 14:46:07');
INSERT INTO `tbl_audit_trail` VALUES ('464', '42', 'dwiky_keu', 'Upload Arsip', 'Arsip diupload: whatsapp_image_2025-11-04_at_141841_00da07.jpeg', '10.10.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-05 14:46:07');
INSERT INTO `tbl_audit_trail` VALUES ('465', '18', 'administrator', 'Upload Arsip', 'Arsip diupload: wdd_081b2d_aea5d4.docx', '10.10.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-05 15:16:05');
INSERT INTO `tbl_audit_trail` VALUES ('466', '18', 'administrator', 'Edit Arsip', 'Arsip diperbarui: TTC-2505-000051_archive_1d91e5.pdf', '10.10.1.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-06 08:37:56');


-- Struktur tabel `tbl_dep`
DROP TABLE IF EXISTS `tbl_dep`;
CREATE TABLE `tbl_dep` (
  `id_dep` int(11) NOT NULL AUTO_INCREMENT,
  `nama_dep` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_dep`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_dep`
INSERT INTO `tbl_dep` VALUES ('27', 'KEU');
INSERT INTO `tbl_dep` VALUES ('28', 'P3');
INSERT INTO `tbl_dep` VALUES ('29', 'HRD');
INSERT INTO `tbl_dep` VALUES ('30', 'QC');
INSERT INTO `tbl_dep` VALUES ('31', 'QA');
INSERT INTO `tbl_dep` VALUES ('32', 'REGIS');
INSERT INTO `tbl_dep` VALUES ('33', 'RND');
INSERT INTO `tbl_dep` VALUES ('34', 'NBL');
INSERT INTO `tbl_dep` VALUES ('35', 'BETA');
INSERT INTO `tbl_dep` VALUES ('36', 'SEFA');


-- Struktur tabel `tbl_kategori`
DROP TABLE IF EXISTS `tbl_kategori`;
CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `id_dep` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `nama_kategori` (`nama_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_kategori`
INSERT INTO `tbl_kategori` VALUES ('86', '27', 'Surat Keluar', NULL);


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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_user`
INSERT INTO `tbl_user` VALUES ('18', 'administrator', '$2y$10$joJ73kor1Rj8xQ3zlTujBerDvIAmDX2jkp93vDuGCVt7Irat2TpM.', '0', '0', 'administrator');
INSERT INTO `tbl_user` VALUES ('42', 'dwiky', '$2y$10$XQXI4brVAqQNDjnKnts1YO5ZJezrciN9XbrDZ15Ql6I219LWj2G/W', '1', '27', 'dwiky_keu');
INSERT INTO `tbl_user` VALUES ('43', 'dahniar', '$2y$10$0jyYvg1DEDnNhM9HAtMqmOz78jAgVxcZ7kzE2JpYAOLvAsFaN0H8W', '2', '27', 'dahniar_keu');
INSERT INTO `tbl_user` VALUES ('44', 'win', '$2y$10$72lPYvGuso3ZAORhbA63t.jwc3mlXQgwaLwcWbQuIakUCwPDYKbQK', '1', '28', 'win_p3');
INSERT INTO `tbl_user` VALUES ('45', 'hendra', '$2y$10$Zjg3TZyg03YdU8M/vmiNueeGL8QCsDUpvBop29mxSFAKO.5w0//X2', '2', '27', 'hendra_keu');


SET FOREIGN_KEY_CHECKS = 1;