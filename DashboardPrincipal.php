<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

require_once 'ReporteBalance.php';
require_once 'Entradas.php';
require_once 'Salidas.php';

$reporte = new ReporteBalance();
$datos = $reporte->obtenerReporte($_SESSION['id_usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Finanzas</title>
    <link rel="stylesheet" href="./Css/Dashboard.css">
</head>
<body>
    <div class="header">
        <h1>🏦 Dashboard de Finanzas</h1>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="logout.php" class="logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="contenedor">
        <!-- BALANCE GENERAL -->
        <div class="card balance-card">
            <h2>Resumen Financiero</h2>
            <div class="balance-info">
                <div class="balance-item">
                    <h3>Total Entradas</h3>
                    <p>$<?php echo number_format($datos['total_entradas'], 2); ?></p>
                </div>
                <div class="balance-item">
                    <h3>Total Salidas</h3>
                    <p>$<?php echo number_format($datos['total_salidas'], 2); ?></p>
                </div>
                <div class="balance-item">
                    <h3>Balance</h3>
                    <p <?php echo $datos['balance'] >= 0 ? 'style="color: #2ecc71;"' : 'style="color: #e74c3c;"'; ?>>
                        $<?php echo number_format($datos['balance'], 2); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- MENÚ DE OPCIONES -->
        <div class="menu-principal">
            <div class="card">
                <h2>➕ Registrar Entrada</h2>
                <p>Agregar dinero que ingresa</p>
                <button onclick="mostrarSeccion('registrar-entrada')">Registrar</button>
            </div>
            <div class="card">
                <h2>➖ Registrar Salida</h2>
                <p>Agregar dinero que se gasta</p>
                <button onclick="mostrarSeccion('registrar-salida')">Registrar</button>
            </div>
            <div class="card">
                <h2>👀 Ver Entradas</h2>
                <p>Visualizar todas las entradas</p>
                <button onclick="mostrarSeccion('ver-entradas')">Ver</button>
            </div>
            <div class="card">
                <h2>👀 Ver Salidas</h2>
                <p>Visualizar todas las salidas</p>
                <button onclick="mostrarSeccion('ver-salidas')">Ver</button>
            </div>
            <div class="card">
                <h2>📊 Ver Balance</h2>
                <p>Reporte detallado de balance</p>
                <button onclick="mostrarSeccion('balance')">Ver Reporte</button>
            </div>
        </div>

        <!-- REGISTRAR ENTRADA -->
        <div id="registrar-entrada" class="tab-contenido">
            <h2>Registrar Nueva Entrada</h2>
            <form method="POST" action="procesar_entrada.php">
                <div class="form-group">
                    <label for="concepto_entrada">Concepto:</label>
                    <input type="text" id="concepto_entrada" name="concepto" placeholder="Ej: Salario, Venta..." required>
                </div>
                <div class="form-group">
                    <label for="monto_entrada">Monto ($):</label>
                    <input type="number" id="monto_entrada" name="monto" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label for="fecha_entrada">Fecha:</label>
                    <input type="date" id="fecha_entrada" name="fecha" required>
                </div>
                <div class="form-group">
                    <label for="descripcion_entrada">Descripción:</label>
                    <textarea id="descripcion_entrada" name="descripcion" placeholder="Detalles adicionales..."></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Registrar Entrada</button>
                </div>
            </form>
        </div>

        <!-- REGISTRAR SALIDA -->
        <div id="registrar-salida" class="tab-contenido">
            <h2>Registrar Nueva Salida</h2>
            <form method="POST" action="procesar_salida.php">
                <div class="form-group">
                    <label for="concepto_salida">Concepto:</label>
                    <input type="text" id="concepto_salida" name="concepto" placeholder="Ej: Alquiler, Comida..." required>
                </div>
                <div class="form-group">
                    <label for="monto_salida">Monto ($):</label>
                    <input type="number" id="monto_salida" name="monto" step="0.01" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label for="fecha_salida">Fecha:</label>
                    <input type="date" id="fecha_salida" name="fecha" required>
                </div>
                <div class="form-group">
                    <label for="descripcion_salida">Descripción:</label>
                    <textarea id="descripcion_salida" name="descripcion" placeholder="Detalles adicionales..."></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Registrar Salida</button>
                </div>
            </form>
        </div>

        <!-- VER ENTRADAS -->
        <div id="ver-entradas" class="tab-contenido">
            <h2>Listado de Entradas</h2>
            <?php
            $entradas = new Entradas();
            $resultado = $entradas->obtenerEntradas($_SESSION['id_usuario']);

            if ($resultado->num_rows > 0) {
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
                echo '<p style="text-align: center; color: #666; margin-top: 20px;">No hay entradas registradas</p>';
            }
            ?>
        </div>

        <!-- VER SALIDAS -->
        <div id="ver-salidas" class="tab-contenido">
            <h2>Listado de Salidas</h2>
            <?php
            $salidas = new Salidas();
            $resultado = $salidas->obtenerSalidas($_SESSION['id_usuario']);

            if ($resultado->num_rows > 0) {
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
                echo '<p style="text-align: center; color: #666; margin-top: 20px;">No hay salidas registradas</p>';
            }
            ?>
        </div>

        <!-- BALANCE DETALLADO -->
        <div id="balance" class="tab-contenido">
            <h2>Reporte de Balance</h2>
            <div class="reporte-balance">
                <div class="reporte-item">
                    <h3>Total Entradas</h3>
                    <p class="reporte-valor">$<?php echo number_format($datos['total_entradas'], 2); ?></p>
                </div>
                <div class="reporte-item">
                    <h3>Total Salidas</h3>
                    <p class="reporte-valor">$<?php echo number_format($datos['total_salidas'], 2); ?></p>
                </div>
                <div class="reporte-item">
                    <h3>Balance Final</h3>
                    <p class="reporte-valor" <?php echo $datos['balance'] >= 0 ? 'style="color: #2ecc71;"' : 'style="color: #e74c3c;"'; ?>>
                        $<?php echo number_format($datos['balance'], 2); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>