<?php
// artikel_simpan.php - proses simpan artikel + upload gambar
include "config.php";
include "koneksi.php";

$judul = trim($_POST['judul'] ?? '');
$isi   = trim($_POST['isi'] ?? '');
$tgl   = date('Y-m-d');

if ($judul === '' || $isi === '') {
    header("Location: artikel_tambah.php?err=" . urlencode("Judul dan isi wajib diisi."));
    exit;
}

if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    header("Location: artikel_tambah.php?err=" . urlencode("Gambar wajib diupload."));
    exit;
}

// Validasi upload
$folder = "assets/images/artikel/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$file = $_FILES['gambar'];
$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    header("Location: artikel_tambah.php?err=" . urlencode("Ekstensi tidak diizinkan. Gunakan JPG/JPEG/PNG."));
    exit;
}

$maxSize = 2 * 1024 * 1024; // 2MB
if ($file['size'] > $maxSize) {
    header("Location: artikel_tambah.php?err=" . urlencode("Ukuran file terlalu besar (maks 2MB)."));
    exit;
}

// Nama file unik
$namaBaru = time() . "_" . rand(100, 999) . "." . $ext;
$tujuan   = $folder . $namaBaru;

if (!move_uploaded_file($file['tmp_name'], $tujuan)) {

    die(
        "<pre>" .
        "Folder : $folder\n" .
        "Tujuan : $tujuan\n" .
        "Tmp File : " . $file['tmp_name'] . "\n" .
        "is_dir : " . (is_dir($folder) ? "YA" : "TIDAK") . "\n" .
        "is_writable : " . (is_writable($folder) ? "YA" : "TIDAK") .
        "</pre>"
    );

}

// Simpan ke database (prepared statement)
$sql  = "INSERT INTO artikel (judul, isi, gambar, tanggal) VALUES (?,?,?,?)";
$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) {
    @unlink($tujuan);
    die("Query error: " . mysqli_error($koneksi));
}
mysqli_stmt_bind_param($stmt, "ssss", $judul, $isi, $namaBaru, $tgl);
$ok = mysqli_stmt_execute($stmt);

if (!$ok) {
    @unlink($tujuan);
    die("Gagal menyimpan artikel: " . mysqli_error($koneksi));
}

header("Location: artikel_list.php?msg=save_ok");
exit;
