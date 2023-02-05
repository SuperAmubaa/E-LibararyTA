-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 17 Des 2022 pada 13.25
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `kode` char(8) CHARACTER SET utf8mb4 NOT NULL,
  `judul` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `tahun` char(5) CHARACTER SET utf8mb4 NOT NULL,
  `penerbit_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `pengarang_id` int(11) NOT NULL,
  `sinopsis` text NOT NULL,
  `stok` int(11) NOT NULL,
  `cover` varchar(120) NOT NULL DEFAULT 'img/cover/default.jpg',
  `harga` decimal(10,0) NOT NULL,
  `like` int(11) NOT NULL DEFAULT 0,
  `dislike` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id` int(11) NOT NULL,
  `jenis` varchar(55) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tarif` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `denda`
--

INSERT INTO `denda` (`id`, `jenis`, `keterangan`, `tarif`) VALUES
(1, 'Tidak Ada Denda', 'Buku dikembalikan dengan semestinya.', '0'),
(2, 'Keterlambatan', 'Terlambat Mengembalikan Buku', '5000/hari'),
(3, 'Kerusakan', 'Mengembalikan buku dalam keadaan rusak atau cacat', 'Harga buku + 5000'),
(4, 'Kehilangan', 'Menghilangkan Buku', 'Harga buku + 10000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kode` char(7) CHARACTER SET utf8mb4 NOT NULL,
  `nm_kategori` varchar(45) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `tgl_notif` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `redirect` varchar(255) NOT NULL DEFAULT '#',
  `status` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` enum('pending','accepted','rejected','finish') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Trigger `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `stokBuku` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
      IF (NEW.status = 'accepted') THEN
            UPDATE buku SET stok = stok - 1 WHERE id = NEW.buku_id;
      ELSEIF (NEW.status = 'finish') THEN
      		UPDATE buku SET stok = stok + 1 WHERE id = NEW.buku_id;
      END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id` int(11) NOT NULL,
  `nm_penerbit` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 NOT NULL,
  `tlp` varchar(15) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengarang`
--

CREATE TABLE `pengarang` (
  `id` int(11) NOT NULL,
  `nm_pengarang` varchar(55) CHARACTER SET utf8mb4 NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 NOT NULL,
  `tlp` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `tgl_kembali` date NOT NULL,
  `pustakawan_id` int(11) NOT NULL,
  `peminjaman_id` int(11) NOT NULL,
  `denda_id` int(11) NOT NULL,
  `tarif` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Trigger `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `updateTglKembali` AFTER INSERT ON `pengembalian` FOR EACH ROW UPDATE peminjaman SET tgl_kembali = NEW.tgl_kembali, status = 'finish' WHERE id = NEW.peminjaman_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `action` enum('like','dislike') NOT NULL,
  `anggota_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `tgl_rate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `rating`
--
DELIMITER $$
CREATE TRIGGER `rating_buku_delete` BEFORE DELETE ON `rating` FOR EACH ROW BEGIN
      IF (OLD.action = 'dislike') THEN
            UPDATE buku SET `dislike` = `dislike` - 1 WHERE id = OLD.buku_id;
      ELSEIF (OLD.action = 'like') THEN
            UPDATE buku SET `like` = `like` - 1 WHERE id = OLD.buku_id;
      END IF;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rating_buku_insert` AFTER INSERT ON `rating` FOR EACH ROW BEGIN
      IF (NEW.action = 'like') THEN
            UPDATE buku SET `like` = `like` + 1 WHERE id = NEW.buku_id;
      ELSEIF (NEW.action = 'dislike') THEN
            UPDATE buku SET `dislike` = `dislike` + 1 WHERE id = NEW.buku_id;
      END IF;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rating_buku_update` AFTER UPDATE ON `rating` FOR EACH ROW BEGIN
      IF (NEW.action = 'like' AND OLD.action = 'dislike') THEN
            UPDATE buku SET `like` = `like` + 1, `dislike` = `dislike` - 1 WHERE id = NEW.buku_id;
      ELSEIF (NEW.action = 'dislike' AND OLD.action = 'like') THEN
            UPDATE buku SET `dislike` = `dislike` + 1, `like` = `like` - 1 WHERE id = NEW.buku_id;
      END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(120) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(120) NOT NULL,
  `role` enum('anggota','pustakawan','admin') NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `agama` enum('Islam','Kristen','Hindu','Budha','Kong Hu Chu') NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL,
  `foto` varchar(100) DEFAULT 'img/avatar/default.jpg',
  `is_active` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `no_anggota` varchar(45) DEFAULT NULL,
  `nip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `gender`, `tgl_lahir`, `agama`, `alamat`, `tlp`, `foto`, `is_active`, `created_at`, `updated_at`, `remember_token`, `email_verified_at`, `no_anggota`, `nip`) VALUES
