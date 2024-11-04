<?php
require_once '../dao/DaoHorario.php';
require_once '../dao/DaoSeguridad.php';
session_start();

class ControllerHorario {
    private $daoHorario;
    private $daoSeguridad;

    public function __construct() {
        $this->daoHorario = new DaoHorario();
        $this->daoSeguridad = new DaoSeguridad();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrar'])) {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad) && !empty($hora_inicio) && !empty($hora_fin)) {
                $resultado = $this->daoHorario->registrarHorario($id_seguridad, $hora_inicio, $hora_fin, $fecha);
                $this->redireccionar($resultado, 'Registro');
            } else {
                $this->mensajeError($id_seguridad, $hora_inicio, $hora_fin);
            }
        }
    }

    public function obtenerHorarios() {
        return $this->daoHorario->obtenerHorariosRestringidos();
    }

    public function modificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnModificar'])) {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $id_hora = $_POST['txtId'] ?? null;
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            if ($id_seguridad && $id_hora && !empty($hora_inicio) && !empty($hora_fin)) {
                $resultado = $this->daoHorario->modificarHorario($id_hora, $id_seguridad, $hora_inicio, $hora_fin, $fecha);
                $this->redireccionar($resultado, 'Modificación');
            } else {
                echo "Error: Todos los campos son obligatorios y el id de seguridad debe ser válido.";
            }
        }
    }

    public function eliminar($id_hora) {
        if ($id_hora) {
            $resultado = $this->daoHorario->eliminarHorario($id_hora);
            $this->redireccionar($resultado, 'Eliminación');
        } else {
            echo "Error: El id del horario no es válido.";
        }
    }

    private function redireccionar($resultado, $accion) {
        if ($resultado) {
            header("Location: ../view/horario_ubicacion.php?msg={$accion}_exitosa");
        } else {
            echo "Error al {$accion} el horario en la base de datos.";
        }
        exit;
    }

    private function mensajeError($id_seguridad, $hora_inicio, $hora_fin) {
        if (!$id_seguridad) {
            echo "Error: No se ha encontrado la sesión de seguridad.";
        } elseif (empty($hora_inicio) || empty($hora_fin)) {
            echo "Error: Debes llenar todos los campos.";
        } else {
            echo "Error: El id_seguridad no existe.";
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new ControllerHorario();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action(isset($_GET['id']) ? $_GET['id'] : null);
    } else {
        echo "Acción no válida.";
    }
}
