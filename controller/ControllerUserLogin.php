<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';

//Evitar ataque SQL INJECTION
$tarjeta = filter_input(INPUT_POST, 'tarjeta', FILTER_SANITIZE_NUMBER_INT);
$dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_NUMBER_INT);
$clave_internet = filter_input(INPUT_POST, 'clave_internet', FILTER_SANITIZE_STRING);

// $tarjeta = $_POST['tarjeta'];
// $dni = $_POST['dni'];
// $clave_internet = $_POST['clave_internet']; 
$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();

try {
    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);

    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id_usuario'] = $registro[0]['id_usuario']; //Se establece el id del usuario

        $resultado = $daoSeguridad->readByUser($_SESSION['id_usuario']);
        $idSeguridad = $resultado[0]['id_seguridad'];
        if ($resultado[0]['activacion_seguridad'] == 1) {
            $_SESSION['id_seguridad'] = $idSeguridad;
        }

        header("Location: ../view/principal.php");

        //AQUI ->
    } else {

        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}