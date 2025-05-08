<?php
require "conexion.php";

$id = intval($_GET['id']);
$titulacion = $conectar->query("SELECT * FROM tipo_titulacion_carrera WHERE id_tipo_titulacion = $id")->fetch_assoc();
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Titulación</title>
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
            <a class="arrow" href="modulo_tipo_titulacion_carrera.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Editar tipo de titulación</h2>
    </div>

    <form class="nuevas_carreras" action="actualizar_tipo_titulacion_carrera.php" method="POST">
        <input type="hidden" name="id_tipo_titulacion" value="<?= $titulacion['id_tipo_titulacion'] ?>">

        <section>
            <label>Nombre de la titulación:</label><br>
            <input type="text" name="nombre_titulacion"
                value="<?= htmlspecialchars($titulacion['nombre_titulacion']) ?>" required>
        </section><br><br>

        <section>
            <label>Descripción:</label><br>
            <textarea name="descripcion_titulacion" rows="4"
                cols="50"><?= htmlspecialchars($titulacion['descripcion_titulacion']) ?></textarea>
        </section><br><br>

        <section>
            <label>Periodo:</label><br>
            <select name="periodo_carrera" required>
                <option value="">Selecciona un periodo</option>
                <?php while ($p = $periodos->fetch_assoc()): ?>
                    <option value="<?= $p['id_periodo_carrera'] ?>"
                        <?= $p['id_periodo_carrera'] == $titulacion['periodo_carrera'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['anio_periodo']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <input class="mod_car" type="submit" value="Actualizar">
    </form>
</body>

<br><br>

<?php
include "footer.php";
?>

<script src="./funciones.js"></script>

</html>