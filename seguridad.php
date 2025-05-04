<?php
session_start();

// Evitar el caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['admin_id'])) {
    header("Location: iniciosesion.php");
    exit;
}

$nombreUsuario = $_SESSION['admin_usuario'];
?>
