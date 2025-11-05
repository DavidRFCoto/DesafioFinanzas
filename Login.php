<?php
require_once 'ConexionDB.php';

class Login {
    private $db;

    public function __construct() {
        // Establece la conexión a la base de datos al crear el objeto Login
        $conexionDB = new ConexionDB();
        $this->db = $conexionDB->conectar();
    }


    public function validarUsuario($usuario, $contraseña) {
        // 1. Preparar la consulta para buscar el usuario
        // Usamos sentencias preparadas para prevenir inyecciones SQL
        $sql = "SELECT id, contraseña FROM usuarios WHERE usuario = ?";
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("Error de preparación de consulta (Login): " . $this->db->error);
            return false;
        }

        // 2. Vincular el parámetro y ejecutar
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $id_usuario = $fila['id'];
            $contraseña_hash = $fila['contraseña'];

            // 3. Verificar la contraseña usando password_verify()
            if (password_verify($contraseña, $contraseña_hash)) {
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['usuario'] = $usuario;

                $stmt->close();
                return true;
            }
        }
        
        $stmt->close();
        return false;
    }

    public function __destruct() {}
}
?>