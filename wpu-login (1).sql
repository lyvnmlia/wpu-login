-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 15, 2025 at 05:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wpu-login`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pelajaran`
--

CREATE TABLE `jadwal_pelajaran` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `tahun_ajaran` int(11) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `id_jam` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_pelajaran`
--

INSERT INTO `jadwal_pelajaran` (`id`, `id_kelas`, `semester`, `tahun_ajaran`, `hari`, `id_jam`, `id_mapel`) VALUES
(1, 5, 'Ganjil', 2025, 'Selasa', 2, 4),
(2, 6, 'Ganjil', 2025, 'Rabu', 3, 4),
(3, 6, 'Ganjil', 2025, 'Selasa', 1, 6),
(4, 6, 'Ganjil', 2025, 'Jumat', 5, 5),
(5, 6, 'Ganjil', 2025, 'Selasa', 2, 8),
(6, 6, 'Ganjil', 2025, 'Kamis', 4, 4),
(8, 4, 'Ganjil', 2025, 'Kamis', 2, 4),
(9, 4, 'Ganjil', 2025, 'Jumat', 1, 5),
(10, 6, 'Ganjil', 2025, 'Senin', 2, 4),
(12, 4, 'Ganjil', 2025, 'Jumat', 1, 6),
(13, 4, 'Ganjil', 2025, 'Jumat', 2, 8),
(14, 4, 'Ganjil', 2025, 'Jumat', 4, 5),
(15, 4, 'Ganjil', 2025, 'Jumat', 2, 6),
(16, 4, 'Ganjil', 2025, 'Jumat', 5, 6),
(18, 4, 'Ganjil', 2025, 'Selasa', 4, 8),
(20, 4, 'Ganjil', 2025, 'Selasa', 3, 4),
(21, 6, 'Ganjil', 2025, 'Senin', 2, 8),
(22, 6, 'Ganjil', 2025, 'Jumat', 6, 5),
(23, 8, 'Ganjil', 2025, 'Senin', 2, 6),
(24, 8, 'Ganjil', 2025, 'Senin', 3, 8),
(25, 8, 'Ganjil', 2025, 'Senin', 4, 4),
(26, 8, 'Ganjil', 2025, 'Senin', 5, 5),
(28, 4, 'Ganjil', 2025, 'Senin', 3, 6),
(30, 4, 'Ganjil', 2025, 'Senin', 6, 4),
(31, 4, 'Ganjil', 2025, 'Senin', 2, 10),
(32, 16, 'Ganjil', 2025, 'Selasa', 2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_siswa`
--

