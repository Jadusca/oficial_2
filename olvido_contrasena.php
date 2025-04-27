<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Instituto Tecnológico de Mérida</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
</head>

<body>

    <section class="iniciousuarios pixeles">
        <div class="muro">
            <figure>
                <img src="Imagenes/Inicio_Sesion/MuroTec.jpg" alt="">
            </figure>
        </div>
        <div class="iniciosesion">
            <div class="biblioteca">
                <figure>
                    <img src="Imagenes/Logo_ITM/Logo nacional.png" alt="">
                </figure>
            </div>
            <div class="textobiblio">
                <h1>Recuperar Contraseña</h1><br>
                <h1>Centro de Información del Instituto Tecnológico de Mérida</h1>
            </div>
            <div class="formulariobiblio">
                <form method="post" action="enviar_token.php">
                    <input type="email" name="email" class="campo" placeholder="Ingresa tu correo electrónico" required><br><br>
                    <input type="submit" value="Enviar enlace de recuperación" id="enviar">
                </form>
                <div style="margin-top: 10px;">
                    <a href="iniciosesionSuperAdmin.php" style="text-decoration: none; color: #007BFF;">← Volver al inicio de sesión</a>
                </div>
            </div>
            <div class="logotecbiblio">
                <figure>
                    <img src="Imagenes/Logo_ITM/Logo_ITM.png" alt="">
                </figure>
            </div>
            <div class="fondo-admin">
            </div>
        </div>
    </section>

    <?php
    include 'footer.php';
    ?>

</body>

</html>
