<?php
require "conexion.php";

$nombre = $_POST['nombre_posgrado'];
$anio = $_POST['anio_posgrado'] ?? null;

$sql = "INSERT INTO posgrados (nombre_posgrado, anio_posgrado)
        VALUES (?, ?)";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("sss", $nombre, $anio);
$stmt->execute();

header("Location: modulo_posgrados.php");
