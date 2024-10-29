<?php
//FUNCIONES----------------------------------------
function getPublicIp()
{
    //Hacer una solicitud a ipify.org para obtener la IP pública
    $ip = file_get_contents('https://api.ipify.org');
    return $ip;
}
function obtener_info_ip($ip)
{
    //Se construye la url utilizando la dirección ip a consultar 
    $url = "http://ip-api.com/json/" . $ip;

    //Se realiza la solicitud GET a la API para obtener información
    $respuesta = file_get_contents($url);

    //json decode permite crear un array
    $valor = json_decode($respuesta, true);

    //Validar que la API respondió correctamente
    if ($valor['status'] == 'success') {
        return $valor;
    } else {
        return null;
    }
}

function obtener_dispositivo()
{
    //Se detecta que dispositivo se está utilizando por medio de la página web
    $userAgent = $_SERVER['HTTP_USER_AGENT']; //exclusivo de PHP

    if (strpos($userAgent, 'Mobile') !== false) {
        return 'Dispositivo móvil';
    } elseif (strpos($userAgent, 'Tablet') !== false) {
        return 'Tableta';
    } else {
        return 'Ordenador de escritorio';
    }
}

//Obtener la direccion publica


