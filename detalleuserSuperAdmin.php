<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio del Instituto Tecnológico de Mérida</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <?php
    include 'headerSuperadmin.php';
    include 'conexion.php';

    // Validar el idUsuario
    if (isset($_GET['idUsuario']) && is_numeric($_GET['idUsuario'])) {
        $idDelUsuario = intval($_GET['idUsuario']);
    } else {
        header('Location: listaUsuarios.php');
        exit();
    }

    // Ejecutar la consulta
    $sql = "SELECT * FROM administradores WHERE id_administrador = $idDelUsuario";
    $result = $conectar->query($sql);

    // Leer privilegios (opcional)
    $privilegiosId = file_exists('idUsuario.txt') ? file_get_contents('idUsuario.txt') : "0";

    include 'sidebar2.php';
    ?>

    <div class="menu1">
        <a class="arrow" href="listaUsuariosSuperAdmin.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>

    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <br>

    <section class="detallesuser ancho">
        <div class="contdetalles">
            <div class="partedetalles">
                <div class="informacion info1">
                    <p>Información del Usuario</p>
                    <?php
                    echo "<a class='botonespequeños botongris' href='editarUsuarioSuperAdmin.php?idUsuario=$idDelUsuario'>Editar <i class='fa-solid fa-pen'></i></a>";
                    ?>
                </div>

                <?php
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $fecha = $row['fecha_nacimiento'];
                    $usuario = $row['usuario'];
                    $contrasenia = ($privilegiosId === "1") ? $row['contrasena'] : "*******";

                    echo "
                    <div class='detallesindividual'>
                        <p class='negritas'>Nombre(s):</p>
                        <p class='td'>{$row['nombre']}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Apellidos:</p>
                        <p class='td'>{$row['apellido']}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Email:</p>
                        <p class='td'>{$row['email']}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Fecha de<br>Nacimiento:</p>
                        <p class='td'>{$fecha}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Género:</p>
                        <p class='td'>{$row['genero']}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Biblioteca:</p>
                        <p class='td'>{$row['biblioteca']}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Número de<br>Usuario:</p>
                        <p class='td'>{$row['id_administrador']}</p>
                    </div>

                    <div class='informacion info1'>
                        <p>Administrador</p>
                        <a class='botonespequeños botongris' href='editarpasswordSuperAdmin.php?idUsuario=$idDelUsuario&usuario=$usuario'>Editar <i class='fa-solid fa-pen'></i></a>
                    </div>

                    <div class='detallesindividual'>
                        <p class='negritas'>Usuario:</p>
                        <p class='td'>{$usuario}</p>
                    </div>
                    <div class='detallesindividual'>
                        <p class='negritas'>Contraseña:</p>
                        <p class='td'>{$contrasenia}</p>
                    </div>
                    ";
                } else {
                    echo "<div class='informacion info1'>
                            <p class='animate__animated animate__fadeInDown' style='color:red;'>❗ Usuario no encontrado ❗</p>
                            <a class='botonespequeños botongris' href='listaUsuariosSuperAdmin.php'>Volver</a>
                          </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="./funciones.js"></script>

</body>

</html>
