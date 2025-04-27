<?php
require "conexion.php";

$id = $_POST['id_periodo_carrera'];
$anio = $_POST['anio_periodo'];

$stmt = $conectar->prepare("UPDATE periodo_carrera SET anio_periodo = ? WHERE id_periodo_carrera = ?");
$stmt->bind_param("si", $anio, $id);
$stmt->execute();

header("Location: modulo_periodo_carrera.php");
