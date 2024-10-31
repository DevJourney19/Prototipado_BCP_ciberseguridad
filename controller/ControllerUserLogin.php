<?php
include '../dao/DaoUsuario.php';
include '../dao/DaoSeguridad.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$clave_internet = $_POST['clave_internet']; 
$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();

try {
    $registro = $daoUsuario->verificarLogin($tarjeta, $dni, $clave_internet);

    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id'] = $registro[0]['id_usuario'];

        $resultado = $daoSeguridad->readByUser($_SESSION['id']);
        $idSeguridad = $resultado[0]['id_seguridad'];
        if($resultado[0]['activacion_seguridad'] == 1) {
            $_SESSION['id_seguridad'] = $idSeguridad;
        } 

        header("Location: ../view/principal.php");
        
        //AQUI ->
    } 
    // else if(count($entrada_no_deseada) == 1) {
    //     session_start();
    //     $_SESSION['id_no_permitido'] = $entrada_no_deseada[0]['id_usuario'];
        
        
    //     //Como puedo hacer para que no me lleve a esa direccion solo que ejecute codigo?
    //     echo "<script>window.location.href = 'direccion_ip.php';</script>";
    //     //header("Location: ../index.php?error=true");
    // }
    else{

        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}