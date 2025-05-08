<?php
require "conexion.php";
$titulaciones = $conectar->query("SELECT t.id_tipo_titulacion, t.nombre_titulacion, t.descripcion_titulacion, p.anio_periodo
                                FROM tipo_titulacion_carrera t
                                JOIN periodo_carrera p ON t.periodo_carrera = p.id_periodo_carrera");
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tipo de Titulación (Carrera)</title>
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
        <h2 class="tit_mod_car">Agregar nueva titulación</h2>
    </div>

    <form class="nuevas_carreras" action="guardar_tipo_titulacion_carrera.php" method="POST">
        <section>
            <label>Nombre de la titulación:</label><br>
            <input type="text" name="nombre_titulacion" required>
        </section><br><br>

        <section>
            <label>Descripción:</label><br>
            <textarea name="descripcion_titulacion" rows="4"
                cols="50">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</textarea>
        </section><br><br>

        <section>
            <label>Periodo:</label><br>
            <select name="periodo_carrera" required>
                <option value="">Selecciona un periodo</option>
                <?php while ($p = $periodos->fetch_assoc()): ?>
                    <option value="<?= $p['id_periodo_carrera'] ?>"><?= htmlspecialchars($p['anio_periodo']) ?></option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de titulaciones</h2>
    <div class="tabla-responsive">
        <table class="tab_mod">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Periodo</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $titulaciones->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_tipo_titulacion'] ?></td>
                    <td><?= htmlspecialchars($row['nombre_titulacion']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion_titulacion']) ?></td>
                    <td><?= htmlspecialchars($row['anio_periodo']) ?></td>
                    <td>
                        <div class="actions">
                            <div class="pdf_busqueda">
                                <a href="editar_tipo_titulacion_carrera.php?id=<?= $row['id_tipo_titulacion'] ?>"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                            <div class="pdf_busqueda">
                                <a href="eliminar_tipo_titulacion_carrera.php?id=<?= $row['id_tipo_titulacion'] ?>"
                                    onclick="return confirm('¿Deseas eliminar esta titulación?')"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php
    include "footer.php";
    ?>

    <script src="./funciones.js"></script>

</body>

</html>