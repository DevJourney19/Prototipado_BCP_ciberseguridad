<?php

$email = $_POST['email'];

if(!empty($email)){

  $asunto = "Envio de correo";
  $cuerpo = "Hola, hemos detectado un intento de inicio de sesion en tu cuenta desde un dispositivo desconocido. Si fuiste tu, por favor ingresa el siguiente codigo: 123456";

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  // Dirección del remitente
  $headers .= "From: $nombre  <$email> \r\n";

  mail($destino, $asunto, $cuerpo, $headers);
  echo "Correo enviado";

}else{
  echo "Error al enviar correo";
}
