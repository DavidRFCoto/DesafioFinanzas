<?php
require_once 'ConexionDB.php';

class Salidas {
    private $conexion;

    public function __construct() {
        $db = new ConexionDB();
        $this->conexion = $db->conectar();
    }

    private function validarFormatoFecha($fecha) {
        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);
        return $fecha_obj && $fecha_obj->format('Y-m-d') === $fecha;
    }

    public function registrarSalida($id_usuario, $concepto, $monto, $fecha, $descripcion) {
        try {
            // Validación estricta de la fecha
            if (!$this->validarFormatoFecha($fecha)) {
                error_log("Fecha inválida recibida: " . $fecha);
                return false;
            }

            // Preparar la consulta con la fecha explícita
            $query = "INSERT INTO salidas (id_usuario, concepto, monto, fecha, descripcion) 
                     VALUES (?, ?, ?, STR_TO_DATE(?, '%Y-%m-%d'), ?)";
            
            $stmt = $this->conexion->prepare($query);
            if (!$stmt) {
                error_log("Error preparando la consulta: " . $this->conexion->error);
                return false;
            }

            $stmt->bind_param("isiss", $id_usuario, $concepto, $monto, $fecha, $descripcion);
            $resultado = $stmt->execute();
            
            if (!$resultado) {
                error_log("Error ejecutando la consulta: " . $stmt->error);
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Error al registrar salida: " . $e->getMessage());
            return false;
        }
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

    public function obtenerSalidasPorMes($id_usuario, $mes) {
        $inicio_mes = $mes . '-01';
        $fin_mes = date('Y-m-t', strtotime($inicio_mes));
        
        $query = "SELECT * FROM salidas 
                 WHERE id_usuario = ? 
                 AND fecha BETWEEN ? AND ? 
                 ORDER BY fecha";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iss", $id_usuario, $inicio_mes, $fin_mes);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $salidas = array();
        
        while ($row = $resultado->fetch_assoc()) {
            $salidas[] = $row;
        }
        
        return $salidas;
    }
}
?>