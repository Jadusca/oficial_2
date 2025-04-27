<?php
require "conexion.php";

$sabaticos = $conectar->query("SELECT * FROM sabaticos");
$categorias = $conectar->query("SELECT * FROM categoria_sabatico");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Ficha Sabático</title>
</head>
<body>
    <h2>Subir documento sabático</h2>
    <form action="procesar_ficha_sabatico.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <textarea name="titulo" required></textarea><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required><br><br>

        <label>Resumen:</label><br>
        <textarea name="resumen"></textarea><br><br>

        <label>Fecha del documento:</label><br>
        <input type="date" name="fecha" required><br><br>

        <label>Palabras clave:</label><br>
        <input type="text" name="palabras_clave"><br><br>

        <label>Páginas:</label><br>
        <input type="text" name="paginas"><br><br>

        <label>Dimensiones:</label><br>
        <input type="text" name="dimensiones"><br><br>

        <label>Sabático:</label><br>
        <select name="sabatico_id" id="sabatico_id" required>
            <option value="">Selecciona un sabático</option>
            <?php while ($row = $sabaticos->fetch_assoc()): ?>
                <option value="<?= $row['id_sabaticos'] ?>"><?= htmlspecialchars($row['nombre_sabatico']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Categoría:</label><br>
        <select name="categoria_id" id="categoria_id" required>
            <option value="">Selecciona primero un sabatico</option>
        </select><br><br>

        <label>Documento PDF:</label><br>
        <input type="file" name="documento" accept="application/pdf" required><br>
        <span id="nombreDocumento"></span><br><br>

        <label>Oficio PDF:</label><br>
        <input type="file" name="oficio" accept="application/pdf" required><br>
        <span id="nombreOficio"></span><br><br>

        <input type="submit" value="Subir documento">
    </form>

    <script>
    document.getElementById('sabatico_id').addEventListener('change', function () {
        const sabaticoId = this.value;
        const categoriaSelect = document.getElementById('categoria_id');

        categoriaSelect.innerHTML = '<option>Cargando...</option>';

        fetch('obtener_categoria_por_sabatico.php?sabatico_id=' + sabaticoId)
            .then(response => response.json())
            .then(data => {
                categoriaSelect.innerHTML = '<option value="">Selecciona una categoria</option>';
                data.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id_categoria_sab;
                    option.textContent = categoria.nombre_categoria;
                    categoriaSelect.appendChild(option);
                });
            })
            .catch(error => {
                categoriaSelect.innerHTML = '<option>Error al cargar</option>';
                console.error(error);
            });
    });
    </script>
</body>
</html>
