<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: BalanceDetalle.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Finanzas - Login</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,500,600,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./Css/Global.css">
    <link rel="stylesheet" href="./Css/login.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo mb-4">
            <a href="Index.php">
                <i class="fas fa-money-bill-wave fa-3x mb-3 text-white"></i>
                <br>
                <b>Sistema de </b>Finanzas
            </a>
        </div>
        <div class="card">
        
        <div id="login" class="tab-contenido activo card-body login-card-body">
            <p class="login-box-msg">Inicia sesión para comenzar</p>
            <?php
            // mensaje de error del login
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger">Usuario o contraseña incorrectos</div>';
            }
            // mensaje de éxito de registro
            if (isset($_GET['registro_exito'])) {
                echo '<div class="alert alert-success">Registrado exitosamente. Inicia sesión.</div>';
            }
            ?>
            <form method="POST" action="ProcesarLogin.php">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Contraseña" id="contraseña" name="contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                            <div class="input-group-text password-toggle" onclick="togglePassword('contraseña', this)">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">
                            <i class="fas fa-sign-in-alt"></i>Ingresar al Sistema
                        </button>
                    </div>
                </div>
                
                <p class="mb-0 mt-3 text-center">
                    ¿No tienes cuenta? <a href="#" onclick="mostrarTab('registro')" class="text-primary">
                        <i class="fas fa-user-plus mr-1"></i>Regístrate aquí
                    </a>
                </p>
            </form>
        </div>

        <div id="registro" class="tab-contenido card-body login-card-body" style="display: none;">
            <p class="login-box-msg">Registra una nueva cuenta</p>
            <?php
            // mensaje de error del registro
            if (isset($_GET['registro_error'])) {
                echo '<div class="alert alert-danger">El usuario o email ya existe. Intenta con otro.</div>';
            }
            ?>
            <form method="POST" action="ProcesarRegistro.php">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Usuario" id="nuevo_usuario" name="usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email" id="nuevo_email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Contraseña" id="nueva_contraseña" name="contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                            <div class="input-group-text password-toggle" onclick="togglePassword('nueva_contraseña', this)">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">
                            <i class="fas fa-user-check"></i>Crear Cuenta
                        </button>
                    </div>
                </div>
                
                <p class="mb-0 mt-3 text-center">
                    ¿Ya tienes cuenta? <a href="#" onclick="mostrarTab('login')" class="text-primary">
                        <i class="fas fa-sign-in-alt mr-1"></i>Ingresa aquí
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="Index.js"></script>
    <script>
    function togglePassword(inputId, toggleElement) {
        const input = document.getElementById(inputId);
        const icon = toggleElement.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }

        // Añade un efecto de pulso al icono
        toggleElement.style.transform = 'scale(1.1)';
        setTimeout(() => {
            toggleElement.style.transform = 'scale(1)';
        }, 200);
    }

    // Añadir efecto de entrada suave a los mensajes de alerta
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.style.transition = 'all 0.5s ease-in-out';
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
            }, 100);
        });
    });
    </script>
</body>
</html>