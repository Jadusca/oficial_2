<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Super Admin</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="desktop.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="movil.css" />
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/600b045a2f.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
</head>

<body>
    <?php
    include "headerSuperadmin.php";
    include('conexion.php');

    $sql = "SELECT id_super_administrador, nombre, apellido FROM super_administradores";
    $result = $conectar->query($sql);

    // Establecer $privilegiosId para permitir borrar sin restricciones
    $privilegiosId = "admin";
    ?>
    <?php
    include "sidebar2.php";
    ?>
    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>
    <div class="menu1">
        <a class="arrow" href="indexSuperadmin.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <div class="redireccionadmin2">
        <div class="admin1">
            <a href="listaUsuariosSuperAdmin.php">
                <h2>Administradores</h2>
            </a>
        </div>
        <br><br><br>
        <div class="super-admin1">
            <a href="listaSuperUsuariosSuperAdmin.php">
                <h2>Super Administradores</h2>
            </a>
        </div>
    </div>

    <section class="ancho">
        <div class="titop2">
            <!-- <h1 class="titulosadmin">Lista de Usuarios</h1>
            <h1 id="opcionesadmin">Opciones</h1> -->
        </div>
        <div class="contenedorLUPadre">
            <div class="divListaU">
                <h2>Lista de Super Administradores</h2>
                <div class="tablauser">
                    <?php

                    if ($result->num_rows > 0) {
                        echo "<h3>Mostrando resultados de 1 a 20</h3>";

                        while ($row = $result->fetch_assoc()) {
                            $nombreCompleto = $row["nombre"] . " " . $row["apellido"];
                            $id = $row["id_super_administrador"];

                            echo "<div class='nombrebotones'>
                                <p>" . $nombreCompleto . "</p>
                                <div class='botonestablauser'>
                                    <a class='botonazulfuerte' href='detallesuperuserSuperAdmin.php?idUsuario=$id'>Ver</a>
                                    <i class='fa-solid fa-trash-can borrar-btn' data-userid='$id'></i>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                </div>
                <div class="agregarNU">
                    <a id="btnAU" href="agregarSuperUsuario.php">Agregar Nuevo Super Usuario</a>
                </div>
                <br><br>
            </div>
            <!-- <div class="tablaadmin" id="menuadmin">
                <p>Opciones</p>
                <div class="tablasopciones">
                    <a href="subir_archivos_super_admin.php">Catálogo</a><br>
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
    include "footer.php"
        ?>
    <script src="./funciones.js"></script>
    <script>
        //Funcion eliminar usuario
        $(document).ready(function () {
            $(".borrar-btn").click(function () {
                var userId = $(this).data("userid");
                if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                    window.location.href = "borrarSuperUsuario.php?idUsuario=" + userId + "&redirect=listaSuperUsuariosSuperAdmin.php";
                }
            });
        });
    </script>
</body>

</html>