<?php
require 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID de documento no especificado.");
}

$id = (int) $_GET['id'];
$sql = "SELECT * FROM ficha_posgrados WHERE id_ficha_posgrado = $id";
$res = $conectar->query($sql);

if (!$res || $res->num_rows === 0) {
    die("Documento no encontrado.");
}

$ficha = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $conectar->real_escape_string($_POST['titulo']);
    $autor = $conectar->real_escape_string($_POST['autor']);
    $estado_revision = isset($_POST['aprobar_rechazado']) ? 2 : $ficha['estado_revision']; // 2 = Aprobado

    $documento_actual = $ficha['documento'];
    $oficio_actual = $ficha['oficio'];

    // Manejo de documento PDF
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['documento']['type'] === 'application/pdf') {
            if ($documento_actual && file_exists("documentos/" . $documento_actual)) {
                unlink("documentos/" . $documento_actual);
            }
            $nombre_documento = uniqid('doc_') . ".pdf";
            $destino_documento = "documentos/" . $nombre_documento;
            move_uploaded_file($_FILES['documento']['tmp_name'], $destino_documento);
        } else {
            die("El documento debe ser un archivo PDF.");
        }
    } else {
        $nombre_documento = $documento_actual;
    }

    // Manejo de oficio PDF
    if (isset($_FILES['oficio']) && $_FILES['oficio']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['oficio']['type'] === 'application/pdf') {
            if ($oficio_actual && file_exists("oficios/" . $oficio_actual)) {
                unlink("oficios/" . $oficio_actual);
            }
            $nombre_oficio = uniqid('ofc_') . ".pdf";
            $destino_oficio = "oficios/" . $nombre_oficio;
            move_uploaded_file($_FILES['oficio']['tmp_name'], $destino_oficio);
        } else {
            die("El oficio debe ser un archivo PDF.");
        }
    } else {
        $nombre_oficio = $oficio_actual;
    }

    // Actualizar en la base de datos
    $update_sql = "UPDATE ficha_posgrados SET
        titulo = '$titulo',
        autor = '$autor',
        documento = '$nombre_documento',
        oficio = '$nombre_oficio',
        estado_revision = $estado_revision
        WHERE id_ficha_posgrado = $id";

    if ($conectar->query($update_sql)) {
        echo "<script>alert('Documento actualizado correctamente'); window.location.href = 'documentos_revisados.php';</script>";
        exit;
    } else {
        echo "Error al actualizar: " . $conectar->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>

<h2>Editar documento de posgrado</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?= htmlspecialchars($ficha['titulo']) ?>" required><br>

    <label>Autor:</label>
    <input type="text" name="autor" value="<?= htmlspecialchars($ficha['autor']) ?>" required><br>

    <label>Documento PDF:</label>
    <input type="file" name="documento" accept="application/pdf"><br>
    <?php if (!empty($ficha['documento'])): ?>
        <p>Documento actual:
            <a href="ver_documento.php?archivo=<?= $ficha['documento'] ?>" target="_blank">
                <?= $ficha['documento'] ?>
            </a>
        </p>
    <?php endif; ?>

    <label>Oficio PDF:</label>
    <input type="file" name="oficio" accept="application/pdf"><br>
    <?php if (!empty($ficha['oficio'])): ?>
        <p>Oficio actual:
            <a href="ver_oficio.php?archivo=<?= $ficha['oficio'] ?>" target="_blank">
                <?= $ficha['oficio'] ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if ($ficha['estado_revision'] == 3): ?>
        <label>
            <input type="checkbox" name="aprobar_rechazado"> Aprobar este documento
        </label><br>
    <?php endif; ?>

    <button type="submit">Guardar cambios</button>
</form>
</body>
</html>