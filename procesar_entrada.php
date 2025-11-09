<?php
session_start();

require_once 'Entradas.php';
require_once 'ConexionDB.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit();
}

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanear los datos del formulario
    $id_usuario = $_SESSION['id_usuario'];
    $monto = (float)($_POST['monto'] ?? 0);  
    $concepto = htmlspecialchars($_POST['concepto'] ?? '');
    $fecha = htmlspecialchars($_POST['fecha'] ?? '');
    $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');

    // Validar datos mínimos
    if ($monto <= 0 || empty($concepto) || empty($fecha)) {
        header("Location: BalanceDetalle.php?error=datos_invalidos");
        exit();
    }   

    $entradas = new Entradas();

    if ($entradas->registrarEntrada($id_usuario, $concepto, $monto, $fecha, $descripcion)) {
        header("Location: BalanceDetalle.php?registro=entrada_ok");
        exit();

    } else {
        header("Location: BalanceDetalle.php?error=db_entrada");
        exit();
    }
} else {
    header("Location: BalanceDetalle.php");
    exit();    
}
?> 