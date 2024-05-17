-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Bulan Mei 2024 pada 04.11
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tirta_pandan_ayu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluhan`
--

CREATE TABLE `keluhan` (
  `id_keluhan` int(25) NOT NULL,
  `id_pelanggan` varchar(25) NOT NULL,
  `keluhan` text NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(25) NOT NULL,
  `reply` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keluhan`
--

INSERT INTO `keluhan` (`id_keluhan`, `id_pelanggan`, `keluhan`, `tanggal`, `status`, `reply`) VALUES
(6, 'CK-001', 'testerrr', '2024-04-23', 'Selesai', 'Telah Berhasil'),
(7, 'CK-001', 'Air Keruh', '2024-04-23', '', ''),
(8, 'CK-002', 'Air Berbau Tidak Sedap', '2024-04-23', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(25) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pelanggan` varchar(25) NOT NULL,
  `jenis_kelamin` enum('L','P','','') NOT NULL,
  `rt` varchar(3) NOT NULL,
  `no_telepon` varchar(12) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nik`, `nama_pelanggan`, `jenis_kelamin`, `rt`, `no_telepon`, `password`) VALUES
('CK-001', '3325082307000003', 'Abdus Shomad Nurrohman', 'L', '06', '081312883292', 'maskumis'),
('CK-002', '3325082608900003', 'Kiki Widya Sari', 'P', '06', '082325503583', 'sari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemakaian`
--

CREATE TABLE `pemakaian` (
  `id_pemakaian` varchar(25) NOT NULL,
  `id_pelanggan` varchar(25) DEFAULT NULL,
  `meter_lalu` int(20) NOT NULL,
  `meter_sekarang` int(20) NOT NULL,
  `jumlah_pakai` int(20) NOT NULL,
  `periode` text NOT NULL,
  `tanggal_pemakaian` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemakaian`
--

INSERT INTO `pemakaian` (`id_pemakaian`, `id_pelanggan`, `meter_lalu`, `meter_sekarang`, `jumlah_pakai`, `periode`, `tanggal_pemakaian`) VALUES
('TP012209', 'CK-001', 0, 44, 44, '2024-01', '2024-04-25'),
('TP440609', 'CK-001', 44, 66, 22, '2024-02', '2024-04-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(10) NOT NULL,
  `id_pemakaian` varchar(25) NOT NULL,
  `tarif1` int(25) NOT NULL,
  `tarif2` int(25) NOT NULL,
  `tarif3` int(25) NOT NULL,
  `tarif4` int(25) NOT NULL,
  `jumlah_tagihan` int(15) DEFAULT NULL,
  `tunggakan` int(15) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updates_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_pemakaian`, `tarif1`, `tarif2`, `tarif3`, `tarif4`, `jumlah_tagihan`, `tunggakan`, `status`, `created_at`, `updates_at`) VALUES
('TT304409', 'TP440609', 50000, 6000, 0, 0, 56000, NULL, 'Belum Lunas', '2024-04-25 09:44:30', NULL),
('TT410109', 'TP012209', 50000, 60000, 14000, 0, 124000, NULL, 'Lunas', '2024-04-25 09:01:41', '2024-04-25 09:56:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` char(10) NOT NULL,
  `tarif020` int(20) NOT NULL,
  `tarif2140` int(20) NOT NULL,
  `tarif4160` int(20) NOT NULL,
  `tariflebih60` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `tarif020`, `tarif2140`, `tarif4160`, `tariflebih60`) VALUES
('TA01', 2500, 3000, 3500, 4000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(25) NOT NULL,
  `id_pelanggan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`, `id_pelanggan`) VALUES
(1, 'admin', 'admin', 'admin', 'CK-001'),
(2, 'petugas', '123456', 'petugas', 'CK-002');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`id_keluhan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pemakaian`
--
ALTER TABLE `pemakaian`
  ADD PRIMARY KEY (`id_pemakaian`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_pelanggan` (`id_pemakaian`),
  ADD KEY `id_pemakaian` (`id_pemakaian`);

--
-- Indeks untuk tabel `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`id_pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `id_keluhan` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
