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
    <title>Editar Documento</title>
</head>
<body>

<h2>Editar Documento</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($row['titulo']) ?>" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" value="<?= htmlspecialchars($row['autor']) ?>" required><br><br>

    <label>Documento actual:</label><br>
    <a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank"><?= $row['documento'] ?></a><br>
    <label>Nuevo Documento (PDF):</label><br>
    <input type="file" name="documento" accept="application/pdf"><br><br>

    <label>Oficio actual:</label><br>
    <?php if ($row['oficio']): ?>
        <a href="ver_oficio.php?archivo=<?= $row['oficio'] ?>" target="_blank"><?= $row['oficio'] ?></a><br>
    <?php else: ?>
        No disponible<br>
    <?php endif; ?>
    <label>Nuevo Oficio (PDF):</label><br>
    <input type="file" name="oficio" accept="application/pdf"><br><br>

    <?php if ($row['estado_revision'] == 3): ?>
    <label><input type="checkbox" name="aprobar_nuevamente" value="1"> Aprobar nuevamente este documento</label><br><br>
    <?php endif; ?>

    <button type="submit">Guardar cambios</button>
</form>

</body>
</html>