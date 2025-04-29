<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subida de archivos</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>
    <?php
    include "headerSuperadmin.php";
    ?>

    <?php
    $nombreUsuario = file_exists('nombreUsuario.txt') ? file_get_contents('nombreUsuario.txt') : 'Invitado';

    if (empty($nombreUsuario)) {
        header("Location:iniciosesionSuperAdmin.php");
    }
    ?>
    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <section class="parrallax1">
        <article class="info2">
            <h1>Centro de información <br> "Antonio Mediz Bolio"</h1>
    </section>
    <section class="contprincipal ancho">
        <div class="bienvenida">
            <p>Bienvenido al módulo de gestión de documentos académicos.
                Aquí podrás cargar, organizar y administrar los archivos correspondientes a Licenciaturas, Posgrados y
                Sabáticos.
                Asegúrate de completar todos los campos requeridos y de subir los documentos en formato PDF. Cada
                archivo pasará por un proceso de revisión antes de ser publicado oficialmente.
                Gracias por contribuir a mantener actualizada nuestra plataforma académica.</p>
        </div>
        <section class="opc_catalogo">
            <?php
            echo "<a href='formulario_ficha_carrera.php'>
            <section class='catalogo'>
            <i class='fa-solid fa-laptop-file'></i>
                <h1>Licenciaturas</h1>
                <div class='fondo'>

                </div>
                </section></a>";
            echo "<a href='formulario_ficha_posgrado.php'><section class='catalogo'>
            <i class='fa-solid fa-laptop-file'></i>
                <h1>Posgrados</h1>
                <div class='fondo'>

                </div>
                </section></a>";
            echo "<a href='formulario_ficha_sabatico.php'><section class='catalogo'>
            <i class='fa-solid fa-laptop-file'></i>
                <h1>Sabáticos</h1>
                <div class='fondo'>

                </div>
                </section></a>";
            ?>
        </section>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>

</body>

</html>