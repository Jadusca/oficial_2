<link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">

<?php
require 'conexion.php';

if (!isset($_GET['id'])) {
    die("ID de documento no especificado.");
}

$id = (int) $_GET['id'];
$sql = "SELECT * FROM ficha_sabaticos WHERE id_ficha_sabatico = $id";
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
    $update_sql = "UPDATE ficha_sabaticos SET
        titulo = '$titulo',
        autor = '$autor',
        documento = '$nombre_documento',
        oficio = '$nombre_oficio',
        estado_revision = $estado_revision
        WHERE id_ficha_sabatico = $id";

    if ($conectar->query($update_sql)) {
        echo "<script>alert('Documento actualizado correctamente'); window.location.href = 'documentos_revisados.php';</script>";
        exit;
    } else {
        echo "Error al actualizar: " . $conectar->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar documento sabático</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="documentos_revisados.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar documento de sabático</h2>
    </div>
    <form class="nuevas_carreras" method="POST" enctype="multipart/form-data">
        <section>
            <label>Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($ficha['titulo']) ?>" required>
        </section><br><br>

        <section>
            <label>Autor:</label>
            <input type="text" name="autor" value="<?= htmlspecialchars($ficha['autor']) ?>" required>
        </section><br><br>

        <section class="image_movil">
            <label>Documento PDF:</label>
            <input class="image" type="file" name="documento" accept="application/pdf">
        </section><br><br>
        <?php if ($ficha['documento']): ?>
            <section class="image_movil">
                <label>Documento actual:</label>
                <div class="tabla-responsive">
                    <a href="ver_documento.php?archivo=<?= $ficha['documento'] ?>"
                        target="_blank"><?= $ficha['documento'] ?></a>
                </div>
            </section><br><br>
        <?php endif; ?>

        <section class="image_movil">
            <label>Oficio PDF:</label>
            <input class="image" type="file" name="oficio" accept="application/pdf">
        </section><br><br>
        <?php if ($ficha['oficio']): ?>
            <section class="image_movil">
                <label>Oficio actual:</label>
                <div class="tabla-responsive">
                    <a href="ver_oficio.php?archivo=<?= $ficha['oficio'] ?>" target="_blank"><?= $ficha['oficio'] ?></a>
                </div>
            </section><br><br>
        <?php endif; ?>

        <?php if ($ficha['estado_revision'] == 3): // 3 = Rechazado ?>
            <label>
                <input type="checkbox" name="aprobar_rechazado"> Aprobar este documento
            </label><br>
        <?php endif; ?>

        <button class="mod_car" type="submit">Guardar cambios</button>
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="./funciones.js"></script>

</body>

</html>