<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

require_once 'ReporteBalance.php';

$reporte = new ReporteBalance();
$datos = $reporte->obtenerReporte($_SESSION['id_usuario']) ?? ['total_entradas' => 0, 'total_salidas' => 0, 'balance' => 0];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Finanzas - Dashboard</title>
    <link rel="stylesheet" href="./Css/Global.css">
</head>
<body>
    <div class="header">
        <h1>Control de Finanzas</h1>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="logout.php" class="logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="contenedor">
        <div class="card balance-card">
            <h2>Resumen Financiero</h2>
            <div class="balance-info">
                <div class="balance-item">
                    <h3>Total Entradas</h3>
                    <p>$<?php echo number_format($datos['total_entradas'] ?? 0, 2); ?></p>
                </div>
                <div class="balance-item">
                    <h3>Total Salidas</h3>
                    <p>$<?php echo number_format($datos['total_salidas'] ?? 0, 2); ?></p>
                </div>
                <div class="balance-item">
                    <h3>Balance</h3>
                    <p <?php echo ($datos['balance'] ?? 0) >= 0 ? 'style="color: #2ecc71;"' : 'style="color: #e74c3c;"'; ?>>
                        $<?php echo number_format($datos['balance'] ?? 0, 2); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="menu-principal">
            <div class="card">
                <h2>Registrar Entrada</h2>
                <p>Agregar dinero que ingresa</p>
                <a href="RegistrarEntrada.php" class="button-link"><button>Registrar</button></a>
            </div>
            <div class="card">
                <h2>Registrar Salida</h2>
                <p>Agregar dinero que se gasta</p>
                <a href="RegistrarSalida.php" class="button-link"><button>Registrar</button></a>
            </div>
            <div class="card">
                <h2>Ver Entradas</h2>
                <p>Visualizar todas las entradas</p>
                <a href="EntradasLista.php" class="button-link"><button>Ver</button></a>
            </div>
            <div class="card">
                <h2>Ver Salidas</h2>
                <p>Visualizar todas las salidas</p>
                <a href="SalidasLista.php" class="button-link"><button>Ver</button></a>
            </div>
            <div class="card">
                <h2>Ver Balance</h2>
                <p>Reporte detallado de balance</p>
                <a href="BalanceDetalle.php" class="button-link"><button>Ver Reporte</button></a>
            </div>
        </div>

        </div>
    
    </body>
</html>