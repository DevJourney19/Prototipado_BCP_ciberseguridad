<?php

function validar_entrada($location) {
    session_start();
    if (!isset($_SESSION['id'])) {
        exit("<script>alert('Inicie Sesion para poder continuar');
            window.location.href = '$location';</script>");
    }
}

function validar_servicio($location) {
    $sql = "SELECT * FROM seguridad WHERE id_usuario = " . $_SESSION['id'];
    try {
        conectar();
        $resultado = consultar($sql);
        $datos = $resultado;

        desconectar();
    } catch (Exception $exc) {
        die($exc->getMessage());
    }

    if (count($datos) == 0) {
        exit("<script>alert('No ha contratado el servicio de Yape Seguro');
            window.location.href = '$location';</script>");
    }
}