-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Nov 2025 pada 15.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paw_master_detail`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `supplier_id`, `kode_barang`, `nama_barang`, `harga_satuan`, `stok`) VALUES
(1, 1, 'BRG001', 'Buku Tulis', 5000.00, 100),
(2, 1, 'BRG002', 'Pulpen', 3000.00, 200),
(3, 2, 'BRG003', 'Penghapus', 2000.00, 150);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama_pelanggan`, `alamat`, `telepon`) VALUES
(1, 'Budi Santoso', NULL, NULL),
(2, 'Rina Agustina', NULL, NULL),
(3, 'Joko Purwanto', NULL, NULL),
(4, 'Dewi Kurniasih', NULL, NULL),
(5, 'Agus Supriyadi', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`) VALUES
(1, 'PT Sumber Makmur'),
(2, 'UD Maju Jaya'),
(3, 'PT Subur Jaya'),
(4, 'Toko electronik'),
(5, 'Toko perabotan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text NOT NULL,
  `total` decimal(10,2) DEFAULT 0.00,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2025-11-09', '-', 5000.00, 3),
(2, '2025-11-09', '-', 16000.00, 2),
(3, '2025-11-09', '-', 6000.00, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `barang_id`, `qty`, `harga`) VALUES
(1, 1, 1, 1, 5000.00),
(2, 2, 3, 8, 16000.00),
(3, 3, 2, 2, 6000.00);

--
-- Trigger `transaksi_detail`
--
DELIMITER $$
CREATE TRIGGER `trg_after_delete_detail` AFTER DELETE ON `transaksi_detail` FOR EACH ROW BEGIN
    UPDATE transaksi
    SET total = (
        SELECT COALESCE(SUM(harga), 0) 
        FROM transaksi_detail 
        WHERE transaksi_id = OLD.transaksi_id
    )
    WHERE id = OLD.transaksi_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_insert_detail` AFTER INSERT ON `transaksi_detail` FOR EACH ROW BEGIN
    UPDATE transaksi
    SET total = (
        SELECT SUM(harga) 
        FROM transaksi_detail 
        WHERE transaksi_id = NEW.transaksi_id
    )
    WHERE id = NEW.transaksi_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_update_detail` AFTER UPDATE ON `transaksi_detail` FOR EACH ROW BEGIN
    UPDATE transaksi
    SET total = (
        SELECT SUM(harga) 
        FROM transaksi_detail 
        WHERE transaksi_id = NEW.transaksi_id
    )
    WHERE id = NEW.transaksi_id;

    IF OLD.transaksi_id <> NEW.transaksi_id THEN
        UPDATE transaksi
        SET total = (
            SELECT COALESCE(SUM(harga), 0) 
            FROM transaksi_detail 
            WHERE transaksi_id = OLD.transaksi_id
        )
        WHERE id = OLD.transaksi_id;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_detail` (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
