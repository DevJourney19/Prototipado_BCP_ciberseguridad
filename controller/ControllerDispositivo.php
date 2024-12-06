<?php
session_start();
require_once '../dao/DaoDispositivo.php';
require_once '../dao/DaoUsuario.php';
require_once '../dao/DaoSeguridad.php';
require_once '../model/Dispositivo.php';
class ControllerDispositivo
{
    private $daoUsuario;
    private $daoDispositivo;
    public function __construct()
    {
        $this->daoUsuario = new DaoUsuario();
        $this->daoDispositivo = new DaoDispositivo();
    }
    
    public function crearDispositivo()//JSON
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['token_validado'])) {
            $_SESSION['token_validado'] = $data['token_validado'];
            $estado = $data['token_validado'] === true ? 'en_proceso_si' : 'en_proceso_no';
            $modelo_direccion = new Dispositivo();
            $modelo_direccion->setIdSeguridad($_SESSION['id_seguridad']);
            $modelo_direccion->setDireccionIp($_SESSION['direccion_ip']);
            $modelo_direccion->setTipoDispositivo($_SESSION['dispositivo']);
            $modelo_direccion->setPais($_SESSION['info']['country']);
            $modelo_direccion->setCiudad($_SESSION['info']['city']);
            $modelo_direccion->setEstadoDispositivo($estado);
            $modelo_direccion->setLatitud($data['latitud']);
            $modelo_direccion->setLongitud($data['longitud']);
            $this->daoDispositivo->createDevice($modelo_direccion);
        }
        echo json_encode(['status' => 'success']);
    }
    public function obtenerDispositivo($id_seguridad)
    {
        return $this->daoDispositivo->readDispoByUserSecurity($id_seguridad);
    }
    public function obtenerDispositivosFiltrados($id_seguridad)
    {
        return $this->daoDispositivo->readDispoByUserSecurityFilter($id_seguridad);
    }
    public function obtenerDispositivosEnProceso($id_seguridad)
    {
        return $this->daoDispositivo->readDispoByUserSecurityFilterProcess($id_seguridad);
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
                //Se trae del data-id
                $id_dispositivo = $_POST['id_dispositivo'];
                $accion = $_POST['accion'];

                $resultado = $this->daoDispositivo->updateDeviceStatus($accion, $id_dispositivo);

                if ($resultado) {
                    if ($accion !== "eliminar") {
                        $dispositivo_actualizado = $this->daoDispositivo->readById( $id_dispositivo);
                        $response['data'] = $dispositivo_actualizado;
                    }
                    $response['status'] = 'success';
                    $response['message'] = "Dispositivo " . $accion . " con exito";
                }else{
                    $response['status'] = 'error';
                    $response['message'] = "No se pudo realizar la acción de $accion";
                }
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
    // si el dispotivio no existe crear otro
    if (isset($_SESSION['noExiste']) && $_SESSION['noExiste'] === true) {
        $controller->crearDispositivo();
    }else{
        echo json_encode(['mensaje' => 'No cambio']);
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'deleteDispo') {
    $controller = new ControllerDispositivo();
    $controller->eliminar_dispositivo();
}
if (isset($_GET['action']) && $_GET['action'] === 'acciones') {
    $controller = new ControllerDispositivo();
    $controller->cambiar_estado_acciones();
}

