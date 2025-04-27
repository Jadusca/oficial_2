<?php
require "conexion.php";

$id = intval($_GET['id']);
$eliminar = $conectar->prepare("DELETE FROM tipo_titulacion_carrera WHERE id_tipo_titulacion = ?");
$eliminar->bind_param("i", $id);
$eliminar->execute();

header("Location: modulo_tipo_titulacion_carrera.php");
