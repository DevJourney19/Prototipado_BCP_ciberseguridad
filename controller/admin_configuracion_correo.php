<?php
require __DIR__ . '/../vendor/autoload.php';
include_once '../dao/DaoUsuario.php';
include_once '../model/Usuario.php';

use PHPMailer\PHPMailer\Exception;

class AdminConfiguracionCorreo
{
    function entrada()
    {
        $cuerpo = '<!DOCTYPE html>
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
           
    </head>';
        return $cuerpo;
    }
    function cierre($data)
    {
        $cierre = '<p>Atentamente, ' . $data['nombre'] . ' - Administrador </p>
                <p>BCP - CyberSecurity Solutions Group</p>
                <br/>
                <p>Por favor, no dude en contactarnos si tiene alguna duda o necesita asistencia adicional. Puede comunicarse con nosotros a través de nuestro centro de ayuda:</p>
                    <a href="https://www.viabcp.com/ayuda-bcp?rfid=header:ayuda-y-educacion:centro-de-ayuda">https://www.viabcp.com/ayuda-bcp?rfid=header:ayuda-y-educacion:centro-de-ayuda</a>
                </table>';
        return $cierre;
    }
    function contenido_enviar_correo($mail, $emailCliente, $asunto, $cuerpo, $img_asuntos)
    {
        try {
            //Para
            $mail->addAddress(trim($emailCliente));

            //AQUI VA A DIFERIR CONFORME QUE ES LO QUE SE QUIERA ENVIAR A LOS USUARIOS (SWITCH)
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->addEmbeddedImage($img_asuntos[1], $img_asuntos[2]);

            if (!$mail->send()) {
                $mail->clearAddresses();
                return false;
            } else {
                $mail->clearAddresses();
                return true;
            }
        } catch (Exception $e) {
            $mail->clearAddresses();
            return false;
        }

    }
}
?>