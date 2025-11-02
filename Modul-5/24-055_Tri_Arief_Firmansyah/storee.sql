-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 03:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storee`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Gula pasir', 25000, 150, 1),
(2, 'BRG002', 'Kerupuk', 14500, 200, 1),
(3, 'BRG003', 'Sabun Mandi', 18000, 100, 2),
(4, 'BRG004', 'Mie Instan', 150000, 50, 3),
(5, 'BRG005', 'Jaket', 1500000, 20, 4),
(6, 'BRG006', 'Sandal', 65000, 120, 5),
(7, 'BRG007', 'Saus Tomat', 12000, 90, 3),
(8, 'BRG008', 'Shampo', 22000, 80, 2),
(9, 'BRG009', 'Odol', 10000, 110, 2),
(10, 'BRG010', 'Galon Mineral', 19000, 70, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('C001', 'Budi Santoso', 'L', '08112345678', 'Jl. Kenanga No. 3, Jakarta'),
('C002', 'Ani Lestari', 'P', '08578901234', 'Jl. Mawar No. 15, Bandung'),
('C003', 'Citra Dewi', 'P', '08781234567', 'Jl. Anggrek No. 8, Surabaya'),
('C004', 'Dedi Kurniawan', 'L', '08125566778', 'Jl. Dahlia No. 2, Semarang'),
('C005', 'Eko Prasetyo', 'L', '08591122334', 'Jl. Melati No. 11, Yogyakarta'),
('C006', 'Fani Rahma', 'P', '08210099887', 'Jl. Soka No. 6, Medan'),
('C007', 'Gilang Ramadhan', 'L', '08134455667', 'Jl. Teratai No. 1, Palembang'),
('C008', 'Hana Fitria', 'P', '08779988776', 'Jl. Kamboja No. 9, Makassar'),
('C009', 'Irfan Jauhari', 'L', '08960011223', 'Jl. Tulip No. 4, Denpasar'),
('C010', 'Julianti Rina', 'P', '08587766554', 'Jl. Matahari No. 14, Bekasi');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2025-10-29 10:00:15', 43000, 'TUNAI', 1),
(2, '2025-10-29 10:30:45', 150000, 'TRANSFER', 2),
(3, '2025-10-29 11:15:30', 1525000, 'EDC', 3),
(4, '2025-10-29 12:40:50', 94000, 'TUNAI', 4),
(5, '2025-10-29 13:10:20', 40000, 'TUNAI', 5),
(6, '2025-10-29 14:00:10', 31000, 'EDC', 6),
(7, '2025-10-29 15:30:05', 46000, 'TRANSFER', 7),
(8, '2025-10-29 16:50:35', 38000, 'TUNAI', 8),
(9, '2025-10-29 17:20:15', 145000, 'TRANSFER', 9),
(10, '2025-10-29 18:05:50', 109000, 'EDC', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Majemuk', '081123456780', 'Jl. Kunti No. 1, Surabaya'),
(2, 'CV Makmur jaya', '085678901231', 'Jl. Merak No. 5, Jakarta'),
(3, 'Toko Sembako', '087800112232', 'Jl. Cipta No. 10, Surabaya'),
(4, 'Benang Jarum Colection', '081233445563', 'Jl. Gatot Subroto No. 22, Semarang'),
(5, 'Mitra Abadi Sentosa', '085998765444', 'Jl. Pahlawan No. 20, Yogyakarta'),
(6, 'PT Surya Kencana', '082155667785', 'Jl. Sudirman No. 3A, Medan'),
(7, 'Global Food Supply', '081300998876', 'Jl. Asia Afrika No. 45, Palembang'),
(8, 'UD Sumber Rejeki', '087711223347', 'Jl. Veteran No. 7, Makassar'),
(9, 'Pabrik Peralatan Rumah', '089655443328', 'Jl. Rajawali No. 12, Denpasar'),
(10, 'Importir Komoditi Utama', '081577889909', 'Jl. Kartini No. 101, Bekasi');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `pelanggan_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2025-10-29', 'Belanja Harian jarot', 43000, 'C001'),
(2, '2025-10-29', 'Pembelian Grosir Mie', 150000, 'C003'),
(3, '2025-10-29', 'Beli Baju dan Gula', 1525000, 'C002'),
(4, '2025-10-29', 'Pembelian Gula dan Sandal', 94000, 'C005'),
(5, '2025-10-29', 'Beli Sabun dan Shampo', 40000, 'C006'),
(6, '2025-10-29', 'Belanja Kecil', 31000, 'C001'),
(7, '2025-10-29', 'Pembelian Perlengkapan Mandi', 46000, 'C008'),
(8, '2025-10-29', 'Pembelian Galon', 38000, 'C004'),
(9, '2025-10-29', 'Beli Gula Banyak', 145000, 'C009'),
(10, '2025-10-29', 'Belanja Akhir Hari', 109000, 'C010');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 25000, 1),
(1, 3, 18000, 1),
(2, 4, 150000, 1),
(3, 1, 25000, 1),
(3, 5, 1500000, 1),
(4, 2, 14500, 2),
(4, 6, 65000, 1),
(5, 3, 18000, 1),
(5, 8, 22000, 1),
(6, 7, 12000, 1),
(6, 10, 19000, 1),
(7, 3, 18000, 2),
(7, 9, 10000, 1),
(8, 10, 19000, 2),
(9, 2, 14500, 10),
(10, 6, 65000, 1),
(10, 8, 22000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator Toko', 'Jl. Raya Utama No. 1', '081111222333', 1),
(2, 'kasir01', '25d55ad283aa400af464c76d713c07ad', 'Siti Nurmala', 'Jl. Kasir No. 5', '085777888999', 2),
(3, 'kasir02', '25d55ad283aa400af464c76d713c07ad', 'Rudi Hermanto', 'Jl. Pegawai No. 1A', '081233445566', 2),
(4, 'gudang', '25d55ad283aa400af464c76d713c07ad', 'Ahmad Faruq', 'Jl. Gudang No. 1', '081300998877', 3),
(5, 'kasir03', '25d55ad283aa400af464c76d713c07ad', 'Dewi Susanti', 'Jl. Melati No. 1', '087811223344', 2),
(6, 'kasir04', '25d55ad283aa400af464c76d713c07ad', 'Joko Susilo', 'Jl. Mawar No. 2', '085911223344', 2),
(7, 'kasir05', '25d55ad283aa400af464c76d713c07ad', 'Lina Marlina', 'Jl. Kenanga No. 3', '082155667788', 2),
(8, 'kasir06', '25d55ad283aa400af464c76d713c07ad', 'Tomi Setiawan', 'Jl. Dahlia No. 4', '081577889900', 2),
(9, 'kasir07', '25d55ad283aa400af464c76d713c07ad', 'Mira Handayani', 'Jl. Tulip No. 5', '089600112233', 2),
(10, 'kasir08', '25d55ad283aa400af464c76d713c07ad', 'Rio Fernando', 'Jl. Soka No. 6', '085877665544', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
