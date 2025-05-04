<?php
session_start();

if (!isset($_SESSION['superadmin_id'])) {
    header("Location: iniciosesionSuperAdmin.php");
    exit;
}

$nombreUsuario = $_SESSION['superadmin_usuario'];
?>
