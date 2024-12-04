<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';
include '../dao/DaoDispositivo.php';
include '../dao/DaoHorario.php';
include '../dao/DaoDireccion.php';
include 'direccion_ip.php';
include 'envio_mensaje.php';

//Evitar ataque SQL INJECTION
$tarjeta = filter_input(INPUT_POST, 'tarjeta', FILTER_SANITIZE_NUMBER_INT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT);
$clave_internet = filter_input(INPUT_POST, var_name: 'clave_internet', filter: FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$dir_ip = getPublicIp(); //se obtiene la direccion actual para comparar con la direccion de activación
$info = obtener_info_ip($dir_ip);
$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();
$daoDispositivo = new DaoDispositivo();
$daoHorario = new DaoHorario();
$daoDireccion = new DaoDireccion();

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
            $dispositivo_actual = $daoDispositivo->enterAccess($id_seguridad, $dir_ip);

            $direccion_ip_deseada = $dispositivo_actual[0]['direccion_ip'];
            $_SESSION['info'] = $info;
            $_SESSION['direccion_ip'] = $dir_ip;
            $_SESSION['dispositivo'] = obtener_dispositivo();
            $_SESSION['pais'] = $info['country'];
            $_SESSION['ciudad'] = $info['city'];
            $_SESSION['hora'] = date("h:i:s A");

            //SI COINCIDE EN LA VERIFCACION
            if (!empty($direccion_ip_deseada) && $_SESSION['direccion_ip'] === $direccion_ip_deseada) {
                //  COMPARAR CON LA LATITUD Y LONGITUD DE LA DIRECCION DE LA BASE DE DATOS
                $horario = $registro2[0]['estado_hora_direccion'];
                if ($horario) {
                    $horario_restringido = $daoHorario->obtenerHorariosRestringidos($id_seguridad);
                    $hora_actual = date("H:i:s");
                    // si esa fuera del rango de restriccion de hora
                    if ($hora_actual <= $horario_restringido[0]['hora_inicio'] && $hora_actual >= $horario_restringido[0]['hora_final']) {
                        //obtener todas direcciones y recorrer
                        $direcciones = $daoDireccion->obtenerTodasDirecciones($id_seguridad);
                        
                        for ($i = 0; $i < count($direcciones); $i++) {
                            if (verificarUbicacionSegura($dispositivo_actual['latitud'], $dispositivo_actual['longitud'], $direcciones[$i]['latitud'], $direcciones[$i]['longitud'], $direcciones[$i]['rango_gps'])) {
                                $_SESSION['id_dispositivo'] = $dispositivo_actual[0]['id_dispositivo'];
                                $_SESSION['estado_dispositivo'] = $dispositivo_actual[0]['estado_dispositivo'];
                                header("Location: ../view/principal.php");
                                
                            } else {
                                //enviar mensaje y no dejar ingresar
                                envioCorreo($info['city'], $dir_ip, date("h:i:s A"));
                                $_SESSION['error_ubicacion'] = true; //LLAVE PARA ABRIR EL MODAL PARA INGRESAR EL CÓDIGO DE VERIFICACIÓN
                                header("Location: ../view/index.php");
                                die();
                            }
                        }
                    } else {
                        //enviar mensaje y no dejar ingresar

                        $_SESSION['error_ubicacion'] = true; //LLAVE PARA ABRIR EL MODAL PARA INGRESAR EL CÓDIGO DE VERIFICACIÓN
                        header("Location: ../view/index.php");
                        die();
                    }
                } else {
                    $_SESSION['id_dispositivo'] = $dispositivo_actual[0]['id_dispositivo'];
                    $_SESSION['estado_dispositivo'] = $dispositivo_actual[0]['estado_dispositivo'];
                    header("Location: ../view/principal.php");
                    die();
                }
            } else { //SI NO COINCIDE EN LA VERIFCACION
                $_SESSION['error_ubicacion'] = true; //LLAVE PARA ABRIR EL MODAL PARA INGRESAR EL CÓDIGO DE VERIFICACIÓN
                header("Location: ../view/index.php");
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
