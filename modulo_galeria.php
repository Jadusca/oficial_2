<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Galería</title>
</head>
<body>
    <h2>Actualizar galería (6 imágenes)</h2>

    <form action="guardar_galeria.php" method="POST" enctype="multipart/form-data">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <label>Imagen <?= $i ?> :</label><br>
            <img src="Imagenes/Galería/gallery <?= $i ?>.jpg" width="150" alt="Imagen actual <?= $i ?>"><br>
            <input type="file" name="imagen<?= $i ?>" accept="image/*"><br><br>
        <?php endfor; ?>
        <input type="submit" value="Actualizar galería">
    </form>
</body>
</html>
