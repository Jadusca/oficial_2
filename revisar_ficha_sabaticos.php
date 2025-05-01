<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar sabáticos</title>
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        width: 60%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }
    </style>
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

window.onclick = function(event) {
    var modal = document.getElementById("resumenModal");
    if (event.target == modal) {
        cerrarModal();
    }
}
</script>
<body>

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

<h2>Documentos de Sabáticos Pendientes</h2>
<table border="1">
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
    <?php while($row = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['titulo']; ?></td>
        <td><?php echo $row['autor']; ?></td>
        <td><?php echo $row['nombre_sabatico']; ?></td>
        <td><?php echo $row['nombre_categoria']; ?></td>
        <td><button onclick="mostrarResumen(`<?php echo htmlspecialchars($row['resumen'], ENT_QUOTES); ?>`)">Ver resumen</button></td>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['palabras_clave']; ?></td>
        <td><?php echo $row['paginas']; ?></td>
        <td><?php echo $row['dimensiones']; ?></td>
        <td><?php echo $row['nombre_estado']; ?></td>
        <td>
            <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank">Ver</a> |
            <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank">Ver oficio</a> |
            <a href="aprobar.php?id=<?php echo $row['id_ficha_sabatico']; ?>&tipo=sab">Aprobar</a> |
            <a href="rechazar.php?id=<?php echo $row['id_ficha_sabatico']; ?>&tipo=sab">Rechazar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>