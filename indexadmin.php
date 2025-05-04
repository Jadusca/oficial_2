<?php
    include "headeradmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>
    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>

    <section class="parrallax">
        <article class="info2">
            <h1>Centro de información <br> "Antonio Mediz Bolio"</h1>
        </article>

    </section>

    <section class="contprincipal ancho">
        <article class="bienvenida">
            <p>Bienvenido al Repositorio Institucional de Acceso Abierto del Instituto Tecnológico de Mérida,
                que almacena y organiza la documentación y producción de índole científica y académica con el
                propósito de preservarla en formato digital y facilitar su acceso y visibilidad global.</p>
        </article>
        <br><br>
        <section class="direccionesprincipales">
            <a class='hvr-sweep-to-right' href='consulta_documentosAdmin.php'>Catalogo</a>
            <a class='hvr-sweep-to-right' href='subir_archivosAdmin.php'>Subir archivos</a>
            <a class='hvr-sweep-to-right' href='ver_visitasAdmin.php'>Reporte de visitas</a>
        </section>
    </section>
    <br><br>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>
</body>

</html>