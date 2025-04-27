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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <?php
    include 'headerSuperadmin.php';
    include 'conexion.php';
    ?>

    <?php
    if (isset($_GET['idUsuario'])) {
        $idDelUsuario = $_GET['idUsuario'];
    } else {
        header('Location: listaUsuarios.php');
        exit();
    }

    $sql = "SELECT * FROM super_administradores WHERE id_super_administrador = $idDelUsuario";
    $result = $conectar->query($sql);

    $privilegiosId = file_exists('idUsuario.txt') ? file_get_contents('idUsuario.txt') : "0";

    ?>
    <?php
    include 'sidebar2.php'
        ?>

    <div class="menu1">
        <a class="arrow" href="listaSuperUsuariosSuperAdmin.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <br><br><br>
    <section class="detallesuser ancho">
        <!-- <div class="redireccionadmin">
            <?php
            echo "<a href='listaUsuarios.php'>Lista de Usuarios</a><i class='fa-solid fa-chevron-right'></i><h2>Detalles de Usuario</h2>";
            ?>
            
        </div> -->
        <div class="contdetalles">
            <div class="partedetalles">

                <div class="informacion info1">
                    <p>Informacion del Usuario</p>
                    <?php
                    echo "<a class='botonespequeños botongris' href='editarUsuarioSuperAdmin.php?&idUsuario=$idDelUsuario'>Editar <i class='fa-solid fa-pen'></i></a>";
                    ?>

                </div>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fecha = $row['fecha_nacimiento'];
                        $usuario = $row['usuario'];
                        $contrasenia;
                        $btnEditar;

                        $contrasenia = "*******";

                        echo "<div class='detallesindividual'>
                        <p class='negritas'>Nombre(s):</p>
                        <p class='td'>" . $row['nombre'] . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Apellidos:</p>
                        <p class='td'>" . $row['apellido'] . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Email:</p>
                        <p class='td'>" . $row['email'] . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Fecha de<br> Nacimiento:</p>
                        <p class='td'>" . $fecha . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Genero:</p>
                        <p class='td'>" . $row['genero'] . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Biblioteca:</p>
                        <p class='td'>" . $row['biblioteca'] . "</p>
                    </div>

                    <div class='informacion info1'>
                        <p>Administrador</p>
                        <a class='botonespequeños botongris' href='editarpasswordSuperAdmin.php?idUsuario=$idDelUsuario&usuario=$usuario'>Editar<i class='fa-solid fa-pen'></i></a>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Usuario:</p>
                        <p class='td'>" . $row['usuario'] . "</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Contraseña:</p>
                        <p class='td'>" . $contrasenia . "</p>

                    </div>
                ";
                    }
                }


                ?>


            </div>

            <!-- <div class="tablaadmin" id="menuadmin">
                <p>Opciones</p>
                <div class="tablasopciones">
                    <a href="catalogoadmin.php">Catálogo</a><br>
                    <?php
                    echo "<a href='documentosRTS.php?tipoDocumento=Residencias'>Residencias</a>";
                    echo "<a href='documentosRTS.php?tipoDocumento=Tesis'>Tesis</a>";
                    echo "<a href='documentosRTS.php?tipoDocumento=Sabáticos'>Sabáticos</a>";
                    ?>
                </div>
            </div> -->
        </div>

    </section>
    <?php
    include 'footer.php';
    ?>
    <script src="./funciones.js"></script>

</body>

</html>