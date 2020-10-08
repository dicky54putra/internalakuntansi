-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2020 at 09:01 AM
-- Server version: 10.3.23-MariaDB-0+deb10u1
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akunting`
--

-- --------------------------------------------------------

--
-- Table structure for table `akt_akun`
--

CREATE TABLE `akt_akun` (
  `id_akun` int(11) NOT NULL,
  `kode_akun` varchar(200) NOT NULL,
  `nama_akun` varchar(200) NOT NULL,
  `saldo_akun` int(11) NOT NULL,
  `header` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `jenis` int(11) NOT NULL,
  `klasifikasi` int(11) NOT NULL,
  `status_aktif` int(11) NOT NULL,
  `saldo_normal` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_akun`
--

INSERT INTO `akt_akun` (`id_akun`, `kode_akun`, `nama_akun`, `saldo_akun`, `header`, `parent`, `jenis`, `klasifikasi`, `status_aktif`, `saldo_normal`) VALUES
(1, 'AK001', 'kas', 0, 1, 1, 1, 1, 1, 1),
(2, 'AK002', 'Piutang Usaha', 0, 1, 1, 1, 3, 1, 1),
(3, 'AK003', 'Perlengkapan (Barang Habis Pakai)', 0, 1, 1, 1, 1, 1, 1),
(5, 'AK005', 'Kendaraan Mobil', 0, 1, 1, 2, 1, 1, 1),
(6, 'AK006', 'Akumulasi Depresiasi - Mobil', 0, 1, 1, 2, 1, 1, 2),
(7, 'AK007', 'Peralatan Kantor ', 0, 1, 1, 2, 1, 1, 1),
(8, 'AK008', 'Akumulasi Depresiasi - Peralatan Kantor', 0, 1, 1, 2, 1, 1, 2),
(37, 'AK037', 'Piutang Wesel', 0, 1, 1, 1, 4, 1, 1),
(38, 'AK038', 'Uang Muka Pembelian', 0, 1, 1, 1, 7, 1, 1),
(39, 'AK039', 'Tanah', 0, 1, 1, 2, 1, 1, 1),
(40, 'AK040', 'Gedung', 0, 1, 1, 2, 1, 1, 1),
(41, 'AK041', 'Beban Dibayar di Muka', 0, 1, 1, 1, 12, 1, 1),
(42, 'AK042', 'Mesin ', 0, 0, 1, 2, 10, 1, 1),
(43, 'AK043', 'PPH Pasal 21', 0, 1, 1, 8, 23, 1, 2),
(44, 'AK044', 'PPH 25/Final 0,5%', 0, 1, 1, 8, 23, 1, 1),
(45, 'AK045', 'Cadangan Kerugian Piutang', 0, 1, 1, 1, 6, 1, 2),
(46, 'AK046', 'Alat Angkut', 0, 0, 1, 2, 10, 1, 1),
(47, 'AK047', 'Hutang Pengiriman', 0, 1, 1, 5, 13, 1, 2),
(48, 'AK048', 'Cadangan Kerugian Piutang Tak Tertagih', 0, 0, 1, 1, 6, 1, 1),
(49, 'AK049', 'Sewa Dibayar di Muka', 0, 0, 1, 1, 12, 1, 1),
(50, 'AK050', 'Iklan Dibayar di Muka', 0, 0, 1, 1, 12, 1, 1),
(51, 'AK051', 'Asuransi Dibayar di Muka', 0, 0, 1, 1, 12, 1, 1),
(53, 'AK053', 'PPN Masukan', 0, 0, 1, 1, 12, 1, 1),
(54, 'AK054', 'Uang Muka PPH', 0, 0, 1, 1, 12, 1, 1),
(55, 'AK055', 'Akumulasi Penyusutan Bangunan ', 0, 0, 1, 2, 12, 1, 2),
(56, 'AK056', 'Akumulasi Penyusunan Kendaraan ', 0, 0, 1, 2, 12, 1, 2),
(57, 'AK057', 'Akumulasi Penyusutan Mesin ', 0, 0, 1, 2, 12, 1, 2),
(58, 'AK058', 'Hak Paten (Trade Mark)', 0, 0, 1, 3, 11, 1, 1),
(59, 'AK059', 'Hak Cipta ', 0, 1, 1, 3, 11, 1, 1),
(60, 'AK060', 'Goodwill', 0, 0, 1, 3, 11, 1, 1),
(61, 'AK061', 'Merk', 0, 0, 1, 3, 11, 1, 1),
(62, 'AK062', 'Hak Sewa', 0, 0, 1, 3, 11, 1, 1),
(63, 'AK063', 'Franchise', 0, 0, 1, 3, 11, 1, 1),
(64, 'AK064', 'Hutang Usaha ', 0, 0, 1, 6, 16, 1, 2),
(65, 'AK065', 'Hutang Gaji ', 0, 0, 1, 6, 16, 1, 2),
(66, 'AK066', 'Pendapatan  Diterima di Muka', 0, 0, 1, 5, 15, 1, 2),
(67, 'AK067', 'Beban yang Masih Harus Dibayar', 0, 0, 1, 5, 13, 1, 2),
(68, 'AK068', 'Hutang Bank', 0, 1, 1, 6, 16, 1, 2),
(69, 'AK069', 'Wesel Bayar ', 0, 0, 1, 6, 13, 1, 2),
(70, 'AK070', 'Hutang Hipotek', 0, 0, 1, 6, 16, 1, 2),
(71, 'AK071', 'Hutang Obligasi', 0, 0, 1, 6, 16, 1, 2),
(72, 'AK072', 'Hutang Pemegang Saham', 0, 0, 1, 6, 16, 1, 2),
(73, 'AK073', 'PPN Keluaran', 0, 0, 1, 5, 17, 1, 2),
(74, 'AK074', 'Hutang Dividen ', 0, 0, 1, 6, 17, 1, 2),
(75, 'AK075', 'Hutang Lain-Lain', 0, 0, 1, 6, 17, 1, 2),
(76, 'AK076', 'Modal', 0, 0, 1, 7, 18, 1, 2),
(77, 'AK077', 'Prive', 0, 0, 1, 7, 19, 1, 1),
(78, 'AK078', 'Ikhtisar Laba Rugi', 0, 0, 1, 7, 20, 1, 2),
(79, 'AK079', 'Laba Ditahan', 0, 0, 1, 7, 20, 1, 2),
(80, 'AK080', 'Laba Tahun Berjalan', 0, 0, 1, 7, 20, 1, 2),
(81, 'AK081', 'Deviden', 0, 0, 1, 7, 18, 1, 1),
(82, 'AK082', 'Pendapatan ', 0, 0, 1, 4, 21, 1, 2),
(83, 'AK083', 'Beban Angkut Penjualan', 0, 0, 1, 4, 25, 1, 1),
(84, 'AK084', 'Denda Bayar Lambat', 0, 0, 1, 4, 21, 1, 2),
(85, 'AK085', 'Potongan Penjualan', 0, 0, 1, 4, 21, 1, 1),
(86, 'AK086', 'Pendapatan Diluar Usaha', 0, 0, 1, 4, 26, 1, 2),
(87, 'AK087', 'Pendapatan Bunga', 0, 0, 1, 4, 21, 1, 2),
(88, 'AK088', 'Pendapatan Dividen', 0, 0, 1, 4, 21, 1, 2),
(89, 'AK089', 'Pendapatan Lain-lain', 0, 0, 1, 4, 26, 1, 2),
(90, 'AK090', 'Penjualan', 0, 0, 1, 4, 21, 1, 2),
(91, 'AK091', 'Retur Penjualan', 0, 0, 1, 4, 21, 1, 1),
(92, 'AK092', 'Beban BBM', 0, 1, 1, 8, 24, 1, 1),
(93, 'AK093', 'Beban Sewa Kantor', 0, 1, 1, 8, 24, 1, 1),
(94, 'AK094', 'Beban Rental Mobil', 0, 0, 1, 8, 24, 1, 1),
(95, 'AK095', 'Beban Gaji', 0, 1, 1, 8, 24, 1, 1),
(96, 'AK096', 'Beban Listrik, Air, Telepon', 0, 1, 1, 8, 24, 1, 1),
(97, 'AK097', 'Beban Perlengkapan', 0, 0, 1, 8, 24, 1, 1),
(98, 'AK098', 'Beban Iklan', 0, 0, 1, 8, 24, 1, 1),
(99, 'AK099', 'Beban Perbaikan Kendaraan ', 0, 1, 1, 8, 24, 1, 1),
(100, 'AK100', 'Beban Bunga', 0, 1, 1, 8, 24, 1, 1),
(101, 'AK101', 'Beban Asuransi', 0, 1, 1, 8, 24, 1, 1),
(102, 'AK102', 'Beban ATK', 0, 1, 1, 8, 24, 1, 1),
(103, 'AK103', 'Beban Akumulasi Penyusutan Mesin', 0, 1, 1, 8, 24, 1, 1),
(104, 'AK104', 'Beban Akumulasi Penyusutan Bangunan', 0, 1, 1, 8, 25, 1, 1),
(105, 'AK105', 'Beban Akumulasi Penyusutan Peralatan', 0, 1, 1, 8, 25, 1, 1),
(106, 'AK106', 'Beban Akumulasi Penyusutan Kendaraan', 0, 1, 1, 8, 25, 1, 1),
(107, 'AK107', 'Beban Kerugian Piutang', 0, 1, 1, 8, 25, 1, 1),
(108, 'AK108', 'Beban Denda', 0, 1, 1, 8, 25, 1, 1),
(109, 'AK109', 'Beban Pemeliharaan Aset/Mesin/Kendaraan/Gedung/Bangunan', 0, 1, 1, 8, 25, 1, 1),
(110, 'AK110', 'Beban Pajak Penghasilan', 0, 1, 1, 8, 24, 1, 1),
(111, 'AK111', 'Beban Administrasi Bank', 0, 0, 1, 8, 25, 1, 1),
(112, 'AK112', 'Laba Rugi Penjualan Kendaraan', 0, 1, 1, 8, 23, 1, 2),
(113, 'AK113', 'Beban Lain-lain', 0, 1, 1, 8, 23, 1, 1),
(114, 'AK114', 'HPP', 0, 1, 1, 7, 18, 1, 1),
(115, 'AK115', 'Biaya Admin Kantor', 0, 1, 1, 8, 25, 1, 1),
(116, 'AK116', 'Retur Pembelian', 0, 1, 1, 8, 25, 1, 1),
(117, 'AK117', 'Persediaan Barang Dagang', 0, 1, 1, 1, 7, 1, 1),
(118, 'AK118', 'Diskon Penjualan', 0, 1, 1, 7, 18, 1, 1),
(119, 'AK119', 'Saldo Awal Modal ', 0, 0, 1, 7, 18, 1, 2),
(120, 'AK120', 'Saham Biasa', 0, 0, 1, 7, 18, 1, 2),
(121, 'AK121', 'Pembelian Barang', 0, 1, 1, 8, 24, 1, 1),
(122, 'AK122', 'Piutang Pengiriman', 0, 1, 1, 1, 6, 1, 1),
(123, 'AK123', 'Beban Penyusutan Gedung', 0, 1, 1, 8, 23, 1, 1),
(124, 'AK124', 'PPH 23', 0, 1, 1, 8, 23, 1, 1),
(125, 'AK125', 'PPH 22', 0, 1, 1, 8, 23, 1, 2),
(126, 'AK126', 'bunga dibayar dimuka', 0, 1, 1, 1, 12, 1, 1),
(127, 'AK127', 'Gaji dibayar dimuka', 0, 0, 1, 1, 12, 1, 1),
(128, 'AK128', 'Pajak dibayar dimuka', 0, 1, 1, 1, 12, 1, 1),
(129, 'AK129', 'biaya sampel', 0, 1, 1, 8, 23, 1, 1),
(130, 'AK130', 'Bonus Barang', 0, 1, 1, 4, 21, 1, 2),
(131, 'AK131', 'Uang Muka Penjualan', 0, 1, 1, 4, 27, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `akt_approver`
--

CREATE TABLE `akt_approver` (
  `id_approver` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `id_jenis_approver` int(11) NOT NULL,
  `tingkat_approver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_approver`
--

INSERT INTO `akt_approver` (`id_approver`, `id_login`, `id_jenis_approver`, `tingkat_approver`) VALUES
(45, 5, 1, 3),
(46, 6, 1, 2),
(47, 6, 1, 1),
(49, NULL, 2, 1),
(50, NULL, 2, 1),
(51, 11, 3, 1),
(52, NULL, 3, 1),
(53, NULL, 4, 1),
(54, NULL, 4, 1),
(55, NULL, 5, 1),
(56, NULL, 5, 1),
(57, NULL, 6, 1),
(58, NULL, 6, 1),
(59, NULL, 7, 1),
(60, 4, 7, 1),
(61, NULL, 8, 1),
(62, NULL, 8, 1),
(63, NULL, 9, 1),
(64, NULL, 9, 1),
(65, NULL, 10, 2),
(66, NULL, 10, 1),
(67, NULL, 13, 1),
(68, NULL, 13, 1),
(69, 11, 15, 1),
(70, NULL, 15, 1),
(71, 15, 16, 1),
(72, 16, 16, 1),
(73, 4, 17, 1),
(74, NULL, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `akt_bom`
--

CREATE TABLE `akt_bom` (
  `id_bom` int(11) NOT NULL,
  `no_bom` varchar(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tipe` varchar(200) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` double NOT NULL,
  `tanggal_approve` date DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `status_bom` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_bom_detail_bb`
--

CREATE TABLE `akt_bom_detail_bb` (
  `id_bom_detail_bb` int(11) NOT NULL,
  `id_bom` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_bom_detail_hp`
--

CREATE TABLE `akt_bom_detail_hp` (
  `id_bom_hasil_detail_hp` int(11) NOT NULL,
  `id_bom` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_cabang`
--

CREATE TABLE `akt_cabang` (
  `id_cabang` int(11) NOT NULL,
  `kode_cabang` varchar(123) NOT NULL,
  `nama_cabang` varchar(123) NOT NULL,
  `nama_cabang_perusahaan` varchar(123) NOT NULL,
  `alamat` varchar(123) NOT NULL,
  `telp` varchar(123) NOT NULL,
  `fax` varchar(123) NOT NULL,
  `npwp` varchar(123) NOT NULL,
  `pkp` varchar(123) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_foto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_cek_giro`
--

CREATE TABLE `akt_cek_giro` (
  `id_cek_giro` int(11) NOT NULL,
  `no_transaksi` varchar(11) NOT NULL,
  `no_cek_giro` varchar(11) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `tanggal_effektif` date NOT NULL,
  `tipe` int(11) NOT NULL,
  `in_out` int(11) NOT NULL,
  `id_bank_asal` int(11) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `cabang_bank` varchar(20) NOT NULL,
  `tanggal_kliring` date NOT NULL,
  `bank_kliring` varchar(20) NOT NULL,
  `id_penerbit` int(11) NOT NULL,
  `id_penerima` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_credit_card`
--

CREATE TABLE `akt_credit_card` (
  `id_cc` int(11) NOT NULL,
  `kode_cc` varchar(123) NOT NULL,
  `nama_cc` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_departement`
--

CREATE TABLE `akt_departement` (
  `id_departement` int(11) NOT NULL,
  `kode_departement` varchar(123) NOT NULL,
  `nama_departement` varchar(123) NOT NULL,
  `keterangan` text NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_gmb_dua`
--

CREATE TABLE `akt_gmb_dua` (
  `id_gmb_dua` int(11) NOT NULL,
  `kode_gmb_dua` varchar(200) NOT NULL,
  `keterangan_gmb_dua` text NOT NULL,
  `level_gmb_dua` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_gmb_satu`
--

CREATE TABLE `akt_gmb_satu` (
  `id_gmb_satu` int(11) NOT NULL,
  `kode_gmb_satu` varchar(200) NOT NULL,
  `keterangan_gmb_satu` text NOT NULL,
  `level_gmb_satu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_gmb_tiga`
--

CREATE TABLE `akt_gmb_tiga` (
  `id_gmb_tiga` int(11) NOT NULL,
  `kode_gmb_tiga` varchar(200) NOT NULL,
  `keterangan_gmb_tiga` text NOT NULL,
  `level_gmb_tiga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_gudang`
--

CREATE TABLE `akt_gudang` (
  `id_gudang` int(11) NOT NULL,
  `kode_gudang` varchar(200) NOT NULL,
  `nama_gudang` varchar(200) NOT NULL,
  `status_aktif_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_harta_tetap`
--

CREATE TABLE `akt_harta_tetap` (
  `id_harta_tetap` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_kelompok_harta_tetap` int(11) NOT NULL,
  `tipe` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_history_transaksi`
--

CREATE TABLE `akt_history_transaksi` (
  `id_history_transaksi` int(11) NOT NULL,
  `id_tabel` int(11) DEFAULT NULL,
  `id_jurnal_umum` int(11) NOT NULL,
  `nama_tabel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_item`
--

CREATE TABLE `akt_item` (
  `id_item` int(11) NOT NULL,
  `kode_item` varchar(200) NOT NULL,
  `barcode_item` varchar(200) DEFAULT NULL,
  `nama_item` varchar(200) NOT NULL,
  `nama_alias_item` varchar(200) DEFAULT NULL,
  `id_tipe_item` int(11) NOT NULL,
  `id_merk` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `id_mitra_bisnis` int(11) DEFAULT NULL,
  `keterangan_item` text DEFAULT NULL,
  `status_aktif_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_item_harga_jual`
--

CREATE TABLE `akt_item_harga_jual` (
  `id_item_harga_jual` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `id_level_harga` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_item_stok`
--

CREATE TABLE `akt_item_stok` (
  `id_item_stok` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `hpp` int(11) NOT NULL,
  `min` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_item_tipe`
--

CREATE TABLE `akt_item_tipe` (
  `id_tipe_item` int(11) NOT NULL,
  `nama_tipe_item` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_jenis_approver`
--

CREATE TABLE `akt_jenis_approver` (
  `id_jenis_approver` int(11) NOT NULL,
  `nama_jenis_approver` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_jenis_approver`
--

INSERT INTO `akt_jenis_approver` (`id_jenis_approver`, `nama_jenis_approver`) VALUES
(1, 'Pengajuan Biaya'),
(2, 'Permintaan Pembelian'),
(3, 'Order Pembelian'),
(4, 'Pembelian'),
(5, 'Penerimaan Pembelian'),
(6, 'Pembelian Harta Tetap'),
(7, 'Retur Pembelian'),
(8, 'Permintaan Barang'),
(9, 'Bill Of Material'),
(10, 'Produksi Bill Of Material'),
(13, 'Penawaran Penjualan'),
(15, 'Order Penjualan'),
(16, 'Penyesuaian Stok'),
(17, 'Retur Penjualan');

-- --------------------------------------------------------

--
-- Table structure for table `akt_jurnal_umum`
--

CREATE TABLE `akt_jurnal_umum` (
  `id_jurnal_umum` int(11) NOT NULL,
  `no_jurnal_umum` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_jurnal_umum`
--

INSERT INTO `akt_jurnal_umum` (`id_jurnal_umum`, `no_jurnal_umum`, `tanggal`, `tipe`, `keterangan`) VALUES
(6, 'JU2009001', '2020-09-26', 1, 'Set Saldo Awal Akun : SA2009001');

-- --------------------------------------------------------

--
-- Table structure for table `akt_jurnal_umum_detail`
--

CREATE TABLE `akt_jurnal_umum_detail` (
  `id_jurnal_umum_detail` int(11) NOT NULL,
  `id_jurnal_umum` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `debit` int(11) DEFAULT 0,
  `kredit` int(11) DEFAULT 0,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_kas_bank`
--

CREATE TABLE `akt_kas_bank` (
  `id_kas_bank` int(11) NOT NULL,
  `kode_kas_bank` varchar(123) NOT NULL,
  `keterangan` text NOT NULL,
  `jenis` varchar(123) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `saldo` int(11) DEFAULT 0,
  `total_giro_keluar` int(11) DEFAULT 0,
  `id_akun` int(11) DEFAULT 0,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_kas_bank`
--

INSERT INTO `akt_kas_bank` (`id_kas_bank`, `kode_kas_bank`, `keterangan`, `jenis`, `id_mata_uang`, `saldo`, `total_giro_keluar`, `id_akun`, `status_aktif`) VALUES
(1, 'KB001', 'Bank BCA', '2', 1, 0, 0, 1, 1),
(2, 'KB002', 'Kas Utama', '1', 1, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `akt_kelompok_harta_tetap`
--

CREATE TABLE `akt_kelompok_harta_tetap` (
  `id_kelompok_harta_tetap` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `umur_ekonomis` int(11) NOT NULL,
  `metode_depresiasi` int(11) NOT NULL,
  `id_akun_harta` int(11) NOT NULL,
  `id_akun_akumulasi` int(11) NOT NULL,
  `id_akun_depresiasi` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_klasifikasi`
--

CREATE TABLE `akt_klasifikasi` (
  `id_klasifikasi` int(11) NOT NULL,
  `klasifikasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_klasifikasi`
--

INSERT INTO `akt_klasifikasi` (`id_klasifikasi`, `klasifikasi`) VALUES
(1, 'Kas'),
(2, 'Bank'),
(3, 'Piutang Usaha'),
(4, 'Piutang Non Usaha'),
(5, 'Piutang Pajak'),
(6, 'Piutang Lainnya'),
(7, 'Persedian'),
(8, 'Biaya Bayar Di Muka'),
(9, 'Investasi Jangka Panjang'),
(10, 'Harta Tetap Berwujud'),
(11, 'Harta Tetap Tidak Berwujud'),
(12, 'Harta Lainnya'),
(13, 'Hutang Lancar'),
(14, 'Hutang Pajak'),
(15, 'Pendepatan Di Terima Di Muka'),
(16, 'Hutang Jangka Panjang'),
(17, 'Hutang Lainnya'),
(18, 'Modal'),
(19, 'Prive'),
(20, 'Laba'),
(21, 'Pendapatan Usaha'),
(22, 'Biaya Produksi'),
(23, 'Biaya Lain'),
(24, 'Biaya Operasional'),
(25, 'Biaya Non Operasional'),
(26, 'Pendapatan Luar Usaha'),
(27, 'Pengeluaran Luar Usaha');

-- --------------------------------------------------------

--
-- Table structure for table `akt_kota`
--

CREATE TABLE `akt_kota` (
  `id_kota` int(11) NOT NULL,
  `kode_kota` varchar(123) NOT NULL,
  `nama_kota` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_kota`
--

INSERT INTO `akt_kota` (`id_kota`, `kode_kota`, `nama_kota`) VALUES
(1, 'KT001', 'Semarang');

-- --------------------------------------------------------

--
-- Table structure for table `akt_laba_rugi`
--

CREATE TABLE `akt_laba_rugi` (
  `id_laba_rugi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `periode` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `tanggal_approve` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_laba_rugi_detail`
--

CREATE TABLE `akt_laba_rugi_detail` (
  `id_laba_rugi_detail` int(11) NOT NULL,
  `id_laba_rugi` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `saldo_akun` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_laporan_ekuitas`
--

CREATE TABLE `akt_laporan_ekuitas` (
  `id_laporan_ekuitas` int(11) NOT NULL,
  `id_laba_rugi` int(11) NOT NULL,
  `prive` int(20) NOT NULL,
  `modal` int(20) DEFAULT 0,
  `laba_bersih` int(20) NOT NULL,
  `setor_tambahan` int(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_laporan_posisi_keuangan`
--

CREATE TABLE `akt_laporan_posisi_keuangan` (
  `id_laporan_posisi_keuangan` int(11) NOT NULL,
  `id_laba_rugi` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `nominal` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_level_harga`
--

CREATE TABLE `akt_level_harga` (
  `id_level_harga` int(11) NOT NULL,
  `kode_level_harga` varchar(20) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_level_harga`
--

INSERT INTO `akt_level_harga` (`id_level_harga`, `kode_level_harga`, `keterangan`) VALUES
(1, 'LH001', 'Retail'),
(2, 'LH002', 'Grosir'),
(3, 'LH003', 'Reseller');

-- --------------------------------------------------------

--
-- Table structure for table `akt_mata_uang`
--

CREATE TABLE `akt_mata_uang` (
  `id_mata_uang` int(11) NOT NULL,
  `kode_mata_uang` varchar(123) NOT NULL,
  `mata_uang` varchar(123) NOT NULL,
  `simbol` varchar(123) NOT NULL,
  `kurs` varchar(123) NOT NULL,
  `fiskal` varchar(123) NOT NULL,
  `rate_type` varchar(123) NOT NULL,
  `status_default` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_mata_uang`
--

INSERT INTO `akt_mata_uang` (`id_mata_uang`, `kode_mata_uang`, `mata_uang`, `simbol`, `kurs`, `fiskal`, `rate_type`, `status_default`) VALUES
(1, 'IDR', 'Rupiah', 'Rp', '0', '0', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `akt_merk`
--

CREATE TABLE `akt_merk` (
  `id_merk` int(11) NOT NULL,
  `kode_merk` varchar(200) NOT NULL,
  `nama_merk` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_mitra_bisnis`
--

CREATE TABLE `akt_mitra_bisnis` (
  `id_mitra_bisnis` int(11) NOT NULL,
  `kode_mitra_bisnis` varchar(200) NOT NULL,
  `nama_mitra_bisnis` varchar(200) NOT NULL,
  `deskripsi_mitra_bisnis` text DEFAULT NULL,
  `tipe_mitra_bisnis` int(11) NOT NULL,
  `id_gmb_satu` int(11) DEFAULT NULL,
  `id_gmb_dua` int(11) DEFAULT NULL,
  `id_gmb_tiga` int(11) DEFAULT NULL,
  `id_level_harga` int(11) DEFAULT NULL,
  `id_sales` int(11) DEFAULT NULL,
  `status_mitra_bisnis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_mitra_bisnis_alamat`
--

CREATE TABLE `akt_mitra_bisnis_alamat` (
  `id_mitra_bisnis_alamat` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `keterangan_alamat` text NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `telephone` varchar(200) DEFAULT NULL,
  `fax` varchar(200) DEFAULT NULL,
  `kode_pos` varchar(200) DEFAULT NULL,
  `alamat_pengiriman_penagihan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_mitra_bisnis_bank_pajak`
--

CREATE TABLE `akt_mitra_bisnis_bank_pajak` (
  `id_mitra_bisnis_bank_pajak` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `nama_bank` varchar(200) NOT NULL,
  `no_rekening` varchar(200) NOT NULL,
  `atas_nama` varchar(200) NOT NULL,
  `npwp` varchar(200) DEFAULT NULL,
  `pkp` varchar(200) DEFAULT NULL,
  `tanggal_pkp` date DEFAULT NULL,
  `no_nik` varchar(200) DEFAULT NULL,
  `atas_nama_nik` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_mitra_bisnis_kontak`
--

CREATE TABLE `akt_mitra_bisnis_kontak` (
  `id_mitra_bisnis_kontak` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `nama_kontak` varchar(200) NOT NULL,
  `jabatan` varchar(200) DEFAULT NULL,
  `handphone` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_mitra_bisnis_pembelian_penjualan`
--

CREATE TABLE `akt_mitra_bisnis_pembelian_penjualan` (
  `id_mitra_bisnis_pembelian_penjualan` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `termin_pembelian` int(11) NOT NULL,
  `tempo_pembelian` int(11) NOT NULL,
  `termin_penjualan` int(11) NOT NULL,
  `tempo_penjualan` int(11) NOT NULL,
  `batas_hutang` varchar(200) NOT NULL,
  `batas_frekuensi_hutang` varchar(200) NOT NULL,
  `id_akun_hutang` int(11) NOT NULL,
  `batas_piutang` varchar(200) NOT NULL,
  `batas_frekuensi_piutang` varchar(200) NOT NULL,
  `id_akun_piutang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pajak`
--

CREATE TABLE `akt_pajak` (
  `id_pajak` int(11) NOT NULL,
  `kode_pajak` varchar(20) NOT NULL,
  `nama_pajak` varchar(100) NOT NULL,
  `id_akun_pembelian` int(11) NOT NULL,
  `id_akun_penjualan` int(11) NOT NULL,
  `presentasi_npwp` varchar(100) NOT NULL,
  `presentasi_non_npwp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_pajak`
--

INSERT INTO `akt_pajak` (`id_pajak`, `kode_pajak`, `nama_pajak`, `id_akun_pembelian`, `id_akun_penjualan`, `presentasi_npwp`, `presentasi_non_npwp`) VALUES
(2, 'PJ001', 'PPN', 1, 1, '1234567890', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `akt_pegawai`
--

CREATE TABLE `akt_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `kode_pegawai` varchar(20) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `kode_pos` varchar(20) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `handphone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_aktif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembayaran_biaya`
--

CREATE TABLE `akt_pembayaran_biaya` (
  `id_pembayaran_biaya` int(11) NOT NULL,
  `tanggal_pembayaran_biaya` date NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `cara_bayar` int(11) NOT NULL,
  `id_kas_bank` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembelian`
--

CREATE TABLE `akt_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `no_order_pembelian` varchar(255) NOT NULL,
  `tanggal_order_pembelian` date NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_sales` int(11) DEFAULT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `no_pembelian` varchar(255) DEFAULT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `no_faktur_pembelian` varchar(255) DEFAULT NULL,
  `tanggal_faktur_pembelian` date DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `pajak` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `jenis_bayar` int(11) DEFAULT NULL,
  `jatuh_tempo` int(11) DEFAULT NULL,
  `tanggal_tempo` date DEFAULT NULL,
  `materai` int(11) DEFAULT NULL,
  `id_penagih` int(11) DEFAULT NULL,
  `no_penerimaan` varchar(255) DEFAULT NULL,
  `tanggal_penerimaan` date DEFAULT NULL,
  `pengantar` varchar(255) DEFAULT NULL,
  `keterangan_penerimaan` text DEFAULT NULL,
  `no_spb` varchar(255) DEFAULT NULL,
  `id_mitra_bisnis_alamat` int(11) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `tanggal_approve` datetime DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `uang_muka` int(40) DEFAULT 0,
  `id_kas_bank` int(11) DEFAULT NULL,
  `tanggal_estimasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembelian_detail`
--

CREATE TABLE `akt_pembelian_detail` (
  `id_pembelian_detail` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `diskon` int(11) DEFAULT NULL,
  `total` bigint(20) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembelian_harta_tetap`
--

CREATE TABLE `akt_pembelian_harta_tetap` (
  `id_pembelian_harta_tetap` int(11) NOT NULL,
  `no_pembelian_harta_tetap` varchar(123) NOT NULL,
  `tanggal` date NOT NULL,
  `termin` int(11) DEFAULT NULL,
  `id_kas_bank` int(11) DEFAULT NULL,
  `jumlah_hari` int(11) DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `id_mata_uang` int(11) DEFAULT NULL,
  `pajak` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `materai` int(11) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembelian_penerimaan`
--

CREATE TABLE `akt_pembelian_penerimaan` (
  `id_pembelian_penerimaan` int(11) NOT NULL,
  `no_penerimaan` varchar(200) NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `foto_resi` varchar(255) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `pengantar` varchar(200) NOT NULL,
  `keterangan_pengantar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pembelian_penerimaan_detail`
--

CREATE TABLE `akt_pembelian_penerimaan_detail` (
  `id_pembelian_penerimaan_detail` int(11) NOT NULL,
  `id_pembelian_penerimaan` int(11) NOT NULL,
  `id_pembelian_detail` int(11) NOT NULL,
  `qty_diterima` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penagih`
--

CREATE TABLE `akt_penagih` (
  `id_penagih` int(11) NOT NULL,
  `kode_penagih` varchar(20) NOT NULL,
  `nama_penagih` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `kode_pos` varchar(20) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penawaran_penjualan`
--

CREATE TABLE `akt_penawaran_penjualan` (
  `id_penawaran_penjualan` int(11) NOT NULL,
  `no_penawaran_penjualan` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_sales` int(11) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `pajak` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  `id_penagih` int(11) NOT NULL,
  `id_pengirim` int(11) NOT NULL,
  `the_approver` int(11) DEFAULT NULL,
  `tanggal_approve` datetime DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penawaran_penjualan_detail`
--

CREATE TABLE `akt_penawaran_penjualan_detail` (
  `id_penawaran_penjualan_detail` int(11) NOT NULL,
  `id_penawaran_penjualan` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `diskon` int(11) NOT NULL,
  `sub_total` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_item_harga_jual` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penerimaan_pembayaran`
--

CREATE TABLE `akt_penerimaan_pembayaran` (
  `id_penerimaan_pembayaran_penjualan` int(11) NOT NULL,
  `tanggal_penerimaan_pembayaran` date NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `cara_bayar` int(11) NOT NULL,
  `id_kas_bank` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pengajuan_biaya`
--

CREATE TABLE `akt_pengajuan_biaya` (
  `id_pengajuan_biaya` int(11) NOT NULL,
  `nomor_pengajuan_biaya` varchar(200) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `nomor_purchasing_order` varchar(200) DEFAULT NULL,
  `nomor_kendaraan` varchar(200) DEFAULT NULL,
  `volume` varchar(200) NOT NULL,
  `keterangan_pengajuan` text DEFAULT NULL,
  `dibuat_oleh` int(11) NOT NULL,
  `jenis_bayar` varchar(200) NOT NULL,
  `dibayar_oleh` varchar(200) NOT NULL,
  `dibayar_kepada` varchar(200) NOT NULL,
  `alamat_dibayar_kepada` text DEFAULT NULL,
  `approver1` int(11) DEFAULT NULL,
  `approver2` int(11) DEFAULT NULL,
  `approver3` int(11) DEFAULT NULL,
  `approver1_date` datetime DEFAULT NULL,
  `approver2_date` datetime DEFAULT NULL,
  `approver3_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `alasan_reject` text DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `sumber_dana` int(11) NOT NULL,
  `status_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_pengajuan_biaya_detail`
--

CREATE TABLE `akt_pengajuan_biaya_detail` (
  `id_pengajuan_biaya_detail` int(11) NOT NULL,
  `id_pengajuan_biaya` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `kode_rekening` varchar(200) NOT NULL,
  `nama_pengajuan` varchar(200) NOT NULL,
  `debit` bigint(20) DEFAULT 0,
  `kredit` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan`
--

CREATE TABLE `akt_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `no_order_penjualan` varchar(200) NOT NULL,
  `tanggal_order_penjualan` date NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_sales` int(11) DEFAULT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `the_approver` int(11) DEFAULT NULL,
  `the_approver_date` datetime DEFAULT NULL,
  `no_penjualan` varchar(200) DEFAULT NULL,
  `tanggal_penjualan` date DEFAULT NULL,
  `no_faktur_penjualan` varchar(200) DEFAULT NULL,
  `tanggal_faktur_penjualan` date DEFAULT NULL,
  `ongkir` bigint(20) DEFAULT NULL,
  `pajak` bigint(20) DEFAULT NULL,
  `uang_muka` bigint(20) DEFAULT NULL,
  `id_kas_bank` int(11) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `jenis_bayar` int(11) DEFAULT NULL,
  `jumlah_tempo` int(11) DEFAULT NULL,
  `tanggal_tempo` date DEFAULT NULL,
  `materai` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `tanggal_estimasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan_detail`
--

CREATE TABLE `akt_penjualan_detail` (
  `id_penjualan_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `diskon` float NOT NULL,
  `total` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_item_harga_jual` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan_harta_tetap`
--

CREATE TABLE `akt_penjualan_harta_tetap` (
  `id_penjualan_harta_tetap` int(11) NOT NULL,
  `no_penjualan_harta_tetap` varchar(200) NOT NULL,
  `tanggal_penjualan_harta_tetap` date NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_sales` int(11) DEFAULT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `the_approver` int(11) DEFAULT NULL,
  `the_approver_date` datetime DEFAULT NULL,
  `no_faktur_penjualan_harta_tetap` varchar(200) DEFAULT NULL,
  `tanggal_faktur_penjualan_harta_tetap` date DEFAULT NULL,
  `ongkir` bigint(20) DEFAULT NULL,
  `pajak` bigint(20) DEFAULT NULL,
  `uang_muka` bigint(20) DEFAULT NULL,
  `id_kas_bank` int(11) DEFAULT NULL,
  `total` bigint(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `jenis_bayar` int(11) DEFAULT NULL,
  `jumlah_tempo` int(11) DEFAULT NULL,
  `tanggal_tempo` date DEFAULT NULL,
  `materai` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan_harta_tetap_detail`
--

CREATE TABLE `akt_penjualan_harta_tetap_detail` (
  `id_penjualan_harta_tetap_detail` int(11) NOT NULL,
  `id_penjualan_harta_tetap` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `diskon` float NOT NULL,
  `total` bigint(20) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan_pengiriman`
--

CREATE TABLE `akt_penjualan_pengiriman` (
  `id_penjualan_pengiriman` int(11) NOT NULL,
  `no_pengiriman` varchar(200) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `pengantar` varchar(200) NOT NULL,
  `keterangan_pengantar` text DEFAULT NULL,
  `foto_resi` varchar(200) DEFAULT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_mitra_bisnis_alamat` int(11) NOT NULL,
  `penerima` varchar(200) DEFAULT NULL,
  `keterangan_penerima` text DEFAULT NULL,
  `tanggal_penerimaan` date DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penjualan_pengiriman_detail`
--

CREATE TABLE `akt_penjualan_pengiriman_detail` (
  `id_penjualan_pengiriman_detail` int(11) NOT NULL,
  `id_penjualan_pengiriman` int(11) NOT NULL,
  `id_penjualan_detail` int(11) NOT NULL,
  `qty_dikirim` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penyesuaian_kas`
--

CREATE TABLE `akt_penyesuaian_kas` (
  `id_penyesuaian_kas` int(11) NOT NULL,
  `no_transaksi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `id_akun` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `no_referensi` varchar(20) NOT NULL,
  `id_kas_bank` int(11) NOT NULL,
  `id_mata_uang` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penyesuaian_stok`
--

CREATE TABLE `akt_penyesuaian_stok` (
  `id_penyesuaian_stok` int(11) NOT NULL,
  `no_transaksi` varchar(200) NOT NULL,
  `tanggal_penyesuaian` date NOT NULL,
  `tipe_penyesuaian` int(11) NOT NULL,
  `keterangan_penyesuaian` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_penyesuaian_stok_detail`
--

CREATE TABLE `akt_penyesuaian_stok_detail` (
  `id_penyesuaian_stok_detail` int(11) NOT NULL,
  `id_penyesuaian_stok` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_permintaan_barang`
--

CREATE TABLE `akt_permintaan_barang` (
  `id_permintaan_barang` int(11) NOT NULL,
  `nomor_permintaan` varchar(200) NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `status_aktif` int(11) NOT NULL DEFAULT 0,
  `id_pegawai` int(11) NOT NULL DEFAULT 0,
  `id_login` int(11) DEFAULT NULL,
  `tanggal_approve` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_permintaan_barang_detail`
--

CREATE TABLE `akt_permintaan_barang_detail` (
  `id_permintaan_barang_detail` int(11) NOT NULL,
  `id_permintaan_barang` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `qty_ordered` int(11) NOT NULL,
  `qty_rejected` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_permintaan_barang_pegawai`
--

CREATE TABLE `akt_permintaan_barang_pegawai` (
  `id_permintaan_barang_pegawai` int(11) NOT NULL,
  `id_permintaan_barang` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_permintaan_pembelian`
--

CREATE TABLE `akt_permintaan_pembelian` (
  `id_permintaan_pembelian` int(11) NOT NULL,
  `no_permintaan` varchar(123) NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 2,
  `keterangan` text NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `draft` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `tanggal_approve` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_bom`
--

CREATE TABLE `akt_produksi_bom` (
  `id_produksi_bom` int(11) NOT NULL,
  `no_produksi_bom` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `id_bom` int(11) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `tanggal_approve` date DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `status_produksi` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_bom_detail_bb`
--

CREATE TABLE `akt_produksi_bom_detail_bb` (
  `id_produksi_bom_detail_bb` int(11) NOT NULL,
  `id_produksi_bom` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_bom_detail_hp`
--

CREATE TABLE `akt_produksi_bom_detail_hp` (
  `id_produksi_bom_detail_hp` int(11) NOT NULL,
  `id_produksi_bom` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_manual`
--

CREATE TABLE `akt_produksi_manual` (
  `id_produksi_manual` int(11) NOT NULL,
  `no_produksi_manual` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `id_customer` int(11) NOT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `status_produksi` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_manual_detail_bb`
--

CREATE TABLE `akt_produksi_manual_detail_bb` (
  `id_produksi_manual_detail_bb` int(11) NOT NULL,
  `id_produksi_manual` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_produksi_manual_detail_hp`
--

CREATE TABLE `akt_produksi_manual_detail_hp` (
  `id_produksi_manual_detail_hp` int(11) NOT NULL,
  `id_produksi_manual` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_proyek`
--

CREATE TABLE `akt_proyek` (
  `id_proyek` int(11) NOT NULL,
  `kode_proyek` varchar(123) NOT NULL,
  `nama_proyek` varchar(123) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_mitra_bisnis` int(11) NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_retur_pembelian`
--

CREATE TABLE `akt_retur_pembelian` (
  `id_retur_pembelian` int(11) NOT NULL,
  `no_retur_pembelian` varchar(255) NOT NULL,
  `tanggal_retur_pembelian` date NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `status_retur` int(11) NOT NULL,
  `id_login` int(11) DEFAULT NULL,
  `tanggal_approve` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_retur_pembelian_detail`
--

CREATE TABLE `akt_retur_pembelian_detail` (
  `id_retur_pembelian_detail` int(11) NOT NULL,
  `id_retur_pembelian` int(11) NOT NULL,
  `id_pembelian_detail` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `retur` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_retur_penjualan`
--

CREATE TABLE `akt_retur_penjualan` (
  `id_retur_penjualan` int(11) NOT NULL,
  `no_retur_penjualan` varchar(200) NOT NULL,
  `tanggal_retur_penjualan` date NOT NULL,
  `id_penjualan_pengiriman` int(11) NOT NULL,
  `status_retur` int(11) NOT NULL,
  `id_login` int(11) NOT NULL DEFAULT 0,
  `tanggal_approve` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_retur_penjualan_detail`
--

CREATE TABLE `akt_retur_penjualan_detail` (
  `id_retur_penjualan_detail` int(11) NOT NULL,
  `id_retur_penjualan` int(11) NOT NULL,
  `id_penjualan_pengiriman_detail` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `retur` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_saldo_awal_akun`
--

CREATE TABLE `akt_saldo_awal_akun` (
  `id_saldo_awal_akun` int(11) NOT NULL,
  `no_jurnal` varchar(25) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_saldo_awal_akun`
--

INSERT INTO `akt_saldo_awal_akun` (`id_saldo_awal_akun`, `no_jurnal`, `tanggal`, `tipe`) VALUES
(8, 'SA2009001', '2020-09-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `akt_saldo_awal_akun_detail`
--

CREATE TABLE `akt_saldo_awal_akun_detail` (
  `id_saldo_awal_akun_detail` int(11) NOT NULL,
  `id_saldo_awal_akun` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `debet` double DEFAULT 0,
  `kredit` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akt_saldo_awal_akun_detail`
--

INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun_detail`, `id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES
(21, 8, 2, 1000000, NULL),
(22, 8, 3, 1000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `akt_saldo_awal_kas`
--

CREATE TABLE `akt_saldo_awal_kas` (
  `id_saldo_awal_kas` int(11) NOT NULL,
  `no_transaksi` varchar(200) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `id_kas_bank` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_saldo_awal_stok`
--

CREATE TABLE `akt_saldo_awal_stok` (
  `id_saldo_awal_stok` int(11) NOT NULL,
  `no_transaksi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_saldo_awal_stok_detail`
--

CREATE TABLE `akt_saldo_awal_stok_detail` (
  `id_saldo_awal_stok_detail` int(11) NOT NULL,
  `id_saldo_awal_stok` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_sales`
--

CREATE TABLE `akt_sales` (
  `id_sales` int(11) NOT NULL,
  `kode_sales` varchar(20) NOT NULL,
  `nama_sales` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `kode_pos` varchar(20) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `handphone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_aktif` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_satuan`
--

CREATE TABLE `akt_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akt_satuan`
--

INSERT INTO `akt_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'BOX'),
(2, 'PCS'),
(3, 'Lusin'),
(5, 'PAK');

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_keluar`
--

CREATE TABLE `akt_stok_keluar` (
  `id_stok_keluar` int(11) NOT NULL,
  `nomor_transaksi` varchar(200) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `tipe` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_keluar_detail`
--

CREATE TABLE `akt_stok_keluar_detail` (
  `id_stok_keluar_detail` int(11) NOT NULL,
  `id_stok_keluar` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_masuk`
--

CREATE TABLE `akt_stok_masuk` (
  `id_stok_masuk` int(11) NOT NULL,
  `nomor_transaksi` varchar(200) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tipe` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_masuk_detail`
--

CREATE TABLE `akt_stok_masuk_detail` (
  `id_stok_masuk_detail` int(11) NOT NULL,
  `id_stok_masuk` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_opname`
--

CREATE TABLE `akt_stok_opname` (
  `id_stok_opname` int(11) NOT NULL,
  `no_transaksi` varchar(200) NOT NULL,
  `tanggal_opname` date NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_stok_opname_detail`
--

CREATE TABLE `akt_stok_opname_detail` (
  `id_stok_opname_detail` int(11) NOT NULL,
  `id_stok_opname` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `qty_opname` int(11) NOT NULL,
  `qty_program` int(11) NOT NULL,
  `qty_selisih` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_transfer_kas`
--

CREATE TABLE `akt_transfer_kas` (
  `id_transfer_kas` int(11) NOT NULL,
  `no_transfer_kas` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_asal_kas` int(11) NOT NULL,
  `id_tujuan_kas` int(11) NOT NULL,
  `jumlah1` double NOT NULL,
  `jumlah2` double NOT NULL DEFAULT 0,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `akt_transfer_stok`
--

CREATE TABLE `akt_transfer_stok` (
  `id_transfer_stok` int(11) NOT NULL,
  `no_transfer` varchar(200) NOT NULL,
  `tanggal_transfer` date NOT NULL,
  `id_gudang_asal` int(11) NOT NULL,
  `id_gudang_tujuan` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `akt_transfer_stok_detail`
--

CREATE TABLE `akt_transfer_stok_detail` (
  `id_transfer_stok_detail` int(11) NOT NULL,
  `id_transfer_stok` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id_foto` int(11) NOT NULL,
  `nama_tabel` varchar(100) NOT NULL,
  `id_tabel` int(11) NOT NULL,
  `foto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_pembelian_harta_tetap`
--

CREATE TABLE `item_pembelian_harta_tetap` (
  `id_item_pembelian_harta_tetap` int(11) NOT NULL,
  `id_pembelian_harta_tetap` int(11) NOT NULL,
  `id_harta_tetap` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_permintaan_pembelian`
--

CREATE TABLE `item_permintaan_pembelian` (
  `id_item_permintaan_pembelian` int(11) NOT NULL,
  `id_permintaan_pembelian` int(11) NOT NULL,
  `id_item_stok` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `id_proyek` int(11) NOT NULL,
  `keterangan` varchar(123) NOT NULL,
  `req_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_transaksi`
--

CREATE TABLE `jurnal_transaksi` (
  `id_jurnal_transaksi` int(11) NOT NULL,
  `nama_transaksi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_transaksi`
--

INSERT INTO `jurnal_transaksi` (`id_jurnal_transaksi`, `nama_transaksi`) VALUES
(2, 'Pembelian Kredit'),
(3, 'Pembayaran Transaksi Kredit'),
(4, 'Pembelian Cash'),
(6, 'Pembayaran Transaksi Cash'),
(7, 'Penjualan Kredit'),
(8, 'Penerimaan Transaksi Kredit'),
(9, 'Penjualan Cash'),
(10, 'Penerimaan Transaksi Cash'),
(11, 'Stok Masuk'),
(12, 'Stok Keluar'),
(13, 'Stok Opname'),
(14, 'Penyesuaian Stok'),
(15, 'Set Saldo Awal Kas'),
(16, 'Set Saldo Awal Akun'),
(17, 'Retur Pembelian'),
(18, 'Retur Penjualan');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_transaksi_detail`
--

CREATE TABLE `jurnal_transaksi_detail` (
  `id_jurnal_transaksi_detail` int(11) NOT NULL,
  `id_jurnal_transaksi` int(11) NOT NULL,
  `tipe` varchar(2) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_transaksi_detail`
--

INSERT INTO `jurnal_transaksi_detail` (`id_jurnal_transaksi_detail`, `id_jurnal_transaksi`, `tipe`, `id_akun`) VALUES
(5, 2, 'D', 117),
(6, 2, 'K', 64),
(7, 4, 'D', 117),
(8, 4, 'K', 64),
(10, 7, 'K', 117),
(11, 7, 'D', 2),
(12, 7, 'K', 73),
(13, 6, 'D', 64),
(14, 6, 'K', 1),
(16, 8, 'D', 1),
(17, 8, 'K', 2),
(18, 5, 'D', 1),
(19, 5, 'K', 90),
(20, 5, 'D', 114),
(22, 9, 'K', 117),
(23, 9, 'D', 2),
(24, 10, 'D', 1),
(25, 10, 'K', 2),
(26, 2, 'D', 53),
(27, 2, 'D', 122),
(28, 3, 'D', 64),
(31, 3, 'K', 1),
(32, 7, 'K', 47),
(33, 11, 'D', 117),
(34, 12, 'K', 117),
(35, 13, 'K', 117),
(36, 14, 'D', 117),
(38, 12, 'K', 78),
(40, 12, 'D', 114),
(41, 11, 'K', 114),
(42, 11, 'D', 78),
(43, 11, 'K', 130),
(45, 2, 'D', 115),
(48, 7, 'D', 115),
(49, 7, 'K', 131),
(50, 2, 'D', 38),
(53, 2, 'K', 1),
(54, 4, 'D', 53),
(55, 4, 'D', 122),
(56, 4, 'D', 115),
(57, 4, 'D', 38),
(58, 4, 'K', 1),
(59, 12, 'D', 130),
(60, 7, 'D', 1),
(61, 9, 'K', 73),
(62, 9, 'K', 47),
(63, 9, 'D', 115),
(64, 9, 'K', 131),
(65, 9, 'D', 1),
(66, 15, 'D', 1),
(67, 15, 'K', 119),
(68, 16, 'D', 119),
(69, 16, 'K', 120),
(70, 17, 'D', 64),
(71, 17, 'K', 117),
(72, 18, 'D', 117),
(74, 18, 'D', 91),
(75, 18, 'K', 114),
(76, 18, 'K', 2);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` bigint(20) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `level`, `category`, `log_time`, `prefix`, `message`) VALUES
(1, 0, 'Login', 1601093966.1392, 'GSS Developer', 'Login'),
(2, 4, 'yii\\db\\Command::execute', 1601093966.1394, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601093966.1392, \'GSS Developer\', \'Login\')'),
(3, 4, 'yii\\db\\Command::execute', 1601093993.9913, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(4, 4, 'yii\\db\\Command::execute', 1601094042.92, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(5, 4, 'yii\\db\\Command::execute', 1601094360.5746, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009001\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009001\')'),
(6, 4, 'yii\\db\\Command::execute', 1601094360.5765, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(7, 4, 'yii\\db\\Command::execute', 1601094360.5872, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (1, 119, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(8, 4, 'yii\\db\\Command::execute', 1601094360.5901, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (1, 120, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(9, 4, 'yii\\db\\Command::execute', 1601094360.5963, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 3, 1)'),
(10, 4, 'yii\\db\\Command::execute', 1601094379.0543, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009002\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009002\')'),
(11, 4, 'yii\\db\\Command::execute', 1601094379.0555, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009002\', \'2020-09-26\', 1)'),
(12, 4, 'yii\\db\\Command::execute', 1601094379.0598, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (2, 119, 0, 0, \'Set Saldo Awal Akun : SA2009002\')'),
(13, 4, 'yii\\db\\Command::execute', 1601094379.0607, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (2, 120, 0, 0, \'Set Saldo Awal Akun : SA2009002\')'),
(14, 4, 'yii\\db\\Command::execute', 1601094379.0641, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 4, 2)'),
(15, 4, 'yii\\db\\Command::execute', 1601094386.6426, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun` WHERE `id_saldo_awal_akun`=4'),
(16, 4, 'yii\\db\\Command::execute', 1601094395.4234, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=4'),
(17, 4, 'yii\\db\\Command::execute', 1601094397.0479, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=3'),
(18, 4, 'yii\\db\\Command::execute', 1601094398.5742, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum` WHERE `id_jurnal_umum`=2'),
(19, 4, 'yii\\db\\Command::execute', 1601094857.9448, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 2, 1000000, NULL)'),
(20, 4, 'yii\\db\\Command::execute', 1601094857.9597, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(21, 4, 'yii\\db\\Command::execute', 1601094857.9617, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=1'),
(22, 4, 'yii\\db\\Command::execute', 1601094857.9639, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(23, 4, 'yii\\db\\Command::execute', 1601094857.9649, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=2'),
(24, 4, 'yii\\db\\Command::execute', 1601094868.8285, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 5, 1000000, NULL)'),
(25, 4, 'yii\\db\\Command::execute', 1601094868.8433, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(26, 4, 'yii\\db\\Command::execute', 1601094868.8447, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=2000000 WHERE `id_jurnal_umum_detail`=1'),
(27, 4, 'yii\\db\\Command::execute', 1601094868.8462, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=2000000 WHERE `id_akun`=120'),
(28, 4, 'yii\\db\\Command::execute', 1601094868.847, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=2000000 WHERE `id_jurnal_umum_detail`=2'),
(29, 4, 'yii\\db\\Command::execute', 1601095054.0958, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 3, 1000000, NULL)'),
(30, 4, 'yii\\db\\Command::execute', 1601095054.1095, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`)\n                VALUES (4, \'yii\\\\db\\\\Command::execute\', 1601095054.0958, \'GSS Developer\', \'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 3, 1000000, NULL)\')'),
(31, 4, 'yii\\db\\Command::execute', 1601095140.1327, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)'),
(32, 4, 'yii\\db\\Command::execute', 1601095171.1883, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 7, 1000000, NULL)'),
(33, 4, 'yii\\db\\Command::execute', 1601095202.267, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=5'),
(34, 4, 'yii\\db\\Command::execute', 1601095205.6808, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=4'),
(35, 4, 'yii\\db\\Command::execute', 1601095228.9952, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)'),
(36, 4, 'yii\\db\\Command::execute', 1601095229.0238, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`)\n                VALUES (4, \'yii\\\\db\\\\Command::execute\', 1601095228.9952, \'GSS Developer\', \'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)\')'),
(37, 4, 'yii\\db\\Command::execute', 1601095256.4078, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=6'),
(38, 4, 'yii\\db\\Command::execute', 1601095260.4361, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)'),
(39, 4, 'yii\\db\\Command::execute', 1601095260.4448, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`)\n                VALUES (4, \'yii\\\\db\\\\Command::execute\', 1601095260.4361, \'GSS Developer\', \'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)\')'),
(40, 4, 'yii\\db\\Command::execute', 1601095400.3264, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=7'),
(41, 4, 'yii\\db\\Command::execute', 1601095404.7367, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (3, 6, NULL, 1000000)'),
(42, 4, 'yii\\db\\Command::execute', 1601095404.7521, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=6'),
(43, 4, 'yii\\db\\Command::execute', 1601095404.771, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-3000000 WHERE `id_akun`=119'),
(44, 4, 'yii\\db\\Command::execute', 1601095404.7763, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=3000000 WHERE `id_jurnal_umum_detail`=1'),
(45, 4, 'yii\\db\\Command::execute', 1601095404.7845, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=3000000 WHERE `id_akun`=120'),
(46, 4, 'yii\\db\\Command::execute', 1601095404.7865, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=3000000 WHERE `id_jurnal_umum_detail`=2'),
(47, 4, 'yii\\db\\Command::execute', 1601095440.7824, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=3'),
(48, 4, 'yii\\db\\Command::execute', 1601095825.0504, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=6'),
(49, 4, 'yii\\db\\Command::execute', 1601095825.0582, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-4000000 WHERE `id_akun`=119'),
(50, 4, 'yii\\db\\Command::execute', 1601095825.0601, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=2000000 WHERE `id_akun`=120'),
(51, 4, 'yii\\db\\Command::execute', 1601095825.061, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=2000000 WHERE `id_jurnal_umum_detail`=2'),
(52, 4, 'yii\\db\\Command::execute', 1601095825.0622, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=8'),
(53, 4, 'yii\\db\\Command::execute', 1601095886.3939, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=5'),
(54, 4, 'yii\\db\\Command::execute', 1601095886.4033, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-5000000 WHERE `id_akun`=119'),
(55, 4, 'yii\\db\\Command::execute', 1601095886.405, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=2000000 WHERE `id_jurnal_umum_detail`=1'),
(56, 4, 'yii\\db\\Command::execute', 1601095886.4069, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(57, 4, 'yii\\db\\Command::execute', 1601095886.4081, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=2'),
(58, 4, 'yii\\db\\Command::execute', 1601095895.6652, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=2'),
(59, 4, 'yii\\db\\Command::execute', 1601095895.672, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-6000000 WHERE `id_akun`=119'),
(60, 4, 'yii\\db\\Command::execute', 1601095895.675, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=1'),
(61, 4, 'yii\\db\\Command::execute', 1601095895.6775, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(62, 4, 'yii\\db\\Command::execute', 1601095895.6784, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=1'),
(63, 4, 'yii\\db\\Command::execute', 1601095906.1162, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=2'),
(64, 4, 'yii\\db\\Command::execute', 1601095908.1588, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-5000000 WHERE `id_akun`=119'),
(65, 4, 'yii\\db\\Command::execute', 1601095908.1602, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=1'),
(66, 4, 'yii\\db\\Command::execute', 1601095913.3494, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum` WHERE `id_jurnal_umum`=1'),
(67, 4, 'yii\\db\\Command::execute', 1601095917.3649, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun` WHERE `id_saldo_awal_akun`=3'),
(68, 4, 'yii\\db\\Command::execute', 1601096069.453, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009001\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009001\')'),
(69, 4, 'yii\\db\\Command::execute', 1601096069.4546, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(70, 4, 'yii\\db\\Command::execute', 1601096069.4601, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (3, 119, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(71, 4, 'yii\\db\\Command::execute', 1601096069.4611, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (3, 120, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(72, 4, 'yii\\db\\Command::execute', 1601096069.4632, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 5, 3)'),
(73, 4, 'yii\\db\\Command::execute', 1601096079.9307, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (5, 2, 1000000, NULL)'),
(74, 4, 'yii\\db\\Command::execute', 1601096079.9335, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(75, 4, 'yii\\db\\Command::execute', 1601096079.9409, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(76, 4, 'yii\\db\\Command::execute', 1601096079.9418, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=5'),
(77, 4, 'yii\\db\\Command::execute', 1601096079.943, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(78, 4, 'yii\\db\\Command::execute', 1601096079.9437, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=6'),
(79, 4, 'yii\\db\\Command::execute', 1601096188.0567, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(80, 4, 'yii\\db\\Command::execute', 1601096188.0681, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(81, 4, 'yii\\db\\Command::execute', 1601096188.0728, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=5'),
(82, 4, 'yii\\db\\Command::execute', 1601096188.0764, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(83, 4, 'yii\\db\\Command::execute', 1601096188.0776, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=9'),
(84, 4, 'yii\\db\\Command::execute', 1601096366.9495, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=6'),
(85, 4, 'yii\\db\\Command::execute', 1601096369.5532, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=5'),
(86, 4, 'yii\\db\\Command::execute', 1601096371.3129, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum` WHERE `id_jurnal_umum`=3'),
(87, 4, 'yii\\db\\Command::execute', 1601096507.3421, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun` WHERE `id_saldo_awal_akun`=5'),
(88, 4, 'yii\\db\\Command::execute', 1601096516.3685, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009001\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009001\')'),
(89, 4, 'yii\\db\\Command::execute', 1601096516.3703, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(90, 4, 'yii\\db\\Command::execute', 1601096516.3764, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (4, 119, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(91, 4, 'yii\\db\\Command::execute', 1601096516.3789, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (4, 120, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(92, 4, 'yii\\db\\Command::execute', 1601096516.3815, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 6, 4)'),
(93, 4, 'yii\\db\\Command::execute', 1601096528.9706, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (6, 2, 1000000, NULL)'),
(94, 4, 'yii\\db\\Command::execute', 1601096528.9752, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(95, 4, 'yii\\db\\Command::execute', 1601096528.9849, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(96, 4, 'yii\\db\\Command::execute', 1601096528.9859, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=7'),
(97, 4, 'yii\\db\\Command::execute', 1601096528.9875, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(98, 4, 'yii\\db\\Command::execute', 1601096528.9882, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=8'),
(99, 4, 'yii\\db\\Command::execute', 1601096576.7499, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(100, 4, 'yii\\db\\Command::execute', 1601096576.755, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=119'),
(101, 4, 'yii\\db\\Command::execute', 1601096576.756, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0, `kredit`=-1000000 WHERE `id_jurnal_umum_detail`=7'),
(102, 4, 'yii\\db\\Command::execute', 1601096576.7571, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(103, 4, 'yii\\db\\Command::execute', 1601096576.7579, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=-1000000, `kredit`=0 WHERE `id_jurnal_umum_detail`=8'),
(104, 4, 'yii\\db\\Command::execute', 1601096576.7586, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=10'),
(105, 4, 'yii\\db\\Command::execute', 1601096597.5961, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (6, 2, 1000000, NULL)'),
(106, 4, 'yii\\db\\Command::execute', 1601096597.5998, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(107, 4, 'yii\\db\\Command::execute', 1601096597.6142, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(108, 4, 'yii\\db\\Command::execute', 1601096597.616, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=7'),
(109, 4, 'yii\\db\\Command::execute', 1601096597.6197, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(110, 4, 'yii\\db\\Command::execute', 1601096597.6292, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=8'),
(111, 4, 'yii\\db\\Command::execute', 1601096636.4161, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(112, 4, 'yii\\db\\Command::execute', 1601096636.4249, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=119'),
(113, 4, 'yii\\db\\Command::execute', 1601096636.4262, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=7'),
(114, 4, 'yii\\db\\Command::execute', 1601096636.428, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(115, 4, 'yii\\db\\Command::execute', 1601096636.4303, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=-2000000 WHERE `id_jurnal_umum_detail`=8'),
(116, 4, 'yii\\db\\Command::execute', 1601096636.4311, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=11'),
(117, 4, 'yii\\db\\Command::execute', 1601096638.4077, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun` WHERE `id_saldo_awal_akun`=6'),
(118, 4, 'yii\\db\\Command::execute', 1601096646.8137, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=8'),
(119, 4, 'yii\\db\\Command::execute', 1601096648.7817, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=7'),
(120, 4, 'yii\\db\\Command::execute', 1601096650.7852, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum` WHERE `id_jurnal_umum`=4'),
(121, 4, 'yii\\db\\Command::execute', 1601096725.1661, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009001\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009001\')'),
(122, 4, 'yii\\db\\Command::execute', 1601096725.1677, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(123, 4, 'yii\\db\\Command::execute', 1601096725.1747, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (5, 119, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(124, 4, 'yii\\db\\Command::execute', 1601096725.176, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (5, 120, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(125, 4, 'yii\\db\\Command::execute', 1601096725.1787, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 7, 5)'),
(126, 4, 'yii\\db\\Command::execute', 1601096733.1358, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (7, 2, 1000000, NULL)'),
(127, 4, 'yii\\db\\Command::execute', 1601096733.1409, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(128, 4, 'yii\\db\\Command::execute', 1601096733.1517, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(129, 4, 'yii\\db\\Command::execute', 1601096733.153, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=9'),
(130, 4, 'yii\\db\\Command::execute', 1601096733.1551, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(131, 4, 'yii\\db\\Command::execute', 1601096733.1562, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=10'),
(132, 4, 'yii\\db\\Command::execute', 1601096738.0598, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(133, 4, 'yii\\db\\Command::execute', 1601096738.0662, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=119'),
(134, 4, 'yii\\db\\Command::execute', 1601096738.0672, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=9'),
(135, 4, 'yii\\db\\Command::execute', 1601096738.0684, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(136, 4, 'yii\\db\\Command::execute', 1601096738.0692, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=-1000000 WHERE `id_jurnal_umum_detail`=10'),
(137, 4, 'yii\\db\\Command::execute', 1601096738.0699, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=12'),
(138, 4, 'yii\\db\\Command::execute', 1601096873.8473, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=9'),
(139, 4, 'yii\\db\\Command::execute', 1601096873.8507, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum_detail` WHERE `id_jurnal_umum_detail`=10'),
(140, 4, 'yii\\db\\Command::execute', 1601096873.852, 'GSS Developer', 'DELETE FROM `akt_jurnal_umum` WHERE `id_jurnal_umum`=5'),
(141, 4, 'yii\\db\\Command::execute', 1601096873.854, 'GSS Developer', 'DELETE FROM `akt_history_transaksi` WHERE `id_history_transaksi`=5'),
(142, 4, 'yii\\db\\Command::execute', 1601096873.856, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun` WHERE `id_saldo_awal_akun`=7'),
(143, 4, 'yii\\db\\Command::execute', 1601096925.8168, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum` (`no_jurnal_umum`, `tipe`, `tanggal`, `keterangan`) VALUES (\'JU2009001\', 1, \'2020-09-26\', \'Set Saldo Awal Akun : SA2009001\')'),
(144, 4, 'yii\\db\\Command::execute', 1601096925.8184, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun` (`no_jurnal`, `tanggal`, `tipe`) VALUES (\'SA2009001\', \'2020-09-26\', 1)'),
(145, 4, 'yii\\db\\Command::execute', 1601096925.8337, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (6, 119, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(146, 4, 'yii\\db\\Command::execute', 1601096925.8352, 'GSS Developer', 'INSERT INTO `akt_jurnal_umum_detail` (`id_jurnal_umum`, `id_akun`, `debit`, `kredit`, `keterangan`) VALUES (6, 120, 0, 0, \'Set Saldo Awal Akun : SA2009001\')'),
(147, 4, 'yii\\db\\Command::execute', 1601096925.8378, 'GSS Developer', 'INSERT INTO `akt_history_transaksi` (`nama_tabel`, `id_tabel`, `id_jurnal_umum`) VALUES (\'akt_saldo_awal_akun\', 8, 6)'),
(148, 4, 'yii\\db\\Command::execute', 1601096945.7742, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(149, 4, 'yii\\db\\Command::execute', 1601096945.7783, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(150, 4, 'yii\\db\\Command::execute', 1601096945.7882, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(151, 4, 'yii\\db\\Command::execute', 1601096945.7893, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(152, 4, 'yii\\db\\Command::execute', 1601096945.7908, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(153, 4, 'yii\\db\\Command::execute', 1601096945.7915, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(154, 4, 'yii\\db\\Command::execute', 1601096951.3516, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(155, 4, 'yii\\db\\Command::execute', 1601096951.3589, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=119'),
(156, 4, 'yii\\db\\Command::execute', 1601096951.3604, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(157, 4, 'yii\\db\\Command::execute', 1601096951.3624, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=120'),
(158, 4, 'yii\\db\\Command::execute', 1601096951.3636, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=13'),
(159, 4, 'yii\\db\\Command::execute', 1601097791.9429, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(160, 4, 'yii\\db\\Command::execute', 1601097791.9479, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(161, 4, 'yii\\db\\Command::execute', 1601097791.9577, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(162, 4, 'yii\\db\\Command::execute', 1601097791.9589, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(163, 4, 'yii\\db\\Command::execute', 1601097791.9608, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=120'),
(164, 4, 'yii\\db\\Command::execute', 1601097791.9633, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(165, 4, 'yii\\db\\Command::execute', 1601097798.2297, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=2'),
(166, 4, 'yii\\db\\Command::execute', 1601097798.2368, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=0 WHERE `id_akun`=119'),
(167, 4, 'yii\\db\\Command::execute', 1601097798.238, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(168, 4, 'yii\\db\\Command::execute', 1601097798.2399, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=14'),
(169, 4, 'yii\\db\\Command::execute', 1601097907.0174, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(170, 4, 'yii\\db\\Command::execute', 1601097907.0232, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=2'),
(171, 4, 'yii\\db\\Command::execute', 1601097907.034, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-1000000 WHERE `id_akun`=119'),
(172, 4, 'yii\\db\\Command::execute', 1601097907.0447, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(173, 4, 'yii\\db\\Command::execute', 1601097907.0476, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=2000000 WHERE `id_akun`=120'),
(174, 4, 'yii\\db\\Command::execute', 1601097907.0485, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(175, 4, 'yii\\db\\Command::execute', 1601097914.7936, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(176, 4, 'yii\\db\\Command::execute', 1601097914.7955, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=15'),
(177, 4, 'yii\\db\\Command::execute', 1601098049.4557, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, NULL, NULL)'),
(178, 4, 'yii\\db\\Command::execute', 1601098059.6757, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=16'),
(179, 4, 'yii\\db\\Command::execute', 1601098116.0255, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(180, 4, 'yii\\db\\Command::execute', 1601098116.0294, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=2000000 WHERE `id_akun`=2'),
(181, 4, 'yii\\db\\Command::execute', 1601098116.0392, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(182, 4, 'yii\\db\\Command::execute', 1601098116.0407, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(183, 4, 'yii\\db\\Command::execute', 1601098116.0432, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=3000000 WHERE `id_akun`=120'),
(184, 4, 'yii\\db\\Command::execute', 1601098116.0443, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(185, 4, 'yii\\db\\Command::execute', 1601098135.1069, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(186, 4, 'yii\\db\\Command::execute', 1601098186.9026, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=17'),
(187, 4, 'yii\\db\\Command::execute', 1601098265.98, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(188, 4, 'yii\\db\\Command::execute', 1601098265.9841, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=3000000 WHERE `id_akun`=2'),
(189, 4, 'yii\\db\\Command::execute', 1601098265.992, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-3000000 WHERE `id_akun`=119'),
(190, 4, 'yii\\db\\Command::execute', 1601098265.9931, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(191, 4, 'yii\\db\\Command::execute', 1601098265.9947, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=4000000 WHERE `id_akun`=120'),
(192, 4, 'yii\\db\\Command::execute', 1601098265.9954, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(193, 4, 'yii\\db\\Command::execute', 1601098272.7661, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(194, 4, 'yii\\db\\Command::execute', 1601098272.7679, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(195, 4, 'yii\\db\\Command::execute', 1601098272.7696, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=18'),
(196, 4, 'yii\\db\\Command::execute', 1601098284.3856, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(197, 4, 'yii\\db\\Command::execute', 1601098284.3905, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=4000000 WHERE `id_akun`=2'),
(198, 4, 'yii\\db\\Command::execute', 1601098284.4048, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-3000000 WHERE `id_akun`=119'),
(199, 4, 'yii\\db\\Command::execute', 1601098284.406, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(200, 4, 'yii\\db\\Command::execute', 1601098284.408, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=5000000 WHERE `id_akun`=120'),
(201, 4, 'yii\\db\\Command::execute', 1601098284.4089, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=2000000 WHERE `id_jurnal_umum_detail`=12'),
(202, 4, 'yii\\db\\Command::execute', 1601098292.6922, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(203, 4, 'yii\\db\\Command::execute', 1601098292.6936, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(204, 4, 'yii\\db\\Command::execute', 1601098292.6952, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=19'),
(205, 4, 'yii\\db\\Command::execute', 1601098334.7109, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(206, 4, 'yii\\db\\Command::execute', 1601098334.7139, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=5000000 WHERE `id_akun`=2'),
(207, 4, 'yii\\db\\Command::execute', 1601098334.7214, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-3000000 WHERE `id_akun`=119'),
(208, 4, 'yii\\db\\Command::execute', 1601098334.7225, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(209, 4, 'yii\\db\\Command::execute', 1601098334.7243, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=6000000 WHERE `id_akun`=120'),
(210, 4, 'yii\\db\\Command::execute', 1601098334.7251, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=3000000 WHERE `id_jurnal_umum_detail`=12'),
(211, 4, 'yii\\db\\Command::execute', 1601098352.0477, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-2000000 WHERE `id_akun`=119'),
(212, 4, 'yii\\db\\Command::execute', 1601098352.0523, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=0 WHERE `id_jurnal_umum_detail`=11'),
(213, 4, 'yii\\db\\Command::execute', 1601098836.0233, 'GSS Developer', 'DELETE FROM `akt_saldo_awal_akun_detail` WHERE `id_saldo_awal_akun_detail`=20'),
(214, 4, 'yii\\db\\Command::execute', 1601098852.7329, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 2, 1000000, NULL)'),
(215, 4, 'yii\\db\\Command::execute', 1601098852.7369, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=6000000 WHERE `id_akun`=2'),
(216, 4, 'yii\\db\\Command::execute', 1601098852.7472, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-3000000 WHERE `id_akun`=119'),
(217, 4, 'yii\\db\\Command::execute', 1601098852.7492, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=1000000 WHERE `id_jurnal_umum_detail`=11'),
(218, 4, 'yii\\db\\Command::execute', 1601098852.7515, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=7000000 WHERE `id_akun`=120'),
(219, 4, 'yii\\db\\Command::execute', 1601098852.7527, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=1000000 WHERE `id_jurnal_umum_detail`=12'),
(220, 4, 'yii\\db\\Command::execute', 1601098862.6721, 'GSS Developer', 'INSERT INTO `akt_saldo_awal_akun_detail` (`id_saldo_awal_akun`, `id_akun`, `debet`, `kredit`) VALUES (8, 3, 1000000, NULL)'),
(221, 4, 'yii\\db\\Command::execute', 1601098862.6782, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=1000000 WHERE `id_akun`=3'),
(222, 4, 'yii\\db\\Command::execute', 1601098862.6949, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=-4000000 WHERE `id_akun`=119'),
(223, 4, 'yii\\db\\Command::execute', 1601098862.6967, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `debit`=2000000 WHERE `id_jurnal_umum_detail`=11'),
(224, 4, 'yii\\db\\Command::execute', 1601098862.6999, 'GSS Developer', 'UPDATE `akt_akun` SET `saldo_akun`=8000000 WHERE `id_akun`=120'),
(225, 4, 'yii\\db\\Command::execute', 1601098862.7011, 'GSS Developer', 'UPDATE `akt_jurnal_umum_detail` SET `kredit`=2000000 WHERE `id_jurnal_umum_detail`=12'),
(226, 0, 'Login', 1601100873.514, 'GSS Developer', 'Login'),
(227, 4, 'yii\\db\\Command::execute', 1601100873.5141, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601100873.514, \'GSS Developer\', \'Login\')'),
(228, 0, 'Login', 1601101214.4363, 'GSS Developer', 'Login'),
(229, 4, 'yii\\db\\Command::execute', 1601101214.4365, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601101214.4363, \'GSS Developer\', \'Login\')'),
(230, 4, 'yii\\db\\Command::execute', 1601101246.3401, 'GSS Developer', 'UPDATE `akt_approver` SET `id_login`=4, `tingkat_approver`=1 WHERE `id_approver`=60'),
(231, 4, 'yii\\db\\Command::execute', 1601101256.2809, 'GSS Developer', 'UPDATE `akt_approver` SET `id_login`=4, `tingkat_approver`=1 WHERE `id_approver`=73'),
(232, 0, 'Login', 1601129703.8163, 'GSS Developer', 'Login'),
(233, 4, 'yii\\db\\Command::execute', 1601129703.8165, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601129703.8163, \'GSS Developer\', \'Login\')'),
(234, 0, 'Login', 1601193576.0121, 'Ivanda AJM', 'Login'),
(235, 4, 'yii\\db\\Command::execute', 1601193576.0123, 'Ivanda AJM', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601193576.0121, \'Ivanda AJM\', \'Login\')'),
(236, 0, 'Login', 1601344732.1109, 'GSS Developer', 'Login'),
(237, 4, 'yii\\db\\Command::execute', 1601344732.1111, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601344732.1109, \'GSS Developer\', \'Login\')'),
(238, 0, 'Login', 1601345759.2157, 'Ivanda AJM', 'Login'),
(239, 4, 'yii\\db\\Command::execute', 1601345759.2158, 'Ivanda AJM', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601345759.2157, \'Ivanda AJM\', \'Login\')'),
(240, 4, 'yii\\db\\Command::execute', 1601348495.6504, 'GSS Developer', 'INSERT INTO `akt_kota` (`kode_kota`, `nama_kota`) VALUES (\'KT001\', \'Semarang\')'),
(241, 4, 'yii\\db\\Command::execute', 1601348511.5486, 'GSS Developer', 'UPDATE `setting` SET `id_kota`=1 WHERE `id_setting`=1'),
(242, 0, 'Login', 1601368564.4449, 'GSS Developer', 'Login'),
(243, 4, 'yii\\db\\Command::execute', 1601368564.4451, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601368564.4449, \'GSS Developer\', \'Login\')'),
(244, 0, 'Login', 1601402599.965, 'GSS Developer', 'Login'),
(245, 4, 'yii\\db\\Command::execute', 1601402599.9651, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601402599.965, \'GSS Developer\', \'Login\')'),
(246, 0, 'Login', 1601432295.246, 'Ivanda AJM', 'Login'),
(247, 4, 'yii\\db\\Command::execute', 1601432295.2462, 'Ivanda AJM', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601432295.246, \'Ivanda AJM\', \'Login\')'),
(248, 0, 'Login', 1601438620.6562, 'Ivanda AJM', 'Login'),
(249, 4, 'yii\\db\\Command::execute', 1601438620.6564, 'Ivanda AJM', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601438620.6562, \'Ivanda AJM\', \'Login\')'),
(250, 0, 'Login', 1601442453.2507, 'GSS Developer', 'Login'),
(251, 4, 'yii\\db\\Command::execute', 1601442453.2509, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601442453.2507, \'GSS Developer\', \'Login\')'),
(252, 4, 'yii\\db\\Command::execute', 1601442464.7751, 'GSS Developer', 'UPDATE `menu_navigasi` SET `id_parent`=35, `no_urut`=10, `status`=0 WHERE `id_menu`=65'),
(253, 0, 'Login', 1601526795.7192, 'GSS Developer', 'Login'),
(254, 4, 'yii\\db\\Command::execute', 1601526795.7193, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601526795.7192, \'GSS Developer\', \'Login\')'),
(255, 0, 'Login', 1601528262.4338, 'GSS Developer', 'Login'),
(256, 4, 'yii\\db\\Command::execute', 1601528262.434, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601528262.4338, \'GSS Developer\', \'Login\')'),
(257, 0, 'Login', 1601599568.1152, 'Ivanda AJM', 'Login'),
(258, 4, 'yii\\db\\Command::execute', 1601599568.1153, 'Ivanda AJM', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601599568.1152, \'Ivanda AJM\', \'Login\')'),
(259, 0, 'Login', 1601603093.5394, 'GSS Developer', 'Login'),
(260, 4, 'yii\\db\\Command::execute', 1601603093.5396, 'GSS Developer', 'INSERT INTO `log` (`level`, `category`, `log_time`, `prefix`, `message`) VALUES (0, \'Login\', 1601603093.5394, \'GSS Developer\', \'Login\')');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `username` varchar(21) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `username`, `password`, `nama`, `foto`) VALUES
(4, 'approver1', 'a8abe17c8a4dc107c42b9ceb7d98907d', 'Pak Trias', 'avatar5.png'),
(5, 'approver2', '83612ac9fbf80ea96b74f970cc873d5c', 'Pak Taukhid', 'avatar5.png'),
(6, 'approver3', '788b953fa8534027fb80d2d796dceec4', 'Pak Slamet', 'avatar5.png'),
(11, 'admin', '1e21d885875ce28ecd17872f40e67e05', 'GSS Developer', '1598935038_GSS.png'),
(17, 'ivanda', '202cb962ac59075b964b07152d234b70', 'Ivanda AJM', '1601087064_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigasi`
--

CREATE TABLE `menu_navigasi` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_navigasi`
--

INSERT INTO `menu_navigasi` (`id_menu`, `nama_menu`, `url`, `id_parent`, `no_urut`, `icon`, `status`) VALUES
(1, 'MASTER DATA', '#', 0, 2, 'database', 0),
(2, 'Menu Navigasi', 'menu-navigasi', 1, 1, 'bars', 0),
(3, 'Login', 'login', 1, 2, 'users', 0),
(4, 'Hak Akses', 'systemrole', 1, 3, 'user-tag', 0),
(5, 'Barang', 'akt-item', 1, 4, 'box', 0),
(6, 'Mitra Bisnis', 'akt-mitra-bisnis', 1, 5, 'users', 0),
(7, 'Merk Barang', 'akt-merk', 1, 6, 'boxes', 0),
(8, 'Akun', 'akt-akun', 1, 7, 'check', 0),
(9, 'Gudang', 'akt-gudang', 1, 8, 'home', 0),
(10, 'Kas/Bank', 'akt-kas-bank', 1, 9, 'building', 0),
(11, 'Terminal Kasir', 'akt-terminal-kasir', 1, 10, 'train', 1),
(12, 'Mesin EDC', 'akt-mesin-edc', 1, 11, 'calendar-alt', 1),
(13, 'Kartu Kredit', 'akt-credit-card', 1, 12, 'credit-card', 1),
(14, 'Departemen', 'akt-departement', 1, 13, 'clipboard-list', 1),
(15, 'Proyek', 'akt-proyek', 1, 14, 'gavel', 1),
(16, 'Kota', 'akt-kota', 1, 15, 'map-marker-alt', 0),
(17, 'Cabang', 'akt-cabang', 1, 16, 'flag-checkered', 1),
(18, 'Mata Uang', 'akt-mata-uang', 1, 17, 'usd', 0),
(19, 'Pajak', 'akt-pajak', 1, 18, 'hand-holding-usd', 1),
(20, 'Pegawai', 'akt-pegawai', 1, 19, 'user-tie', 0),
(21, 'Sales', 'akt-sales', 1, 20, 'street-view', 0),
(22, 'Penagih', 'akt-penagih', 1, 21, 'address-book', 1),
(23, 'Level Harga', 'akt-level-harga', 1, 22, 'level-up-alt', 0),
(24, 'PEMBELIAN', '#', 0, 2, 'cart-plus', 0),
(25, 'Permintaan Pembelian', 'akt-permintaan-pembelian', 24, 1, 'file', 1),
(26, 'Order Pembelian', 'akt-pembelian', 24, 2, 'barcode', 0),
(27, 'Penerimaan Pembelian', 'akt-pembelian-penerimaan-sendiri', 24, 4, 'handshake-o ', 0),
(28, 'Pembelian', 'akt-pembelian-pembelian', 24, 3, 'shopping-cart ', 0),
(29, 'Tipe Barang', 'akt-item-tipe', 1, 23, 'list', 0),
(30, 'Satuan', 'akt-satuan', 1, 24, 'list', 0),
(31, 'Pembelian Harta Tetap', 'akt-pembelian-harta-tetap', 24, 6, 'list-alt', 1),
(32, 'STOK', '#', 0, 3, 'warehouse', 0),
(33, 'PRODUKSI', '#', 0, 4, 'chart-area', 0),
(34, 'KAS / BANK', '#', 0, 5, 'money-check-alt', 0),
(35, 'PENJUALAN', '#', 0, 6, 'shopping-cart', 0),
(36, 'AKUNTANSI', '#', 0, 7, 'chart-bar', 0),
(37, 'SISTEM', '#', 0, 8, 'cogs', 0),
(38, 'Permintaan Barang', 'akt-permintaan-barang', 32, 1, 'list', 1),
(39, 'Klasifikasi', 'akt-klasifikasi', 1, 25, 'list', 0),
(40, 'Bill of Material', 'akt-bom', 33, 1, 'credit-card ', 0),
(41, 'Penyesuaian Stok', 'akt-penyesuaian-stok', 32, 2, 'th-large', 0),
(42, 'Produksi B.o.M', 'akt-produksi-bom', 33, 2, 'area-chart', 0),
(43, 'Stok Masuk', 'akt-stok-masuk', 32, 3, 'cart-plus', 0),
(44, 'Produksi Manual', 'akt-produksi-manual', 33, 3, 'area-chart', 0),
(45, 'Stok Keluar', 'akt-stok-keluar', 32, 4, 'cart-plus', 0),
(46, 'Laporan Produksi', 'akt-laporan-produksi', 33, 4, 'fa fa-file', 0),
(47, 'Transfer Stok', 'akt-transfer-stok', 32, 5, 'truck', 0),
(48, 'Stok Opname', 'akt-stok-opname', 32, 6, 'cubes', 0),
(49, 'Penerimaan Biaya', 'akt-penerimaan-pembayaran', 34, 1, 'money-check-alt', 0),
(50, 'Pembayaran', 'akt_pembayaran', 34, 2, 'money-check-alt', 1),
(51, 'Pembayaran Biaya', 'akt-pembayaran-biaya', 34, 3, 'money-check-alt', 0),
(52, 'Uang Muka', 'akt-uang-muka', 34, 4, 'money-check-alt', 1),
(53, 'Lihat Kas', 'akt-lihat-kas', 34, 5, 'money-check-alt', 0),
(54, 'Lihat Piutang', 'akt-piutang', 34, 6, 'money-check-alt', 0),
(55, 'Penyesuaian Kas', 'akt-penyesuaian-kas', 34, 8, 'fa fa-tasks', 0),
(56, 'Transfer Kas', 'akt-transfer-kas', 34, 8, 'fa fa-book', 0),
(57, 'Cek/Giro', 'akt-cek-giro', 34, 9, 'fa fa-list-alt', 0),
(58, 'Rekonsiliasi Bank', 'akt-rekonsiliasi-bank', 34, 10, 'money-check-alt', 1),
(59, 'Laporan Kas', 'akt-laporan-kas', 34, 11, 'folder', 0),
(60, 'Penawaran Penjualan', 'akt-penawaran-penjualan', 35, 1, 'shopping-cart', 1),
(61, 'Order Penjualan', 'akt-penjualan', 35, 2, 'shopping-cart', 0),
(62, 'Penjualan', 'akt-penjualan-penjualan', 35, 3, 'shopping-cart', 0),
(63, 'Pengiriman', 'akt-penjualan-pengiriman-parent', 35, 4, 'truck', 0),
(65, 'Penjualan Harta Tetap', 'akt-penjualan-harta-tetap', 35, 10, 'shopping-cart', 0),
(67, 'Retur Penjualan', 'akt-retur-penjualan', 35, 8, 'shopping-cart', 0),
(68, 'Nota Potong', 'akt-nota-poong', 35, 9, 'shopping-cart', 1),
(69, 'Jurnal Umum', 'akt-jurnal-umum', 36, 1, 'chart-bar', 0),
(70, 'Tutup Buku', 'akt-tutup-buku', 36, 2, 'chart-bar', 0),
(71, 'Tutup Buku Tahun', 'akt-tutup-buku-tahun', 36, 3, 'chart-bar', 1),
(73, 'Anggaran', 'akt-anggaran', 36, 5, 'money', 0),
(74, 'Harta Tetap', 'akt-harta-tetap', 1, 29, 'chart-bar', 1),
(76, 'Kelompok Harta Tetap', 'akt-kelompok-harta-tetap', 1, 30, 'chart-bar', 1),
(77, 'Laporan Stok', 'akt-laporan-stok', 32, 7, 'file', 0),
(78, 'Jurnal Transaksi', 'jurnal-transaksi', 1, 26, 'chart-bar', 0),
(79, 'Data Perusahaan', 'setting', 37, 1, 'hospital-o', 0),
(80, 'Lihat Hutang', 'akt-hutang', 34, 7, 'money-check-alt', 0),
(81, 'Retur Pembelian', 'akt-retur-pembelian', 24, 5, 'list', 0),
(82, 'Depresisi Harta Tetap', '#', 36, 9, 'money-check-alt', 1),
(83, 'Pengafkiran Harta Tetap', '#', 36, 10, 'money-check-alt', 1),
(84, 'Laporan Akuntansi', 'akt-laporan-akuntansi', 36, 12, 'file', 0),
(85, 'Approver', 'akt-approver', 1, 27, 'users', 0),
(86, 'Jenis Approver', 'akt-jenis-approver', 1, 28, 'users', 0),
(87, 'Pengajuan Biaya', 'akt-pengajuan-biaya', 34, 12, 'book', 0),
(88, 'Lihat Stok', 'akt-lihat-stok', 32, 8, 'cube', 0),
(89, 'Set Saldo Awal Kas', 'akt-saldo-awal-kas', 37, 2, 'bank', 0),
(90, 'Set Saldo Awal Akun', 'akt-saldo-awal-akun', 37, 3, 'fa fa-check', 0),
(91, 'Set Saldo Awal Stok', 'akt-saldo-awal-stok', 37, 4, 'cube', 0),
(92, 'Home', 'site', 0, 1, 'home', 0),
(93, 'Jurnal Penyesuaian', 'akt-jurnal-umum-penyesuaian', 36, 11, 'book', 0),
(94, 'Laporan Penjualan', 'akt-laporan-penjualan', 35, 11, 'file-text', 0),
(95, 'Laporan Pembelian', 'akt-laporan-pembelian', 24, 7, 'file-text', 0),
(96, 'Log', 'log', 37, 5, 'list-ul', 0),
(97, 'Rekap Log', 'log/rekap-log', 37, 6, 'list-ul', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_navigasi_role`
--

CREATE TABLE `menu_navigasi_role` (
  `id_menu_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_system_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_navigasi_role`
--

INSERT INTO `menu_navigasi_role` (`id_menu_role`, `id_menu`, `id_system_role`) VALUES
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 1),
(8, 7, 1),
(9, 8, 1),
(10, 9, 1),
(11, 10, 1),
(12, 11, 1),
(13, 12, 1),
(14, 13, 1),
(15, 14, 1),
(16, 15, 1),
(17, 16, 1),
(18, 17, 1),
(20, 19, 1),
(21, 20, 1),
(22, 21, 1),
(23, 22, 1),
(24, 23, 1),
(25, 24, 1),
(26, 25, 1),
(27, 26, 1),
(29, 27, 1),
(30, 28, 1),
(31, 29, 1),
(32, 30, 1),
(33, 31, 1),
(36, 34, 1),
(37, 35, 1),
(38, 36, 1),
(39, 37, 1),
(45, 41, 1),
(47, 43, 1),
(49, 44, 1),
(50, 45, 1),
(54, 46, 1),
(55, 47, 1),
(56, 48, 1),
(57, 49, 1),
(58, 50, 1),
(59, 51, 1),
(60, 52, 1),
(61, 53, 1),
(62, 54, 1),
(63, 55, 1),
(64, 56, 1),
(65, 57, 1),
(66, 58, 1),
(67, 59, 1),
(68, 60, 1),
(69, 61, 1),
(70, 62, 1),
(71, 63, 1),
(72, 65, 1),
(73, 67, 1),
(74, 68, 1),
(75, 69, 1),
(76, 70, 1),
(77, 71, 1),
(78, 73, 1),
(81, 77, 1),
(84, 79, 1),
(85, 80, 1),
(86, 81, 1),
(87, 82, 1),
(88, 83, 1),
(89, 84, 1),
(90, 85, 1),
(94, 33, 6),
(95, 33, 1),
(98, 40, 6),
(99, 40, 1),
(100, 42, 6),
(101, 42, 1),
(102, 32, 6),
(103, 32, 1),
(104, 38, 6),
(105, 38, 1),
(106, 88, 1),
(107, 89, 1),
(109, 90, 1),
(110, 91, 1),
(111, 92, 6),
(112, 92, 1),
(113, 93, 1),
(117, 1, 9),
(118, 1, 1),
(122, 87, 9),
(123, 87, 1),
(124, 76, 9),
(125, 76, 1),
(126, 74, 9),
(127, 74, 1),
(128, 94, 9),
(129, 94, 1),
(131, 95, 6),
(132, 95, 1),
(134, 78, 9),
(135, 2, 9),
(136, 18, 9),
(137, 39, 9),
(138, 86, 9),
(139, 96, 9),
(140, 96, 1),
(141, 97, 9),
(142, 97, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `nama_usaha` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `fax` varchar(200) NOT NULL,
  `npwp` varchar(200) NOT NULL,
  `direktur` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `nama`, `nama_usaha`, `email`, `alamat`, `id_kota`, `telepon`, `fax`, `npwp`, `direktur`) VALUES
(1, 'GSS ACCOUNTING', 'SOFTWARE HOUSE', 'accounting@klikgss.com', 'Jl. MH THAMRIN NO 28, \r\nSemarang, Indonesia', 1, '085998887776', '123456789', '987654321', 'Daniel ');

-- --------------------------------------------------------

--
-- Table structure for table `system_role`
--

CREATE TABLE `system_role` (
  `id_system_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_role`
--

INSERT INTO `system_role` (`id_system_role`, `nama_role`) VALUES
(1, 'SYSTEM ADMINISTRATOR'),
(6, 'MANAGER'),
(9, 'DEVELOPER');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` int(11) NOT NULL,
  `id_system_role` int(11) NOT NULL,
  `id_login` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `id_system_role`, `id_login`) VALUES
(1, 1, 1),
(5, 1, 2),
(18, 9, 3),
(6, 6, 4),
(7, 6, 5),
(8, 6, 6),
(9, 6, 7),
(10, 6, 8),
(11, 1, 8),
(12, 1, 9),
(14, 6, 10),
(28, 9, 11),
(19, 1, 3),
(20, 9, 12),
(21, 1, 12),
(22, 6, 13),
(23, 1, 13),
(24, 9, 15),
(25, 1, 15),
(26, 6, 16),
(27, 1, 16),
(29, 1, 11),
(30, 1, 17);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akt_akun`
--
ALTER TABLE `akt_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `akt_approver`
--
ALTER TABLE `akt_approver`
  ADD PRIMARY KEY (`id_approver`);

--
-- Indexes for table `akt_bom`
--
ALTER TABLE `akt_bom`
  ADD PRIMARY KEY (`id_bom`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `akt_bom_detail_bb`
--
ALTER TABLE `akt_bom_detail_bb`
  ADD PRIMARY KEY (`id_bom_detail_bb`);

--
-- Indexes for table `akt_bom_detail_hp`
--
ALTER TABLE `akt_bom_detail_hp`
  ADD PRIMARY KEY (`id_bom_hasil_detail_hp`);

--
-- Indexes for table `akt_cabang`
--
ALTER TABLE `akt_cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indexes for table `akt_cek_giro`
--
ALTER TABLE `akt_cek_giro`
  ADD PRIMARY KEY (`id_cek_giro`);

--
-- Indexes for table `akt_credit_card`
--
ALTER TABLE `akt_credit_card`
  ADD PRIMARY KEY (`id_cc`);

--
-- Indexes for table `akt_departement`
--
ALTER TABLE `akt_departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Indexes for table `akt_gmb_dua`
--
ALTER TABLE `akt_gmb_dua`
  ADD PRIMARY KEY (`id_gmb_dua`);

--
-- Indexes for table `akt_gmb_satu`
--
ALTER TABLE `akt_gmb_satu`
  ADD PRIMARY KEY (`id_gmb_satu`);

--
-- Indexes for table `akt_gmb_tiga`
--
ALTER TABLE `akt_gmb_tiga`
  ADD PRIMARY KEY (`id_gmb_tiga`);

--
-- Indexes for table `akt_gudang`
--
ALTER TABLE `akt_gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `akt_harta_tetap`
--
ALTER TABLE `akt_harta_tetap`
  ADD PRIMARY KEY (`id_harta_tetap`),
  ADD KEY `id_kelompok_harta_tetap` (`id_kelompok_harta_tetap`);

--
-- Indexes for table `akt_history_transaksi`
--
ALTER TABLE `akt_history_transaksi`
  ADD PRIMARY KEY (`id_history_transaksi`);

--
-- Indexes for table `akt_item`
--
ALTER TABLE `akt_item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `akt_item_harga_jual`
--
ALTER TABLE `akt_item_harga_jual`
  ADD PRIMARY KEY (`id_item_harga_jual`);

--
-- Indexes for table `akt_item_stok`
--
ALTER TABLE `akt_item_stok`
  ADD PRIMARY KEY (`id_item_stok`);

--
-- Indexes for table `akt_item_tipe`
--
ALTER TABLE `akt_item_tipe`
  ADD PRIMARY KEY (`id_tipe_item`);

--
-- Indexes for table `akt_jenis_approver`
--
ALTER TABLE `akt_jenis_approver`
  ADD PRIMARY KEY (`id_jenis_approver`);

--
-- Indexes for table `akt_jurnal_umum`
--
ALTER TABLE `akt_jurnal_umum`
  ADD PRIMARY KEY (`id_jurnal_umum`);

--
-- Indexes for table `akt_jurnal_umum_detail`
--
ALTER TABLE `akt_jurnal_umum_detail`
  ADD PRIMARY KEY (`id_jurnal_umum_detail`),
  ADD KEY `id_jurnal_umum` (`id_jurnal_umum`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `akt_kas_bank`
--
ALTER TABLE `akt_kas_bank`
  ADD PRIMARY KEY (`id_kas_bank`);

--
-- Indexes for table `akt_kelompok_harta_tetap`
--
ALTER TABLE `akt_kelompok_harta_tetap`
  ADD PRIMARY KEY (`id_kelompok_harta_tetap`),
  ADD KEY `id_akun_depresiasi` (`id_akun_depresiasi`),
  ADD KEY `id_akun_akumulasi` (`id_akun_akumulasi`),
  ADD KEY `id_akun_harta` (`id_akun_harta`);

--
-- Indexes for table `akt_klasifikasi`
--
ALTER TABLE `akt_klasifikasi`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `akt_kota`
--
ALTER TABLE `akt_kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `akt_laba_rugi`
--
ALTER TABLE `akt_laba_rugi`
  ADD PRIMARY KEY (`id_laba_rugi`);

--
-- Indexes for table `akt_laba_rugi_detail`
--
ALTER TABLE `akt_laba_rugi_detail`
  ADD PRIMARY KEY (`id_laba_rugi_detail`);

--
-- Indexes for table `akt_laporan_ekuitas`
--
ALTER TABLE `akt_laporan_ekuitas`
  ADD PRIMARY KEY (`id_laporan_ekuitas`);

--
-- Indexes for table `akt_laporan_posisi_keuangan`
--
ALTER TABLE `akt_laporan_posisi_keuangan`
  ADD PRIMARY KEY (`id_laporan_posisi_keuangan`);

--
-- Indexes for table `akt_level_harga`
--
ALTER TABLE `akt_level_harga`
  ADD PRIMARY KEY (`id_level_harga`);

--
-- Indexes for table `akt_mata_uang`
--
ALTER TABLE `akt_mata_uang`
  ADD PRIMARY KEY (`id_mata_uang`);

--
-- Indexes for table `akt_merk`
--
ALTER TABLE `akt_merk`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `akt_mitra_bisnis`
--
ALTER TABLE `akt_mitra_bisnis`
  ADD PRIMARY KEY (`id_mitra_bisnis`);

--
-- Indexes for table `akt_mitra_bisnis_alamat`
--
ALTER TABLE `akt_mitra_bisnis_alamat`
  ADD PRIMARY KEY (`id_mitra_bisnis_alamat`);

--
-- Indexes for table `akt_mitra_bisnis_bank_pajak`
--
ALTER TABLE `akt_mitra_bisnis_bank_pajak`
  ADD PRIMARY KEY (`id_mitra_bisnis_bank_pajak`);

--
-- Indexes for table `akt_mitra_bisnis_kontak`
--
ALTER TABLE `akt_mitra_bisnis_kontak`
  ADD PRIMARY KEY (`id_mitra_bisnis_kontak`);

--
-- Indexes for table `akt_mitra_bisnis_pembelian_penjualan`
--
ALTER TABLE `akt_mitra_bisnis_pembelian_penjualan`
  ADD PRIMARY KEY (`id_mitra_bisnis_pembelian_penjualan`);

--
-- Indexes for table `akt_pajak`
--
ALTER TABLE `akt_pajak`
  ADD PRIMARY KEY (`id_pajak`),
  ADD KEY `id_akun_pembelian` (`id_akun_pembelian`),
  ADD KEY `id_akun_penjualan` (`id_akun_penjualan`);

--
-- Indexes for table `akt_pegawai`
--
ALTER TABLE `akt_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `akt_pembayaran_biaya`
--
ALTER TABLE `akt_pembayaran_biaya`
  ADD PRIMARY KEY (`id_pembayaran_biaya`);

--
-- Indexes for table `akt_pembelian`
--
ALTER TABLE `akt_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_sales` (`id_sales`),
  ADD KEY `id_mata_uang` (`id_mata_uang`),
  ADD KEY `id_penagih` (`id_penagih`);

--
-- Indexes for table `akt_pembelian_detail`
--
ALTER TABLE `akt_pembelian_detail`
  ADD PRIMARY KEY (`id_pembelian_detail`);

--
-- Indexes for table `akt_pembelian_harta_tetap`
--
ALTER TABLE `akt_pembelian_harta_tetap`
  ADD PRIMARY KEY (`id_pembelian_harta_tetap`);

--
-- Indexes for table `akt_pembelian_penerimaan`
--
ALTER TABLE `akt_pembelian_penerimaan`
  ADD PRIMARY KEY (`id_pembelian_penerimaan`);

--
-- Indexes for table `akt_pembelian_penerimaan_detail`
--
ALTER TABLE `akt_pembelian_penerimaan_detail`
  ADD PRIMARY KEY (`id_pembelian_penerimaan_detail`);

--
-- Indexes for table `akt_penagih`
--
ALTER TABLE `akt_penagih`
  ADD PRIMARY KEY (`id_penagih`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `akt_penawaran_penjualan`
--
ALTER TABLE `akt_penawaran_penjualan`
  ADD PRIMARY KEY (`id_penawaran_penjualan`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_sales` (`id_sales`),
  ADD KEY `id_mata_uang` (`id_mata_uang`),
  ADD KEY `id_pengirim` (`id_pengirim`),
  ADD KEY `id_penagih` (`id_penagih`);

--
-- Indexes for table `akt_penawaran_penjualan_detail`
--
ALTER TABLE `akt_penawaran_penjualan_detail`
  ADD PRIMARY KEY (`id_penawaran_penjualan_detail`),
  ADD KEY `id_penawaran_penjualan` (`id_penawaran_penjualan`),
  ADD KEY `id_item_stok` (`id_item_stok`);

--
-- Indexes for table `akt_penerimaan_pembayaran`
--
ALTER TABLE `akt_penerimaan_pembayaran`
  ADD PRIMARY KEY (`id_penerimaan_pembayaran_penjualan`);

--
-- Indexes for table `akt_pengajuan_biaya`
--
ALTER TABLE `akt_pengajuan_biaya`
  ADD PRIMARY KEY (`id_pengajuan_biaya`);

--
-- Indexes for table `akt_pengajuan_biaya_detail`
--
ALTER TABLE `akt_pengajuan_biaya_detail`
  ADD PRIMARY KEY (`id_pengajuan_biaya_detail`);

--
-- Indexes for table `akt_penjualan`
--
ALTER TABLE `akt_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `akt_penjualan_detail`
--
ALTER TABLE `akt_penjualan_detail`
  ADD PRIMARY KEY (`id_penjualan_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_item_stok` (`id_item_stok`);

--
-- Indexes for table `akt_penjualan_harta_tetap`
--
ALTER TABLE `akt_penjualan_harta_tetap`
  ADD PRIMARY KEY (`id_penjualan_harta_tetap`);

--
-- Indexes for table `akt_penjualan_harta_tetap_detail`
--
ALTER TABLE `akt_penjualan_harta_tetap_detail`
  ADD PRIMARY KEY (`id_penjualan_harta_tetap_detail`),
  ADD KEY `id_penjualan` (`id_penjualan_harta_tetap`),
  ADD KEY `id_item_stok` (`id_item_stok`);

--
-- Indexes for table `akt_penjualan_pengiriman`
--
ALTER TABLE `akt_penjualan_pengiriman`
  ADD PRIMARY KEY (`id_penjualan_pengiriman`);

--
-- Indexes for table `akt_penjualan_pengiriman_detail`
--
ALTER TABLE `akt_penjualan_pengiriman_detail`
  ADD PRIMARY KEY (`id_penjualan_pengiriman_detail`);

--
-- Indexes for table `akt_penyesuaian_kas`
--
ALTER TABLE `akt_penyesuaian_kas`
  ADD PRIMARY KEY (`id_penyesuaian_kas`);

--
-- Indexes for table `akt_penyesuaian_stok`
--
ALTER TABLE `akt_penyesuaian_stok`
  ADD PRIMARY KEY (`id_penyesuaian_stok`);

--
-- Indexes for table `akt_penyesuaian_stok_detail`
--
ALTER TABLE `akt_penyesuaian_stok_detail`
  ADD PRIMARY KEY (`id_penyesuaian_stok_detail`);

--
-- Indexes for table `akt_permintaan_barang`
--
ALTER TABLE `akt_permintaan_barang`
  ADD PRIMARY KEY (`id_permintaan_barang`);

--
-- Indexes for table `akt_permintaan_barang_detail`
--
ALTER TABLE `akt_permintaan_barang_detail`
  ADD PRIMARY KEY (`id_permintaan_barang_detail`);

--
-- Indexes for table `akt_permintaan_barang_pegawai`
--
ALTER TABLE `akt_permintaan_barang_pegawai`
  ADD PRIMARY KEY (`id_permintaan_barang_pegawai`);

--
-- Indexes for table `akt_permintaan_pembelian`
--
ALTER TABLE `akt_permintaan_pembelian`
  ADD PRIMARY KEY (`id_permintaan_pembelian`);

--
-- Indexes for table `akt_produksi_bom`
--
ALTER TABLE `akt_produksi_bom`
  ADD PRIMARY KEY (`id_produksi_bom`);

--
-- Indexes for table `akt_produksi_bom_detail_bb`
--
ALTER TABLE `akt_produksi_bom_detail_bb`
  ADD PRIMARY KEY (`id_produksi_bom_detail_bb`);

--
-- Indexes for table `akt_produksi_bom_detail_hp`
--
ALTER TABLE `akt_produksi_bom_detail_hp`
  ADD PRIMARY KEY (`id_produksi_bom_detail_hp`);

--
-- Indexes for table `akt_produksi_manual`
--
ALTER TABLE `akt_produksi_manual`
  ADD PRIMARY KEY (`id_produksi_manual`);

--
-- Indexes for table `akt_produksi_manual_detail_bb`
--
ALTER TABLE `akt_produksi_manual_detail_bb`
  ADD PRIMARY KEY (`id_produksi_manual_detail_bb`);

--
-- Indexes for table `akt_produksi_manual_detail_hp`
--
ALTER TABLE `akt_produksi_manual_detail_hp`
  ADD PRIMARY KEY (`id_produksi_manual_detail_hp`);

--
-- Indexes for table `akt_proyek`
--
ALTER TABLE `akt_proyek`
  ADD PRIMARY KEY (`id_proyek`);

--
-- Indexes for table `akt_retur_pembelian`
--
ALTER TABLE `akt_retur_pembelian`
  ADD PRIMARY KEY (`id_retur_pembelian`);

--
-- Indexes for table `akt_retur_pembelian_detail`
--
ALTER TABLE `akt_retur_pembelian_detail`
  ADD PRIMARY KEY (`id_retur_pembelian_detail`);

--
-- Indexes for table `akt_retur_penjualan`
--
ALTER TABLE `akt_retur_penjualan`
  ADD PRIMARY KEY (`id_retur_penjualan`),
  ADD KEY `id_penjualan` (`id_penjualan_pengiriman`);

--
-- Indexes for table `akt_retur_penjualan_detail`
--
ALTER TABLE `akt_retur_penjualan_detail`
  ADD PRIMARY KEY (`id_retur_penjualan_detail`),
  ADD KEY `id_retur_penjualan` (`id_retur_penjualan`),
  ADD KEY `id_item` (`id_penjualan_pengiriman_detail`);

--
-- Indexes for table `akt_saldo_awal_akun`
--
ALTER TABLE `akt_saldo_awal_akun`
  ADD PRIMARY KEY (`id_saldo_awal_akun`);

--
-- Indexes for table `akt_saldo_awal_akun_detail`
--
ALTER TABLE `akt_saldo_awal_akun_detail`
  ADD PRIMARY KEY (`id_saldo_awal_akun_detail`);

--
-- Indexes for table `akt_saldo_awal_kas`
--
ALTER TABLE `akt_saldo_awal_kas`
  ADD PRIMARY KEY (`id_saldo_awal_kas`);

--
-- Indexes for table `akt_saldo_awal_stok`
--
ALTER TABLE `akt_saldo_awal_stok`
  ADD PRIMARY KEY (`id_saldo_awal_stok`);

--
-- Indexes for table `akt_saldo_awal_stok_detail`
--
ALTER TABLE `akt_saldo_awal_stok_detail`
  ADD PRIMARY KEY (`id_saldo_awal_stok_detail`);

--
-- Indexes for table `akt_sales`
--
ALTER TABLE `akt_sales`
  ADD PRIMARY KEY (`id_sales`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `akt_satuan`
--
ALTER TABLE `akt_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `akt_stok_keluar`
--
ALTER TABLE `akt_stok_keluar`
  ADD PRIMARY KEY (`id_stok_keluar`);

--
-- Indexes for table `akt_stok_keluar_detail`
--
ALTER TABLE `akt_stok_keluar_detail`
  ADD PRIMARY KEY (`id_stok_keluar_detail`);

--
-- Indexes for table `akt_stok_masuk`
--
ALTER TABLE `akt_stok_masuk`
  ADD PRIMARY KEY (`id_stok_masuk`);

--
-- Indexes for table `akt_stok_masuk_detail`
--
ALTER TABLE `akt_stok_masuk_detail`
  ADD PRIMARY KEY (`id_stok_masuk_detail`);

--
-- Indexes for table `akt_stok_opname`
--
ALTER TABLE `akt_stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`);

--
-- Indexes for table `akt_stok_opname_detail`
--
ALTER TABLE `akt_stok_opname_detail`
  ADD PRIMARY KEY (`id_stok_opname_detail`);

--
-- Indexes for table `akt_transfer_kas`
--
ALTER TABLE `akt_transfer_kas`
  ADD PRIMARY KEY (`id_transfer_kas`);

--
-- Indexes for table `akt_transfer_stok`
--
ALTER TABLE `akt_transfer_stok`
  ADD PRIMARY KEY (`id_transfer_stok`);

--
-- Indexes for table `akt_transfer_stok_detail`
--
ALTER TABLE `akt_transfer_stok_detail`
  ADD PRIMARY KEY (`id_transfer_stok_detail`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indexes for table `item_pembelian_harta_tetap`
--
ALTER TABLE `item_pembelian_harta_tetap`
  ADD PRIMARY KEY (`id_item_pembelian_harta_tetap`);

--
-- Indexes for table `item_permintaan_pembelian`
--
ALTER TABLE `item_permintaan_pembelian`
  ADD PRIMARY KEY (`id_item_permintaan_pembelian`);

--
-- Indexes for table `jurnal_transaksi`
--
ALTER TABLE `jurnal_transaksi`
  ADD PRIMARY KEY (`id_jurnal_transaksi`);

--
-- Indexes for table `jurnal_transaksi_detail`
--
ALTER TABLE `jurnal_transaksi_detail`
  ADD PRIMARY KEY (`id_jurnal_transaksi_detail`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `menu_navigasi`
--
ALTER TABLE `menu_navigasi`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_parent` (`id_parent`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `menu_navigasi_role`
--
ALTER TABLE `menu_navigasi_role`
  ADD PRIMARY KEY (`id_menu_role`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_system_role` (`id_system_role`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `system_role`
--
ALTER TABLE `system_role`
  ADD PRIMARY KEY (`id_system_role`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`),
  ADD KEY `id_system_role` (`id_system_role`),
  ADD KEY `id_login` (`id_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akt_akun`
--
ALTER TABLE `akt_akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `akt_approver`
--
ALTER TABLE `akt_approver`
  MODIFY `id_approver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `akt_bom`
--
ALTER TABLE `akt_bom`
  MODIFY `id_bom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_bom_detail_bb`
--
ALTER TABLE `akt_bom_detail_bb`
  MODIFY `id_bom_detail_bb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_bom_detail_hp`
--
ALTER TABLE `akt_bom_detail_hp`
  MODIFY `id_bom_hasil_detail_hp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_cabang`
--
ALTER TABLE `akt_cabang`
  MODIFY `id_cabang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_cek_giro`
--
ALTER TABLE `akt_cek_giro`
  MODIFY `id_cek_giro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_credit_card`
--
ALTER TABLE `akt_credit_card`
  MODIFY `id_cc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_departement`
--
ALTER TABLE `akt_departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_gmb_dua`
--
ALTER TABLE `akt_gmb_dua`
  MODIFY `id_gmb_dua` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_gmb_satu`
--
ALTER TABLE `akt_gmb_satu`
  MODIFY `id_gmb_satu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_gmb_tiga`
--
ALTER TABLE `akt_gmb_tiga`
  MODIFY `id_gmb_tiga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_gudang`
--
ALTER TABLE `akt_gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_harta_tetap`
--
ALTER TABLE `akt_harta_tetap`
  MODIFY `id_harta_tetap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_history_transaksi`
--
ALTER TABLE `akt_history_transaksi`
  MODIFY `id_history_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `akt_item`
--
ALTER TABLE `akt_item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_item_harga_jual`
--
ALTER TABLE `akt_item_harga_jual`
  MODIFY `id_item_harga_jual` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_item_stok`
--
ALTER TABLE `akt_item_stok`
  MODIFY `id_item_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_item_tipe`
--
ALTER TABLE `akt_item_tipe`
  MODIFY `id_tipe_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_jenis_approver`
--
ALTER TABLE `akt_jenis_approver`
  MODIFY `id_jenis_approver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `akt_jurnal_umum`
--
ALTER TABLE `akt_jurnal_umum`
  MODIFY `id_jurnal_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `akt_jurnal_umum_detail`
--
ALTER TABLE `akt_jurnal_umum_detail`
  MODIFY `id_jurnal_umum_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `akt_kas_bank`
--
ALTER TABLE `akt_kas_bank`
  MODIFY `id_kas_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `akt_kelompok_harta_tetap`
--
ALTER TABLE `akt_kelompok_harta_tetap`
  MODIFY `id_kelompok_harta_tetap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_klasifikasi`
--
ALTER TABLE `akt_klasifikasi`
  MODIFY `id_klasifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `akt_kota`
--
ALTER TABLE `akt_kota`
  MODIFY `id_kota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `akt_laba_rugi`
--
ALTER TABLE `akt_laba_rugi`
  MODIFY `id_laba_rugi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_laba_rugi_detail`
--
ALTER TABLE `akt_laba_rugi_detail`
  MODIFY `id_laba_rugi_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_laporan_ekuitas`
--
ALTER TABLE `akt_laporan_ekuitas`
  MODIFY `id_laporan_ekuitas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_laporan_posisi_keuangan`
--
ALTER TABLE `akt_laporan_posisi_keuangan`
  MODIFY `id_laporan_posisi_keuangan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_level_harga`
--
ALTER TABLE `akt_level_harga`
  MODIFY `id_level_harga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `akt_mata_uang`
--
ALTER TABLE `akt_mata_uang`
  MODIFY `id_mata_uang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `akt_merk`
--
ALTER TABLE `akt_merk`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_mitra_bisnis`
--
ALTER TABLE `akt_mitra_bisnis`
  MODIFY `id_mitra_bisnis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_mitra_bisnis_alamat`
--
ALTER TABLE `akt_mitra_bisnis_alamat`
  MODIFY `id_mitra_bisnis_alamat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_mitra_bisnis_bank_pajak`
--
ALTER TABLE `akt_mitra_bisnis_bank_pajak`
  MODIFY `id_mitra_bisnis_bank_pajak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_mitra_bisnis_kontak`
--
ALTER TABLE `akt_mitra_bisnis_kontak`
  MODIFY `id_mitra_bisnis_kontak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_mitra_bisnis_pembelian_penjualan`
--
ALTER TABLE `akt_mitra_bisnis_pembelian_penjualan`
  MODIFY `id_mitra_bisnis_pembelian_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pajak`
--
ALTER TABLE `akt_pajak`
  MODIFY `id_pajak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `akt_pegawai`
--
ALTER TABLE `akt_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembayaran_biaya`
--
ALTER TABLE `akt_pembayaran_biaya`
  MODIFY `id_pembayaran_biaya` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembelian`
--
ALTER TABLE `akt_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembelian_detail`
--
ALTER TABLE `akt_pembelian_detail`
  MODIFY `id_pembelian_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembelian_harta_tetap`
--
ALTER TABLE `akt_pembelian_harta_tetap`
  MODIFY `id_pembelian_harta_tetap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembelian_penerimaan`
--
ALTER TABLE `akt_pembelian_penerimaan`
  MODIFY `id_pembelian_penerimaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pembelian_penerimaan_detail`
--
ALTER TABLE `akt_pembelian_penerimaan_detail`
  MODIFY `id_pembelian_penerimaan_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penagih`
--
ALTER TABLE `akt_penagih`
  MODIFY `id_penagih` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penawaran_penjualan`
--
ALTER TABLE `akt_penawaran_penjualan`
  MODIFY `id_penawaran_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penawaran_penjualan_detail`
--
ALTER TABLE `akt_penawaran_penjualan_detail`
  MODIFY `id_penawaran_penjualan_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penerimaan_pembayaran`
--
ALTER TABLE `akt_penerimaan_pembayaran`
  MODIFY `id_penerimaan_pembayaran_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pengajuan_biaya`
--
ALTER TABLE `akt_pengajuan_biaya`
  MODIFY `id_pengajuan_biaya` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_pengajuan_biaya_detail`
--
ALTER TABLE `akt_pengajuan_biaya_detail`
  MODIFY `id_pengajuan_biaya_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan`
--
ALTER TABLE `akt_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan_detail`
--
ALTER TABLE `akt_penjualan_detail`
  MODIFY `id_penjualan_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan_harta_tetap`
--
ALTER TABLE `akt_penjualan_harta_tetap`
  MODIFY `id_penjualan_harta_tetap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan_harta_tetap_detail`
--
ALTER TABLE `akt_penjualan_harta_tetap_detail`
  MODIFY `id_penjualan_harta_tetap_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan_pengiriman`
--
ALTER TABLE `akt_penjualan_pengiriman`
  MODIFY `id_penjualan_pengiriman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penjualan_pengiriman_detail`
--
ALTER TABLE `akt_penjualan_pengiriman_detail`
  MODIFY `id_penjualan_pengiriman_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penyesuaian_kas`
--
ALTER TABLE `akt_penyesuaian_kas`
  MODIFY `id_penyesuaian_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penyesuaian_stok`
--
ALTER TABLE `akt_penyesuaian_stok`
  MODIFY `id_penyesuaian_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_penyesuaian_stok_detail`
--
ALTER TABLE `akt_penyesuaian_stok_detail`
  MODIFY `id_penyesuaian_stok_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_permintaan_barang`
--
ALTER TABLE `akt_permintaan_barang`
  MODIFY `id_permintaan_barang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_permintaan_barang_detail`
--
ALTER TABLE `akt_permintaan_barang_detail`
  MODIFY `id_permintaan_barang_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_permintaan_barang_pegawai`
--
ALTER TABLE `akt_permintaan_barang_pegawai`
  MODIFY `id_permintaan_barang_pegawai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_permintaan_pembelian`
--
ALTER TABLE `akt_permintaan_pembelian`
  MODIFY `id_permintaan_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_bom`
--
ALTER TABLE `akt_produksi_bom`
  MODIFY `id_produksi_bom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_bom_detail_bb`
--
ALTER TABLE `akt_produksi_bom_detail_bb`
  MODIFY `id_produksi_bom_detail_bb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_bom_detail_hp`
--
ALTER TABLE `akt_produksi_bom_detail_hp`
  MODIFY `id_produksi_bom_detail_hp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_manual`
--
ALTER TABLE `akt_produksi_manual`
  MODIFY `id_produksi_manual` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_manual_detail_bb`
--
ALTER TABLE `akt_produksi_manual_detail_bb`
  MODIFY `id_produksi_manual_detail_bb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_produksi_manual_detail_hp`
--
ALTER TABLE `akt_produksi_manual_detail_hp`
  MODIFY `id_produksi_manual_detail_hp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_proyek`
--
ALTER TABLE `akt_proyek`
  MODIFY `id_proyek` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_retur_pembelian`
--
ALTER TABLE `akt_retur_pembelian`
  MODIFY `id_retur_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_retur_pembelian_detail`
--
ALTER TABLE `akt_retur_pembelian_detail`
  MODIFY `id_retur_pembelian_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_retur_penjualan`
--
ALTER TABLE `akt_retur_penjualan`
  MODIFY `id_retur_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_retur_penjualan_detail`
--
ALTER TABLE `akt_retur_penjualan_detail`
  MODIFY `id_retur_penjualan_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_saldo_awal_akun`
--
ALTER TABLE `akt_saldo_awal_akun`
  MODIFY `id_saldo_awal_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `akt_saldo_awal_akun_detail`
--
ALTER TABLE `akt_saldo_awal_akun_detail`
  MODIFY `id_saldo_awal_akun_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `akt_saldo_awal_kas`
--
ALTER TABLE `akt_saldo_awal_kas`
  MODIFY `id_saldo_awal_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_saldo_awal_stok`
--
ALTER TABLE `akt_saldo_awal_stok`
  MODIFY `id_saldo_awal_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_saldo_awal_stok_detail`
--
ALTER TABLE `akt_saldo_awal_stok_detail`
  MODIFY `id_saldo_awal_stok_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_sales`
--
ALTER TABLE `akt_sales`
  MODIFY `id_sales` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_satuan`
--
ALTER TABLE `akt_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `akt_stok_keluar`
--
ALTER TABLE `akt_stok_keluar`
  MODIFY `id_stok_keluar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_stok_keluar_detail`
--
ALTER TABLE `akt_stok_keluar_detail`
  MODIFY `id_stok_keluar_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_stok_masuk`
--
ALTER TABLE `akt_stok_masuk`
  MODIFY `id_stok_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_stok_masuk_detail`
--
ALTER TABLE `akt_stok_masuk_detail`
  MODIFY `id_stok_masuk_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_stok_opname`
--
ALTER TABLE `akt_stok_opname`
  MODIFY `id_stok_opname` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_stok_opname_detail`
--
ALTER TABLE `akt_stok_opname_detail`
  MODIFY `id_stok_opname_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_transfer_kas`
--
ALTER TABLE `akt_transfer_kas`
  MODIFY `id_transfer_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_transfer_stok`
--
ALTER TABLE `akt_transfer_stok`
  MODIFY `id_transfer_stok` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akt_transfer_stok_detail`
--
ALTER TABLE `akt_transfer_stok_detail`
  MODIFY `id_transfer_stok_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_pembelian_harta_tetap`
--
ALTER TABLE `item_pembelian_harta_tetap`
  MODIFY `id_item_pembelian_harta_tetap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_permintaan_pembelian`
--
ALTER TABLE `item_permintaan_pembelian`
  MODIFY `id_item_permintaan_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal_transaksi`
--
ALTER TABLE `jurnal_transaksi`
  MODIFY `id_jurnal_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jurnal_transaksi_detail`
--
ALTER TABLE `jurnal_transaksi_detail`
  MODIFY `id_jurnal_transaksi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `menu_navigasi`
--
ALTER TABLE `menu_navigasi`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `menu_navigasi_role`
--
ALTER TABLE `menu_navigasi_role`
  MODIFY `id_menu_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_role`
--
ALTER TABLE `system_role`
  MODIFY `id_system_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
