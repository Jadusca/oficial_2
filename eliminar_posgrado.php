<?php
require "conexion.php";

$id = intval($_GET['id']);

$eliminar = $conectar->prepare("DELETE FROM posgrados WHERE id_posgrados = ?");
$eliminar->bind_param("i", $id);
$eliminar->execute();

header("Location: modulo_posgrados.php");
