-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2026 at 12:01 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_icecream`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `menu_item` varchar(100) NOT NULL,
  `topping` varchar(100) NOT NULL,
  `jumlah` int NOT NULL,
  `total_harga` int NOT NULL,
  `kode_qr` varchar(255) NOT NULL,
  `tanggal_pesan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `user_id`, `menu_item`, `topping`, `jumlah`, `total_harga`, `kode_qr`, `tanggal_pesan`) VALUES
(1, '1', 'Es Krim Vanilla', 'Cokelat', 1, 15000, 'QRIS123', '2026-10-19 04:13:40'),
(2, '1', 'Es Krim Vanilla', 'Cokelat', 1, 15000, 'QRIS123', '2026-10-23 06:46:21'),
(3, '1', 'Es Krim Vanilla', 'Tanpa Topping', 1, 0, '', '2026-10-23 07:58:10'),
(4, '1', 'Es Krim Vanilla', 'Tanpa Topping', 1, 0, '', '2026-10-23 08:00:19'),
(5, '1', 'Es Krim Vanilla', 'Tanpa Topping', 1, 0, '', '2026-10-23 08:40:23'),
(6, '1', 'Es Krim Vanilla', 'Tanpa Topping', 1, 0, '', '2026-10-23 08:40:24'),
(7, '1', 'Es Krim Vanilla', 'Tanpa Topping', 1, 0, '', '2026-10-23 08:40:24'),
(8, '1', '', '', 1, 0, '', '2026-10-23 09:04:16'),
(9, '', 'Vanila Cone', 'Tidak Ada', 1, 0, '', '2026-10-23 09:12:53'),
(10, '', 'Vanila Cone', 'Tidak Ada', 1, 0, '', '2026-10-24 05:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pelanggan','admin') DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Anisa Novianti', 'anisa@gmail.com', '12345', 'pelanggan'),
(2, 'Admin Toko', 'admin@17icecream.com', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
