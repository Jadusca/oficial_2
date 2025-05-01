<?php
require "conexion.php";
require "correo.php";

// Validar y guardar archivo PDF del documento
$archivo = $_FILES['documento'];
$nombrePDF = time() . "_" . $archivo['name'];
$rutaPDF = "documentos/" . $nombrePDF;
move_uploaded_file($archivo['tmp_name'], $rutaPDF);

// Guardar el oficio PDF
$oficioArchivo = $_FILES['oficio'];
$nombreOficio = time() . "_oficio_" . $oficioArchivo['name'];
$rutaOficio = "oficios/" . $nombreOficio;
move_uploaded_file($oficioArchivo['tmp_name'], $rutaOficio);

// Obtener el ID del estado "Pendiente"
$estado_resultado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Pendiente' LIMIT 1");
$estado_id = $estado_resultado->fetch_assoc()['id_estado'];

// Obtener fecha proporcionada por el usuario
$fecha_usuario = $_POST['fecha']; // formato: YYYY-MM-DD

// Preparar e insertar en la tabla ficha_posgrados
$stmt = $conectar->prepare("INSERT INTO ficha_posgrados (
    posgrados, tipo_titulacion_posgrado, titulo, autor, asesor_interno,
    asesor_externo, resumen, fecha, palabras_clave, documento,
    oficio, paginas, dimensiones, estado_revision
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iisssssssssssi",
    $_POST['posgrado_id'],
    $_POST['tipo_titulacion_id'],
    $_POST['titulo'],
    $_POST['autor'],
    $_POST['asesor_interno'],
    $_POST['asesor_externo'],
    $_POST['resumen'],
    $fecha_usuario,
    $_POST['palabras_clave'],
    $rutaPDF,
    $rutaOficio,
    $_POST['paginas'],
    $_POST['dimensiones'],
    $estado_id
);

if ($stmt->execute()) {
    // Obtener los correos de los superadministradores
    $resultado = $conectar->query("SELECT email FROM super_administradores");
    $correos = [];

    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row['email'];
    }

    // Armar el mensaje
    $asunto = "Nuevo documento de posgrado para revisar";
    $mensaje = "Se ha subido un nuevo documento de posgrado:\n\n";
    $mensaje .= "Título: " . $_POST['titulo'] . "\n";
    $mensaje .= "Autor: " . $_POST['autor'] . "\n";
    $mensaje .= "Fecha: " . $fecha_usuario . "\n\n";
    $mensaje .= "Por favor revisa el documento en el sistema.\n";

    // Enviar correo
    $resultadoCorreo = enviarCorreo($correos, $asunto, $mensaje);

    if ($resultadoCorreo === true) {
        echo "<script>
            alert('Ficha de posgrado registrada correctamente. El superadministrador ha sido notificado.');
            window.location.href = 'formulario_ficha_posgrado_admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Ficha registrada, pero hubo un problema al enviar el correo: " . addslashes($resultadoCorreo) . "');
            window.location.href = 'formulario_ficha_posgrado_admin.php';
        </script>";
    }
}
?>
