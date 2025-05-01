<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar sabáticos</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>
<!-- Modal -->
<div id="resumenModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h3>Resumen</h3>
        <p id="contenidoResumen"></p>
    </div>
</div>

<script>
    function mostrarResumen(texto) {
        document.getElementById("contenidoResumen").innerText = texto;
        document.getElementById("resumenModal").style.display = "block";
    }

    function cerrarModal() {
        document.getElementById("resumenModal").style.display = "none";
    }

    window.onclick = function (event) {
        var modal = document.getElementById("resumenModal");
        if (event.target == modal) {
            cerrarModal();
        }
    }
</script>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="modulo_revision_general.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Documentos de Sabáticos Pendientes</h2>
    </div>

    <?php
    require 'conexion.php';

    $query = "SELECT f.*, s.nombre_sabatico, c.nombre_categoria, e.nombre_estado
        FROM ficha_sabaticos f
        JOIN sabaticos s ON f.sabaticos = s.id_sabaticos
        JOIN categoria_sabatico c ON f.categoria_sabatico = c.id_categoria_sab
        JOIN estado_revision e ON f.estado_revision = e.id_estado
        WHERE f.estado_revision = 1";

    $resultado = $conectar->query($query);
    ?>

    <section class="tabla-contenedor">
        <table class="tab_mod_1">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Sabático</th>
                <th>Categoría</th>
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
                    <td><?php echo $row['nombre_sabatico']; ?></td>
                    <td><?php echo $row['nombre_categoria']; ?></td>
                    <td>
                        <div class="pdf_busqueda">
                            <button
                                onclick="mostrarResumen(`<?php echo htmlspecialchars($row['resumen'], ENT_QUOTES); ?>`)"><i
                                    class="fa-solid fa-file-contract"></i></button>
                        </div>
                    </td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['palabras_clave']; ?></td>
                    <td><?php echo $row['paginas']; ?></td>
                    <td><?php echo $row['dimensiones']; ?></td>
                    <td><?php echo $row['nombre_estado']; ?></td>
                    <td>
                        <div class="actions_1">
                            <div class="icon_action">
                                <div class="pdf_busqueda">
                                    <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank"><i
                                            class="fa-solid fa-file-pdf"></i></a>
                                </div>
                                <div class="pdf_busqueda">
                                    <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank"><i
                                            class="fa-solid fa-file-zipper"></i></a>
                                </div>
                            </div>
                            <div class="icon_action">
                                <div class="pdf_busqueda_check">
                                    <a href="aprobar.php?id=<?php echo $row['id_ficha_sabatico']; ?>&tipo=sab"><i
                                            class="fa-solid fa-square-check"></i></a>
                                </div>
                                <div class="pdf_busqueda_trash">
                                    <a href="rechazar.php?id=<?php echo $row['id_ficha_sabatico']; ?>&tipo=sab"><i
                                            class="fa-solid fa-rectangle-xmark"></i></a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>