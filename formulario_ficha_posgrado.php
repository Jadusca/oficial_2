<?php
require "conexion.php";

// Obtener opciones de los selects
$posgrados = $conectar->query("SELECT * FROM posgrados");
$titulaciones = $conectar->query("SELECT * FROM tipo_titulacion_posgrado");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Ficha de Posgrado</title>
</head>
<body>
    <h2>Subir documento de posgrado</h2>
    <form action="procesar_ficha_posgrado.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <textarea name="titulo" required></textarea><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required><br><br>

        <label>Asesor Interno:</label><br>
        <input type="text" name="asesor_interno"><br><br>

        <label>Asesor Externo:</label><br>
        <input type="text" name="asesor_externo"><br><br>

        <label>Palabras clave:</label><br>
        <input type="text" name="palabras_clave"><br><br>

        <label>Resumen:</label><br>
        <textarea name="resumen"></textarea><br><br>

        <label>Fecha del documento:</label><br>
        <input type="date" name="fecha" required><br><br>

        <label>Páginas:</label><br>
        <input type="text" name="paginas"><br><br>

        <label>Dimensiones:</label><br>
        <input type="text" name="dimensiones"><br><br>

        <label>Posgrado:</label><br>
        <select name="posgrado_id" required>
            <option value="">Selecciona un posgrado</option>
            <?php while ($row = $posgrados->fetch_assoc()) {
                echo "<option value='{$row['id_posgrados']}'>{$row['nombre_posgrado']}</option>";
            } ?>
        </select><br><br>

        <label>Tipo de Titulación:</label><br>
        <select name="tipo_titulacion_id" required>
            <option value="">Selecciona el tipo de titulación</option>
            <?php while ($row = $titulaciones->fetch_assoc()) {
                echo "<option value='{$row['id_tipo_titulacion_pos']}'>{$row['nombre_titulacion_pos']}</option>";
            } ?>
        </select><br><br>

        <label>Documento PDF:</label><br>
        <input type="file" name="documento" accept="application/pdf" required><br>
        <span id="nombreDocumento"></span><br><br>

        <label>Oficio PDF:</label><br>
        <input type="file" name="oficio" accept="application/pdf" required><br>
        <span id="nombreOficio"></span><br><br>

        <input type="submit" value="Subir documento">
    </form>
</body>
</html>
