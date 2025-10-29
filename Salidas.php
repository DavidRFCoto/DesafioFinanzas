<?php
require_once 'ConexionDB.php';

class Salidas {
    private $conexion;

    public function __construct() {
        $db = new ConexionDB();
        $this->conexion = $db->conectar();
    }

    public function registrarSalida($id_usuario, $concepto, $monto, $fecha, $descripcion) {
        $query = "INSERT INTO salidas (id_usuario, concepto, monto, fecha, descripcion) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isids", $id_usuario, $concepto, $monto, $fecha, $descripcion);
        return $stmt->execute();
    }

    public function obtenerSalidas($id_usuario) {
        $query = "SELECT * FROM salidas WHERE id_usuario = ? ORDER BY fecha DESC";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function sumarSalidas($id_usuario) {
        $query = "SELECT SUM(monto) as total FROM salidas WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] ?? 0;
    }
}
?>