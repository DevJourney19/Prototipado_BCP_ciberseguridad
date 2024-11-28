<?php

header('Content-Type: application/json');
include_once '../dao/DaoUsuario.php';
include_once '../model/Usuario.php';
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

function envioCorreo($lugar, $ip, $hora) {
  session_start();
try {
  $mail = new PHPMailer(true);
  
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  //DEBE SER CORREO DE LA CUENTA DEL CLIENTE EN EL QUE SE QUIERE INGRESAR
  $mail->Username = $_ENV['EMAIL'];
  $mail->Password = $_ENV['PASSWORD']; //Contraseña creada en la verficacion de 2 pasos de Google
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587; //465 para la conexion encriptada

  // Configuración del sms
  $base_url = $_ENV['URL'];
  $api_key = $_ENV['API_KEY'];
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
$mail->Subject = 'Ingreso Bloqueado';
$mail->Body = 'Alguien esta tratando de ingresar a tu cuenta!\nDesde: ' . $lugar . '\Con ip: ' . $ip . '\A las: ' . $hora . '\nSi no fuiste tu, por favor contacta a soporte tecnico e ignora este mensaje.';
$mail->send();

$api = new SmsApi(config: $configuration);
$destination = new SmsDestination(to: $modelUsuario->getTelefono());
$message = new SmsTextualMessage(
  destinations: [$destination],
  text: 'Estan intentando ingresar a tu cuenta bcp desde: ' . $lugar . '\Con ip: ' . $ip . '\A las: ' . $hora
);

$request = new SmsAdvancedTextualRequest(messages: [$message]);
$responseSms = $api->sendSmsMessage($request);


$response = ['status' => 'enviado'];
echo json_encode($response);

}
