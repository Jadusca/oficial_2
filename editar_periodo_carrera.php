<?php
require "conexion.php";

$id = $_GET['id'];
$stmt = $conectar->prepare("SELECT * FROM periodo_carrera WHERE id_periodo_carrera = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$periodo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Periodo</title>
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
            <a class="arrow" href="modulo_periodo_carrera.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar periodo</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_periodo_carrera.php" method="POST">
        <input type="hidden" name="id_periodo_carrera" value="<?= $periodo['id_periodo_carrera'] ?>">

        <section>
            <label>Año del periodo:</label><br>
            <input type="text" name="anio_periodo" value="<?= htmlspecialchars($periodo['anio_periodo']) ?>" required>
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>
    
    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>