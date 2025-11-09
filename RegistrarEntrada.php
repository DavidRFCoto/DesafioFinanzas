<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Entrada</title>
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
                        <a href="RegistrarEntrada.php" class="nav-link active">
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Registrar Nueva Entrada</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="BalanceDetalle.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Registrar Entrada</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Nueva Entrada de Dinero</h3>
                            </div>
                            <form method="POST" action="procesar_entrada.php">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="concepto_entrada">Concepto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-tag"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="concepto_entrada" name="concepto" 
                                                   placeholder="Ej: Salario, Venta..." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="monto_entrada">Monto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control" id="monto_entrada" name="monto" 
                                                   step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_entrada">Fecha de Transacción</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                            </div>
                                            <?php 
                                            $fecha_actual = new DateTime();
                                            $fecha_valor = $fecha_actual->format('Y-m-d');
                                            ?>
                                            <input type="date" 
                                                   class="form-control" 
                                                   id="fecha_entrada" 
                                                   name="fecha" 
                                                   value="<?php echo htmlspecialchars($fecha_valor); ?>" 
                                                   max="<?php echo htmlspecialchars($fecha_valor); ?>"
                                                   pattern="\d{4}-\d{2}-\d{2}"
                                                   required
                                                   oninvalid="this.setCustomValidity('Por favor ingrese una fecha válida')"
                                                   oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion_entrada">Descripción (Opcional)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-comment"></i>
                                                </span>
                                            </div>
                                            <textarea class="form-control" id="descripcion_entrada" name="descripcion" 
                                                      rows="3" placeholder="Detalles adicionales..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar Entrada
                                    </button>
                                    <a href="BalanceDetalle.php" class="btn btn-secondary float-right">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </form>
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
</body>
</html>