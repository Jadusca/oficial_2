<?php
require "conexion.php";

$id = intval($_GET['id']);
$carrera = $conectar->prepare("SELECT * FROM carreras WHERE id_carreras = ?");
$carrera->bind_param("i", $id);
$carrera->execute();
$resultado = $carrera->get_result();
$datos = $resultado->fetch_assoc();

$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Carrera</title>
</head>
<body>

    <h2>Editar carrera</h2>

    <form action="actualizar_carrera.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_carreras" value="<?= $datos['id_carreras'] ?>">

        <label>Nombre de la carrera:</label><br>
        <input type="text" name="nombre_carrera" value="<?= htmlspecialchars($datos['nombre_carrera']) ?>" required><br><br>

        <label>Periodo de la carrera:</label><br>
        <select name="periodo_carrera" required>
            <option value="">Seleccione un periodo</option>
            <?php while ($p = $periodos->fetch_assoc()): ?>
                <option value="<?= $p['id_periodo_carrera'] ?>" <?= $p['id_periodo_carrera'] == $datos['periodo_carrera'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['anio_periodo']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Año de la carrera (opcional):</label><br>
        <input type="text" name="anio_carrera" value="<?= htmlspecialchars($datos['anio_carrera']) ?>"><br><br>

        <label>Logo actual:</label><br>
        <?php if (!empty($datos['logo_carrera'])): ?>
            <img src="logos/<?= htmlspecialchars($datos['logo_carrera']) ?>" width="80"><br>
        <?php else: ?>
            <em>No hay logo cargado</em><br>
        <?php endif; ?>

        <label>Nuevo logo (opcional):</label><br>
        <input type="file" name="logo_carrera" accept="image/*"><br><br>

        <input type="submit" value="Actualizar">
    </form>

    <p><a href="modulo_carreras.php">← Volver a la lista</a></p>

</body>
</html>
