
<?php
require "conexion.php";

$nombre = $_POST['nombre_carrera'];
$anio = $_POST['anio_carrera'] ?? null;
$periodo = $_POST['periodo_carrera'];

$logo = null;

if (!empty($_FILES['logo_carrera']['name'])) {
    $logo = uniqid() . "_" . basename($_FILES["logo_carrera"]["name"]);
    $ruta = "logos/" . $logo;
    move_uploaded_file($_FILES["logo_carrera"]["tmp_name"], $ruta);
}

$sql = "INSERT INTO carreras (nombre_carrera, anio_carrera, periodo_carrera, logo_carrera)
        VALUES (?, ?, ?, ?)";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("ssis", $nombre, $anio, $periodo, $logo);
$stmt->execute();

header("Location: modulo_carreras.php?mensaje=guardado");
