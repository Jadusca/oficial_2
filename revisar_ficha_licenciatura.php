<head>
    <meta charset="UTF-8">
    <title>Revisar ficha de Licenciatura</title>
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

<div class="menu1">
    <a class="arrow" href="herramientas.php"><i class="fa-solid fa-arrow-left"></i></a>
</div>

<br>

<?php
require 'conexion.php';

$query = "SELECT f.*, c.nombre_carrera, t.nombre_titulacion, e.nombre_estado
        FROM ficha_carreras f
        JOIN carreras c ON f.carreras = c.id_carreras
        JOIN tipo_titulacion_carrera t ON f.tipo_titulacion_carrera = t.id_tipo_titulacion
        JOIN estado_revision e ON f.estado_revision = e.id_estado
        WHERE f.estado_revision = 1";

$resultado = $conectar->query($query);
?>

<h2 class="tit_mod_car">Documentos de Licenciatura Pendientes</h2>
<section class="tabla-contenedor">
    <table class="tab_mod_1">
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Carrera</th>
            <th>Titulación</th>
            <th>Asesor Interno</th>
            <th>Asesor Externo</th>
            <th>Resumen</th>
            <th>Fecha</th>
            <th>Palabras claves</th>
            <th>Páginas</th>
            <th>Dimensiones</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['autor']; ?></td>
                <td><?php echo $row['nombre_carrera']; ?></td>
                <td><?php echo $row['nombre_titulacion']; ?></td>
                <td><?php echo $row['asesor_interno']; ?></td>
                <td><?php echo $row['asesor_externo']; ?></td>
                <td><?php echo $row['resumen']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['palabras_clave']; ?></td>
                <td><?php echo $row['paginas']; ?></td>
                <td><?php echo $row['dimensiones']; ?></td>
                <td><?php echo $row['nombre_estado']; ?></td>
                <td>
                    <div class="actions_1">
                        <div class="icon_action">
                            <div class="pdf_busqueda">
                                <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                            </div>
                            <div class="pdf_busqueda">
                                <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank"><i class="fa-solid fa-file-zipper"></i></a>
                            </div>
                        </div>
                        <div class="icon_action">
                            <div class="pdf_busqueda">
                                <a href="aprobar.php?id=<?php echo $row['id_ficha_carrera']; ?>&tipo=lic"><i class="fa-solid fa-square-check"></i></a>
                            </div>
                            <div class="pdf_busqueda">
                                <a href="rechazar.php?id=<?php echo $row['id_ficha_carrera']; ?>&tipo=lic"><i class="fa-solid fa-rectangle-xmark"></i></a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>