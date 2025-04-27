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
        <td><?php echo $row['resumen']; ?></td>
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
