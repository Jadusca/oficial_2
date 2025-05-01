<?php
require "conexion.php";
require "correo.php";

// Validar y guardar archivo PDF del documento
$archivo = $_FILES['documento'];
$nombrePDF = time() . "_" . $archivo['name'];
$rutaPDF = "documentos/" . $nombrePDF;
move_uploaded_file($archivo['tmp_name'], $rutaPDF);

// Validar y guardar archivo PDF del oficio
$oficioArchivo = $_FILES['oficio'];
$nombreOficio = time() . "_oficio_" . $oficioArchivo['name'];
$rutaOficio = "oficios/" . $nombreOficio;
move_uploaded_file($oficioArchivo['tmp_name'], $rutaOficio);

// Obtener el ID del estado "Pendiente"
$estado_resultado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Pendiente' LIMIT 1");
$estado_id = $estado_resultado->fetch_assoc()['id_estado'];

// Obtener la fecha del formulario y validarla (formato YYYY-MM-DD)
$fecha = $_POST['fecha'];
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
    die("La fecha ingresada no es válida.");
}

// Preparar e insertar en la tabla ficha_sabaticos
$stmt = $conectar->prepare("INSERT INTO ficha_sabaticos (
    sabaticos, categoria_sabatico, titulo, autor, resumen,
    fecha, palabras_clave, documento, paginas, dimensiones,
    estado_revision, oficio
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iissssssssis",
    $_POST['sabatico_id'],
    $_POST['categoria_id'],
    $_POST['titulo'],
    $_POST['autor'],
    $_POST['resumen'],
    $fecha,
    $_POST['palabras_clave'],
    $rutaPDF,
    $_POST['paginas'],
    $_POST['dimensiones'],
    $estado_id,
    $rutaOficio
);

if ($stmt->execute()) {
    // Obtener los correos de los superadministradores
    $resultado = $conectar->query("SELECT email FROM super_administradores");
    $correos = [];

    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row['email'];
    }

    // Armar el mensaje
    $asunto = "Nuevo documento sabático para revisar";
    $mensaje = "Se ha subido un nuevo documento de sabáticos:\n\n";
    $mensaje .= "Título: " . $_POST['titulo'] . "\n";
    $mensaje .= "Autor: " . $_POST['autor'] . "\n";
    $mensaje .= "Fecha: " . $fecha . "\n\n";
    $mensaje .= "Por favor revisa el documento en el sistema.\n";

    // Enviar correo
    $resultadoCorreo = enviarCorreo($correos, $asunto, $mensaje);

    if ($resultadoCorreo === true) {
        echo "<script>
            alert('Ficha sabática registrada correctamente. El superadministrador ha sido notificado.');
            window.location.href = 'formulario_ficha_sabatico_admin.php';
        </script>";
    } else {
        echo "<script>
            alert('Ficha registrada, pero hubo un problema al enviar el correo: " . addslashes($resultadoCorreo) . "');
            window.location.href = 'formulario_ficha_sabatico_admin.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Error al registrar el documento sabático.');
        window.location.href = 'formulario_ficha_sabatico_admin.php';
    </script>";
}
