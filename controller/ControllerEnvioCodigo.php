<?php

header('Content-Type: application/json');
include_once '../dao/DaoUsuario.php';
include_once '../model/Usuario.php';
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
  $mail = new PHPMailer(true);

  $base_url = $_ENV['URL'];
  $api_key = $_ENV['API_KEY'];
  //Configura los parámetros para trabajar con infobip [infobip]
  $configuration = new Configuration(host: $base_url, apiKey: $api_key);

  //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $response = [];
  $data = json_decode(file_get_contents('php://input'), true);

  if (!isset($data['codigo'])) {
    throw new Exception('Codigo is missing in the input');
  }
  $codigo = $data['codigo'];
} catch (Exception $error) {
  echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
}

$daoUsuario = new DaoUsuario();
$id_seguridad = $_SESSION['id_seguridad'];
//echo $id_seguridad;
$usuario = $daoUsuario->readUserWithSecurity($id_seguridad, 'seguridad');

if (!$usuario) {
  throw new Exception('User not found');
}
$modelUsuario = new Usuario();
$modelUsuario->setNombre($usuario['nombre']);
$modelUsuario->setTelefono($usuario['telefono']);
$modelUsuario->setCorreo($usuario['correo']);

if (!filter_var($modelUsuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
  throw new Exception('Invalid email address');
}

$mail->setFrom("bcp83584@gmail.com", "Banca en Linea BCP");
$mail->addAddress($modelUsuario->getCorreo(), $modelUsuario->getNombre());
$mail->Subject = 'Codigo de verificacion';
$mail->Body = 'Alguien esta tratando de ingresar a tu cuenta!<br>El codigo de verificacion es: ' . $codigo . '\n Si no fuiste tu, por favor contacta a soporte tecnico e ignora este mensaje.';
$mail->send();

//Envio de SMS [Se trabajó con la configuración de infoip]
$api = new SmsApi(config: $configuration);
$destination = new SmsDestination(to: $modelUsuario->getTelefono());
$message = new SmsTextualMessage(
  destinations: [$destination],
  text: 'El codigo de verificacion es: ' . $codigo
);

$request = new SmsAdvancedTextualRequest(messages: [$message]);
$responseSms = $api->sendSmsMessage($request);


$response = ['status' => 'enviado'];
echo json_encode($response);


