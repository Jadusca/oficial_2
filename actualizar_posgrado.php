<?php
require "conexion.php";

$id = $_POST['id_posgrados'];
$nombre = $_POST['nombre_posgrado'];
$anio = $_POST['anio_posgrado'] ?? null;


$sql = "UPDATE posgrados
        SET nombre_posgrado = ?, anio_posgrado = ?
        WHERE id_posgrados = ?";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("sssi", $nombre, $anio, $id);
$stmt->execute();

header("Location: modulo_posgrados.php");
