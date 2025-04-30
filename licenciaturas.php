<?php
include('conexion.php');

$id_periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 0;
$id_carrera = isset($_GET['carrera']) ? intval($_GET['carrera']) : 0;
$id_tipo = isset($_GET['tipo']) ? intval($_GET['tipo']) : 0;
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documentos por Carrera</title>
    <script src="funciones.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <style>
        /* body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #444; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 5px; width: 250px; }
        button { padding: 5px 10px; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; } */

        /* Modal */
        #modalFicha {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #modalFicha .contenido {
            background: #fff;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 8px;
            position: relative;
        }

        #modalFicha .cerrar {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <?php
    include "registrar_visita.php";
    include 'headerBusqueda.php';
    ?>

    <div id="subir" class="flecha">
        <i class="fa-solid fa-angle-up"></i>
    </div>

    <?php
    if ($id_periodo && $id_carrera && $id_tipo) {
    $estado_resultado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Aprobado' LIMIT 1");
    $estado_aprobado = $estado_resultado->fetch_assoc()['id_estado'];

    $por_pagina = 20;
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
    if ($pagina < 1) $pagina = 1;
    $inicio = ($pagina - 1) * $por_pagina;

    // Total de documentos aprobados
    $total_resultado = $conectar->query("SELECT COUNT(*) AS total 
        FROM ficha_carreras 
        WHERE carreras = $id_carrera 
        AND tipo_titulacion_carrera = $id_tipo 
        AND estado_revision = $estado_aprobado");
    $total_filas = $total_resultado->fetch_assoc()['total'];
    $total_paginas = ceil($total_filas / $por_pagina);

    // Documentos paginados
    $docs = $conectar->query("SELECT f.*, c.nombre_carrera, t.nombre_titulacion
        FROM ficha_carreras f
        JOIN carreras c ON f.carreras = c.id_carreras
        JOIN tipo_titulacion_carrera t ON f.tipo_titulacion_carrera = t.id_tipo_titulacion
        WHERE f.carreras = $id_carrera
        AND f.tipo_titulacion_carrera = $id_tipo
        AND f.estado_revision = $estado_aprobado
        LIMIT $inicio, $por_pagina");

    echo "<div class='echo_periodo'><a href='?periodo=$id_periodo&carrera=$id_carrera'><i class='fa-solid fa-arrow-left'></i></a></div>";
    echo "<h2 class='documentos_disponibles'>Documentos disponibles:</h2>";

    if ($docs->num_rows > 0) {
        while ($doc = $docs->fetch_assoc()) {
            echo "<div class='doc_disp'>
                <div class='titulo_autor'>
                    <strong>{$doc['titulo']}</strong><br> {$doc['autor']}
                </div><br>
                <div class='nombre_carrera'><em>{$doc['nombre_carrera']} | {$doc['nombre_titulacion']}</em></div><br>";
            $nombreArchivo = rawurlencode(basename($doc['documento']));
            $ruta = "../../documentos/$nombreArchivo";
            echo "<a class='pdf' href='pdf/web/viewer.html?file=" . htmlspecialchars($ruta) . "' target='_blank'><i class='fa-solid fa-file-invoice'></i> Ver documento</a>";
            echo "<a class='view_ficha' href='javascript:void(0)' onclick='verFicha({$doc['id_ficha_carrera']})'><i class='fa-solid fa-magnifying-glass'></i> Ver ficha</a>
            </div>";
        }

        // Paginación
        echo "<div class='paginacion'>";
        if ($pagina > 1) {
            $prev = $pagina - 1;
            echo "<a class='pagina' href='?periodo=$id_periodo&carrera=$id_carrera&tipo=$id_tipo&pagina=$prev'>&laquo; Anterior</a>";
        }

        for ($i = 1; $i <= $total_paginas; $i++) {
            $clase = ($i == $pagina) ? "pagina-activa" : "";
            echo "<a class='pagina $clase' href='?periodo=$id_periodo&carrera=$id_carrera&tipo=$id_tipo&pagina=$i'>$i</a>";
        }

        if ($pagina < $total_paginas) {
            $next = $pagina + 1;
            echo "<a class='pagina' href='?periodo=$id_periodo&carrera=$id_carrera&tipo=$id_tipo&pagina=$next'>Siguiente &raquo;</a>";
        }
        echo "</div>";
    } else {
        echo "<div class='mensaje'>No hay documentos aprobados para esta combinación.</div>";
    }

    } elseif ($id_periodo && $id_carrera) {
        // Obtener nombre de la carrera
        $nombreCarrera = '';
        $carreraRes = $conectar->query("SELECT nombre_carrera FROM carreras WHERE id_carreras = $id_carrera LIMIT 1");
        if ($carreraFila = $carreraRes->fetch_assoc()) {
            $nombreCarrera = $carreraFila['nombre_carrera'];
        }

        echo "<div class='echo_periodo';'><a href='?periodo=$id_periodo' class='periodos'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo "<h1 id='subir' class='Opc_Tit'>Opciones de Titulación $nombreCarrera</h1>";
        echo "<div class='Opciones'>";

        $tipos = $conectar->query("SELECT id_tipo_titulacion, nombre_titulacion, descripcion_titulacion FROM tipo_titulacion_carrera WHERE periodo_carrera = $id_periodo");
        $contador = 0;

        while ($tipo = $tipos->fetch_assoc()) {
            if ($contador % 2 == 0)
                echo "<div class='opciones_duo'>"; // inicia fila

            $idTipo = $tipo['id_tipo_titulacion'];
            $nombre = $tipo['nombre_titulacion'];
            $descripcion = $tipo['descripcion_titulacion'];

            echo "<div class='Opciones_titulacion'>
                <i class='fa-solid fa-laptop-file'></i>
                <h2>$nombre</h2>
                <p>$descripcion</p>
                <a class='hvr-sweep-to-right' href='?periodo=$id_periodo&carrera=$id_carrera&tipo=$idTipo'>Acceder</a>
            </div>";

            $contador++;
            if ($contador % 2 == 0)
                echo "</div>"; // cierra fila
        }

        if ($contador % 2 != 0)
            echo "</div>"; // cierre por si hay impar
    
        echo "</div>";

    } elseif ($id_periodo) {
        echo "<div class='echo_periodo';'><a href='licenciaturas.php' class='periodos'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo '<section class="carreras ancho">
            <div class="titulocar">
                <h1>Carreras</h1>
            </div>
            <div class="viewport2">
                <ul class="overview2">';

        $carreras = $conectar->query("SELECT * FROM carreras WHERE periodo_carrera = $id_periodo");
        $hay_resultados = false;

        while ($carrera = $carreras->fetch_assoc()) {
            if ($buscar === '' || stripos($carrera['nombre_carrera'], $buscar) !== false) {
                $nombre = $carrera['nombre_carrera'];
                $logo = "../../oficial_2/logos/" . $carrera['logo_carrera'];
                $id = $carrera['id_carreras'];

                echo "<a href='?periodo=$id_periodo&carrera=$id'>
                    <div class='cardcarreras'>
                        <div class='logocar'>
                            <figure><img src='$logo' alt='Logo de $nombre' onerror=\"this.onerror=null;this.src='../../oficial_2/logos/default.png';\"></figure>
                        </div>
                        <h1>$nombre</h1>
                        <div class='fondo'></div>
                    </div>
                </a>";
                $hay_resultados = true;
            }
        }

        if (!$hay_resultados) {
            echo "<p style='margin: 20px;'>No se encontraron carreras con ese término.</p>";
        }

        echo '</ul></div>';
        echo '</section>';

    } else {
        echo '<section class="periodos" id="periodosContainer">';
        echo '<div class="periodos_flecha"><a href="index.php" class="periodos"><i class="fa-solid fa-arrow-left"></i></a></div>';
        $periodos = $conectar->query("SELECT * FROM periodo_carrera");
        $contador = 0;
        echo '<div class="partes">';
        while ($periodo = $periodos->fetch_assoc()) {
            $id = htmlspecialchars($periodo['id_periodo_carrera']);
            $anio = htmlspecialchars($periodo['anio_periodo']);
            $contador++;

            echo "<a href='?periodo=$id' class='periodo_$contador'>
                <div class='primero' data-period-id='periodo$id' data-input-id='inputPeriodo$id'>
                    <h1 id='periodo$id' oncontextmenu='return false;'>$anio</h1>
                </div>
            </a>";

            // Divide el grupo en dos bloques visuales como en tu maqueta
            if ($contador == 2) {
                echo '</div><br><br><br><br><div class="partes partes1">';
            }
        }
        echo '</div>'; // Cierre del último bloque de .partes
        echo '</section>';
    }
    ?>

    <!-- Modal -->
    <div id="modalFicha">
        <div class="contenido">
            <span class="cerrar" onclick="cerrarModal()">✖️</span>
            <div id="contenidoFicha">Cargando ficha...</div>
        </div>
    </div>

    <script>
        function verFicha(id) {
            const modal = document.getElementById("modalFicha");
            const contenido = document.getElementById("contenidoFicha");

            modal.style.display = "flex";
            contenido.innerHTML = "Cargando ficha...";

            fetch("ver_ficha_ajax.php?id=" + id)
                .then(res => res.text())
                .then(html => {
                    contenido.innerHTML = html;
                })
                .catch(() => {
                    contenido.innerHTML = "Error al cargar la ficha.";
                });
        }

        function cerrarModal() {
            document.getElementById("modalFicha").style.display = "none";
        }
    </script>
    <br>
    <?php
    include 'footer-index.php';
    ?>

</body>

</html>