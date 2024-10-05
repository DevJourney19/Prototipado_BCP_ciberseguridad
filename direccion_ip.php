<?php

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

//Se obtiene la dirección ip del usuario
//$ip_usuario= $_SERVER['REMOTE_ADDR'];
$ip_usuario = "63.246.135.89";


//Llamamos a la función
$resultado = obtener_info_ip($ip_usuario);

if ($resultado !== null) {
    echo "Tu ip es: " . $ip_usuario . "\n";
    echo "Tu pais es: " . $resultado['country'] . "\n";
    echo "Tu ciudad es: " . $resultado['city'] . "\n";
    echo "Tu latitud es: " . $resultado['lat'] . "\n";
} else {
    echo "No se pudo obtener la información";
}