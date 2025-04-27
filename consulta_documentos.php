<?php
require "conexion.php";

function consultar($tabla, $joins = "", $campos_extra = "") {
    global $conectar;

    $where = "1=1";
    $params = [];
    $types = "";

    if (!empty($_GET["autor"])) {
        $where .= " AND $tabla.autor LIKE ?";
        $params[] = "%" . $_GET["autor"] . "%";
        $types .= "s";
    }

    if (!empty($_GET["palabras_clave"])) {
        $where .= " AND $tabla.palabras_clave LIKE ?";
        $params[] = "%" . $_GET["palabras_clave"] . "%";
        $types .= "s";
    }

    if (!empty($_GET["fecha"])) {
        $where .= " AND $tabla.fecha = ?";
        $params[] = $_GET["fecha"];
        $types .= "s";
    }

    $sql = "SELECT $tabla.*, estado_revision.nombre_estado $campos_extra FROM $tabla
            JOIN estado_revision ON $tabla.estado_revision = estado_revision.id_estado
            $joins
            WHERE $where AND estado_revision.nombre_estado = 'Aprobado'
            ORDER BY $tabla.fecha DESC";

    $stmt = $conectar->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Documentos</title>
    <style>
        .tab { display: none; }
        .tab.active { display: block; }
        button { margin: 5px; }

        #modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        #modal {
            position: fixed;
            top: 10%; left: 50%;
            transform: translateX(-50%);
            width: 60%;
            max-height: 80%;
            overflow-y: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #000;
            z-index: 1000;
        }

        #modal-content p {
            margin: 5px 0;
        }

        #modal-close {
            float: right;
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
    function mostrarTab(id) {
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.getElementById(id).classList.add('active');
    }

    function mostrarDetalle(data) {
        const ocultos = [
            'estado_revision', 'oficio', 'documento',
            'carreras', 'tipo_titulacion_carrera',
            'tipo_titulacion_posgrado', 'posgrados',
            'sabaticos', 'categoria_sabatico',
            'nombre_estado', 'Carrera', 'Tipo Titulación', 'Posgrado'
        ];

        const traducciones = {
            titulo: 'Título',
            autor: 'Autor',
            fecha: 'Fecha',
            palabras_clave: 'Palabras Clave',
            nombre_carrera: 'Carrera',
            nombre_titulacion: 'Tipo de Titulación',
            nombre_posgrado: 'Posgrado',
            nombre_titulacion_pos: 'Tipo de Titulación',
            nombre_sabatico: 'Sabático',
            nombre_categoria: 'Categoría',
            resumen: 'Resumen',
            paginas: 'Páginas',
            dimensiones: 'Dimensiones',
            asesor_interno: 'Asesor Interno',
            asesor_externo: 'Asesor Externo'
        };

        let contenido = "";

        for (let key in data) {
            if (
                key.startsWith("id_") ||
                key.endsWith("_id") ||
                ocultos.includes(key)
            ) continue;

            const label = traducciones[key] || key.replaceAll('_', ' ');
            contenido += `<p><strong>${label}</strong>: ${data[key]}</p>`;
        }

        document.getElementById('modal-content').innerHTML = contenido;
        document.getElementById('modal-overlay').style.display = 'block';
    }


    function cerrarModal() {
        document.getElementById('modal-overlay').style.display = 'none';
    }
    </script>
</head>
<body>

<h1>Panel de Consulta</h1>

<button onclick="mostrarTab('lic')">Licenciaturas</button>
<button onclick="mostrarTab('pos')">Posgrados</button>
<button onclick="mostrarTab('sab')">Sabáticos</button>

<form method="GET">
    <label>Autor: <input type="text" name="autor" value="<?= htmlspecialchars($_GET['autor'] ?? '') ?>"></label>
    <label>Palabra clave: <input type="text" name="palabras_clave" value="<?= htmlspecialchars($_GET['palabras_clave'] ?? '') ?>"></label>
    <label>Fecha: <input type="date" name="fecha" value="<?= htmlspecialchars($_GET['fecha'] ?? '') ?>"></label>
    <input type="submit" value="Buscar">
