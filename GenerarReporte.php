<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'ReporteBalance.php';
require_once 'Entradas.php';
require_once 'Salidas.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

$tipo_reporte = $_GET['tipo'] ?? ''; // balance, entradas, salidas
$formato = $_GET['formato'] ?? ''; // excel, pdf
$mes = $_GET['mes'] ?? date('Y-m'); // YYYY-MM formato

$reporte = new ReporteBalance();
$entradas = new Entradas();
$salidas = new Salidas();

$totales = []; // Variable para guardar los totales del balance

// Obtener datos según el tipo de reporte
switch ($tipo_reporte) {
    case 'entradas':
        $datos = $entradas->obtenerEntradasPorMes($_SESSION['id_usuario'], $mes);
        $titulo = "Reporte de Entradas - " . date('F Y', strtotime($mes));
        break;
    case 'salidas':
        $datos = $salidas->obtenerSalidasPorMes($_SESSION['id_usuario'], $mes);
        $titulo = "Reporte de Salidas - " . date('F Y', strtotime($mes));
        break;
    default:
        // El reporte mensual devuelve un array con 'movimientos' y 'totales'.
        $reporte_data = $reporte->obtenerReporteMensual($_SESSION['id_usuario'], $mes);
        
        $datos = $reporte_data['movimientos'];
        $totales = $reporte_data['totales'];
        
        $titulo = "Balance General - " . date('F Y', strtotime($mes));
        break;
}

if ($formato === 'excel') {
    // Crear nuevo documento Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Establecer título
    $sheet->setCellValue('A1', $titulo);
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    
    // Establecer encabezados
    $sheet->setCellValue('A3', 'Fecha');
    $sheet->setCellValue('B3', 'Concepto');
    $sheet->setCellValue('C3', 'Descripción');
    $sheet->setCellValue('D3', 'Monto');
    $sheet->setCellValue('E3', 'Tipo');
    $sheet->getStyle('A3:D3')->getFont()->setBold(true);
    
    // Agregar datos
    $row = 4;
    $totalMonto = 0;
    
    foreach ($datos as $dato) {
        $monto_columna = $dato['monto'];
        $monto_a_sumar = $dato['monto'];
        $tipo_movimiento = $dato['tipo'] ?? ($tipo_reporte === 'entradas' ? 'entrada' : 'salida');
        
        // Si es el reporte Balance, las salidas deben ser negativas para calcular el Balance
        if ($tipo_reporte === '' || $tipo_reporte === 'balance') {
            if ($tipo_movimiento === 'salida') {
                $monto_a_sumar *= -1;
                $monto_columna = '(' . $monto_columna . ')';
            }
            $sheet->setCellValue('E' . $row, ucfirst($tipo_movimiento));
        }
        
        $sheet->setCellValue('A' . $row, date('d/m/Y', strtotime($dato['fecha'])));
        $sheet->setCellValue('B' . $row, $dato['concepto']);
        $sheet->setCellValue('C' . $row, $dato['descripcion']);
        $sheet->setCellValue('D' . $row, $dato['monto']);
        $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('$#,##0.00');
        
        $totalMonto += $monto_a_sumar;
        $row++;
    }
    
    // Agregar total
    $sheet->setCellValue('D' . $row, 'Total Balance:');
    $sheet->setCellValue('E' . $row, $totalMonto);
    $sheet->getStyle('E' . $row)->getFont()->setBold(true);
    $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('$#,##0.00');
    
    // Autoajustar columnas
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // Generar archivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $titulo . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    
} else if ($formato === 'pdf') {
    // Crear nuevo documento PDF
    $dompdf = new Dompdf();
    
    // Preparar HTML para el PDF
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            h1 { color: #333; text-align: center; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
            th { background-color: #f5f5f5; }
            .total { font-weight: bold; }
            .monto { text-align: right; }
        </style>
    </head>
    <body>
        <h1>' . $titulo . '</h1>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th>Tipo</th> </tr>
                </tr>
            </thead>
            <tbody>';
    
    $totalMonto = 0;
    $es_balance = ($tipo_reporte === '' || $tipo_reporte === 'balance');
    foreach ($datos as $dato) {
        $monto_a_mostrar = '$' . number_format($dato['monto'], 2);
        $monto_a_sumar = $dato['monto'];
        $tipo_movimiento = $dato['tipo'] ?? ($tipo_reporte === 'entradas' ? 'entrada' : 'salida');
        $columna_tipo = '';

        if ($es_balance) {
            if ($tipo_movimiento === 'salida') {
                $monto_a_sumar *= -1;
            }
            $columna_tipo = '<td>' . ucfirst($tipo_movimiento) . '</td>';
        }
        $html .= '<tr>';
        $html .= '<td>' . date('d/m/Y', strtotime($dato['fecha'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['concepto']) . '</td>';
        $html .= '<td>' . htmlspecialchars($dato['descripcion']) . '</td>';
        $html .= '<td class="monto">' . $monto_a_mostrar . '</td>';
        $html .= $columna_tipo;
        $html .= '</tr>';
        
        $totalMonto += $monto_a_sumar;
    }
    
    $html .= '
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td class="monto total">$' . number_format($totalMonto, 2) . '</td>
                </tr>
            </tfoot>
        </table>
    </body>
    </html>';
    
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Generar archivo PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="' . $titulo . '.pdf"');
    echo $dompdf->output();
}

exit();
?>