<?php
require "conexion.php";

if (isset($_GET['periodo_id'])) {
    $periodo_id = intval($_GET['periodo_id']);

    $sql = "SELECT id_tipo_titulacion, nombre_titulacion
            FROM tipo_titulacion_carrera
            WHERE periodo_carrera = ?";

    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $periodo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $titulaciones = [];
    while ($row = $result->fetch_assoc()) {
        $titulaciones[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($titulaciones);
}
