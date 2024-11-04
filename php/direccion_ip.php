<?php
//include '../config/connection.php';
include '../config/Connection.php/';

$conexion = new Connection(); //se establece una conexion directa con el dao impl
session_start();
//$conexion->conectar();

$id_usuario_no_permitido = $_SESSION["id_no_permitido"];

/*$listaa = $conexion->consultar("SELECT id_seguridad from seguridad 
WHERE id_usuario='$id_usuario_no_permitido'");
*/ //En lugar de ese metodo largo vamos a llamar al metodo de Seguridad




if (count($listaa) > 0) {
    $_SESSION["id_seguridad"] = $listaa[0]["id_seguridad"];
    $id_seguridad = $_SESSION["id_seguridad"];
}

$conexion->desconectar();
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
$resultado = obtener_info_ip($ip_usuario);
//----------------------------------------
$dispositivo = obtener_dispositivo();

function obtener_dispositivo()
{
    //Se detecta que dispositivo se está utilizando por medio de la página web
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($userAgent, 'Mobile') !== false) {
        return 'Dispositivo móvil';
    } elseif (strpos($userAgent, 'Tablet') !== false) {
        return 'Tableta';
    } else {
        return 'Ordenador de escritorio';
    }
}

$fecha_registro = date('Y-m-d H:i:s');
//Agregamos los equipos no deseados a la base de datos
conectar();
/*ejecutar("insert into dispositivos(dispositivo_seguro, tipo_dispositivo, direccion_ip, pais, ciudad, 
fecha_registro) values ('0', '$dispositivo', '$ip_usuario', '$pais', '$ciudad', '$fecha_registro')");*/
//Se tiene que agregar el where id del usuario
if (
    
    ejecutar("INSERT INTO dispositivos (dispositivo_seguro, tipo_dispositivo, direccion_ip, 
    pais, ciudad, fecha_registro, id_seguridad) VALUES (0, '$dispositivo', '$ip_usuario', 
    '{$resultado['country']}', '{$resultado['city']}', '$fecha_registro', '$id_seguridad')")
) {
} else {
    echo "Error al insertar datos: " . mysqli_error($conexion); // Cambia $conexion por tu variable de conexión
}
header("Location: ../index.php?error=true");