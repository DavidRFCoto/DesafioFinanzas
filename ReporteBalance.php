<?php
require_once 'Entradas.php';
require_once 'Salidas.php';
require_once 'ConexionDB.php';

class ReporteBalance {
    private $entradas;
    private $salidas;
    private $conexion;

    public function __construct() {
        $this->entradas = new Entradas();
        $this->salidas = new Salidas();
        $db = new ConexionDB();
        $this->conexion = $db->conectar();
        if (!$this->conexion) {
            die("Error al conectar con la base de datos");
        }
    }

    public function calcularBalance($id_usuario) {
        $total_entradas = $this->entradas->sumarEntradas($id_usuario);
        $total_salidas = $this->salidas->sumarSalidas($id_usuario);
        return $total_entradas - $total_salidas;
    }

    public function obtenerReporte($id_usuario) {
        $total_entradas = $this->entradas->sumarEntradas($id_usuario);
        $total_salidas = $this->salidas->sumarSalidas($id_usuario);
        $balance = $this->calcularBalance($id_usuario);

        return [
            'total_entradas' => $total_entradas,
            'total_salidas' => $total_salidas,
            'balance' => $balance
        ];
    }

    public function obtenerReporteMensual($id_usuario, $mes) {
        $inicio_mes = $mes . '-01';
        $fin_mes = date('Y-m-t', strtotime($inicio_mes));
        
        // Obtener todas las entradas del mes
        $sql_entradas = "SELECT 'entrada' as tipo, concepto, monto, fecha, descripcion, fecha_registro 
                        FROM entradas 
                        WHERE id_usuario = ? AND fecha BETWEEN ? AND ?";
        
        // Obtener todas las salidas del mes
        $sql_salidas = "SELECT 'salida' as tipo, concepto, monto, fecha, descripcion, fecha_registro 
                       FROM salidas 
                       WHERE id_usuario = ? AND fecha BETWEEN ? AND ?";
        
        // Combinar ambas consultas
        $sql = $sql_entradas . " UNION ALL " . $sql_salidas . " ORDER BY fecha";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("isssss", 
            $id_usuario, $inicio_mes, $fin_mes,
            $id_usuario, $inicio_mes, $fin_mes
        );
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $movimientos = array();
        $totales = array(
            'total_entradas' => 0,
            'total_salidas' => 0,
            'balance' => 0
        );
        
        while ($row = $resultado->fetch_assoc()) {
            $movimientos[] = $row;
            if ($row['tipo'] === 'entrada') {
                $totales['total_entradas'] += $row['monto'];
            } else {
                $totales['total_salidas'] += $row['monto'];
            }
        }
        
        $totales['balance'] = $totales['total_entradas'] - $totales['total_salidas'];
        
        return array(
            'movimientos' => $movimientos,
            'totales' => $totales,
            'periodo' => array(
                'inicio' => $inicio_mes,
                'fin' => $fin_mes
            )
        );
    }
}
?>