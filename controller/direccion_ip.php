<?php
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

    // Clasificar el tipo de dispositivo usando switch
    switch (true) {
        case strpos($userAgent, 'Windows') !== false:
        case strpos($userAgent, 'Macintosh') !== false:
        case strpos($userAgent, 'Linux') !== false:
            return 'Ordenador de escritorio';

        case strpos($userAgent, 'Mobile') !== false:
            return 'Teléfono móvil';

        case strpos($userAgent, 'Tablet') !== false:
        case strpos($userAgent, 'iPad') !== false:
        case (strpos($userAgent, 'Android') !== false && strpos($userAgent, 'Mobile') === false):
            return 'Tableta';

        case strpos($userAgent, 'SmartWatch') !== false:
            return 'Smartwatch';

        case strpos($userAgent, 'SmartTV') !== false:
        case strpos($userAgent, 'TV') !== false:
            return 'Televisor inteligente';

        case strpos($userAgent, 'Nintendo') !== false:
        case strpos($userAgent, 'PlayStation') !== false:
        case strpos($userAgent, 'Xbox') !== false:
            return 'Consola de videojuegos';

        case strpos($userAgent, 'IoT') !== false:
        case strpos($userAgent, 'Raspberry') !== false:
            return 'Dispositivo IoT';

        default:
            return 'Tipo de dispositivo no reconocido';
    }
}