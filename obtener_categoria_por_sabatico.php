<?php
require "conexion.php";

if (isset($_GET['sabatico_id'])) {
    $sabatico_id = intval($_GET['sabatico_id']);

    $sql = "SELECT id_categoria_sab, nombre_categoria
            FROM categoria_sabatico
            WHERE sabaticos = ?";

    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $sabatico_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $categorias = [];
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($categorias);
}
