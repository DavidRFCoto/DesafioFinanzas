<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

require_once 'Salidas.php'; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Salidas</title>
    <link rel="stylesheet" href="./Css/Global.css">
</head>
<body>
    <div class="header">
        <h1>Control de Finanzas</h1>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="DashboardPrincipal.php" class="button-link back-button logout" style="background: #e74c3c;">Volver al Dashboard</a>
        </div>
    </div>
    
    <div class="contenedor">
        <div class="card full-width">
            <h2>Listado de Salidas</h2>
            <?php
            $salidas = new Salidas();
            $resultado = $salidas->obtenerSalidas($_SESSION['id_usuario']);

            if ($resultado && $resultado->num_rows > 0) {
                echo '<table>';
                echo '<thead><tr>';
                echo '<th>Concepto</th>';
                echo '<th class="monto">Monto</th>';
                echo '<th class="fecha">Fecha Transacción</th>'; // Título más claro
                echo '<th>Descripción</th>';
                echo '<th class="fecha-registro">Registrado En</th>'; // Nueva clase para alinear
                echo '</tr></thead>';
                echo '<tbody>';
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($fila['concepto']) . '</td>';
                    echo '<td class="monto salida-color">$' . number_format($fila['monto'], 2) . '</td>'; // Monto con color
                    echo '<td class="fecha">' . $fila['fecha'] . '</td>'; // Clase para la fecha
                    echo '<td>' . htmlspecialchars($fila['descripcion']) . '</td>';
                    echo '<td class="fecha-registro">' . $fila['fecha_registro'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="info-message">No hay salidas registradas.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>