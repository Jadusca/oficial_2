<?php
require "conexion.php";

$id = intval($_POST['id']);
$nombre = $_POST['nombre_sabatico'];
$anio = !empty($_POST['anio_sabatico']) ? intval($_POST['anio_sabatico']) : null;

$stmt = $conectar->prepare("UPDATE sabaticos SET nombre_sabatico = ?, anio_sabatico = ? WHERE id_sabaticos = ?");
$stmt->bind_param("sii", $nombre, $anio, $id);
$stmt->execute();

header("Location: modulo_sabaticos.php");
