-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jan 2024 pada 09.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_depo_murah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` varchar(15) NOT NULL,
  `id_kategori_barang` varchar(10) DEFAULT NULL,
  `nm_barang` varchar(30) DEFAULT NULL,
  `harga_barang` int(11) DEFAULT NULL,
  `foto_barang` varchar(50) DEFAULT 'no_image.jpg',
  `deskripsi` varchar(255) DEFAULT NULL,
  `point_barang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `id_kategori_barang`, `nm_barang`, `harga_barang`, `foto_barang`, `deskripsi`, `point_barang`) VALUES
('BSI00001', 'K0002', 'Besi Ringan', 250000, '1704078966172.png', 'Besi Ringan Merk Bangunan,\r\nPanjan 10Meter', 25),
('BSI00002', 'K0002', 'Besi Hollow 3\"X5\"', 500000, '1704165099189.png', 'Besi Hollow 3\"X5\"\r\nPanjang 10meter', 100),
('KRM00001', 'K0001', 'Keramik 30X30 Putih Polos', 100000, 'no_image.jpg', 'Keramik 30X30 Putih Polos,\r\n1 Dus isi 5 keramik', 10),
('SMN00001', 'K0003', 'Semen tiga Roda', 150000, 'no_image.jpg', 'Semen tiga roda', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `id_barang_masuk` varchar(15) NOT NULL,
  `id_barang` varchar(15) DEFAULT NULL,
  `id_cabang` varchar(255) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `ket` varchar(500) DEFAULT NULL,
  `jumlah` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cabang`
--

CREATE TABLE `tb_cabang` (
  `id_cabang` varchar(10) NOT NULL,
  `nm_cabang` varchar(35) DEFAULT NULL,
  `alamat_cabang` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_cabang`
--

INSERT INTO `tb_cabang` (`id_cabang`, `nm_cabang`, `alamat_cabang`) VALUES
('CB001', 'Cabang 1', 'Jati Kudus'),
('CB002', 'Cabang 2', 'Kudus Kota');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dtl_penjualan`
--

CREATE TABLE `tb_dtl_penjualan` (
  `id_dtl_penjualan` int(11) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `id_barang` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_barang` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_dtl_penjualan`
--

INSERT INTO `tb_dtl_penjualan` (`id_dtl_penjualan`, `id_penjualan`, `id_barang`, `jumlah`, `harga_barang`, `subtotal`) VALUES
(4, 'J2400001', 'BSI00002', 5, 500000, 2500000),
(5, 'J2400002', 'BSI00002', 10, 500000, 5000000),
(6, 'J2400002', 'BSI00001', 20, 250000, 5000000),
(7, 'J2400003', 'BSI00001', 10, 250000, 2500000),
(8, 'J2400003', 'KRM00001', 100, 100000, 10000000),
(9, 'J2400003', 'SMN00001', 200, 150000, 30000000),
(10, 'J2400004', 'KRM00001', 100, 100000, 10000000),
(11, 'J2400005', 'BSI00002', 5, 500000, 2500000),
(12, 'J2400006', 'KRM00001', 50, 100000, 5000000),
(13, 'J2400007', 'BSI00002', 3, 500000, 1500000),
(14, 'J2400008', 'KRM00001', 10, 100000, 1000000),
(15, 'J2400009', 'SMN00001', 5, 150000, 750000),
(16, 'J2400010', 'BSI00002', 6, 500000, 3000000),
(17, 'J2400010', 'SMN00001', 10, 150000, 1500000),
(18, 'J2400011', 'SMN00001', 12, 150000, 1800000),
(19, 'J2400012', 'BSI00001', 5, 250000, 1250000),
(20, 'J2400013', 'SMN00001', 10, 150000, 1500000),
(21, 'J2400013', 'KRM00001', 50, 100000, 5000000),
(22, 'J2400014', 'BSI00002', 1, 500000, 500000),
(23, 'J2400014', 'KRM00001', 1, 100000, 100000),
(24, 'J2400014', 'BSI00001', 1, 250000, 250000),
(25, 'J2400015', 'KRM00001', 10, 100000, 1000000),
(26, 'J2400016', 'KRM00001', 1, 100000, 100000),
(27, 'J2400017', 'BSI00001', 10, 250000, 2500000),
(28, 'J2400018', 'BSI00002', 1, 500000, 500000),
(29, 'J2400019', 'SMN00001', 5, 150000, 750000),
(30, 'J2400020', 'KRM00001', 1, 100000, 100000),
(31, 'J2400021', 'KRM00001', 5, 100000, 500000),
(32, 'J2400022', 'SMN00001', 3, 150000, 450000),
(33, 'J2400023', 'BSI00002', 1, 500000, 500000),
(34, 'J2400024', 'SMN00001', 4, 150000, 600000),
(35, 'J2400025', 'SMN00001', 1, 150000, 150000),
(36, 'J2400026', 'KRM00001', 1, 100000, 100000),
(37, 'J2400027', 'BSI00002', 1, 500000, 500000),
(38, 'J2400028', 'BSI00002', 1, 500000, 500000),
(39, 'J2400029', 'KRM00001', 1, 100000, 100000),
(40, 'J2400030', 'KRM00001', 1, 100000, 100000),
(41, 'J2400031', 'SMN00001', 1, 150000, 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori_barang` varchar(10) NOT NULL,
  `nm_kategori` varchar(40) DEFAULT NULL,
  `kode_kategori` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kategori_barang`
--

INSERT INTO `tb_kategori_barang` (`id_kategori_barang`, `nm_kategori`, `kode_kategori`) VALUES
('K0001', 'Keramik', 'KRM'),
('K0002', 'Besi', 'BSI'),
('K0003', 'Semen', 'SMN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `kriteria` varchar(35) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`id_kriteria`, `kriteria`, `bobot`) VALUES
('KR001', 'Jumlah Pembelian', 0.521),
('KR002', 'Itensitas Pembelian', 0.271),
('KR003', 'Sikap pembeli', 0.146),
('KR004', 'Cara Pengantaran', 0.063);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` varchar(15) NOT NULL,
  `nm_pelanggan` varchar(35) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL,
  `no_pelanggan` varchar(13) DEFAULT NULL,
  `point_pelanggan` int(11) NOT NULL,
  `tgl_register` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `nm_pelanggan`, `alamat`, `no_pelanggan`, `point_pelanggan`, `tgl_register`) VALUES
