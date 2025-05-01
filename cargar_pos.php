<?php
require 'conexion.php';

$limite = 20;
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;
$filtro = isset($_GET['filtro']) ? $conectar->real_escape_string($_GET['filtro']) : '';

$where = "WHERE f.estado_revision IN (2,3)";
if ($filtro !== '') {
    $where .= " AND (f.titulo LIKE '%$filtro%' OR f.autor LIKE '%$filtro%')";
}

// Obtener total de registros
$sql_total = "SELECT COUNT(*) AS total
              FROM ficha_posgrados f
              JOIN estado_revision e ON f.estado_revision = e.id_estado
              $where";
$res_total = $conectar->query($sql_total);

if (!$res_total) {
    die("Error en COUNT: " . $conectar->error . "<br>Consulta: $sql_total");
}

$total = $res_total->fetch_assoc()['total'];
$total_paginas = ceil($total / $limite);

// Consulta principal
$query = "SELECT f.*, c.nombre_posgrado, t.nombre_titulacion_pos, e.nombre_estado
          FROM ficha_posgrados f
          JOIN posgrados c ON f.posgrados = c.id_posgrados
          JOIN tipo_titulacion_posgrado t ON f.tipo_titulacion_posgrado = t.id_tipo_titulacion_pos
          JOIN estado_revision e ON f.estado_revision = e.id_estado
          $where
          ORDER BY f.id_ficha_posgrado DESC
          LIMIT $inicio, $limite";
$res = $conectar->query($query);

if (!$res) {
    die("Error en SELECT: " . $conectar->error . "<br>Consulta: $query");
}
?>
<br>
<table class="tab_mod_1">
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Posgrado</th>
        <th>Titulación</th>
        <th>Estado</th>
        <th>Documento</th>
        <th>Oficio</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['titulo'] ?></td>
            <td><?= $row['autor'] ?></td>
            <td><?= $row['nombre_posgrado'] ?></td>
            <td><?= $row['nombre_titulacion_pos'] ?></td>
            <td><?= $row['nombre_estado'] ?></td>
            <td class='line_pdf'>
                <div class="pdf_busqueda_1">
                    <a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank"><i
                            class='fa-solid fa-file-pdf'></i></a>
                </div>
            </td>
            <td class='line_pdf'>
                <?= $row['oficio'] ? "<div class='pdf_busqueda_1'><a href='ver_oficio.php?archivo={$row['oficio']}' target='_blank'><i class='fa-solid fa-file-zipper'></i></a></div>" : "No disponible" ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Paginación con estilos -->
<div class="paginacion">
    <?php for ($i = 1; $i <= $total_paginas; $i++):
        $clase = ($i == $pagina) ? 'pagina pagina-activa' : 'pagina';
        ?>
        <a href="#" class="<?= $clase ?> pag-link" data-pagina="<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>