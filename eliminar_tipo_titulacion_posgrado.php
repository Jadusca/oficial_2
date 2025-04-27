<?php
require "conexion.php";

$id = intval($_GET['id']);
$stmt = $conectar->prepare("DELETE FROM tipo_titulacion_posgrado WHERE id_tipo_titulacion_pos = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: modulo_tipo_titulacion_posgrado.php");
