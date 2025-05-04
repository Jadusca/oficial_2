<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: iniciosesion.php");
    exit;
}

$nombreUsuario = $_SESSION['admin_usuario'];
?>
