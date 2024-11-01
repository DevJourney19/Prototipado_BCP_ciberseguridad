<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../dao/DaoHorario.php';
require_once '../dao/DaoSeguridad.php';

class ControllerHorario {
    private $daoHorario;
    private $daoSeguridad;

    public function __construct() {
        $this->daoHorario = new DaoHorario();
        $this->daoSeguridad = new DaoSeguridad();
    }

    public function registrar() {
        echo "Método registrar llamado";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrar'])) { 
            var_dump($_POST); // Añade esto para verificar qué datos se envían
            $id_seguridad = $_SESSION['id_seguridad'] ?? null; // Asegúrate de que esto tenga un valor
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d'); 
    
            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad)) {
                if (!empty($hora_inicio) && !empty($hora_fin)) {
                    $resultado = $this->daoHorario->registrarHorario($id_seguridad, $hora_inicio, $hora_fin, $fecha);
                    
                    if ($resultado) {
                        header('Location: /view/horario_ubicacion.php');
                        exit; // Asegúrate de hacer un exit después de header
                    } else {
                        echo "Error al registrar el horario en la base de datos.";
                    }
                } else {
                    echo "Error: Debes llenar todos los campos.";
                }
            } else {
                echo "Error: El id_seguridad no existe.";
            }
        }
    }

    public function obtenerHorarios() {
        return $this->daoHorario->obtenerHorariosRestringidos();
    }

    public function modificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
    
            $id_hora = $_POST['id_hora'] ?? null;
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d'); // O puedes obtenerlo de otra manera
    
            if ($id_seguridad && $id_hora && !empty($hora_inicio) && !empty($hora_fin)) {
                $this->daoHorario->modificarHorario($id_hora, $id_seguridad, $hora_inicio, $hora_fin, $fecha);
                header('Location: /view/horario_ubicacion.php');
            } else {
                echo "Error: Debes llenar todos los campos y asegurarte de que el id de seguridad es válido.";
            }
        }
    }
    public function eliminar($id_hora) {
        if ($id_hora) {
            $this->daoHorario->eliminarHorario($id_hora);
            header('Location: /view/horario_ubicacion.php');
        } else {
            echo "Error: El id del horario no es válido.";
        }
    }
}
