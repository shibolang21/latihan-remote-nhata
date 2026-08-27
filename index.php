<?php
// index.php - halaman utama (publik)
session_start();
include "config.php";
include "koneksi.php";
include "library/pagination.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $perPage;
$search = isset($_GET['q']) ? $_GET['q'] : '';

// Query untuk total data
$sqlTotal = "SELECT COUNT(*) AS jml FROM artikel";
if ($search !== '') {
    $sqlTotal .= " WHERE judul LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}
$qTotal = mysqli_query($koneksi, $sqlTotal);
$total = 0;
if ($qTotal) {
    $rTotal = mysqli_fetch_assoc($qTotal);
    $total  = (int)($rTotal['jml'] ?? 0);
}

// Query untuk data artikel (untuk grid)
$sql = "SELECT * FROM artikel";
if ($search !== '') {
    $sql .= " WHERE judul LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%'";
}
$sql .= " ORDER BY id_artikel DESC LIMIT $perPage OFFSET $offset";
$data = mysqli_query($koneksi, $sql);

// Query untuk artikel unggulan (hanya tampil di halaman 1 dan jika tidak sedang mencari)
$featured = null;
if ($page === 1 && $search === '') {
    $sqlFeatured = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 1";
    $qFeatured = mysqli_query($koneksi, $sqlFeatured);
    if ($qFeatured && mysqli_num_rows($qFeatured) > 0) {
        $featured = mysqli_fetch_assoc($qFeatured);
    }
}

$pageTitle = "Beranda - Modern Editorial CMS";
include "partials/header.php";
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'logout_ok'): ?>
  <div class="alert" style="color: var(--success); border-color: var(--success); text-align: center; max-width: 600px; margin: 0 auto 32px auto;">Anda telah berhasil logout.</div>
<?php endif; ?>

<?php if ($featured): ?>
  <?php 
    $heroImgPath = "assets/images/artikel/" . $featured['gambar'];
    $heroImgSrc = (file_exists($heroImgPath) && !empty($featured['gambar'])) ? $heroImgPath : "assets/images/article-placeholder.png";
  ?>
  <div class="hero-section">
    <img src="<?= htmlspecialchars($heroImgSrc) ?>" alt="<?= htmlspecialchars($featured['judul']) ?>" class="hero-bg">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="hero-meta">
        <span class="hero-date"><?= htmlspecialchars($featured['tanggal']) ?></span>
      </div>
      <h2 class="hero-title"><?= htmlspecialchars($featured['judul']) ?></h2>
      <p class="hero-excerpt">
        <?php
          $cuplikan = substr(strip_tags($featured['isi']), 0, 200);
          echo htmlspecialchars($cuplikan) . (strlen(strip_tags($featured['isi'])) > 200 ? "..." : "");
        ?>
      </p>
      <a class="hero-btn" href="artikel_detail.php?id=<?= (int)$featured['id_artikel'] ?>">Read Article</a>
    </div>
  </div>
<?php endif; ?>

<div class="search-container">
  <form method="GET" action="index.php" class="search-form">
    <input type="text" name="q" placeholder="Cari artikel..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn" type="submit">Cari</button>
  </form>
</div>

<div class="section-header">
  <h2>Latest Articles</h2>
  <p class="muted">Discover the latest published articles.</p>
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
          <p class="excerpt">
            <?php
              $cuplikan = substr(strip_tags($row['isi']), 0, 200);
              echo htmlspecialchars($cuplikan) . (strlen(strip_tags($row['isi'])) > 200 ? "..." : "");
            ?>
          </p>
          <div class="row">
            <a class="btn ghost" href="artikel_detail.php?id=<?= (int)$row['id_artikel'] ?>">Read More</a>
          </div>
        </div>
      </article>
    <?php endwhile; ?>
  </div>

  <?php
    $urlPagination = "index.php" . ($search !== '' ? "?q=" . urlencode($search) : "");
  ?>
  <?= renderPagination($page, $perPage, $total, $search !== '' ? "index.php?q=" . urlencode($search) : "index.php"); ?>

<?php else: ?>
  <div class="card" style="text-align: center; padding: 64px 24px;">
    <h2>Tidak ada artikel ditemukan</h2>
    <p class="muted">Coba cari dengan kata kunci lain atau periksa kembali nanti.</p>
  </div>
<?php endif; ?>

<?php include "partials/footer.php"; ?>
