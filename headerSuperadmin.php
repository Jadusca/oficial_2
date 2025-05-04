<?php
include "seguridadSuperAdmin.php";
?>

<header class="cabecera pixeles">
    <div class="uno unosuperadmin">
        <div class="nombre_Usuario">
            <i class="fa-solid fa-sort-down iconocerrarsesion2"></i>
            <ul class="cerrarsesionad2" id="opcerrar2">
                <li><a href="cerrarSesionSuperAdmin.php">Cerrar Sesión ❌</a></li>
            </ul>
        </div>
        <div class="inicio">
            <i class="fa-solid fa-house"></i>
            <a href='indexSuperadmin.php'>Página Inicio</a>
        </div>
        <div class="contenedorlogocabecera">
            <figure class="logo_nacional">
                <img src="Imagenes/Logo_ITM/Logo nacional.png" alt="">
            </figure>
        </div>
        <div class="contenedorlogocabecera">
            <figure class="logo">
                <img src="Imagenes/Logo_ITM/Logo_ITM.png" alt="">
            </figure>
        </div>
        <div class="contenedorlogocabecera">
            <figure class="logo__nacional">
                <img src="Imagenes/Logo_ITM/Logo nacional.png" alt="">
            </figure>
        </div>
        <div class="iniciomovil">
            <a href="indexSuperadmin.php"><i class="fa-solid fa-house"></i></a>
        </div>
    </div>
    <div class="dosadmin">
        <div class="ingresaradmin">
            <i class="fa-regular fa-user"></i>
            <div class="nombreUsuario">
                <a href="#"><?php echo htmlspecialchars($nombreUsuario); ?></a>
                <i class="fa-solid fa-sort-down iconocerrarsesion" id="iconoUsuario"></i>
                <ul class="cerrarsesionad" id="opcerrarUsuario">
                    <li><a href="cerrarSesionSuperAdmin.php">Cerrar Sesión ❌</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
<script>
    $(document).ready(function () {
        $('#iconoUsuario').click(function () {
            $('#opcerrarUsuario').toggle();
        });
    });
</script>
