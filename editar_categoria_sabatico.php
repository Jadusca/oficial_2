<?php
require "conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido.");
}

// Obtener datos de la categoría a editar
$stmt = $conectar->prepare("SELECT * FROM categoria_sabatico WHERE id_categoria_sab = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die("Categoría no encontrada.");
}

// Obtener lista de sabáticos para el select
$sabaticos = $conectar->query("SELECT * FROM sabaticos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría de Sabático</title>
</head>
<body>
    <h2>Editar Categoría de Sabático</h2>
    <form action="actualizar_categoria_sabatico.php" method="POST">
        <input type="hidden" name="id_categoria_sab" value="<?= $categoria['id_categoria_sab'] ?>">

        <label>Nombre de la categoría:</label><br>
        <input type="text" name="nombre_categoria" value="<?= htmlspecialchars($categoria['nombre_categoria']) ?>" required><br><br>

        <label>Sabático:</label><br>
        <select name="sabaticos" required>
            <option value="">Selecciona un sabático</option>
            <?php while ($sab = $sabaticos->fetch_assoc()): ?>
                <option value="<?= $sab['id_sabaticos'] ?>"
                    <?= ($sab['id_sabaticos'] == $categoria['sabaticos']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sab['nombre_sabatico']) ?> (<?= htmlspecialchars($sab['anio_sabatico']) ?>)
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
