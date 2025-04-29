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
    <style>
        h2 {
            color: #333;
        }
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
        .btn:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<?php include 'headerBusqueda.php'; ?>

<?php
if ($id_sabatico && $id_categoria) {
    // Mostrar documentos de la categoría seleccionada
    $estado = $conectar->query("SELECT id_estado FROM estado_revision WHERE nombre_estado = 'Aprobado' LIMIT 1");
    $id_aprobado = $estado->fetch_assoc()['id_estado'];

    $nombre_sab = $conectar->query("SELECT nombre_sabatico FROM sabaticos WHERE id_sabaticos = $id_sabatico")->fetch_assoc()['nombre_sabatico'];
    $nombre_cat = $conectar->query("SELECT nombre_categoria FROM categoria_sabatico WHERE id_categoria_sab = $id_categoria")->fetch_assoc()['nombre_categoria'];

    $docs = $conectar->query("SELECT * FROM ficha_sabaticos WHERE sabaticos = $id_sabatico AND categoria_sabatico = $id_categoria AND estado_revision = $id_aprobado");

    echo "<h2>Documentos disponibles de <em>$nombre_sab</em> en la categoría <em>$nombre_cat</em>:</h2>";

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
        echo "<p>No hay documentos aprobados en esta categoría.</p>";
    }

    echo "<p><a href='?sabatico=$id_sabatico'>← Volver a categorías</a></p>";

} elseif ($id_sabatico) {
    // Mostrar categorías de un sabático
    $nombre_sab = $conectar->query("SELECT nombre_sabatico FROM sabaticos WHERE id_sabaticos = $id_sabatico")->fetch_assoc()['nombre_sabatico'];
    echo "<h2>Categorías de <em>$nombre_sab</em>:</h2>";

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
        echo "</div>"; // Cierra último duo sabatico
    } else {
        echo "<p>No hay categorías registradas para este sabático.</p>";
    }
    echo "</div>"; // Cierra Opciones

    echo "<p><a href='sabaticos.php'>← Volver a sabáticos</a></p>";

} else {
    // Mostrar todos los sabáticos
    echo "<h2>Sabáticos:</h2>";

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
        echo "</div>"; // Cierra último duo sabatico
    } else {
        echo "<p>No hay sabáticos registrados.</p>";
    }
    echo "</div>"; // Cierra Opciones
}
?>

<!-- Modal -->
<div id="modalFicha" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <div id="contenidoModal"></div>
    </div>
</div>

<script>
function mostrarFicha(doc) {
    let html = `
        <h3>${doc.titulo}</h3>
        <p><strong>Autor:</strong> ${doc.autor}</p>
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

<br><br>

<?php include 'footer.php'; ?>

</body>
</html>
