<?php

header('Content-Type: application/json');
include_once '../dao/DaoUsuario.php';


use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

session_start();

try {

  $mail = new PHPMailer(true);

  //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  //DEBE SER CORREO DE LA CUENTA DEL CLIENTE EN EL QUE SE QUIERE INGRESAR
  $mail->Username = '';
  $mail->Password = ''; //Contraseña creada en la verficacion de 2 pasos de Google
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587; //465 para la conexion encriptada

  $response = [];
  $data = json_decode(file_get_contents('php://input'), true);

  if (!isset($data['codigo'])) {
    throw new Exception('Codigo is missing in the input');
  }
  $codigo = $data['codigo'];
  /*
  $daoUsuario = new DaoUsuario();
  $id_seguridad = $_SESSION['id_seguridad'];
  //echo $id_seguridad;
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
*/
  $mail->setFrom("", "Banca en Linea BCP");
  $mail->addAddress("", "Juan");

  $mail->Subject = 'Codigo de verificacion';
  $mail->Body = 'El codigo de verificacion es: ' . $codigo;

  if ($mail->send()) {
    //$_SESSION['email_sent'] = true;
    $response = ['status' => 'enviado'];
  } else {
    $response = ['status' => 'error', 'message' => 'No se pudo enviar el correo.'];
  }


} catch (Exception $e) {
  $response = ['status' => 'error', 'message' => $e->getMessage()];
  error_log($e->getMessage());
}

echo json_encode($response);
