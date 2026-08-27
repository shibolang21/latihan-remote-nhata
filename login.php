<?php
// login.php - proses login (session + MD5) dan form login

session_start();

// Jika sudah login langsung ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit;
}

include "koneksi.php";

// Proses login hanya jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $hash = md5($password);

    $sql = "SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        die("Query Error : " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $hash);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {

        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        header("Location: dashboard.php?msg=login_ok");
        exit;
    }

    header("Location: login.php?err=1");
    exit;
}

$pageTitle = "Login Admin";
include "partials/header.php";
?>

<div class="card" style="max-width:520px;margin:50px auto;">

    <h2>Login Admin</h2>

    <p class="muted">
        Silakan login untuk mengelola artikel.
    </p>

    <?php if(isset($_GET['err'])): ?>
        <div class="alert error">
            Username atau Password salah.
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Masukkan Username"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Masukkan Password"
            required
        >

        <button class="btn" type="submit">
            Login
        </button>

    </form>

    <p class="muted small" style="margin-top:20px;">
        Akun Default :
        <strong>admin</strong> /
        <strong>admin</strong>
    </p>

</div>

<?php
include "partials/footer.php";
?>