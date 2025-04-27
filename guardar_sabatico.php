<?php
require "conexion.php";

$nombre = $_POST['nombre_sabatico'];
$anio = !empty($_POST['anio_sabatico']) ? intval($_POST['anio_sabatico']) : null;

$stmt = $conectar->prepare("INSERT INTO sabaticos (nombre_sabatico, anio_sabatico) VALUES (?, ?)");
$stmt->bind_param("si", $nombre, $anio);
$stmt->execute();

header("Location: modulo_sabaticos.php");
