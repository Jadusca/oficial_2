<?php
require "conexion.php";

$hoy = date("Y-m-d");
$sql = "INSERT INTO visitas (fecha, cantidad) VALUES (?, 1)
        ON DUPLICATE KEY UPDATE cantidad = cantidad + 1";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("s", $hoy);
$stmt->execute();
?>
