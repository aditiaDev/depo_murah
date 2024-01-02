-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jan 2024 pada 09.44
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
  `id_user` varchar(25) DEFAULT NULL,
  `nm_cabang` varchar(35) DEFAULT NULL,
  `nm_kepala_toko` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('P2400001', 'Pelanggan 1', 'Alamat', '08524465132', 10000, '2024-01-01');

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
  `id_pelanggan` varchar(15) NOT NULL,
  `id_cabang` varchar(10) NOT NULL,
  `diskon` float NOT NULL,
  `tot_harga_barang` int(11) NOT NULL,
  `tot_penjualan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sikap_pelanggan`
--

CREATE TABLE `tb_sikap_pelanggan` (
  `id_sikap` varchar(15) NOT NULL,
  `id_pelanggan` varchar(15) NOT NULL,
  `id_penjualan` varchar(15) NOT NULL,
  `nilai_sikap` enum('KURANG BAIK','CUKUP BAIK','BAIK','SANGAT BAIK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` varchar(25) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `nm_pengguna` varchar(45) DEFAULT NULL,
  `level` enum('PEMILIK','KEPALA TOKO','KASIR','ADMIN GUDANG') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `nm_pengguna`, `level`) VALUES
('U2300001', 'admin', '12345678', 'Admin Gudang', 'ADMIN GUDANG'),
('U2300002', 'sdfdsf', '34234234', 'sfds', 'KASIR'),
('U2300003', 'sdfsdfdsfd', '12312345', 'sdfsdfsdf', 'KASIR'),
('U2300004', 'dfgd', 'ertretet', 'dfg', 'KASIR'),
('U2300005', 'asdsadsad', 'er234324234', 'asdsad', 'KEPALA TOKO'),
('U2300006', 'pemilik', '12345678', 'Pemilik', 'PEMILIK');

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
  MODIFY `id_dtl_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_stock_cabang`
--
ALTER TABLE `tb_stock_cabang`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
