-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 06:29 PM
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
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `foto`) VALUES
(1, 'admin', '123', 'Hafizh Alvian Nazhif', '1733829668_profil1-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` varchar(20) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nis`, `nama`, `kelas`, `no_hp`, `alamat`) VALUES
('A001', '2024001', 'Ahmad Rizki', 'X IPA 1', '081234567801', 'Jl. Merdeka No. 1'),
('A002', '2024002', 'Budi Santoso', 'X IPA 1', '081234567802', 'Jl. Sudirman No. 2'),
('A003', '2024003', 'Citra Dewi', 'X IPA 2', '081234567803', 'Jl. Gatot Subroto No. 3'),
('A004', '2024004', 'Dian Pratiwi', 'X IPA 2', '081234567804', 'Jl. Diponegoro No. 4'),
('A005', '2024005', 'Eko Prasetyo', 'X IPS 1', '081234567805', 'Jl. Pahlawan No. 5'),
('A006', '2024006', 'Fitri Handayani', 'X IPS 1', '081234567806', 'Jl. Ahmad Yani No. 6'),
('A007', '2024007', 'Gunawan', 'X IPS 2', '081234567807', 'Jl. Veteran No. 7'),
('A008', '2024008', 'Hadi Kusuma', 'X IPS 2', '081234567808', 'Jl. Pemuda No. 8'),
('A010', '2024010', 'Joko Nurjana', 'X BAHASA', '081234567810', 'Jl. Gajah Mada No. 10'),
('A011', '2023001', 'Kartika Sari', 'XI IPA 1', '081234567811', 'Jl. Hayam Wuruk No. 11'),
('A012', '2023002', 'Lukman Hakim', 'XI IPA 1', '081234567812', 'Jl. Thamrin No. 12'),
('A013', '2023003', 'Maya Angelina', 'XI IPA 2', '081234567813', 'Jl. Asia Afrika No. 13'),
('A014', '2023004', 'Nanda Pratama', 'XI IPA 2', '081234567814', 'Jl. Imam Bonjol No. 14'),
('A015', '2023005', 'Oscar Putra', 'XI IPS 1', '081234567815', 'Jl. Antasari No. 15'),
('A016', '2023006', 'Putri Rahayu', 'XI IPS 1', '081234567816', 'Jl. Sisingamangaraja No. 16'),
('A017', '2023007', 'Qori Amalia', 'XI IPS 2', '081234567817', 'Jl. Pangeran Jayakarta No. 17'),
('A018', '2023008', 'Rudi Hermawan', 'XI IPS 2', '081234567818', 'Jl. Wahid Hasyim No. 18'),
('A019', '2023009', 'Siti Nurhaliza', 'XI BAHASA', '081234567819', 'Jl. Rasuna Said No. 19'),
('A020', '2023010', 'Tono Sucipto', 'XI BAHASA', '081234567820', 'Jl. Kuningan No. 20'),
('A021', '2022001', 'Udin Sedunia', 'XII IPA 1', '081234567821', 'Jl. Casablanca No. 21'),
('A022', '2022002', 'Vina Panduwinata', 'XII IPA 1', '081234567822', 'Jl. Sudirman Kav. 22'),
('A023', '2022003', 'Wati Sulistyo', 'XII IPA 2', '081234567823', 'Jl. Gatot Subroto Kav. 23'),
('A024', '2022004', 'Xaverius Wijaya', 'XII IPA 2', '081234567824', 'Jl. HR Rasuna Said No. 24'),
('A025', '2022005', 'Yanto Mulyadi', 'XII IPS 1', '081234567825', 'Jl. MT Haryono No. 25'),
('A026', '2022006', 'Zainab Putri', 'XII IPS 1', '081234567826', 'Jl. Mega Kuningan No. 26'),
('A027', '2022007', 'Adi Nugroho', 'XII IPS 2', '081234567827', 'Jl. Satrio No. 27'),
('A028', '2022008', 'Bayu Segara', 'XII IPS 2', '081234567828', 'Jl. Mas Mansyur No. 28'),
('A029', '2022009', 'Candra Wijaya', 'XII BAHASA', '081234567829', 'Jl. Tentara Pelajar No. 29'),
('A030', '2022010', 'Desi Ratnasari', 'XII BAHASA', '081234567830', 'Jl. Senopati No. 30');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `tingkat` varchar(5) NOT NULL,
  `lokasi_rak` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `isbn`, `pengarang`, `penerbit`, `tahun_terbit`, `tingkat`, `lokasi_rak`, `stok`) VALUES
