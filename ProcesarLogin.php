<?php
session_start();
require_once 'Login.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Obtener y sanear los datos del formulario (Mejora de seguridad: usar funciones de sanitización)
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    
    // 2. Crear una instancia de la clase Login
    $login = new Login();
    
    // 3. Llamar al método de validación de usuario    
    if ($login->validarUsuario($usuario, $contraseña)) {
        header("Location: DashboardPrincipal.php");
        exit();
    } else {
        header("Location: index.php?error=1");
        exit();
    }
} else {
    header("Location: Index.php");
    exit();
}
?>