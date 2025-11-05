<?php
session_start();

require_once 'Salidas.php';
require_once 'ConexionDB.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3. Obtener y sanear los datos del formulario
    $id_usuario = $_SESSION['id_usuario'];
    $monto = (float)($_POST['monto'] ?? 0);   
    $concepto = htmlspecialchars($_POST['concepto'] ?? '');
    $fecha = htmlspecialchars($_POST['fecha'] ?? '');
    $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');

    // Validar datos mínimos
    if ($monto <= 0 || empty($concepto) || empty($fecha)) {
        header("Location: DashboardPrincipal.php?error=datos_invalidos");
        exit();
    }

    // Instanciar la clase y registrar
    $salidas = new Salidas();

    if ($salidas->registrarSalida($id_usuario, $concepto, $monto, $fecha, $descripcion)) {
        header("Location: DashboardPrincipal.php?registro=salida_ok");
        exit();

    } else {
        header("Location: DashboardPrincipal.php?error=db_salida");
        exit();
    }

} else {
    header("Location: DashboardPrincipal.php");
    exit();
}
?>