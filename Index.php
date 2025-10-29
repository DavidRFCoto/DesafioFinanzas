<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Finanzas - Login</title>
    <link rel="stylesheet" href="./Css/Style.css">
    

</head>
<body>
    <div class="contenedor">
        <h1>🏦 Sistema de Finanzas</h1>
        
        <!-- TAB LOGIN -->
        <div id="login" class="tab-contenido activo">
            <div class="tab-buttons">
                <button class="tab-btn activo" onclick="mostrarTab('login')">Iniciar Sesión</button>
                <button class="tab-btn" onclick="mostrarTab('registro')">Registrarse</button>
            </div>
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="error">Usuario o contraseña incorrectos</div>';
            }
            ?>
            <form method="POST" action="procesar_login.php">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required>
                </div>
                <button type="submit">Ingresar</button>
            </form>
        </div>

        <!-- TAB REGISTRO -->
        <div id="registro" class="tab-contenido">
            <div class="tab-buttons">
                <button class="tab-btn" onclick="mostrarTab('login')">Iniciar Sesión</button>
                <button class="tab-btn activo" onclick="mostrarTab('registro')">Registrarse</button>
            </div>
            <?php
            if (isset($_GET['registro_error'])) {
                echo '<div class="error">El usuario o email ya existe</div>';
            }
            if (isset($_GET['registro_exito'])) {
                echo '<div style="color: green; text-align: center;">Registrado exitosamente. Inicia sesión</div>';
            }
            ?>
            <form method="POST" action="procesar_registro.php">
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
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>