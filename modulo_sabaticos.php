<?php
require "conexion.php";

// Obtener sabáticos existentes
$result = $conectar->query("SELECT * FROM sabaticos");
?>

<h2>Agregar nuevo sabático</h2>
<form action="guardar_sabatico.php" method="POST">
    <label>Nombre del sabático:</label><br>
    <input type="text" name="nombre_sabatico" required><br><br>

    <label>Año del sabático (opcional):</label><br>
    <input type="number" name="anio_sabatico"><br><br>

    <input type="submit" value="Guardar">
</form>

<hr>

<h2>Lista de sabáticos</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Año</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nombre_sabatico']) ?></td>
            <td><?= htmlspecialchars($row['anio_sabatico']) ?></td>
            <td>
                <a href="editar_sabatico.php?id=<?= $row['id_sabaticos'] ?>">Editar</a> |
                <a href="eliminar_sabatico.php?id=<?= $row['id_sabaticos'] ?>" onclick="return confirm('¿Estás seguro de eliminar este sabático?')">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
