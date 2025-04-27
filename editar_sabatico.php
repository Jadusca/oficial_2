<?php
require "conexion.php";

$id = intval($_GET['id']);
$result = $conectar->query("SELECT * FROM sabaticos WHERE id_sabaticos = $id");
$sabatico = $result->fetch_assoc();
?>

<h2>Editar sabático</h2>
<form action="actualizar_sabatico.php" method="POST">
    <input type="hidden" name="id" value="<?= $sabatico['id_sabaticos'] ?>">

    <label>Nombre del sabático:</label><br>
    <input type="text" name="nombre_sabatico" value="<?= htmlspecialchars($sabatico['nombre_sabatico']) ?>" required><br><br>

    <label>Año del sabático (opcional):</label><br>
    <input type="number" name="anio_sabatico" value="<?= htmlspecialchars($sabatico['anio_sabatico']) ?>"><br><br>

    <input type="submit" value="Actualizar">
</form>
