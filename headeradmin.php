<?php include "seguridad.php"; ?>

<header id="inicio" class="cabecera pixeles">
    <div class="uno uno_admin">
        <div class="menu_admin">
            <i class="fa-solid fa-bars iconocerrarsesion2"></i>
            <ul class="cerrarsesionad2" id="opcerrar2">
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="inicio">
            <i class="fa-solid fa-house"></i>
            <a href="indexadmin.php">Página Inicio</a>
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
            <a href="indexadmin.php"><i class="fa-solid fa-house"></i></a>
        </div>
    </div>
    <div class="dosadmin">
        <div class="ingresaradmin">
            <i class="fa-regular fa-user"></i>
            <a href="#"><?php echo htmlspecialchars($nombreUsuario); ?></a>
            <i class="fa-solid fa-sort-down iconocerrarsesion"></i>
            <ul class="cerrarsesionad" id="opcerrar">
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="menuadmin">
            <i class="fa-solid fa-bars iconocerrarsesion2"></i>
            <ul class="cerrarsesionad2" id="opcerrar2">
                <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</header>
