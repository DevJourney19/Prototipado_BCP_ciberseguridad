<?php
session_start();
header('Content-Type: application/json');
include_once '../dao/DaoSeguridad.php';
include_once '../dao/DaoDispositivo.php';
include_once '../model/Dispositivo.php';
include_once '../model/Usuario.php';
include_once '../dao/DaoUsuario.php';
include 'direccion_ip.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos necesarios están presentes
try {

  $daoSeguridad = new DaoSeguridad();
  $daoDispositivo = new DaoDispositivo();
  $daoUsuario = new DaoUsuario();
  $id = $_SESSION['id_usuario'];

  // Ejecutar la consulta, cambiar el telefono y correo del usuario

  $usuario = new Usuario();
  $telefono = $data['telefono'];
  $correo = $data['correo'];
  $usuario->setTelefono($telefono);
  $usuario->setCorreo($correo);
  $usuario->setIdUsuario($id);
  $latitud = $data['latitud'];
  $longitud = $data['longitud'];

  if ($daoSeguridad->verificarActivaciones($id) && $daoUsuario->updateUser($usuario)) {
    $response = ['status' => 'registrado'];
    $result = $daoSeguridad->readByUser($id);
    $_SESSION['id_seguridad'] = $result[0]['id_seguridad'];
    // Crear el dispositivo en la base de datos -> verificar si ya hay un principal editarlo
    $dir_ip = getPublicIp(); //se obtiene la direccion actual para comparar con la direccion de activación
    $info = obtener_info_ip($dir_ip);
    $_SESSION['info'] = $info;
    $_SESSION['direccion_ip'] = $dir_ip;
    $_SESSION['dispositivo'] = obtener_dispositivo();
    $_SESSION['pais'] = $info['country'];
    $_SESSION['ciudad'] = $info['city'];

    $modelo_dispositivo = new Dispositivo();
    $modelo_dispositivo->setIdSeguridad($_SESSION['id_seguridad']);
    $modelo_dispositivo->setDireccionIp($dir_ip);
    $modelo_dispositivo->setPais($info['country']);
    $modelo_dispositivo->setCiudad($info['city']);
    $modelo_dispositivo->setTipoDispositivo(obtener_dispositivo());
    $modelo_dispositivo->setEstadoDispositivo('principal');
    $modelo_dispositivo->setLatitud($latitud);
    $modelo_dispositivo->setLongitud($longitud);
    $daoDispositivo->createDevice($modelo_dispositivo);
    unset($result);
  } else {
    $response = ['status' => 'no registrado'];
  }
} catch (Exception $e) {
  echo "Error: " . $e;
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'error'
  ];
}

// Enviar la respuesta en formato JSON
echo json_encode($response);
