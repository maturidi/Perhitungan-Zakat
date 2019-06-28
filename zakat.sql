-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2016 at 10:38 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zakat`
--

-- --------------------------------------------------------

--
-- Table structure for table `amil`
--

CREATE TABLE IF NOT EXISTS `amil` (
  `id_amil` int(10) NOT NULL,
  `nama_amil` varchar(30) NOT NULL,
  `alamat_amil` text NOT NULL,
  `email_amil` varchar(20) NOT NULL,
  `tlp_amil` varchar(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amil`
--

INSERT INTO `amil` (`id_amil`, `nama_amil`, `alamat_amil`, `email_amil`, `tlp_amil`, `username`, `password`) VALUES
(1, 'Tono', 'jln.zakat rt.01', 'zakat@gmail.com', '08971253411', 'zakat', 'zakat'),
(2, 'tani', 'jln,kesumba', 'tani@gmail.com', '089431', 'tani', 'tani'),
(3, 'titi', 'bangil', 'titi@gmail.com', '21301293', 'titi', 'titi');

-- --------------------------------------------------------

--
-- Table structure for table `bagi_zakat`
--

CREATE TABLE IF NOT EXISTS `bagi_zakat` (
  `id_bagi` int(10) NOT NULL,
  `id_amil` int(10) NOT NULL,
  `id_mustahiq` int(10) NOT NULL,
  `id_jns_barang` int(10) NOT NULL,
  `tanggal_bagi` date NOT NULL,
  `bagi` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bagi_zakat`
--

INSERT INTO `bagi_zakat` (`id_bagi`, `id_amil`, `id_mustahiq`, `id_jns_barang`, `tanggal_bagi`, `bagi`) VALUES
(1, 1, 2, 1, '2016-06-01', '20'),
(2, 1, 3, 1, '2016-07-02', '13'),
(3, 1, 3, 2, '2016-06-28', '100');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int(10) NOT NULL,
  `id_muzaki` int(10) NOT NULL,
  `id_amil` int(10) NOT NULL,
  `id_jenis` int(10) NOT NULL,
  `id_jns_barang` int(10) NOT NULL,
  `masuk` varchar(10) NOT NULL,
  `tgl_masuk` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_muzaki`, `id_amil`, `id_jenis`, `id_jns_barang`, `masuk`, `tgl_masuk`) VALUES
(1, 16, 1, 1, 1, '20', '2016-06-29'),
(4, 17, 0, 1, 1, '2', '2016-06-29'),
(5, 17, 1, 2, 2, '21', '2016-07-29'),
(6, 18, 1, 2, 2, '20000', '2016-06-29'),
(7, 16, 1, 1, 1, '20', '2016-06-12'),
(8, 16, 1, 1, 1, '13', '2016-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE IF NOT EXISTS `jenis_barang` (
  `id_jns_barang` int(10) NOT NULL,
  `nama_jns_barang` varchar(30) NOT NULL,
  `satuan_jns_barang` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jns_barang`, `nama_jns_barang`, `satuan_jns_barang`) VALUES
(1, 'beras', 'Kilogram'),
(2, 'uang', 'Rupiah');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_zakat`
--

CREATE TABLE IF NOT EXISTS `jenis_zakat` (
  `id_jenis` int(10) NOT NULL,
  `nama_jenis` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_zakat`
--

INSERT INTO `jenis_zakat` (`id_jenis`, `nama_jenis`) VALUES
(1, 'fitrah'),
(2, 'maal');

-- --------------------------------------------------------

--
-- Table structure for table `macam_mustahiq`
--

CREATE TABLE IF NOT EXISTS `macam_mustahiq` (
  `id_macam` int(10) NOT NULL,
  `nama_macam` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `macam_mustahiq`
--

INSERT INTO `macam_mustahiq` (`id_macam`, `nama_macam`) VALUES
(1, 'fakir'),
(2, 'miskin'),
(9, 'amil'),
(10, 'mu`allaf'),
(11, 'hamba sahaya'),
(12, 'gharimin'),
(13, 'fisabilillah');

-- --------------------------------------------------------

--
-- Table structure for table `mustahiq`
--

CREATE TABLE IF NOT EXISTS `mustahiq` (
  `id_mustahiq` int(10) NOT NULL,
  `id_kategori` int(10) NOT NULL,
  `nama_mustahiq` varchar(30) NOT NULL,
  `umur_mustahiq` varchar(3) NOT NULL,
  `jk_mustahiq` enum('Laki - Laki','Perempuan','','') NOT NULL,
  `alamat_mustahiq` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mustahiq`
--

INSERT INTO `mustahiq` (`id_mustahiq`, `id_kategori`, `nama_mustahiq`, `umur_mustahiq`, `jk_mustahiq`, `alamat_mustahiq`) VALUES
(2, 1, 'Budi', '30', 'Laki - Laki', 'Malang'),
(3, 2, 'Bagus', '33', 'Laki - Laki', 'Malang'),
(4, 2, 'Nurul', '43', 'Perempuan', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `muzaki`
--

CREATE TABLE IF NOT EXISTS `muzaki` (
  `id_muzaki` int(10) NOT NULL,
  `nama_muzaki` varchar(30) NOT NULL,
  `alamat_muzaki` text NOT NULL,
  `tlp_muzaki` varchar(15) NOT NULL,
  `jk_muzaki` enum('Laki - Laki','Perempuan','','') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `muzaki`
--

INSERT INTO `muzaki` (`id_muzaki`, `nama_muzaki`, `alamat_muzaki`, `tlp_muzaki`, `jk_muzaki`) VALUES
(16, 'Faisol', 'Malang', '081787654567', 'Laki - Laki'),
(17, 'Ahmad', 'Surabaya', '081676545678', 'Laki - Laki'),
(18, 'Siti', 'Kediri', '081678898888', 'Perempuan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amil`
--
ALTER TABLE `amil`
  ADD PRIMARY KEY (`id_amil`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bagi_zakat`
--
ALTER TABLE `bagi_zakat`
  ADD PRIMARY KEY (`id_bagi`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jns_barang`);

--
-- Indexes for table `jenis_zakat`
--
ALTER TABLE `jenis_zakat`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `macam_mustahiq`
--
ALTER TABLE `macam_mustahiq`
  ADD PRIMARY KEY (`id_macam`);

--
-- Indexes for table `mustahiq`
--
ALTER TABLE `mustahiq`
  ADD PRIMARY KEY (`id_mustahiq`);

--
-- Indexes for table `muzaki`
--
ALTER TABLE `muzaki`
  ADD PRIMARY KEY (`id_muzaki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amil`
--
ALTER TABLE `amil`
  MODIFY `id_amil` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bagi_zakat`
--
ALTER TABLE `bagi_zakat`
  MODIFY `id_bagi` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id_jns_barang` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jenis_zakat`
--
ALTER TABLE `jenis_zakat`
  MODIFY `id_jenis` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `macam_mustahiq`
--
ALTER TABLE `macam_mustahiq`
  MODIFY `id_macam` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `mustahiq`
--
ALTER TABLE `mustahiq`
  MODIFY `id_mustahiq` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `muzaki`
--
ALTER TABLE `muzaki`
  MODIFY `id_muzaki` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
