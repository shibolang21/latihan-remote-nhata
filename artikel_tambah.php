<?php
// artikel_tambah.php - form input artikel
include "config.php";
$pageTitle = "Tambah Artikel";
?>
<?php include "partials/header.php"; ?>

<div class="card">
  <h2>Tambah Artikel</h2>

  <?php if (isset($_GET['err'])): ?>
    <div class="alert error"><?= htmlspecialchars($_GET['err']) ?></div>
  <?php endif; ?>

  <form class="form" method="POST" action="artikel_simpan.php" enctype="multipart/form-data"
        onsubmit="return confirmSave();">
    <label>Judul</label>
    <input type="text" name="judul" required placeholder="Judul artikel">

    <label>Isi</label>
    <textarea name="isi" rows="8" required placeholder="Isi artikel..."></textarea>

    <label>Gambar (wajib 1 gambar)</label>
    <input type="file" name="gambar" accept="image/*" required>

    <div class="row gap">
      <button class="btn" type="submit">Simpan</button>
      <a class="btn ghost" href="artikel_list.php">Batal</a>
    </div>

    <p class="muted small">
      Catatan: ekstensi yang diizinkan: JPG/JPEG/PNG, ukuran maksimum 2MB.
    </p>
  </form>
</div>

<?php include "partials/footer.php"; ?>
