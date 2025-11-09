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

    public function obtenerEntradasPorMes($id_usuario, $mes) {
        $inicio_mes = $mes . '-01';
        $fin_mes = date('Y-m-t', strtotime($inicio_mes));
        
        $query = "SELECT * FROM entradas 
                 WHERE id_usuario = ? 
                 AND fecha BETWEEN ? AND ? 
                 ORDER BY fecha";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iss", $id_usuario, $inicio_mes, $fin_mes);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $entradas = array();
        
        while ($row = $resultado->fetch_assoc()) {
            $entradas[] = $row;
        }
        
        return $entradas;
    }
}
?>