<?php

require_once '../dao/DaoDireccion.php';
require_once '../dao/DaoSeguridad.php';
include_once '../controller/ControllerEntradas.php';

$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

class ControllerDireccion {
    private $daoDireccion;
    private $daoSeguridad;

    public function __construct() {
        session_start(); 
        $this->daoDireccion = new DaoDireccion();
        $this->daoSeguridad = new DaoSeguridad();
    }

    public function registrar($id_seguridad) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrarDireccion'])) {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $direccion_exacta = trim($_POST['txtdireccion'] ?? '');
            $rango_gps = 10; 
            $fecha_configuracion = date('Y-m-d');
            $hora_configuracion = date('H:i:s');

            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad)) {
                if (!empty($direccion_exacta)) {
                    $this->daoDireccion->registrarDireccion($id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion);
                    $_SESSION['mensaje'] = "Dirección registrada correctamente";
                } else {
                    $_SESSION['mensaje'] = "Error: Debes llenar todos los campos.";
                }
            } else {
                $_SESSION['mensaje'] = "Error: El id_seguridad no existe.";
            }
            header('Location: /Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php');
            exit;
        } else {
            echo "No se envió el formulario.";
        }
    }

    public function obtenerDirecciones($id) {
        return $this->daoDireccion->obtenerTodasDirecciones($id);
    }

    public function modificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnModificar'])) {
            $id_direccion = $_POST['txtId'] ?? null;
            $direccion_exacta = trim($_POST['txtdireccion'] ?? '');
            $rango_gps = $_POST['txtRango'] ?? 10;
    
            if ($id_direccion && !empty($direccion_exacta)) { 
                $this->daoDireccion->modificarDireccion($id_direccion, $direccion_exacta, $rango_gps);
                $_SESSION['mensaje'] = "Dirección modificada correctamente";
                $error = false; 
            } else {
                $_SESSION['mensaje'] = "Error: Debes llenar todos los campos.";
                $error = true; 
            }
    
            header('Location: /Prototipado_BCP_ciberseguridad/view/ver_direcciones.php');
            exit;
        } else {
            echo "No se ha enviado el formulario de modificación correctamente.";
        }
    }

    public function eliminar($id) {
        if (is_numeric($id)) {
            $this->daoDireccion->eliminarDireccion($id);
            $_SESSION['mensaje'] = "Dirección eliminada correctamente";
        } else {
            $_SESSION['mensaje'] = "Error: El id de dirección no es válido.";
        }
    
        header('Location: /Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php');
        exit;
    }
}

if (isset($_GET['action'])) {
    $controller = new ControllerDireccion();

    switch ($_GET['action']) {
        case 'registrar':
            $id_seguridad = isset($GET['id_seguridad']) ? $_GET['id_seguridad'] : null;
            $controller->registrar($id_seguridad);
            break;
        case 'modificar':
            $controller->modificar();
            break;
        case 'eliminar':
            $id = $_GET['id'] ?? null;
            $controller->eliminar($id);
            break;
        default:
            echo "Acción no válida.";
            break;
    }
} else {
}