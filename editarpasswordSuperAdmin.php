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
</head>

<body>
    <?php
    include "headerSuperadmin.php";
    $idDelUsuario = $_GET['idUsuario'];
    $nombreDelUsuario = $_GET['usuario'];
    ?>

    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <br>
    <section class="editar ancho">
        <div class="textoapartadodoc">
            <h2>Editar Usuario y Contraseña</h2>
        </div>
        <div class="formseditarcontra">
            <?php
            echo "<form method='post' class='formNuevoUsuario' action='actualizarContraseña.php?id=$idDelUsuario'>";
            ?>
            <div class="editaruc">
                <label for="">Usuario:</label>
                <?php
                echo "<input type='text' value='$nombreDelUsuario' readonly>"
                    ?>

            </div>
            <div class="editaruc">
                <label>Contraseña Actual:</label>
                <input type="password" name="contraseniaA" minlength="8">
            </div>
            <p>Introduzca su nueva contraseña. Minimo de 8 caracteres</p>
            <div class="editaruc">
                <label for="">Nueva Contraseña:</label>
                <input type="password" name="contraseniaN" minlength="8">
            </div>
            <div class="editaruc">
                <label for="">Confirmar Contraseña:</label>
                <input type="password" name="contraseniaNC" minlength="8">
            </div>
            <div class="btnsPassword botonesfinalescompleto">
                <input class="btnCancelarAdmin" type="button" value="Cancelar" onclick="cancelarEdicionUsuario()">
                <input class="btnSiguienteAdmin" type="submit" value="Guardar">
            </div>
            </form>
        </div>


    </section>
    <br><br>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>
    <script>
        // Función para redirigir a la página del documento
        function cancelarEdicionUsuario() {
            // Obtén el ID del documento desde la URL
            var idUsuario = <?php echo $idDelUsuario; ?>;

            // Redirige a la página del documento correspondiente
            window.location = 'detallesuperuserSuperAdmin.php?idUsuario=' + idUsuario;
        }
    </script>

</body>

</html>