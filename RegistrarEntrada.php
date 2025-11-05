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
    <link rel="stylesheet" href="./Css/Global.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #667eea;
            outline: none;
        }
        .form-container button {
            width: 100%;
            padding: 15px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
        }
        .form-container button:hover {
            background-color: #5a6ed1;
        }
        .form-container button:active {
            transform: scale(0.99);
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Control de Finanzas</h1>
        <div>
            <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="logout.php" class="logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="form-container">
        <a href="DashboardPrincipal.php" class="back-link">&larr; Volver al Dashboard</a>
        <h2>Registrar Nueva Entrada</h2>
        <form method="POST" action="procesar_entrada.php">
            <div class="form-group">
                <label for="concepto_entrada">Concepto:</label>
                <input type="text" id="concepto_entrada" name="concepto" placeholder="Ej: Salario, Venta..." required>
            </div>
            <div class="form-group">
                <label for="monto_entrada">Monto ($):</label>
                <input type="number" id="monto_entrada" name="monto" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label for="fecha_entrada">Fecha de Transacción:</label>
                <input type="date" id="fecha_entrada" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="descripcion_entrada">Descripción (Opcional):</label>
                <textarea id="descripcion_entrada" name="descripcion" placeholder="Detalles adicionales..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Guardar Entrada</button>
            </div>
        </form>
    </div>
</body>
</html>