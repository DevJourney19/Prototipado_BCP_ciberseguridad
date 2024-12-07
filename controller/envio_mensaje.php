<?php

header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';
include_once '../dao/DaoUsuario.php';
include_once '../model/Usuario.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

class EnvioMensaje {
    private $modelUsuario;
    private $daoUsuario;
    private $id_seguridad;
    private $usuario;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->daoUsuario = new DaoUsuario();
        $this->id_seguridad = $_SESSION['id_seguridad'];
        echo $this->id_seguridad;
        $this->usuario = $this->daoUsuario->readUserWithSecurity($this->id_seguridad, 'seguridad');

        if (!$this->usuario) {
            throw new Exception('User not found');
        }

        $this->modelUsuario = new Usuario();
        $this->modelUsuario->setNombre($this->usuario['nombre']);
        $this->modelUsuario->setTelefono($this->usuario['telefono']);
        $this->modelUsuario->setCorreo($this->usuario['correo']);

        if (!filter_var($this->modelUsuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
    }

    public function envioCorreo($lugar, $ip, $hora) {
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL'];
            $mail->Password = $_ENV['PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_ENV['EMAIL'], "Banca en Linea BCP");
            $mail->addAddress($this->modelUsuario->getCorreo(), $this->modelUsuario->getNombre());
            $mail->isHTML(true);
            $mail->Subject = 'Ingreso Bloqueado';
            $mail->Body = 'Alguien está tratando de ingresar a tu cuenta!<br>Desde: ' . $lugar . '<br>Con ip: ' . $ip . '<br>A las: ' . $hora . '<br>Si no fuiste tú, por favor contacta a soporte técnico e ignora este mensaje.';

            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
        }
    }

    public function envioSms($lugar, $ip, $hora) {
        $configuration = new Configuration(
            host: $_ENV['URL'],
            apiKey: $_ENV['API_KEY']
        );

        $api = new SmsApi(config: $configuration);
        $destination = new SmsDestination(to: $this->modelUsuario->getTelefono());
        $message = new SmsTextualMessage(
            destinations: [$destination],
            text:  "Están intentando ingresar a tu cuenta BCP desde: $lugar\nCon IP: $ip\nA las: $hora"
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);
        $responseSms = $api->sendSmsMessage($request);

        $response = ['status' => 'enviado'];
        echo json_encode($response);
    }
}