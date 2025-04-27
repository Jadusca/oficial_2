<?php
require "conexion.php";

$anio = $_POST['anio_periodo'] ?? '';

if ($anio !== '') {
    $stmt = $conectar->prepare("INSERT INTO periodo_carrera (anio_periodo) VALUES (?)");
    $stmt->bind_param("s", $anio);
    $stmt->execute();
}

header("Location: modulo_periodo_carrera.php");
