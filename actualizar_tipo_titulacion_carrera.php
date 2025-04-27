<?php
require "conexion.php";

$id = $_POST['id_tipo_titulacion'];
$nombre = $_POST['nombre_titulacion'];
$descripcion = $_POST['descripcion_titulacion'];
$periodo = $_POST['periodo_carrera'];

$sql = "UPDATE tipo_titulacion_carrera SET nombre_titulacion = ?, descripcion_titulacion = ?, periodo_carrera = ? WHERE id_tipo_titulacion = ?";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("ssii", $nombre, $descripcion, $periodo, $id);
$stmt->execute();

header("Location: modulo_tipo_titulacion_carrera.php");
