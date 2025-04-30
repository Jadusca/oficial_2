<?php
require "conexion.php";

$sql = "SELECT SUM(cantidad) AS total FROM visitas";
$resultado = $conectar->query($sql);
$fila = $resultado->fetch_assoc();
$total_visitas = $fila['total'] ?? 0;

echo "👣 Visitas totales: " . number_format($total_visitas);
?>
