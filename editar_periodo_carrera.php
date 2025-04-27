<?php
require "conexion.php";

$id = $_GET['id'];
$stmt = $conectar->prepare("SELECT * FROM periodo_carrera WHERE id_periodo_carrera = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$periodo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Periodo</title>
</head>
<body>
    <h2>Editar periodo</h2>
    <form action="actualizar_periodo_carrera.php" method="POST">
        <input type="hidden" name="id_periodo_carrera" value="<?= $periodo['id_periodo_carrera'] ?>">

        <label>Año del periodo:</label><br>
        <input type="text" name="anio_periodo" value="<?= htmlspecialchars($periodo['anio_periodo']) ?>" required><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
