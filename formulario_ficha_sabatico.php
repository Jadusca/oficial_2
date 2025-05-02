<?php
require "conexion.php";

$sabaticos = $conectar->query("SELECT * FROM sabaticos");
$categorias = $conectar->query("SELECT * FROM categoria_sabatico");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- IMPORTANTE para estilos móviles -->
    <title>Subir Ficha Sabático</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>

    <?php include "headerSuperadmin.php"; ?>

    <div class="menu1">
        <a class="arrow" href="Subir_archivos.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <br><br>
    <h2 class="tit_lic">Subir documento sabático</h2>
    <form class="form_lic" action="procesar_ficha_sabatico.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <input type="text" name="titulo" placeholder="Introduzca el título" required><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor"
            placeholder="Introduzca el nombre del autor(es) (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Resumen:</label><br>
        <textarea name="resumen" placeholder="Introduzca el resumen del documento" required></textarea><br><br>

        <label>Fecha del documento:</label><br>
        <input type="date" name="fecha" required><br><br>

        <label>Palabras clave:</label><br>
        <input type="text" name="palabras_clave" placeholder="Introduzca las palabras claves del documento."><br><br>

        <label>Páginas:</label><br>
        <input type="text" name="paginas" placeholder="Introduce UNICAMENTE el número de páginas" required><br><br>

        <label>Dimensiones:</label><br>
        <input type="text" name="dimensiones" placeholder="Introduce las dimensiones del documento, ejemplo (50 x 50)"
            required><br><br>

        <label>Sabático:</label><br>
        <select name="sabatico_id" id="sabatico_id" required>
            <option value="">Selecciona un sabático</option>
            <?php while ($row = $sabaticos->fetch_assoc()): ?>
                <option value="<?= $row['id_sabaticos'] ?>"><?= htmlspecialchars($row['nombre_sabatico']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Categoría:</label><br>
        <select name="categoria_id" id="categoria_id" required>
            <option value="">Selecciona primero un sabático</option>
        </select><br><br>

        <label>Documento PDF:</label><br>
        <input class="file" type="file" name="documento" accept="application/pdf" required><br>
        <span id="nombreDocumento"></span><br><br>

        <label>Oficio PDF:</label><br>
        <input class="file" type="file" name="oficio" accept="application/pdf" required><br>
        <span id="nombreOficio"></span><br><br>

        <input class="enviar_doc" type="submit" value="Subir documento">
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

    <br><br>
    <?php include "footer.php"; ?>

    <script src="./funciones.js"></script>

</body>

</html>
