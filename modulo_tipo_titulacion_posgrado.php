<?php
require "conexion.php";
$titulaciones = $conectar->query("SELECT * FROM tipo_titulacion_posgrado");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Tipos de Titulación de Posgrado</title>
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
        <h2 class="tit_mod_car">Agregar nuevo tipo de titulación</h2>
    </div>

    <form class="nuevas_carreras" action="guardar_tipo_titulacion_posgrado.php" method="POST">
        <section>
            <label>Nombre de la titulación:</label><br>
            <input type="text" name="nombre_titulacion_pos" required>
        </section><br><br>
        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de tipos de titulación</h2>
    <table class="tab_mod">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $titulaciones->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_tipo_titulacion_pos'] ?></td>
                <td><?= htmlspecialchars($row['nombre_titulacion_pos']) ?></td>
                <td>
                    <div class="actions">
                        <div class="pdf_busqueda">
                            <a href="editar_tipo_titulacion_posgrado.php?id=<?= $row['id_tipo_titulacion_pos'] ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        </div>
                        <div class="pdf_busqueda">
                            <a href="eliminar_tipo_titulacion_posgrado.php?id=<?= $row['id_tipo_titulacion_pos'] ?>"
                                onclick="return confirm('¿Deseas eliminar este tipo de titulación?')"><i
                                    class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                    <br><br>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>