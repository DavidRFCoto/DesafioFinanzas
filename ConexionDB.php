<?php
class ConexionDB {
    private $servidor = "localhost";
    private $usuario = "root";
    private $contraseña = "";
    private $base_datos = "finanzas_db";
    private $conexion;

    public function conectar() {
        $this->conexion = new mysqli(
            $this->servidor,
            $this->usuario,
            $this->contraseña,
            $this->base_datos
        );

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
        
        return $this->conexion;
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    public function cerrar() {
        $this->conexion->close();
    }
}
?>