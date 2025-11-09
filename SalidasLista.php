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
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
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
                    <li class="nav-item">
                        <a href="BalanceDetalle.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
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
                        <a href="SalidasLista.php" class="nav-link active">
                            <i class="nav-icon fas fa-list text-warning"></i>
                            <p>Ver Salidas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="BalanceDetalle.php" class="nav-link">
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
                        <h1>Análisis de Salidas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="BalanceDetalle.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salidas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Gráficos Estadísticos -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Salidas por Mes
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salidasPorMes" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Distribución de Gastos
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="distribucionSalidas" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Salidas -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            Listado de Salidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $salidas = new Salidas();
                        $resultado = $salidas->obtenerSalidas($_SESSION['id_usuario']);
                        
                        if ($resultado && $resultado->num_rows > 0) {
                            // Preparar arrays para los gráficos
                            $montosPorMes = array();
                            $montosPorConcepto = array();
                            
                            echo '<table id="tablaSalidas" class="table table-bordered table-striped">';
                            echo '<thead>
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Registrado</th>
                                    </tr>
                                  </thead>';
                            echo '<tbody>';
                            
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($fila['concepto']) . '</td>';
                                echo '<td class="text-danger">$' . number_format($fila['monto'], 2) . '</td>';
                                $fecha = new DateTime($fila['fecha']);
                                echo '<td>' . $fecha->format('d/m/Y') . '</td>';
                                echo '<td>' . htmlspecialchars($fila['descripcion']) . '</td>';
                                $fecha_registro = new DateTime($fila['fecha_registro']);
                                echo '<td>' . $fecha_registro->format('d/m/Y H:i') . '</td>';
                                echo '</tr>';
                                
                                // Agrupar datos para gráficos
                                $mes = date('M Y', strtotime($fila['fecha']));
                                $montosPorMes[$mes] = ($montosPorMes[$mes] ?? 0) + $fila['monto'];
                                
                                $concepto = $fila['concepto'];
                                $montosPorConcepto[$concepto] = ($montosPorConcepto[$concepto] ?? 0) + $fila['monto'];
                            }
                            echo '</tbody>';
                            echo '</table>';
                            
                            // Convertir datos para JavaScript
                            $jsonMontosPorMes = json_encode($montosPorMes);
                            $jsonMontosPorConcepto = json_encode($montosPorConcepto);
                        } else {
                            echo '<div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No hay salidas registradas.
                                  </div>';
                        }
                        ?>
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
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(function () {
    // Inicializar DataTables
    $('#tablaSalidas').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });

    <?php if (isset($jsonMontosPorMes) && isset($jsonMontosPorConcepto)): ?>
    // Gráfico de Salidas por Mes
    var ctxMes = document.getElementById('salidasPorMes').getContext('2d');
    var datosMes = <?php echo $jsonMontosPorMes; ?>;
    new Chart(ctxMes, {
        type: 'bar',
        data: {
            labels: Object.keys(datosMes),
            datasets: [{
                label: 'Total de Salidas por Mes',
                data: Object.values(datosMes),
                backgroundColor: 'rgba(220, 53, 69, 0.5)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
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
            }
        }
    });

    // Gráfico de Distribución de Salidas
    var ctxDist = document.getElementById('distribucionSalidas').getContext('2d');
    var datosDist = <?php echo $jsonMontosPorConcepto; ?>;
    new Chart(ctxDist, {
        type: 'pie',
        data: {
            labels: Object.keys(datosDist),
            datasets: [{
                data: Object.values(datosDist),
                backgroundColor: [
                    'rgba(220, 53, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(23, 162, 184, 0.7)',
                    'rgba(52, 58, 64, 0.7)',
                    'rgba(111, 66, 193, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[0];
                        var total = dataset.data.reduce((a, b) => a + b, 0);
                        var value = dataset.data[tooltipItem.index];
                        var percentage = ((value/total) * 100).toFixed(1);
                        return data.labels[tooltipItem.index] + ': $' + value.toFixed(2) + ' (' + percentage + '%)';
                    }
                }
            }
        }
    });
    <?php endif; ?>
});
</script>
</body>
</html>