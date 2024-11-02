<?php
include '../dao/DaoUsuario.php';

$email = $_POST['email'];
$password = $_POST['password'];
$nombre = $_POST['nombre'];

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