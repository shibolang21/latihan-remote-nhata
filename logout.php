<?php
// logout.php - proses logout
session_start();
session_destroy();
header("Location: index.php?msg=logout_ok");
exit;
