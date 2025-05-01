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
$pdf->SetAuthor('Sistema de Reportes');
$pdf->SetTitle('Reporte de Visitas');
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

//izquierdo
$pdf->Image('Imagenes/Logo_ITM/Logo nacional.jpg', 12, 12, 55);

// derecho
$pdf->Image('Imagenes/Logo_ITM/Logo_ITM.jpg', 167, 8, 29);


// Encabezado
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Visitas', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "Desde: $desde   Hasta: $hasta", 0, 1, 'C');
$pdf->Ln(5);

// Tabla HTML
$html = "<table border='1' cellpadding='4'>
            <tr style='background-color:#eaeaea;'>
                <th><b>Fecha</b></th>
                <th><b>Cantidad</b></th>
            </tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['fecha']}</td>
                <td>{$row['cantidad']}</td>
              </tr>";
}
$html .= "</table><br><br><h3>Gráfica:</h3>";

// Escribir HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Gráfica en imagen
if (!empty($imagenBase64) && preg_match('/^data:image\/(png|jpeg);base64,/', $imagenBase64, $type)) {
    $extension = $type[1] === 'jpeg' ? 'jpg' : $type[1];
    $imagenBase64 = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $imagenBase64);
    $imagenBase64 = str_replace(' ', '+', $imagenBase64);
    $imagenData = base64_decode($imagenBase64);

    if ($imagenData) {
        $tempImagePath = tempnam(sys_get_temp_dir(), 'grafica_') . '.' . $extension;
        file_put_contents($tempImagePath, $imagenData);

        // Insertar imagen centrada
        $pdf->Image($tempImagePath, '', '', 180, 80, strtoupper($extension), '', 'T', false, 300, '', false, false, 1, false, false, false);

        unlink($tempImagePath);
    } else {
        $pdf->Write(0, 'Error al decodificar la imagen.', '', 0, 'L', true, 0, false, false, 0);
    }
} else {
    $pdf->Write(0, 'No se recibió imagen válida.', '', 0, 'L', true, 0, false, false, 0);
}

// Comentarios finales
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'I', 11);
$pdf->MultiCell(0, 10, "Observaciones: Se recomienda monitorear las tendencias semanales para identificar patrones de uso o caídas de tráfico.", 0, 'L');

$pdf->Output('reporte_visitas.pdf', 'I');
?>
