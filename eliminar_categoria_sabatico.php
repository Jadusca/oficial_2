<?php
require "conexion.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID no proporcionado.");
}

$stmt = $conectar->prepare("DELETE FROM categoria_sabatico WHERE id_categoria_sab = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Categoría eliminada correctamente'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
} else {
    echo "<script>alert('No se encontró o no se pudo eliminar la categoría'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
}
