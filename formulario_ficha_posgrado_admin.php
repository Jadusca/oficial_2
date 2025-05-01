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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Ficha de Posgrado</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>

    <?php
    include "headeradmin.php";
    ?>

    <div class="menu1">
        <a class="arrow" href="Subir_archivosAdmin.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <br><br>

    <h2 class="tit_lic">Subir documento de posgrado</h2>
    <form class="form_lic" action="procesar_ficha_posgrado_admin.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <input type="text" name="titulo" placeholder="Introduzca el título" required></input><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor"
            placeholder="Introduzca el nombre del autor(es) (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Asesor Interno:</label><br>
        <input type="text" name="asesor_interno"
            placeholder="Introduzca el nombre del asesor interno (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Asesor Externo:</label><br>
        <input type="text" name="asesor_externo"
            placeholder="Introduzca el nombre del asesor externo (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Palabras clave:</label><br>
        <input type="text" name="palabras_clave" placeholder="Introduzca las palabras claves del documento."
            required><br><br>

        <label>Resumen:</label><br>
        <textarea name="resumen" placeholder="Introduzca el resumen del documento" required></textarea><br><br>

        <label>Fecha del documento:</label><br>
        <input type="date" name="fecha" required><br><br>

        <label>Páginas:</label><br>
        <input type="text" name="paginas" placeholder="Introduce UNICAMENTE el número de páginas" required><br><br>

        <label>Dimensiones:</label><br>
        <input type="text" name="dimensiones" placeholder="Introduce las dimensiones del documento, ejemplo (50 x 50)"
            required><br><br>

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
        <input class="file" type="file" name="documento" accept="application/pdf" required><br>
        <span id="nombreDocumento"></span><br><br>

        <label>Oficio PDF:</label><br>
        <input class="file" type="file" name="oficio" accept="application/pdf" required><br>
        <span id="nombreOficio"></span><br><br>

        <input class="enviar_doc" type="submit" value="Subir documento">
    </form>
    <br><br>
    <?php
    include "footer.php";
    ?>
</body>

</html>