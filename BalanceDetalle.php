<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

require_once 'ReporteBalance.php'; 

$reporte = new ReporteBalance();
// Usamos el operador de fusión null '??' para asegurar valores por defecto.
$datos = $reporte->obtenerReporte($_SESSION['id_usuario']) ?? ['total_entradas' => 0, 'total_salidas' => 0, 'balance' => 0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Detallado de Balance</title>
    <link rel="stylesheet" href="./Css/Global.css">
</head>
<body>
    <div class="header">
        <h1>Control de Finanzas</h1>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <!-- Botón de retorno al Dashboard -->
            <a href="DashboardPrincipal.php" class="button-link back-button logout">Volver al Dashboard</a>
        </div>
    </div>
    
    <div class="contenedor">
        <div class="card full-width">
            <h2>Reporte Detallado de Balance</h2>
            
            <table class="balance-table">
                <thead>
                    <tr>
                        <th style="width: 70%;">Concepto</th>
                        <th class="monto" style="width: 30%;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total de Entradas (Ingresos)</td>
                        <td class="monto entrada-color">$<?php echo number_format($datos['total_entradas'] ?? 0, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total de Salidas (Gastos)</td>
                        <!-- Las salidas siempre se muestran como valor positivo aquí -->
                        <td class="monto salida-color">$<?php echo number_format($datos['total_salidas'] ?? 0, 2); ?></td>
                    </tr>
                    <tr class="balance-row">
                        <td style="font-weight: bold;">Balance Final (Neto)</td>
                        <!-- Se aplica el color condicional: Verde para positivo, Rojo para negativo -->
                        <td class="monto" style="font-weight: bold; <?php echo ($datos['balance'] ?? 0) >= 0 ? 'color: #2ecc71;' : 'color: #e74c3c;'; ?>">
                            $<?php echo number_format($datos['balance'] ?? 0, 2); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>