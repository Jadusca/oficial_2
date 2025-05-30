<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas</title>
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

    <div class="menu1">
        <a class="arrow" href="indexSuperadmin.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <?php
    $nombreUsuario = file_exists('nombreUsuario.txt') ? file_get_contents('nombreUsuario.txt') : 'Invitado';

    if (empty($nombreUsuario)) {
        header("Location:iniciosesionSuperAdmin.php");
    }
    ?>
    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <section class="contprincipal ancho">
        <div class="direccionesprincipales">
            <?php
            echo "<a class='hvr-sweep-to-right' href='modulo_carreras.php'>Modulo de licenciaturas</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_posgrados.php'>Modulo de posgrados</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_sabaticos.php'>Modulo de sabáticos</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_categoria_sabatico.php'>Modulo de categoria sabáticos</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_periodo_carrera.php'>Modulo de periodos licenciaturas</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_tipo_titulacion_carrera.php'>Modulo de tipo de titulación licenciatura</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_tipo_titulacion_posgrado.php'>Modulo de tipo de titulación posgrado</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_galeria.php'>Modulo de galería</a>";
            ?>
        </div>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>

</body>

</html>