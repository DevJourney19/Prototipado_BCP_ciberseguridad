<?php
include '../dao/DaoUsuario.php';

$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_NUMBER_INT);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_NUMBER_INT);
$nombre = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_STRING);


$daoUsuario = new DaoUsuario();

try {;
    $registro = $daoUsuario->verificarLoginAdmi($email, $nombre, $password);
    if (count($registro) == 1) {
        session_start();
        $_SESSION['security'] = '12345';
        $_SESSION['id'] = $registro[0]['id_usuario'];
        header("Location: ../view/dashboard.php");
    } else {
        session_start();
        session_destroy();
        header("Location: ../view/login_admin.php?error=true");
    }
} catch (Exception $exc) {
    die($exc->getMessage());
}