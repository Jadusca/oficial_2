<?php
require "conexion.php";

$nombre = $_POST['nombre_titulacion'];
$descripcion = $_POST['descripcion_titulacion'];
$periodo = $_POST['periodo_carrera'];

$sql = "INSERT INTO tipo_titulacion_carrera (nombre_titulacion, descripcion_titulacion, periodo_carrera) VALUES (?, ?, ?)";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("ssi", $nombre, $descripcion, $periodo);
$stmt->execute();

header("Location: modulo_tipo_titulacion_carrera.php");
