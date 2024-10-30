<?php

include_once '../dao/DaoUsuario.php';
header('Content-Type: application/json');
require '../vendor/autoload.php';
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

// Configuración del servidor de correo
$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = $_ENV['EMAIL'];
$mail->Password = $_ENV['PASSWORD'];

// Configuración del sms
$base_url = $_ENV['URL'];
$api_key = $_ENV['API_KEY'];
$configuration = new Configuration(host: $base_url, apiKey: $api_key);

try {
  $response = [];
  $data = json_decode(file_get_contents('php://input'), true);

  if (!isset($data['codigo'])) {
    throw new Exception('Codigo is missing in the input');
  }
  $codigo = $data['codigo'];

  $daoUsuario = new DaoUsuario();
  $id_seguridad = $_SESSION['id_seguridad'];
  $usuario = $daoUsuario->read($id_seguridad);

  if (!$usuario) {
    throw new Exception('User not found');
  }

  $nombre = $usuario['nombre'];
  $correo = $usuario['correo'];
  $telefono = $usuario['telefono'];

  if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    throw new Exception('Invalid email address');
  }

  $mail->setFrom("bcp83584@gmail.com", "Banca en Linea BCP");
  $mail->addAddress($correo, $nombre);

  $mail->Subject = 'Codigo de verificacion';
  $mail->Body = 'El codigo de verificacion es: ' . $codigo;

  $mail->send();


  $api = new SmsApi(config: $configuration);
  $destination = new SmsDestination(to: $telefono);
  $message = new SmsTextualMessage(
    destinations: [$destination],
    text: 'El codigo de verificacion es: ' . $codigo
  );

  $request = new SmsAdvancedTextualRequest(messages: [$message]);
  $responseSms = $api->sendSmsMessage($request);


  $response = ['status' => 'enviado'];
} catch (Exception $e) {
  $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
