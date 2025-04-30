<?php
require "conexion.php";
$posgrados = $conectar->query("SELECT * FROM posgrados");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Posgrados</title>
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
        <h2 class="tit_mod_car">Agregar nuevo posgrado</h2>
    </div>

    <form class="nuevas_carreras" action="guardar_posgrado.php" method="POST" enctype="multipart/form-data">
        <section>
            <label>Nombre del posgrado:</label><br>
            <input type="text" name="nombre_posgrado" required>
        </section><br><br>

        <section>
            <label>Año del posgrado (opcional):</label><br>
            <input type="text" name="anio_posgrado">
        </section><br><br>

        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de posgrados</h2>
    <table class="tab_mod">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $posgrados->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_posgrados'] ?></td>
                <td><?= htmlspecialchars($row['nombre_posgrado']) ?></td>
                <td><?= htmlspecialchars($row['anio_posgrado']) ?></td>
                <td>
                    <div class="actions">
                        <div class="pdf_busqueda">
                            <a href="editar_posgrado.php?id=<?= $row['id_posgrados'] ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        </div>
                        <div class="pdf_busqueda">
                            <a href="eliminar_posgrado.php?id=<?= $row['id_posgrados'] ?>"
                                onclick="return confirm('¿Estás seguro de eliminar este posgrado?')"><i
                                    class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
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