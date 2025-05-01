<?php require "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Visitas por Día</title>
    <link rel="shortcut icon" href="Imagenes/Logo_ITM/Logo_ITM.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="estilosmovil.css">
    <script src="https://kit.fontawesome.com/1b0d4e5620.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="responsiveslides.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php
    include "headerSuperadmin.php";
    ?>

    <div class="edit_car">
        <div class="menu1_1">
            <a class="arrow" href="indexadmin.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2 class="tit_mod_car">Visitas por Día</h2>
    </div>

    <form class="nuevas_carreras" method="GET">
        <section>
            <label>Desde:</label> <input type="date" name="desde" required>
        </section>
        <br>
        <section>
            <label>Hasta:</label> <input type="date" name="hasta" required>
        </section>
        <br>
        <button class="mod_car" type="submit">Filtrar</button>
    </form>

    <canvas class="graphic" id="grafica"></canvas>

    <?php
    $desde = $_GET['desde'] ?? date("Y-m-01");
    $hasta = $_GET['hasta'] ?? date("Y-m-d");

    $sql = "SELECT fecha, cantidad FROM visitas WHERE fecha BETWEEN ? AND ? ORDER BY fecha";
    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("ss", $desde, $hasta);
    $stmt->execute();
    $result = $stmt->get_result();

    $fechas = [];
    $cantidades = [];

    while ($row = $result->fetch_assoc()) {
        $fechas[] = $row['fecha'];
        $cantidades[] = $row['cantidad'];
    }
    ?>

    <script>
        const etiquetas = <?= json_encode($fechas) ?>;
        const datos = <?= json_encode($cantidades) ?>;

        const ctx = document.getElementById('grafica').getContext('2d');
        const grafica = new Chart(ctx, {
            type: 'line',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Visitas por Día',
                    data: datos,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        // Convertir gráfica a imagen y enviarla al generar PDF
        function generarPDF() {
            const imagen = document.getElementById('grafica').toDataURL('image/jpeg', 1.0);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'generar_reporte_pdf.php';

            const inputDesde = document.createElement('input');
            inputDesde.type = 'hidden';
            inputDesde.name = 'desde';
            inputDesde.value = "<?= $desde ?>";

            const inputHasta = document.createElement('input');
            inputHasta.type = 'hidden';
            inputHasta.name = 'hasta';
            inputHasta.value = "<?= $hasta ?>";

            const inputImg = document.createElement('input');
            inputImg.type = 'hidden';
            inputImg.name = 'imagen';
            inputImg.value = imagen;

            form.appendChild(inputDesde);
            form.appendChild(inputHasta);
            form.appendChild(inputImg);

            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <button class="mod_car_1" onclick="generarPDF()"><i class="fa-solid fa-file-arrow-down"></i> Descargar PDF</button>

    <br></br>

    <?php
    include "footer.php";
    ?>

</body>

</html>