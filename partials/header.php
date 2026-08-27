<?php
// partials/header.php - header + menu (dipakai di halaman internal)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle ?? "Portal Artikel") ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/script.js" defer></script>
</head>
<body>
  <header class="header">
    <div class="container header-container">
      <div class="header-brand">
        <a href="index.php" class="logo">
          <h1>Modern Editorial CMS</h1>
        </a>
        <?php if(isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
          <span class="admin-badge"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
        <?php endif; ?>
      </div>
      
      <nav class="header-nav">
        <?php if(isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
          <a class="nav-link" href="dashboard.php">Dashboard</a>
          <a class="nav-link" href="artikel_list.php">Daftar Artikel</a>
          <a class="nav-link" href="artikel_tambah.php">Tambah Artikel</a>
          <a class="nav-link danger" href="logout.php" onclick="return confirmLogout();">Logout</a>
        <?php else: ?>
          <a class="nav-link" href="index.php">Home</a>
          <a class="nav-link outline" href="login.php">Login Admin</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

<div class="container">
  <main class="main">
