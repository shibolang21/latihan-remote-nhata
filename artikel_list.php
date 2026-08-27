<?php
// artikel_list.php - daftar artikel + pagination (maks 6 artikel/halaman)
include "config.php";
include "koneksi.php";
include "library/pagination.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; // WAJIB
if ($page < 1) $page = 1;

$offset = ($page - 1) * $perPage;

// total data
$qTotal = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM artikel");
$total  = 0;
if ($qTotal) {
    $rTotal = mysqli_fetch_assoc($qTotal);
    $total  = (int)($rTotal['jml'] ?? 0);
}

// data per halaman
$sql = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT $perPage OFFSET $offset";
$data = mysqli_query($koneksi, $sql);

$pageTitle = "Daftar Artikel";
?>
<?php include "partials/header.php"; ?>

<?php
// alert setelah aksi
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg === 'save_ok') echo "<script>window.addEventListener('DOMContentLoaded', () => alert('Artikel berhasil disimpan!'));</script>";
    if ($msg === 'delete_ok') echo "<script>window.addEventListener('DOMContentLoaded', () => alert('Artikel berhasil dihapus!'));</script>";
}
?>

<div class="card">
  <div class="row space-between align-center">
    <h2>Daftar Artikel</h2>
    <a class="btn" href="artikel_tambah.php">+ Tambah Artikel</a>
  </div>

  <?php if ($data && mysqli_num_rows($data) > 0): ?>
    <div class="cards">
      <?php while($row = mysqli_fetch_assoc($data)): ?>
        <?php 
          $imgPath = "assets/images/artikel/" . $row['gambar'];
          $imgSrc = (file_exists($imgPath) && !empty($row['gambar'])) ? $imgPath : "assets/images/article-placeholder.png";
        ?>
        <article class="card article">
          <div class="article-thumb">
            <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" loading="lazy">
          </div>
          <div class="article-body">
            <h3><?= htmlspecialchars($row['judul']) ?></h3>
            <p class="muted small">Tanggal: <?= htmlspecialchars($row['tanggal']) ?></p>
            <p>
              <?php
                $cuplikan = substr(strip_tags($row['isi']), 0, 200); // WAJIB 200 karakter
                echo htmlspecialchars($cuplikan) . (strlen(strip_tags($row['isi'])) > 200 ? "..." : "");
              ?>
            </p>
            <div class="row gap">
              <a class="btn ghost" href="artikel_detail.php?id=<?= (int)$row['id_artikel'] ?>">Read More</a>
              <a class="btn danger" href="artikel_hapus.php?id=<?= (int)$row['id_artikel'] ?>"
                 onclick="return confirmDelete();">Hapus</a>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <?= renderPagination($page, $perPage, $total, "artikel_list.php"); ?>

  <?php else: ?>
    <p class="muted">Belum ada artikel. Silakan tambah artikel terlebih dahulu.</p>
  <?php endif; ?>
</div>

<?php include "partials/footer.php"; ?>
