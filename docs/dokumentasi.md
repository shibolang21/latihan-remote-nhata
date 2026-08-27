# Dokumentasi - Portal Artikel Sederhana (MUK Junior Web Programmer)

## 1. Deskripsi Aplikasi
Aplikasi **Portal Artikel Sederhana** dibuat menggunakan **HTML, CSS (eksternal), PHP, JavaScript, dan MySQL (mysqli)** dengan paradigma **pemrograman terstruktur (bukan OOP)**.

Fitur utama:
- Login menggunakan session PHP (admin/admin, verifikasi MD5)
- Manajemen artikel (tambah, simpan, hapus) + upload gambar
- Daftar artikel menampilkan judul, gambar, cuplikan isi 200 karakter + Read More
- Pagination maksimal 6 artikel per halaman (navigasi halaman aktif)
- UI rapi & konsisten (header, menu, konten, footer)
- Confirm JavaScript: simpan, hapus, logout

## 2. Struktur Folder
Lihat struktur folder wajib sesuai MUK:
- index.php, login.php, logout.php, dashboard.php
- artikel_list.php, artikel_tambah.php, artikel_simpan.php, artikel_hapus.php, artikel_detail.php
- koneksi.php, config.php
- assets/css/style.css, assets/js/script.js, assets/images/artikel/
- library/pagination.php
- database/db_portal.sql

## 3. Cara Instalasi
1) Taruh folder `project-web-jwp` di `htdocs` (XAMPP) / `www` (Laragon).  
2) Buat database dan tabel: import file `database/db_portal.sql` via phpMyAdmin.  
3) Edit `koneksi.php`:
   - `$db = "NamaSiswa"` sesuaikan dengan database Anda.
4) Akses:
   - `http://localhost/project-web-jwp/`

## 4. Screenshot Halaman (isi saat ujian)
- Login
- Dashboard
- Daftar artikel (pagination terlihat)
- Tambah artikel (form)
- Detail artikel (Read More)
- Confirm JS: simpan/hapus/logout

## 5. Catatan Debugging (contoh)
- Kasus: login selalu gagal  
  Penyebab: password di DB belum diisi MD5('admin')  
  Solusi: pastikan insert user menggunakan MD5 dan proses login juga md5 input password