CREATE TABLE `jadwal_siswa` (
  `id_jam` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jam_pelajaran`
--

CREATE TABLE `jam_pelajaran` (
  `id_jam` int(11) NOT NULL,
  `jam_ke` varchar(10) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jam_pelajaran`
--

INSERT INTO `jam_pelajaran` (`id_jam`, `jam_ke`, `waktu_mulai`, `waktu_selesai`) VALUES
(2, '1', '07:00:00', '07:40:00'),
(3, '2', '07:40:00', '08:20:00'),
(4, '3', '08:20:00', '09:40:00'),
(5, '4', '09:40:00', '10:20:00'),
(6, '5', '10:20:00', '11:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_jurusan`
--

CREATE TABLE `m_jurusan` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `deskripsi` varchar(128) NOT NULL,
  `code_jurusan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_jurusan`
--

INSERT INTO `m_jurusan` (`id`, `nama`, `deskripsi`, `code_jurusan`) VALUES
(1, 'DKV', 'Desain Komunikasi Visual', '001'),
(2, 'PPLG', 'Pengembangan Perangkat Lunak dan Gim', '002'),
(4, 'TKJ', 'Teknik Komputer dan Jaringan', '003'),
(5, 'AKL', 'Akuntansi', '004'),
(7, 'TE', 'Teknik Elektro', '006');

-- --------------------------------------------------------

--
-- Table structure for table `m_kelas`
--

CREATE TABLE `m_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `code_kelas` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_kelas`
--

INSERT INTO `m_kelas` (`id`, `nama`, `id_jurusan`, `code_kelas`) VALUES
(4, 'X', 1, 'D1'),
(5, 'X', 2, 'P1'),
(6, 'X', 4, 'T1'),
(7, 'X', 5, 'A1'),
(8, 'X', 6, 'T1'),
(9, 'X', 7, 'TE1'),
(10, 'XI', 1, 'D2'),
(11, 'XI', 2, 'P2'),
(12, 'XI', 4, 'T2'),
(13, 'XI', 5, 'A2'),
(14, 'XI', 7, 'TE2'),
(15, 'XII', 1, 'D3'),
(16, 'XII', 2, 'P3'),
(17, 'XII', 4, 'T3'),
(18, 'XII', 5, 'A3'),
(19, 'XII', 7, 'TE3');

-- --------------------------------------------------------

--
-- Table structure for table `m_mapel`
--

CREATE TABLE `m_mapel` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `name_mapel` varchar(128) NOT NULL,
  `code_mapel` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_mapel`
--

INSERT INTO `m_mapel` (`id`, `id_kelas`, `name_mapel`, `code_mapel`) VALUES
(4, 4, 'Matematika', 'M01'),
(5, 6, 'PJOK', 'M03'),
(6, 5, 'Bahasa Indonesia', 'M04'),
(8, 4, 'Bahasa Jawa', 'M05'),
(9, 5, 'Bahasa Inggris', 'M02'),
(10, 10, 'Sejarah', 'M06'),
(11, 11, 'PKWU', 'M07'),
(12, 12, 'IPAS', 'M08'),
(13, 15, 'PPKN', 'M09'),
(14, 17, 'BK', 'M10'),
(15, 18, 'Kejuruan', 'M11');

-- --------------------------------------------------------

--
-- Table structure for table `m_mapeldetail`
--

CREATE TABLE `m_mapeldetail` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `materi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_mapeldetail`
--

INSERT INTO `m_mapeldetail` (`id`, `id_mapel`, `materi`) VALUES
(1, 4, 'lingkaran'),
(2, 4, 'ikgujg'),
(4, 4, 'Lingkaran'),
(5, 6, 'Aksara Jawa'),
(7, 5, 'Kayang');

-- --------------------------------------------------------

--
-- Table structure for table `m_siswa`
--

CREATE TABLE `m_siswa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_siswa` varchar(128) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nomor_whatsapp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_siswa`
--

INSERT INTO `m_siswa` (`id`, `id_user`, `nama_siswa`, `tanggal_lahir`, `id_kelas`, `nomor_whatsapp`) VALUES
(7, 19, 'Amanda', '2008-08-08', 7, '62882003066684'),
(8, 20, 'Rayyan', '2007-07-07', 4, '6282314281829'),
(9, 21, 'Niscala', '2008-08-18', 4, '62882008439545'),
(10, 22, 'Ryan', '2010-10-10', 6, ''),
(11, 25, 'Ana', '2008-02-12', 8, '6288239573576'),
(12, 26, 'Pak Fendi', '1111-11-11', 12, '-');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `whatsapp`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'vmeliaa', 'lymlya@gmail.com', NULL, 'singaNkucing1.jpg', '$2y$10$tJLubN6WCWRkmDNlSjOCk.59YffIippPwsvuX8wI.SZQZrXDiNhY2', 1, 1, 1760062633),
(2, 'amelialia', 'amelialia@gmail.com', NULL, 'profile71.jpg', '$2y$10$3DbAlf/yUvU95JWq2Y8wsOw687ecxBOpxiwln/jd.Vxh/CgPl3Poi', 2, 1, 1760063025),
(3, 'ifood', 'ifood@gmail.com', NULL, 'default.jpg', '$2y$10$4d2EkM9f9FnETWrmOB3dOekVk59t9H/F7fFMsr1Hwk9AiYIb2UL3K', 2, 0, 1760291217),
(18, 'brian', 'Brian@gmail.com', NULL, 'default.jpg', '$2y$10$gteI954PNlNPw.CCjMvU7uy/qEhD3q.uwA0np9qPd/61J/3Cx/Ml2', 2, 1, 1762955738),
(19, '', 'Amanda@gmail.com', NULL, '', '$2y$10$k96dZyeFt/ulb4SoHHdPHe39aMoQcirXFfs14jYJP04RUb..1MBkK', 0, 0, 0),
(20, '', 'Alexander@gmail.com', NULL, '', '$2y$10$e8/UAtG.TM5CnVkB3Mo2yutI.VhIs4Fm4.L3Yo9bzGjTXTHxyg3E6', 0, 0, 0),
(21, '', 'Niscala@gmail.com', NULL, '', '$2y$10$fHNGZ3E0WzBNo4wAUxxL3OFT90XGS/Bz2jv4nW0fqmh6PKTrS4C/u', 0, 0, 0),
(22, '', 'Ryan@gmail.com', NULL, '', '$2y$10$je1qanWCpmaWGGFOiz5ytOuY3K7Vqe55CW/NsR1iXeG0JaETPBcTm', 0, 0, 0),
(24, 'coba 1', 'coba@gmail.com', '6288239573576', 'sygq1.jpg', '$2y$10$7tbIE6nWLAfpgR4qkqShe.X6kRvY3g6jbGgyMlJKVNOrjy385APC6', 2, 1, 1765630399),
(25, '', 'ana@gmail.com', NULL, '', '$2y$10$kA.NjyChUDDzIAWudOrUXu4GBLLPLJgVonZbJT9lcp/4QFHKlSKCa', 3, 1, 0),
(26, '', 'Fendi@gmail.com', NULL, '', '$2y$10$WcwFMAwt8TaD0EOFWBA2cuc14TlNR4H1vaZmMK1LFdunSVS8xSLSy', 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(6, 1, 7),
(7, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 2, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(7, 'Master Data'),
(8, 'Management Jadwal'),
(10, 'Tambah Jadwal'),
(11, 'Jadwal Saya');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-solid fa-gauge-high', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-solid fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-solid fa-user-pen', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-solid fa-folder-tree', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-solid fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fa-fw fa-solid fa-user-tie', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fa-fw fa-solid fa-key', 1),
(10, 7, 'Jurusan', 'jurusan', 'fa-fw fa-solid fa-user-graduate', 1),
(11, 7, 'Kelas', 'kelas', 'fa-fw fa-solid fa-school', 1),
(12, 7, 'Mapel', 'mapel', 'fa-fw fa-solid fa-book', 1),
(13, 7, 'Siswa', 'siswa', 'fa-fw fa-solid fa-users', 1),
(14, 8, 'Jadwal', 'jadwal', 'fa-fw fa-solid fa-calendar-days', 1),
(15, 7, 'Jam Pelajaran', 'jam_pelajaran', 'fa-fw fa-solid fa-clock', 1),
(17, 10, 'Tambah Jadwal', 'jadwal/tambah', 'fa-solid fa-square-plus', 1),
(18, 11, 'Jadwal Saya', 'jadwalsaya', 'fa-fw fa-solid fa-calendar-days', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(1, 'coba@coba.com', 'Pu9PQVvK5Omy/haHcrNxwFio5Tli5JwsGxeLAiGFs9s=', 1760294884),
(2, 'septiavindy20@gmail.com', 'ypr5qgWLAJJwSDNAwq5iiNQIQc60o2I/oZ5lhlmn8+4=', 1760295081),
(3, 'septiavindy20@gmail.com', 'IreWo+fQfqaiBdFVb42cum6VWaZapv0Bh0cVuNcPS5s=', 1760418408),
(4, 'septiavindy20@gmail.com', 'JRObCm2GrgNF5dvNsr7uxT+gbd4nt5NtfDtjm5WmEDQ=', 1760418731),
(5, 'brian@gmail.com', 'xQzgTr6bNTQdBBlKDT6ncws+WNHy+W45wIAv0mq+J3U=', 1762418641),
(6, 'amanda@gmail.com', '6P4yczKXN1HHBtFAfvPnPKAQeJL9BXhhzORS/h0HQZE=', 1762938259),
(7, 'yanto@gmail.com', '0BPN6CXp67fbjRV4RDcHlBleRSfpLNFVQZHKHALfnYY=', 1762938432),
(8, 'Brian@gmail.com', 'EtgUx8HWSfmbbxlClUzc/aFLwYWviM9YVPALVNY/4vY=', 1762955738),
(9, 'rayan@gmail.com', 'XCdXREkoBVnhbIJ8c9Dc4tVBghPSB4DktZgIrcHeS/A=', 1765630356),
(10, 'coba@gmail.com', '3r67/GsjHFRXUlrY23mxTYH+wXiQDnLy8yosac9fmDY=', 1765630399);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_siswa`
--
ALTER TABLE `jadwal_siswa`
  ADD PRIMARY KEY (`id_jam`);

--
-- Indexes for table `jam_pelajaran`
--
ALTER TABLE `jam_pelajaran`
  ADD PRIMARY KEY (`id_jam`);

--
-- Indexes for table `m_jurusan`
--
ALTER TABLE `m_jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_mapel`
--
ALTER TABLE `m_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_mapeldetail`
--
ALTER TABLE `m_mapeldetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `jadwal_siswa`
--
ALTER TABLE `jadwal_siswa`
  MODIFY `id_jam` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam_pelajaran`
--
ALTER TABLE `jam_pelajaran`
  MODIFY `id_jam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_jurusan`
--
ALTER TABLE `m_jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_kelas`
--
ALTER TABLE `m_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `m_mapel`
--
ALTER TABLE `m_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `m_mapeldetail`
--
ALTER TABLE `m_mapeldetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_siswa`
--
ALTER TABLE `m_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
