<?php
require "conexion.php";

$nombre_categoria = $_POST['nombre_categoria'] ?? null;
$sabaticos = $_POST['sabaticos'] ?? null;

if (!$nombre_categoria || !$sabaticos) {
    die("Faltan datos.");
}

$stmt = $conectar->prepare("INSERT INTO categoria_sabatico (nombre_categoria, sabaticos) VALUES (?, ?)");
$stmt->bind_param("si", $nombre_categoria, $sabaticos);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Categoría agregada correctamente'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
} else {
    echo "<script>alert('Hubo un error al guardar'); window.location.href = 'modulo_categoria_sabatico.php';</script>";
}
