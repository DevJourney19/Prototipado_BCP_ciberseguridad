<?php

include './util/connection.php';

$tarjeta = $_POST['tarjeta'];
$dni = $_POST['dni'];
$pin = $_POST['pin'];

$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni' AND AES_DECRYPT(pin, '$pin') = '$pin'";
try {
    conectar();
    $registro = consultar($validar_login);
    desconectar();
    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id'] = $registro[0]['id_usuario'];
        header("Location: ../principal.php");
    } else {
        session_start();
        session_destroy();
        header("Location: ../index.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}