<?php

require_once '../dao/DaoDireccion.php';
require_once '../dao/DaoSeguridad.php';

class ControllerDireccion {
    private $daoDireccion;
    private $daoSeguridad;

    public function __construct() {
        session_start(); // Asegúrate de iniciar la sesión
        $this->daoDireccion = new DaoDireccion();
        $this->daoSeguridad = new DaoSeguridad();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $direccion_exacta = $_POST['txtdireccion'] ?? '';
            $rango_gps = 10; // Valor fijo o puedes cambiarlo
            $fecha_configuracion = date('Y-m-d');
            $hora_configuracion = date('H:i:s');

            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad)) {
                if (!empty($direccion_exacta)) {
                    $this->daoDireccion->registrarDireccion($id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion);
                    header('Location: /view/horario_ubicacion.php');
                    exit; // Asegúrate de usar exit después de redirigir
                } else {
                    echo "Error: Debes llenar todos los campos.";
                }
            } else {
                echo "Error: El id_seguridad no existe.";
            }
        }
    }

    public function obtenerDirecciones() {
        return $this->daoDireccion->obtenerTodasDirecciones();
    }

    public function modificar() {
    }

    public function eliminar($id) {
    }
}
?>