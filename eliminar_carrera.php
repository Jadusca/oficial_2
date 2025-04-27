<?php
require "conexion.php";

$id = intval($_GET['id']);

// Obtener el nombre del logo antes de borrar
$stmt = $conectar->prepare("SELECT logo_carrera FROM carreras WHERE id_carreras = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

// Eliminar logo si existe
if ($datos && !empty($datos['logo_carrera']) && file_exists("logos/" . $datos['logo_carrera'])) {
    unlink("logos/" . $datos['logo_carrera']);
}

// Borrar carrera
$eliminar = $conectar->prepare("DELETE FROM carreras WHERE id_carreras = ?");
$eliminar->bind_param("i", $id);
$eliminar->execute();

header("Location: modulo_carreras.php?mensaje=eliminado");
