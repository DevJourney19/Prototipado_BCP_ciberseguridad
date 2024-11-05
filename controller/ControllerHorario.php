<?php
session_start();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrar'])) {
            $id_seguridad = $_POST["id_seguridad"] ?? null;
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            // Depuración: Imprimir los valores recibidos
            echo "id_seguridad: $id_seguridad<br>";
            echo "hora_inicio: $hora_inicio<br>";
            echo "hora_fin: $hora_fin<br>";

            // Verificar la existencia del id de seguridad
            $existe = false; // Inicializar variable
            if ($id_seguridad) {
                $existe = $this->daoSeguridad->existeSeguridad($id_seguridad);
                echo "existeSeguridad: " . ($existe ? 'true' : 'false') . "<br>"; // Depuración
            } else {
                echo "Error: No se ha proporcionado un id_seguridad.<br>";
            }

            if ($existe && !empty($hora_inicio) && !empty($hora_fin)) {
                if ($this->daoHorario->registrarHorario($id_seguridad, $hora_inicio, $hora_fin)) {
                    $resultado = true;
                } else {
                    $resultado = false;
                }
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
            $seguridad = $_SESSION['id_seguridad'] ?? null;
            $id_hora = $_POST['txtId'] ?? null;
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            if ($seguridad && $id_hora && !empty($hora_inicio) && !empty($hora_fin)) {
                $resultado = $this->daoHorario->modificarHorario($id_hora, $seguridad, $hora_inicio, $hora_fin, $fecha);
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
        } elseif (!$this->daoSeguridad->existeSeguridad($id_seguridad)) {
            echo "Error: El id_seguridad no existe.";
        } elseif (empty($hora_inicio) || empty($hora_fin)) {
            echo "Error: Debes llenar todos los campos.";
        } else {
            echo "Error desconocido. Por favor intenta de nuevo.";
        }
    }
}

// Controlador de acciones
if (isset($_GET['action'])) {
    $controller = new ControllerHorario();
    $action = $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Acción no válida.";
    }
}