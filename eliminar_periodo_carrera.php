<?php
require "conexion.php";

$id = intval($_GET['id']);
$stmt = $conectar->prepare("DELETE FROM periodo_carrera WHERE id_periodo_carrera = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: modulo_periodo_carrera.php");
