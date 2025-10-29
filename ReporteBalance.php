<?php
require_once 'Entradas.php';
require_once 'Salidas.php';

class ReporteBalance {
    private $entradas;
    private $salidas;

    public function __construct() {
        $this->entradas = new Entradas();
        $this->salidas = new Salidas();
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
}
?>