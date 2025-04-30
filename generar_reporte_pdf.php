<?php
require "conexion.php";
require_once "tcpdf/tcpdf.php";

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$imagenBase64 = $_POST['imagen'];

// Consultar base de datos
$sql = "SELECT fecha, cantidad FROM visitas WHERE fecha BETWEEN ? AND ? ORDER BY fecha";
$stmt = $conectar->prepare($sql);
$stmt->bind_param("ss", $desde, $hasta);
$stmt->execute();
$result = $stmt->get_result();

// Crear PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema');
$pdf->SetTitle('Reporte de Visitas');
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Contenido HTML
$html = "<h2>Reporte de Visitas</h2>";
$html .= "<p>Desde: $desde | Hasta: $hasta</p>";
$html .= "<table border='1' cellpadding='4'><tr><th>Fecha</th><th>Cantidad</th></tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr><td>{$row['fecha']}</td><td>{$row['cantidad']}</td></tr>";
}
$html .= "</table><br><h3>Gráfica</h3>";

// Escribir contenido HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Extraer imagen y guardarla temporalmente si viene en base64
if (!empty($imagenBase64) && preg_match('/^data:image\/(png|jpeg);base64,/', $imagenBase64, $type)) {
    $extension = $type[1] === 'jpeg' ? 'jpg' : $type[1];
    $imagenBase64 = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $imagenBase64);
    $imagenBase64 = str_replace(' ', '+', $imagenBase64);
    $imagenData = base64_decode($imagenBase64);

    if ($imagenData) {
        $tempImagePath = tempnam(sys_get_temp_dir(), 'grafica_') . '.' . $extension;
        file_put_contents($tempImagePath, $imagenData);

        // Insertar imagen
        $pdf->Image($tempImagePath, '', '', 150, 80, strtoupper($extension));

        // Eliminar archivo temporal
        unlink($tempImagePath);
    } else {
        $pdf->Write(0, 'Error al decodificar la imagen.', '', 0, 'L', true, 0, false, false, 0);
    }
} else {
    $pdf->Write(0, 'No se recibió imagen válida.', '', 0, 'L', true, 0, false, false, 0);
}

$pdf->Output('reporte_visitas.pdf', 'I');
?>
