<?php
require "conexion.php";

$id = $_POST['id_carreras'];
$nombre = $_POST['nombre_carrera'];
$anio = $_POST['anio_carrera'] ?? null;
$periodo = $_POST['periodo_carrera'];
$logoActual = $_POST['logo_actual'] ?? null;

$logoNuevo = $logoActual;

// Subir nuevo logo si se seleccionó uno
if (!empty($_FILES['logo_carrera']['name'])) {
    $logoNuevo = uniqid() . "_" . basename($_FILES["logo_carrera"]["name"]);
    $ruta = "logos/" . $logoNuevo;
    move_uploaded_file($_FILES["logo_carrera"]["tmp_name"], $ruta);

    // Eliminar logo anterior si existe
    if ($logoActual && file_exists("logos/" . $logoActual)) {
        unlink("logos/" . $logoActual);
    }
}

$sql = "UPDATE carreras
        SET nombre_carrera = ?, anio_carrera = ?, periodo_carrera = ?, logo_carrera = ?
        WHERE id_carreras = ?";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("ssisi", $nombre, $anio, $periodo, $logoNuevo, $id);
$stmt->execute();

header("Location: modulo_carreras.php?mensaje=actualizado");
