<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';
include '../dao/DaoDispositivo.php';
include 'direccion_ip.php';
//Evitar ataque SQL INJECTION
$tarjeta = filter_input(INPUT_POST, 'tarjeta', FILTER_SANITIZE_NUMBER_INT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT);
$clave_internet = filter_input(INPUT_POST, 'clave_internet', FILTER_SANITIZE_STRING);
$dir_ip = getPublicIp(); //se obtiene la direccion actual para comparar con la direccion de activación
$info = obtener_info_ip($dir_ip);

$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();
$daoDispositivo = new DaoDispositivo();

try {

    //$consultar = "SELECT * FROM dispositivo WHERE id_seguridad = '$id_seguridad' AND (estado_dispositivo='activado' || estado_dispositivo='seguro') AND direccion_ip='$dir_ip'";

    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);
    if (count($registro) === 1) {
        session_start();
        //USUARIO
        $_SESSION['id_usuario'] = $registro[0]['id_usuario'];
        $id_usuario = $_SESSION['id_usuario'];
        //SEGURIDAD
        $registro2 = $daoSeguridad->readByUser($id_usuario); //Seleccionar la llave foranea de id de usuario pero en seguridad(es decir la seguridad para el cliente tal... Esto se hace para conectar con dispositivo por medio de este valor obtenido)

        if ($registro2[0]['activacion_seguridad'] === 1) { //Va a revisar si esta activado la seguridad 
            $_SESSION['id_seguridad'] = $registro2[0]['id_seguridad'];
            $id_seguridad = $_SESSION['id_seguridad'];
            //DISPOSITIVO
            // $registro3 = $daoDispositivo->enterAccess($id_seguridad, $dir_ip);
            // $_SESSION['id_dispositivo'] = $registro3[0]['id_dispositivo'];
            // $_SESSION['estado_dispositivo'] = $registro3[0]['estado_dispositivo'];
            // $_SESSION['direccion_ip'] = $registro3[0]['direccion_ip'];
            // $id_dispositivo = $_SESSION['id_dispositivo'];
            // $direccion_ip_deseada = $_SESSION['direccion_ip'];
            // $_SESSION['dispositivo'] = obtener_dispositivo();
            // $_SESSION['pais'] = $info['country'];
            // $_SESSION['ciudad'] = $info['city'];
            // $_SESSION['hora'] = date("h:i:s");
            

            // if (empty($direccion_ip_deseada)) { //Si no existe la direccion ip por la comparacion
            //     $_SESSION['error_ubicacion'] = true;
            //     header("Location: ../view/index.php");

            // } else {
            //     header("Location: ../view/principal.php");
            //     die();
            // }
            // ----
            header("Location: ../view/index.php");
        } else {
            header("Location: ../view/index.php");
        }
        // verificar si la direccion ip es existe y es la misma de la principal
        // y colocar en la variable de session el estado de la seguridad
        header("Location: ../view/principal.php");
    } else {
        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}