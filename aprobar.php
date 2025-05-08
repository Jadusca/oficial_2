<?php
require 'conexion.php';

if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = intval($_GET['id']);
    $tipo = $_GET['tipo'];

    switch ($tipo) {
        case 'lic':
            $tabla = 'ficha_carreras';
            $campo_id = 'id_ficha_carrera';
            break;
        case 'pos':
            $tabla = 'ficha_posgrados';
            $campo_id = 'id_ficha_posgrado';
            break;
        case 'sab':
            $tabla = 'ficha_sabaticos';
            $campo_id = 'id_ficha_sabatico';
            break;
        default:
            die('Tipo no válido');
    }

    // 2 = Aprobado
    $query = "UPDATE $tabla SET estado_revision = 2 WHERE $campo_id = $id";
    $resultado = $conectar->query($query);

    if ($resultado) {
        echo "Documento aprobado correctamente.";
    } else {
        echo "Error al aprobar el documento.";
    }
} else {
    echo "Parámetros no válidos.";
}
?>
<a href="modulo_revision_general.php">Regresar</a>
