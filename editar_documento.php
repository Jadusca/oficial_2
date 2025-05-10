<link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">

<?php
require 'conexion.php';

if (!isset($_GET['id'])) {
    die('ID no proporcionado.');
}

$id = (int) $_GET['id'];

// Obtener datos actuales
$sql = "SELECT * FROM ficha_carreras WHERE id_ficha_carrera = $id";
$res = $conectar->query($sql);

if (!$res || $res->num_rows === 0) {
    die("Documento no encontrado.");
}

$row = $res->fetch_assoc();

// Guardar cambios si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $conectar->real_escape_string($_POST['titulo']);
    $autor = $conectar->real_escape_string($_POST['autor']);

    $sqlUpdate = "UPDATE ficha_carreras SET titulo = '$titulo', autor = '$autor'";

    if (!empty($_FILES['documento']['name'])) {
        $nombreDoc = basename($_FILES['documento']['name']);
        $rutaDoc = 'documentos/' . $nombreDoc;
        move_uploaded_file($_FILES['documento']['tmp_name'], $rutaDoc);
        $sqlUpdate .= ", documento = '$nombreDoc'";
    }

    if (!empty($_FILES['oficio']['name'])) {
        $nombreOficio = basename($_FILES['oficio']['name']);
        $rutaOficio = 'oficios/' . $nombreOficio;
        move_uploaded_file($_FILES['oficio']['tmp_name'], $rutaOficio);
        $sqlUpdate .= ", oficio = '$nombreOficio'";
    }

    //cambia a aprobado si fue rechazado y se marcó la casilla
    if (isset($_POST['aprobar_nuevamente']) && $row['estado_revision'] == 3) {
        $sqlUpdate .= ", estado_revision = 2";
    }

    $sqlUpdate .= " WHERE id_ficha_carrera = $id";

    if ($conectar->query($sqlUpdate)) {
        echo "<script>alert('Documento actualizado correctamente'); window.location.href='documentos_revisados.php';</script>";
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
    <title>Editar Documento Lic</title>
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
        <h2 class="tit_mod_car">Editar Documento</h2>
    </div>

    <form class="nuevas_carreras" method="POST" enctype="multipart/form-data">
        <section>
            <label>Título:</label><br>
            <input type="text" name="titulo" value="<?= htmlspecialchars($row['titulo']) ?>" required>
        </section><br><br>

        <section>
            <label>Autor:</label><br>
            <input type="text" name="autor" value="<?= htmlspecialchars($row['autor']) ?>" required>
        </section><br><br>

        <section class="image_movil">
            <label>Documento actual:</label><br>
            <a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank"><?= $row['documento'] ?></a>
        </section><br><br>
        <section class="image_movil">
            <label>Nuevo Documento (PDF):</label><br>
            <input class="image" type="file" name="documento" accept="application/pdf">
        </section><br><br>

        <section class="image_movil">
            <label>Oficio actual:</label><br>
            <?php if ($row['oficio']): ?>
                <a href="ver_oficio.php?archivo=<?= $row['oficio'] ?>" target="_blank"><?= $row['oficio'] ?></a><br>
            <?php else: ?>
                No disponible<br>
            <?php endif; ?>
        </section><br><br>
        <section class="image_movil">
            <label>Nuevo Oficio (PDF):</label><br>
            <input class="image" type="file" name="oficio" accept="application/pdf">
        </section><br><br>

        <?php if ($row['estado_revision'] == 3): ?>
            <label><input type="checkbox" name="aprobar_nuevamente" value="1"> Aprobar nuevamente este
                documento</label><br><br>
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