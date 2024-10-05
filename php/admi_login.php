<?php

include './util/connection.php';

$email = $_POST['email'];
$password = $_POST['password'];
$nombre = $_POST['nombre'];


$validar_login = "SELECT * FROM usuario WHERE correo = '$email' AND nombre='$nombre' AND AES_DECRYPT(password, '$password') = '$password'";
try {
    conectar();
    $registro = consultar($validar_login);
    desconectar();
    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id'] = $registro[0]['id_usuario'];
        header("Location: ../dashboard.php");
    } else {
        session_start();
        session_destroy();
        header("Location: ../login_admi.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}