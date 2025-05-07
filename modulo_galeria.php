<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Galería</title>
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
            <a class="arrow" href="herramientas.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Agregar nueva categoría de sabático</h2>
    </div>

    <h2 class="tit_mod_car tit_mod_car1">Actualizar galería (6 imágenes)</h2>

    <form class="nuevas_carreras" action="guardar_galeria.php" method="POST" enctype="multipart/form-data">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <label>Imagen <?= $i ?> :</label><br>
            <section>
            <img src="Imagenes/Galería/gallery<?= $i ?>.jpg?<?= time() ?>" width="150" alt="Imagen actual <?= $i ?>">
                <br>
                <input class="image" type="file" name="imagen<?= $i ?>" accept="image/*">
            </section><br><br>
        <?php endfor; ?>
        <input class="mod_car" type="submit" value="Actualizar galería">
    </form>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="funciones.js"></script>

</body>

</html>