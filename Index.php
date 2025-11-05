<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: DashboardPrincipal.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Finanzas - Login</title>
    <link rel="stylesheet" href="./Css/Global.css">
</head>
<body class="login-body">
    <div class="contenedor login-box">
        <h1>Sistema de Finanzas</h1>
        
        <div id="login" class="tab-contenido activo">
            <?php
            // mensaje de error del login
            if (isset($_GET['error'])) {
                echo '<div class="error">Usuario o contraseña incorrectos</div>';
            }
            // mensaje de éxito de registro
            if (isset($_GET['registro_exito'])) {
                echo '<div class="mensaje" style="color: green; font-weight: bold;">Registrado exitosamente. Inicia sesión.</div>';
            }
            ?>
            <form method="POST" action="ProcesarLogin.php">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required>
                </div>
                <button type="submit">Ingresar</button>
                
                <p class="enlace-alternar">
                    ¿No tienes cuenta? <a href="#" onclick="mostrarTab('registro')">**Regístrate aquí**</a>
                </p>
            </form>
        </div>

        <div id="registro" class="tab-contenido">
            <?php
            // mensaje de error del registro
            if (isset($_GET['registro_error'])) {
                echo '<div class="error">El usuario o email ya existe. Intenta con otro.</div>';
            }
            ?>
            <form method="POST" action="ProcesarRegistro.php">
                <div class="form-group">
                    <label for="nuevo_usuario">Usuario:</label>
                    <input type="text" id="nuevo_usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="nuevo_email">Email:</label>
                    <input type="email" id="nuevo_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nueva_contraseña">Contraseña:</label>
                    <input type="password" id="nueva_contraseña" name="contraseña" required>
                </div>
                <button type="submit">Registrarse</button>
                
                <p class="enlace-alternar">
                    ¿Ya tienes cuenta? <a href="#" onclick="mostrarTab('login')">**Ingresa aquí**</a>
                </p>
            </form>
        </div>
    </div>

    <script src="Index.js"></script> 
</body>
</html>