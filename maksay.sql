-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 05:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maksay`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `nama_lengkap` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_role` int(155) NOT NULL,
  `gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `nama_lengkap`, `username`, `password`, `id_role`, `gambar`, `timestamp`) VALUES
(17, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '348-Capture.PNG', '2024-09-28 18:33:26'),
(18, '', '', 'd41d8cd98f00b204e9800998ecf8427e', 0, 'user.png', '2024-09-28 18:33:26'),
(21, 'test', 'test', '912ec803b2ce49e4a541068d495ab570', 15, '114-Menu.png', '2024-10-02 02:43:43'),
(22, 'user', 'user', 'd2c24d8988c79cbcd26caa5360e70d3b', 19, '574-04. Failed Log GL CAMS.png', '2024-10-02 07:40:56'),
(23, 'test yuk', 'test', 'ae90c5ed4b071378b42e3ea177e9c270', 25, '3-01. Document number yang telah dilakukan pengecekan jurnal.jpg', '2024-10-02 08:11:27'),
(24, 'coba lagi ya', 'dodo', 'ae90c5ed4b071378b42e3ea177e9c270', 6, '174-04. Failed Log GL CAMS.png', '2024-10-02 08:32:58'),
(25, 'test 2', 'zaa', 'ae90c5ed4b071378b42e3ea177e9c270', 11, '848-06. GP CAMS.jpg', '2024-10-02 08:33:11'),
(26, 'gfsfs', 'martiza', 'ae90c5ed4b071378b42e3ea177e9c270', 15, '719-06. GP CAMS.jpg', '2024-10-02 09:27:53'),
(27, 'yuk', 'yuk lagi', 'ae90c5ed4b071378b42e3ea177e9c270', 19, '113-02. Success Log GL CAMS.png', '2024-10-02 09:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL,
  `menu_code` varchar(155) NOT NULL,
  `menu_name` varchar(155) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_image` varchar(155) DEFAULT NULL,
  `modified_by` varchar(155) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `menu_code`, `menu_name`, `menu_description`, `menu_image`, `modified_by`, `timestamp`) VALUES
(12, 'prj2024', 'cams', '', '01. PCR Cabang Depok.png', '', '2024-10-02 14:37:06'),
(13, 'prj123', 'cams 2', '', '07.A.2.b. PO Masih Harus Search Denom Tidak Bisa Langsung Pilih.png', '', '2024-10-02 14:38:39'),
(14, 'prjlagi', 'yuk coba', '', '07.A.2.b. PO Masih Harus Search Denom Tidak Bisa Langsung Pilih.png', '', '2024-10-02 14:44:26'),
(15, 'prj2021', 'apa aja', '', '14. PCR HO.png', '', '2024-10-02 14:48:43'),
(16, 'gfh', 'dgfg', '', '08. PO Cabang Depok.png', '', '2024-10-02 14:48:51'),
(17, 'test', 'apa aja', '', '08. PO Cabang Depok.png', '', '2024-10-02 14:49:01'),
(18, 'prj2024coba', 'yuk coba', '', '02. Cash In.png', '', '2024-10-02 14:50:04'),
(19, 'test', 'apa aja', '', '03. PCT Draft.png', '', '2024-10-02 14:57:28'),
(20, 'kenapa di atas', 'yuk bisa', '', '03. PCT Draft.png', '', '2024-10-02 14:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(155) NOT NULL,
  `nama_role` varchar(155) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`, `timestamp`) VALUES
(6, 'e', '2024-09-28 16:58:33'),
(7, 'f', '2024-09-28 16:58:33'),
(11, 'j', '2024-09-28 16:58:56'),
(15, 'n', '2024-09-28 16:59:08'),
(19, 'oke1', '2024-09-28 18:29:28'),
(25, 'test lagi', '2024-10-02 08:11:13'),
(26, 'coba', '2024-10-02 08:22:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
