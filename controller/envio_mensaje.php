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

session_start();

function envioCorreo($lugar, $ip, $hora)
{
  try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['EMAIL'];
    $mail->Password = $_ENV['PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; //465 para la conexion encriptada

    $daoUsuario = new DaoUsuario();
    $id_seguridad = $_SESSION['id_seguridad'];
    $usuario = $daoUsuario->readUserWithSecurity($id_seguridad, 'seguridad');

    if (!$usuario) {
      throw new Exception('User not found');
    }
    $modelUsuario = new Usuario();
    $modelUsuario->setNombre($usuario[0]['nombre']);
    $modelUsuario->setTelefono($usuario[0]['telefono']);
    $modelUsuario->setCorreo($usuario[0]['correo']);

    if (!filter_var($modelUsuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Invalid email address');
    }

    $mail->setFrom($_ENV['EMAIL'], "Banca en Linea BCP");
    $mail->addAddress($modelUsuario->getCorreo(), $modelUsuario->getNombre());
    $mail->isHTML(true);
    $mail->Subject = 'Ingreso Bloqueado';
    $mail->Body = 'Alguien esta tratando de ingresar a tu cuenta!<br>Desde: ' . $lugar . '<br>Con ip: ' . $ip . '<br>A las: ' . $hora . '<br>Si no fuiste tu, por favor contacta a soporte tecnico e ignora este mensaje.';
    $mail->send();

    // Configuración del sms
    $base_url = $_ENV['URL'];
    $api_key = $_ENV['API_KEY'];
    $configuration = new Configuration(host: $base_url, apiKey: $api_key);

    $api = new SmsApi(config: $configuration);
    $destination = new SmsDestination(to: $modelUsuario->getTelefono());
    $message = new SmsTextualMessage(
      destinations: [$destination],
      text: 'Estan intentando ingresar a tu cuenta bcp desde: ' . $lugar . '\nCon ip: ' . $ip . '\nA las: ' . $hora
    );

    $request = new SmsAdvancedTextualRequest(messages: [$message]);
    $responseSms = $api->sendSmsMessage($request);


    $response = ['status' => 'enviado'];
    echo json_encode($response);
  } catch (Exception $error) {
    echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
  }
}
