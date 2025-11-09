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
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
        <a href="DashboardPrincipal.php" class="brand-link">
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-arrow-down"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Entradas</span>
                                <span class="info-box-number">
                                    $<?php echo number_format($datos['total_entradas'] ?? 0, 2); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-arrow-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Salidas</span>
                                <span class="info-box-number">
                                    $<?php echo number_format($datos['total_salidas'] ?? 0, 2); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-wallet"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Balance Total</span>
                                <span class="info-box-number" <?php echo ($datos['balance'] ?? 0) >= 0 ? 'style="color: #28a745;"' : 'style="color: #dc3545;"'; ?>>
                                    $<?php echo number_format($datos['balance'] ?? 0, 2); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Acciones Rápidas
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3><i class="fas fa-plus"></i></h3>
                                                <p>Nueva Entrada</p>
                                            </div>
                                            <a href="RegistrarEntrada.php" class="small-box-footer">
                                                Registrar <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small-box bg-danger">
                                            <div class="inner">
                                                <h3><i class="fas fa-minus"></i></h3>
                                                <p>Nueva Salida</p>
                                            </div>
                                            <a href="RegistrarSalida.php" class="small-box-footer">
                                                Registrar <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list mr-1"></i>
                                    Reportes Disponibles
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="EntradasLista.php" class="btn btn-info btn-block mb-3">
                                            <i class="fas fa-list"></i> Ver Entradas
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="SalidasLista.php" class="btn btn-warning btn-block mb-3">
                                            <i class="fas fa-list"></i> Ver Salidas
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="BalanceDetalle.php" class="btn btn-primary btn-block mb-3">
                                            <i class="fas fa-chart-line"></i> Balance
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="Dashboard.js"></script>
</body>
</html>