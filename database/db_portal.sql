-- database/db_portal.sql
-- Import via phpMyAdmin
-- Catatan: sesuai MUK, nama database = NamaSiswa (silakan ganti sesuai nama Anda)

CREATE DATABASE IF NOT EXISTS NamaSiswa;
USE NamaSiswa;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- user default (admin/admin) -> password disimpan MD5
INSERT INTO users (username, password)
VALUES ('admin', MD5('admin'));

-- Tabel artikel
CREATE TABLE IF NOT EXISTS artikel (
  id_artikel INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  isi TEXT NOT NULL,
  gambar VARCHAR(255) NOT NULL,
  tanggal DATE NOT NULL
);

-- Data contoh (opsional). Hapus jika tidak diperlukan.
-- INSERT INTO artikel (judul, isi, gambar, tanggal) VALUES
-- ('Contoh Artikel', 'Ini isi artikel contoh untuk uji tampilan.', 'contoh.jpg', CURDATE());
