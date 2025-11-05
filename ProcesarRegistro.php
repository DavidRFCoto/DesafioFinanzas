<?php
session_start();
require_once 'Registro.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    // obtener y sanear los datos del formulario
    if (!isset($_POST['usuario'], $_POST['email'], $_POST['contraseña']) || 
        empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['contraseña'])) {
        
        // Redirigir si faltan datos
        header("Location: index.php?registro_error=campos_vacios");
        exit();
    }
    
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $contraseña_plana = $_POST['contraseña'];

    $contraseña_hasheada = password_hash($contraseña_plana, PASSWORD_DEFAULT);

    $registro = new Registro();
    
    $resultado = $registro->registrarNuevoUsuario($usuario, $email, $contraseña_hasheada);

    if ($resultado === true) {
        header("Location: index.php?registro_exito=1");
        exit();
    } else {
        header("Location: index.php?registro_error=1");
        exit();
    }
} else {
    header("Location: Index.php");
    exit();
}
?>