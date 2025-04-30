<?php
require "conexion.php";

// Obtener todas las categorías
$categorias = $conectar->query("SELECT * FROM categoria_sabatico");

// Obtener todos los sabáticos para el <select>
$sabaticos = $conectar->query("SELECT * FROM sabaticos");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías de Sabáticos</title>
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

    <form class="nuevas_carreras" action="guardar_categoria_sabatico.php" method="POST">
        <section>
            <label>Nombre de la categoría:</label><br>
            <input type="text" name="nombre_categoria" required>
        </section><br><br>

        <section>
            <label>Sabático:</label><br>
            <select name="sabaticos" required>
                <option value="">Selecciona un sabático</option>
                <?php while ($sab = $sabaticos->fetch_assoc()): ?>
                    <option value="<?= $sab['id_sabaticos'] ?>">
                        <?= htmlspecialchars($sab['nombre_sabatico']) ?> (<?= htmlspecialchars($sab['anio_sabatico']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de categorías</h2>
    <table class="tab_mod">
        <tr>
            <th>ID</th>
            <th>Categoría</th>
            <th>Sabático</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Traer sabáticos junto con las categorías (JOIN)
        $categoriasConSabaticos = $conectar->query("
            SELECT cs.*, s.nombre_sabatico, s.anio_sabatico
            FROM categoria_sabatico cs
            LEFT JOIN sabaticos s ON cs.sabaticos = s.id_sabaticos
        ");
        while ($row = $categoriasConSabaticos->fetch_assoc()):
            ?>
            <tr>
                <td><?= $row['id_categoria_sab'] ?></td>
                <td><?= htmlspecialchars($row['nombre_categoria']) ?></td>
                <td><?= htmlspecialchars($row['nombre_sabatico']) ?></td>
                <td>
                    <div class="actions">
                        <div class="pdf_busqueda">
                            <a href="editar_categoria_sabatico.php?id=<?= $row['id_categoria_sab'] ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        </div>
                        <div class="pdf_busqueda">
                            <a href="eliminar_categoria_sabatico.php?id=<?= $row['id_categoria_sab'] ?>"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')"><i
                                    class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

<br><br>

<?php
include "footer.php";
?>

</html>