<?php
require "conexion.php";

$id = $_POST['id_tipo_titulacion_pos'];
$nombre = $_POST['nombre_titulacion_pos'];

$stmt = $conectar->prepare("UPDATE tipo_titulacion_posgrado SET nombre_titulacion_pos = ? WHERE id_tipo_titulacion_pos = ?");
$stmt->bind_param("si", $nombre, $id);
$stmt->execute();

header("Location: modulo_tipo_titulacion_posgrado.php");
