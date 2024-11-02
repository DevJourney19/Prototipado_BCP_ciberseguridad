<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';

//Evitar ataque SQL INJECTION
$tarjeta = filter_input(INPUT_POST, 'tarjeta', FILTER_SANITIZE_NUMBER_INT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT);
$clave_internet = filter_input(INPUT_POST, 'clave_internet', FILTER_SANITIZE_STRING);

$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();

try {
    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);
    if (count($registro) == 1) {
        session_start();

<<<<<<< HEAD
        $resultado = $daoUsuario->read($_SESSION['id_usuario']);
        $idSeguridad = $resultado[0]['id_seguridad']; //retorna el id de seguridad

        if ($resultado[0]['activacion_seguridad'] == 1) {
            $_SESSION['id_seguridad'] = $idSeguridad;

            if(){
                
            }
        }

        header("Location: ../view/principal.php");

        //AQUI ->
    } else {
=======
        $_SESSION['id'] = $registro[0]['id_usuario'];
        echo $_SESSION['id'];
        $resultado = $daoSeguridad->readByUser($_SESSION['id']);
        if($resultado[0]['activacion_seguridad'] == 1) {
            $_SESSION['id_seguridad'] = $resultado[0]['id_seguridad'];
        } 
        // verificar si la direccion ip es existe y es la misma de la principal
        // y colocar en la variable de session el estado de la seguridad
>>>>>>> 70621f60203601d482c517938c701dae78f754fb

        header("Location: ../view/principal.php"); 
    }else{
        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}