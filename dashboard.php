<?php
// dashboard.php - halaman utama setelah login
include "config.php";
include "koneksi.php";

$pageTitle = "Dashboard";

$q1 = mysqli_query($koneksi, "SELECT COUNT(*) AS total_artikel FROM artikel");
$row1 = $q1 ? mysqli_fetch_assoc($q1) : ['total_artikel' => 0];

$q2 = mysqli_query($koneksi, "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 5");
?>
<?php include "partials/header.php"; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'login_ok'): ?>
  <script>window.addEventListener('DOMContentLoaded', () => alert('Login berhasil!'));</script>
<?php endif; ?>

<section class="grid">
  <div class="card">
    <h2>Ringkasan</h2>
    <p>Total artikel: <b><?= (int)$row1['total_artikel'] ?></b></p>
    <p class="muted small">Gunakan menu untuk menambah, melihat, atau menghapus artikel.</p>
  </div>

  <div class="card">
    <h2>5 Artikel Terbaru</h2>
    <?php if ($q2 && mysqli_num_rows($q2) > 0): ?>
      <ul class="list">
        <?php while($a = mysqli_fetch_assoc($q2)): ?>
          <li>
            <a href="artikel_detail.php?id=<?= (int)$a['id_artikel'] ?>">
              <?= htmlspecialchars($a['judul']) ?>
            </a>
            <span class="muted small">— <?= htmlspecialchars($a['tanggal']) ?></span>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p class="muted">Belum ada artikel.</p>
    <?php endif; ?>
  </div>
</section>

<?php include "partials/footer.php"; ?>
