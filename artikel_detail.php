<?php
// artikel_detail.php - Read More (detail artikel)
include "config.php";
include "koneksi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: artikel_list.php");
    exit;
}

$sql = "SELECT * FROM artikel WHERE id_artikel = ? LIMIT 1";
$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) die("Query error: " . mysqli_error($koneksi));
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (!$res || mysqli_num_rows($res) !== 1) {
    header("Location: artikel_list.php");
    exit;
}
$row = mysqli_fetch_assoc($res);

$pageTitle = "Detail Artikel";
?>
<?php include "partials/header.php"; ?>

<article class="card">
  <div class="detail-header">
    <h1><?= htmlspecialchars($row['judul']) ?></h1>
    <div class="detail-meta">
      <span>Ditulis oleh Admin</span>
      <span>•</span>
      <span><?= htmlspecialchars($row['tanggal']) ?></span>
    </div>
  </div>

  <?php 
    $imgPath = "assets/images/artikel/" . $row['gambar'];
    $imgSrc = (file_exists($imgPath) && !empty($row['gambar'])) ? $imgPath : "assets/images/article-placeholder.png";
  ?>
  <div class="detail-thumb">
    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
  </div>

  <div class="content">
    <?php
      // tampilkan isi (aman untuk HTML sederhana)
      // Jika Anda ingin benar-benar aman, gunakan htmlspecialchars().
      // Untuk ujian sederhana, bisa tampilkan dengan nl2br + htmlspecialchars.
      echo nl2br(htmlspecialchars($row['isi']));
    ?>
  </div>

  <div class="row gap">
    <a class="btn ghost" href="artikel_list.php">← Kembali</a>
  </div>
</article>

<?php include "partials/footer.php"; ?>
