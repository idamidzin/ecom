-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Des 2024 pada 14.20
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_pandu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_user` varchar(25) NOT NULL,
  `id_invoice` varchar(30) NOT NULL,
  `id_brg` int(11) NOT NULL,
  `nama_brg` varchar(255) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `id_user`, `id_invoice`, `id_brg`, `nama_brg`, `jumlah`, `harga`) VALUES
(1, '11', 'INV-45965289', 1, 'Vaporesso Luxe Q', 3, 750000),
(2, '11', 'INV-45965289', 4, 'GeekVape Aegis Legend 2', 1, 500000),
(3, '11', 'INV-74772021', 1, 'Vaporesso Luxe Q', 3, 750000),
(4, '11', 'INV-74772021', 4, 'GeekVape Aegis Legend 2', 1, 500000);

--
-- Trigger `cart`
--
DELIMITER $$
CREATE TRIGGER `pesanan_penjualan` AFTER INSERT ON `cart` FOR EACH ROW BEGIN
	UPDATE product SET stok = stok-NEW.jumlah
    WHERE id_brg = NEW.id_brg;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_brg` int(11) NOT NULL,
  `nama_brg` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kategori` varchar(60) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(4) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_brg`, `nama_brg`, `keterangan`, `kategori`, `harga`, `stok`, `gambar`) VALUES
(1, 'Vaporesso Luxe Q', 'Pod system dengan kapasitas baterai 2000mAh, mendukung output hingga 80W.Pod kecil dengan desain premium dan teknologi anti-bocor.', 'Device', 750000, -8, '7.jpeg'),
(2, 'Smok Nord 4', 'Pod system dengan kapasitas baterai 2000mAh, mendukung output hingga 80W.', 'Device', 600000, 13, '4.jpeg'),
(4, 'GeekVape Aegis Legend 2', 'Box mod tahan air dan debu dengan daya hingga 200W.', 'Device', 500000, -4, '2.jpeg'),
(5, 'Naked 100 - Hawaiian Pog', 'Freebase liquid rasa campuran jeruk, jambu, dan markisa.', 'Liquid', 200000, 2, 'download.jpeg'),
(6, 'Dinner Lady - Lemon Tart', 'asdfFreebase dengan rasa creamy lemon pie.', 'Liquid', 200000, 10, 'images.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_cart`
--

CREATE TABLE `temp_cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `temp_cart`
--

INSERT INTO `temp_cart` (`id`, `user_id`, `product_id`, `quantity`, `price`, `name`, `options`, `created_at`, `updated_at`) VALUES
(6, '11', 1, 3, '750000.00', 'Vaporesso Luxe Q', '{\"keterangan\":\"Pod system dengan kapasitas baterai 2000mAh, mendukung output hingga 80W.Pod kecil dengan desain premium dan teknologi anti-bocor.\",\"kategori\":\"Device\",\"gambar\":\"7.jpeg\"}', '2024-11-27 06:52:07', '2024-11-27 12:24:54'),
(7, '11', 4, 1, '500000.00', 'GeekVape Aegis Legend 2', '{\"keterangan\":\"Box mod tahan air dan debu dengan daya hingga 200W.\",\"kategori\":\"Device\",\"gambar\":\"2.jpeg\"}', '2024-11-27 06:52:10', '2024-11-27 06:52:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `order_id` char(30) NOT NULL,
  `id_user` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(225) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `mobile_phone` varchar(15) NOT NULL,
  `city` varchar(255) NOT NULL,
  `kode_pos` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `ekspedisi` varchar(100) NOT NULL,
  `total_ongkir` decimal(15,2) DEFAULT 0.00,
  `tracking_id` varchar(30) NOT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `payment_limit` datetime DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  `gambar` text DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_bayar` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`order_id`, `id_user`, `name`, `email`, `alamat`, `mobile_phone`, `city`, `kode_pos`, `payment_method`, `ekspedisi`, `total_ongkir`, `tracking_id`, `transaction_time`, `payment_limit`, `status`, `gambar`, `subtotal`, `total_bayar`) VALUES
('INV-45965289', '11', 'Gembul House', 'test@gmail.com', 'Cipasung Rt10/Rw04 Dusun Manis', '082129960156', '109', '45562', 'Direct Bank Transfer', 'pos', '12000.00', '199218270109', '2024-11-27 17:43:55', '2024-11-28 17:43:55', '1', 'bukti11.png', '2750000.00', '2762000.00'),
('INV-74772021', '11', 'Gembul House', 'test@gmail.com', 'Cipasung Rt10/Rw04 Dusun Manis', '082129960156', '211', '45562', 'Direct Bank Transfer', 'tiki', '10000.00', '950297528160', '2024-11-27 19:25:48', '2024-11-28 19:25:48', '1', 'bukti4.png', '2750000.00', '2760000.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `avatar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `password`, `level`, `avatar`) VALUES
(6, 'Helpdesk Shoppify', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', 'user.png'),
(11, 'Testing', 'test@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2', 'user.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_brg`);

--
-- Indeks untuk tabel `temp_cart`
--
ALTER TABLE `temp_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id_brg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `temp_cart`
--
ALTER TABLE `temp_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
