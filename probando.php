<?php

$dir_ip = getPublicIp();
echo 'Tu direccion publica es : '. $dir_ip;
function getPublicIp()
{
  //Hacer una solicitud a ipify.org para obtener la IP pública
  $ip = file_get_contents('https://api.ipify.org');
  return $ip;
}
