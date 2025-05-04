<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['nombreUsuario'])) {
  header("Location: iniciosesion.php");
  exit;
}
?>
