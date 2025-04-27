<?php
require "conexion.php";

$id = intval($_GET['id']);
$resultado = $conectar->query("SELECT * FROM posgrados WHERE id_posgrados = $id");
$posgrado = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Posgrado</title>
</head>
<body>
    <h2>Editar posgrado</h2>
    <form action="actualizar_posgrado.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_posgrados" value="<?= $posgrado['id_posgrados'] ?>">

        <label>Nombre del posgrado:</label><br>
        <input type="text" name="nombre_posgrado" value="<?= htmlspecialchars($posgrado['nombre_posgrado']) ?>" required><br><br>

        <label>Año del posgrado:</label><br>
        <input type="text" name="anio_posgrado" value="<?= htmlspecialchars($posgrado['anio_posgrado']) ?>"><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
