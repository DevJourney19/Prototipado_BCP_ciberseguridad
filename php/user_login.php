<?php
include '../php/util/connection.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$clave_internet = $_POST['clave_internet']; // Cambié de $pin a $clave_internet

// Corregir la consulta para desencriptar el pin almacenado y compararlo con el ingresado
$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni' AND AES_DECRYPT(clave_internet, 'D9u#F5h8*Z3kB9!nL7^mQ4') = '$clave_internet'";
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
        $sqlSeguridad = "SELECT * FROM seguridad WHERE id_usuario = " . $_SESSION['id'];
        conectar();
        $resultado = consultar($sqlSeguridad);
        desconectar();
        $idSeguridad = $resultado[0]['id_seguridad'];
        if($resultado[0]['activacion_seguridad'] == 1) {
            $_SESSION['id_seguridad'] = $idSeguridad;
        } 
        header("Location: ../view/principal.php");
    // } else if(count($entrada_no_deseada) == 1) {
    //     session_start();
    //     $_SESSION['id_no_permitido'] = $entrada_no_deseada[0]['id_usuario'];
    //     header("Location: ../index.php?error=true");
    } else {
        session_destroy();
        header("Location: ../view/index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}