<?php
if (isset($_GET['archivo'])) {
    $archivo = basename($_GET['archivo']); // Evita rutas externas o maliciosas
    $ruta = "documentos/" . $archivo;

    if (file_exists($ruta)) {
        // Forzar el navegador a mostrar el PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $archivo . '"');
        readfile($ruta);
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "Archivo no especificado.";
}
?>
