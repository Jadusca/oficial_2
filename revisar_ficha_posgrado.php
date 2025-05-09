<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar pendientes Posgrados</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="responsiveslides.min.js"></script>
</head>
<body>

<!-- Modal Resumen -->
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

    window.onclick = function(event) {
        if (event.target === document.getElementById("resumenModal")) {
            cerrarModal();
        }
    }

    function confirmarAccion(id, tipo, accion) {
        let mensaje = accion === 'aprobar' ? '¿Deseas aprobar este documento?' : '¿Deseas rechazar este documento?';
        if (confirm(mensaje)) {
            $.ajax({
                url: accion + '.php',
                type: 'GET',
                data: { id: id, tipo: tipo },
                success: function(respuesta) {
                    alert('Documento ' + (accion === 'aprobar' ? 'aprobado' : 'rechazado') + ' correctamente.');
                    location.reload();
                },
                error: function() {
                    alert('Error al procesar la solicitud.');
                }
            });
        }
    }
</script>

<?php include "headerSuperadmin.php"; ?>

<div class="edit_car">
    <div class="menu1_1">
        <a class="arrow" href="modulo_revision_general.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <h2 class="tit_mod_car">Documentos de Posgrado Pendientes</h2>
</div>

<?php
require 'conexion.php';

$query = "SELECT f.*, p.nombre_posgrado, t.nombre_titulacion_pos, e.nombre_estado
          FROM ficha_posgrados f
          JOIN posgrados p ON f.posgrados = p.id_posgrados
          JOIN tipo_titulacion_posgrado t ON f.tipo_titulacion_posgrado = t.id_tipo_titulacion_pos
          JOIN estado_revision e ON f.estado_revision = e.id_estado
          WHERE f.estado_revision = 1";

$resultado = $conectar->query($query);
?>

<section class="tabla-contenedor">
    <div class="tabla-responsive">
        <table class="tab_mod">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Posgrado</th>
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
                    <td><?php echo $row['nombre_posgrado']; ?></td>
                    <td><?php echo $row['nombre_titulacion_pos']; ?></td>
                    <td><?php echo $row['asesor_interno']; ?></td>
                    <td><?php echo $row['asesor_externo']; ?></td>
                    <td>
                        <div class="pdf_busqueda">
                            <button onclick="mostrarResumen(`<?php echo htmlspecialchars($row['resumen'], ENT_QUOTES); ?>`)">
                                <i class="fa-solid fa-file-contract"></i>
                            </button>
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
                                    <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                </div>
                                <div class="pdf_busqueda">
                                    <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank">
                                        <i class="fa-solid fa-file-zipper"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="icon_action">
                                <div class="pdf_busqueda_check">
                                    <a href="javascript:void(0);" onclick="confirmarAccion(<?php echo $row['id_ficha_posgrado']; ?>, 'pos', 'aprobar')">
                                        <i class="fa-solid fa-square-check"></i>
                                    </a>
                                </div>
                                <div class="pdf_busqueda_trash">
                                    <a href="javascript:void(0);" onclick="confirmarAccion(<?php echo $row['id_ficha_posgrado']; ?>, 'pos', 'rechazar')">
                                        <i class="fa-solid fa-rectangle-xmark"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>

<br><br>

<?php include "footer.php"; ?>

<script src="funciones.js"></script>

</body>
</html>
