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

function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371; // Radio de la Tierra en kilómetros

    // Convertir de grados a radianes
    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    // Fórmula de Haversine
    $deltaLat = $lat2Rad - $lat1Rad;
    $deltaLon = $lon2Rad - $lon1Rad;

    $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
        cos($lat1Rad) * cos($lat2Rad) *
        sin($deltaLon / 2) * sin($deltaLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distancia = $radioTierra * $c; // Resultado en kilómetros

    return $distancia;
}

function verificarUbicacionSegura($latDispositivo, $lonDispositivo, $latDireccion, $lonDireccion, $rango)
{

    $distancia = calcularDistancia($latDispositivo, $lonDispositivo, $latDireccion, $lonDireccion);
    $rango = $rango / 1000; // Convertir el rango de metros a kilómetros
    if ($distancia <= $rango) { 
        echo "El dispositivo está dentro del rango permitido.";
        return true;
    } else {
        echo "El dispositivo está fuera del rango permitido.";
        return false;
    }
}


function obtenerCoordenadasOSM($direccion) {
    $direccionEncoded = urlencode($direccion);
    $url = "https://nominatim.openstreetmap.org/search?q=$direccionEncoded&format=json&limit=1";

    $respuesta = file_get_contents($url);
    $datos = json_decode($respuesta, true);

    if (!empty($datos)) {
        return ['latitud' => $datos[0]['lat'], 'longitud' => $datos[0]['lon']];
    }
    return ['error' => 'No se encontraron coordenadas'];
}

function obtenerCoordenadasIP($ip) {
    $url = "https://ipinfo.io/$ip/json";
    $respuesta = file_get_contents($url);
    $datos = json_decode($respuesta, true);

    if (isset($datos['loc'])) {
        list($latitud, $longitud) = explode(',', $datos['loc']);
        return ['latitud' => $latitud, 'longitud' => $longitud];
    }
    return ['error' => 'No se pudo obtener la ubicación de la IP'];
}
