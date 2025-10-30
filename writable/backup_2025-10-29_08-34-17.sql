SET FOREIGN_KEY_CHECKS = 0;

-- Struktur tabel `pesan_bantuan`
DROP TABLE IF EXISTS `pesan_bantuan`;
CREATE TABLE `pesan_bantuan` (
  `id_pesan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca') DEFAULT 'baru',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pesan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `pesan_bantuan`
INSERT INTO `pesan_bantuan` VALUES ('15', '18', '42', 'halo', 'dibaca', '2025-10-29 15:06:24');


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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_arsip`
INSERT INTO `tbl_arsip` VALUES ('163', '86', '', '2025-10-29 15:00:55', '2025-10-29', '28042025_f402bb_56536c_881c4f_5d97a7.xlsx', 'uploads/keu/surat_keluar/', '27', '42', 'dwiky', 'umum', '93509');


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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=418 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data untuk tabel `tbl_user`
INSERT INTO `tbl_user` VALUES ('18', 'administrator', '$2y$10$joJ73kor1Rj8xQ3zlTujBerDvIAmDX2jkp93vDuGCVt7Irat2TpM.', '0', '0', 'administrator');
INSERT INTO `tbl_user` VALUES ('42', 'dwiky', '$2y$10$XQXI4brVAqQNDjnKnts1YO5ZJezrciN9XbrDZ15Ql6I219LWj2G/W', '1', '27', 'dwiky_keu');
INSERT INTO `tbl_user` VALUES ('43', 'dahniar', '$2y$10$0jyYvg1DEDnNhM9HAtMqmOz78jAgVxcZ7kzE2JpYAOLvAsFaN0H8W', '2', '27', 'dahniar_keu');


SET FOREIGN_KEY_CHECKS = 1;