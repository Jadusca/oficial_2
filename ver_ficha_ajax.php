<?php
include('conexion.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$ficha = $conectar->query("
    SELECT f.*, c.nombre_carrera, t.nombre_titulacion
    FROM ficha_carreras f
    JOIN carreras c ON f.carreras = c.id_carreras
    JOIN tipo_titulacion_carrera t ON f.tipo_titulacion_carrera = t.id_tipo_titulacion
    WHERE f.id_ficha_carrera = $id
")->fetch_assoc();

if ($ficha):
?>
    <h3>Ficha del Documento</h3>
    <p><strong>Título:</strong> <?= $ficha['titulo'] ?></p>
    <p><strong>Autor:</strong> <?= $ficha['autor'] ?></p>
    <p><strong>Asesor Interno:</strong> <?= $ficha['asesor_interno'] ?></p>
    <p><strong>Asesor Externo:</strong> <?= $ficha['asesor_externo'] ?></p>
    <p><strong>Resumen:</strong><br><?= nl2br($ficha['resumen']) ?></p>
    <p><strong>Fecha:</strong> <?= $ficha['fecha'] ?></p>
    <p><strong>Palabras Clave:</strong> <?= $ficha['palabras_clave'] ?></p>
    <p><strong>Páginas:</strong> <?= $ficha['paginas'] ?></p>
    <p><strong>Dimensiones:</strong> <?= $ficha['dimensiones'] ?></p>
    <p><strong>Carrera:</strong> <?= $ficha['nombre_carrera'] ?></p>
    <p><strong>Tipo de Titulación:</strong> <?= $ficha['nombre_titulacion'] ?></p>
<?php else: ?>
    <p>No se encontró la ficha.</p>
<?php endif; ?>
