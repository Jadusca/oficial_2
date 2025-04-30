<?php require "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visitas por Día</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Visitas por Día</h2>

<form method="GET">
    Desde: <input type="date" name="desde" required>
    Hasta: <input type="date" name="hasta" required>
    <button type="submit">Filtrar</button>
</form>

<canvas id="grafica" width="600" height="300"></canvas>

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

<button onclick="generarPDF()">📄 Descargar PDF</button>

</body>
</html>
