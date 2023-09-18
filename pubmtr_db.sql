-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Feb 2023 pada 17.25
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pubmtr_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'pegawai',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `nip`, `password`, `email`, `no_hp`, `user_type`, `image`) VALUES
(23, '010101', '827ccb0eea8a706c4c34a16891f84e7b', 'abdul@gmail.com', '081234567890', 'admin', 'pic-3.png'),
(24, '197712759310236485', '827ccb0eea8a706c4c34a16891f84e7b', 'devina-aggr@gmail.com', '0812374562487', 'pegawai', 'pic-4.png'),
(25, '198145927601887115', '827ccb0eea8a706c4c34a16891f84e7b', 'fajrisamego88@gmail.com', '089817436726', 'pegawai', 'pic-1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatankinerja`
--

CREATE TABLE `catatankinerja` (
  `id_kinerja` int(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `tugas` varchar(150) NOT NULL,
  `kuantitas` varchar(100) NOT NULL,
  `output` varchar(100) NOT NULL,
  `lampiran` varchar(50) NOT NULL,
  `waktu` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Menunggu Validasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `catatankinerja`
--

INSERT INTO `catatankinerja` (`id_kinerja`, `nip`, `tanggal`, `tugas`, `kuantitas`, `output`, `lampiran`, `waktu`, `status`) VALUES
(23, '197712759310236485', '2023-02-09', 'Merekap dokumen Surat Perintah Pencairan Dana SP2D tahun 2021', '1', 'Laporan', 'devina-1.jpg', '2023-02-10 04:57:14', 'Terlambat'),
(24, '197712759310236485', '2023-02-10', 'Memverifikasi Surat Perintah Perjalanan Dinas (SPPD) ', '1', 'Dokumen', 'devina-2.jpg', '2023-02-10 10:55:24', 'Selesai'),
(25, '198145927601887115', '2023-02-11', 'Pengawasan Perbaikan Jalan Martapura - Sp. Martapura', '1', 'Laporan', 'semego-1.jpg', '2023-02-10 11:01:03', 'Tidak Valid'),
(26, '198145927601887115', '2023-02-10', 'Rehabilitasi Jalan Petanggan - Tj. Kemuning - Bts. Kab. OKI', '1', 'Laporan', 'semego-2.jpeg', '2023-02-10 11:02:30', 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `jabatan_peg` varchar(100) NOT NULL,
  `pangkat_peg` varchar(20) NOT NULL,
  `id_sub` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`nip`, `nama`, `gender`, `jabatan_peg`, `pangkat_peg`, `id_sub`) VALUES
('010101', 'Abdul Zainuddin', 'Pria', 'Admin', '-', 1),
('197712759310236485', 'Devina Anggraini', 'Wanita', 'Pegawai', 'III/d', 3),
('198145927601887115', 'M. Fajri Samego', 'Pria', 'Pegawai', 'II/b', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subbagian`
--

CREATE TABLE `subbagian` (
  `id_sub` int(10) NOT NULL,
  `nama_sub` varchar(100) NOT NULL,
  `kepala_sub` varchar(100) NOT NULL,
  `nip_kepala` varchar(20) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `pangkat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `subbagian`
--

INSERT INTO `subbagian` (`id_sub`, `nama_sub`, `kepala_sub`, `nip_kepala`, `jabatan`, `pangkat`) VALUES
(1, 'Sub Bagian Umum & Kepegawaian', 'Delly Puspita,ST', '19761231200512019', 'KSB. UMUM DAN KEPEGAWAIAN', 'III/d'),
(2, 'Perencanaan, Evaluasi & Pelaporan', 'Riliane Prima Winanri, ST, MT', '198506092011012004', 'KSB. PERENCANAAN, EVALUASI & PELAPORAN', 'III/c'),
(3, 'Sub Bagian Keuangan', 'Sri Eka Susilawati, SE', '197304061993032003', 'KSB. KEUANGAN', 'III/d');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD KEY `nip` (`nip`);

--
-- Indeks untuk tabel `catatankinerja`
--
ALTER TABLE `catatankinerja`
  ADD PRIMARY KEY (`id_kinerja`),
  ADD KEY `nip` (`nip`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `id_sub` (`id_sub`);

--
-- Indeks untuk tabel `subbagian`
--
ALTER TABLE `subbagian`
  ADD PRIMARY KEY (`id_sub`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `catatankinerja`
--
ALTER TABLE `catatankinerja`
  MODIFY `id_kinerja` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `subbagian`
--
ALTER TABLE `subbagian`
  MODIFY `id_sub` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `catatankinerja`
--
ALTER TABLE `catatankinerja`
  ADD CONSTRAINT `catatankinerja_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_sub`) REFERENCES `subbagian` (`id_sub`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
