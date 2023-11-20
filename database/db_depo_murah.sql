-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2023 pada 15.34
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

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
  `foto_barang` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `point_barang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Struktur dari tabel `tb_kategori_barang`
--

CREATE TABLE `tb_kategori_barang` (
  `id_kategori_barang` varchar(10) NOT NULL,
  `nm_kategori` varchar(40) DEFAULT NULL,
  `kode_kategori` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` varchar(15) NOT NULL,
  `nm_pelanggan` varchar(35) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL,
  `no_pelanggan` varchar(13) DEFAULT NULL
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
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
