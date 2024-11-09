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
    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);
    if (count($registro) === 1) {

        //USUARIO
        $_SESSION['id_usuario'] = $registro[0]['id_usuario'];
        $id_usuario = $_SESSION['id_usuario'];
        //SEGURIDAD
        $registro2 = $daoSeguridad->readByUser($id_usuario);

        if ($registro2[0]['activacion_seguridad'] === 1) { //Va a revisar si esta activado la seguridad 
            $_SESSION['id_seguridad'] = $registro2[0]['id_seguridad'];
            $id_seguridad = $_SESSION['id_seguridad'];
            //DISPOSITIVO
            $registro3 = $daoDispositivo->enterAccess($id_seguridad, $dir_ip);

            $direccion_ip_deseada = $registro3[0]['direccion_ip'];
            $_SESSION['info'] = $info;
            $_SESSION['direccion_ip'] = $dir_ip;
            $_SESSION['dispositivo'] = obtener_dispositivo();
            $_SESSION['pais'] = $info['country'];
            $_SESSION['ciudad'] = $info['city'];
            $_SESSION['hora'] = date("h:i:s A");

            //SI NO COINCIDE EN LA VERIFCACION
            if (empty($direccion_ip_deseada)) { //SE COMPARAN LAS 2 DIRECCIONES IP O LOS ESTADOS DE ACTIVACION O SEGURO PARA PODER INGRESAR
                $_SESSION['error_ubicacion'] = true; //LLAVE PARA ABRIR EL MODAL PARA INGRESAR EL CÓDIGO DE VERIFICACIÓN
                header("Location: ../view/index.php");
                die();
            } else {//SI SI COINCIDE EN LA VERIFCACION
                $_SESSION['id_dispositivo'] = $registro3[0]['id_dispositivo'];
                $_SESSION['estado_dispositivo'] = $registro3[0]['estado_dispositivo'];
                header("Location: ../view/principal.php");
                die();
            }
        } else {
            header("Location: ../view/principal.php");
        }
    } else {
        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}