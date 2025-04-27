<?php
require "conexion.php";

// Obtener todas las categorías
$categorias = $conectar->query("SELECT * FROM categoria_sabatico");

// Obtener todos los sabáticos para el <select>
$sabaticos = $conectar->query("SELECT * FROM sabaticos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías de Sabáticos</title>
</head>
<body>
    <h2>Agregar nueva categoría de sabático</h2>
    <form action="guardar_categoria_sabatico.php" method="POST">
        <label>Nombre de la categoría:</label><br>
        <input type="text" name="nombre_categoria" required><br><br>

        <label>Sabático:</label><br>
        <select name="sabaticos" required>
            <option value="">Selecciona un sabático</option>
            <?php while ($sab = $sabaticos->fetch_assoc()): ?>
                <option value="<?= $sab['id_sabaticos'] ?>">
                    <?= htmlspecialchars($sab['nombre_sabatico']) ?> (<?= htmlspecialchars($sab['anio_sabatico']) ?>)
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de categorías</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Categoría</th>
            <th>Sabático</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Traer sabáticos junto con las categorías (JOIN)
        $categoriasConSabaticos = $conectar->query("
            SELECT cs.*, s.nombre_sabatico, s.anio_sabatico
            FROM categoria_sabatico cs
            LEFT JOIN sabaticos s ON cs.sabaticos = s.id_sabaticos
        ");
        while ($row = $categoriasConSabaticos->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id_categoria_sab'] ?></td>
            <td><?= htmlspecialchars($row['nombre_categoria']) ?></td>
            <td><?= htmlspecialchars($row['nombre_sabatico']) ?> (<?= htmlspecialchars($row['anio_sabatico']) ?>)</td>
            <td>
                <a href="editar_categoria_sabatico.php?id=<?= $row['id_categoria_sab'] ?>">Editar</a> |
                <a href="eliminar_categoria_sabatico.php?id=<?= $row['id_categoria_sab'] ?>"
                onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