('GUEST', 'Non Member', NULL, NULL, 0, '2024-01-01'),
('P2400001', 'Pelanggan 1', 'Alamat', '08524465132', 10, '2024-01-01'),
('P2400002', 'Pelanggan 2', 'Alamat', '08524465133', 10, '2024-01-01'),
('P2400003', 'Pelanggan 3', 'Alamat', '08524465134', 10, '2024-01-01'),
('P2400004', 'Pelanggan 4', 'Alamat', '08524465135', 100, '2024-01-01'),
('P2400005', 'Pelanggan 5', 'Alamat', '08524465136', 100, '2024-01-01'),
('P2400006', 'Pelanggan 6', 'Alamat', '08524465137', 10, '2024-01-01'),
('P2400007', 'Pelanggan 7', 'Alamat', '08524465138', 100, '2024-01-01'),
('P2400008', 'Pelanggan 8', 'Alamat', '08524465139', 10, '2024-01-01'),
('P2400009', 'Pelanggan 9', 'Alamat', '08524465140', 10, '2024-01-01'),
('P2400010', 'Pelanggan 10', 'Alamat', '08524465141', 200, '2024-01-01'),
('P2400011', 'Pelanggan 11', 'Alamat', '08524465142', 1000, '2024-01-01'),
('P2400012', 'Pelanggan 12', 'Alamat', '08524465143', 1000, '2024-01-01'),
('P2400013', 'Pelanggan 13', 'Alamat', '08524465144', 20000, '2024-01-01'),
('P2400014', 'Pelanggan 14', 'Alamat', '08524465145', 304000, '2024-01-01'),
('P2400015', 'Pelanggan 15', 'Alamat', '08524465146', 2000, '2024-01-01'),
('P2400016', 'Pelanggan 16', 'Alamat', '08524465147', 30000, '2024-01-01'),
('P2400017', 'Pelanggan 17', 'Alamat', '08524465148', 300, '2024-01-01'),
('P2400018', 'Pelanggan 18', 'Alamat', '08524465149', 10000, '2024-01-01'),
('P2400019', 'Pelanggan 19', 'Alamat', '08524465150', 1000, '2024-01-01'),
('P2400020', 'Pelanggan 20', 'Alamat', '08524465151', 1000, '2024-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `nominal_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` varchar(15) NOT NULL,
  `tgl_penjualan` datetime NOT NULL,
  `id_pelanggan` varchar(15) NOT NULL,
  `id_cabang` varchar(10) NOT NULL,
  `diskon` float NOT NULL,
  `tot_harga_barang` int(11) NOT NULL,
  `tot_akhir` int(11) NOT NULL,
  `created_by` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`id_penjualan`, `tgl_penjualan`, `id_pelanggan`, `id_cabang`, `diskon`, `tot_harga_barang`, `tot_akhir`, `created_by`) VALUES
