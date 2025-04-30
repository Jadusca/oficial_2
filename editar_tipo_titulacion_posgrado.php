<?php
require "conexion.php";

$id = $_GET['id'];
$stmt = $conectar->prepare("SELECT * FROM tipo_titulacion_posgrado WHERE id_tipo_titulacion_pos = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$titulacion = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Tipo de Titulación</title>
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
            <a class="arrow" href="modulo_tipo_titulacion_posgrado.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar tipo de titulación</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_tipo_titulacion_posgrado.php" method="POST">
        <input type="hidden" name="id_tipo_titulacion_pos" value="<?= $titulacion['id_tipo_titulacion_pos'] ?>">

        <section>
            <label>Nombre de la titulación:</label><br>
            <input type="text" name="nombre_titulacion_pos"
                value="<?= htmlspecialchars($titulacion['nombre_titulacion_pos']) ?>" required>
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>