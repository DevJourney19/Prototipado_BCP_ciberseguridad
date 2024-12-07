<?php

header('Content-Type: application/json');
include_once '../dao/DaoUsuario.php';
include_once '../model/Usuario.php';
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require __DIR__ . '/../vendor/autoload.php';
include_once '../dao/DaoUsuario.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
  $response = [];
  $data = json_decode(file_get_contents('php://input'), true);

  if (!isset($data['codigo'])) {
    throw new Exception('Codigo is missing in the input');
  }
  $codigo = $data['codigo'];

  $daoUsuario = new DaoUsuario();
  $id_seguridad = $_SESSION['id_seguridad'];
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

  // PHPMailer es utilizado solo para formar el mensaje
  $mail = new PHPMailer(true);

  // Configuración del servidor SMTP
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV['EMAIL']; // Correo SMTP
  $mail->Password = $_ENV['PASSWORD']; // Contraseña SMTP
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $base_url = $_ENV['URL'];
  $api_key = $_ENV['API_KEY'];

  $configuration = new Configuration(
    host: $base_url,
    apiKey: $api_key
  );

  // Configuración del correo
  $mail->setFrom($_ENV['EMAIL'], 'Banca en Linea BCP');
  $mail->addAddress($modelUsuario->getCorreo(), $modelUsuario->getNombre());
  $mail->isHTML(true);
  $mail->Subject = 'Código de Verificación';
  $mail->Body = 'Alguien está tratando de ingresar a tu cuenta!<br>El código de verificación es: ' . $codigo . '<br>Si no fuiste tú, por favor contacta a soporte técnico e ignora este mensaje.';

  $mail->send();


  $configuration = new Configuration(
    host: $base_url,
    apiKey: $api_key
  );
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
} catch (Exception $e) {

  $response = ['status' => 'error'];
  echo json_encode($response);
}