('J2400001', '2024-01-03 13:11:26', 'P2400001', 'CB001', 0, 2500000, 2500000, 'U2400002'),
('J2400002', '2024-01-04 14:01:04', 'P2400001', 'CB001', 300, 10000000, 10000000, 'U2400002'),
('J2400003', '2024-01-04 14:02:06', 'P2400002', 'CB001', 10000, 42500000, 42500000, 'U2400002'),
('J2400004', '2024-01-04 14:02:33', 'P2400003', 'CB001', 1000, 10000000, 10000000, 'U2400002'),
('J2400005', '2024-01-04 14:02:58', 'P2400004', 'CB001', 1000, 2500000, 2500000, 'U2400002'),
('J2400006', '2024-01-04 14:03:21', 'P2400006', 'CB001', 304000, 5000000, 5000000, 'U2400002'),
('J2400007', '2024-01-04 14:03:54', 'P2400007', 'CB001', 2000, 1500000, 1500000, 'U2400002'),
('J2400008', '2024-01-04 14:04:17', 'P2400008', 'CB001', 30000, 1000000, 1000000, 'U2400002'),
('J2400009', '2024-01-04 14:04:46', 'P2400010', 'CB001', 10000, 750000, 750000, 'U2400002'),
('J2400010', '2024-01-04 14:05:16', 'P2400010', 'CB001', 100, 4500000, 4500000, 'U2400002'),
('J2400011', '2024-01-04 14:05:57', 'P2400009', 'CB001', 300, 1800000, 1800000, 'U2400002'),
('J2400012', '2024-01-04 14:12:44', 'P2400005', 'CB001', 0, 1250000, 1250000, 'U2400002'),
('J2400013', '2024-01-05 04:03:26', 'P2400001', 'CB001', 125, 6500000, 6500000, 'U2400002'),
('J2400014', '2024-01-08 03:32:03', 'P2400001', 'CB001', 110, 850000, 850000, 'U2400002'),
('J2400015', '2024-01-08 03:32:39', 'P2400005', 'CB001', 20000, 1000000, 1000000, 'U2400002'),
('J2400016', '2024-01-08 03:33:03', 'P2400002', 'CB001', 135, 100000, 100000, 'U2400002'),
('J2400017', '2024-01-08 03:33:28', 'P2400001', 'CB001', 135, 2500000, 2500000, 'U2400002'),
('J2400018', '2024-01-08 03:33:50', 'P2400005', 'CB001', 10, 500000, 500000, 'U2400002'),
('J2400019', '2024-01-08 03:34:14', 'P2400006', 'CB001', 10, 750000, 750000, 'U2400002'),
('J2400020', '2024-01-08 03:34:35', 'P2400006', 'CB001', 100, 100000, 100000, 'U2400002'),
('J2400021', '2024-01-08 03:35:02', 'P2400009', 'CB001', 100, 500000, 500000, 'U2400002'),
('J2400022', '2024-01-08 03:35:24', 'P2400001', 'CB001', 25, 450000, 450000, 'U2400002'),
('J2400023', '2024-01-08 03:35:42', 'P2400001', 'CB001', 100, 500000, 500000, 'U2400002'),
('J2400024', '2024-01-08 03:36:06', 'P2400005', 'CB001', 100, 600000, 600000, 'U2400002'),
('J2400025', '2024-01-08 03:36:46', 'P2400005', 'CB001', 100, 150000, 150000, 'U2400002'),
('J2400026', '2024-01-08 03:37:06', 'P2400006', 'CB001', 10, 100000, 100000, 'U2400002'),
('J2400027', '2024-01-08 03:37:26', 'P2400001', 'CB001', 100, 500000, 500000, 'U2400002'),
('J2400028', '2024-01-08 07:51:56', 'P2400005', 'CB001', 100, 500000, 500000, 'U2400002'),
('J2400029', '2024-01-08 07:52:15', 'P2400005', 'CB001', 100, 100000, 100000, 'U2400002'),
('J2400030', '2024-01-08 07:52:35', 'P2400001', 'CB001', 100, 100000, 100000, 'U2400002'),
('J2400031', '2024-01-08 07:52:58', 'P2400005', 'CB001', 10, 150000, 150000, 'U2400002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ranking`
--

CREATE TABLE `tb_ranking` (
  `id_ranking` int(11) NOT NULL,
  `id_pelanggan` varchar(15) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `KR001` float NOT NULL,
  `KR002` float NOT NULL,
  `KR003` float NOT NULL,
  `KR004` float NOT NULL,
  `TOTAL` float NOT NULL,
  `RANKING` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_real_kriteria_pelanggan`
--

CREATE TABLE `tb_real_kriteria_pelanggan` (
  `id_pelanggan` varchar(15) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `jml_pembelian` int(11) NOT NULL,
  `intensitas_pembelian` int(11) NOT NULL,
  `KR001` varchar(10) NOT NULL,
  `KR002` varchar(10) NOT NULL,
  `KR003` varchar(10) NOT NULL,
  `KR004` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_real_kriteria_pelanggan`
--

INSERT INTO `tb_real_kriteria_pelanggan` (`id_pelanggan`, `tahun`, `jml_pembelian`, `intensitas_pembelian`, `KR001`, `KR002`, `KR003`, `KR004`) VALUES
('P2400001', '2024', 114, 9, 'SK001', 'SK007', 'SK010', 'SK015'),
('P2400002', '2024', 311, 2, 'SK001', 'SK008', 'SK010', 'SK013'),
('P2400003', '2024', 100, 1, 'SK001', 'SK008', 'SK009', 'SK013'),
('P2400004', '2024', 5, 1, 'SK004', 'SK008', 'SK009', 'SK013'),
('P2400005', '2024', 24, 8, 'SK004', 'SK007', 'SK012', 'SK015'),
('P2400006', '2024', 57, 4, 'SK002', 'SK008', 'SK009', 'SK014'),
('P2400007', '2024', 3, 1, 'SK004', 'SK008', 'SK010', 'SK013'),
('P2400008', '2024', 10, 1, 'SK004', 'SK008', 'SK009', 'SK016'),
('P2400009', '2024', 17, 2, 'SK004', 'SK008', 'SK009', 'SK014'),
('P2400010', '2024', 21, 2, 'SK004', 'SK008', 'SK010', 'SK013');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sikap_pelanggan`
--

CREATE TABLE `tb_sikap_pelanggan` (
  `id_sikap` varchar(15) NOT NULL,
  `id_pelanggan` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `id_sub_kriteria` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sikap_pelanggan`
--

INSERT INTO `tb_sikap_pelanggan` (`id_sikap`, `id_pelanggan`, `id_penjualan`, `id_sub_kriteria`) VALUES
('SK20240001', 'P2400001', 'J2400013', 'SK010'),
('SK20240002', 'P2400001', 'J2400014', 'SK010'),
('SK20240003', 'P2400005', 'J2400015', 'SK010'),
('SK20240004', 'P2400002', 'J2400016', 'SK011'),
('SK20240005', 'P2400001', 'J2400017', 'SK011'),
('SK20240006', 'P2400005', 'J2400018', 'SK012'),
('SK20240007', 'P2400006', 'J2400019', 'SK010'),
('SK20240008', 'P2400006', 'J2400020', 'SK011'),
('SK20240009', 'P2400009', 'J2400021', 'SK011'),
('SK20240010', 'P2400001', 'J2400022', 'SK011'),
('SK20240011', 'P2400001', 'J2400023', 'SK011'),
('SK20240012', 'P2400005', 'J2400024', 'SK011'),
('SK20240013', 'P2400005', 'J2400025', 'SK010'),
('SK20240014', 'P2400006', 'J2400026', 'SK012'),
('SK20240015', 'P2400001', 'J2400027', 'SK011'),
('SK20240016', 'P2400005', 'J2400028', 'SK010'),
('SK20240017', 'P2400005', 'J2400029', 'SK011'),
('SK20240018', 'P2400001', 'J2400030', 'SK012'),
('SK20240019', 'P2400005', 'J2400031', 'SK010');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_stock_cabang`
--

CREATE TABLE `tb_stock_cabang` (
  `id_stock` int(11) NOT NULL,
  `id_cabang` varchar(10) NOT NULL,
  `id_barang` varchar(15) NOT NULL,
  `stock` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_stock_cabang`
--

INSERT INTO `tb_stock_cabang` (`id_stock`, `id_cabang`, `id_barang`, `stock`) VALUES
(1, 'CB001', 'BSI00002', 921),
(2, 'CB001', 'BSI00001', 454),
(3, 'CB001', 'KRM00001', 9669),
(4, 'CB001', 'SMN00001', 249);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sub_kriteria`
--

CREATE TABLE `tb_sub_kriteria` (
  `id_sub_kriteria` varchar(10) NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `sub_kriteria` varchar(50) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sub_kriteria`
--

INSERT INTO `tb_sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `sub_kriteria`, `bobot`) VALUES
('SK001', 'KR001', '>75', 0.521),
('SK002', 'KR001', '51 – 75', 0.271),
('SK003', 'KR001', '26 – 50', 0.146),
('SK004', 'KR001', '1 – 25', 0.063),
('SK005', 'KR002', '> 15', 0.521),
('SK006', 'KR002', '11 – 15', 0.271),
('SK007', 'KR002', '6 – 10', 0.146),
('SK008', 'KR002', '1 – 5', 0.063),
('SK009', 'KR003', 'Sangat Baik', 0.521),
('SK010', 'KR003', 'Baik', 0.271),
('SK011', 'KR003', 'Cukup Baik', 0.146),
('SK012', 'KR003', 'Kurang Baik', 0.063),
('SK013', 'KR004', 'Ambil sendiri', 0.521),
('SK014', 'KR004', 'Diantar lokasi <= 5 km', 0.271),
('SK015', 'KR004', 'Diantar lokasi > 5 km', 0.146),
('SK016', 'KR004', 'Jasa antar lain', 0.063);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(25) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `nm_pengguna` varchar(45) DEFAULT NULL,
  `level` enum('PEMILIK','KEPALA TOKO','KASIR','ADMIN GUDANG') DEFAULT NULL,
  `id_cabang` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `nm_pengguna`, `level`, `id_cabang`) VALUES
('U2300001', 'admin', 'admin', 'Admin Gudang', 'ADMIN GUDANG', 'CB001'),
('U2300005', 'kepala1', 'kepala1', 'Rendi', 'KEPALA TOKO', 'CB001'),
('U2400001', 'pemilik', 'pemilik', 'Pemilik Depo Murah', 'PEMILIK', NULL),
('U2400002', 'kasir1', 'kasir1', 'Kasir 1', 'KASIR', 'CB001'),
('U2400003', 'kasir2', 'kasir2', 'Kasir 2', 'KASIR', 'CB002');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indeks untuk tabel `tb_cabang`
--
ALTER TABLE `tb_cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indeks untuk tabel `tb_dtl_penjualan`
--
ALTER TABLE `tb_dtl_penjualan`
  ADD PRIMARY KEY (`id_dtl_penjualan`);

--
-- Indeks untuk tabel `tb_kategori_barang`
--
ALTER TABLE `tb_kategori_barang`
  ADD PRIMARY KEY (`id_kategori_barang`);

--
-- Indeks untuk tabel `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_ranking`
--
ALTER TABLE `tb_ranking`
  ADD PRIMARY KEY (`id_ranking`);

--
-- Indeks untuk tabel `tb_sikap_pelanggan`
--
ALTER TABLE `tb_sikap_pelanggan`
  ADD PRIMARY KEY (`id_sikap`);

--
-- Indeks untuk tabel `tb_stock_cabang`
--
ALTER TABLE `tb_stock_cabang`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indeks untuk tabel `tb_sub_kriteria`
--
ALTER TABLE `tb_sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_dtl_penjualan`
--
ALTER TABLE `tb_dtl_penjualan`
  MODIFY `id_dtl_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `tb_ranking`
--
ALTER TABLE `tb_ranking`
  MODIFY `id_ranking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_stock_cabang`
--
ALTER TABLE `tb_stock_cabang`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
