# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: thor
# Generation Time: 2021-06-26 02:14:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table jadwal_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jadwal_tesis`;

CREATE TABLE `jadwal_tesis` (
  `id_jadwal_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran_tesis` int(11) NOT NULL,
  `nim` int(50) NOT NULL,
  `id_color` char(11) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `lokasi` varchar(250) DEFAULT NULL,
  `id_pegawai` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `jeda` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table jadwal_ujian
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jadwal_ujian`;

CREATE TABLE `jadwal_ujian` (
  `id_jadwal_ujian` int(11) NOT NULL AUTO_INCREMENT,
  `id_ujian` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `tipe_ujian` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `nama_judul` varchar(255) DEFAULT NULL,
  `id_penguji_1` int(11) NOT NULL,
  `id_penguji_2` int(11) NOT NULL,
  `id_pemb_1` int(11) NOT NULL,
  `id_pemb_2` int(11) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `jam` float NOT NULL,
  `ruang` varchar(100) NOT NULL,
  `ket` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal_ujian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `jadwal_ujian` WRITE;
/*!40000 ALTER TABLE `jadwal_ujian` DISABLE KEYS */;

INSERT INTO `jadwal_ujian` (`id_jadwal_ujian`, `id_ujian`, `id_dosen`, `tipe_ujian`, `id_mahasiswa`, `nama_judul`, `id_penguji_1`, `id_penguji_2`, `id_pemb_1`, `id_pemb_2`, `tgl_mulai`, `tgl_selesai`, `jam`, `ruang`, `ket`)
VALUES
	(4,1,65,2,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-12-05 08:00:00','2020-12-05 10:00:00',0,'Ruang B10',2),
	(5,1,78,2,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-12-05 08:00:00','2020-12-05 10:00:00',0,'Ruang B10',2),
	(6,1,81,2,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-12-05 08:00:00','2020-12-05 10:00:00',0,'Ruang B10',2),
	(13,1,65,1,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-11-30 09:00:00','2020-11-30 10:00:00',0,'Online',2),
	(14,1,76,1,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-11-30 09:00:00','2020-11-30 10:00:00',0,'Online',2),
	(15,1,77,1,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2020-11-30 09:00:00','2020-11-30 10:00:00',0,'Online',2),
	(19,1,65,3,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2021-01-12 10:00:00','2021-01-12 14:00:00',0,'R01, G 2',2),
	(20,1,71,3,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2021-01-12 10:00:00','2021-01-12 14:00:00',0,'R01, G 2',2),
	(21,1,76,3,36,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,0,0,0,'2021-01-12 10:00:00','2021-01-12 14:00:00',0,'R01, G 2',2);

/*!40000 ALTER TABLE `jadwal_ujian` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table log_book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_book`;

CREATE TABLE `log_book` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `op` int(11) DEFAULT NULL,
  `date_act` datetime DEFAULT NULL,
  `action` int(1) DEFAULT NULL,
  `kait` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mhs_pembimbing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_pembimbing`;

CREATE TABLE `mhs_pembimbing` (
  `id_mhs_pembimbing` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` int(11) NOT NULL,
  `id_pengajuan_judul` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_pembimbing` int(11) NOT NULL,
  `id_ref_semester` int(11) NOT NULL,
  `id_periode_pu` int(11) DEFAULT NULL,
  `status_pemb` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_mhs_pembimbing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_pembimbing` WRITE;
/*!40000 ALTER TABLE `mhs_pembimbing` DISABLE KEYS */;

INSERT INTO `mhs_pembimbing` (`id_mhs_pembimbing`, `tipe`, `id_pengajuan_judul`, `id_mahasiswa`, `id_pembimbing`, `id_ref_semester`, `id_periode_pu`, `status_pemb`)
VALUES
	(2,0,1,36,65,7,6,0),
	(4,0,4,34,55,7,7,1),
	(15,2,3,2,55,7,2,1),
	(26,3,4,43,67,7,2,1);

/*!40000 ALTER TABLE `mhs_pembimbing` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mhs_pengajuan_judul
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_pengajuan_judul`;

CREATE TABLE `mhs_pengajuan_judul` (
  `id_mhs_pengajuan_judul` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(200) DEFAULT NULL,
  `id_pengajuan_judul` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_ref_pengajuan_judul` int(11) NOT NULL,
  `berkas` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_mhs_pengajuan_judul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_pengajuan_judul` WRITE;
/*!40000 ALTER TABLE `mhs_pengajuan_judul` DISABLE KEYS */;

INSERT INTO `mhs_pengajuan_judul` (`id_mhs_pengajuan_judul`, `link`, `id_pengajuan_judul`, `id_mahasiswa`, `id_ref_pengajuan_judul`, `berkas`, `status`)
VALUES
	(1,NULL,1,36,6,'Pendaftaran_Ujian_Tesis_1.jpeg',0),
	(3,NULL,1,36,3,'WhatsApp_Image_2020-08-28_at_17_16_33_(3).jpeg',0),
	(4,NULL,1,36,1,'Pendaftaran_Ujian_Tesis_1.jpeg',0),
	(5,NULL,1,36,2,'Pendaftaran_Ujian_Tesis_2.jpeg',0),
	(6,NULL,1,36,7,'SURAT_EDARAN.pdf',0),
	(7,NULL,2,48,7,'SURAT_EDARAN.pdf',0),
	(8,NULL,3,52,7,'SURAT_EDARAN.pdf',0),
	(9,NULL,3,52,3,'bebas_keuangan.pdf',0),
	(10,NULL,2,48,3,'bebas_keuangan.pdf',0),
	(11,NULL,4,34,7,'contoh_upload.pdf',0),
	(12,NULL,4,34,1,'bebas_keuangan.pdf',0),
	(13,NULL,4,34,2,'IDN64764.pdf',0),
	(15,NULL,4,34,1,'bebas_keuangan.pdf',0),
	(16,NULL,4,34,2,'IDN64764.pdf',0),
	(18,NULL,4,34,3,'WhatsApp_Image_2020-08-28_at_17_16_33_(2).jpeg',0);

/*!40000 ALTER TABLE `mhs_pengajuan_judul` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mhs_penguji
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_penguji`;

CREATE TABLE `mhs_penguji` (
  `id_mhs_pembimbing` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_ujian` int(11) NOT NULL,
  `id_pendaftaran_ujian` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_pembimbing` int(11) NOT NULL,
  `id_ref_semester` int(11) NOT NULL,
  `id_periode_pu` int(11) NOT NULL,
  `status_peng` int(1) NOT NULL,
  PRIMARY KEY (`id_mhs_pembimbing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_penguji` WRITE;
/*!40000 ALTER TABLE `mhs_penguji` DISABLE KEYS */;

INSERT INTO `mhs_penguji` (`id_mhs_pembimbing`, `tipe_ujian`, `id_pendaftaran_ujian`, `id_mahasiswa`, `id_pembimbing`, `id_ref_semester`, `id_periode_pu`, `status_peng`)
VALUES
	(37,1,1,36,76,7,6,0),
	(38,1,1,36,77,7,6,0),
	(43,2,1,36,78,7,6,0),
	(44,2,1,36,81,7,6,0),
	(45,3,1,36,71,7,6,0),
	(46,3,1,36,76,7,6,0);

/*!40000 ALTER TABLE `mhs_penguji` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mhs_proposal_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_proposal_tesis`;

CREATE TABLE `mhs_proposal_tesis` (
  `id_mhs_proposal_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(250) DEFAULT NULL,
  `id_proposal_tesis` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_ref_proposal_tesis` int(11) NOT NULL,
  `berkas` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_mhs_proposal_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_proposal_tesis` WRITE;
/*!40000 ALTER TABLE `mhs_proposal_tesis` DISABLE KEYS */;

INSERT INTO `mhs_proposal_tesis` (`id_mhs_proposal_tesis`, `link`, `id_proposal_tesis`, `id_mahasiswa`, `id_ref_proposal_tesis`, `berkas`, `status`)
VALUES
	(1,NULL,1,36,2,'beritalogo.png',0),
	(3,NULL,1,36,7,'Capture.PNG',0),
	(4,NULL,1,36,8,'SURAT_EDARAN.pdf',0),
	(5,NULL,1,36,3,'header.PNG',0),
	(7,NULL,1,36,5,'bebas_keuangan.pdf',0),
	(8,NULL,2,34,2,'bebas_keuangan.pdf',0),
	(9,NULL,2,34,3,'bebas_keuangan.pdf',0),
	(10,NULL,2,34,7,'bebas_keuangan.pdf',0);

/*!40000 ALTER TABLE `mhs_proposal_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mhs_seminar_hp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_seminar_hp`;

CREATE TABLE `mhs_seminar_hp` (
  `id_mhs_seminar_hp` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(250) DEFAULT NULL,
  `id_seminar_hp` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_ref_seminar_hp` int(11) NOT NULL,
  `berkas` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_mhs_seminar_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_seminar_hp` WRITE;
/*!40000 ALTER TABLE `mhs_seminar_hp` DISABLE KEYS */;

INSERT INTO `mhs_seminar_hp` (`id_mhs_seminar_hp`, `link`, `id_seminar_hp`, `id_mahasiswa`, `id_ref_seminar_hp`, `berkas`, `status`)
VALUES
	(2,NULL,1,36,6,'02-MP-S2-PENGAJUAN-JUDUL-PROPOSAL-TESIS.pdf',0),
	(3,NULL,1,36,7,'bebas_keuangan.pdf',0);

/*!40000 ALTER TABLE `mhs_seminar_hp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mhs_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mhs_tesis`;

CREATE TABLE `mhs_tesis` (
  `id_mhs_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(250) DEFAULT NULL,
  `id_tesis` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_ref_tesis` int(11) NOT NULL,
  `berkas` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_mhs_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mhs_tesis` WRITE;
/*!40000 ALTER TABLE `mhs_tesis` DISABLE KEYS */;

INSERT INTO `mhs_tesis` (`id_mhs_tesis`, `link`, `id_tesis`, `id_mahasiswa`, `id_ref_tesis`, `berkas`, `status`)
VALUES
	(1,NULL,1,36,3,'Contoh_Format_Lembar_Persetujuan_Tesis_Disertasi.pdf',0),
	(2,NULL,1,36,12,'3__UJIAN_SHP_DAN_TURNITIN.pdf',0),
	(3,NULL,1,36,14,'4__UJIAN_TESIS_DAN_INSTRUMENT_MONITORING.pdf',0),
	(4,'https://sinta.ristekbrin.go.id/journals',1,36,13,NULL,0),
	(5,NULL,1,36,16,'bebas_keuangan.pdf',0);

/*!40000 ALTER TABLE `mhs_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nav`;

CREATE TABLE `nav` (
  `id_nav` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_par_nav` int(11) DEFAULT NULL,
  `id_aplikasi` int(1) DEFAULT NULL,
  `ref` int(1) DEFAULT NULL,
  `kode` varchar(5) DEFAULT NULL,
  `tipe` int(1) DEFAULT NULL,
  `judul` varchar(128) DEFAULT NULL,
  `link` varchar(128) DEFAULT NULL,
  `fa` varchar(50) DEFAULT NULL,
  `urut` int(3) DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_nav`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `nav` WRITE;
/*!40000 ALTER TABLE `nav` DISABLE KEYS */;

INSERT INTO `nav` (`id_nav`, `id_par_nav`, `id_aplikasi`, `ref`, `kode`, `tipe`, `judul`, `link`, `fa`, `urut`, `aktif`)
VALUES
	(1,NULL,1,1,'',2,'Referensi','','',7,1),
	(2,1,1,1,'',2,'Syarat Tesis','tigris/Ref_tesis','',9,1),
	(3,NULL,1,1,'',2,'Dosen','tigris/Dosen','',9,1),
	(4,NULL,1,1,'',2,'Penjadwalan Ujian','','',13,1),
	(6,NULL,1,1,'',2,'Ids','','',29,1),
	(7,NULL,1,1,'',2,'Pendaftaran Ujian','tigris/Pendaftaran','',12,1),
	(8,NULL,1,1,'tigris',1,'Super','','',1,1),
	(9,1,1,1,'',2,'User','tigris/User','',30,1),
	(10,1,1,1,'',2,'Kewenangan','tigris/Kewenangan','',31,1),
	(11,1,1,1,'',2,'Fakultas','tigris/Unit','',15,1),
	(17,NULL,1,1,'',2,'Mahasiswa','tigris/Mahasiswa','',8,1),
	(18,NULL,1,1,'',2,'Pengajuan Judul','tigris/Pengajuan_judul','',11,1),
	(19,1,1,1,'',2,'Syarat Pengajuan Judul','tigris/Ref_pengajuan_judul','',2,1),
	(20,1,1,1,'',2,'Syarat Proposal Tesis','tigris/Ref_proposal_tesis','',7,1),
	(21,1,1,1,'',2,'Syarat Seminar Hasil Penelitian','tigris/Ref_seminar_hp','',8,1),
	(22,7,1,1,'',2,'Proposal Tesis','tigris/Proposal_tesis','',18,1),
	(23,7,1,1,'',2,'Seminar Hasil Penelitian','tigris/Seminar_hp','',19,1),
	(24,7,1,1,'',2,'Tesis','tigris/Tesis','',20,1),
	(25,NULL,1,1,'akad',1,'Akademik','','',2,1),
	(26,NULL,1,1,'perp',1,'Perpustakaan','','',3,1),
	(27,NULL,1,1,'keua',1,'Keuangan','','',4,1),
	(28,NULL,1,1,'pimp',1,'Pimpinan','','',5,1),
	(29,1,1,1,'',2,'Prodi','tigris/Bidang','',16,1),
	(30,1,1,1,'',2,'Program Konsentrasi','tigris/Ref_program_konsentrasi','',17,1),
	(31,NULL,1,1,'mhs',1,'Mahasiswa','','',6,1),
	(32,4,1,1,'',2,'Proposal Tesis','tigris/Penjadwalan_proposal_tesis','',23,1),
	(33,4,1,1,'',2,'Seminar Hasil Penelitian','tigris/Penjadwalan_seminar_hp','',24,1),
	(34,4,1,1,'',2,'Tesis','tigris/Penjadwalan_tesis','',25,1),
	(36,6,1,1,'',2,'Parameter','tigris/Parameter','',28,1),
	(37,6,1,1,'',2,'Runing teks','tigris/Teks','',26,1),
	(38,NULL,1,1,'',2,'Periode Pendaftaran Ujian','tigris/Periode_pu','',10,1),
	(39,1,1,1,'',2,'Tahun','tigris/Ref_tahun','',21,1),
	(40,1,1,1,'',2,'Semester','tigris/Ref_semester','',22,1);

/*!40000 ALTER TABLE `nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `urut` int(1) NOT NULL,
  `aktif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table parameter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parameter`;

CREATE TABLE `parameter` (
  `param` varchar(100) NOT NULL,
  `val` text,
  PRIMARY KEY (`param`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `parameter` WRITE;
/*!40000 ALTER TABLE `parameter` DISABLE KEYS */;

INSERT INTO `parameter` (`param`, `val`)
VALUES
	('alamat','Jl. Prof. Soedarto, SH., Tembalang, Semarang'),
	('all_reload','1000'),
	('aplikasi','Online Thesis Registration'),
	('aplikasi_code','OnThreg'),
	('aplikasi_logo','cms.png'),
	('aplikasi_logo_only',NULL),
	('aplikasi_s','OnThreg'),
	('app_active','1'),
	('copyright','2020'),
	('default_pass',''),
	('demo',NULL),
	('description',' Dikelola oleh MMK'),
	('durasi_agenda_bulan_depan','30'),
	('durasi_agenda_bulan_ini','7'),
	('durasi_agenda_kegiatan','10'),
	('durasi_galeri_kanan','30'),
	('durasi_galeri_kiri','30'),
	('email',''),
	('footer','Copyright © 2018. BKPSDM Kabupaten Murung Raya Provinsi Kalimantan Tengah'),
	('foto_latar_login',''),
	('hal','3'),
	('header_image','header_grobogan_anyar.png'),
	('height_agenda_1','530'),
	('height_agenda_2','400'),
	('height_agenda_bulan_depan_1','250'),
	('height_agenda_bulan_depan_2','150'),
	('height_agenda_bulan_ini_1','200'),
	('height_agenda_bulan_ini_2','100'),
	('height_galeri_1','100'),
	('height_galeri_2','100'),
	('height_kalender_1','100'),
	('height_kalender_2','100'),
	('height_pengumuman_1','100'),
	('height_pengumuman_2','100'),
	('ibukota','UNDIP'),
	('instansi','Universitas Diponegoro'),
	('instansi_code','UNDIP'),
	('instansi_s','UNDIP'),
	('login_captcha',NULL),
	('main_color','#d32821'),
	('main_title','MALCOM - Manajemen Layanan e-Commerce'),
	('multi_unit','1'),
	('nav','1'),
	('page_view','a:1032:{i:0;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:1;s:3:\"162\";i:2;s:3:\"318\";i:3;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:4;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:5;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:6;s:52:\"pengumuman_perpanjangan_jadwal_pendaftaran_cpns_2018\";i:7;s:60:\"surat_bkn_no_2630v102899_hal_penjelasan_masa_kerja_dan_hak_p\";i:8;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:9;s:14:\"pengadaan_cpns\";i:10;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:11;s:14:\"pengadaan_cpns\";i:12;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:13;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:14;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:15;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:16;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:17;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:18;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:19;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:20;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:21;s:3:\"342\";i:22;s:60:\"pengumuman_penyampaian_dokumen_pendukung_hasil_seleksi_kompe\";i:23;s:6:\"tujuan\";i:24;s:14:\"pengadaan_cpns\";i:25;s:27:\"kenaikan_jabatan_fungsional\";i:26;s:60:\"hasil_cat_seleksi_kompetensi_bidang_skb_penerimaan_cpns_daer\";i:27;s:16:\"tanda_kehormatan\";i:28;s:4:\"home\";i:29;s:22:\"tugas_dan_pokok_fungsi\";i:30;s:3:\"342\";i:31;s:4:\"home\";i:32;s:20:\"peraturan_pemerintah\";i:33;s:5:\"video\";i:34;s:13:\"visi_dan_misi\";i:35;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:36;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:37;s:19:\"struktur_organisasi\";i:38;s:6:\"diklat\";i:39;s:6:\"diklat\";i:40;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:41;s:3:\"183\";i:42;s:15:\"perpindahan_pns\";i:43;s:2:\"13\";i:44;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:45;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:46;s:3:\"351\";i:47;s:3:\"339\";i:48;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:49;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:50;s:29:\"pelaksanaan_epupns_tahun_2015\";i:51;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:52;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:53;s:52:\"ujian_kenaikan_pangkat_penyesuaian_ijazah_tahun_2018\";i:54;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:55;s:4:\"foto\";i:56;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:57;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:58;s:16:\"kartu_istrisuami\";i:59;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:60;s:13:\"visi_dan_misi\";i:61;s:3:\"314\";i:62;s:14:\"pengadaan_cpns\";i:63;s:13:\"undang_undang\";i:64;s:28:\"perpanjangan_i_seleksi_sekda\";i:65;s:3:\"258\";i:66;s:3:\"252\";i:67;s:37:\"perubahan_jadwal_penerimaan_cpns_2019\";i:68;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:69;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:70;s:15:\"perpindahan_pns\";i:71;s:3:\"182\";i:72;s:9:\"kartu_pns\";i:73;s:60:\"tahapan_dan_jadwal_seleksi_terbuka_jpt_pratama_pemkab_murung\";i:74;s:3:\"366\";i:75;s:29:\"pelaksanaan_epupns_tahun_2015\";i:76;s:3:\"292\";i:77;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:78;s:6:\"diklat\";i:79;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:80;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:81;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:82;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:83;s:16:\"kenaikan_pangkat\";i:84;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:85;s:13:\"undang_undang\";i:86;s:17:\"statistik_pegawai\";i:87;s:3:\"331\";i:88;s:3:\"211\";i:89;s:9:\"kartu_pns\";i:90;s:3:\"318\";i:91;s:7:\"pensiun\";i:92;s:6:\"diklat\";i:93;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:94;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:95;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:96;s:20:\"peraturan_pemerintah\";i:97;s:3:\"330\";i:98;s:3:\"162\";i:99;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:100;s:3:\"162\";i:101;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:102;s:52:\"pengumuman_perpanjangan_jadwal_pendaftaran_cpns_2018\";i:103;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:104;s:3:\"292\";i:105;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:106;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:107;s:2:\"15\";i:108;s:60:\"pengumuman_pelaksanaan_ujian_seleksi_calon_pppk_tahap_i_tahu\";i:109;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:110;s:27:\"kenaikan_jabatan_fungsional\";i:111;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:112;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:113;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:114;s:48:\"usulan_tanda_kehormatan_satyalancana_karya_satya\";i:115;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:116;s:60:\"penerimaan_cpns_daerah_kabupaten_murung_raya_formasi_tahun_2\";i:117;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:118;s:44:\"masyarakat_agar_waspada_hoax_penerimaan_cpns\";i:119;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:120;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:121;s:5:\"video\";i:122;s:3:\"356\";i:123;s:60:\"pengumuman_penyampaian_dokumen_pendukung_hasil_seleksi_kompe\";i:124;s:19:\"artikel-kepegawaian\";i:125;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:126;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:127;s:4:\"home\";i:128;s:50:\"hasil_final_seleksi_terbuka_jpt_pratama_tahun_2017\";i:129;s:60:\"penggantian_peserta_yang_mengundurkan_diri_hasil_seleksi_pen\";i:130;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:131;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:132;s:42:\"libur_nasional_dan_cuti_bersama_tahun_2018\";i:133;s:2:\"15\";i:134;s:3:\"358\";i:135;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:136;s:6:\"diklat\";i:137;s:2:\"15\";i:138;s:60:\"penerimaan_pegawai_pemerintah_dengan_perjanjian_kerja_pppk_t\";i:139;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:140;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:141;s:3:\"277\";i:142;s:2:\"13\";i:143;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:144;s:29:\"pelaksanaan_epupns_tahun_2015\";i:145;s:13:\"undang_undang\";i:146;s:6:\"tujuan\";i:147;s:36:\"laporan_penilaian_prestasi_kerja_pns\";i:148;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:149;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:150;s:3:\"234\";i:151;s:3:\"351\";i:152;s:3:\"329\";i:153;s:50:\"hasil_final_seleksi_terbuka_jpt_pratama_tahun_2017\";i:154;s:3:\"343\";i:155;s:17:\"statistik_pegawai\";i:156;s:3:\"286\";i:157;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:158;s:3:\"314\";i:159;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:160;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:161;s:13:\"undang_undang\";i:162;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:163;s:3:\"358\";i:164;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:165;s:20:\"peraturan_pemerintah\";i:166;s:2:\"13\";i:167;s:4:\"foto\";i:168;s:3:\"234\";i:169;s:50:\"hasil_final_seleksi_terbuka_jpt_pratama_tahun_2017\";i:170;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:171;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:172;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:173;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:174;s:3:\"358\";i:175;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:176;s:5:\"video\";i:177;s:3:\"358\";i:178;s:16:\"kartu_istrisuami\";i:179;s:22:\"tugas_dan_pokok_fungsi\";i:180;s:52:\"ujian_kenaikan_pangkat_penyesuaian_ijazah_tahun_2018\";i:181;s:3:\"349\";i:182;s:16:\"kartu_istrisuami\";i:183;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:184;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:185;s:7:\"lainnya\";i:186;s:60:\"pendaftaran_cpns_penyuluh_pertanian_dari_pelamar_thltb_penyu\";i:187;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:188;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:189;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:190;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:191;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:192;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:193;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:194;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:195;s:3:\"162\";i:196;s:3:\"182\";i:197;s:3:\"183\";i:198;s:3:\"184\";i:199;s:3:\"211\";i:200;s:3:\"234\";i:201;s:3:\"263\";i:202;s:3:\"292\";i:203;s:3:\"342\";i:204;s:3:\"349\";i:205;s:3:\"351\";i:206;s:3:\"352\";i:207;s:3:\"356\";i:208;s:3:\"357\";i:209;s:3:\"358\";i:210;s:3:\"162\";i:211;s:3:\"182\";i:212;s:3:\"183\";i:213;s:3:\"184\";i:214;s:3:\"211\";i:215;s:3:\"234\";i:216;s:3:\"263\";i:217;s:3:\"292\";i:218;s:3:\"342\";i:219;s:3:\"349\";i:220;s:3:\"351\";i:221;s:3:\"352\";i:222;s:3:\"354\";i:223;s:3:\"356\";i:224;s:3:\"357\";i:225;s:3:\"358\";i:226;s:29:\"pelaksanaan_epupns_tahun_2015\";i:227;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:228;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:229;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:230;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:231;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:232;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:233;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:234;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:235;s:2:\"13\";i:236;s:2:\"14\";i:237;s:2:\"15\";i:238;s:6:\"diklat\";i:239;s:4:\"foto\";i:240;s:16:\"kartu_istrisuami\";i:241;s:9:\"kartu_pns\";i:242;s:27:\"kenaikan_jabatan_fungsional\";i:243;s:16:\"kenaikan_pangkat\";i:244;s:7:\"lainnya\";i:245;s:14:\"pengadaan_cpns\";i:246;s:7:\"pensiun\";i:247;s:20:\"peraturan_pemerintah\";i:248;s:15:\"perpindahan_pns\";i:249;s:17:\"statistik_pegawai\";i:250;s:19:\"struktur_organisasi\";i:251;s:16:\"tanda_kehormatan\";i:252;s:22:\"tugas_dan_izin_belajar\";i:253;s:22:\"tugas_dan_pokok_fungsi\";i:254;s:6:\"tujuan\";i:255;s:13:\"undang_undang\";i:256;s:5:\"video\";i:257;s:13:\"visi_dan_misi\";i:258;s:4:\"home\";i:259;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:260;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:261;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:262;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:263;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:264;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:265;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:266;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:267;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:268;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:269;s:27:\"kenaikan_jabatan_fungsional\";i:270;s:13:\"undang_undang\";i:271;s:58:\"pengumuman_hasil_seleksi_administrasi_setelah_masa_sanggah\";i:272;s:3:\"366\";i:273;s:4:\"foto\";i:274;s:3:\"182\";i:275;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:276;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:277;s:8:\"hub_kami\";i:278;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:279;s:3:\"211\";i:280;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:281;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:282;s:3:\"162\";i:283;s:19:\"struktur_organisasi\";i:284;s:3:\"162\";i:285;s:16:\"kenaikan_pangkat\";i:286;s:3:\"342\";i:287;s:3:\"182\";i:288;s:3:\"342\";i:289;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:290;s:3:\"224\";i:291;s:60:\"perubahan_pengumuman_seleksi_terbuka_jpt_pratama_kab_murung_\";i:292;s:3:\"284\";i:293;s:16:\"tanda_kehormatan\";i:294;s:2:\"15\";i:295;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:296;s:13:\"visi_dan_misi\";i:297;s:22:\"tugas_dan_pokok_fungsi\";i:298;s:5:\"video\";i:299;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:300;s:2:\"15\";i:301;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:302;s:22:\"tugas_dan_pokok_fungsi\";i:303;s:13:\"undang_undang\";i:304;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:305;s:13:\"undang_undang\";i:306;s:3:\"211\";i:307;s:3:\"352\";i:308;s:7:\"pensiun\";i:309;s:3:\"352\";i:310;s:3:\"313\";i:311;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:312;s:3:\"359\";i:313;s:19:\"Artikel-Kepegawaian\";i:314;s:3:\"211\";i:315;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:316;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:317;s:60:\"perubahan_pengumuman_seleksi_terbuka_jpt_pratama_kab_murung_\";i:318;s:60:\"tahapan_dan_jadwal_seleksi_terbuka_jpt_pratama_pemkab_murung\";i:319;s:15:\"perpindahan_pns\";i:320;s:2:\"14\";i:321;s:16:\"kartu_istrisuami\";i:322;s:22:\"tugas_dan_izin_belajar\";i:323;s:3:\"284\";i:324;s:16:\"tanda_kehormatan\";i:325;s:19:\"Artikel-Kepegawaian\";i:326;s:42:\"perubahan_jadwal_penerimaan_cpns_tahun2019\";i:327;s:9:\"kartu_pns\";i:328;s:52:\"ujian_kenaikan_pangkat_penyesuaian_ijazah_tahun_2018\";i:329;s:49:\"penyesuaian_nomenklatur_jabatan_pelaksana_th_2018\";i:330;s:60:\"penerimaan_calon_pegawai_negeri_sipil_cpns_daerah_kabupaten_\";i:331;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:332;s:60:\"penerimaan_berkas_usul_kenaikan_pangkat_periode_1_april_2018\";i:333;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:334;s:3:\"319\";i:335;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:336;s:3:\"284\";i:337;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:338;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:339;s:16:\"tanda_kehormatan\";i:340;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:341;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:342;s:14:\"pengadaan_cpns\";i:343;s:8:\"hub_kami\";i:344;s:14:\"pengadaan_cpns\";i:345;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:346;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:347;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:348;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:349;s:3:\"323\";i:350;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:351;s:52:\"ujian_kenaikan_pangkat_penyesuaian_ijazah_tahun_2018\";i:352;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:353;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:354;s:60:\"penerimaan_berkas_usul_kenaikan_pangkat_periode_1_april_2018\";i:355;s:3:\"184\";i:356;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:357;s:48:\"usulan_tanda_kehormatan_satyalancana_karya_satya\";i:358;s:3:\"342\";i:359;s:3:\"340\";i:360;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:361;s:2:\"13\";i:362;s:3:\"358\";i:363;s:3:\"237\";i:364;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:365;s:4:\"foto\";i:366;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:367;s:29:\"pelaksanaan_epupns_tahun_2015\";i:368;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:369;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:370;s:5:\"video\";i:371;s:16:\"kartu_istrisuami\";i:372;s:7:\"lainnya\";i:373;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:374;s:16:\"kartu_istrisuami\";i:375;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:376;s:13:\"visi_dan_misi\";i:377;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:378;s:13:\"undang_undang\";i:379;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:380;s:7:\"lainnya\";i:381;s:3:\"314\";i:382;s:19:\"Artikel-Kepegawaian\";i:383;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:384;s:27:\"kenaikan_jabatan_fungsional\";i:385;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:386;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:387;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:388;s:9:\"kartu_pns\";i:389;s:17:\"statistik_pegawai\";i:390;s:6:\"tujuan\";i:391;s:14:\"pengadaan_cpns\";i:392;s:3:\"183\";i:393;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:394;s:2:\"15\";i:395;s:3:\"183\";i:396;s:2:\"15\";i:397;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:398;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:399;s:2:\"14\";i:400;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:401;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:402;s:60:\"pendaftaran_cpns_penyuluh_pertanian_dari_pelamar_thltb_penyu\";i:403;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:404;s:3:\"357\";i:405;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:406;s:3:\"351\";i:407;s:7:\"pensiun\";i:408;s:3:\"162\";i:409;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:410;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:411;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:412;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_bidang_skb_penerim\";i:413;s:3:\"184\";i:414;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:415;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:416;s:17:\"statistik_pegawai\";i:417;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:418;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:419;s:2:\"14\";i:420;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:421;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:422;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:423;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:424;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:425;s:29:\"pelaksanaan_epupns_tahun_2015\";i:426;s:3:\"343\";i:427;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:428;s:27:\"kenaikan_jabatan_fungsional\";i:429;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:430;s:3:\"211\";i:431;s:3:\"234\";i:432;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:433;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:434;s:19:\"struktur_organisasi\";i:435;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:436;s:20:\"peraturan_pemerintah\";i:437;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:438;s:15:\"perpindahan_pns\";i:439;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:440;s:3:\"182\";i:441;s:16:\"kenaikan_pangkat\";i:442;s:60:\"pengumuman_hasil_seleksi_kompetensi_dasar_skd_calon_pegawai_\";i:443;s:60:\"pengumuman_hasil_seleksi_kompetensi_dasar_skd_calon_pegawai_\";i:444;s:20:\"peraturan_pemerintah\";i:445;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:446;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:447;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:448;s:3:\"357\";i:449;s:3:\"342\";i:450;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:451;s:3:\"358\";i:452;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:453;s:4:\"home\";i:454;s:6:\"diklat\";i:455;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:456;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:457;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:458;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:459;s:60:\"pengumuman_penerimaan_cpns_kabupaten_murung_raya_tahun_angga\";i:460;s:6:\"tujuan\";i:461;s:4:\"home\";i:462;s:3:\"349\";i:463;s:3:\"357\";i:464;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:465;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:466;s:16:\"tanda_kehormatan\";i:467;s:3:\"220\";i:468;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:469;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:470;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:471;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:472;s:3:\"219\";i:473;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:474;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:475;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:476;s:19:\"struktur_organisasi\";i:477;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:478;s:4:\"home\";i:479;s:4:\"home\";i:480;s:60:\"hasil_seleksi_pegawai_pemerintah_dengan_perjanjian_kerja_ppp\";i:481;s:60:\"hasil_seleksi_pegawai_pemerintah_dengan_perjanjian_kerja_ppp\";i:482;s:3:\"357\";i:483;s:60:\"penerimaan_cpns_daerah_kabupaten_murung_raya_formasi_tahun_2\";i:484;s:60:\"penerimaan_cpns_daerah_kabupaten_murung_raya_formasi_tahun_2\";i:485;s:29:\"pelaksanaan_epupns_tahun_2015\";i:486;s:29:\"pelaksanaan_epupns_tahun_2015\";i:487;s:3:\"183\";i:488;s:60:\"perubahan_pengumuman_seleksi_terbuka_jpt_pratama_kab_murung_\";i:489;s:3:\"286\";i:490;s:60:\"penerimaan_calon_pegawai_negeri_sipil_cpns_daerah_kabupaten_\";i:491;s:60:\"penerimaan_calon_pegawai_negeri_sipil_cpns_daerah_kabupaten_\";i:492;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:493;s:29:\"pelaksanaan_epupns_tahun_2015\";i:494;s:3:\"351\";i:495;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:496;s:21:\"function.getimagesize\";i:497;s:3:\"278\";i:498;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:499;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:500;s:22:\"tugas_dan_izin_belajar\";i:501;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:502;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:503;s:52:\"pengumuman_perpanjangan_jadwal_pendaftaran_cpns_2018\";i:504;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:505;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:506;s:4:\"foto\";i:507;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:508;s:14:\"pengadaan_cpns\";i:509;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:510;s:3:\"286\";i:511;s:44:\"jadwal_wawancara_makalah_dan_wawancara_akhir\";i:512;s:44:\"jadwal_wawancara_makalah_dan_wawancara_akhir\";i:513;s:47:\"penerimaan_usul_kenaikan_pangkat_pns_tahun_2018\";i:514;s:14:\"pengadaan_cpns\";i:515;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:516;s:13:\"visi_dan_misi\";i:517;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:518;s:4:\"home\";i:519;s:4:\"home\";i:520;s:16:\"kartu_istrisuami\";i:521;s:28:\"perpanjangan_i_seleksi_sekda\";i:522;s:37:\"perubahan_jadwal_penerimaan_cpns_2019\";i:523;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:524;s:15:\"perpindahan_pns\";i:525;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:526;s:2:\"15\";i:527;s:3:\"324\";i:528;s:3:\"182\";i:529;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:530;s:3:\"328\";i:531;s:3:\"292\";i:532;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:533;s:9:\"kartu_pns\";i:534;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:535;s:22:\"tugas_dan_izin_belajar\";i:536;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:537;s:14:\"pengadaan_cpns\";i:538;s:60:\"pengumuman_hasil_seleksi_kompetensi_dasar_skd_calon_pegawai_\";i:539;s:60:\"pengumuman_hasil_seleksi_kompetensi_dasar_skd_calon_pegawai_\";i:540;s:3:\"276\";i:541;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:542;s:3:\"276\";i:543;s:60:\"penggantian_peserta_yang_mengundurkan_diri_hasil_seleksi_pen\";i:544;s:60:\"penggantian_peserta_yang_mengundurkan_diri_hasil_seleksi_pen\";i:545;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:546;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:547;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:548;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:549;s:16:\"kenaikan_pangkat\";i:550;s:3:\"356\";i:551;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:552;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:553;s:17:\"statistik_pegawai\";i:554;s:3:\"359\";i:555;s:3:\"359\";i:556;s:3:\"354\";i:557;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:558;s:3:\"351\";i:559;s:7:\"pensiun\";i:560;s:16:\"kenaikan_pangkat\";i:561;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:562;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:563;s:19:\"struktur_organisasi\";i:564;s:60:\"pengumuman_penyampaian_dokumen_pendukung_hasil_seleksi_kompe\";i:565;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:566;s:60:\"pengumuman_hasil_seleksi_penerimaan_cpns_daerah_kab_murung_r\";i:567;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:568;s:20:\"peraturan_pemerintah\";i:569;s:3:\"342\";i:570;s:60:\"surat_bkn_no_2630v102899_hal_penjelasan_masa_kerja_dan_hak_p\";i:571;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:572;s:49:\"penyesuaian_nomenklatur_jabatan_pelaksana_th_2018\";i:573;s:60:\"pengumuman_hasil_seleksi_kompetensi_dasar_skd_calon_pegawai_\";i:574;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:575;s:60:\"perubahan_pengumuman_seleksi_terbuka_jpt_pratama_kab_murung_\";i:576;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:577;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:578;s:6:\"diklat\";i:579;s:14:\"pengadaan_cpns\";i:580;s:60:\"seleksi_terbuka_jabatan_pimpinan_tinggi_pratama_di_lingkunga\";i:581;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:582;s:2:\"15\";i:583;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:584;s:14:\"pengadaan_cpns\";i:585;s:60:\"surat_bkn_no_2630v102899_hal_penjelasan_masa_kerja_dan_hak_p\";i:586;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:587;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:588;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:589;s:60:\"tata_tertib_peserta_seleksi_kompetensi_dasar_skd_berbasis_ca\";i:590;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:591;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:592;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:593;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:594;s:5:\"video\";i:595;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:596;s:3:\"356\";i:597;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:598;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:599;s:4:\"home\";i:600;s:3:\"292\";i:601;s:3:\"358\";i:602;s:2:\"13\";i:603;s:6:\"diklat\";i:604;s:17:\"statistik_pegawai\";i:605;s:6:\"diklat\";i:606;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:607;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:608;s:13:\"undang_undang\";i:609;s:8:\"hub_kami\";i:610;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:611;s:2:\"14\";i:612;s:3:\"329\";i:613;s:3:\"343\";i:614;s:3:\"184\";i:615;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:616;s:6:\"tujuan\";i:617;s:3:\"211\";i:618;s:17:\"statistik_pegawai\";i:619;s:3:\"286\";i:620;s:60:\"pengumuman_hasil_seleksi_penerimaan_cpns_daerah_kab_murung_r\";i:621;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:622;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:623;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:624;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:625;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:626;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:627;s:3:\"314\";i:628;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:629;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:630;s:3:\"257\";i:631;s:3:\"183\";i:632;s:2:\"13\";i:633;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:634;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:635;s:4:\"foto\";i:636;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:637;s:20:\"peraturan_pemerintah\";i:638;s:5:\"video\";i:639;s:16:\"kartu_istrisuami\";i:640;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:641;s:16:\"kartu_istrisuami\";i:642;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:643;s:22:\"tugas_dan_pokok_fungsi\";i:644;s:60:\"pencetakan_ulang_kartu_tanda_bukti_peserta_ujian_eks_tenaga_\";i:645;s:20:\"peraturan_pemerintah\";i:646;s:7:\"lainnya\";i:647;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:648;s:4:\"home\";i:649;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:650;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:651;s:13:\"visi_dan_misi\";i:652;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:653;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:654;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:655;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:656;s:15:\"perpindahan_pns\";i:657;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:658;s:3:\"182\";i:659;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:660;s:60:\"pencetakan_ulang_kartu_tanda_bukti_peserta_ujian_eks_tenaga_\";i:661;s:3:\"219\";i:662;s:60:\"pengumuman_hasil_seleksi_penerimaan_cpns_daerah_kab_murung_r\";i:663;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:664;s:44:\"masyarakat_agar_waspada_hoax_penerimaan_cpns\";i:665;s:52:\"ujian_kenaikan_pangkat_penyesuaian_ijazah_tahun_2018\";i:666;s:22:\"tugas_dan_izin_belajar\";i:667;s:16:\"kenaikan_pangkat\";i:668;s:44:\"masyarakat_agar_waspada_hoax_penerimaan_cpns\";i:669;s:3:\"314\";i:670;s:19:\"struktur_organisasi\";i:671;s:16:\"tanda_kehormatan\";i:672;s:52:\"pengumuman_perpanjangan_jadwal_pendaftaran_cpns_2018\";i:673;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:674;s:52:\"pengumuman_perpanjangan_jadwal_pendaftaran_cpns_2018\";i:675;s:3:\"284\";i:676;s:22:\"tugas_dan_pokok_fungsi\";i:677;s:60:\"seleksi_terbuka_jabatan_pimpinan_tinggi_pratama_di_lingkunga\";i:678;s:13:\"visi_dan_misi\";i:679;s:3:\"224\";i:680;s:5:\"video\";i:681;s:13:\"undang_undang\";i:682;s:16:\"kenaikan_pangkat\";i:683;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:684;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:685;s:36:\"laporan_penilaian_prestasi_kerja_pns\";i:686;s:7:\"pensiun\";i:687;s:4:\"home\";i:688;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:689;s:29:\"pelaksanaan_epupns_tahun_2015\";i:690;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:691;s:3:\"335\";i:692;s:8:\"hub_kami\";i:693;s:60:\"penerimaan_cpns_daerah_kabupaten_murung_raya_formasi_tahun_2\";i:694;s:3:\"351\";i:695;s:44:\"masyarakat_agar_waspada_hoax_penerimaan_cpns\";i:696;s:3:\"313\";i:697;s:3:\"279\";i:698;s:3:\"292\";i:699;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:700;s:3:\"263\";i:701;s:15:\"perpindahan_pns\";i:702;s:3:\"259\";i:703;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:704;s:2:\"14\";i:705;s:52:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_201\";i:706;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:707;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:708;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:709;s:22:\"tugas_dan_izin_belajar\";i:710;s:3:\"314\";i:711;s:3:\"183\";i:712;s:9:\"kartu_pns\";i:713;s:3:\"183\";i:714;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:715;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:716;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:717;s:3:\"294\";i:718;s:42:\"perubahan_jadwal_penerimaan_cpns_tahun2019\";i:719;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:720;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:721;s:16:\"tanda_kehormatan\";i:722;s:3:\"235\";i:723;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:724;s:3:\"276\";i:725;s:3:\"339\";i:726;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:727;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:728;s:29:\"pelaksanaan_epupns_tahun_2015\";i:729;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:730;s:3:\"327\";i:731;s:3:\"342\";i:732;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:733;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:734;s:14:\"pengadaan_cpns\";i:735;s:3:\"339\";i:736;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:737;s:3:\"184\";i:738;s:3:\"342\";i:739;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:740;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:741;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:742;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:743;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:744;s:3:\"234\";i:745;s:3:\"328\";i:746;s:60:\"perubahan_pengumuman_seleksi_terbuka_jpt_pratama_kab_murung_\";i:747;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:748;s:59:\"kegiatan_assesment_pemkab_murung_raya_2016_bersama_lpkm_ugm\";i:749;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_bidang_skb_penerim\";i:750;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:751;s:36:\"laporan_penilaian_prestasi_kerja_pns\";i:752;s:8:\"hub_kami\";i:753;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:754;s:7:\"lainnya\";i:755;s:2:\"14\";i:756;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:757;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:758;s:27:\"kenaikan_jabatan_fungsional\";i:759;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:760;s:3:\"295\";i:761;s:55:\"seleksi_terbuka_sekretaris_daerah_kabupaten_murung_raya\";i:762;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:763;s:3:\"252\";i:764;s:2:\"15\";i:765;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:766;s:27:\"function.imagecreatefromgif\";i:767;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:768;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:769;s:4:\"foto\";i:770;s:60:\"pengumuman_pelaksanaan_ujian_seleksi_calon_pppk_tahap_i_tahu\";i:771;s:60:\"terbaru_perpanjangan_ke2_jadwal_seleksi_terbuka_jpt_pratama_\";i:772;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:773;s:3:\"182\";i:774;s:3:\"276\";i:775;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:776;s:3:\"238\";i:777;s:60:\"pendaftaran_cpns_penyuluh_pertanian_dari_pelamar_thltb_penyu\";i:778;s:3:\"358\";i:779;s:60:\"seleksi_terbuka_jabatan_pimpinan_tinggi_pratama_di_lingkunga\";i:780;s:42:\"libur_nasional_dan_cuti_bersama_tahun_2018\";i:781;s:30:\"ujian_dinas_tingkat_i__ii_2017\";i:782;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:783;s:17:\"statistik_pegawai\";i:784;s:60:\"penetapan_hasil_assesment_seleksi_terbuka_jabatan_sekretaris\";i:785;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:786;s:2:\"14\";i:787;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:788;s:3:\"354\";i:789;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:790;s:49:\"surat_edaran_hari_libur_nasional_15_pebruari_2017\";i:791;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:792;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:793;s:27:\"kenaikan_jabatan_fungsional\";i:794;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:795;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:796;s:4:\"foto\";i:797;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:798;s:60:\"jadwal_pengajuan_sk_jabatan_fungsional_tenaga_pendidik_dan_k\";i:799;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:800;s:3:\"338\";i:801;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:802;s:9:\"kartu_pns\";i:803;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:804;s:60:\"pengangkatan_cpns_daerah_kabupaten_murung_raya_tahun_2019_do\";i:805;s:3:\"352\";i:806;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:807;s:3:\"310\";i:808;s:3:\"258\";i:809;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:810;s:3:\"357\";i:811;s:13:\"undang_undang\";i:812;s:39:\"pelaksanaan_sumpah_janji_pns_tahun_2018\";i:813;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:814;s:48:\"pengumuman_hasil_sanggah_seleksi_cpns_tahun_2019\";i:815;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:816;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:817;s:3:\"320\";i:818;s:49:\"perpanjangan_ii_seleksi_terbuka_sekretaris_daerah\";i:819;s:29:\"pelaksanaan_epupns_tahun_2015\";i:820;s:6:\"diklat\";i:821;s:4:\"home\";i:822;s:3:\"259\";i:823;s:58:\"pengumuman_hasil_seleksi_administrasi_setelah_masa_sanggah\";i:824;s:14:\"pengadaan_cpns\";i:825;s:6:\"tujuan\";i:826;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:827;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:828;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:829;s:3:\"252\";i:830;s:47:\"penerimaan_usul_kenaikan_pangkat_pns_tahun_2018\";i:831;s:60:\"keikut_sertaan_bkd_dalam_acara_karnaval_memperingati_hut_mur\";i:832;s:60:\"pengumuman_hasil_seleksi_penerimaan_cpns_daerah_kab_murung_r\";i:833;s:13:\"visi_dan_misi\";i:834;s:3:\"254\";i:835;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:836;s:3:\"313\";i:837;s:3:\"329\";i:838;s:3:\"293\";i:839;s:3:\"325\";i:840;s:21:\"function.getimagesize\";i:841;s:3:\"263\";i:842;s:3:\"331\";i:843;s:3:\"162\";i:844;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:845;s:3:\"252\";i:846;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:847;s:60:\"surat_edaran_bupati_murung_raya_tentang_pengangkatan_cpns_me\";i:848;s:5:\"video\";i:849;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:850;s:3:\"263\";i:851;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:852;s:28:\"eksistensi_organisasi_korpri\";i:853;s:3:\"357\";i:854;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:855;s:3:\"358\";i:856;s:44:\"jadwal_wawancara_makalah_dan_wawancara_akhir\";i:857;s:2:\"14\";i:858;s:13:\"visi_dan_misi\";i:859;s:19:\"struktur_organisasi\";i:860;s:3:\"323\";i:861;s:3:\"253\";i:862;s:60:\"pendaftaran_cpns_penyuluh_pertanian_dari_pelamar_thltb_penyu\";i:863;s:4:\"foto\";i:864;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:865;s:3:\"237\";i:866;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:867;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:868;s:29:\"pelaksanaan_epupns_tahun_2015\";i:869;s:3:\"354\";i:870;s:28:\"perpanjangan_i_seleksi_sekda\";i:871;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:872;s:3:\"324\";i:873;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:874;s:42:\"perubahan_jadwal_penerimaan_cpns_tahun2019\";i:875;s:3:\"315\";i:876;s:3:\"254\";i:877;s:60:\"penyerahan_sk_cpns_thltb_penyuluh_pertanian_oleh_bupati_muru\";i:878;s:60:\"penerimaan_cpns_daerah_kabupaten_murung_raya_formasi_tahun_2\";i:879;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:880;s:5:\"video\";i:881;s:4:\"foto\";i:882;s:3:\"236\";i:883;s:28:\"perpanjangan_i_seleksi_sekda\";i:884;s:14:\"pengadaan_cpns\";i:885;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:886;s:13:\"visi_dan_misi\";i:887;s:60:\"hasil_seleksi_pegawai_pemerintah_dengan_perjanjian_kerja_ppp\";i:888;s:37:\"perubahan_jadwal_penerimaan_cpns_2019\";i:889;s:15:\"perpindahan_pns\";i:890;s:9:\"kartu_pns\";i:891;s:3:\"313\";i:892;s:3:\"234\";i:893;s:3:\"263\";i:894;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:895;s:40:\"registrasi_cpns_2014_di_portal_panselnas\";i:896;s:9:\"kartu_pns\";i:897;s:3:\"278\";i:898;s:22:\"tugas_dan_izin_belajar\";i:899;s:4:\"foto\";i:900;s:13:\"visi_dan_misi\";i:901;s:16:\"kenaikan_pangkat\";i:902;s:3:\"339\";i:903;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:904;s:2:\"14\";i:905;s:3:\"356\";i:906;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:907;s:3:\"337\";i:908;s:3:\"295\";i:909;s:3:\"335\";i:910;s:3:\"331\";i:911;s:3:\"354\";i:912;s:47:\"penerimaan_usul_kenaikan_pangkat_pns_tahun_2018\";i:913;s:3:\"354\";i:914;s:3:\"249\";i:915;s:60:\"pencetakan_ulang_kartu_tanda_bukti_peserta_ujian_eks_tenaga_\";i:916;s:52:\"surat_edaran_bupati_tentang_spmt_cpns_pengadaan_2018\";i:917;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:918;s:14:\"pengadaan_cpns\";i:919;s:3:\"253\";i:920;s:3:\"357\";i:921;s:7:\"pensiun\";i:922;s:3:\"224\";i:923;s:3:\"328\";i:924;s:3:\"220\";i:925;s:3:\"257\";i:926;s:3:\"253\";i:927;s:17:\"statistik_pegawai\";i:928;s:60:\"pengambilan_sumpahjanji_pns_di_lingkungan_pemerintah_kabupat\";i:929;s:3:\"337\";i:930;s:3:\"236\";i:931;s:60:\"pelaksanaan_seleksi_kompetensi_dasar_skd_penerimaan_cpns_dae\";i:932;s:44:\"jadwal_wawancara_makalah_dan_wawancara_akhir\";i:933;s:3:\"330\";i:934;s:3:\"235\";i:935;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:936;s:60:\"pengumuman_pelaksanaan_ujian_seleksi_calon_pppk_tahap_i_tahu\";i:937;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:938;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:939;s:13:\"visi_dan_misi\";i:940;s:9:\"kartu_pns\";i:941;s:29:\"pelaksanaan_epupns_tahun_2015\";i:942;s:4:\"foto\";i:943;s:60:\"surat_bkn_no_2630v102899_hal_penjelasan_masa_kerja_dan_hak_p\";i:944;s:2:\"15\";i:945;s:60:\"denah_lokasi_pelaksanaan_seleksi_kompetensi_dasar_skd_peneri\";i:946;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:947;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:948;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:949;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:950;s:49:\"surat_edaran_hari_libur_nasional_15_pebruari_2017\";i:951;s:55:\"pelaksanaan_gerbang_desamu_di_desa_olung_siron_oleh_bkd\";i:952;s:4:\"foto\";i:953;s:3:\"319\";i:954;s:50:\"hasil_final_seleksi_terbuka_jpt_pratama_tahun_2017\";i:955;s:3:\"263\";i:956;s:60:\"pengumuman_pelaksanaan_seleksi_kompetensi_dasar_skd_penerima\";i:957;s:3:\"162\";i:958;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:959;s:4:\"home\";i:960;s:2:\"13\";i:961;s:5:\"video\";i:962;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:963;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:964;s:57:\"penerimaan_cpns_kabupaten_murung_raya_tahun_anggaran_2019\";i:965;s:60:\"pengumuman_dan_formasi_penerimaan_cpns_kabupaten_murung_raya\";i:966;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:967;s:6:\"diklat\";i:968;s:3:\"250\";i:969;s:5:\"video\";i:970;s:55:\"jadwal_diklat_prajabatan_golongan_iii_dan_ii_tahun_2016\";i:971;s:3:\"284\";i:972;s:3:\"338\";i:973;s:60:\"terbaru_perpanjangan_ke2_jadwal_seleksi_terbuka_jpt_pratama_\";i:974;s:3:\"337\";i:975;s:53:\"hasil_seleksi_administrasi_seleksi_terbuka_sekda_2019\";i:976;s:3:\"184\";i:977;s:6:\"tujuan\";i:978;s:13:\"undang_undang\";i:979;s:3:\"325\";i:980;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:981;s:3:\"211\";i:982;s:3:\"356\";i:983;s:4:\"foto\";i:984;s:48:\"perpanjangan_i_seleksi_terbuka_sekda_murung_raya\";i:985;s:3:\"351\";i:986;s:3:\"310\";i:987;s:47:\"penerimaan_usul_kenaikan_pangkat_pns_tahun_2018\";i:988;s:3:\"354\";i:989;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:990;s:14:\"pengadaan_cpns\";i:991;s:53:\"pengumuman_hasil_seleksi_administrasi_cpns_tahun_2019\";i:992;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:993;s:3:\"182\";i:994;s:30:\"ujian_dinas_tingkat_i__ii_2017\";i:995;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:996;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:997;s:7:\"pensiun\";i:998;s:3:\"349\";i:999;s:3:\"237\";i:1000;s:3:\"324\";i:1001;s:60:\"batas_waktu_penerimaan_berkas_usulan_jabatan_fungsional_tert\";i:1002;s:3:\"260\";i:1003;s:60:\"baru_pengumuman_hasil_seleksi_administrasi_pengisian_jpt_pra\";i:1004;s:3:\"252\";i:1005;s:4:\"foto\";i:1006;s:20:\"peraturan_pemerintah\";i:1007;s:3:\"183\";i:1008;s:3:\"234\";i:1009;s:2:\"13\";i:1010;s:56:\"peserta_seleksi_cpns_kategori_p1tl_kabupaten_murung_raya\";i:1011;s:60:\"hasl_selekst_kompetenst_dasar_skd_penerimaan_calon_pegawai_n\";i:1012;s:16:\"kartu_istrisuami\";i:1013;s:3:\"279\";i:1014;s:3:\"291\";i:1015;s:16:\"kartu_istrisuami\";i:1016;s:3:\"237\";i:1017;s:22:\"tugas_dan_pokok_fungsi\";i:1018;s:7:\"lainnya\";i:1019;s:5:\"video\";i:1020;s:3:\"255\";i:1021;s:3:\"236\";i:1022;s:3:\"349\";i:1023;s:60:\"pengumuman_hasil_seleksi_penerimaan_cpns_daerah_kab_murung_r\";i:1024;s:38:\"82_pns_terima_satyalancana_karya_satya\";i:1025;s:5:\"video\";i:1026;s:60:\"pengumuman_hasil_cat_bkn_pada_seleksi_kompetensi_bidang_skb_\";i:1027;s:60:\"pengumuman_hasil_seleksi_administrasi_penerimaan_cpns_tahun_\";i:1028;s:42:\"pendataan_pegawai_tidak_tetap_honorkontrak\";i:1029;s:3:\"342\";i:1030;s:44:\"jadwal_wawancara_makalah_dan_wawancara_akhir\";i:1031;s:0:\"\";}'),
	('pemerintah','Fakultas Hukum'),
	('pemerintah_logo','logo-undip.png'),
	('pemerintah_logo_bw','logo-undip1.png'),
	('pemerintah_s','UNDIP'),
	('sch_warna_header','#4a95ed'),
	('sch_warna_judul','#7cb5f7'),
	('sch_warna_latar','#ffffff'),
	('sch_warna_teks_header','#ffffff'),
	('sch_warna_teks_judul','#ffffff'),
	('stat',''),
	('telepon',''),
	('theme_data','a:2:{i:1;s:3:\"cms\";i:2;s:6:\"2018\";}'),
	('theme_landing','2020'),
	('theme_set','2020'),
	('tv_marquee','1'),
	('tv_widget','1'),
	('user_ol','a:2:{s:4:\"sess\";a:3:{i:0;s:32:\"6b5395843c58beaa139233aa335c56bb\";i:1;s:32:\"e778b2cfc543a1a783282d8a55f02d0f\";i:2;s:32:\"3bd34d1ca80e1a43bc693b19abd32431\";}s:4:\"time\";a:3:{i:0;i:1595648797;i:1;i:1595649097;i:2;i:1595649613;}}');

/*!40000 ALTER TABLE `parameter` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table peg_jabatan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `peg_jabatan`;

CREATE TABLE `peg_jabatan` (
  `id_peg_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_atasan` int(11) DEFAULT NULL,
  `id_atasan_atasan` int(11) DEFAULT NULL,
  `id_penetap` int(1) DEFAULT NULL,
  `id_status_pegawai` int(1) NOT NULL,
  `id_box` int(11) DEFAULT NULL,
  `puncak` int(1) DEFAULT '0',
  `no_sk` varchar(50) NOT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `tmt_jabatan` date NOT NULL,
  `selesai_jabatan` date NOT NULL,
  `tanggal_cetak` datetime DEFAULT NULL,
  `perpanjangan` int(3) DEFAULT NULL,
  `jabatan_manual` varchar(200) DEFAULT NULL,
  `eselon_manual` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `id_golru` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_peg_jabatan`),
  KEY `id_pegawai` (`id_pegawai`),
  KEY `id_jabatan` (`id_jabatan`),
  KEY `id_atasan` (`id_atasan`),
  KEY `id_bidang` (`id_bidang`),
  KEY `id_box` (`id_box`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `peg_jabatan` WRITE;
/*!40000 ALTER TABLE `peg_jabatan` DISABLE KEYS */;

INSERT INTO `peg_jabatan` (`id_peg_jabatan`, `id_pegawai`, `id_unit`, `id_jabatan`, `id_bidang`, `id_atasan`, `id_atasan_atasan`, `id_penetap`, `id_status_pegawai`, `id_box`, `puncak`, `no_sk`, `tanggal_sk`, `tmt_jabatan`, `selesai_jabatan`, `tanggal_cetak`, `perpanjangan`, `jabatan_manual`, `eselon_manual`, `status`, `id_golru`)
VALUES
	(25,9,0,0,0,NULL,NULL,NULL,0,NULL,0,'',NULL,'0000-00-00','0000-00-00',NULL,NULL,NULL,NULL,1,NULL);

/*!40000 ALTER TABLE `peg_jabatan` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table peg_pegawai
# ------------------------------------------------------------

DROP TABLE IF EXISTS `peg_pegawai`;

CREATE TABLE `peg_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `id_program_studi` int(11) DEFAULT NULL,
  `id_bidang` int(11) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `id_ref_semester` int(11) NOT NULL,
  `id_ref_tahun` int(11) NOT NULL,
  `id_ref_tipe_dosen` int(11) DEFAULT NULL,
  `id_tipe` int(1) NOT NULL,
  `id_agama` int(1) NOT NULL,
  `id_jeniskelamin` int(1) NOT NULL,
  `id_gol_darah` int(1) NOT NULL,
  `id_tempat_lahir` int(11) NOT NULL,
  `id_statuskawin` int(11) DEFAULT NULL,
  `id_suku` int(11) DEFAULT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `id_tipe_pegawai` int(1) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nip` char(18) NOT NULL,
  `nip_lama` varchar(18) DEFAULT NULL,
  `no_nik` varchar(30) DEFAULT NULL,
  `no_npwp` varchar(30) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `gelar_depan` varchar(20) DEFAULT NULL,
  `gelar_belakang` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `hobi` varchar(100) DEFAULT NULL,
  `tinggi` int(1) DEFAULT NULL,
  `berat` int(1) DEFAULT NULL,
  `rambut` varchar(100) DEFAULT NULL,
  `bentuk_muka` varchar(100) DEFAULT NULL,
  `warna_kulit` varchar(100) DEFAULT NULL,
  `ciri_khas` varchar(100) DEFAULT NULL,
  `cacat` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `telepon` varchar(12) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `pin` varchar(20) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `cpns_tmt` date DEFAULT NULL,
  `cpns_no` varchar(100) DEFAULT NULL,
  `cpns_tanggal` date DEFAULT NULL,
  `cpns_berkas` varchar(50) DEFAULT NULL,
  `mkg_tahun` int(1) DEFAULT NULL,
  `mkg_bulan` int(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `mn_jabatan` varchar(255) DEFAULT NULL COMMENT 'Manual Jabatan',
  `mn_golru` varchar(255) DEFAULT NULL COMMENT 'Manual Golongan',
  `status` int(1) DEFAULT '1',
  `status_aktif` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nip` (`nip`),
  KEY `id_jeniskelamin` (`id_jeniskelamin`),
  KEY `id_agama` (`id_agama`),
  KEY `id_gol_darah` (`id_gol_darah`),
  KEY `id_kelurahan` (`id_kelurahan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `peg_pegawai` WRITE;
/*!40000 ALTER TABLE `peg_pegawai` DISABLE KEYS */;

INSERT INTO `peg_pegawai` (`id_pegawai`, `id_program_studi`, `id_bidang`, `id_unit`, `id_ref_semester`, `id_ref_tahun`, `id_ref_tipe_dosen`, `id_tipe`, `id_agama`, `id_jeniskelamin`, `id_gol_darah`, `id_tempat_lahir`, `id_statuskawin`, `id_suku`, `id_kelurahan`, `id_tipe_pegawai`, `username`, `password`, `nip`, `nip_lama`, `no_nik`, `no_npwp`, `nama`, `gelar_depan`, `gelar_belakang`, `tanggal_lahir`, `hobi`, `tinggi`, `berat`, `rambut`, `bentuk_muka`, `warna_kulit`, `ciri_khas`, `cacat`, `alamat`, `kodepos`, `telepon`, `email`, `pin`, `website`, `photo`, `cpns_tmt`, `cpns_no`, `cpns_tanggal`, `cpns_berkas`, `mkg_tahun`, `mkg_bulan`, `last_login`, `mn_jabatan`, `mn_golru`, `status`, `status_aktif`)
VALUES
	(1,NULL,1,1,0,0,NULL,0,0,0,0,0,NULL,NULL,0,NULL,'admin','d8578edf8458ce06fbc5bb76a58c5ca4','12345',NULL,NULL,NULL,'Administrator ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-05-19 13:53:12',NULL,NULL,0,1),
	(2,NULL,2,1,0,0,NULL,0,0,0,0,0,NULL,NULL,0,NULL,'akademik','d8578edf8458ce06fbc5bb76a58c5ca4','455645',NULL,NULL,NULL,'Ver Akademik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-12 00:23:15',NULL,NULL,0,1),
	(3,NULL,3,1,0,0,NULL,0,0,0,0,0,NULL,NULL,0,NULL,'perpustakaan','d8578edf8458ce06fbc5bb76a58c5ca4','54565',NULL,NULL,NULL,'Perpustakaan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-12-15 11:00:44',NULL,NULL,0,1),
	(4,NULL,4,1,0,0,NULL,0,0,0,0,0,NULL,NULL,0,NULL,'keuangan','d8578edf8458ce06fbc5bb76a58c5ca4','678678',NULL,NULL,NULL,'Keuangan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-12-15 11:55:32',NULL,NULL,0,1),
	(5,NULL,0,0,0,0,NULL,0,0,0,0,0,NULL,NULL,0,NULL,'pimpinan','d8578edf8458ce06fbc5bb76a58c5ca4','89867',NULL,NULL,NULL,'Pimpinan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-12 01:19:12',NULL,NULL,0,1),
	(34,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410004','17cd449beb1228d0a72c72dea17b8e22','11000117410004',NULL,NULL,NULL,'INDIRA INGGI ASWIJATI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-03-08 15:40:13',NULL,NULL,0,1),
	(35,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410006','e1d345e0c67f514ced44e20334bc38fe','11000117410006',NULL,NULL,NULL,'TONNY SUHARTONO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(36,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410039','bc24eb8a4f7b1f35837c1f22ff11a3ac','11000117410039',NULL,NULL,NULL,'ADITIA SETIAWAN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-05-19 13:53:22',NULL,NULL,0,1),
	(37,2,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410040','60ecb09e72964db12031b16ddf2a43cc','11000117410040',NULL,NULL,NULL,'IRVAN ADI PUTRANTO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-16 10:31:39',NULL,NULL,0,1),
	(38,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410044','22396ed7f04600ed7f84c2762b2ec630','11000117410044',NULL,NULL,NULL,'DODIK SETIAWAN AJI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-11-25 23:47:22',NULL,NULL,0,1),
	(39,2,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410052','0a50ae39606eea5adbb0ccce35026834','11000117410052',NULL,NULL,NULL,'ANDHIKA INDRA PERDANA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-04-05 09:39:00',NULL,NULL,0,1),
	(40,2,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410055','14f4e3f973bd54f125b2b301a4043d59','11000117410055',NULL,NULL,NULL,'MUHAMMAD RIZKI NOVERI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(41,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410058','1df45221ee9f22fe8d71c089b9aeb303','11000117410058',NULL,NULL,NULL,'MAGNIS FLORENCIA BUTAR BUTAR',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(42,3,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410061','1244823ce1562cd6411cf00e597d75e9','11000117410061',NULL,NULL,NULL,'M. FAJRUL FALAH ZIHAN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(43,4,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410071','9876b25ef54bb4d65f1240c073dfde69','11000117410071',NULL,NULL,NULL,'ZULFATUN NIKMAH',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-16 10:33:12',NULL,NULL,0,1),
	(44,3,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410077','c7b6b9de1e59457901a4cb095ec3e93a','11000117410077',NULL,NULL,NULL,'YUDHA SETYA PAMBUDI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-16 10:35:47',NULL,NULL,0,1),
	(45,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410078','4eb28a06f32154319e80005b1d967756','11000117410078',NULL,NULL,NULL,'RAHMAWAN DIANTO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(46,4,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410082','3292341e3ac8b5b1236a8a37bbfdc18e','11000117410082',NULL,NULL,NULL,'RIZKY PRADANA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(47,2,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410084','fde481144c2efa6ddbc841b7ee817e7b','11000117410084',NULL,NULL,NULL,'MUNAWIR IDRIS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(48,3,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410085','e2ebab2b119ac6190ff54e3bd2dcd09c','11000117410085',NULL,NULL,NULL,'ALVIAN HADI PRATAMA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-16 10:30:43',NULL,NULL,0,1),
	(49,3,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410088','72d72561ef217dd704ec92f6ae93f16d','11000117410088',NULL,NULL,NULL,'HEYDER LUTFI ZARKASSI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(50,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410090','4c97cfe944c0e2bd840d11c0ff362de9','11000117410090',NULL,NULL,NULL,'RIZKA JUNISA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-11-20 14:47:39',NULL,NULL,0,1),
	(51,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410095','55cfc4b3fff30aa46d58f2a702b1972e','11000117410095',NULL,NULL,NULL,'PUTUT TRIANGGORO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(52,3,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410098','c1006e08aa03aff12f8163f554711b88','11000117410098',NULL,NULL,NULL,'ANANTA REFKA NANDA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-11-26 12:45:40',NULL,NULL,0,1),
	(53,2,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410099','cc3f84a37da2892470d6e2013c200d61','11000117410099',NULL,NULL,NULL,'EDI BONI MANTOLAS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-11-25 23:47:51',NULL,NULL,0,1),
	(54,5,NULL,NULL,1,4,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'11000117410112','dac007ff86a31b96b7c5a14633755972','11000117410112',NULL,NULL,NULL,'HERU CAHYO HARTANTO',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-12-15 13:00:52',NULL,NULL,0,1),
	(55,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'195110211976032001','d8578edf8458ce06fbc5bb76a58c5ca4','195110211976032001',NULL,NULL,NULL,'Prof. Dr. Esmi Warassih Pudji Rahayu, S.H., M.S.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(63,NULL,NULL,NULL,0,0,2,2,0,0,0,0,NULL,NULL,0,NULL,'195602031981031002','d8578edf8458ce06fbc5bb76a58c5ca4','195602031981031002',NULL,NULL,NULL,'Prof. Dr. Arief Hidayat, S.H., M.S.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(64,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'195508261981031002','d8578edf8458ce06fbc5bb76a58c5ca4','195508261981031002',NULL,NULL,NULL,'Prof. Dr. Yusriyadi, S.H., M.S.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(65,NULL,NULL,NULL,0,0,2,2,0,0,0,0,NULL,NULL,0,NULL,'196204101987031003','d8578edf8458ce06fbc5bb76a58c5ca4','196204101987031003',NULL,NULL,NULL,'Prof. Dr. R. Benny Riyanto, S.H., M.Hum, C.N.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(66,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'195309021986032001','d8578edf8458ce06fbc5bb76a58c5ca4','195309021986032001',NULL,NULL,NULL,'Prof. Erlyn Indarti, S.H., M.A., Ph.D.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(67,NULL,NULL,NULL,0,0,2,2,0,0,0,0,NULL,NULL,0,NULL,'196201181987031002','d8578edf8458ce06fbc5bb76a58c5ca4','196201181987031002',NULL,NULL,NULL,'Prof. Dr. F.X. Adji Samekto, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(68,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196211101987031004','d8578edf8458ce06fbc5bb76a58c5ca4','196211101987031004',NULL,NULL,NULL,'Prof. Dr. Yos Johan Utama, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(69,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196110051986031002','d8578edf8458ce06fbc5bb76a58c5ca4','196110051986031002',NULL,NULL,NULL,'Prof.Dr. Budi Santoso, S.H., M.S.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(70,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196205151987031001','d8578edf8458ce06fbc5bb76a58c5ca4','196205151987031001',NULL,NULL,NULL,'Prof. Dr. Lazarus Tri Setyawanta Rebala, S.H., M.H',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(71,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'197002021994031001','d8578edf8458ce06fbc5bb76a58c5ca4','197002021994031001',NULL,NULL,NULL,'Prof.Dr. Suteki, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(72,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196205051986032001','d8578edf8458ce06fbc5bb76a58c5ca4','196205051986032001',NULL,NULL,NULL,'Prof.Dr. Rahayu, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(73,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'195109151977031001','d8578edf8458ce06fbc5bb76a58c5ca4','195109151977031001',NULL,NULL,NULL,'Prof. Dr. Achmad Busro, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(74,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196711191993032002','d8578edf8458ce06fbc5bb76a58c5ca4','196711191993032002',NULL,NULL,NULL,'Prof. Dr. Retno Saraswati, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(75,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196308221990011001','d8578edf8458ce06fbc5bb76a58c5ca4','196308221990011001',NULL,NULL,NULL,'Prof. Dr. Pujiyono, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(76,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196606071992031001','d8578edf8458ce06fbc5bb76a58c5ca4','196606071992031001',NULL,NULL,NULL,'Dr. Joko Setiyono, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(77,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'198303202008122002','d8578edf8458ce06fbc5bb76a58c5ca4','198303202008122002',NULL,NULL,NULL,'Dr. Ratna Herawati, S.H., M.H.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(78,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196212091987031001','d8578edf8458ce06fbc5bb76a58c5ca4','196212091987031001',NULL,NULL,NULL,'Dr. Bambang Eko Turisno, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(79,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196009261986032001','d8578edf8458ce06fbc5bb76a58c5ca4','196009261986032001',NULL,NULL,NULL,'Dr. Lita Tyesta Addy Listya Wardhani, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(80,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196202241987031001','d8578edf8458ce06fbc5bb76a58c5ca4','196202241987031001',NULL,NULL,NULL,'Prof. Dr. Joko Priyono, S.H., M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(81,NULL,NULL,NULL,0,0,1,2,0,0,0,0,NULL,NULL,0,NULL,'196212081987031001','d8578edf8458ce06fbc5bb76a58c5ca4','196212081987031001',NULL,NULL,NULL,'Dr. Budi Ispriyarso, S.H, M.Hum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1),
	(84,1,NULL,NULL,7,2,NULL,1,0,0,0,0,NULL,NULL,0,NULL,'12345678901234','100416b93d34d3482c47a7f06ca50f29','12345678901234',NULL,NULL,NULL,'Erwin gutawa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-11-20 23:56:25',NULL,NULL,0,1);

/*!40000 ALTER TABLE `peg_pegawai` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pegawai_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pegawai_role`;

CREATE TABLE `pegawai_role` (
  `id_peg_role` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_role` int(3) NOT NULL,
  PRIMARY KEY (`id_peg_role`),
  KEY `id_pegawai` (`id_pegawai`,`id_role`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pegawai_role` WRITE;
/*!40000 ALTER TABLE `pegawai_role` DISABLE KEYS */;

INSERT INTO `pegawai_role` (`id_peg_role`, `id_pegawai`, `id_role`)
VALUES
	(77,1,5),
	(78,1,8),
	(28,2,1),
	(76,3,2),
	(11,4,3),
	(16,5,4),
	(29,6,9),
	(44,6,9),
	(19,7,7),
	(23,10,7),
	(30,13,9),
	(45,13,9),
	(32,14,9),
	(41,14,9),
	(42,14,9),
	(43,14,9),
	(47,14,9),
	(48,14,9),
	(49,14,9),
	(34,16,9),
	(35,19,9),
	(36,20,9),
	(37,21,9),
	(38,22,9),
	(39,23,9),
	(40,24,9),
	(46,24,9),
	(50,29,9),
	(52,29,9),
	(51,33,9),
	(53,33,9),
	(55,34,9),
	(56,35,9),
	(57,36,9),
	(58,37,9),
	(59,38,9),
	(60,39,9),
	(61,40,9),
	(62,41,9),
	(63,42,9),
	(64,43,9),
	(65,44,9),
	(66,45,9),
	(67,46,9),
	(68,47,9),
	(69,48,9),
	(70,49,9),
	(71,50,9),
	(72,51,9),
	(73,52,9),
	(74,53,9),
	(75,54,9),
	(79,82,9),
	(80,83,9),
	(81,84,9),
	(82,84,9),
	(83,85,1);

/*!40000 ALTER TABLE `pegawai_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pendaftaran_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pendaftaran_tesis`;

CREATE TABLE `pendaftaran_tesis` (
  `id_pendaftaran_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mhs` varchar(255) NOT NULL,
  `nim` int(100) NOT NULL,
  `judul_tesis` varchar(250) NOT NULL,
  `program_studi` varchar(250) NOT NULL,
  `v_akademik` int(11) NOT NULL,
  `v_perpus` int(11) NOT NULL,
  `v_keuangan` int(11) NOT NULL,
  `v_pimpinan` int(11) NOT NULL,
  PRIMARY KEY (`id_pendaftaran_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table pengajuan_judul
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pengajuan_judul`;

CREATE TABLE `pengajuan_judul` (
  `id_pengajuan_judul` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_semester` int(11) NOT NULL,
  `id_periode_pu` int(11) DEFAULT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_pembimbing_1` int(11) DEFAULT NULL,
  `id_pemb_1` int(11) DEFAULT NULL,
  `id_pembimbing_2` int(11) DEFAULT NULL,
  `id_pemb_2` int(11) DEFAULT NULL,
  `judul_tesis` text NOT NULL,
  `id_ref_program_konsentrasi` int(11) NOT NULL,
  `tgl_pj` date NOT NULL,
  `status_pj` int(1) DEFAULT NULL,
  `status_tesis` int(1) NOT NULL,
  `status_n_pj` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_judul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `pengajuan_judul` WRITE;
/*!40000 ALTER TABLE `pengajuan_judul` DISABLE KEYS */;

INSERT INTO `pengajuan_judul` (`id_pengajuan_judul`, `id_ref_semester`, `id_periode_pu`, `id_mahasiswa`, `id_pembimbing_1`, `id_pemb_1`, `id_pembimbing_2`, `id_pemb_2`, `judul_tesis`, `id_ref_program_konsentrasi`, `tgl_pj`, `status_pj`, `status_tesis`, `status_n_pj`)
VALUES
	(1,7,6,36,NULL,NULL,NULL,NULL,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,'2020-11-26',1,0,1),
	(2,7,6,48,NULL,NULL,NULL,NULL,'BUKTI ELEKTRONIK DALAM KEJAHATAN KOMPUTER KAJIAN ATAS TINDAK PIDANA KORUPSI DAN PEMBAHARUAN HUKUM PIDANA INDONESIA',0,'2020-11-26',NULL,0,NULL),
	(3,7,6,52,NULL,NULL,NULL,NULL,'EFEKTIVITAS PENEGAKAN HUKUM LINGKUNGAN (STUDI KASUS PENEGAKAN HUKUM PIDANA TERHADAP PT. MENARA JAYA DAN UD. KURNIA DI JAKARTA TIMUR)',0,'2020-11-26',NULL,0,NULL),
	(4,7,7,34,NULL,NULL,NULL,NULL,'LATIHAN SEMINAR HUKUM',0,'2020-12-15',1,0,1),
	(5,7,2,37,NULL,NULL,NULL,NULL,'TES JUDUL SAYA',0,'2021-01-11',NULL,0,NULL);

/*!40000 ALTER TABLE `pengajuan_judul` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table penguji_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `penguji_tesis`;

CREATE TABLE `penguji_tesis` (
  `id_penguji_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_dosen` int(11) NOT NULL,
  `id_pendaftaran_tesis` int(11) NOT NULL,
  PRIMARY KEY (`id_penguji_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table periode_pu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `periode_pu`;

CREATE TABLE `periode_pu` (
  `id_periode_pu` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_semester` int(11) NOT NULL,
  `bulan` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` int(1) NOT NULL,
  `urut` int(1) NOT NULL,
  PRIMARY KEY (`id_periode_pu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `periode_pu` WRITE;
/*!40000 ALTER TABLE `periode_pu` DISABLE KEYS */;

INSERT INTO `periode_pu` (`id_periode_pu`, `id_ref_semester`, `bulan`, `start_date`, `end_date`, `status`, `urut`)
VALUES
	(1,7,'Oktober','2020-10-01','2020-10-31',0,1),
	(2,7,'Januari','2021-01-01','2021-01-31',0,2),
	(3,8,'April','2021-04-01','2021-04-30',0,3),
	(4,8,'Juli','2021-07-01','2021-07-31',0,4),
	(6,7,'November','2020-11-01','2020-11-30',0,5),
	(7,7,'Desember','2020-12-01','2020-12-30',0,6);

/*!40000 ALTER TABLE `periode_pu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table proposal_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proposal_tesis`;

CREATE TABLE `proposal_tesis` (
  `id_proposal_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_semester` int(11) NOT NULL,
  `id_periode_pu` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_penguji_1` int(11) DEFAULT NULL,
  `id_pemb_1` int(11) DEFAULT NULL,
  `id_penguji_2` int(11) DEFAULT NULL,
  `id_pemb_2` int(11) DEFAULT NULL,
  `judul_tesis` text NOT NULL,
  `id_ref_program_konsentrasi` int(11) NOT NULL,
  `tgl_pt` date NOT NULL,
  `status_pt` int(1) DEFAULT NULL,
  `status_n_pt` int(11) NOT NULL,
  PRIMARY KEY (`id_proposal_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `proposal_tesis` WRITE;
/*!40000 ALTER TABLE `proposal_tesis` DISABLE KEYS */;

INSERT INTO `proposal_tesis` (`id_proposal_tesis`, `id_ref_semester`, `id_periode_pu`, `id_mahasiswa`, `id_penguji_1`, `id_pemb_1`, `id_penguji_2`, `id_pemb_2`, `judul_tesis`, `id_ref_program_konsentrasi`, `tgl_pt`, `status_pt`, `status_n_pt`)
VALUES
	(1,7,6,36,NULL,NULL,NULL,NULL,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,'2020-11-26',1,1),
	(2,7,7,34,NULL,NULL,NULL,NULL,'LATIHAN SEMINAR HUKUM',0,'2020-12-15',NULL,1);

/*!40000 ALTER TABLE `proposal_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_aplikasi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_aplikasi`;

CREATE TABLE `ref_aplikasi` (
  `id_aplikasi` int(1) NOT NULL AUTO_INCREMENT,
  `id_par_aplikasi` int(1) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `kode_aplikasi` varchar(15) NOT NULL,
  `nama_aplikasi` varchar(50) NOT NULL,
  `deskripsi` varchar(80) DEFAULT NULL,
  `folder` varchar(30) DEFAULT NULL,
  `warna` varchar(7) DEFAULT NULL,
  `aktif` int(11) NOT NULL,
  PRIMARY KEY (`id_aplikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ref_aplikasi` WRITE;
/*!40000 ALTER TABLE `ref_aplikasi` DISABLE KEYS */;

INSERT INTO `ref_aplikasi` (`id_aplikasi`, `id_par_aplikasi`, `urut`, `kode_aplikasi`, `nama_aplikasi`, `deskripsi`, `folder`, `warna`, `aktif`)
VALUES
	(1,NULL,1,'ot','tigris','Online Thesis Registration','tigris','#42708e',1);

/*!40000 ALTER TABLE `ref_aplikasi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_bidang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_bidang`;

CREATE TABLE `ref_bidang` (
  `id_bidang` int(11) NOT NULL AUTO_INCREMENT,
  `id_par_bidang` int(11) DEFAULT NULL,
  `id_unit` int(11) unsigned NOT NULL,
  `penetapan` date DEFAULT NULL,
  `kode_bidang` varchar(20) DEFAULT NULL,
  `nama_bidang` varchar(80) NOT NULL,
  `urut` int(1) NOT NULL,
  `level` int(1) DEFAULT NULL,
  `pos_x` int(3) DEFAULT NULL,
  `pos_y` int(3) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_bidang`),
  KEY `id_par_bidang` (`id_par_bidang`,`id_unit`),
  KEY `id_subunit` (`id_unit`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ref_bidang` WRITE;
/*!40000 ALTER TABLE `ref_bidang` DISABLE KEYS */;

INSERT INTO `ref_bidang` (`id_bidang`, `id_par_bidang`, `id_unit`, `penetapan`, `kode_bidang`, `nama_bidang`, `urut`, `level`, `pos_x`, `pos_y`, `status`, `aktif`)
VALUES
	(1,NULL,1,NULL,'MH','Magister Hukum',1,NULL,NULL,NULL,NULL,NULL),
	(2,1,1,NULL,'AK','Akademik',1,NULL,NULL,NULL,NULL,NULL),
	(3,1,1,NULL,'PER','Perpustakaan',2,NULL,NULL,NULL,NULL,NULL),
	(4,1,1,NULL,'KEU','Keuangan',3,NULL,NULL,NULL,NULL,NULL),
	(5,1,1,NULL,'PIM','Kaprodi',4,NULL,NULL,NULL,NULL,NULL),
	(6,1,1,NULL,'SEK','Sek Prodi',5,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `ref_bidang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_pengajuan_judul
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_pengajuan_judul`;

CREATE TABLE `ref_pengajuan_judul` (
  `id_ref_pengajuan_judul` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_tipe_field` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `nama_syarat` varchar(250) NOT NULL,
  `keterangan_pengajuan_judul` varchar(250) NOT NULL,
  `wajib_isi_mhs` int(11) DEFAULT NULL,
  `wajib_isi_bidang` int(11) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_ref_pengajuan_judul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_pengajuan_judul` WRITE;
/*!40000 ALTER TABLE `ref_pengajuan_judul` DISABLE KEYS */;

INSERT INTO `ref_pengajuan_judul` (`id_ref_pengajuan_judul`, `id_ref_tipe_field`, `id_bidang`, `nama_syarat`, `keterangan_pengajuan_judul`, `wajib_isi_mhs`, `wajib_isi_bidang`, `urut`, `status`)
VALUES
	(1,2,2,'Telah menyelesaikan Mata Kuliah Semester 1 dan Semester 2\r\nsebanyak minimal 36 SKS. ','Silahkan upload file',1,NULL,7,1),
	(2,2,2,'Telah HER Registrasi dan IRS melalui SSO, serta Print IRS\r\ndengan isian Mata Kuliah TESIS. ','Silahkan upload file',1,NULL,8,1),
	(3,2,4,'SURAT KETERANGAN Bebas Administrasi KEUANGAN\r\nPengajuan Judul Tesis, dari Bagian Keuangan PSMIH. ','Telah melakukan pembayaran SPP',NULL,NULL,9,1),
	(5,1,2,'Mengisi Form PENETAPAN DOSEN PEMBIMBING dan\r\ndiajukan ke Ketua Program Studi Magister Ilmu Hukum, FH\r\nUNDIP.','Silahkan isi form dan upload berkas yang sudah di tandatangani ketua prodi',1,NULL,12,1),
	(6,2,4,'Telah mengikuti MATRIKULASI, dibuktikan dengan FC\r\nSertifikat.','Silahkan upload sertifikat',1,NULL,10,1),
	(7,2,3,'JUDUL TESIS telah di setujui oleh Bagian PERPUSTAKAAN PSMIH dan tidak ada kesamaan judul, pembahasan maupun plagiat.','-',NULL,NULL,11,1);

/*!40000 ALTER TABLE `ref_pengajuan_judul` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_prodi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_prodi`;

CREATE TABLE `ref_prodi` (
  `id_ref_prodi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(250) NOT NULL,
  `urut` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_ref_prodi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_prodi` WRITE;
/*!40000 ALTER TABLE `ref_prodi` DISABLE KEYS */;

INSERT INTO `ref_prodi` (`id_ref_prodi`, `nama_prodi`, `urut`, `status`)
VALUES
	(4,'Ilmu Hukum',4,1);

/*!40000 ALTER TABLE `ref_prodi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_program_konsentrasi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_program_konsentrasi`;

CREATE TABLE `ref_program_konsentrasi` (
  `id_ref_program_konsentrasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_program_konsentrasi` varchar(250) NOT NULL,
  `urut` int(1) NOT NULL,
  PRIMARY KEY (`id_ref_program_konsentrasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_program_konsentrasi` WRITE;
/*!40000 ALTER TABLE `ref_program_konsentrasi` DISABLE KEYS */;

INSERT INTO `ref_program_konsentrasi` (`id_ref_program_konsentrasi`, `nama_program_konsentrasi`, `urut`)
VALUES
	(1,'Reguler A - Pembaharuan Hukum Pidana',1),
	(2,'Reguler A - Hukum Ekonomi dan Bisnis',2),
	(3,'Reguler A - Hukum Kenegaraan',3),
	(4,'Reguler A - Hukum Internasional',4),
	(5,'Reguler B',5),
	(6,'Reguler by Research',6);

/*!40000 ALTER TABLE `ref_program_konsentrasi` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_proposal_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_proposal_tesis`;

CREATE TABLE `ref_proposal_tesis` (
  `id_ref_proposal_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_tipe_field` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `nama_syarat` varchar(250) NOT NULL,
  `keterangan_proposal_tesis` varchar(250) NOT NULL,
  `wajib_isi` int(11) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_ref_proposal_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_proposal_tesis` WRITE;
/*!40000 ALTER TABLE `ref_proposal_tesis` DISABLE KEYS */;

INSERT INTO `ref_proposal_tesis` (`id_ref_proposal_tesis`, `id_ref_tipe_field`, `id_bidang`, `nama_syarat`, `keterangan_proposal_tesis`, `wajib_isi`, `urut`, `status`)
VALUES
	(1,1,2,'PROPOSAL TESIS telah di tanda tangani oleh Dosen\r\nPembimbing dan Ketua Program Studi Magister Ilmu Hukum,\r\nFH UNDIP. ','Siapkan berkas yang diperlukan',1,4,1),
	(2,2,2,'Foto Copy (FC) KTM (Kartu Mahasiswa), Foto Copy Penetapan\r\nDosen Pembimbing dan FC Bimbingan Tesis.','Siapkan berkas yang diperlukan',1,7,1),
	(3,2,2,'Foto Copy Sertifikat TOEFL dari SEU UNDIP, dengan skor min.\r\n475','Siapkan berkas yang diperlukan',1,9,1),
	(4,1,2,'Naskah PROPOSAL TESIS telah dijilid Soft Cover Lem warna\r\nHIJAU, dengan ketentuan : \r\n1. Naskah Proposal Tesis dibuat rangkap 4 (empat), jika hanya 1\r\n(satu) Dosen Pembimbing. \r\n2. Naskah Proposal Tesis dibuat rangkap 5 (lima), jika ada 2\r\n(dua) Dose','Siapkan berkas yang diperlukan',1,12,1),
	(5,2,4,'SURAT KETERANGAN Bebas Administrasi KEUANGAN untuk\r\nUjian Review Proposal Tesis, dari Bagian Keuangan PSMIH Undip.','Telah melakukan pembayaran SPP',NULL,13,1),
	(6,1,3,'Mengisi Form Instrument Monitoring Proposal Tesis, sebelum\r\nmengajukan Tanda Tangan Pengesahan ke Ketua Program.','Membawa form yang sudah di isi dan di tandatangani',1,14,1),
	(7,2,3,'SUBMIT di Open Journal System &#40;OJS&#41;, Terakreditasi Min. SINTA\r\n3, dibuktikan dengan hasil cetak/print balasan email. ','upload hasil balasan email',1,15,1),
	(8,2,3,'Turnitin Proposal','Cek Turnitin ke Perpustakaan dengan hasil turnitin maksimal 30%',NULL,16,1);

/*!40000 ALTER TABLE `ref_proposal_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_role`;

CREATE TABLE `ref_role` (
  `id_role` int(3) NOT NULL AUTO_INCREMENT,
  `id_aplikasi` int(1) NOT NULL,
  `nama_role` varchar(80) NOT NULL,
  PRIMARY KEY (`id_role`),
  KEY `id_aplikasi` (`id_aplikasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ref_role` WRITE;
/*!40000 ALTER TABLE `ref_role` DISABLE KEYS */;

INSERT INTO `ref_role` (`id_role`, `id_aplikasi`, `nama_role`)
VALUES
	(1,1,'Verivikator Akademik'),
	(2,1,'Verivikator Perpustakaan'),
	(3,1,'Verivikator Keuangan'),
	(4,1,'Verivikator Pimpinan'),
	(5,1,'Operator Penjadwalan Ujian'),
	(8,1,'Superadmin'),
	(9,1,'Mahasiswa');

/*!40000 ALTER TABLE `ref_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_role_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_role_nav`;

CREATE TABLE `ref_role_nav` (
  `id_role_nav` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_nav` int(11) NOT NULL,
  PRIMARY KEY (`id_role_nav`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ref_role_nav` WRITE;
/*!40000 ALTER TABLE `ref_role_nav` DISABLE KEYS */;

INSERT INTO `ref_role_nav` (`id_role_nav`, `id_role`, `id_nav`)
VALUES
	(73,2,26),
	(74,2,18),
	(75,2,7),
	(76,2,22),
	(77,2,23),
	(78,2,24),
	(194,9,31),
	(195,9,18),
	(196,9,7),
	(197,9,22),
	(198,9,23),
	(199,9,24),
	(200,3,27),
	(201,3,18),
	(202,3,7),
	(203,3,22),
	(204,3,23),
	(205,3,24),
	(362,4,28),
	(363,4,18),
	(364,4,7),
	(365,4,22),
	(366,4,23),
	(367,4,24),
	(368,4,6),
	(575,1,25),
	(576,1,17),
	(577,1,18),
	(578,1,7),
	(579,1,22),
	(580,1,23),
	(581,1,24),
	(636,5,8),
	(637,5,1),
	(638,5,19),
	(639,5,20),
	(640,5,21),
	(641,5,2),
	(642,5,11),
	(643,5,29),
	(644,5,30),
	(645,5,39),
	(646,5,9),
	(647,5,10),
	(648,5,40),
	(649,5,17),
	(650,5,3),
	(651,5,18),
	(652,5,38),
	(653,5,7),
	(654,5,22),
	(655,5,23),
	(656,5,24),
	(657,5,4),
	(658,5,32),
	(659,5,33),
	(660,5,34),
	(661,5,6),
	(662,5,37),
	(663,5,36),
	(664,8,8),
	(665,8,1),
	(666,8,19),
	(667,8,20),
	(668,8,21),
	(669,8,2),
	(670,8,11),
	(671,8,29),
	(672,8,30),
	(673,8,39),
	(674,8,9),
	(675,8,10),
	(676,8,40),
	(677,8,17),
	(678,8,3),
	(679,8,18),
	(680,8,38),
	(681,8,7),
	(682,8,22),
	(683,8,23),
	(684,8,24),
	(685,8,4),
	(686,8,32),
	(687,8,33),
	(688,8,34),
	(689,8,6),
	(690,8,37),
	(691,8,36);

/*!40000 ALTER TABLE `ref_role_nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_role_unit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_role_unit`;

CREATE TABLE `ref_role_unit` (
  `id_role_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(3) NOT NULL,
  `id_unit` int(11) NOT NULL,
  PRIMARY KEY (`id_role_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ref_semester
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_semester`;

CREATE TABLE `ref_semester` (
  `id_ref_semester` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_tahun` int(11) NOT NULL,
  `nama_semester` varchar(100) NOT NULL,
  `urut` int(1) NOT NULL,
  PRIMARY KEY (`id_ref_semester`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_semester` WRITE;
/*!40000 ALTER TABLE `ref_semester` DISABLE KEYS */;

INSERT INTO `ref_semester` (`id_ref_semester`, `id_ref_tahun`, `nama_semester`, `urut`)
VALUES
	(1,4,'1 (Ganjil) 2017/2018',1),
	(2,3,'2 (Genap) 2017/2018 ',2),
	(3,3,'1 (Ganjil) 2018/2019',3),
	(4,1,'2 (Genap) 2018/2019',4),
	(5,1,'1 (Ganjil) 2019/2020',5),
	(6,2,'2 (Genap) 2019/2020',6),
	(7,2,'1 (Ganjil) 2020/2021',7),
	(8,5,'2 (Genap) 2020/2021',8),
	(9,5,'1 (Ganjil) 2021/2022',9),
	(10,6,'2 (Genap) 2021/2022',10),
	(11,6,'1 (Ganjil) 2022/2023',11);

/*!40000 ALTER TABLE `ref_semester` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_seminar_hp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_seminar_hp`;

CREATE TABLE `ref_seminar_hp` (
  `id_ref_seminar_hp` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_tipe_field` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `nama_syarat` varchar(250) NOT NULL,
  `keterangan_seminar_hp` varchar(250) NOT NULL,
  `wajib_isi` int(11) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_ref_seminar_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_seminar_hp` WRITE;
/*!40000 ALTER TABLE `ref_seminar_hp` DISABLE KEYS */;

INSERT INTO `ref_seminar_hp` (`id_ref_seminar_hp`, `id_ref_tipe_field`, `id_bidang`, `nama_syarat`, `keterangan_seminar_hp`, `wajib_isi`, `urut`, `status`)
VALUES
	(1,1,2,'Paper SHP TESIS BAB I, II dan III dengan ketentuan Bab I &\r\nBab II max. 10 halaman dan untuk Bab III max. 40 halaman, telah dijilid Soft Cover Lem warna BIRU, dengan ketentuan : \r\n1. Naskah SHP Tesis dibuat rangkap 3 (tiga), jika Dosen\r\nPembimbing ha','Silahakan membawa berkas yang di butuhkan',1,1,1),
	(2,1,2,'Telah mengkonfirmasi Dosen Pembimbing, pada pelaksanaan\r\njadwal SHP yang telah terjadwal, harus bisa hadir sesuai jadwal. ','bukti konfirmasi pembimbing',1,2,1),
	(3,1,2,'FC KTM (Kartu Mahasiswa) sebanyak 1 (satu) lembar. ','Bawa FC KTM',1,3,1),
	(4,1,2,'Menyerahkan FC Penetapan Dosen Pembimbing. ','-',1,4,1),
	(5,1,2,'Menyerahkan PPT SHP dibuat max. 9 Slide (LB 1 Slide, PM 1\r\nSlide, Teori 1 Slide, Metode 1 Slide dan Hasil Penelitian 6 Slide)\r\ndan dibuat rangkap 5 (lima) untuk peserta SHP. ','Membawa berkas yang di butuhkan',1,5,1),
	(6,2,3,'Menyerahkan HASIL TURNITIN Paper SHP Tesis (Bab 1 – Bab\r\n3) ','Membawa Berkas Hasil TURNITIN dengan nilai maksimal 30%',1,6,1),
	(7,2,4,'SURAT KETERANGAN Bebas Administrasi KEUANGAN\r\nUjian SHP Tesis, dari Bagian Keuangan PSMIH. ','Telah melakukan pembayaran SPP',NULL,7,1);

/*!40000 ALTER TABLE `ref_seminar_hp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_tahun
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_tahun`;

CREATE TABLE `ref_tahun` (
  `id_ref_tahun` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tahun` int(5) NOT NULL,
  `urut` int(1) NOT NULL,
  `ujian` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_ref_tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_tahun` WRITE;
/*!40000 ALTER TABLE `ref_tahun` DISABLE KEYS */;

INSERT INTO `ref_tahun` (`id_ref_tahun`, `nama_tahun`, `urut`, `ujian`, `status`)
VALUES
	(1,2019,3,1,NULL),
	(2,2020,2,NULL,NULL),
	(3,2018,1,1,NULL),
	(4,2017,4,1,NULL),
	(5,2021,5,NULL,NULL),
	(6,2022,6,NULL,NULL);

/*!40000 ALTER TABLE `ref_tahun` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_tesis`;

CREATE TABLE `ref_tesis` (
  `id_ref_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_tipe_field` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `nama_syarat` varchar(250) NOT NULL,
  `keterangan_tesis` varchar(250) NOT NULL,
  `waib_isi` int(11) DEFAULT NULL,
  `urut` int(1) NOT NULL,
  `status` int(11) NOT NULL,
  `wajib_isi` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_ref_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_tesis` WRITE;
/*!40000 ALTER TABLE `ref_tesis` DISABLE KEYS */;

INSERT INTO `ref_tesis` (`id_ref_tesis`, `id_ref_tipe_field`, `id_bidang`, `nama_syarat`, `keterangan_tesis`, `waib_isi`, `urut`, `status`, `wajib_isi`)
VALUES
	(1,1,2,'TESIS telah di tanda tangani oleh Dosen Pembimbing dan Ketua Program PSMIH','bawa Tesis yang sudah di tandatangani',NULL,5,1,1),
	(2,1,2,'Naskah TESIS dijilid Soft Cover Lem warna MERAH, ketentuan: \r\n - Naskah TESIS rangkap 4 (empat) jika Dosen Pembimbing 1\r\n(satu). \r\n- Naskah TESIS rangkap 5 (lima) jika Dosen Pembimbing 2\r\n(dua). ','Membawa TESIS yang sudah dijilid',NULL,6,1,1),
	(3,2,2,'Mengirim FILE REVISI PROPOSAL TESIS melalui E-mail, dengan\r\nalamat E-mail : revisiproposal.mih@gmail.com','Upload file revisi ke email diatas',NULL,7,1,1),
	(4,1,2,'Fotocopi KTM (Kartu Mahasiswa) sebanyak 1 (satu) lembar\r\nMenyerahkan Penetapan Dosen Pembimbing & Bimbingan TESIS','Siapkan berkas yang diperlukan',NULL,9,1,1),
	(5,1,2,'TOEFL dari SEU UNDIP, dengan skor minimal 475. ','Siapkan berkas yang diperlukan',NULL,10,1,1),
	(6,1,2,'Mengikuti sebagai peserta SHP sebanyak 3 kali (Angkatan 2019)','-',NULL,12,1,1),
	(7,1,2,'Mengisi Form TRACER STUDY di web http://mih.undip.ac.id','-',NULL,13,1,1),
	(8,1,2,'Print Out Daftar Kumpulan Nilai yang sudah di tanda tangani oleh\r\nKetua Program PSMIH. (Print Out minta di Bagian Akademik\r\nPSMIH)','Silahkan membawa berkas yang di perlukan',NULL,14,1,1),
	(9,1,3,'Mengisi Form Instrument Monitoring Tesis, sebelum\r\nmengajukan Pengesahan Tanda Tangan Ketua Program PSMIH','silahkan isi form',NULL,15,1,1),
	(10,1,3,'Print Out Hasil Turnitin Tahap I dan Tahap II','nilai hasil turnitin maksimal 30%',NULL,16,1,1),
	(11,1,3,'Menyerahkan jurnal ilmiah yang sudah sesuai Template Jurnal Ilmiah MIH  dalam bentuk Softcover (Bahasa Indonesia & Bahasa Inggis,) dengan warna cover sesuai Program Kajian (PHP= Merah, HEB= Kuning, Kenegaraan= Hijau, Hukum Internasional= Oranye)\r\n\r\nJ','Silahkan menyerahkan 2 buah Jurnal (Indonesia dan Inggris)',NULL,19,1,1),
	(12,2,3,'Mengirimkan file jurnal yang sudah sesuai Template Jurnal Ilmiah MIH  (Bahasa Indonesia & Bahasa Inggris) ke alamat E-mail : jurnalmih.undip@gmail.com','Silahkan mengirimkan soft file ke alamat email',NULL,18,1,1),
	(13,3,3,'PUBLISH di Open Journal System &#40;OJS&#41;, Terakreditasi Min. SINTA\r\n3, dibuktikan dengan link Website OJS nya di SINTA','Silahakan upload link Publish OJS  di SINTA',NULL,20,1,1),
	(14,2,3,'SURAT KETERANGAN Bebas Pinjaman BUKU PUSTAKA, dari : \r\n- Bebas PERPUS PSMIH UNDIP \r\n- Bebas PERPUS Fakultas Hukum UNDIP (PERPUS FH Tembalang) \r\n- Bebas PERPUS UNDIP (UPT Perpustakaan UNDIP Tembalang)','Bebas Perpus MIH, Bebas Perpus FH,  dan Bebas Perpus UPT Pusat file di jadikan satu (1)',NULL,22,1,1),
	(15,1,3,'Menyerahkan sumbangan 2 (dua) buah buku tentang hukum\r\ndengan Judul Buku yang berbeda (List Judul Buku Lihat ke\r\nPERPUSTAKAAN PSMIH) dan Terbitan 5 (lima) tahun terakhir.','Silahkan menyerahkan 2 buah buku sesuai ketentuan',NULL,21,1,1),
	(16,2,4,'SURAT KETERANGAN Bebas Administrasi KEUANGAN, dari\r\nBagian Keuangan PSMIH.','-',NULL,23,1,NULL);

/*!40000 ALTER TABLE `ref_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_tipe_dosen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_tipe_dosen`;

CREATE TABLE `ref_tipe_dosen` (
  `id_ref_tipe_dosen` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_dosen` varchar(100) NOT NULL,
  PRIMARY KEY (`id_ref_tipe_dosen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_tipe_dosen` WRITE;
/*!40000 ALTER TABLE `ref_tipe_dosen` DISABLE KEYS */;

INSERT INTO `ref_tipe_dosen` (`id_ref_tipe_dosen`, `tipe_dosen`)
VALUES
	(1,'aktif'),
	(2,'Luar Biasa');

/*!40000 ALTER TABLE `ref_tipe_dosen` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_tipe_field
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_tipe_field`;

CREATE TABLE `ref_tipe_field` (
  `id_ref_tipe_field` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tipe_field` varchar(20) NOT NULL,
  PRIMARY KEY (`id_ref_tipe_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `ref_tipe_field` WRITE;
/*!40000 ALTER TABLE `ref_tipe_field` DISABLE KEYS */;

INSERT INTO `ref_tipe_field` (`id_ref_tipe_field`, `nama_tipe_field`)
VALUES
	(1,'Hard Copy'),
	(2,'File'),
	(3,'Link');

/*!40000 ALTER TABLE `ref_tipe_field` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_unit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_unit`;

CREATE TABLE `ref_unit` (
  `id_unit` int(11) NOT NULL AUTO_INCREMENT,
  `id_par_unit` int(11) DEFAULT NULL,
  `kode_unit` varchar(20) DEFAULT NULL,
  `unit` varchar(80) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `id_kepala` int(11) DEFAULT NULL,
  `level_unit` int(1) DEFAULT NULL,
  `bso_image` varchar(50) DEFAULT NULL,
  `bso_uu` text,
  `aktif` int(1) NOT NULL,
  `urut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ref_unit` WRITE;
/*!40000 ALTER TABLE `ref_unit` DISABLE KEYS */;

INSERT INTO `ref_unit` (`id_unit`, `id_par_unit`, `kode_unit`, `unit`, `alamat`, `telp`, `id_kepala`, `level_unit`, `bso_image`, `bso_uu`, `aktif`, `urut`)
VALUES
	(1,NULL,'FH','Fakultas Hukum','','',0,1,NULL,NULL,1,1);

/*!40000 ALTER TABLE `ref_unit` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table seminar_hp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seminar_hp`;

CREATE TABLE `seminar_hp` (
  `id_seminar_hp` int(11) NOT NULL AUTO_INCREMENT,
  `id_ref_semester` int(11) DEFAULT NULL,
  `id_periode_pu` int(11) DEFAULT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_penguji_1` int(11) DEFAULT NULL,
  `id_pemb_1` int(11) DEFAULT NULL,
  `id_penguji_2` int(11) DEFAULT NULL,
  `id_pemb_2` int(11) DEFAULT NULL,
  `judul_tesis` text NOT NULL,
  `id_ref_program_konsentrasi` int(11) NOT NULL,
  `tgl_shp` date NOT NULL,
  `status_shp` int(1) DEFAULT NULL,
  `status_n_shp` int(1) NOT NULL,
  PRIMARY KEY (`id_seminar_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `seminar_hp` WRITE;
/*!40000 ALTER TABLE `seminar_hp` DISABLE KEYS */;

INSERT INTO `seminar_hp` (`id_seminar_hp`, `id_ref_semester`, `id_periode_pu`, `id_mahasiswa`, `id_penguji_1`, `id_pemb_1`, `id_penguji_2`, `id_pemb_2`, `judul_tesis`, `id_ref_program_konsentrasi`, `tgl_shp`, `status_shp`, `status_n_shp`)
VALUES
	(1,7,6,36,NULL,NULL,NULL,NULL,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,'2020-11-26',1,1);

/*!40000 ALTER TABLE `seminar_hp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teks`;

CREATE TABLE `teks` (
  `id_teks` int(11) NOT NULL AUTO_INCREMENT,
  `teks` varchar(255) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `urut` int(1) NOT NULL,
  `aktif` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_teks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `teks` WRITE;
/*!40000 ALTER TABLE `teks` DISABLE KEYS */;

INSERT INTO `teks` (`id_teks`, `teks`, `id_pegawai`, `status`, `urut`, `aktif`)
VALUES
	(1,'Selamat datang di Online Registration Tesis',1,1,1,1),
	(2,'Silahkan lihat syarat-syarat dan lengkapi dokumen atau berkas sebelum melakuakan pendaftaran ujian',1,0,2,NULL),
	(3,'Judul Tesis yang diinput harus menggunakan huruf \"KAPITAL\" semua',1,0,3,NULL);

/*!40000 ALTER TABLE `teks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tesis`;

CREATE TABLE `tesis` (
  `id_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_mahasiswa` int(11) NOT NULL,
  `id_ref_semester` int(11) DEFAULT NULL,
  `id_periode_pu` int(11) DEFAULT NULL,
  `id_penguji_1` int(11) DEFAULT NULL,
  `id_pemb_1` int(11) DEFAULT NULL,
  `id_penguji_2` int(11) DEFAULT NULL,
  `id_pemb_2` int(11) DEFAULT NULL,
  `judul_tesis` text NOT NULL,
  `id_ref_program_konsentrasi` int(11) NOT NULL,
  `tgl_t` date NOT NULL,
  `status_t` int(1) DEFAULT NULL,
  `status_n_t` int(1) NOT NULL,
  PRIMARY KEY (`id_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `tesis` WRITE;
/*!40000 ALTER TABLE `tesis` DISABLE KEYS */;

INSERT INTO `tesis` (`id_tesis`, `id_mahasiswa`, `id_ref_semester`, `id_periode_pu`, `id_penguji_1`, `id_pemb_1`, `id_penguji_2`, `id_pemb_2`, `judul_tesis`, `id_ref_program_konsentrasi`, `tgl_t`, `status_t`, `status_n_t`)
VALUES
	(1,36,7,6,NULL,NULL,NULL,NULL,'ANALISIS BUMN PERSERO DITINJAU DARI SUDUT PANDANG DOKTRIN BADAN HUKUM, PRINSIP PENGELOLAAN PERUSAHAAN YANG BAIK, DAN TINDAK PIDANA KORUPSI',0,'2020-11-26',1,1);

/*!40000 ALTER TABLE `tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table theme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `theme`;

CREATE TABLE `theme` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;

INSERT INTO `theme` (`id_theme`, `theme`, `status`)
VALUES
	(1,'2 kolom',1),
	(2,'3 kolom',0);

/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table veri_pengajuan_judul
# ------------------------------------------------------------

DROP TABLE IF EXISTS `veri_pengajuan_judul`;

CREATE TABLE `veri_pengajuan_judul` (
  `id_veri_pengajuan_judul` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengajuan_judul` int(11) NOT NULL,
  `id_ref_pengajuan_judul` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `status_ver` int(1) NOT NULL,
  `catatan` text NOT NULL,
  PRIMARY KEY (`id_veri_pengajuan_judul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `veri_pengajuan_judul` WRITE;
/*!40000 ALTER TABLE `veri_pengajuan_judul` DISABLE KEYS */;

INSERT INTO `veri_pengajuan_judul` (`id_veri_pengajuan_judul`, `id_pengajuan_judul`, `id_ref_pengajuan_judul`, `id_pegawai`, `id_mahasiswa`, `id_bidang`, `status`, `status_ver`, `catatan`)
VALUES
	(1,1,6,0,36,4,1,1,''),
	(2,1,3,0,36,4,1,1,''),
	(3,1,1,0,36,2,1,1,''),
	(4,1,2,0,36,2,1,1,''),
	(7,1,5,0,36,2,1,1,''),
	(8,1,7,0,36,3,1,1,'lanjut coyyy'),
	(9,3,7,0,52,3,1,1,''),
	(10,2,7,0,48,3,1,1,''),
	(11,3,3,0,52,4,1,1,''),
	(12,2,3,0,48,4,1,1,''),
	(13,3,5,0,52,2,1,1,''),
	(14,2,5,0,48,2,1,1,''),
	(15,4,7,0,34,3,1,1,''),
	(16,4,5,0,34,2,1,1,''),
	(17,4,1,0,34,2,1,1,''),
	(18,4,2,0,34,2,1,1,''),
	(19,4,6,0,34,4,1,1,'lanjutkan'),
	(20,4,3,0,34,4,1,1,'lanjutkan');

/*!40000 ALTER TABLE `veri_pengajuan_judul` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table veri_proposal_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `veri_proposal_tesis`;

CREATE TABLE `veri_proposal_tesis` (
  `id_veri_proposal_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_proposal_tesis` int(11) NOT NULL,
  `id_ref_proposal_tesis` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `status_ver` int(11) NOT NULL,
  `catatan` text NOT NULL,
  PRIMARY KEY (`id_veri_proposal_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `veri_proposal_tesis` WRITE;
/*!40000 ALTER TABLE `veri_proposal_tesis` DISABLE KEYS */;

INSERT INTO `veri_proposal_tesis` (`id_veri_proposal_tesis`, `id_proposal_tesis`, `id_ref_proposal_tesis`, `id_pegawai`, `id_mahasiswa`, `id_bidang`, `status`, `status_ver`, `catatan`)
VALUES
	(1,1,1,0,36,2,1,1,''),
	(2,1,4,0,36,2,1,1,''),
	(3,1,2,0,36,2,1,1,''),
	(5,1,6,0,36,3,1,1,''),
	(6,1,7,0,36,3,1,1,''),
	(7,1,8,0,36,3,1,1,''),
	(8,1,3,0,36,2,1,1,''),
	(9,1,5,0,36,4,1,1,'');

/*!40000 ALTER TABLE `veri_proposal_tesis` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table veri_seminar_hp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `veri_seminar_hp`;

CREATE TABLE `veri_seminar_hp` (
  `id_veri_seminar_hp` int(11) NOT NULL AUTO_INCREMENT,
  `id_seminar_hp` int(11) NOT NULL,
  `id_ref_seminar_hp` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `status_ver` int(11) DEFAULT NULL,
  `catatan` text,
  PRIMARY KEY (`id_veri_seminar_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `veri_seminar_hp` WRITE;
/*!40000 ALTER TABLE `veri_seminar_hp` DISABLE KEYS */;

INSERT INTO `veri_seminar_hp` (`id_veri_seminar_hp`, `id_seminar_hp`, `id_ref_seminar_hp`, `id_pegawai`, `id_mahasiswa`, `id_bidang`, `status`, `status_ver`, `catatan`)
VALUES
	(1,1,1,0,36,2,1,1,''),
	(2,1,2,0,36,2,1,1,''),
	(3,1,3,0,36,2,1,1,''),
	(4,1,4,0,36,2,1,1,''),
	(5,1,5,0,36,2,1,1,''),
	(7,1,7,0,36,4,1,1,''),
	(8,1,6,0,36,3,1,1,'okee');

/*!40000 ALTER TABLE `veri_seminar_hp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table veri_tesis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `veri_tesis`;

CREATE TABLE `veri_tesis` (
  `id_veri_tesis` int(11) NOT NULL AUTO_INCREMENT,
  `id_tesis` int(11) NOT NULL,
  `id_ref_tesis` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `status_ver` int(11) DEFAULT NULL,
  `catatan` text NOT NULL,
  PRIMARY KEY (`id_veri_tesis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `veri_tesis` WRITE;
/*!40000 ALTER TABLE `veri_tesis` DISABLE KEYS */;

INSERT INTO `veri_tesis` (`id_veri_tesis`, `id_tesis`, `id_ref_tesis`, `id_pegawai`, `id_mahasiswa`, `id_bidang`, `status`, `status_ver`, `catatan`)
VALUES
	(1,1,1,0,36,2,1,1,''),
	(2,1,2,0,36,2,1,1,''),
	(3,1,4,0,36,2,1,1,''),
	(4,1,5,0,36,2,1,1,''),
	(5,1,6,0,36,2,1,1,''),
	(6,1,7,0,36,2,1,1,''),
	(7,1,8,0,36,2,1,1,''),
	(8,1,3,0,36,2,1,1,''),
	(9,1,16,0,36,4,1,1,''),
	(10,1,9,0,36,3,1,1,''),
	(11,1,10,0,36,3,1,1,''),
	(12,1,11,0,36,3,1,1,''),
	(13,1,12,0,36,3,1,1,''),
	(14,1,13,0,36,3,1,1,''),
	(15,1,14,0,36,3,1,1,''),
	(16,1,15,0,36,3,1,1,'');

/*!40000 ALTER TABLE `veri_tesis` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
