<?php
require "conexion.php";

// Validar y obtener datos del formulario
$id = $_POST['id_categoria_sab'] ?? null;
$nombre_categoria = $_POST['nombre_categoria'] ?? null;
$sabaticos = $_POST['sabaticos'] ?? null;

if (!$id || !$nombre_categoria || !$sabaticos) {
    die("Datos incompletos.");
}

// Preparar y ejecutar la actualización
$stmt = $conectar->prepare("UPDATE categoria_sabatico SET nombre_categoria = ?, sabaticos = ? WHERE id_categoria_sab = ?");
$stmt->bind_param("sii", $nombre_categoria, $sabaticos, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Categoría actualizada correctamente'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
} else {
    echo "<script>alert('No se realizaron cambios o hubo un error.'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
}
