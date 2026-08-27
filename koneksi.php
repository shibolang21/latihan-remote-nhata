<?php
// koneksi.php - koneksi database (mysqli, prosedural)
$host = "localhost";
$user = "root";
$pass = "";          // sesuaikan jika ada password (mis. di laptop tertentu)
$db   = "namasiswa"; // WAJIB: ganti sesuai nama database Anda (NamaSiswa)

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
