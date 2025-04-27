<?php
require "conexion.php";
$posgrados = $conectar->query("SELECT * FROM posgrados");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Posgrados</title>
</head>
<body>
    <h2>Agregar nuevo posgrado</h2>
    <form action="guardar_posgrado.php" method="POST" enctype="multipart/form-data">
        <label>Nombre del posgrado:</label><br>
        <input type="text" name="nombre_posgrado" required><br><br>

        <label>Año del posgrado (opcional):</label><br>
        <input type="text" name="anio_posgrado"><br><br>

        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de posgrados</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $posgrados->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_posgrados'] ?></td>
            <td><?= htmlspecialchars($row['nombre_posgrado']) ?></td>
            <td><?= htmlspecialchars($row['anio_posgrado']) ?></td>
            <td>
                <a href="editar_posgrado.php?id=<?= $row['id_posgrados'] ?>">Editar</a> |
                <a href="eliminar_posgrado.php?id=<?= $row['id_posgrados'] ?>" onclick="return confirm('¿Estás seguro de eliminar este posgrado?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
