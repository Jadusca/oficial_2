<?php
require "conexion.php";

$id = $_GET['id'];
$stmt = $conectar->prepare("SELECT * FROM tipo_titulacion_posgrado WHERE id_tipo_titulacion_pos = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$titulacion = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tipo de Titulación</title>
</head>
<body>
    <h2>Editar tipo de titulación</h2>
    <form action="actualizar_tipo_titulacion_posgrado.php" method="POST">
        <input type="hidden" name="id_tipo_titulacion_pos" value="<?= $titulacion['id_tipo_titulacion_pos'] ?>">

        <label>Nombre de la titulación:</label><br>
        <input type="text" name="nombre_titulacion_pos" value="<?= htmlspecialchars($titulacion['nombre_titulacion_pos']) ?>" required><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
