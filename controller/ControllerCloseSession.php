<?php
require_once '../dao/DaoDispositivo.php';
session_start();

$controller = new ControllerCloseSession();
$controller->actualizar_ult_conexion_dispositivo($_SESSION['id_dispositivo']);

class ControllerCloseSession
{
    private $daoDispositivo;
    public function __construct()
    {
        $this->daoDispositivo = new DaoDispositivo();
    }
    function actualizar_ult_conexion_dispositivo($id_dispositivo)
    {
        header('Content-Type: application/json');
        try {
            $this->daoDispositivo->updateDate($id_dispositivo);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
session_destroy();
header("Location: ../view/index.php?logout=true");
exit();
