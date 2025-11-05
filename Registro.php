<?php
require_once 'ConexionDB.php';

class Registro {
    private $db;

    public function __construct() {
        $conexionDB = new ConexionDB();
        $this->db = $conexionDB->conectar();
    }

    /**
     * Registra un nuevo usuario en la base de datos.
     * @param string $usuario Nombre de usuario.
     * @param string $email Correo electrónico.
     * @param string $contrasena_hasheada Contraseña ya hasheada (generada con password_hash()).
     * @return bool Retorna true si el registro fue exitoso, false si falló (ej: usuario/email duplicado).
     */
    public function registrarNuevoUsuario($usuario, $email, $contraseña_hasheada) {
        // 1. Verificar si el usuario o email ya existe (Importante para evitar errores de UNIQUE)
        if ($this->existeUsuarioOEmail($usuario, $email)) {
            return false; // El usuario o email ya existen
        }

        // 2. Preparar la consulta INSERT
        $sql = "INSERT INTO usuarios (usuario, email, contraseña) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            error_log("Error de preparación de consulta (Registro): " . $this->db->error);
            return false;
        }

        // 3. Vincular los parámetros y ejecutar
        $stmt->bind_param("sss", $usuario, $email, $contraseña_hasheada);
        $resultado = $stmt->execute();

        $stmt->close();

        return $resultado;
    }

    private function existeUsuarioOEmail($usuario, $email) {
        $sql = "SELECT id FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("Error de preparación de consulta (Verificación): " . $this->db->error);
            return true;
        }

        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $existe = $resultado->num_rows > 0;
        $stmt->close();
        
        return $existe;
    }

    public function __destruct() {}
}
?>