(1, 'Matematika X', '9780123456789', 'Dr. Ahmad', 'Erlangga', '2023', 'X', 'R1-A1', 7),
(2, 'Bahasa Indonesia X', '9780123456790', 'Dra. Siti', 'Gramedia', '2023', 'X', 'R1-A2', 15),
(3, 'Fisika X', '9780123456791', 'Prof. Budi', 'Yudhistira', '2023', 'X', 'R1-A3', 12),
(4, 'Biologi X', '9780123456792', 'Dr. Maya', 'BSE', '2023', 'X', 'R1-A4', 8),
(5, 'Kimia X', '9780123456793', 'Dr. Rudi', 'Intan Pariwara', '2023', 'X', 'R1-A5', 6),
(6, 'Matematika XI', '9780123456794', 'Dr. Dewi', 'Erlangga', '2023', 'XI', 'R2-A1', 10),
(7, 'Bahasa Indonesia XI', '9780123456795', 'Prof. Andi', 'Gramedia', '2023', 'XI', 'R2-A2', 12),
(8, 'Fisika XI', '9780123456796', 'Dr. Joko', 'Yudhistira', '2023', 'XI', 'R2-A3', 12),
(9, 'Biologi XI', '9780123456797', 'Dra. Nina', 'BSE', '2023', 'XI', 'R2-A4', 8),
(10, 'Kimia XI', '9780123456798', 'Prof. Tono', 'Intan Pariwara', '2023', 'XI', 'R2-A5', 10),
(11, 'Matematika XII', '9780123456799', 'Dr. Rina', 'Erlangga', '2023', 'XII', 'R3-A1', 8),
(12, 'Bahasa Indonesia XII', '9780123456800', 'Prof. Dedi', 'Gramedia', '2023', 'XII', 'R3-A2', -9),
(13, 'Fisika XII', '9780123456801', 'Dr. Sari', 'Yudhistira', '2023', 'XII', 'R3-A3', 12),
(14, 'Biologi XII', '9780123456802', 'Prof. Hadi', 'BSE', '2023', 'XII', 'R3-A4', 8),
(15, 'Kimia XII', '9780123456803', 'Dr. Wati', 'Intan Pariwara', '2023', 'XII', 'R3-A5', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ebook`
--

CREATE TABLE `ebook` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_anggota` varchar(20) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(5, 'A004', 12, '2024-12-14', '2024-12-20', 'dikembalikan'),
(26, 'A004', 12, '2024-12-14', '2024-12-20', 'dikembalikan'),
(27, 'A012', 11, '2024-12-14', '2024-12-21', 'dipinjam'),
(29, 'A002', 11, '2024-12-14', '2024-12-20', 'dipinjam'),
(30, 'A002', 7, '2024-12-14', '2024-12-19', 'dikembalikan'),
(47, 'A004', 5, '2024-12-14', '2024-12-18', 'dipinjam'),
(48, 'A004', 5, '2024-12-14', '2024-12-18', 'dipinjam'),
(49, 'A004', 5, '2024-12-14', '2024-12-18', 'dipinjam'),
(50, 'A004', 5, '2024-12-14', '2024-12-18', 'dipinjam'),
(51, 'A002', 7, '2024-12-14', '2024-12-17', 'dipinjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ebook`
--
ALTER TABLE `ebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
