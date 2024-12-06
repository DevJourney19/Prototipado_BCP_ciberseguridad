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

$dir_ip = getPublicIp(); //se obtiene la direccion del dispotivio actual para comparar con la direccion de activación

$info = obtener_info_ip($dir_ip);
$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();
$daoDispositivo = new DaoDispositivo();
$daoHorario = new DaoHorario();
$daoDireccion = new DaoDireccion();

try {
    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);
    if (count($registro) === 1) {
        echo "Registrado exitosamente";
        //USUARIO
        $_SESSION['id_usuario'] = $registro[0]['id_usuario'];
        $id_usuario = $_SESSION['id_usuario'];
        //SEGURIDAD
        $registro2 = $daoSeguridad->readByUser($id_usuario);
        //Va a revisar si esta activado la seguridad
        if ($registro2[0]['activacion_seguridad'] === 1) { 

            $_SESSION['id_seguridad'] = $registro2[0]['id_seguridad'];

            $id_seguridad = $_SESSION['id_seguridad'];
            
            //Verificar si la direccion ip actual ya esta registrada en la base de datos y si es seguro o principal
            $dispositivo_actual = $daoDispositivo->enterAccess($id_seguridad, $dir_ip);

            $direccion_ip_deseada = $dispositivo_actual[0]['direccion_ip'];
            $_SESSION['info'] = $info;
            $_SESSION['direccion_ip'] = $dir_ip;
            $_SESSION['dispositivo'] = obtener_dispositivo();
            $_SESSION['pais'] = $info['country'];
            $_SESSION['ciudad'] = $info['city'];
            $_SESSION['hora'] = date("h:i:s A");
            

            //RECORRER TODOS LOS DISPOSITIVOS QUE PRINCIPAL Y SEGURO PARA VER SI HAY ALGUNA DIRECCION IP QUE COINCIDA CON LA ACTUAL
            if (!empty($direccion_ip_deseada) && $_SESSION['direccion_ip'] === $direccion_ip_deseada) {
                //VERIFICAR SI FUNCIONALIDAD DE BLOQUEO POR HORA ESTA ACTIVADA
                $horario = $registro2[0]['estado_hora_direccion'];
                if ($horario) {
                    //OBTENER HORARIO DE BLOQUEO
                    $horario_restringido = $daoHorario->obtenerHorariosRestringidos($id_seguridad);
                    $hora_actual = date("H:i:s");
                    // SI LA HORA ACTUAL ESTA DENTRO DEL RANGO DE HORAS RESTRINGIDAS
                    if ($hora_actual >= $horario_restringido[0]['hora_inicio'] && $hora_actual <= $horario_restringido[0]['hora_final']) {
                        //OBTENER TODAS LAS DIRECCIONES DE UBICACION SEGURA
                        $direcciones = $daoDireccion->obtenerTodasDirecciones($id_seguridad);
                        $verificar = false;
                        for ($i = 0; $i < count($direcciones); $i++) {
                            // verificar si alguna direccion esta en el rango de ubicacion segura, si esta, dejar ingresar
                            if (verificarUbicacionSegura($dispositivo_actual[0]['latitud'], $dispositivo_actual[0]['longitud'], $direcciones[$i]['latitud'], $direcciones[$i]['longitud'], $direcciones[$i]['rango_gps'])) {
                                $_SESSION['id_dispositivo'] = $dispositivo_actual[0]['id_dispositivo'];
                                $_SESSION['estado_dispositivo'] = $dispositivo_actual[0]['estado_dispositivo'];
                                header("Location: ../view/principal.php");
                                die();
                            }
                        }
                        echo "No se encuentra ninguna ubicacion segura";
                        // si a la hora de recorrer no se encuentra ninguna ubicacion segura, enviar mensaje y no dejar ingresar
                        if (!$verificar) {
                            //enviar mensaje y no dejar ingresar
                            envioCorreo($info['city'], $dir_ip, date("h:i:s A"));
                            $_SESSION['error_ubicacion'] = true;
                            header("Location: ../view/index.php");
                            die();
                        }
                    } else {
                        $_SESSION['id_dispositivo'] = $dispositivo_actual[0]['id_dispositivo'];
                        $_SESSION['estado_dispositivo'] = $dispositivo_actual[0]['estado_dispositivo'];
                        header("Location: ../view/principal.php");
                        die();
                    }
                } else {
                    $_SESSION['id_dispositivo'] = $dispositivo_actual[0]['id_dispositivo'];
                    $_SESSION['estado_dispositivo'] = $dispositivo_actual[0]['estado_dispositivo'];
                    header("Location: ../view/principal.php");
                    die();
                }
            } else { //SI NO COINCIDE EN LA VERIFCACION DE LA DIRECCION IP SE ABRE MODAL
                // PARA REGISTRAR UN NUEVO DIPOSITIVO CON en proceso si
                $_SESSION['noExiste'] = true;
                $_SESSION['error_ubicacion'] = true; 
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
