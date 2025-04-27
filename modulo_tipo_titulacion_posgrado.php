<?php
require "conexion.php";
$titulaciones = $conectar->query("SELECT * FROM tipo_titulacion_posgrado");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tipos de Titulación de Posgrado</title>
</head>
<body>
    <h2>Agregar nuevo tipo de titulación</h2>
    <form action="guardar_tipo_titulacion_posgrado.php" method="POST">
        <label>Nombre de la titulación:</label><br>
        <input type="text" name="nombre_titulacion_pos" required><br><br>
        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de tipos de titulación</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $titulaciones->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_tipo_titulacion_pos'] ?></td>
            <td><?= htmlspecialchars($row['nombre_titulacion_pos']) ?></td>
            <td>
                <a href="editar_tipo_titulacion_posgrado.php?id=<?= $row['id_tipo_titulacion_pos'] ?>">Editar</a> |
                <a href="eliminar_tipo_titulacion_posgrado.php?id=<?= $row['id_tipo_titulacion_pos'] ?>" onclick="return confirm('¿Deseas eliminar este tipo de titulación?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
