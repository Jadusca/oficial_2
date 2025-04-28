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
            <p>Bienvenido al módulo de Herramientas del sistema.
                Desde esta sección podrás gestionar los diferentes elementos que forman parte de la plataforma:
                Agregar o modificar Licenciaturas, Posgrados y Sabáticos.
                Administrar las imágenes de la galería.
                Gestionar los Tipos de Titulación disponibles.
                Configurar los Periodos de Licenciaturas.
                Utiliza cada módulo con responsabilidad para asegurar que la información publicada esté siempre actualizada y correcta.

</p>
        </div>
        <div class="direccionesprincipales">
            <?php
            echo "<a class='hvr-sweep-to-right' href='modulo_carreras.php'>Modulo de licenciaturas</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_posgrados.php'>Modulo de posgrados</a>";
            echo "<a class='hvr-sweep-to-right' href='modulo_sabaticos.php'>Modulo de sabáticos</a>";
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