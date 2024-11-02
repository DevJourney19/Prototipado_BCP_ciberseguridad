<?php

require_once '../dao/DaoDireccion.php';
require_once '../dao/DaoSeguridad.php';
include_once '../controller/ControllerEntradas.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Cambia a E_ALL & ~E_NOTICE en producción
// Crear una instancia del controlador de entradas
$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

class ControllerDireccion {
    private $daoDireccion;
    private $daoSeguridad;

    public function __construct() {
        session_start(); // Iniciar sesión
        $this->daoDireccion = new DaoDireccion();
        $this->daoSeguridad = new DaoSeguridad();
    }

    public function registrar() {
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

            header('Location: /view/horario_ubicacion.php');
            exit;
        } else {
            echo "No se envió el formulario.";
        }
    }

    public function obtenerDirecciones() {
        return $this->daoDireccion->obtenerTodasDirecciones();
    }

    public function modificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnModificar'])) {
            $id_direccion = $_POST['txtId'] ?? null;
            $direccion_exacta = trim($_POST['txtdireccion'] ?? '');
            $rango_gps = $_POST['txtRango'] ?? 10;
    
            if ($id_direccion && !empty($direccion_exacta)) {
                $this->daoDireccion->modificarDireccion($id_direccion, $direccion_exacta, $rango_gps);
                $_SESSION['mensaje'] = "Dirección modificada correctamente";
            } else {
                $_SESSION['mensaje'] = "Error: Debes llenar todos los campos.";
            }
    
            header('Location: /view/ver_direcciones.php');
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
    
        header('Location: /view/horario_ubicacion.php');
        exit;
    }
}

// Verificar la acción en el controlador
if (isset($_GET['action'])) {
    $controller = new ControllerDireccion();

    switch ($_GET['action']) {
        case 'registrar':
            $controller->registrar();
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