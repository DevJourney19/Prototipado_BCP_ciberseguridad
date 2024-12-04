<?php
include '../dao/DaoUsuario.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);



$daoUsuario = new DaoUsuario();

try {
    $registro = $daoUsuario->verificarLoginAdmi($email, $nombre, $password);
    echo $registro[0]['nombre'];
    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id_usuario'] = $registro[0]['id_usuario'];
        header("Location: ../view/principal_admin.php");
    } else {
        session_start();
        session_destroy();
        header("Location: ../view/login_admin.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}