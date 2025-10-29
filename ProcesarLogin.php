<?php
session_start();
require_once 'Login.php';

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

$login = new Login();
if ($login->validarUsuario($usuario, $contraseña)) {
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: index.php?error=1");
    exit();
}
?>