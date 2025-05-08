<?php
require "conexion.php";
$carreras = $conectar->query("SELECT * FROM carreras");
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carreras</title>
    <!-- <style>

        .mensaje {
            margin: 15px 0;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style> -->
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
        <h2 class="tit_mod_car">Agregar nueva carrera</h2>
    </div>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje">
            <?php if ($_GET['mensaje'] === 'actualizado')
                echo "Carrera actualizada con éxito."; ?>
            <?php if ($_GET['mensaje'] === 'eliminado')
                echo "Carrera eliminada correctamente."; ?>
            <?php if ($_GET['mensaje'] === 'guardado')
                echo "Carrera guardada con éxito."; ?>
        </div>
    <?php endif; ?>

    <form class="nuevas_carreras" action="guardar_carrera.php" method="POST" enctype="multipart/form-data">
        <section><label>Nombre de la carrera:</label><br>
            <input type="text" name="nombre_carrera" required>
        </section><br><br>

        <section>
            <label>Periodo de la carrera:</label><br>
            <select name="periodo_carrera" required>
                <option value="">Seleccione un periodo</option>
                <?php while ($p = $periodos->fetch_assoc()): ?>
                    <option value="<?= $p['id_periodo_carrera'] ?>"><?= htmlspecialchars($p['anio_periodo']) ?></option>
                <?php endwhile; ?>
            </select>
        </section><br><br>

        <section>
            <label>Año de la carrera (opcional):</label><br>
            <input type="text" name="anio_carrera" pattern="\d{4}" title="Debe ser un año de 4 dígitos">
        </section><br><br>

        <section>
            <label>Logo (imagen):</label><br>
            <input class="image" type="file" name="logo_carrera" accept="image/*">
        </section><br><br>

        <input class="mod_car" type="submit" value="Guardar">
    </form>

    <h2 class="tit_mod_car">Lista de carreras</h2>
    <div class="tabla-responsive">
        <table class="tab_mod">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Año</th>
                <th>Periodo</th>
                <th>Logo</th>
                <th>Acciones</th>
            </tr>
            <?php
            $carrerasFull = $conectar->query("SELECT c.*, p.anio_periodo FROM carreras c LEFT JOIN periodo_carrera p ON c.periodo_carrera = p.id_periodo_carrera");
            while ($row = $carrerasFull->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $row['id_carreras'] ?></td>
                    <td><?= htmlspecialchars($row['nombre_carrera']) ?></td>
                    <td><?= htmlspecialchars($row['anio_carrera']) ?></td>
                    <td><?= htmlspecialchars($row['anio_periodo'] ?? 'Sin asignar') ?></td>
                    <td>
                        <?php if (!empty($row['logo_carrera'])): ?>
                            <img src="logos/<?= htmlspecialchars($row['logo_carrera']) ?>" width="60">
                        <?php else: ?>
                            <em>Sin logo</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <div class='pdf_busqueda'><a href="editar_carrera.php?id=<?= $row['id_carreras'] ?>"><i
                                        class="fa-solid fa-pen-to-square"></i></a></div>
                            <div class='pdf_busqueda'><a href="eliminar_carrera.php?id=<?= $row['id_carreras'] ?>"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?')"><i
                                        class="fa-solid fa-trash-can"></i></a></div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <br><br>

    <?php
    include "footer.php";
    ?>

    <script src="./funciones.js"></script>

</body>

</html>