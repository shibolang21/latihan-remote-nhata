<?php
// artikel_hapus.php - proses hapus artikel (hapus db + file)
include "config.php";
include "koneksi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: artikel_list.php");
    exit;
}

// Ambil nama file gambar
$sql = "SELECT gambar FROM artikel WHERE id_artikel = ? LIMIT 1";
$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) die("Query error: " . mysqli_error($koneksi));
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$gambar = "";
if ($res && mysqli_num_rows($res) === 1) {
    $row = mysqli_fetch_assoc($res);
    $gambar = $row['gambar'] ?? '';
}

// Hapus data artikel
$sql2 = "DELETE FROM artikel WHERE id_artikel = ?";
$stmt2 = mysqli_prepare($koneksi, $sql2);
if (!$stmt2) die("Query error: " . mysqli_error($koneksi));
mysqli_stmt_bind_param($stmt2, "i", $id);
mysqli_stmt_execute($stmt2);

// Hapus file gambar (jika ada)
if ($gambar !== "") {
    $path = "assets/images/artikel/" . $gambar;
    if (file_exists($path)) {
        @unlink($path);
    }
}

header("Location: artikel_list.php?msg=delete_ok");
exit;
