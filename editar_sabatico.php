<head>
    <meta charset="UTF-8">
    <title>Editar Sabático</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<?php
include "headerSuperadmin.php";
?>

<div class="edit_car">
    <div class="menu1_1">
        <a class="arrow" href="modulo_sabaticos.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <h2 class="tit_mod_car">Editar sabático</h2>
</div>

<?php
require "conexion.php";


$id = intval($_GET['id']);
$result = $conectar->query("SELECT * FROM sabaticos WHERE id_sabaticos = $id");
$sabatico = $result->fetch_assoc();
?>

<form class="nuevas_carreras" action="actualizar_sabatico.php" method="POST">
    <input type="hidden" name="id" value="<?= $sabatico['id_sabaticos'] ?>">

    <section>
        <label>Nombre del sabático:</label><br>
        <input type="text" name="nombre_sabatico" value="<?= htmlspecialchars($sabatico['nombre_sabatico']) ?>"
            required>
    </section><br><br>

    <section>
        <label>Año del sabático (opcional):</label><br>
        <input type="number" name="anio_sabatico" value="<?= htmlspecialchars($sabatico['anio_sabatico']) ?>">
    </section><br><br>

    <input class="mod_car" type="submit" value="Actualizar">
</form>

<br><br>

    <?php
    include "footer.php";
    ?>