</form>

<div id="lic" class="tab active">
    <h2>Documentos de Licenciatura</h2>
    <table border="1">
        <tr><th>Título</th><th>Autor</th><th>Fecha</th><th>Carrera</th><th>Titulación</th><th>Documento</th><th>Ficha</th></tr>
        <?php
        $joins = "
            JOIN tipo_titulacion_carrera ON ficha_carreras.tipo_titulacion_carrera = tipo_titulacion_carrera.id_tipo_titulacion
            JOIN carreras ON ficha_carreras.carreras = carreras.id_carreras";
        $campos_extra = ", tipo_titulacion_carrera.nombre_titulacion, carreras.nombre_carrera";
        $result = consultar("ficha_carreras", $joins, $campos_extra);
        while ($row = $result->fetch_assoc()) {
            $row['Tipo Titulación'] = $row['nombre_titulacion'];
            $row['Carrera'] = $row['nombre_carrera'];
            echo "<tr>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['nombre_carrera']}</td>
                    <td>{$row['nombre_titulacion']}</td>
                    <td><a href='{$row['documento']}' target='_blank'>Ver</a></td>
                    <td><button onclick='mostrarDetalle(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ")'>Ver ficha</button></td>
                </tr>";
        }
        ?>
    </table>
</div>

<div id="pos" class="tab">
    <h2>Documentos de Posgrado</h2>
    <table border="1">
        <tr><th>Título</th><th>Autor</th><th>Fecha</th><th>Posgrado</th><th>Titulación</th><th>Documento</th><th>Ficha</th></tr>
        <?php
        $joins = "JOIN tipo_titulacion_posgrado ON ficha_posgrados.tipo_titulacion_posgrado = tipo_titulacion_posgrado.id_tipo_titulacion_pos
                  JOIN posgrados ON ficha_posgrados.posgrados = posgrados.id_posgrados";
        $campos_extra = ", tipo_titulacion_posgrado.nombre_titulacion_pos, posgrados.nombre_posgrado";
        $result = consultar("ficha_posgrados", $joins, $campos_extra);
        while ($row = $result->fetch_assoc()) {
            $row['Tipo Titulación'] = $row['nombre_titulacion_pos'];
            $row['Posgrado'] = $row['nombre_posgrado'];
            echo "<tr>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['nombre_posgrado']}</td>
                    <td>{$row['nombre_titulacion_pos']}</td>
                    <td><a href='{$row['documento']}' target='_blank'>Ver</a></td>
                    <td><button onclick='mostrarDetalle(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ")'>Ver ficha</button></td>
                </tr>";
        }
        ?>
    </table>
</div>

<div id="sab" class="tab">
    <h2>Documentos Sabáticos</h2>
    <table border="1">
        <tr><th>Título</th><th>Autor</th><th>Fecha</th><th>Sabático</th><th>Categoría</th><th>Documento</th><th>Ficha</th></tr>
        <?php
        $joins = "JOIN categoria_sabatico ON ficha_sabaticos.categoria_sabatico = categoria_sabatico.id_categoria_sab
                JOIN sabaticos ON ficha_sabaticos.sabaticos = sabaticos.id_sabaticos";
        $campos_extra = ", categoria_sabatico.nombre_categoria, sabaticos.nombre_sabatico";
        $result = consultar("ficha_sabaticos", $joins, $campos_extra);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['titulo']}</td>
                    <td>{$row['autor']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['nombre_sabatico']}</td>
                    <td>{$row['nombre_categoria']}</td>
                    <td><a href='{$row['documento']}' target='_blank'>Ver</a></td>
                    <td><button onclick='mostrarDetalle(" . json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ")'>Ver ficha</button></td>
                </tr>";
        }
        ?>
    </table>
</div>


<div id="modal-overlay">
    <div id="modal">
        <span id="modal-close" onclick="cerrarModal()">[Cerrar]</span>
        <div id="modal-content"></div>
    </div>
</div>

</body>
</html>
