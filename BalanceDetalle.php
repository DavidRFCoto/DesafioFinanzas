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
    <title>Balance Detallado</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link rel="stylesheet" href="./Css/Global.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="BalanceDetalle.php" class="brand-link">
            <i class="fas fa-money-bill-wave fa-lg ml-3"></i>
            <span class="brand-text font-weight-light">Sistema Finanzas</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-info"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $_SESSION['usuario']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <!-- <li class="nav-item">
                        <a href="BalanceDetalle.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="RegistrarEntrada.php" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle text-success"></i>
                            <p>Registrar Entrada</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="RegistrarSalida.php" class="nav-link">
                            <i class="nav-icon fas fa-minus-circle text-danger"></i>
                            <p>Registrar Salida</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="EntradasLista.php" class="nav-link">
                            <i class="nav-icon fas fa-list text-info"></i>
                            <p>Ver Entradas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="SalidasLista.php" class="nav-link">
                            <i class="nav-icon fas fa-list text-warning"></i>
                            <p>Ver Salidas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="BalanceDetalle.php" class="nav-link active">
                            <i class="nav-icon fas fa-chart-line text-primary"></i>
                            <p>Balance Detallado</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Balance Detallado</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info Boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-arrow-down"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Entradas</span>
                                <span class="info-box-number">$<?php echo number_format($datos['total_entradas'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-arrow-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Salidas</span>
                                <span class="info-box-number">$<?php echo number_format($datos['total_salidas'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box <?php echo ($datos['balance'] >= 0) ? 'bg-info' : 'bg-warning'; ?>">
                            <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Balance Neto</span>
                                <span class="info-box-number">$<?php echo number_format($datos['balance'], 2); ?></span>
                                <?php if ($datos['balance'] >= 0): ?>
                                    <span class="progress-description">
                                        <i class="fas fa-check-circle"></i> Balance Positivo
                                    </span>
                                <?php else: ?>
                                    <span class="progress-description">
                                        <i class="fas fa-exclamation-circle"></i> Balance Negativo
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Evolución del Balance
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="balanceEvolucion" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Distribución Entradas vs Salidas
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="distribucionBalance" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Exportación -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-export mr-1"></i>
                            Exportar Reportes
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Seleccionar Mes</label>
                                    <input type="month" class="form-control" id="mes_reporte" value="<?php echo date('Y-m'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Reporte</label>
                                    <select class="form-control" id="tipo_reporte">
                                        <option value="balance">Balance General</option>
                                        <option value="entradas">Solo Entradas</option>
                                        <option value="salidas">Solo Salidas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Acciones</label>
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-info" onclick="exportarReporte('excel')">
                                            <i class="fas fa-file-excel mr-1"></i> Excel
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="exportarReporte('pdf')">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla Detallada -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-1"></i>
                            Resumen Detallado
                        </h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Entradas (Ingresos)</td>
                                    <td class="text-success">$<?php echo number_format($datos['total_entradas'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-success">Ingresos</span>
                                    </td>
                                    <td>
                                        <?php
                                        $total = $datos['total_entradas'] + $datos['total_salidas'];
                                        $porcentajeEntradas = ($total > 0) ? ($datos['total_entradas'] / $total) * 100 : 0;
                                        ?>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" style="width: <?php echo $porcentajeEntradas; ?>%"></div>
                                        </div>
                                        <span class="badge bg-success"><?php echo number_format($porcentajeEntradas, 1); ?>%</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Salidas (Gastos)</td>
                                    <td class="text-danger">$<?php echo number_format($datos['total_salidas'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-danger">Gastos</span>
                                    </td>
                                    <td>
                                        <?php
                                        $porcentajeSalidas = ($total > 0) ? ($datos['total_salidas'] / $total) * 100 : 0;
                                        ?>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-danger" style="width: <?php echo $porcentajeSalidas; ?>%"></div>
                                        </div>
                                        <span class="badge bg-danger"><?php echo number_format($porcentajeSalidas, 1); ?>%</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Balance Final (Neto)</strong></td>
                                    <td class="<?php echo ($datos['balance'] >= 0) ? 'text-success' : 'text-danger'; ?>">
                                        <strong>$<?php echo number_format($datos['balance'], 2); ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($datos['balance'] >= 0): ?>
                                            <span class="badge bg-success">Positivo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Negativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $razonBalance = ($datos['total_entradas'] > 0) ? 
                                            ($datos['balance'] / $datos['total_entradas']) * 100 : 0;
                                        ?>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar <?php echo ($razonBalance >= 0) ? 'bg-success' : 'bg-danger'; ?>" 
                                                 style="width: <?php echo abs($razonBalance); ?>%">
                                            </div>
                                        </div>
                                        <span class="badge <?php echo ($razonBalance >= 0) ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo number_format(abs($razonBalance), 1); ?>%
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Sistema de Control de Finanzas</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Versión</b> 1.0
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(function () {
    // Datos para el gráfico de evolución
    var ctxEvolucion = document.getElementById('balanceEvolucion').getContext('2d');
    new Chart(ctxEvolucion, {
        type: 'line',
        data: {
            labels: ['Entradas', 'Salidas', 'Balance'],
            datasets: [{
                label: 'Flujo de Dinero',
                data: [
                    <?php echo $datos['total_entradas']; ?>,
                    <?php echo $datos['total_salidas']; ?>,
                    <?php echo $datos['balance']; ?>
                ],
                backgroundColor: 'rgba(60,141,188,0.5)',
                borderColor: 'rgba(60,141,188,1)',
                pointRadius: 4,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': $' + 
                               tooltipItem.yLabel.toFixed(2);
                    }
                }
            }
        }
    });

    // Gráfico de distribución
    var ctxDistribucion = document.getElementById('distribucionBalance').getContext('2d');
    new Chart(ctxDistribucion, {
        type: 'doughnut',
        data: {
            labels: ['Entradas', 'Salidas'],
            datasets: [{
                data: [
                    <?php echo $datos['total_entradas']; ?>,
                    <?php echo $datos['total_salidas']; ?>
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            cutoutPercentage: 60,
            legend: {
                position: 'bottom'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[0];
                        var total = dataset.data.reduce((a, b) => a + b, 0);
                        var value = dataset.data[tooltipItem.index];
                        var percentage = ((value/total) * 100).toFixed(1);
                        return data.labels[tooltipItem.index] + ': $' + value.toFixed(2) + 
                               ' (' + percentage + '%)';
                    }
                }
            }
        }
    });

    // Función para exportar reportes
    window.exportarReporte = function(formato) {
        var mes = document.getElementById('mes_reporte').value;
        var tipo = document.getElementById('tipo_reporte').value;
        
        if (!mes) {
            alert('Por favor seleccione un mes para el reporte');
            return;
        }

        window.location.href = `GenerarReporte.php?tipo=${tipo}&formato=${formato}&mes=${mes}`;
    };
});
</script>
</body>
</html>