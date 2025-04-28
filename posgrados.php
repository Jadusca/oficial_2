<?php
include('conexion.php');

$id_posgrado = isset($_GET['posgrado']) ? intval($_GET['posgrado']) : 0;
$id_tipo = isset($_GET['tipo']) ? intval($_GET['tipo']) : 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documentos de Posgrados</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
</head>

<body>

    <?php
    include 'headerBusqueda.php';
    ?>

    <?php
    if (!$id_posgrado && !$id_tipo) {
        echo '<section class="carreras ancho">
            <div class="titulocar">
                <h1>Posgrados</h1>
            </div>
        </section>
        <div class="Opciones">';

        $posgrados = $conectar->query("SELECT * FROM posgrados");
        $count = 0;
        $grupo = [];

        while ($p = $posgrados->fetch_assoc()) {
            $grupo[] = '
            <div class="Opciones_titulacion_posgrado">
                <i class="fa-solid fa-book"></i>
                <h2>' . $p['nombre_posgrado'] . '</h2>
                <a class="hvr-sweep-to-right" href="?posgrado=' . $p['id_posgrados'] . '">Acceder</a>
            </div>';
            $count++;

            if ($count % 2 == 0 || $count == $posgrados->num_rows) {
                echo '<div class="opciones_duo_posgrado">' . implode('', $grupo) . '</div>';
                $grupo = [];
            }
        }

        echo '</div>';
    } elseif ($id_posgrado && !$id_tipo) {
        echo "<div class='echo_periodo';'><a href='posgrados.php'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo '<section class="carreras ancho">
            <div class="titulocar">
                <h1>Tipos de Titulación</h1>
            </div>
        </section>
        <div class="Opciones">';

        $tipos = $conectar->query("SELECT * FROM tipo_titulacion_posgrado");
        $count = 0;
        $grupo = [];

        while ($tipo = $tipos->fetch_assoc()) {
            $grupo[] = '
            <div class="Opciones_titulacion_posgrado">
                <i class="fa-solid fa-book"></i>
                <h2>' . $tipo['nombre_titulacion_pos'] . '</h2>
                <a class="hvr-sweep-to-right" href="?posgrado=' . $id_posgrado . '&tipo=' . $tipo['id_tipo_titulacion_pos'] . '">Acceder</a>
            </div>';
            $count++;

            if ($count % 2 == 0 || $count == $tipos->num_rows) {
                echo '<div class="opciones_duo_posgrado">' . implode('', $grupo) . '</div>';
                $grupo = [];
            }
        }

    } elseif ($id_posgrado && $id_tipo) {
        $estado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Aprobado' LIMIT 1");
        $id_aprobado = $estado->fetch_assoc()['id_estado'];

        $nombre_pos = $conectar->query("SELECT nombre_posgrado FROM posgrados WHERE id_posgrados = $id_posgrado")->fetch_assoc()['nombre_posgrado'];
        $nombre_tipo = $conectar->query("SELECT nombre_titulacion_pos FROM tipo_titulacion_posgrado WHERE id_tipo_titulacion_pos = $id_tipo")->fetch_assoc()['nombre_titulacion_pos'];

        $docs = $conectar->query("SELECT * FROM ficha_posgrados WHERE posgrados = $id_posgrado AND tipo_titulacion_posgrado = $id_tipo AND estado_revision = $id_aprobado");

        echo "<div class='echo_periodo';'><a href='?posgrado=$id_posgrado'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo "<h2 style='padding: 20px;'>Documentos disponibles en <em>$nombre_pos</em> para <em>$nombre_tipo</em>:</h2>";

        if ($docs->num_rows > 0) {
            while ($doc = $docs->fetch_assoc()) {
                echo "<div class='card'>
                    <strong>{$doc['titulo']}</strong><br>
                    <em>{$doc['autor']}</em><br><br>
                    <button class='btn' onclick=\"window.open('pdf/web/viewer.html?file=" . urlencode("../../documentos/" . rawurlencode(basename($doc['documento']))) . "', '_blank')\">📄 Ver documento</button>
                    <button class='btn' onclick=\"mostrarFicha(" . htmlspecialchars(json_encode($doc), ENT_QUOTES, 'UTF-8') . ")\">Ver ficha</button>
                </div>";
            }
        } else {
            echo "<p style='padding: 20px;'>No hay documentos aprobados para este tipo de titulación.</p>";
        }
    }
    ?>

    <!-- Modal -->
    <div id="modalFicha" class="modal"
        style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6);">
        <div class="modal-content"
            style="background-color: #fff; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 80%; max-height: 80vh; overflow-y: auto; border-radius: 5px;">
            <span class="close" onclick="cerrarModal()"
                style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
            <div id="contenidoModal"></div>
        </div>
    </div>

    <script>
        function mostrarFicha(doc) {
            let html = `
        <h3>${doc.titulo}</h3>
        <p><strong>Autor:</strong> ${doc.autor}</p>
        <p><strong>Asesor interno:</strong> ${doc.asesor_interno}</p>
        <p><strong>Asesor externo:</strong> ${doc.asesor_externo}</p>
        <p><strong>Resumen:</strong> ${doc.resumen}</p>
        <p><strong>Fecha:</strong> ${doc.fecha}</p>
        <p><strong>Palabras clave:</strong> ${doc.palabras_clave}</p>
        <p><strong>Páginas:</strong> ${doc.paginas}</p>
        <p><strong>Dimensiones:</strong> ${doc.dimensiones}</p>
    `;
            document.getElementById('contenidoModal').innerHTML = html;
            document.getElementById('modalFicha').style.display = 'block';
        }
        function cerrarModal() {
            document.getElementById('modalFicha').style.display = 'none';
        }
    </script>

    <?php
    include 'footer.php';
    ?>

</body>

</html>