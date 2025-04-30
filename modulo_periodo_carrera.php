<?php
require "conexion.php";
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Periodos de Carrera</title>
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
        <h2 class="tit_mod_car">Agregar nuevo periodo</h2>
    </div>

    <form class="nuevas_carreras" action="guardar_periodo_carrera.php" method="POST">
        <section>
            <label>Año del periodo:</label><br>
            <input type="text" name="anio_periodo" required>
        </section><br><br>
        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de periodos</h2>
    <table class="tab_mod">
        <tr>
            <th>ID</th>
            <th>Periodos</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $periodos->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_periodo_carrera'] ?></td>
                <td><?= htmlspecialchars($row['anio_periodo']) ?></td>
                <td>
                    <div class="actions">
                        <div class="pdf_busqueda">
                            <a href="editar_periodo_carrera.php?id=<?= $row['id_periodo_carrera'] ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        </div>
                        <div class="pdf_busqueda">
                            <a href="eliminar_periodo_carrera.php?id=<?= $row['id_periodo_carrera'] ?>"
                                onclick="return confirm('¿Estás seguro de eliminar este periodo?')"><i
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