<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';
include '../dao/DaoDispositivo.php';
include '../dao/DaoHorario.php';
include '../dao/DaoDireccion.php';
include 'direccion_ip.php';
include 'envio_mensaje.php';
session_start();
//Evitar ataque SQL INJECTION
$tarjeta = filter_input(INPUT_POST, 'tarjeta', FILTER_SANITIZE_NUMBER_INT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT);
$clave_internet = filter_input(INPUT_POST, 'clave_internet', FILTER_SANITIZE_STRING);
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
            $registro3 = $daoDispositivo->enterAccess($id_seguridad, $dir_ip);

            $direccion_ip_deseada = $registro3[0]['direccion_ip'];
            $_SESSION['info'] = $info;
            $_SESSION['direccion_ip'] = $dir_ip;
            $_SESSION['dispositivo'] = obtener_dispositivo();
            $_SESSION['pais'] = $info['country'];
            $_SESSION['ciudad'] = $info['city'];
            $_SESSION['hora'] = date("h:i:s A");

            //SI COINCIDE EN LA VERIFCACION
            if (!empty($direccion_ip_deseada) && $_SESSION['direccion_ip'] === $direccion_ip_deseada) {
                // verificar si hora esta actividado, si no esta activado, se deja ingresar, si esta activado, verificar si la hora de ahora esta en el rango de la hora de bloqueo, si no esta, verificar si la ubicacion de la ip esta un un rango segun lo que se indique en la base de datos de las ubicaciones seguras, si no esta, se envia un correo con la ubicacion y la hora de acceso no autorizado y no deja ingresar.
                $horario = $registro2[0]['estado_hora_direccion'];
                if ($horario) {
                    $horario_restringido = $daoHorario->obtenerHorariosRestringidos($id_seguridad);
                    $hora_actual = date("H:i:s");
                    // si esa fuera del rango de restriccion de hora
                    if ($hora_actual <= $horario_restringido[0]['hora_inicio'] && $hora_actual >= $horario_restringido[0]['hora_final']) {
                        //obtener todas direcciones y recorrer
                        $direcciones = $daoDireccion->obtenerTodasDirecciones($id_seguridad);
                        $datosDispositivo = obtenerCoordenadasIP($dir_ip);
                        for ($i = 0; $i < count($direcciones); $i++) {
                            $datosUbicacion = obtenerCoordenadasOSM($direcciones[$i]['direccion_exacta']);
                            if (verificarUbicacionSegura($datosDispositivo['latitud'], $datosDispositivo['longitud'], $datosUbicacion['latitud'], $datosUbicacion['longitud'], $direcciones[$i]['rango_gps'])) {
                                $_SESSION['id_dispositivo'] = $registro3[0]['id_dispositivo'];
                                $_SESSION['estado_dispositivo'] = $registro3[0]['estado_dispositivo'];
                                header("Location: ../view/principal.php");
                                die();
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
                    $_SESSION['id_dispositivo'] = $registro3[0]['id_dispositivo'];
                    $_SESSION['estado_dispositivo'] = $registro3[0]['estado_dispositivo'];
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
