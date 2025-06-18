-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2025 pada 12.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `informasi_akademik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `program_studi` varchar(50) NOT NULL,
  `program_studi_id` int(11) DEFAULT NULL,
  `pendidikan_terakhir` varchar(20) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `bidang_keahlian` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `program_studi_id_temp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id`, `nidn`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telepon`, `email`, `program_studi`, `program_studi_id`, `pendidikan_terakhir`, `jabatan`, `bidang_keahlian`, `foto`, `created_at`, `updated_at`, `deleted_at`, `program_studi_id_temp`) VALUES
(1, '0001048501', 'Teguh Ansyor Lorosae', 'Laki-laki', 'Bima', '1985-04-01', 'Jl. Gajah Mada No. 23, Bima', '081234567890', 'teguh.ansyor@umbima.ac.id', '', 0, 'S2', 'Lektor', 'Kecerdasan Buatan', 'default.jpg', '2025-03-29 04:13:18', '2025-03-29 04:13:18', NULL, NULL),
(2, '0002057603', 'Miftahul Jannah', 'Perempuan', 'Mataram', '1976-05-02', 'Jl. Hasanuddin No. 45, Bima', '085678901234', 'miftahul.jannah@umbima.ac.id', '', 0, 'S2', 'Asisten Ahli', 'Manajemen Sistem Informasi', '1743407858_dosen2.jpg', '2025-03-29 04:13:18', '2025-05-24 23:28:48', '2025-05-24 23:28:48', NULL),
(3, '0003069002', 'Zumhur Alamin', 'Laki-laki', 'Sumbawa', '1990-06-03', 'Jl. Soekarno hatta No. 129 kel rabangodu utara, kec raba kota Bima, NTB 84115', '089012345678', 'zumhur.alamin@umbima.ac.id', 'Ilmu Komputer', 0, 'S2', 'Asisten Ahli', 'Rekayasa Perangkat Lunak', 'default.jpg', '2025-03-29 04:13:18', '2025-06-10 16:22:06', NULL, NULL),
(4, '0004079103', 'A Latief Fashihulisan', 'Laki-laki', 'Bima', '1991-07-04', 'Jl. Diponegoro No. 12, Bima', '087654321098', 'latief.fashihulisan@umbima.ac.id', '', 0, 'S2', 'Asisten Ahli', 'Pemrograman Mobile', '1743326744_dosen4.jpg', '2025-03-29 04:13:18', '2025-03-30 09:25:44', NULL, NULL),
(7, 'B02220040', 'M. Iwan Setiawan', 'Laki-laki', 'kota bima', '2004-05-08', 'Mekar baru', '085339370766', 'iwansyf@gmail.com', '', 0, 'S1', 'Tenaga Pengajar', 'Sistem Informasi', '1748012141_3982e563c6b789d2bec6.jpg', '2025-05-23 06:55:41', '2025-05-23 06:55:41', NULL, NULL),
(8, 'B02220050', 'Miftahul Jannah', 'Perempuan', 'Bima', '2025-05-20', 'renda pride', '087654321098', 'iis@gmail.com', '', 0, 'S2', 'Tenaga Pengajar', 'sistem pakar', 'default.jpg', '2025-05-23 08:13:34', '2025-05-23 08:13:34', NULL, NULL),
(9, '1236789002', 'si ajg M.kom', 'Laki-laki', 'kab.bima', '1997-06-19', 'madapangga', '082367877234', 'ndasmu@gmail.com', 'Ilmu Komputer', NULL, 'S2', 'Tenaga Pengajar', 'komputerisasi', 'default.jpg', '2025-05-25 00:48:37', '2025-06-06 21:58:42', '2025-06-06 21:58:42', NULL),
(10, '6808563282', 'Sahrul Ramadan, M.kom', 'Laki-laki', 'kota bima', '1993-06-10', 'pane', '085678901234', 'sahrulramadan@gmail.com', 'Ilmu Komputer', NULL, 'S2', 'Tenaga Pengajar', 'desain', 'default.jpg', '2025-06-06 21:58:35', '2025-06-06 21:58:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan_dosen`
--

CREATE TABLE `jabatan_dosen` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan_dosen`
--

INSERT INTO `jabatan_dosen` (`id`, `nama_jabatan`, `deskripsi`, `created_at`, `deleted_at`) VALUES
(1, 'Guru Besar', 'Jabatan fungsional akademik tertinggi bagi dosen', '2025-03-31 08:10:42', NULL),
(2, 'Lektor Kepala', 'Tingkat jabatan fungsional dosen di bawah Guru Besar', '2025-03-31 08:10:42', NULL),
(3, 'Lektor', 'Tingkat jabatan fungsional dosen di bawah Lektor Kepala', '2025-03-31 08:10:42', NULL),
(4, 'Asisten Ahli', 'Tingkat jabatan fungsional dosen pemula', '2025-03-31 08:10:42', NULL),
(5, 'Tenaga Pengajar', 'Belum memiliki jabatan fungsional akademik', '2025-03-31 08:10:42', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kuliah`
--

CREATE TABLE `jadwal_kuliah` (
  `id` int(11) NOT NULL,
  `kode_matkul` varchar(20) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `sks` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `ruangan` varchar(20) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `program_studi_id` int(11) NOT NULL,
  `tahun_akademik` varchar(20) NOT NULL,
  `kelas` varchar(10) DEFAULT 'Reguler',
  `kuota` int(3) DEFAULT 40,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kuliah`
--

INSERT INTO `jadwal_kuliah` (`id`, `kode_matkul`, `nama_matkul`, `sks`, `semester`, `hari`, `waktu_mulai`, `waktu_selesai`, `ruangan`, `dosen_id`, `program_studi_id`, `tahun_akademik`, `kelas`, `kuota`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'K03', 'Pemrograman Mobile', 4, 6, 'Kamis', '08:30:00', '11:00:00', 'K1F', 4, 1, '2025/2026', 'Reguler', 40, 'Aktif', '2025-03-30 13:03:53', '2025-03-30 13:03:53', NULL),
(2, 'K04', 'Mesin Learning', 2, 6, 'Jumat', '07:00:00', '10:00:00', 'K1F', 1, 1, '2025/2026', 'Reguler', 40, 'Aktif', '2025-03-31 07:56:36', '2025-03-31 07:56:36', NULL),
(3, 'SPK01', 'Sistem pakar', 4, 6, 'Kamis', '07:00:00', '09:00:00', 'K1G', 1, 1, '2025/2026', 'Reguler', 40, 'Aktif', '2025-06-06 21:44:44', '2025-06-06 21:46:58', NULL),
(4, 'DG', 'Desain Grafis', 2, 2, 'Selasa', '08:30:00', '11:00:00', 'K1G', 10, 1, '2025/2026', 'Reguler', 35, 'Aktif', '2025-06-06 21:59:55', '2025-06-06 21:59:55', NULL),
(5, 'SPK01', 'Sistem pakar', 4, 6, 'Rabu', '08:00:00', '10:30:00', 'K1F', 1, 1, '2025/2026', 'Reguler', 40, 'Aktif', '2025-06-10 16:25:42', '2025-06-10 16:25:42', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `program_studi` varchar(50) NOT NULL,
  `angkatan` int(4) NOT NULL,
  `semester` int(1) NOT NULL DEFAULT 1,
  `status` enum('Aktif','Cuti','Lulus','Keluar') NOT NULL DEFAULT 'Aktif',
  `foto` varchar(255) DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telepon`, `email`, `program_studi`, `angkatan`, `semester`, `status`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '2022003', 'Muhammad Fajarudin', 'Laki-laki', 'Bima', '2003-12-10', 'Jl. Diponegoro No. 78, Bima', '081234567890', 'muhammad.fajar@students.umbima.ac.id', 'Ilmu Komputer', 2022, 1, 'Aktif', 'default.jpg', '2025-03-29 04:11:19', '2025-05-20 07:39:55', NULL),
(4, 'B02220040', 'M. Iwan Setiawan', 'Laki-laki', 'kota bima', '2004-05-08', 'mekar baru', '085339370766', 'iwansyf@gmail.com', 'Ilmu Komputer', 2022, 6, 'Aktif', 'default.jpg', '2025-03-29 17:01:00', '2025-06-17 02:41:31', NULL),
(5, 'B02220048', 'Iis Muzdalifah', 'Perempuan', 'kota bima', '2004-03-08', 'Manggemaci', '082367877234', 'iis@gmail.com', 'Sistem Informasi', 2023, 1, 'Cuti', 'B02220048_1743326456.jpg', '2025-03-30 09:20:56', '2025-03-30 09:20:56', NULL),
(6, 'B02220107', 'Muhammad Akbar', 'Laki-laki', 'Bima', '2004-01-02', 'Waki', '085678901234', 'akbarkaboa@gmail.com', 'Ilmu Komputer', 2022, 1, 'Aktif', 'default.jpg', '2025-04-09 11:43:51', '2025-04-09 11:43:51', NULL),
(7, 'B022200123', 'Sukran Golit', 'Laki-laki', 'kota bima', '2002-07-19', 'tato', '083345678456', 'sukrangolit@gmail.com', 'Ilmu Komputer', 2022, 1, 'Lulus', 'default.jpg', '2025-05-20 07:41:30', '2025-05-20 07:41:30', NULL),
(8, 'B02224404567', 'Nurfadillah ', 'Perempuan', 'Bima', '2025-05-07', 'kedo', '082367877234', 'nurfadilla@gmail.com', 'Ilmu Komputer', 2022, 1, 'Aktif', 'default.jpg', '2025-05-25 00:00:34', '2025-05-25 00:00:34', NULL),
(10, 'B02220050', 'Ferdiansyah', 'Laki-laki', 'Bima', '2025-06-25', 'kempo', '085667854332', 'sambo@gmail.com', 'Ilmu hukum', 2022, 1, 'Aktif', 'default.jpg', '2025-06-06 22:39:35', '2025-06-06 22:39:35', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id` int(11) NOT NULL,
  `kode_matkul` varchar(20) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `sks` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `program_studi_id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id`, `kode_matkul`, `nama_matkul`, `sks`, `semester`, `program_studi_id`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'K03', 'Pemrograman Mobile', 4, 6, 1, NULL, '2025-05-16 04:05:49', '2025-05-16 04:05:49', NULL),
(2, 'K04', 'Mesin Learning', 2, 6, 1, NULL, '2025-05-16 04:05:49', '2025-05-16 04:05:49', NULL),
(3, 'SPK01', 'Sistem pakar', 4, 6, 1, '', '2025-05-23 15:18:54', '2025-05-23 15:18:54', NULL),
(4, 'ANSI', 'Analisis dan perancangan', 4, 6, 1, '', '2025-05-25 05:13:15', '2025-05-25 05:13:15', NULL),
(5, 'PRC', 'Manajemen Sistem', 2, 6, 1, '', '2025-05-25 08:01:37', '2025-05-25 08:01:37', NULL),
(6, 'DG', 'Desain Grafis', 2, 2, 1, '', '2025-06-07 05:55:56', '2025-06-07 05:55:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_studi`
--

CREATE TABLE `program_studi` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `ketua_prodi` varchar(100) DEFAULT NULL,
  `tahun_berdiri` int(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `program_studi`
--

INSERT INTO `program_studi` (`id`, `kode`, `nama`, `jenjang`, `ketua_prodi`, `tahun_berdiri`, `deleted_at`) VALUES
(1, 'TI', 'Ilmu Komputer', 'S2', 'Teguh Ansyor Lorosae, M.Kom', 2022, NULL),
(2, 'SI', 'Sistem Informasi', 'S1', 'Teguh Ansyor Lorosae, M.Kom', 2012, '2025-05-23 07:49:04'),
(3, 'TK', 'Teknik Komputer', 'S1', 'Teguh Ansyor Lorosae, M.Kom', 2015, '2025-05-23 07:49:11'),
(4, 'MI', 'Manajemen Informatika', 'D3', 'Teguh Ansyor Lorosae, M.Kom', 2018, '2025-05-23 07:49:16'),
(5, 'KA', 'Komputerisasi Akuntansi', 'D3', 'Teguh Ansyor Lorosae, M.Kom', 2020, '2025-05-23 07:49:24'),
(6, 'HKM', 'Ilmu hukum', 'S1', 'Iis Muzdalifah', 2022, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','dosen','mahasiswa') NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`, `related_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', NULL, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(2, '0001048501', '57374ab2d1783494ec0b75893e98339e', 'dosen', NULL, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(3, '0002057603', '7e9fa3008df90c5eba5aede26183e53b', 'dosen', NULL, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(4, '0003069002', '0a48ceee3f7849e70c33ff0185fc91a4', 'dosen', 3, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(5, '0004079103', '79393229e843ef92c814ed60c54395a1', 'dosen', 4, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(9, '2022001', '1def1dd11b499be300e5c4b9d55109dc', 'mahasiswa', NULL, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(10, '2022002', '2f75368087d8b322e27128e4c6d8a1fe', 'mahasiswa', NULL, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(11, '2022003', '94243b528d2172717cee07d38790eef2', 'mahasiswa', 3, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(12, 'B02220040', '688160f43fe1c163c032a637c58aabdb', 'mahasiswa', 4, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(13, 'B02220048', 'b5434855b0f7f43ed57978d03bbbd802', 'mahasiswa', 5, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL),
(14, 'B02220107', '56241d44747f8d8db362c72b97d4b078', 'mahasiswa', 6, '2025-05-16 03:57:58', '2025-05-16 03:57:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `program_studi_idx` (`program_studi_id`),
  ADD KEY `nama_lengkap_idx` (`nama_lengkap`),
  ADD KEY `jabatan_idx` (`jabatan`);

--
-- Indeks untuk tabel `jabatan_dosen`
--
ALTER TABLE `jabatan_dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_jabatan` (`nama_jabatan`);

--
-- Indeks untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `program_studi_id` (`program_studi_id`),
  ADD KEY `semester_idx` (`semester`),
  ADD KEY `tahun_akademik_idx` (`tahun_akademik`),
  ADD KEY `kode_matkul_idx` (`kode_matkul`),
  ADD KEY `hari_idx` (`hari`),
  ADD KEY `status_idx` (`status`),
  ADD KEY `dosen_prodi_idx` (`dosen_id`,`program_studi_id`),
  ADD KEY `prodi_semester_idx` (`program_studi_id`,`semester`),
  ADD KEY `tahun_semester_idx` (`tahun_akademik`,`semester`),
  ADD KEY `kelas_idx` (`kelas`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `program_studi_idx` (`program_studi`),
  ADD KEY `nama_lengkap_idx` (`nama_lengkap`),
  ADD KEY `angkatan_idx` (`angkatan`),
  ADD KEY `status_idx` (`status`);

--
-- Indeks untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_matkul` (`kode_matkul`),
  ADD KEY `program_studi_id` (`program_studi_id`),
  ADD KEY `semester_prodi_idx` (`semester`,`program_studi_id`),
  ADD KEY `nama_matkul_idx` (`nama_matkul`);

--
-- Indeks untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `jenjang_idx` (`jenjang`),
  ADD KEY `nama_idx` (`nama`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `level_idx` (`level`),
  ADD KEY `related_id_idx` (`related_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jabatan_dosen`
--
ALTER TABLE `jabatan_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD CONSTRAINT `jadwal_kuliah_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_kuliah_ibfk_2` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD CONSTRAINT `mata_kuliah_ibfk_1` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_mahasiswa_fk` FOREIGN KEY (`related_id`) REFERENCES `mahasiswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
