<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoHorario.php';
include '../dao/DaoSeguridad.php';
include '../dao/DaoDireccion.php';
include '../dao/DaoDispositivo.php';
include '../controller/envio_mensaje.php';
include '../controller/admin_configuracion_correo.php';

$configCorreo = new AdminConfiguracionCorreo();
$e_correo = $configCorreo->entrada();

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
$cierre = $configCorreo->cierre($data);
//Necesito comparar el correo y el valor que coincida que me de el id de usuario
$response = ['success' => [], 'failed' => []];

if (isset($data['opcion'])) {
    $asunto = "Ciberseguridad";

    $daoDireccion = new DaoDireccion();
    $daoSeguridad = new DaoSeguridad();
    $daoUsuario = new DaoUsuario();
    $daoHorario = new DaoHorario();
    $daoDispositivo = new DaoDispositivo();

    switch ($data['opcion']) {
        //Direcciones configuradas
        case 1: {
            $descripcion = "direcciones que usted ha configurado.";
            foreach ($data['objetos'] as $valor) {
                $infoUsuario = $daoUsuario->readUser($valor['id']);
                //Aqui en usuario no se le pone el 0
                $nombreUsuario = $infoUsuario['nombre'];

                $infoSeguridad = $daoSeguridad->readByUser($valor['id']);
                $id_seguridad = $infoSeguridad[0]['id_seguridad'];
                $direcciones = $daoDireccion->obtenerTodasDirecciones($id_seguridad);
                $direccionesContenido = "";
                if (!empty($direcciones)) {
                    foreach ($direcciones as $direccion) {
                        $direccionesContenido .= '<li>' . $direccion['direccion_exacta'] . '</li>';
                    }
                } else {
                    $direccionesContenido = "No se registraron direcciones configuradas.";
                }
                $cuerpo = $e_correo . '
        <body>
            <div class="contenedor">
            
                <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;font-weight:100">
                <br/>
                    <h2 style="color: #132A55;text-align:left;">Hola <span style="text-transform: uppercase">' . $nombreUsuario . ',</span></h2>
                    <br/>
                    <tr>
                        <td style="padding: 0; color: #132A55;text-align:left">
                            
                           <p >Le enviamos el presente correo para informarle acerca de las <span style=font-weight:800>' . $descripcion . '</span> Le enviamos esta información para que pueda corroborar las direcciones configuradas por usted, a su vez que pueda ver que dispositivos están configurados para poder obtener acceso.</p>
                           <br/>
                           <h2>Direcciones configuradas</h2>
                           <br/>
                            <ul>
                            ' . $direccionesContenido . '
                            </ul>
                        </td>
                    </tr>
                    <br/>
                    <div style="color:#132A55">
                    ' . $cierre . '
                    </div>
            </div>
        </body>
    </html>';

                if ($configCorreo->contenido_enviar_correo($mail, $valor['correo'], $asunto, $cuerpo)) {
                    $response['success'][] = $valor['correo'];
                } else {
                    $response['failed'][] = $valor['correo'];
                }
            }
            break;
        }
        case 2: {
            $descripcion = "horas que usted ha configurado.";
            foreach ($data['objetos'] as $valor) {
                $infoUsuario = $daoUsuario->readUser($valor['id']);
                //Aqui en usuario no se le pone el 0
                $nombreUsuario = $infoUsuario['nombre'];

                $infoSeguridad = $daoSeguridad->readByUser($valor['id']);
                $id_seguridad = $infoSeguridad[0]['id_seguridad'];
                $horarios = $daoHorario->obtenerHorariosRestringidos($id_seguridad);
                $horariosIniContenido = "";
                $horariosFinContenido = "";
                if (!empty($horarios)) {
                    foreach ($horarios as $hora) {
                        $horariosIniContenido .= '<li>' . $hora['horario_inicio'] . '</li>';
                        $horariosFinContenido .= '<li>' . $hora['horario_final'] . '</li>';
                    }
                } else {
                    $horariosIniContenido = "No se registraron horas iniciales configuradas.";
                    $horariosFinContenido = "No se registraron horas finales configuradas.";
                }

                $cuerpo = $e_correo . '
        <body>
            <div class="contenedor">
            
                <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;font-weight:100">
                <br/>
                    <h2 style="color: #132A55;text-align:left;">Hola <span style="text-transform: uppercase">' . $nombreUsuario . ',</span></h2>
                    <br/>
                    <tr>
                        <td style="padding: 0; color: #132A55;text-align:left">
                            
                           <p >Le enviamos el presente correo para informarle acerca de las <span style=font-weight:800>' . $descripcion . '</span> Le enviamos esta información para que pueda corroborar las direcciones configuradas por usted, a su vez que pueda ver que dispositivos están configurados para poder obtener acceso.</p>
                           <br/>
                           <h2>Horas configuradas</h2>
                           <br/>
                           <h3>Horas iniciales</h3>
                            <ul>
                            ' . $horariosIniContenido . '
                            </ul>
                            <h3>Horas finales</h3>
                            <ul>
                            ' . $horariosFinContenido . '
                            </ul>
                        </td>
                    </tr>
                    <br/>
                    <div style="color:#132A55">
                    ' . $cierre . '
                    </div>
            </div>
        </body>
    </html>';

                if ($configCorreo->contenido_enviar_correo($mail, $valor['correo'], $asunto, $cuerpo)) {
                    $response['success'][] = $valor['correo'];
                } else {
                    $response['failed'][] = $valor['correo'];
                }
            }
            break;
        }
        //Acceso de dispositivos
        case 3: {
            $descripcion = "intentos de acceso que usted ha recibido.";
            foreach ($data['objetos'] as $valor) {
                $infoUsuario = $daoUsuario->readUser($valor['id']);
                //Aqui en usuario no se le pone el 0
                $nombreUsuario = $infoUsuario['nombre'];

                $infoSeguridad = $daoSeguridad->readByUser($valor['id']);
                $id_seguridad = $infoSeguridad[0]['id_seguridad'];
                $dispositivos = $daoDispositivo->readDispoByUserSecurity($id_seguridad);
                $verificadosSiContenido = "";
                $verificadosNoContenido = "";
                $estado_dispositivos = "";
                $countCodigoSi = 0;
                $countCodigoNo = 0;

                if (!empty($dispositivos)) {
                    foreach ($dispositivos as $dvo) {
                        if ($dvo['estado_dispositivo'] === "en_proceso_si") {
                            $countCodigoSi++;
                            $verificadosSiContenido .= '<li> ' . $dvo['tipo_dispositivo'] . ' ( ' . $dvo['ciudad'] . ' - ' . $dvo['pais'] . ' )</li>';
                        } else if ($dvo['estado_dispositivo'] === "en_proceso_no") {
                            $countCodigoNo++;
                            $verificadosNoContenido .= '<li> ' . $dvo['tipo_dispositivo'] . ' ( ' . $dvo['ciudad'] . ' - ' . $dvo['pais'] . ' )</li>';
                        }
                    }
                } else {
                    $verificadosSiContenido = "No se registraron dispositivos que hayan ingresado el código esperado.";
                    $verificadosNoContenido = "No se registraron dispositivos que hayan ingresado el código de manera errónea.";
                }

                $cuerpo = $e_correo . '
        <body>
            <div class="contenedor">
            
                <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;font-weight:100">
                <br/>
                    <h2 style="color: #132A55;text-align:left;">Hola <span style="text-transform: uppercase">' . $nombreUsuario . ',</span></h2>
                    <br/>
                    <tr>
                        <td style="padding: 0; color: #132A55;text-align:left">
                            
                           <p >Le enviamos el presente correo para informarle acerca de los <span style=font-weight:800>' . $descripcion . '</span> Le enviamos esta información para que pueda corroborar las direcciones configuradas por usted, a su vez que pueda ver que dispositivos están configurados para poder obtener acceso.</p>
                           <br/>
                           <h2>Dispositivos con los que se ha intentado ingresar</h2>
                           <br/>
                           <h3>Total de dispositivos con los que se ingresó el código de verificación: <span>' . $countCodigoSi . '</span></h3>                            
                           <ul>
                            ' . $verificadosSiContenido . '
                            </ul>
                            <br/>
                            <h3>Total de dispositivos con los que NO se ingresó el código de verificación: <span>' . $countCodigoNo . '</span></h3>
                            <ul>
                            ' . $verificadosNoContenido . '
                            </ul>
                        </td>
                    </tr>
                    <br/>
                    <div style="color:#132A55">
                    ' . $cierre . '
                    </div>
            </div>
        </body>
    </html>';

                if ($configCorreo->contenido_enviar_correo($mail, $valor['correo'], $asunto, $cuerpo)) {
                    $response['success'][] = $valor['correo'];
                } else {
                    $response['failed'][] = $valor['correo'];
                }
            }
            break;
        }
    }

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'No se recibieron correos válidos.']);
}

?>