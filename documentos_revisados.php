<?php require 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentos Revisados</title>
    <style>
        .tabs {
            display: flex;
            cursor: pointer;
            margin-bottom: 1em;
        }
        .tab {
            padding: 10px 20px;
            background: #eee;
            border: 1px solid #ccc;
            margin-right: 5px;
        }
        .tab.active {
            background: #ddd;
            font-weight: bold;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2em;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Documentos Revisados</h2>

<div class="tabs">
    <div class="tab active" data-tab="lic">Licenciaturas</div>
    <div class="tab" data-tab="pos">Posgrados</div>
    <div class="tab" data-tab="sab">Sabáticos</div>
</div>

<div id="lic" class="tab-content active">
    <h3>Documentos de Licenciatura</h3>
    <?php
    $query = "SELECT f.*, c.nombre_carrera, t.nombre_titulacion, e.nombre_estado
              FROM ficha_carreras f
              JOIN carreras c ON f.carreras = c.id_carreras
              JOIN tipo_titulacion_carrera t ON f.tipo_titulacion_carrera = t.id_tipo_titulacion
              JOIN estado_revision e ON f.estado_revision = e.id_estado
              WHERE f.estado_revision IN (2,3)";
    $res = $conectar->query($query);
    ?>
    <table>
        <tr>
            <th>Título</th><th>Autor</th><th>Carrera</th><th>Titulación</th><th>Estado</th><th>Documento</th><th>Oficio</th>
        </tr>
        <?php while($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['titulo'] ?></td>
            <td><?= $row['autor'] ?></td>
            <td><?= $row['nombre_carrera'] ?></td>
            <td><?= $row['nombre_titulacion'] ?></td>
            <td><?= $row['nombre_estado'] ?></td>
            <td><a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank">Ver</a></td>
            <td><?= $row['oficio'] ? "<a href='ver_oficio.php?archivo={$row['oficio']}' target='_blank'>Ver</a>" : "No disponible" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div id="pos" class="tab-content">
    <h3>Documentos de Posgrado</h3>
    <?php
    $query = "SELECT f.*, e.nombre_estado
              FROM ficha_posgrados f
              JOIN estado_revision e ON f.estado_revision = e.id_estado
              WHERE f.estado_revision IN (2,3)";
    $res = $conectar->query($query);
    ?>
    <table>
        <tr>
            <th>Título</th><th>Autor</th><th>Estado</th><th>Documento</th><th>Oficio</th>
        </tr>
        <?php while($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['titulo'] ?></td>
            <td><?= $row['autor'] ?></td>
            <td><?= $row['nombre_estado'] ?></td>
            <td><a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank">Ver</a></td>
            <td><?= $row['oficio'] ? "<a href='ver_oficio.php?archivo={$row['oficio']}' target='_blank'>Ver</a>" : "No disponible" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div id="sab" class="tab-content">
    <h3>Documentos de Sabáticos</h3>
    <?php
    $query = "SELECT f.*, e.nombre_estado
              FROM ficha_sabaticos f
              JOIN estado_revision e ON f.estado_revision = e.id_estado
              WHERE f.estado_revision IN (2,3)";
    $res = $conectar->query($query);
    ?>
    <table>
        <tr>
            <th>Título</th><th>Autor</th><th>Estado</th><th>Documento</th><th>Oficio</th>
        </tr>
        <?php while($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['titulo'] ?></td>
            <td><?= $row['autor'] ?></td>
            <td><?= $row['nombre_estado'] ?></td>
            <td><a href="ver_documento.php?archivo=<?= $row['documento'] ?>" target="_blank">Ver</a></td>
            <td><?= $row['oficio'] ? "<a href='ver_oficio.php?archivo={$row['oficio']}' target='_blank'>Ver</a>" : "No disponible" ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Activar tab
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Mostrar contenido correspondiente
            contents.forEach(c => c.classList.remove('active'));
            document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
        });
    });
</script>

</body>
</html>
