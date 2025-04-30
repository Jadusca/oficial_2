<?php
include('conexion.php');

// Parámetros
$id_sabatico = isset($_GET['sabatico']) ? intval($_GET['sabatico']) : 0;
$id_categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Documentos Sabáticos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <style>
        h2 { color: #333; }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn:hover { background-color: #0056b3; }

        a { text-decoration: none; color: #007BFF; }

        a:hover { text-decoration: underline; }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

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
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus { color: #000; text-decoration: none; }

        body.modal-open { overflow: hidden; }

        .paginacion {
          text-align: center;
          margin: 40px auto 20px auto;
          padding-bottom: 20px;
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 6px;
        }

        .paginacion .pagina {
          display: inline-block;
          padding: 6px 14px;
          background-color: #f0f0f0;
          color: #333;
          text-decoration: none;
          border-radius: 5px;
          font-weight: 500;
          transition: all 0.2s ease-in-out;
        }

        .paginacion .pagina:hover {
          background-color: #ccc;
          color: black;
        }

        .paginacion .pagina-activa {
          background-color: #003568;
          color: white;
          font-weight: bold;
        }
    </style>
</head>

<body>

    <?php
    include "registrar_visita.php";
    include 'headerBusqueda.php'; ?>

    <?php

    if ($id_sabatico && $id_categoria) {
        $estado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Aprobado' LIMIT 1");
        $id_aprobado = $estado->fetch_assoc()['id_estado'];

        $nombre_sab = $conectar->query("SELECT nombre_sabatico FROM sabaticos WHERE id_sabaticos = $id_sabatico")->fetch_assoc()['nombre_sabatico'];
        $nombre_cat = $conectar->query("SELECT nombre_categoria FROM categoria_sabatico WHERE id_categoria_sab = $id_categoria")->fetch_assoc()['nombre_categoria'];

        echo "<br><br>";
        echo "<div class='periodos_flecha'><a href='?sabatico=$id_sabatico'><i class='fa-solid fa-arrow-left'></i></a></div>";
        echo "<h2 class='tit_doc_posg'>Documentos disponibles:</h2>";

        $por_pagina = 6;
        $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        $inicio = ($pagina_actual - 1) * $por_pagina;

        $total_resultado = $conectar->query("SELECT COUNT(*) as total FROM ficha_sabaticos WHERE sabaticos = $id_sabatico AND categoria_sabatico = $id_categoria AND estado_revision = $id_aprobado");
        $total_filas = $total_resultado->fetch_assoc()['total'];
        $total_paginas = ceil($total_filas / $por_pagina);

        $docs = $conectar->query("
            SELECT fs.*, s.nombre_sabatico, cs.nombre_categoria
            FROM ficha_sabaticos fs
            JOIN sabaticos s ON fs.sabaticos = s.id_sabaticos
            JOIN categoria_sabatico cs ON fs.categoria_sabatico = cs.id_categoria_sab
            WHERE fs.sabaticos = $id_sabatico
            AND fs.categoria_sabatico = $id_categoria
            AND fs.estado_revision = $id_aprobado
            LIMIT $inicio, $por_pagina
        ");

        if ($docs->num_rows > 0) {
            while ($doc = $docs->fetch_assoc()) {
                echo "<div class='doc_disp'>
                    <div class='titulo_autor'><strong>{$doc['titulo']}</strong><br>
                    <p>{$doc['autor']}</p></div><br>
                    <div class='nombre_carrera'><em>{$doc['nombre_sabatico']} | {$doc['nombre_categoria']}</em></div><br>
                    <button class='pdf' onclick=\"window.open('pdf/web/viewer.html?file=" . urlencode("../../documentos/" . rawurlencode(basename($doc['documento']))) . "', '_blank')\"><i class='fa-solid fa-file-invoice'></i> Ver documento</button>
                    <button class='view_ficha' onclick=\"mostrarFicha(" . htmlspecialchars(json_encode($doc), ENT_QUOTES, 'UTF-8') . ")\"><i class='fa-solid fa-magnifying-glass'></i> Ver ficha</button>
                </div>";
            }

            echo "<div class='paginacion'>";
            if ($pagina_actual > 1) {
                echo "<a class='pagina' href='?sabatico=$id_sabatico&categoria=$id_categoria&pagina=" . ($pagina_actual - 1) . "'>&laquo; Anterior</a>";
            }
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($i == $pagina_actual) {
                    echo "<span class='pagina pagina-activa'>$i</span>";
                } else {
                    echo "<a class='pagina' href='?sabatico=$id_sabatico&categoria=$id_categoria&pagina=$i'>$i</a>";
                }
            }
            if ($pagina_actual < $total_paginas) {
                echo "<a class='pagina' href='?sabatico=$id_sabatico&categoria=$id_categoria&pagina=" . ($pagina_actual + 1) . "'>Siguiente &raquo;</a>";
            }
            echo "</div>";
        } else {
            echo "<div class='mensaje'>No hay documentos aprobados en esta categoría.</div>";
        }

    } elseif ($id_sabatico) {
        echo '<br><br>';
        echo "<div class='periodos_flecha'><a href='sabaticos.php'><i class='fa-solid fa-arrow-left'></i></a></div>";
        $nombre_sab = $conectar->query("SELECT nombre_sabatico FROM sabaticos WHERE id_sabaticos = $id_sabatico")->fetch_assoc()['nombre_sabatico'];
        echo "<h2 class='tit_doc_posg'>Categorías de <em>$nombre_sab</em>:</h2>";

        echo "<div class='Opciones'>";
        $categorias = $conectar->query("SELECT * FROM categoria_sabatico WHERE sabaticos = $id_sabatico");
        $contador = 0;

        if ($categorias->num_rows > 0) {
            echo "<div class='opciones_duo_sabatico'>";
            while ($cat = $categorias->fetch_assoc()) {
                echo "<div class='Opciones_titulacion_sabatico'>
                    <i class='fa-solid fa-book-open-reader'></i>
                    <h2>{$cat['nombre_categoria']}</h2>
                    <a class='hvr-sweep-to-right' href='?sabatico=$id_sabatico&categoria={$cat['id_categoria_sab']}'>Acceder</a>
                </div>";
                $contador++;

                if ($contador % 2 == 0 && $contador != $categorias->num_rows) {
                    echo "</div><div class='opciones_duo_sabatico'>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>No hay categorías registradas para este sabático.</p>";
        }
        echo "</div>";

    } else {
        echo '<br></br>';
        echo '<div class="periodos_flecha"><a href="index.php" class="periodos"><i class="fa-solid fa-arrow-left"></i></a></div>';
        echo "<div class='Opciones'>";
        $sabaticos = $conectar->query("SELECT * FROM sabaticos");
        $contador = 0;

        if ($sabaticos->num_rows > 0) {
            echo "<div class='opciones_duo_sabatico'>";
            while ($sab = $sabaticos->fetch_assoc()) {
                echo "<div class='Opciones_titulacion_sabatico'>
                    <i class='fa-solid fa-book-open-reader'></i>
                    <h2>{$sab['nombre_sabatico']}</h2>
                    <a class='hvr-sweep-to-right' href='?sabatico={$sab['id_sabaticos']}'>Acceder</a>
                </div>";
                $contador++;

                if ($contador % 2 == 0 && $contador != $sabaticos->num_rows) {
                    echo "</div><div class='opciones_duo_sabatico'>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>No hay sabáticos registrados.</p>";
        }
        echo "</div>";
    }
    ?>

    <div id="modalFicha" class="modal" onclick="cerrarModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="contenidoModal"></div>
        </div>
    </div>

    <script>
    function mostrarFicha(doc) {
        let html = `
            <div class="ficha">
                <h3>${doc.titulo}</h3>
                <p><strong>Autor:</strong> ${doc.autor}</p>
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

    function cerrarModal(event) {
        if (!event || event.target.classList.contains('modal')) {
            document.getElementById('modalFicha').style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    }
    </script>

    <br><br>

    <?php include 'footer-index.php'; ?>

</body>

</html>
