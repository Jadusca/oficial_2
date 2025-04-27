<?php
require "conexion.php";
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Periodos de Carrera</title>
</head>
<body>
    <h2>Agregar nuevo periodo</h2>
    <form action="guardar_periodo_carrera.php" method="POST">
        <label>Año del periodo:</label><br>
        <input type="text" name="anio_periodo" required><br><br>
        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de periodos</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Periodos</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $periodos->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_periodo_carrera'] ?></td>
            <td><?= htmlspecialchars($row['anio_periodo']) ?></td>
            <td>
                <a href="editar_periodo_carrera.php?id=<?= $row['id_periodo_carrera'] ?>">Editar</a> |
                <a href="eliminar_periodo_carrera.php?id=<?= $row['id_periodo_carrera'] ?>" onclick="return confirm('¿Estás seguro de eliminar este periodo?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
