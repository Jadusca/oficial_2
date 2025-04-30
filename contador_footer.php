<?php
require "conexion.php";

$sql = "SELECT SUM(cantidad) AS total FROM visitas";
$resultado = $conectar->query($sql);
$fila = $resultado->fetch_assoc();
$total_visitas = $fila['total'] ?? 0;

echo "<i class='fa-solid fa-users'></i> Visitas totales: " . number_format($total_visitas);
?>
