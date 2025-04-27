<?php
require "conexion.php";

$id = intval($_GET['id']);
$titulacion = $conectar->query("SELECT * FROM tipo_titulacion_carrera WHERE id_tipo_titulacion = $id")->fetch_assoc();
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Titulación</title>
</head>
<body>
    <h2>Editar tipo de titulación</h2>
    <form action="actualizar_tipo_titulacion_carrera.php" method="POST">
        <input type="hidden" name="id_tipo_titulacion" value="<?= $titulacion['id_tipo_titulacion'] ?>">

        <label>Nombre de la titulación:</label><br>
        <input type="text" name="nombre_titulacion" value="<?= htmlspecialchars($titulacion['nombre_titulacion']) ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion_titulacion" rows="4" cols="50"><?= htmlspecialchars($titulacion['descripcion_titulacion']) ?></textarea><br><br>

        <label>Periodo:</label><br>
        <select name="periodo_carrera" required>
            <option value="">Selecciona un periodo</option>
            <?php while ($p = $periodos->fetch_assoc()): ?>
                <option value="<?= $p['id_periodo_carrera'] ?>"
                    <?= $p['id_periodo_carrera'] == $titulacion['periodo_carrera'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['anio_periodo']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
