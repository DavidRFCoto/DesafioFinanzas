<?php
require_once 'ConexionDB.php';

class Entradas {
    private $conexion;

    public function __construct() {
        $db = new ConexionDB();
        $this->conexion = $db->conectar();
    }

    public function registrarEntrada($id_usuario, $concepto, $monto, $fecha, $descripcion) {
        $query = "INSERT INTO entradas (id_usuario, concepto, monto, fecha, descripcion) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isids", $id_usuario, $concepto, $monto, $fecha, $descripcion);
        return $stmt->execute();
    }

    public function obtenerEntradas($id_usuario) {
        $query = "SELECT * FROM entradas WHERE id_usuario = ? ORDER BY fecha DESC";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function sumarEntradas($id_usuario) {
        $query = "SELECT SUM(monto) as total FROM entradas WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] ?? 0;
    }
}
?>