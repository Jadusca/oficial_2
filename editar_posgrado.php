<?php
require "conexion.php";

$id = intval($_GET['id']);
$resultado = $conectar->query("SELECT * FROM posgrados WHERE id_posgrados = $id");
$posgrado = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Posgrado</title>
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

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="modulo_posgrados.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar posgrado</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_posgrado.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_posgrados" value="<?= $posgrado['id_posgrados'] ?>">

        <section>
            <label>Nombre del posgrado:</label><br>
            <input type="text" name="nombre_posgrado" value="<?= htmlspecialchars($posgrado['nombre_posgrado']) ?>"
                required>
        </section><br><br>

        <section>
            <label>Año del posgrado:</label><br>
            <input type="text" name="anio_posgrado" value="<?= htmlspecialchars($posgrado['anio_posgrado']) ?>">
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="./funciones.js"></script>

</body>

</html>