(1, 'Akhmad Lylana', 'admin@gmail.com', 'admin123', '$2y$10$mEsQoKuWDFE0RMti6OhmKe1rEGqRfNU0oJrjACG5hodA/VCZ797Zq', 'admin', 'L', '2000-09-19', 'Islam', 'Jl. Pangeran Cakrabuana No. 17', '083121085114', 'img/avatar/O1g3e7hQY1IieA46TtgzfFgXE0saVuY7xHB8F9nx.jpg', 'aktif', '2022-11-30 14:44:51', '2022-12-07 13:08:25', '7U30PmI5tLe8MM4Mdt5t5yI2UhB2uOYxE8Ga4S01Nz1k2ix5T8IilipVvRBy', '2022-11-30 14:44:50', NULL, NULL),
(2, 'Udin Petot', 'pustakawan@gmail.com', 'pustakawan123', '$2y$10$VHj/.Y8L13hzT32NuH/iT.WbxvZMMwo3VGijSNPw.ZmkLnBqStpZq', 'pustakawan', 'L', '2000-09-19', 'Islam', 'Jl. Pangeran Cakrabuana No. 17', '083121085114', 'img/avatar/default.jpg', 'aktif', '2022-11-30 14:44:51', '2022-12-17 06:00:33', 'GmUmXYf7NwMl9WvdRFZfNcbxKfaiIrjeaW72p5rJBD8ub0v8knuzCflhTgRn', '2022-11-30 14:44:51', NULL, NULL),
(3, 'Sugiono', 'anggota@gmail.com', 'anggota123', '$2y$10$WTFl.nVjn2hp9RwPyw9ECeOWs3HxzfCM7/.AtdFjXAbbiEhHclJUa', 'anggota', 'L', '2000-09-19', 'Islam', 'Jl. Pangeran Cakrabuana No. 16', '083121085114', 'img/avatar/default.jpg', 'aktif', '2022-11-30 14:44:51', '2022-12-17 12:10:31', 'JmRb9yocYLqcYbnfRgEhMGvEppl9cYS2qpvZFaoimITltvSZrUsi1cBxKvAB', '2022-11-30 14:44:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `anggota_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_UNIQUE` (`kode`),
  ADD KEY `fk_buku_penerbit_idx` (`penerbit_id`),
  ADD KEY `fk_buku_kategori1_idx` (`kategori_id`),
  ADD KEY `fk_buku_pengarang1_idx` (`pengarang_id`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_UNIQUE` (`kode`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifikasi_users1_idx` (`users_id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_anggota_has_buku_buku1_idx` (`buku_id`),
  ADD KEY `fk_peminjaman_users1_idx` (`anggota_id`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengarang`
--
ALTER TABLE `pengarang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pengembalian_denda1_idx` (`denda_id`),
  ADD KEY `fk_pengembalian_users1_idx` (`pustakawan_id`),
  ADD KEY `fk_pengembalian_peminjaman1_idx` (`peminjaman_id`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rating_users1_idx` (`anggota_id`),
  ADD KEY `fk_rating_buku1_idx` (`buku_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wishlist_buku1_idx` (`buku_id`),
  ADD KEY `fk_wishlist_users1_idx` (`anggota_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengarang`
--
ALTER TABLE `pengarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategori1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buku_penerbit` FOREIGN KEY (`penerbit_id`) REFERENCES `penerbit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buku_pengarang1` FOREIGN KEY (`pengarang_id`) REFERENCES `pengarang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `fk_notifikasi_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_anggota_has_buku_buku1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_users1` FOREIGN KEY (`anggota_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `fk_pengembalian_denda1` FOREIGN KEY (`denda_id`) REFERENCES `denda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengembalian_peminjaman1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengembalian_users1` FOREIGN KEY (`pustakawan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_buku1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rating_users1` FOREIGN KEY (`anggota_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_buku1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishlist_users1` FOREIGN KEY (`anggota_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;