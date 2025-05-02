<?php
require "conexion.php";

$id = intval($_GET['id']);
$carrera = $conectar->prepare("SELECT * FROM carreras WHERE id_carreras = ?");
$carrera->bind_param("i", $id);
$carrera->execute();
$resultado = $carrera->get_result();
$datos = $resultado->fetch_assoc();

$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Carrera</title>
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
            <a class="arrow" href="modulo_carreras.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar carrera</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_carrera.php" method="POST" enctype="multipart/form-data"> <input
            type="hidden" name="id_carreras" value="<?= $datos['id_carreras'] ?>">

        <section>
            <label>Nombre de la carrera:</label><br>
            <input type="text" name="nombre_carrera" value="<?= htmlspecialchars($datos['nombre_carrera']) ?>" required>
        </section><br><br>

        <section>
            <label>Periodo de la carrera:</label><br>
            <select name="periodo_carrera" required>
                <option value="">Seleccione un periodo</option>
                <?php while ($p = $periodos->fetch_assoc()): ?>
                    <option value="<?= $p['id_periodo_carrera'] ?>" <?= $p['id_periodo_carrera'] == $datos['periodo_carrera'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['anio_periodo']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <section>
            <label>Año de la carrera (opcional):</label><br>
            <input type="text" name="anio_carrera" value="<?= htmlspecialchars($datos['anio_carrera']) ?>">
        </section><br>

        <section>
            <label>Logo actual:</label><br>
            <?php if (!empty($datos['logo_carrera'])): ?>
                <img src="logos/<?= htmlspecialchars($datos['logo_carrera']) ?>" width="100"><br>
            <?php else: ?>
                <em>No hay logo cargado</em><br>
            <?php endif; ?>
        </section><br>

        <section class="image_movil">
            <label>Nuevo logo (opcional):</label><br>
            <input class="image" type="file" name="logo_carrera" accept="image/*">
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>