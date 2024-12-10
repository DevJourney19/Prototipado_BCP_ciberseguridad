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
                $horas = $daoHorario->obtenerHorariosRestringidos($id_seguridad);
                $horasIniContenido = "";
                $horasFinContenido = "";
                if (!empty($horas)) {
                    foreach ($horas as $hora) {
                        $horasIniContenido .= '<li>' . $hora['hora_inicio'] . '</li>';
                        $horasFinContenido .= '<li>' . $hora['hora_final'] . '</li>';
                        $response['failed'][] = $hora['hora_inicio'];
                    }
                } else {
                    $horasIniContenido = "No se registraron horas iniciales configuradas.";
                    $horasFinContenido = "No se registraron horas finales configuradas.";
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
                            ' . $horasIniContenido . '
                            </ul>
                            <h3>Horas finales</h3>
                            <ul>
                            ' . $horasFinContenido . '
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
        //Configuración de dispositivos
        case 4: {
            $descripcion = "dispositivos que ha activado o vinculado, para permitirle el acceso.";
            foreach ($data['objetos'] as $valor) {
                $infoUsuario = $daoUsuario->readUser($valor['id']);
                //Aqui en usuario no se le pone el 0
                $nombreUsuario = $infoUsuario['nombre'];

                $infoSeguridad = $daoSeguridad->readByUser($valor['id']);
                $id_seguridad = $infoSeguridad[0]['id_seguridad'];
                $dispositivos = $daoDispositivo->readDispoByUserSecurity($id_seguridad);
                $verificadosPrincipal = "";
                $verificadosSeguro = "";
                $estado_dispositivos = "";

                if (!empty($dispositivos)) {
                    foreach ($dispositivos as $dvo) {
                        if ($dvo['estado_dispositivo'] === "principal") {

                            $verificadosPrincipal .= '<li> ' . $dvo['tipo_dispositivo'] . ' ( ' . $dvo['ciudad'] . ' - ' . $dvo['pais'] . ' )</li>';
                        } else if ($dvo['estado_dispositivo'] === "seguro") {
                            $verificadosSeguro .= '<li> ' . $dvo['tipo_dispositivo'] . ' ( ' . $dvo['ciudad'] . ' - ' . $dvo['pais'] . ' )</li>';
                        }
                    }
                } else {
                    $verificadosPrincipal = "No se registraron dispositivos principales para permitirles el acceso.";
                    $verificadosSeguro = "No se registraron dispositivos seguros para permitirles el acceso.";
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
                           <h2>Dispositivos con acceso a la cuenta</h2>
                           <br/>
                           <h3>Dispositivos principales</h3>                            
                           <ul>
                            ' . $verificadosPrincipal . '
                            </ul>
                            <br/>
                            <h3>Dispositivos seguros</h3>
                            <ul>
                            ' . $verificadosSeguro . '
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
        //Yape activado
        case 5: {
            $descripcion = "En BCP, sabemos lo importante que es para ti la seguridad de tus operaciones bancarias. 
            Por eso, queremos recordarte la importancia de usar herramientas avanzadas que garanticen la protección de tus transacciones.
            Una de estas herramientas es el Código de Verificación (OTP). Este código es una clave única que se genera automáticamente 
            cada vez que realizas una operación importante, como transferencias de dinero o pagos en línea.";
            foreach ($data['objetos'] as $valor) {
                $infoUsuario = $daoUsuario->readUser($valor['id']);
                //Aqui en usuario no se le pone el 0
                $nombreUsuario = $infoUsuario['nombre'];

                $infoSeguridad = $daoSeguridad->readByUser($valor['id']);
                $estado_yape = $infoSeguridad[0]['estado_yape'];

                if ($estado_yape === 1) {
                    $mensaje = "Estimado cliente, queremos informarle tiene activada la funcionalidad de código de verificación OTP (One-Time Password) para Yape, la cual prevenirá las acciones no autorizadas, brindandote una mayor tranquilidad y seguridad en tu cuenta.";
                } else {
                    $mensaje = "Estimado cliente, queremos informarle que tiene la opción de activar el código de verificación OTP de Yape, para que de esta manera logre aumentar la seguridad de sus transacciones. Esto ayudará a proteger su cuenta contra accesos u acciones no autorizadas.";
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
                            
                           <p>' . $descripcion . '</p>
                           <br/>
                           <h2>¿Tiene la opción para hacer transacciones seguras por Yape?</h2>
                           <br/>
                                          
                           <p>' . $mensaje . '</p>
                            <br/>
                            <h2>¿Cómo funciona?</h2>
                             <br/>
                            <ul>
                            <li><span style="font-weight:800">Verificación interna:</span> Cuando realizas una transacción o accedes desde un dispositivo autorizado, nuestro sistema genera automáticamente un código único que verifica tu identidad en tiempo real, sin necesidad de ingresar datos adicionales.</li>
                            <li><span style="font-weight:800">Asociación con tu número de cliente:</span> Este código se vincula directamente a tu perfil y confirma que eres tú quien realiza la operación.</li>
                            </ul>
                             <br/>
                           <h2>Beneficios de esta función</h2>
                            <br/>
                           <ul>
                           <li><span style="font-weight:800">Mayor seguridad:</span> Cada código es único y solo puede ser utilizado una vez, lo que protege tus operaciones de accesos no autorizados.</li>
                           <li><span style="font-weight:800">Rápida confirmación:</span> Este código asegura que solo tú puedas autorizar tus transacciones en cuestión de segundos.</li>
                           <li><span style="font-weight:800">Tranquilidad garantizada:</span> Con este sistema, puedes realizar tus operaciones con total confianza, sabiendo que tus datos están protegidos.</li>
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