<?php

include 'util/connection.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$pin = $_POST['pin'];

$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni' AND AES_DECRYPT(password, '$pin') = '$pin'";
//Haciendo pruebas en todo caso antes de implementar la verificación (confirmación) por correo
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
        
        //AQUI ->
    } else if(count($entrada_no_deseada) == 1) {
        session_start();
        $_SESSION['id_no_permitido'] = $entrada_no_deseada[0]['id_usuario'];
        
        
        //Como puedo hacer para que no me lleve a esa direccion solo que ejecute codigo?
        echo "<script>window.location.href = 'direccion_ip.php';</script>";
        //header("Location: ../index.php?error=true");
    }else{
        session_destroy();
        header("Location: ../index.php?error=true");
    }
    
} catch (Exception $exc) {
    die($exc->getMessage());
}