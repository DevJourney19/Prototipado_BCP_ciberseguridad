<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$mail = new PHPMailer(true);
//Configura todo con SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
$mail->SMTPAuth = true;
//Registro de smtp, solo email y password
$mail->Username = $_ENV['EMAIL'];  // Tu correo de Gmail
$mail->Password = $_ENV['PASSWORD'];      // Tu contraseña de Gmail
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
//De
$mail->setFrom($_ENV['EMAIL'], 'Banca en Linea BCP - Ciberseguridad');

// Leer datos enviados desde JavaScript
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['correos']) && is_array($data['correos']) && isset($data['opcion'])) {
    $img = null;
    switch ($data['opcion']) {
        case 1: {
            $asunto = mb_encode_mimeheader("¿Cómo tener una cuenta más segura? 🤓🙌 - Ciberseguridad", "UTF-8");
            //Tiene que tener el cid si o si como parte del src
            $img_cid = "cid:img_cb_1.jpg";
            $descripcion = "como tener una cuenta más segura.";
            break;
        }
        case 2: {
            $asunto = mb_encode_mimeheader("Novedades 😎😎 - Ciberseguridad", "UTF-8");
            $img_cid = "cid:img_cb_2.jpg";
            $descripcion = "novedades que se implementará en un futuro, que quizás le interese, con respecto al servicio de ciberseguridad que tiene adquirido.";
            break;
        }
        case 3: {
            $asunto = mb_encode_mimeheader("Plan de servicio 🤝🤝 - Ciberseguridad", "UTF-8");
            $img_cid = "cid:img_cb_3.jpg";
            $descripcion = "si su plan de servicio está por vencer, cómo poder actuar para seguir usando este confiable servicio de ciberseguridad.";
            break;
        }
    }

    $response = ['success' => [], 'failed' => []];
    $cuerpo = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
        <title>Envio de email de forma masiva - BCP</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Roboto", sans-serif;
            font-size: 16px;
            font-weight: 300;
            color: #888;
            background-color:rgba(230, 225, 225, 0.5);
            line-height: 30px;
            text-align: center;
        }
        .contenedor{
            width: 80%;
            min-height:auto;
            text-align: center;
            margin: 0 auto;
            background: white;
            border-top: 3px solid #E64A19;
        }
        .btnlink{
            padding:15px 30px;
            text-align:center;
            background-color:#cecece;
            color: crimson !important;
            font-weight: 600;
            text-decoration: blue;
        }
        .btnlink:hover{
            color: #fff !important;
        }
        .imgBanner{
            max-width:48%;
            margin-left: auto;
            margin-right: auto;
            display: block;
            padding:0px;
        }
        .misection{
            color: #34495e;
            margin: 4% 10% 2%;
            text-align: center;
            font-family: sans-serif;
        }
        .mt-5{
            margin-top:50px;
        }
        .mb-5{
            margin-bottom:50px;
        }
        </style>
           
    </head>
    <body>
        <div class="contenedor">
        
            <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
            <br/>
                <p>Le enviamos el presente correo para informarle acerca de ' . $descripcion . ' Encontrará en el archivo adjunto información detallada que consideramos de su interés.</p>
                <br/>
                <tr>
                    <td style="padding: 0">
                        <img style="width:100%; padding: 0; display: block" src="' . $img_cid . '">
                    </td>
                </tr>
                <br/>
                <p>Atentamente, ' . $data['nombre'] . ' - Administrador </p>
                <p>BCP - CyberSecurity Solutions Group</p>
                <br/>
                <p>Por favor, no dude en contactarnos si tiene alguna duda o necesita asistencia adicional. Puede comunicarse con nosotros a través de nuestro centro de ayuda:</p>
                    <a href="https://www.viabcp.com/ayuda-bcp?rfid=header:ayuda-y-educacion:centro-de-ayuda">https://www.viabcp.com/ayuda-bcp?rfid=header:ayuda-y-educacion:centro-de-ayuda</a>
                </table>
        </div>
    </body>
</html>';

    foreach ($data['correos'] as $emailCliente) {
        try {
            //Para
            $mail->addAddress(trim($emailCliente));

            //AQUI VA A DIFERIR CONFORME QUE ES LO QUE SE QUIERA ENVIAR A LOS USUARIOS (SWITCH)
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;

            if ($img_cid === "cid:img_cb_1.jpg") {
                $mail->addEmbeddedImage('../view/img/img_cb_1.jpg', 'img_cb_1.jpg');
            } else if ($img_cid === "cid:img_cb_2.jpg") {
                $mail->addEmbeddedImage('../view/img/img_cb_2.jpg', 'img_cb_2.jpg');
            } else if ($img_cid === "cid:img_cb_3.jpg") {
                $mail->addEmbeddedImage('../view/img/img_cb_3.jpg', 'img_cb_3.jpg');
            }

            if (!$mail->send()) {
                $response['failed'][] = $emailCliente;
            } else {
                $response['success'][] = $emailCliente;
            }
        } catch (Exception $e) {
            $response['failed'][] = $emailCliente;
        }
        $mail->clearAddresses();
    }
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'No se recibieron correos válidos.']);
}
?>