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

<h2>Documentos de Posgrado Pendientes</h2>
<table border="1">
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
    <?php while($row = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['titulo']; ?></td>
        <td><?php echo $row['autor']; ?></td>
        <td><?php echo $row['nombre_posgrado']; ?></td>
        <td><?php echo $row['nombre_titulacion_pos']; ?></td>
        <td><?php echo $row['asesor_interno']; ?></td>
        <td><?php echo $row['asesor_externo']; ?></td>
        <td><?php echo $row['resumen']; ?></td>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['palabras_clave']; ?></td>
        <td><?php echo $row['paginas']; ?></td>
        <td><?php echo $row['dimensiones']; ?></td>
        <td><?php echo $row['nombre_estado']; ?></td>
        <td>
            <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank">Ver</a> |
            <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank">Ver oficio</a> |
            <a href="aprobar.php?id=<?php echo $row['id_ficha_posgrado']; ?>&tipo=pos">Aprobar</a> |
            <a href="rechazar.php?id=<?php echo $row['id_ficha_posgrado']; ?>&tipo=pos">Rechazar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
