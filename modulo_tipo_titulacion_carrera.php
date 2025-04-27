<?php
require "conexion.php";
$titulaciones = $conectar->query("SELECT t.id_tipo_titulacion, t.nombre_titulacion, t.descripcion_titulacion, p.anio_periodo
                                FROM tipo_titulacion_carrera t
                                JOIN periodo_carrera p ON t.periodo_carrera = p.id_periodo_carrera");
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tipo de Titulación (Carrera)</title>
</head>
<body>
    <h2>Agregar nueva titulación</h2>
    <form action="guardar_tipo_titulacion_carrera.php" method="POST">
        <label>Nombre de la titulación:</label><br>
        <input type="text" name="nombre_titulacion" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion_titulacion" rows="4" cols="50">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</textarea><br><br>

        <label>Periodo:</label><br>
        <select name="periodo_carrera" required>
            <option value="">Selecciona un periodo</option>
            <?php while ($p = $periodos->fetch_assoc()): ?>
                <option value="<?= $p['id_periodo_carrera'] ?>"><?= htmlspecialchars($p['anio_periodo']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de titulaciones</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Periodo</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $titulaciones->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_tipo_titulacion'] ?></td>
            <td><?= htmlspecialchars($row['nombre_titulacion']) ?></td>
            <td><?= htmlspecialchars($row['descripcion_titulacion']) ?></td>
            <td><?= htmlspecialchars($row['anio_periodo']) ?></td>
            <td>
                <a href="editar_tipo_titulacion_carrera.php?id=<?= $row['id_tipo_titulacion'] ?>">Editar</a> |
                <a href="eliminar_tipo_titulacion_carrera.php?id=<?= $row['id_tipo_titulacion'] ?>"
                onclick="return confirm('¿Deseas eliminar esta titulación?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
