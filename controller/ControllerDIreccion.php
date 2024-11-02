<?php

require_once '../dao/DaoDireccion.php';
require_once '../dao/DaoSeguridad.php';
include_once '../controller/ControllerEntradas.php';

$entradas = new ControllerEntradas();
$entradas->validarEntrada('index.php');
$entradas->validarServicio('principal.php', $_SESSION['id_seguridad']);

class ControllerDireccion
{
    private $daoDireccion;
    private $daoSeguridad;

    public function __construct()
    {
        $this->daoDireccion = new DaoDireccion();
        $this->daoSeguridad = new DaoSeguridad();
    }

    private function redirect($location)
    {
        header("Location: $location");
        exit;
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRegistrarDireccion'])) {
            $id_seguridad = $_SESSION['id_seguridad'] ?? null;
            $direccion_exacta = trim($_POST['txtdireccion'] ?? '');

            if ($id_seguridad && $this->daoSeguridad->existeSeguridad($id_seguridad) && !empty($direccion_exacta)) {
                $this->daoDireccion->registrarDireccion($id_seguridad, $direccion_exacta, 10, date('Y-m-d'), date('H:i:s'));
                $_SESSION['mensaje'] = "Dirección registrada correctamente";
            } else {
                $_SESSION['mensaje'] = "Error: Debes llenar todos los campos.";
            }
            $this->redirect('/Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php');
        }
    }

    public function modificar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnModificar'])) {
            $id_direccion = $_POST['txtId'] ?? null;
            $direccion_exacta = trim($_POST['txtdireccion'] ?? '');

            if ($id_direccion && !empty($direccion_exacta)) {
                $this->daoDireccion->modificarDireccion($id_direccion, $direccion_exacta, $_POST['txtRango'] ?? 10);
                $_SESSION['mensaje'] = "Dirección modificada correctamente";
            } else {
                $_SESSION['mensaje'] = "Error: Debes llenar todos los campos.";
            }

            $this->redirect('/Prototipado_BCP_ciberseguridad/view/ver_direcciones.php');
        }
    }

    public function eliminar($id)
    {
        if (is_numeric($id)) {
            $this->daoDireccion->eliminarDireccion($id);
            $_SESSION['mensaje'] = "Dirección eliminada correctamente";
        } else {
            $_SESSION['mensaje'] = "Error: El ID de dirección no es válido.";
        }

        $this->redirect('/Prototipado_BCP_ciberseguridad/view/horario_ubicacion.php');
    }
}

$controller = new ControllerDireccion();
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action && method_exists($controller, $action)) {
    $controller->$action($id);
}