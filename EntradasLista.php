<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

require_once 'Entradas.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Entradas</title>
    <link rel="stylesheet" href="./Css/Global.css">
</head>

<body>
    <div class="header">
        <h1>Control de Finanzas</h1>

        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="DashboardPrincipal.php" class="button-link back-button logout" style="background: #27a235ff;">Volver al Dashboard</a>
        </div>
    </div>

       <div class="contenedor">
        <div class="card full-width">
            <h2>Listado de Entradas</h2>
            <?php
            $entradas = new Entradas();
            $resultado = $entradas->obtenerEntradas($_SESSION['id_usuario']);

            if ($resultado && $resultado->num_rows > 0) {
                echo '<table>';
                echo '<thead><tr><th>Concepto</th><th>Monto</th><th>Fecha</th><th>Descripción</th><th>Registrado</th></tr></thead>';
                echo '<tbody>';
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($fila['concepto']) . '</td>';
                    echo '<td>$' . number_format($fila['monto'], 2) . '</td>';
                    echo '<td>' . $fila['fecha'] . '</td>';
                    echo '<td>' . htmlspecialchars($fila['descripcion']) . '</td>';
                    echo '<td>' . $fila['fecha_registro'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="info-message">No hay entradas registradas.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>