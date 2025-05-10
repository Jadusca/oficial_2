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

// Obtener total de registros para paginación
$sqlTotal = "SELECT COUNT(*) AS total FROM ficha_carreras f
    JOIN carreras c ON f.carreras = c.id_carreras
    $where";
$resTotal = $conectar->query($sqlTotal);
if (!$resTotal) {
    die("Error en consulta COUNT: " . $conectar->error . "<br>SQL: $sqlTotal");
}
$total = $resTotal->fetch_assoc()['total'];
$total_paginas = ceil($total / $limite);

// Obtener datos paginados
$sql = "SELECT f.*, c.nombre_carrera, t.nombre_titulacion, e.nombre_estado
        FROM ficha_carreras f
        JOIN carreras c ON f.carreras = c.id_carreras
        JOIN tipo_titulacion_carrera t ON f.tipo_titulacion_carrera = t.id_tipo_titulacion
        JOIN estado_revision e ON f.estado_revision = e.id_estado
        $where
        ORDER BY f.id_ficha_carrera DESC
        LIMIT $inicio, $limite";
$res = $conectar->query($sql);
if (!$res) {
    die("Error en consulta SELECT: " . $conectar->error . "<br>SQL: $sql");
}

// Imprimir tabla
echo "<br>";
echo "<div class='tabla-responsive'>";
echo "<table class='tab_mod'>
<tr>
    <th>Título</th>
    <th>Autor</th>
    <th>Licenciatura</th>
    <th>Titulación</th>
    <th>Estado</th>
    <th>Documento</th>
    <th>Oficio</th>
    <th>Acciones</th>
</tr>";
while ($row = $res->fetch_assoc()) {
    echo "<tr>
        <td>{$row['titulo']}</td>
        <td>{$row['autor']}</td>
        <td>{$row['nombre_carrera']}</td>
        <td>{$row['nombre_titulacion']}</td>
        <td>{$row['nombre_estado']}</td>
        <td class='line_pdf'>
            <div class='pdf_busqueda_1'>
                <a href='ver_documento.php?archivo={$row['documento']}' target='_blank'>
                    <i class='fa-solid fa-file-pdf'></i>
                </a>
            </div>
        </td>
        <td class='line_pdf'>" .
            ($row['oficio']
                ? "<div class='pdf_busqueda_1'><a href='ver_oficio.php?archivo={$row['oficio']}' target='_blank'><i class='fa-solid fa-file-zipper'></i></a></div>"
                : "No disponible") . "
        </td>
        <td>
            <a href='editar_documento.php?id={$row['id_ficha_carrera']}' class='btn-editar'>Editar</a>
        </td>
    </tr>";
}
echo "</table>";
echo "</div>";

// Paginación con estilos
echo "<div class='paginacion'>";
for ($i = 1; $i <= $total_paginas; $i++) {
    $clase = ($i == $pagina) ? 'pagina pagina-activa' : 'pagina';
    echo "<a href='#' class='$clase pag-link' data-pagina='$i'>$i</a>";
}
echo "</div>";
?>