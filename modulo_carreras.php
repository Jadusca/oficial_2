<?php
require "conexion.php";
$carreras = $conectar->query("SELECT * FROM carreras");
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Carreras</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #f2f2f2; }
        img { border: 1px solid #aaa; border-radius: 4px; }
        .mensaje { margin: 15px 0; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <h2>Agregar nueva carrera</h2>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje">
            <?php if ($_GET['mensaje'] === 'actualizado') echo "Carrera actualizada con éxito."; ?>
            <?php if ($_GET['mensaje'] === 'eliminado') echo "Carrera eliminada correctamente."; ?>
            <?php if ($_GET['mensaje'] === 'guardado') echo "Carrera guardada con éxito."; ?>
        </div>
    <?php endif; ?>

    <form action="guardar_carrera.php" method="POST" enctype="multipart/form-data">
        <label>Nombre de la carrera:</label><br>
        <input type="text" name="nombre_carrera" required><br><br>

        <label>Periodo de la carrera:</label><br>
        <select name="periodo_carrera" required>
            <option value="">Seleccione un periodo</option>
            <?php while ($p = $periodos->fetch_assoc()): ?>
                <option value="<?= $p['id_periodo_carrera'] ?>"><?= htmlspecialchars($p['anio_periodo']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Año de la carrera (opcional):</label><br>
        <input type="text" name="anio_carrera" pattern="\d{4}" title="Debe ser un año de 4 dígitos"><br><br>

        <label>Logo (imagen):</label><br>
        <input type="file" name="logo_carrera" accept="image/*"><br><br>

        <input type="submit" value="Guardar">
    </form>

    <h2>Lista de carreras</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Periodo</th>
            <th>Logo</th>
            <th>Acciones</th>
        </tr>
        <?php
        $carrerasFull = $conectar->query("SELECT c.*, p.anio_periodo FROM carreras c LEFT JOIN periodo_carrera p ON c.periodo_carrera = p.id_periodo_carrera");
        while ($row = $carrerasFull->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id_carreras'] ?></td>
            <td><?= htmlspecialchars($row['nombre_carrera']) ?></td>
            <td><?= htmlspecialchars($row['anio_carrera']) ?></td>
            <td><?= htmlspecialchars($row['anio_periodo'] ?? 'Sin asignar') ?></td>
            <td>
                <?php if (!empty($row['logo_carrera'])): ?>
                    <img src="logos/<?= htmlspecialchars($row['logo_carrera']) ?>" width="60">
                <?php else: ?>
                    <em>Sin logo</em>
                <?php endif; ?>
            </td>
            <td>
                <a href="editar_carrera.php?id=<?= $row['id_carreras'] ?>">Editar</a> |
                <a href="eliminar_carrera.php?id=<?= $row['id_carreras'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
