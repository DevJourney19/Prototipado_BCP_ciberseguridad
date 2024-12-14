<?php
include '/app/dao/DaoUsuario.php';
include '/app/dao/DaoSeguridad.php';
//Evitar ataque SQL INJECTION
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$contra = filter_input(INPUT_POST, var_name: 'password', filter: FILTER_SANITIZE_STRING);

$daoUsuario = new DaoUsuario();
$daoSeguridad = new DaoSeguridad();
try {

    $registro1 = $daoUsuario->verificarLoginAdmi($email, $nombre, $contra);

    if (count($registro1) === 1) {
        session_start();
        //USUARIO
        $_SESSION['id_usuario'] = $registro1[0]['id_usuario'];
        echo $_SESSION['id_usuario'];

        $id_usuario = $_SESSION['id_usuario'];
        //SEGURIDAD
        $registro2 = $daoSeguridad->readByUser($id_usuario);
        $_SESSION['security'] = $registro2[0]['id_seguridad'];
        header(header: "Location: ../view/principal_admin.php");
    } else {
        session_start();
        session_destroy();
        header("Location: ../view/login_admin.php?error=true");
    }
} catch (Exception $e) {
    die($exc->getMessage());
}