-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2017 at 05:26 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams_native`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disposisi`
--

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `isi_disposisi` mediumtext NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `batas_waktu` date NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_disposisi`
--

INSERT INTO `tbl_disposisi` (`id_disposisi`, `tujuan`, `isi_disposisi`, `sifat`, `batas_waktu`, `catatan`, `id_surat`, `id_user`) VALUES
(2, 'Nur Hafid', 'Segera Koordinasi Pelaksanaan Zakat Fitrah', 'Segera', '2016-06-12', 'Segera Laksanakan', 11, 5),
(3, 'Ani Triastuti, S.E., S.Pd', 'Segera hadiri undangan', 'Penting', '2016-05-17', 'Mohon hadir tepat waktu', 14, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instansi`
--

CREATE TABLE `tbl_instansi` (
  `id_instansi` tinyint(1) NOT NULL,
  `institusi` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `kepsek` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `website` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_instansi`
--

INSERT INTO `tbl_instansi` (`id_instansi`, `institusi`, `nama`, `status`, `alamat`, `kepsek`, `nip`, `website`, `email`, `logo`, `id_user`) VALUES
(1, 'Klan Uchiha', 'Akademi Ninja Konohagakure', 'Chunin', 'Desa Daun Tersembunyi Konohagakure, Negara Api', 'Uchiha Madara', '-', 'http://www.konohagakure.ninja', 'pesan@konohagakure.ninja', 'logo.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_klasifikasi`
--

CREATE TABLE `tbl_klasifikasi` (
  `id_klasifikasi` int(5) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_klasifikasi`
--

INSERT INTO `tbl_klasifikasi` (`id_klasifikasi`, `kode`, `nama`, `uraian`, `id_user`) VALUES
(1, '420', 'PENDIDIKAN', 'PENDIDIKAN', 1),
(2, '420.1', 'Pendidikan Khusus Klasifikasi disini Pendidikan Putra/I Irja', 'Pendidikan Khusus Klasifikasi disini Pendidikan Putra/I Irja', 1),
(3, '421', 'Sekolah', 'Sekolah', 1),
(4, '421.1', 'Pra Sekolah', 'Pra Sekolah', 1),
(5, '421.2', 'Sekolah Dasar', 'Sekolah Dasar', 1),
(6, '421.3', 'Sekolah Menengah', 'Sekolah Menengah', 1),
(7, '421.4', 'Sekolah Tinggi', 'Sekolah Tinggi', 1),
(8, '421.5', 'Sekolah Kejuruan', 'Sekolah Kejuruan', 1),
(9, '421.6', 'Kegiatan Sekolah, Dies Natalis Lustrum', 'Kegiatan Sekolah, Dies Natalis Lustrum', 1),
(10, '421.7', 'Kegiatan Pelajar', 'Kegiatan Pelajar', 1),
(11, '421.71', 'Reuni Darmawisata', 'Reuni Darmawisata', 1),
(12, '421.72', 'Pelajar Teladan', 'Pelajar Teladan', 1),
(13, '421.73', 'Resimen Mahasiswa', 'Resimen Mahasiswa', 1),
(14, '421.8', 'Sekolah Pendidikan Luar Biasa', 'Sekolah Pendidikan Luar Biasa', 1),
(15, '421.9', 'PLS / Pemberantasan Buta Huruf', 'PLS / Pemberantasan Buta Huruf', 1),
(16, '422', 'Administrasi Sekolah', 'Administrasi Sekolah', 1),
(17, '422.1', 'Persyaratan Masuk Sekolah, Testing, Ujian,Pendaftaran, Mapras', 'Persyaratan Masuk Sekolah, Testing, Ujian,Pendaftaran, Mapras', 1),
(18, '422.2', 'Tahun Pelajaran', 'Tahun Pelajaran', 1),
(19, '422.3', 'Hari Libur', 'Hari Libur', 1),
(20, '422.4', 'Uang Sekolah, Klasifikasi Disini SPP', 'Uang Sekolah, Klasifikasi Disini SPP', 1),
(21, '422.5', 'Beasiswa', 'Beasiswa', 1),
(22, '423', 'Metode Belajar', 'Metode Belajar', 1),
(23, '423.1', 'Kuliah', 'Kuliah', 1),
(24, '423.2', 'Ceramah, Simposium', 'Ceramah, Simposium', 1),
(25, '423.3', 'Diskusi', 'Diskusi', 1),
(26, '423.4', 'Kuliah Lapangan, Widyawisata, KKN, Studi Tur', 'Kuliah Lapangan, Widyawisata, KKN, Studi Tur', 1),
(27, '423.5', 'Kurikulum', 'Kurikulum', 1),
(28, '423.6', 'Karya Tulis', 'Karya Tulis', 1),
(29, '423.7', 'Ujian', 'Ujian', 1),
(30, '424', 'Tenaga Pengajar, Guru, Dosen, Dekan, Rektor', 'Tenaga Pengajar, Guru, Dosen, Dekan, Rektor', 1),
(31, '425', 'Sarana Pendidikan', 'Sarana Pendidikan', 1),
(32, '425.1', 'Gedung', 'Gedung', 1),
(33, '425.11', 'Gedung Sekolah', 'Gedung Sekolah', 1),
(34, '425.12', 'Kampus', 'Kampus', 1),
(35, '425.13', 'Pusat Kegiatan Mahasiswa', 'Pusat Kegiatan Mahasiswa', 1),
(36, '425.2', 'Buku', 'Buku', 1),
(37, '425.3', 'Perlengkapan Sekolah', 'Perlengkapan Sekolah', 1),
(38, '426', 'Keolahragaan', 'Keolahragaan', 1),
(39, '426.1', 'Cabang Olah Raga', 'Cabang Olah Raga', 1),
(40, '426.2', 'Sarana', 'Sarana', 1),
(41, '426.21', 'Gedung Olah Raga', 'Gedung Olah Raga', 1),
(42, '426.22', 'Stadion', 'Stadion', 1),
(43, '426.23', 'Lapangan', 'Lapangan', 1),
(44, '426.24', 'Kolam renang', 'Kolam renang', 1),
(45, '426.3', 'Pesta Olah Raga, Klasifikasi nya: PON, Porsade, Olimpiade,', 'Pesta Olah Raga, Klasifikasi nya: PON, Porsade, Olimpiade,', 1),
(46, '426.4', 'KONI', 'KONI', 1),
(47, '427', 'Kepramukaan Meliputi: Organisasi dan Kegiatan Remaja', 'Kepramukaan Meliputi: Organisasi dan Kegiatan Remaja', 1),
(48, '428', 'Kepramukaan', 'Kepramukaan', 1),
(49, '429', 'Pendidikan Kedinasan Untuk Depdagri', 'Pendidikan Kedinasan Untuk Depdagri', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sett`
--

CREATE TABLE `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `surat_masuk` tinyint(2) NOT NULL,
  `surat_keluar` tinyint(2) NOT NULL,
  `referensi` tinyint(2) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sett`
--

INSERT INTO `tbl_sett` (`id_sett`, `surat_masuk`, `surat_keluar`, `referensi`, `id_user`) VALUES
(1, 100, 5, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_keluar`
--

CREATE TABLE `tbl_surat_keluar` (
  `id_surat` int(10) NOT NULL,
  `no_agenda` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_catat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_surat_keluar`
--

INSERT INTO `tbl_surat_keluar` (`id_surat`, `no_agenda`, `tujuan`, `no_surat`, `isi`, `kode`, `tgl_surat`, `tgl_catat`, `file`, `keterangan`, `id_user`) VALUES
(2, 1, 'Siswa', '420 / 015 /SMK.AH/VIII/2015', 'Surat edaran untuk mengikuti kegiatan sholat Idhul Adha di sekolah.', '421.6', '2015-08-28', '2016-07-24', '4718-surat keluar 1.jpg', 'Wajib', 5),
(3, 2, 'Darmaji, S.T. (Guru)', '421 / 056 /SMK-AH / XII /2015', 'Surat tugas untuk menghadiri undangan Penganugerahan Bursa Khusus SMK', '421', '2015-12-07', '2016-07-24', '7773-surat keluar 2.jpg', '-', 5),
(4, 3, 'Siswa', '421/059/SMK-AH/XII/2015', 'Surat edaran pelaksanaan praktik kerja industri (Prakerin)', '421', '2015-12-17', '2016-07-24', '', 'Penting', 5),
(5, 4, 'Guru', '042/067 / SMk-AH/I/2016', 'Surat undangan rapat dinas koordinasi ujian sekolah\r\n', '421', '2016-02-01', '2016-07-24', '', 'Wajib Hadir', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_masuk`
--

CREATE TABLE `tbl_surat_masuk` (
  `id_surat` int(10) NOT NULL,
  `no_agenda` int(10) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_surat_masuk`
--

INSERT INTO `tbl_surat_masuk` (`id_surat`, `no_agenda`, `no_surat`, `asal_surat`, `isi`, `kode`, `indeks`, `tgl_surat`, `tgl_diterima`, `file`, `keterangan`, `id_user`) VALUES
(11, 1, '001/PPH/VI/2016', 'Pondok Pesantren Hidayatullah Nganjuk', 'Permohonan Zakat Fitrah', '421.7', 'A.1', '2016-06-09', '2016-07-24', '601-surat masuk 1.jpg', 'Penting', 5),
(12, 2, '074 / BAZNAZ.JTM / IV / 2016', 'Badan Amil Zakat Nasional Provinsi Jawa Timur', 'Pencairan Dana Bantuan Sebesar Rp. 800.000,- (Delapan Ratus Ribu Rupiah) dari Baznaz.', '422.4', 'A.2', '2016-04-07', '2016-07-24', '7523-surat masuk 2.jpg', 'Penting', 5),
(13, 3, '3 / XI/M.BIG/2016', 'Musyawarah Guru Mata Pelajaran Bahasa Inggris', 'Surat edaran pertemuan rutin musyawarah guru mata pelajaran bahasa inggris.', '420', 'A.3', '2016-04-19', '2016-07-24', '', '-', 5),
(14, 4, '560/402.1/411.203/2016', 'Dinas Sosial Tenaga Kerja Dan Transmigrasi Daerah Kabupaten Nganjuk', 'Surat undangan untuk menghadiri acara Pameran Bursa Kerja Untuk Percepatan Penempatan Tenaga Kerja / Job Fair Tahun 2016', '421', 'A.2', '2016-05-12', '2016-07-24', '', 'Segera laksanakan', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama`, `nip`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'M. Rudianto', '-', 1),
(2, 'disposisi', '13bb8b589473803f26a02e338f949b8c', 'Petugas Disposisi', '-', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  ADD PRIMARY KEY (`id_disposisi`);

--
-- Indexes for table `tbl_instansi`
--
ALTER TABLE `tbl_instansi`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indexes for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `tbl_sett`
--
ALTER TABLE `tbl_sett`
  ADD PRIMARY KEY (`id_sett`);

--
-- Indexes for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  MODIFY `id_disposisi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_klasifikasi`
--
ALTER TABLE `tbl_klasifikasi`
  MODIFY `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  MODIFY `id_surat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
