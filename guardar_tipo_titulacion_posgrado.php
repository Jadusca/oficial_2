<?php
require "conexion.php";

$nombre = $_POST['nombre_titulacion_pos'] ?? '';

if ($nombre !== '') {
    $stmt = $conectar->prepare("INSERT INTO tipo_titulacion_posgrado (nombre_titulacion_pos) VALUES (?)");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
}

header("Location: modulo_tipo_titulacion_posgrado.php");
