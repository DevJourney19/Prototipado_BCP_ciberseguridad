<?php

include './util/connection.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$pin = $_POST['pin'];

$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni' AND AES_DECRYPT(pin, '$pin') = '$pin'";
$verificar_entradas = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' OR dni = '$dni'";

try {
    conectar();
    $registro = consultar($validar_login);
    $entrada_no_deseada = consultar($verificar_entradas);
    desconectar();
    
    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id'] = $registro[0]['id_usuario'];
        header("Location: ../principal.php");
    } else if(count($entrada_no_deseada) == 1) {
        session_start();
        
        $_SESSION['id_no_permitido'] = $registro[0]['id_usuario'];
        header("Location: ../index.php?error=true");
        header("Location: ../direccion_ip.php");
    }else{
        session_destroy();
        header("Location: ../index.php?error=true");
    }
    
} catch (Exception $exc) {
    die($exc->getMessage());
}