<?php
require "conexion.php";

if (isset($_GET['periodo_id'])) {
    $periodo_id = intval($_GET['periodo_id']);

    $sql = "SELECT id_carreras, nombre_carrera
            FROM carreras
            WHERE periodo_carrera = ?";

    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $periodo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $carreras = [];
    while ($row = $result->fetch_assoc()) {
        $carreras[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($carreras);
}
