<?php
require_once '../dao/DaoDispositivo.php';
require_once '../dao/DaoUsuario.php';
require_once '../dao/DaoSeguridad.php';
class ControllerDispositivo
{
    private $daoUsuario;
    private $daoDispositivo;
    public function __construct()
    {
        $this->daoUsuario = new DaoUsuario();
        $this->daoDispositivo = new DaoDispositivo();
    }

    //LLAMADA A CREAR DISPOSITIVO


    public function crearDispositivo()//JSON
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['token_validado'])) {
            $_SESSION['token_validado'] = $data['token_validado'];
            $estado = $data['token_validado'] === true ? 'en_proceso_si' : 'en_proceso_no';
            $this->daoDispositivo->createDevice($estado); //true o false
        }
        echo json_encode(['status' => 'success']);
    }
    public function obtenerDispositivo($id_seguridad)
    {
        return $this->daoDispositivo->readDispoByUserSecurity($id_seguridad);
    }

    //Info del o de los dispositivos que hayan intentado acceder por medio del código de verificacion 
    public function mostrarDispositivos($id_seguridad)
    {
        $response = [];

        //Select para obtener los dispositivos que hayan accedido desde otro dispositivo 
        $resultado_total = $this->daoDispositivo->readDispoByUserSecurity($id_seguridad);

        if ($resultado_total) {
            foreach ($resultado_total as $row) {
                //Agregar dispositivos al array de respuesta
                $response[] = [
                    'id' => $row['id_dispositivo'],
                    'tipo' => $row['tipo_dispositivo'],
                    'dip' => $row['direccion_ip'],
                    'pais' => $row['pais'],
                    'ciudad' => $row['ciudad'],
                    'estado' => $row['estado_dispositivo'],
                    'fecha' => $row['fecha_registro']
                ];
            }
        }
        echo json_encode($response);
    }
    public function cambiar_estado_acciones()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Se trae del input hidden
                $id_dispositivo = $_POST['id_dispositivo'];
                $accion = $_POST['accion'];

                if ($accion === 'eliminar') {
                    $this->daoDispositivo->updateDeviceStatus($accion, $id_dispositivo);
                    $response['message'] = 'Dispositivo eliminado con éxito.';
                } else if ($accion === 'bloquear') {
                    $this->daoDispositivo->updateDeviceStatus($accion, $id_dispositivo);
                    $response['message'] = 'Dispositivo bloqueado con éxito.';
                } else if ($accion === 'permitir') {
                    $this->daoDispositivo->updateDeviceStatus($accion, $id_dispositivo);
                    $response['message'] = 'Dispositivo permitido con éxito.';
                } else if ($accion === 'activar') {
                    $this->daoDispositivo->updateDeviceStatus($accion, $id_dispositivo);
                    $response['message'] = 'Dispositivo activado con éxito.';
                }
                $response['status'] = 'success';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            echo 'Error en el lugar de cambiar_estado: ' . $e->getMessage();
        }
    }
    public function eliminar_dispositivo()
    {
        header('Content-Type: application/json');
        try {
            $id_dispositivo = $_POST['idSeleccionado'];
            $this->daoDispositivo->delete($id_dispositivo);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        echo json_encode(['status' => 'eliminado']);
    }

}
if (isset($_GET['action']) && $_GET['action'] === 'mostrar') {
    $controller = new ControllerDispositivo();
    $controller->mostrarDispositivos($_SESSION['id_seguridad']);
}

if (isset($_GET['action']) && $_GET['action'] === 'getUsuario' && isset($_GET['cambio'])) {
    $controller = new ControllerDispositivo();
    $controller->crearDispositivo();
}
if (isset($_GET['action']) && $_GET['action'] === 'deleteDispo') {
    $controller = new ControllerDispositivo();
    $controller->eliminar_dispositivo();
}
if (isset($_GET['action']) && $_GET['action'] === 'acciones') {
    $controller = new ControllerDispositivo();
    $controller->cambiar_estado_acciones();
}

