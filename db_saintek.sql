-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2026 at 07:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_saintek`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id_dosen` int NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nidn` varchar(30) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `jabatan_fungsional` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`id_dosen`, `nip`, `nidn`, `nama_dosen`, `jenis_kelamin`, `email`, `prodi`, `jabatan_fungsional`, `no_hp`, `created_at`) VALUES
(4, '198503152010121001', '0815038501', 'Dr. I Made Agus Wirawan, S.Kom., M.Kom.', 'L', 'agus.wirawan@saintek.ac.id', 'Informatika', 'Lektor Kepala', '081999111001', '2026-11-01 13:36:17'),
(5, '198707202012122002', '0820078702', 'Ni Luh Gede Pevin, S.T., M.T.', 'P', 'luh.pevin@saintek.ac.id', 'Informatika', 'Lektor', '081999111002', '2026-11-01 13:36:17'),
(6, '198201102008041003', '0810018203', 'Dr. Eng. Hendra Wijaya, S.T., M.T.', 'L', 'hendra.wijaya@saintek.ac.id', 'Informatika', 'Lektor Kepala', '081999111003', '2026-11-01 13:36:17'),
(7, '199011052015042004', '0805119004', 'Ni Komang Ayu Trisna, S.Kom., M.Cs.', 'P', 'ayu.trisna@saintek.ac.id', 'Sains Informasi', 'Asisten Ahli', '081999111004', '2026-11-01 13:36:17'),
(8, '197804122005011005', '0812047805', 'Prof. Dr. Ir. Bambang Supriadi, M.Sc.', 'L', 'bambang.supriadi@saintek.ac.id', 'Sains Informasi', 'Guru Besar', '081999111005', '2026-11-01 13:36:17'),
(9, '198909182014021006', '0818098906', 'Ida Bagus Prasetya, S.Sn., M.Sn.', 'L', 'gus.prasetya@saintek.ac.id', 'DKV', 'Lektor', '081999111006', '2026-11-01 13:36:17'),
(10, '199102282018032007', '0828029107', 'Ni Putu Dian Utami, S.Ds., M.Ds.', 'P', 'dian.utami@saintek.ac.id', 'DKV', 'Asisten Ahli', '081999111007', '2026-11-01 13:36:17'),
(11, '198406142009121008', '0814068408', 'I Wayan Gede Narayana, S.Kom., M.T.', 'L', 'gede.narayana@saintek.ac.id', 'Informatika', 'Lektor', '081999111008', '2026-11-01 13:36:17'),
(12, '198610022010012009', '0802108609', 'Dr. Ratna Sari, S.Si., M.Sc.', 'P', 'ratna.sari@saintek.ac.id', 'Sains Informasi', 'Lektor Kepala', '081999111009', '2026-11-01 13:36:17'),
(13, '199205152019031010', '0815059210', 'I Kadek Dedy Suryawan, S.Sn., M.Sn.', 'L', 'dedy.suryawan@saintek.ac.id', 'DKV', 'Asisten Ahli', '081999111010', '2026-11-01 13:36:17'),
(14, '198312012008122011', '0801128311', 'Ni Poetri Suardani, S.Kom., M.T.', 'P', 'poetri.suardani@saintek.ac.id', 'Informatika', 'Lektor', '081999111011', '2026-11-01 13:36:17'),
(15, '197508222002121012', '0822087512', 'Dr. Ir. I Nyoman Setiawan, M.T.', 'L', 'nyoman.setiawan@saintek.ac.id', 'Sains Informasi', 'Guru Besar', '081999111012', '2026-11-01 13:36:17'),
(16, '198803302014041013', '0830038813', 'Rudi Hermawan, S.T., M.Kom.', 'L', 'rudi.hermawan@saintek.ac.id', 'Informatika', 'Lektor', '081999111013', '2026-11-01 13:36:17'),
(17, '199307112020122014', '0811079314', 'Ni Poetri Citra Dewi, S.Ds., M.A.', 'P', 'citra.dewi@saintek.ac.id', 'DKV', 'Asisten Ahli', '081999111014', '2026-11-01 13:36:17'),
(18, '198109092006041015', '0809098115', 'I Gusti Ngurah Wickrama, S.Kom., M.M.', 'L', 'ngurah.wickrama@saintek.ac.id', 'Sains Informasi', 'Lektor Kepala', '081999111015', '2026-11-01 13:36:17'),
(19, '198711252012121016', '0825118716', 'Aditya Pratama, S.Kom., M.Cs.', 'L', 'aditya.pratama@saintek.ac.id', 'Informatika', 'Lektor', '081999111016', '2026-11-01 13:36:17'),
(20, '199004182015042017', '0818049017', 'Ni Ketut Ayu Juliani, S.Si., M.Stat.', 'P', 'ayu.juliani@saintek.ac.id', 'Sains Informasi', 'Asisten Ahli', '081999111017', '2026-11-01 13:36:17'),
(21, '198501052010011018', '0805018518', 'I Dewa Made Bayu, S.Sn., M.Sn.', 'L', 'dewa.bayu@saintek.ac.id', 'DKV', 'Lektor', '081999111018', '2026-11-01 13:36:17'),
(22, '198908142014022019', '0814088919', 'Maya Puspita, S.T., M.Sc.', 'P', 'maya.puspita@saintek.ac.id', 'Informatika', 'Lektor', '081999111019', '2026-11-01 13:36:17'),
(23, '199210102019031020', '0810109220', 'I Putu Harta Wijaya, S.Kom., M.Kom.', 'L', 'harta.wijaya@saintek.ac.id', 'Sains Informasi', 'Asisten Ahli', '081999111020', '2026-11-01 13:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `semester` int NOT NULL DEFAULT '1',
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id_mahasiswa`, `nim`, `nama`, `jenis_kelamin`, `email`, `prodi`, `semester`, `no_hp`, `alamat`, `created_at`) VALUES
(8, '2208561001', 'I Putu Gede Pratama', 'L', 'putu.pratama@student.saintek.ac.id', 'Informatika', 5, '081234567001', 'Jl. Raya Batubulan No. 12, Gianyar', '2026-11-01 13:35:31'),
(9, '2208561002', 'Ni Made Ayu Saraswati', 'P', 'ayu.saraswati@student.saintek.ac.id', 'Informatika', 5, '081234567002', 'Jl. Teuku Umar No. 45, Denpasar', '2026-11-01 13:35:31'),
(10, '2208561003', 'I Nyoman Tri Dharma', 'L', 'tri.dharma@student.saintek.ac.id', 'Sains Informasi', 5, '081234567003', 'Jl. Gatot Subroto No. 88, Denpasar', '2026-11-01 13:35:31'),
(11, '2208561004', 'Ni Ketut Sri Wahyuni', 'P', 'sri.wahyuni@student.saintek.ac.id', 'DKV', 3, '081234567004', 'Jl. Raya Ubud No. 10, Gianyar', '2026-11-01 13:35:31'),
(12, '2208561005', 'I Wayan Bayu Riantha', 'L', 'bayu.riantha@student.saintek.ac.id', 'Informatika', 3, '081234567005', 'Jl. Sunset Road No. 22, Badung', '2026-11-01 13:35:31'),
(13, '2208561006', 'Ahmad Rizky Pratama', 'L', 'ahmad.rizky@student.saintek.ac.id', 'Sains Informasi', 3, '081234567006', 'Jl. Diponegoro No. 15, Denpasar', '2026-11-01 13:35:31'),
(14, '2208561007', 'Siti Nurhaliza', 'P', 'siti.nurhaliza@student.saintek.ac.id', 'DKV', 5, '081234567007', 'Jl. Hayam Wuruk No. 30, Denpasar', '2026-11-01 13:35:31'),
(15, '2208561008', 'I Gusti Ngurah Agung', 'L', 'ngurah.agung@student.saintek.ac.id', 'Informatika', 7, '081234567008', 'Jl. Bypass Ngurah Rai No. 99, Badung', '2026-11-01 13:35:31'),
(16, '2208561009', 'Ni Komang Triana Dewi', 'P', 'triana.dewi@student.saintek.ac.id', 'DKV', 1, '081234567009', 'Jl. Raya Tabanan No. 5, Tabanan', '2026-11-01 13:35:31'),
(17, '2208561010', 'I Kadek Dwi Lestari', 'L', 'dwi.lestari@student.saintek.ac.id', 'Sains Informasi', 1, '081234567010', 'Jl. Sesetan No. 14, Denpasar', '2026-11-01 13:35:31'),
(18, '2308561011', 'Kevin Sanjaya', 'L', 'kevin.sanjaya@student.saintek.ac.id', 'Informatika', 3, '081234567011', 'Jl. Imam Bonjol No. 77, Denpasar', '2026-11-01 13:35:31'),
(19, '2308561012', 'Grace Natalie', 'P', 'grace.natalie@student.saintek.ac.id', 'DKV', 3, '081234567012', 'Jl. Raya Kuta No. 101, Badung', '2026-11-01 13:35:31'),
(20, '2308561013', 'I Gede Budi Artana', 'L', 'budi.artana@student.saintek.ac.id', 'Sains Informasi', 3, '081234567013', 'Jl. Nangka Selatan No. 12, Denpasar', '2026-11-01 13:35:31'),
(21, '2308561014', 'Ni Luh Putu Maharani', 'P', 'putu.maharani@student.saintek.ac.id', 'Informatika', 1, '081234567014', 'Jl. Raya Singaraja No. 44, Buleleng', '2026-11-01 13:35:31'),
(22, '2308561015', 'Dewi Anggraini', 'P', 'dewi.anggraini@student.saintek.ac.id', 'Sains Informasi', 1, '081234567015', 'Jl. Cokroaminoto No. 60, Denpasar', '2026-11-01 13:35:31'),
(23, '2308561016', 'I Made Yogi Sugama', 'L', 'yogi.sugama@student.saintek.ac.id', 'DKV', 5, '081234567016', 'Jl. Raya Sukawati No. 18, Gianyar', '2026-11-01 13:35:31'),
(24, '2308561017', 'Farhan Maulana', 'L', 'farhan.maulana@student.saintek.ac.id', 'Informatika', 5, '081234567017', 'Jl. Monang Maning No. 9, Denpasar', '2026-11-01 13:35:31'),
(25, '2308561018', 'Ni Poetri Dian Lestari', 'P', 'poetri.dian@student.saintek.ac.id', 'Sains Informasi', 3, '081234567018', 'Jl. Bedugul No. 21, Denpasar', '2026-11-01 13:35:31'),
(26, '2308561019', 'I Anom Wijaya', 'L', 'anom.wijaya@student.saintek.ac.id', 'DKV', 1, '081234567019', 'Jl. Raya Mengwi No. 33, Badung', '2026-11-01 13:35:31'),
(27, '2308561020', 'Michael Tanuwijaya', 'L', 'michael.tan@student.saintek.ac.id', 'Informatika', 7, '081234567020', 'Jl. Raya Sanur No. 55, Denpasar', '2026-11-01 13:35:31'),
(28, '2408561021', 'Ni Made Rai Anggreni', 'P', 'rai.anggreni@student.saintek.ac.id', 'Sains Informasi', 1, '081234567021', 'Jl. Raya Seminyak No. 4, Badung', '2026-11-01 13:35:31'),
(29, '2408561022', 'I Putu Ryan Wiguna', 'L', 'ryan.wiguna@student.saintek.ac.id', 'DKV', 1, '081234567022', 'Jl. Danau Toba No. 19, Denpasar', '2026-11-01 13:35:31'),
(30, '2408561023', 'Budi Santoso', 'L', 'budi.santoso@student.saintek.ac.id', 'Informatika', 1, '081234567023', 'Jl. Buluh Indah No. 8, Denpasar', '2026-11-01 13:35:31'),
(31, '2408561024', 'Anisa Rahmawati', 'P', 'anisa.rahma@student.saintek.ac.id', 'Sains Informasi', 1, '081234567024', 'Jl. Cargo Permai No. 17, Denpasar', '2026-11-01 13:35:31'),
(32, '2408561025', 'I Komang Wira Sukma', 'L', 'wira.sukma@student.saintek.ac.id', 'DKV', 1, '081234567025', 'Jl. Raya Canggu No. 88, Badung', '2026-11-01 13:35:31'),
(33, '2408561026', 'Ni Ketut Intan Permata', 'P', 'intan.permata@student.saintek.ac.id', 'Informatika', 3, '081234567026', 'Jl. Tukad Badung No. 25, Denpasar', '2026-11-01 13:35:31'),
(34, '2408561027', 'I Wayan Arya Putra', 'L', 'arya.putra@student.saintek.ac.id', 'Sains Informasi', 5, '081234567027', 'Jl. Tukad Balian No. 34, Denpasar', '2026-11-01 13:35:31'),
(35, '2408561028', 'Fajar Ramadhan', 'L', 'fajar.ramadhan@student.saintek.ac.id', 'DKV', 5, '081234567028', 'Jl. Sidakarya No. 12, Denpasar', '2026-11-01 13:35:31'),
(36, '2408561029', 'Clarissa Amanda', 'P', 'clarissa.amanda@student.saintek.ac.id', 'Informatika', 3, '081234567029', 'Jl. Danau Poso No. 40, Denpasar', '2026-11-01 13:35:31'),
(37, '2408561030', 'I Gede Mahardika', 'L', 'gede.mahardika@student.saintek.ac.id', 'Sains Informasi', 7, '081234567030', 'Jl. Raya Amlapura No. 7, Karangasem', '2026-11-01 13:35:31'),
(38, '2108561031', 'Ni Luh Gede Erna', 'P', 'luh.erna@student.saintek.ac.id', 'DKV', 7, '081234567031', 'Jl. Raya Bangli No. 3, Bangli', '2026-11-01 13:35:31'),
(39, '2108561032', 'I Nyoman Gede Krisna', 'L', 'krisna.g@student.saintek.ac.id', 'Informatika', 7, '081234567032', 'Jl. Penelokan No. 15, Bangli', '2026-11-01 13:35:31'),
(40, '2108561033', 'Daniel Christian', 'L', 'daniel.chris@student.saintek.ac.id', 'Sains Informasi', 7, '081234567033', 'Jl. Raya Jimbaran No. 50, Badung', '2026-11-01 13:35:31'),
(41, '2108561034', 'Nadia Putri', 'P', 'nadia.putri@student.saintek.ac.id', 'DKV', 7, '081234567034', 'Jl. Raya Nusa Dua No. 66, Badung', '2026-11-01 13:35:31'),
(42, '2108561035', 'I Putu Surya Utama', 'L', 'surya.utama@student.saintek.ac.id', 'Informatika', 5, '081234567035', 'Jl. Ganetri No. 9, Denpasar', '2026-11-01 13:35:31'),
(43, '2108561036', 'Ni Kadek Tari Asih', 'P', 'tari.asih@student.saintek.ac.id', 'Sains Informasi', 5, '081234567036', 'Jl. Padang Luwih No. 11, Badung', '2026-11-01 13:35:31'),
(44, '2108561037', 'I Made Satria Wibawa', 'L', 'satria.wibawa@student.saintek.ac.id', 'DKV', 3, '081234567037', 'Jl. Dalung Permai No. 42, Badung', '2026-11-01 13:35:31'),
(45, '2108561038', 'Rizky Febrian', 'L', 'rizky.febrian@student.saintek.ac.id', 'Informatika', 3, '081234567038', 'Jl. Gunung Agung No. 70, Denpasar', '2026-11-01 13:35:31'),
(46, '2108561039', 'Jessica Veranda', 'P', 'jessica.v@student.saintek.ac.id', 'Sains Informasi', 5, '081234567039', 'Jl. Gunung Salak No. 18, Denpasar', '2026-11-01 13:35:31'),
(47, '2108561040', 'I Wayan Yuda Pratama', 'L', 'yuda.pratama@student.saintek.ac.id', 'DKV', 5, '081234567040', 'Jl. Marlboro No. 30, Denpasar', '2026-11-01 13:35:31'),
(48, '2208561041', 'Ni Komang Ayu Ningsih', 'P', 'ayu.ningsih@student.saintek.ac.id', 'Informatika', 3, '081234567041', 'Jl. Mahendradatta No. 100, Denpasar', '2026-11-01 13:35:31'),
(49, '2208561042', 'I Ketut Indra Wijaya', 'L', 'indra.wijaya@student.saintek.ac.id', 'Sains Informasi', 3, '081234567042', 'Jl. Raya Kerobokan No. 16, Badung', '2026-11-01 13:35:31'),
(50, '2208561043', 'Hendrik Setiawan', 'L', 'hendrik.s@student.saintek.ac.id', 'DKV', 5, '081234567043', 'Jl. Plawa No. 23, Denpasar', '2026-11-01 13:35:31'),
(51, '2208561044', 'Maya Kartika', 'P', 'maya.kartika@student.saintek.ac.id', 'Informatika', 5, '081234567044', 'Jl. Sumedang No. 5, Denpasar', '2026-11-01 13:35:31'),
(52, '2208561045', 'I Gusti Ayu Novia', 'P', 'ayu.novia@student.saintek.ac.id', 'Sains Informasi', 1, '081234567045', 'Jl. Kenyeri No. 14, Denpasar', '2026-11-01 13:35:31'),
(53, '2208561046', 'I Dewa Gede Rama', 'L', 'dewa.rama@student.saintek.ac.id', 'DKV', 1, '081234567046', 'Jl. Suwung Kauh No. 8, Denpasar', '2026-11-01 13:35:31'),
(54, '2208561047', 'Rachmat Hidayat', 'L', 'rachmat.h@student.saintek.ac.id', 'Informatika', 3, '081234567047', 'Jl. Pemogan No. 67, Denpasar', '2026-11-01 13:35:31'),
(55, '2208561048', 'Tiara Andini', 'P', 'tiara.andini@student.saintek.ac.id', 'Sains Informasi', 3, '081234567048', 'Jl. Pulau Kawe No. 12, Denpasar', '2026-11-01 13:35:31'),
(56, '2208561049', 'I Kadek Agus Aditya', 'L', 'agus.aditya@student.saintek.ac.id', 'DKV', 5, '081234567049', 'Jl. Raya Tabanan No. 89, Tabanan', '2026-11-01 13:35:31'),
(57, '2208561050', 'Ni Luh Made Tari', 'P', 'luh.tari@student.saintek.ac.id', 'Informatika', 5, '081234567050', 'Jl. Raya Celuk No. 4, Gianyar', '2026-11-01 13:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `id_pegawai` int NOT NULL,
  `nip_pegawai` varchar(30) DEFAULT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_pegawai` varchar(50) NOT NULL,
  `status_pegawai` enum('PNS','PPPK','Kontrak','Tetap Non-PNS') NOT NULL,
  `status_aktif` enum('Aktif','Non-Aktif','Cuti') DEFAULT 'Aktif',
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id_pegawai`, `nip_pegawai`, `nama_pegawai`, `jenis_kelamin`, `email`, `jenis_pegawai`, `status_pegawai`, `status_aktif`, `no_hp`, `created_at`) VALUES
(2, '198805122014021001', 'I Wayan Sugiarta', 'L', 'sugiarta@saintek.ac.id', 'Staf Administrasi', 'PNS', 'Aktif', '085739000001', '2026-11-01 13:33:31'),
(3, '199203102020122002', 'Ni Kadek Murniati', 'P', 'murniati@saintek.ac.id', 'Staf Keuangan', 'PPPK', 'Aktif', '085739000002', '2026-11-01 13:33:31'),
(4, NULL, 'I Nyoman Rai Sukarta', 'L', 'rai.sukarta@gmail.com', 'Teknis / IT Support', 'Kontrak', 'Aktif', '085739000003', '2026-11-01 13:33:31'),
(5, '198511202010011004', 'Bambang Triyono', 'L', 'bambang.t@saintek.ac.id', 'Kepala Lab Komputer', 'PNS', 'Aktif', '085739000004', '2026-11-01 13:33:31'),
(6, NULL, 'Ni Ketut Poetri Asih', 'P', 'poetri.asih@gmail.com', 'Staf Kepegawaian', 'Tetap Non-PNS', 'Aktif', '085739000005', '2026-11-01 13:33:31'),
(7, NULL, 'I Made Dwi Cahyadi', 'L', 'dwi.cahyadi@gmail.com', 'Teknis / IT Support', 'Kontrak', 'Aktif', '085739000006', '2026-11-01 13:33:31'),
(8, '199008082018012007', 'Siti Rahmawati', 'P', 'siti.rahma@saintek.ac.id', 'Staf Perpustakaan', 'PPPK', 'Aktif', '085739000007', '2026-11-01 13:33:31'),
(9, NULL, 'I Putu Agus Suputra', 'L', 'agus.suputra@gmail.com', 'Petugas Keamanan', 'Kontrak', 'Aktif', '085739000008', '2026-11-01 13:33:31'),
(10, NULL, 'Ni Luh Poetri Wahyuni', 'P', 'luh.wahyuni@gmail.com', 'Staf Kebersihan', 'Kontrak', 'Aktif', '085739000009', '2026-11-01 13:33:31'),
(11, '198604152009021010', 'I Gede Sudarma', 'L', 'sudarma@saintek.ac.id', 'Kepala Tata Usaha', 'PNS', 'Aktif', '085739000010', '2026-11-01 13:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id_pengumuman` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` enum('Akademik','Kemahasiswaan','Beasiswa','Umum') NOT NULL DEFAULT 'Umum',
  `isi_pengumuman` text NOT NULL,
  `penulis_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pengumuman`
--

INSERT INTO `tb_pengumuman` (`id_pengumuman`, `judul`, `kategori`, `isi_pengumuman`, `penulis_id`, `created_at`, `updated_at`) VALUES
(4, 'Pemeliharaan Rutin & Pembaruan Sistem Portal Saintek', 'Umum', 'Diberitahukan kepada seluruh pengguna portal bahwasanya akan dilakukan pemeliharaan sistem rutin dan optimasi database server pada hari Sabtu pukul 22.00 WITA. Mohon untuk mengamankan pekerjaan sebelum jadwal maintenance tiba.', 6, '2026-11-01 13:54:52', '2026-11-01 14:05:01'),
(5, 'Pengajuan Proposal Hibah Penulisan Jurnal & Riset Kampus', 'Akademik', 'Program pendampingan penulisan artikel ilmiah dan riset kolaborasi dosen-mahasiswa untuk publikasi semester genap telah dibuka. Pengajuan proposal dapat dilakukan langsung melalui sistem portal akademik.', 7, '2026-11-01 13:54:52', '2026-11-01 13:54:52'),
(6, 'Verifikasi Fisik KPRS & Pelayanan Administrasi Loket', 'Akademik', 'Pelayanan verifikasi fisik Kartu Perubahan Rencana Studi (KPRS) dan penyerahan kelengkapan berkas administrasi mahasiswa dibuka di loket Tata Usaha Fakultas dari pukul 08.00 hingga 15.00 WITA.', 8, '2026-11-01 13:54:52', '2026-11-01 13:54:52'),
(7, 'Pengumpulan Portofolio & Review Visual Tugas Akhir DKV', 'Akademik', 'Bagi seluruh mahasiswa DKV yang mengambil mata kuliah Tugas Akhir, batas pengumpulan draf visual story-boarding dan berkas karya fisik dijadwalkan paling lambat Jumat depan di Ruang Studio DKV.', 9, '2026-11-01 13:54:52', '2026-11-01 13:54:52'),
(8, 'Sosialisasi Alur Pengajuan Surat Keterangan Pendamping Ijazah (SKPI)', 'Kemahasiswaan', 'Bagian Staf Administrasi menyampaikan alur pengumpulan sertifikat kegiatan kemahasiswaan untuk verifikasi SKPI kelulusan periode mendatang. Seluruh dokumen wajib diunggah dalam format PDF.', 8, '2026-11-01 13:54:52', '2026-11-01 13:54:52'),
(9, 'Pemberitahuan Verifikasi Berkas Fisik Calon Penerima Beasiswa & Keringanan UKT', 'Beasiswa', 'Diberitahukan kepada seluruh mahasiswa Fakultas Sains dan Teknologi yang telah mengajukan Beasiswa dan permohonan keringanan UKT untuk Semester Genap ini, harap segera mengumpulkan berkas fisik pendukung. Berkas asli (KHS, Surat Kurang Mampu, dan dokumen pendukung lainnya) wajib diserahkan ke Loket Admin Keuangan untuk dilakukan verifikasi kesesuaian data. Batas waktu penyerahan dokumen paling lambat adalah hari Jumat, 20 November 2026 pukul 15.00 WITA di ruang Tata Usaha. Berkas yang terlambat tidak akan diproses untuk seleksi tahap berikutnya. Untuk pertanyaan lebih lanjut, silakan hubungi bagian keuangan pada jam kerja. Terima kasih. \r\n\r\nHormat kami,\r\nNi Kadek Murniati\r\nStaf Keuangan', 10, '2026-11-01 14:03:51', '2026-11-01 14:09:59'),
(10, 'Tata Tertib Penggunaan & Jadwal Uji Coba Laboratorium Komputer untuk Praktikum', 'Akademik', 'Menjelang pelaksanaan praktikum terpadu semester ini, seluruh mahasiswa dan asisten praktikum Fakultas Saintek diharapkan memperhatikan tata tertib penggunaan laboratorium komputer yang baru. Harap selalu menjaga kebersihan, dilarang membawa makanan/minuman ke dalam area lab, serta wajib mengenakan almamater saat jadwal kegiatan berlangsung. Laboratorium akan dibuka untuk umum/belajar mandiri di luar jam praktikum utama setiap hari Senin hingga Kamis pukul 15.00 - 17.00 WITA dengan pengawasan asisten jaga. Bagi mahasiswa yang membutuhkan instalasi software khusus untuk kebutuhan tugas akhir atau riset, silakan berkoordinasi terlebih dahulu melalui asisten lab atau langsung menemui Kepala Lab di ruang persiapan. Mari bersama-sama menjaga fasilitas bersama ini demi kelancaran proses akademik.\n\nSalam,\nBambang Triyono, S.Kom.\nKepala Laboratorium Komputer Saintek', 11, '2026-11-01 14:04:01', '2026-11-01 14:04:01'),
(11, 'Pembaruan Kode Sistem & Peningkatan Keamanan Portal Saintek', 'Umum', 'Diberitahukan kepada seluruh pengguna portal bahwa tim pengembang sedang melakukan pembaruan struktur kode sistem (refactoring) serta penerapan patch keamanan terbaru untuk meningkatkan stabilitas aplikasi.\r\n\r\n*Catatan Penting:* Seluruh civitas akademika diimbau untuk tidak perlu panik. Pembaruan kode ini dilakukan tanpa mengganggu integritas data, dan seluruh basis data (database) dipastikan tetap aman tersimpan tanpa risiko kehilangan data.\r\n\r\nJika menemukan kendala tampilan atau fungsi pasca-update, silakan hubungi Tim Admin IT.\r\n\r\nSalam,\r\nAdministrator Gede', 6, '2026-11-01 14:08:41', '2026-11-01 14:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level_user` enum('admin','dosen','mahasiswa','pegawai') NOT NULL,
  `id_referensi` int DEFAULT NULL,
  `status_akun` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `nama_lengkap`, `level_user`, `id_referensi`, `status_akun`, `created_at`) VALUES
(1, 'admin', '$2y$12$bDF2wKCSg7Nflyo9iw9g8.MUsfiiGNZwF7YcaXH0sHPyJjMA.jiE6', 'Administrator Saintek', 'admin', NULL, 'aktif', '2026-11-01 06:04:39'),
(6, 'admin_gede', '$2y$12$44LH1cuh3Jo0p4XfPAR35uaAj.Oh4zIamCYxhGti7pKi3X5RZwnBm', 'Administrator Gede', 'admin', NULL, 'aktif', '2026-11-01 08:25:34'),
(7, 'lektor_hendra', '$2y$12$jOtmCAF.gx.9AeQOlj6GTuUY87k.XCcVaqGbIKpYRLFknW9A7zV9y', 'Dr. Eng. Hendra Wijaya, S.T., M.T.', 'dosen', NULL, 'aktif', '2026-11-01 13:39:36'),
(8, 'pegawai_sugiarta', '$2y$12$vIfrFKh6gSDycAy5V7z1OeLLYwW6Vj4Aa5qsF3nTkDbqk3q/4Xj5O', 'I Wayan Sugiarta', 'pegawai', NULL, 'aktif', '2026-11-01 13:41:05'),
(9, 'dosen_dian', '$2y$12$z6qPMFBrnLAsgNegrjo7V.xwdAYRJlmuMDPJyG0bI1BkyitgTCBCG', 'Ni Putu Dian Utami, S.Ds., M.Ds.', 'dosen', NULL, 'aktif', '2026-11-01 13:49:19'),
(10, 'pegawai_murniati', '$2y$12$tS0Jd87GGBOOeG/sj/9L8uUKfzbRXmhIV7z3k318m/SVxGppozvL6', 'Ni Kadek Murniati', 'pegawai', NULL, 'aktif', '2026-11-01 13:58:23'),
(11, 'kepala_lab_triyono', '$2y$12$3KBNRBdoNBzDpJeAb5dTsOxuxuLPSVID4rPriMbHk5tzZSScTOobS', 'Bambang Triyono', 'pegawai', NULL, 'aktif', '2026-11-01 13:59:10'),
(12, 'admin2', '$2y$12$XllwLAZfanPt/JG5FE/4k.TZPJpE.honQbMNylWLH5KKnt6wQvcR2', 'Administrator', 'admin', NULL, 'aktif', '2026-11-02 07:15:48'),
(13, 'dosen2', '$2y$12$NM3uoreq3cFKWT1VxqBV0uuZXcDicGekinMQMOYL5YR74Tq6fzote', 'Dosen', 'dosen', NULL, 'aktif', '2026-11-02 07:16:42'),
(14, 'pegawai2', '$2y$12$jJpUjWmyr1raQ5juABFxUuLfRzNNcY9pnI36sF3iKQnwelRhGoYGW', 'Pegawai', 'pegawai', NULL, 'aktif', '2026-11-02 07:17:10'),
(15, 'mahasiswa2', '$2y$12$/5wU.3GweIY6nQTvPaF9xepg1ACtJ9aSupu9ZS4AQuoIruiS/rxku', 'Mahasiswa', 'mahasiswa', NULL, 'aktif', '2026-11-02 07:17:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `nip_pegawai` (`nip_pegawai`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `penulis_id` (`penulis_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  MODIFY `id_dosen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id_pegawai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id_pengumuman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD CONSTRAINT `tb_pengumuman_ibfk_1` FOREIGN KEY (`penulis_id`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
