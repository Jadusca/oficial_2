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
    <script type="text/javascript" src="jquery.tinycarousel.js"></script>
    <script src="funciones.js"></script>
    <script src="responsiveslides.min.js"></script>
    <script src="wow.min.js"></script>
    <script src="fancybox/jquery.fancybox.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
    <style>
        .campo {
            margin-bottom: 10px;
        }

        .icono {
            cursor: pointer;
            user-select: none;
        }
    </style>
</head>

<body>

    <?php
    $error = 0;
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error == "1") {
            echo "<script>alert('Usuario y contraseña incorrectos')</script>";
        }
    }
    ?>
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
                <h1>Panel Administrativo</h1>
                <br>
                <h1>Centro de Información del Instituto Tecnológico de Mérida
                </h1>
                <br>
            </div>
            <div class="formulariobiblio">
                <form method="post" action="validarUsuario.php">
                    <input type="text" name="usuario" class="campo" placeholder="Usuario"><br><br>
                    <input type="password" name="contra" class="campo" placeholder="Contraseña" id="contrasena">
                    <span id="toggleContrasena" class="icono" onclick="togglePassword()">👁️</span><br><br>
                    <input type="submit" value="Iniciar Sesión" id="enviar" class="enviar">
                </form>
            </div>
            <div class="textoforms">
                <!-- <p class="azul">¿Olvidaste tu contraseña?</p>
                <p>Cualquier problema de autentificación por favor <br> enviar un correo a
                    admin.bibliovirtual@merida.tecnm.mx </p> -->
            </div>
            <div class="logotecbiblio1">
                <figure>
                    <img src="Imagenes/Logo_ITM/Logo_ITM.png" alt="">
                </figure>
            </div>
            <div class="fondo-admin">
                
            </div>
        </div>
    </section>
    <div class="footer">
        <?php
        include 'footer.php';
        ?>
    </div>

    <script>
        function togglePassword() {
            const contrasenaInput = document.getElementById('contrasena');
            const toggleIcon = document.getElementById('toggleContrasena');

            if (contrasenaInput.type === 'password') {
                contrasenaInput.type = 'text';
                toggleIcon.textContent = '🔒';
            } else {
                contrasenaInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</body>

</html>