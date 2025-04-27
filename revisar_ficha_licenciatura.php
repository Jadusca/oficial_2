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

<h2>Documentos de Licenciatura Pendientes</h2>
<table border="1">
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
    <?php while($row = $resultado->fetch_assoc()): ?>
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
            <a href="ver_documento.php?archivo=<?php echo $row['documento']; ?>" target="_blank">Ver documento</a> |
            <a href="ver_oficio.php?archivo=<?php echo $row['oficio']; ?>" target="_blank">Ver oficio</a> |
            <a href="aprobar.php?id=<?php echo $row['id_ficha_carrera']; ?>&tipo=lic">Aprobar</a> |
            <a href="rechazar.php?id=<?php echo $row['id_ficha_carrera']; ?>&tipo=lic">Rechazar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
