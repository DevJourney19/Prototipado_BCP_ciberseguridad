<?php
session_start();
include 'util/connection.php';
include_once 'direccion_ip.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$clave_internet = $_POST['clave_internet']; // Cambié de $pin a $clave_internet
$direccion_ip_deseada = null;
$dir_ip = getPublicIp(); //se obtiene la direccion actual para comparar con la direccion de activación

//Para mostrar en el modal del alert
$info = obtener_info_ip($dir_ip);
$dispositivo = obtener_dispositivo();
$_SESSION['dispositivo'] = $dispositivo;
$_SESSION['pais'] = $info['country'];
$_SESSION['ciudad'] = $info['city'];
$hora_actual = date("h:i:s");
$_SESSION['hora'] = $hora_actual;


// Corregir la consulta para desencriptar el pin almacenado y compararlo con el ingresado
$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni' AND AES_DECRYPT(clave_internet, 'D9u#F5h8*Z3kB9!nL7^mQ4') = '$clave_internet'";

//$verificar_entradas = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' OR dni = '$dni'";
$verificar_ip_activada = "SELECT * FROM usuario WHERE ip_principal= '$dir_ip'";
//Se hace esto para crear una Session para poder enviarle el registro al cliente
//1. Entrar a seguridad por medio del id del usuario

//2. Entrar a dispositivos por el id de seguridad

try {
    conectar();
    $direccion_ip_deseada = consultar($verificar_ip_activada);

    $registro = consultar($validar_login);
    //$direccion_seguridad = "SELECT * FROM seguridad WHERE id_usuario= " . $registro['id_usuario'];
    //$valores = consultar($direccion_seguridad);
    //$entrada_no_deseada = consultar($verificar_entradas);

    desconectar();

    if (count($registro) == 1) {
        
        $_SESSION['security'] = '12345';

        $_SESSION['id_usuario'] = $registro[0]['id_usuario'];
        $id_usuario = $_SESSION['id_usuario'];

        conectar();
        $part1 = "SELECT * FROM seguridad WHERE id_usuario = '$id_usuario'";
        $part1_consul = consultar($part1);
        $_SESSION['id_seguridad'] = $part1_consul[0]['id_seguridad'];
        $id_seguridad = $_SESSION['id_seguridad'];
        desconectar();
        conectar();
        $part2 = "SELECT * FROM dispositivos WHERE id_seguridad = '$id_seguridad'";
        $part2_consul = consultar($part2);
        $_SESSION['id_dispositivo'] = $part2_consul[0]['id_dispositivo'];
        $id_dispositivo = $_SESSION['id_dispositivo'];
        desconectar();

        //En caso la direccion ip activada no coincide
        if (empty($direccion_ip_deseada)) {
            $_SESSION['error_ubicacion'] = true;
            header("Location: ../view/index.php");
        } else {
            $sqlSeguridad = "SELECT * FROM seguridad WHERE id_usuario = " . $id_usuario;
            conectar();
            $resultado = consultar($sqlSeguridad);
            desconectar();
            $idSeguridad = $resultado[0]['id_seguridad'];
            if ($resultado[0]['activacion_seguridad'] == 1) {
                $_SESSION['id_seguridad'] = $idSeguridad;
            }
            header("Location: ../view/principal.php");
        }
    } else {
        session_destroy();
        header("Location: ../view/index.php?error=true");
    }

} catch (Exception $exc) {
    die($exc->getMessage());
}

/*
} else if (count($entrada_no_deseada) == 1) {
session_start();
$_SESSION['id_no_permitido'] = $entrada_no_deseada[0]['id_usuario'];

//Como puedo hacer para que no me lleve a esa direccion solo que ejecute codigo?
//echo "<script>window.location.href = 'direccion_ip.php';</script>";

} else {
session_destroy();
header("Location: ../index.php?error=true");
}*/