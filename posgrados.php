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
        echo '<br></br>';
        echo '<div class="periodos_flecha"><a href="index.php" class="periodos"><i class="fa-solid fa-arrow-left"></i></a>
    </div>';
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

        // Paginación
        $por_pagina = 20;
        $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $offset = ($pagina_actual - 1) * $por_pagina;

        // Total de resultados
        $resultado_total = $conectar->query("SELECT COUNT(*) AS total FROM ficha_posgrados WHERE posgrados = $id_posgrado AND tipo_titulacion_posgrado = $id_tipo AND estado_revision = $id_aprobado");
        $total_filas = $resultado_total->fetch_assoc()['total'];
        $total_paginas = ceil($total_filas / $por_pagina);

        $docs = $conectar->query("
            SELECT fp.*, p.nombre_posgrado, ttp.nombre_titulacion_pos
            FROM ficha_posgrados fp
            JOIN posgrados p ON fp.posgrados = p.id_posgrados
            JOIN tipo_titulacion_posgrado ttp ON fp.tipo_titulacion_posgrado = ttp.id_tipo_titulacion_pos
            WHERE fp.posgrados = $id_posgrado AND fp.tipo_titulacion_posgrado = $id_tipo AND fp.estado_revision = $id_aprobado
            LIMIT $por_pagina OFFSET $offset
        ");

        echo "<div class='echo_periodo'><a href='?posgrado=$id_posgrado'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo "<h2 class='documentos_disponibles'>Documentos disponibles</h2>";

        if ($docs->num_rows > 0) {
            while ($doc = $docs->fetch_assoc()) {
                echo "<div class='doc_disp'>
                    <div class='titulo_autor'>
                        <strong>{$doc['titulo']}</strong><br>
                        <p>{$doc['autor']}</p>
                    </div><br>
                    <div class='nombre_carrera'><em>{$doc['nombre_posgrado']} | {$doc['nombre_titulacion_pos']}</em></div><br>
                    <button class='pdf' onclick=\"window.open('pdf/web/viewer.html?file=" . urlencode("../../documentos/" . rawurlencode(basename($doc['documento']))) . "', '_blank')\">
                        <i class='fa-solid fa-file-invoice'></i> Ver documento
                    </button>
                    <button class='view_ficha' onclick=\"mostrarFicha(" . htmlspecialchars(json_encode($doc), ENT_QUOTES, 'UTF-8') . ")\">
                        <i class='fa-solid fa-magnifying-glass'></i> Ver ficha
                    </button>
                </div>";
            }

            // Navegación con íconos y estilo
            echo "<div class='paginacion'>";

            // Botón "Anterior"
            if ($pagina_actual > 1) {
                $prev = $pagina_actual - 1;
                echo "<a class='pagina' href='?posgrado=$id_posgrado&tipo=$id_tipo&pagina=$prev'><i class='fa-solid fa-angle-left'></i></a>";
            }

            // Números de página
            for ($i = 1; $i <= $total_paginas; $i++) {
                $clase = ($i == $pagina_actual) ? "pagina pagina-activa" : "pagina";
                echo "<a class='$clase' href='?posgrado=$id_posgrado&tipo=$id_tipo&pagina=$i'>$i</a>";
            }

            // Botón "Siguiente"
            if ($pagina_actual < $total_paginas) {
                $next = $pagina_actual + 1;
                echo "<a class='pagina' href='?posgrado=$id_posgrado&tipo=$id_tipo&pagina=$next'><i class='fa-solid fa-angle-right'></i></a>";
            }

            echo "</div>";

        } else {
            echo "<p style='padding: 20px;'>No hay documentos aprobados para este tipo de titulación.</p>";
        }
    }
    ?>

    <!-- Modal -->
    <div id="modalFicha" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="contenidoModal"></div>
        </div>
    </div>

    <style>
        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            /* top: 0; left: 0; bottom: 0; right: 0; simplificado */
            background-color: rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

        /* Centrar el contenido */
        .modal-content {
            background-color: #fff;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 30px;
            border-radius: 8px;
            max-width: 700px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Botón cerrar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Al pasar el mouse */
        .close:hover {
            color: #000;
        }

        /* Cuando el modal está abierto, desactivar scroll en body */
        body.modal-open {
            overflow: hidden;
        }
    </style>

    <script>
        function mostrarFicha(doc) {
            let html = `
        <div class="ficha">
            <h3>${doc.titulo}</h3>
            <p><strong>Autor:</strong> ${doc.autor}</p>
            <p><strong>Asesor interno:</strong> ${doc.asesor_interno}</p>
            <p><strong>Asesor externo:</strong> ${doc.asesor_externo}</p>
            <p><strong>Resumen:</strong> ${doc.resumen}</p>
            <p><strong>Fecha:</strong> ${doc.fecha}</p>
            <p><strong>Palabras clave:</strong> ${doc.palabras_clave}</p>
            <p><strong>Páginas:</strong> ${doc.paginas}</p>
            <p><strong>Dimensiones:</strong> ${doc.dimensiones}</p>
        </div>
    `;
            document.getElementById('contenidoModal').innerHTML = html;
            document.getElementById('modalFicha').style.display = 'block';
            document.body.classList.add('modal-open');
        }

        function cerrarModal() {
            document.getElementById('modalFicha').style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    </script>

    <br><br>

    <?php
    include 'footer-index.php';
    ?>

</body>

</html>