-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Des 2023 pada 01.44
-- Versi server: 8.0.35-0ubuntu0.22.04.1
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bridal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `role` varchar(15) NOT NULL,
  `kata_sandi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `role`, `kata_sandi`) VALUES
(1, 'admin', 'Admin', 'admin123'),
(2, 'pelayanan', 'Pelayanan', 'layanan123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_jasa`
--

CREATE TABLE `tbl_detail_jasa` (
  `id` int NOT NULL,
  `id_jasa` int NOT NULL,
  `nama_detail_jasa` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_detail_jasa`
--

INSERT INTO `tbl_detail_jasa` (`id`, `id_jasa`, `nama_detail_jasa`) VALUES
(5, 1, 'Gaun'),
(6, 1, 'Pakaian Adat'),
(7, 1, 'Pakaian Nikah'),
(10, 3, 'Rias Pesta'),
(11, 3, 'Rias Wisuda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jasa`
--

CREATE TABLE `tbl_jasa` (
  `id` char(4) NOT NULL,
  `id_jenis_jasa` int NOT NULL,
  `id_detail_jasa` int NOT NULL,
  `qty` int NOT NULL,
  `harga` int NOT NULL,
  `gambar` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_jasa`
--

INSERT INTO `tbl_jasa` (`id`, `id_jenis_jasa`, `id_detail_jasa`, `qty`, `harga`, `gambar`) VALUES
('DR01', 2, 0, 0, 7500000, '65786b44101b3.jpg'),
('DR02', 2, 0, 0, 10000000, '65786b5b4024e.jpg'),
('FG01', 4, 0, 0, 500000, '657b04eaef466.jpg'),
('GN01', 1, 5, 1, 750000, '6575e0647bb10.jpg'),
('GN02', 1, 5, 1, 1100000, '6575e08d6c4ae.jpg'),
('GN03', 1, 5, 1, 600000, '6575e0d4bd6b4.jpg'),
('GN04', 1, 5, 1, 500000, '6575e0f3d41b0.jpg'),
('PA01', 1, 6, 1, 350000, '6575e2062bfe4.jpg'),
('PA02', 1, 6, 1, 400000, '6575e250a1df9.jpg'),
('PA03', 1, 6, 1, 380000, '6575e26e4010c.jpg'),
('PA04', 1, 6, 1, 420000, '6575e27e69684.jpg'),
('PA05', 1, 6, 1, 350000, '6575e28fa94df.jpg'),
('PA06', 1, 6, 1, 550000, '6575e2ae627ea.jpg'),
('PN01', 1, 7, 1, 1350000, '6575e30adbbb8.jpg'),
('PN02', 1, 7, 1, 1000000, '6575e3265d90a.jpg'),
('RP01', 3, 10, 0, 400000, '657b05510b9fc.jpg'),
('RW01', 3, 11, 0, 350000, '657b056b0dd2e.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jenis_jasa`
--

CREATE TABLE `tbl_jenis_jasa` (
  `id` int NOT NULL,
  `nama_jasa` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_jenis_jasa`
--

INSERT INTO `tbl_jenis_jasa` (`id`, `nama_jasa`) VALUES
(1, 'Pakaian'),
(2, 'Dekorasi'),
(3, 'Rias'),
(4, 'Fotografer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_keranjang`
--

CREATE TABLE `tbl_keranjang` (
  `id_keranjang` int NOT NULL,
  `id_jasa` char(4) NOT NULL,
  `lama_sewa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_keranjang`
--

INSERT INTO `tbl_keranjang` (`id_keranjang`, `id_jasa`, `lama_sewa`) VALUES
(1, 'GN02', 3),
(5, 'PA02', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penyewaan`
--

CREATE TABLE `tbl_penyewaan` (
  `id` char(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `lama_sewa` int NOT NULL,
  `nama_jasa` int NOT NULL,
  `kode_jasa` char(4) NOT NULL,
  `harga_sewa` int NOT NULL,
  `metode_bayar` varchar(8) NOT NULL,
  `status_sewa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tbl_penyewaan`
--

INSERT INTO `tbl_penyewaan` (`id`, `tanggal_transaksi`, `nama`, `alamat`, `no_hp`, `tanggal_sewa`, `lama_sewa`, `nama_jasa`, `kode_jasa`, `harga_sewa`, `metode_bayar`, `status_sewa`) VALUES
('121223001', '2023-12-12', 'alfred', 'Jalan Simatupang', '123123', '2023-12-13', 1, 5, 'GN01', 750000, 'Tunai', 'Dikembalikan'),
('131223001', '2023-12-13', 'asd', 'asd', '123', '2023-12-17', 2, 0, 'DR02', 10000000, 'Transfer', 'Belum Dikembalikan'),
('171223001', '2023-12-17', 'qwer', 'qwer', '12121', '2023-12-22', 2, 6, 'PA01', 350000, 'Tunai', 'Dikembalikan'),
('171223002', '2023-12-17', 'andru', 'turantang', '987812', '2023-12-24', 1, 0, 'DR02', 10000000, 'Tunai', 'Belum Dikembalikan'),
('171223003', '2023-12-17', 'andru', 'turantung tang', '121212', '2023-12-24', 1, 0, 'FG01', 500000, 'Tunai', 'Belum Dikembalikan'),
('171223004', '2023-12-17', 'nindi ajeng', 'asfsdf', '1232413', '2023-12-17', 0, 10, 'RP01', 400000, 'Tunai', 'Dikembalikan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_detail_jasa`
--
ALTER TABLE `tbl_detail_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jasa`
--
ALTER TABLE `tbl_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jenis_jasa`
--
ALTER TABLE `tbl_jenis_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indeks untuk tabel `tbl_penyewaan`
--
ALTER TABLE `tbl_penyewaan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_jasa`
--
ALTER TABLE `tbl_detail_jasa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_jenis_jasa`
--
ALTER TABLE `tbl_jenis_jasa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
