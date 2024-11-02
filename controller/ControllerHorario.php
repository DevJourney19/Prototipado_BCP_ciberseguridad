<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Cambia a E_ALL & ~E_NOTICE en producción

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
        echo "Método registrar llamado<br>";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrar'])) {
            echo "Formulario enviado<br>";
            var_dump($_POST);
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            echo "ID Seguridad: $id_seguridad<br>";
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad)) {
                echo "ID Seguridad válido<br>";
                if (!empty($hora_inicio) && !empty($hora_fin)) {
                    $resultado = $this->daoHorario->registrarHorario($id_seguridad, $hora_inicio, $hora_fin, $fecha);

                    if ($resultado) {
                        echo "Registro exitoso, redirigiendo...<br>";
                        header('Location: /Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php');
                        exit;
                    } else {
                        echo "Error al registrar el horario en la base de datos.";
                    }
                } else {
                    echo "Error: Debes llenar todos los campos.";
                }
            } else {
                echo "Error: El id_seguridad no existe.";
            }
        } else {
            echo "No se envió el formulario.";
        }
    }

    public function obtenerHorarios() {
        return $this->daoHorario->obtenerHorariosRestringidos();
    }

    public function modificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnModificar'])) {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $id_hora = $_POST['txtId'] ?? null; // Asegúrate de que el ID se pase correctamente
            $hora_inicio = $_POST['txtHoraInicio'] ?? '';
            $hora_fin = $_POST['txtHoraFin'] ?? '';
            $fecha = date('Y-m-d');

            if ($id_seguridad && $id_hora && !empty($hora_inicio) && !empty($hora_fin)) {
                $resultado = $this->daoHorario->modificarHorario($id_hora, $id_seguridad, $hora_inicio, $hora_fin, $fecha);
                if ($resultado) {
                    header('Location: /Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php?msg=modificacion_exitosa');
                    exit;
                } else {
                    echo "Error al modificar el horario en la base de datos.";
                }
            } else {
                echo "Error: Debes llenar todos los campos y asegurarte de que el id de seguridad es válido.";
            }
        } else {
            echo "No se ha enviado el formulario de modificación correctamente.";
        }
    }

    public function eliminar($id_hora) {
        if ($id_hora) {
            $resultado = $this->daoHorario->eliminarHorario($id_hora);
            if ($resultado) {
                header('Location: /view/horario_ubicacion.php?msg=eliminacion_exitosa');
                exit;
            } else {
                echo "Error al eliminar el horario.";
            }
        } else {
            echo "Error: El id del horario no es válido.";
        }
    }
}

// Verificar la acción en el controlador
if (isset($_GET['action'])) {
    $controller = new ControllerHorario();

    if ($_GET['action'] === 'registrar') {
        $controller->registrar();
    } elseif ($_GET['action'] === 'modificar') {
        $controller->modificar(); // Llama a la acción de modificar
    } elseif ($_GET['action'] === 'eliminar' && isset($_GET['id'])) {
        $controller->eliminar($_GET['id']); // Llama a la acción de eliminar con el ID correspondiente
    } else {
        echo "Acción no válida.";
    }
} else {
}