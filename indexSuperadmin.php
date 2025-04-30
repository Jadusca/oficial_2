<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio del Instituto Tecnologico de Merida</title>
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
            <p>Bienvenido al Repositorio Institucional de Acceso Abierto del Instituto Tecnológico de Mérida,
                que almacena y organiza la documentación y producción de índole científica y académica con el
                propósito de preservarla en formato digital y facilitar su acceso y visibilidad global.</p>
        </div>
        <br><br>
        <section class="direccionesprincipales">
            <div>
                <a class='hvr-sweep-to-right' href='listaUsuariosSuperAdmin.php'>Usuarios</a>
                <a class='hvr-sweep-to-right' href='consulta_documentosSuperAdmin.php'>Catálogo</a>
                <a class='hvr-sweep-to-right' href='Subir_archivos.php'>Subir Archivos</a>
            </div>
            <div>
                <a class='hvr-sweep-to-right' href='herramientas.php'>Herramientas</a>
                <a class='hvr-sweep-to-right' href='modulo_revision_general.php'>Revisar documentos pendientes</a>
                <a class='hvr-sweep-to-right' href='ver_visitas.php'>Reporte de visitas</a>
            </div>
        </section>
    </section>
    <br>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>

</body>

</html>