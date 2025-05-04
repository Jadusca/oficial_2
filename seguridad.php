<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['nombreUsuario'])) {
    header("Location: iniciosesion.php");
    exit;
}
$nombreUsuario = $_SESSION['nombreUsuario'];
?>
