<?php
require "conexion.php";

// Obtener opciones para los selects
$carreras = $conectar->query("SELECT * FROM carreras");
$periodos = $conectar->query("SELECT * FROM periodo_carrera");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Ficha de Carrera</title>
    <script>
        document.querySelector("form").addEventListener("submit", function (e) {
            const documentoInput = document.querySelector('input[name="documento"]');
            const oficioInput = document.querySelector('input[name="oficio"]');

            const documentoFile = documentoInput.files[0];
            const oficioFile = oficioInput.files[0];

            // Verificar si se seleccionó ambos archivos
            if (!documentoFile) {
                alert("Por favor, selecciona un documento PDF.");
                documentoInput.focus();
                e.preventDefault();
                return;
            }

            if (!oficioFile) {
                alert("Por favor, selecciona un archivo PDF de oficio.");
                oficioInput.focus();
                e.preventDefault();
                return;
            }

            // Verificar que sean archivos PDF
            if (documentoFile.type !== "application/pdf") {
                alert("El documento debe ser un archivo PDF.");
                documentoInput.focus();
                e.preventDefault();
                return;
            }

            if (oficioFile.type !== "application/pdf") {
                alert("El oficio debe ser un archivo PDF.");
                oficioInput.focus();
                e.preventDefault();
                return;
            }
        });
    </script>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
</head>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <br><br>

    <h2 class="tit_lic">Subir documento de licenciatura</h2>
    <form class="form_lic" action="procesar_ficha_carrera.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <input type="text" name="titulo" placeholder="Introduzca el título" required></input><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor"
            placeholder="Introduzca el nombre del autor(es) (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Asesor Interno:</label><br>
        <input type="text" name="asesor_interno"
            placeholder="Introduzca el nombre del asesor interno (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Asesor Externo:</label><br>
        <input type="text" name="asesor_externo"
            placeholder="Introduzca el nombre del asesor externo (Formato: Apellidos, Nombres. Ej. Pérez Domínguez, José Alberto)"
            required><br><br>

        <label>Palabras clave:</label><br>
        <input type="text" name="palabras_clave" placeholder="Introduzca las palabras claves del documento."
            required><br><br>

        <label>Resumen:</label><br>
        <textarea name="resumen" placeholder="Introduzca el resumen del documento" required></textarea><br><br>

        <label>Fecha del documento:</label><br>
        <input type="date" name="fecha" required><br><br>

        <label>Páginas:</label><br>
        <input type="text" name="paginas" placeholder="Introduce UNICAMENTE el número de páginas" required><br><br>

        <label>Dimensiones:</label><br>
        <input type="text" name="dimensiones" placeholder="Introduce las dimensiones del documento, ejemplo (50 x 50)" required><br><br>

        <label>Periodo:</label><br>
        <select name="periodo_id" id="periodo_id" required>
            <option value="">Selecciona un periodo</option>
            <?php while ($row = $periodos->fetch_assoc()): ?>
                <option value="<?= $row['id_periodo_carrera'] ?>"><?= htmlspecialchars($row['anio_periodo']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Carrera:</label><br>
        <select name="carrera_id" id="carrera_id" required>
            <option value="">Selecciona primero un periodo</option>
        </select><br><br>

        <label>Tipo de Titulación:</label><br>
        <select name="tipo_titulacion_id" id="tipo_titulacion_id" required>
            <option value="">Selecciona primero un periodo</option>
        </select><br><br>

        <label>Documento PDF:</label><br>
        <input class="file" type="file" name="documento" accept="application/pdf" required><br>
        <span id="nombreDocumento"></span><br>

        <label>Oficio PDF:</label><br>
        <input class="file" type="file" name="oficio" accept="application/pdf" required><br>
        <span id="nombreOficio"></span><br><br>

        <input class="enviar_doc" type="submit" value="Subir documento">
    </form>

    <script>
        document.getElementById('periodo_id').addEventListener('change', function () {
            const periodoId = this.value;
            const tipoTitulacionSelect = document.getElementById('tipo_titulacion_id');

            tipoTitulacionSelect.innerHTML = '<option>Cargando...</option>';

            fetch('obtener_titulaciones_por_periodo.php?periodo_id=' + periodoId)
                .then(response => response.json())
                .then(data => {
                    tipoTitulacionSelect.innerHTML = '<option value="">Selecciona un tipo</option>';
                    data.forEach(titulacion => {
                        const option = document.createElement('option');
                        option.value = titulacion.id_tipo_titulacion;
                        option.textContent = titulacion.nombre_titulacion;
                        tipoTitulacionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    tipoTitulacionSelect.innerHTML = '<option>Error al cargar</option>';
                    console.error(error);
                });
        });

        document.getElementById('periodo_id').addEventListener('change', function () {
            const periodoId = this.value;
            const CarreraSelect = document.getElementById('carrera_id');

            CarreraSelect.innerHTML = '<option>Cargando...</option>';

            fetch('obtener_carreras_por_periodo.php?periodo_id=' + periodoId)
                .then(response => response.json())
                .then(data => {
                    CarreraSelect.innerHTML = '<option value="">Selecciona una carrera</option>';
                    data.forEach(carrera => {
                        const option = document.createElement('option');
                        option.value = carrera.id_carreras;
                        option.textContent = carrera.nombre_carrera;
                        CarreraSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    CarreraSelect.innerHTML = '<option>Error al cargar</option>';
                    console.error(error);
                });
        });
    </script>

    <br><br>

    <?php
    include "footer.php";
    ?>

</body>

</html>