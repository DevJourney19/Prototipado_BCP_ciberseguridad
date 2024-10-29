<?php

include 'util/connection.php';
conectar();

$id_dispositivo = $_POST['id_dispositivo'];
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'eliminar') {
        $sql = "delete from dispositivos where id_dispositivo = '$id_dispositivo'";
        ejecutar($sql);
    } else if ($accion === 'bloquear') {
        //realizar el bloqueo
        $sql = "delete from dispositivos where id_dispositivo = '$id_dispositivo'";
        ejecutar($sql);
    } else {
        echo "Acción no válida";
    }
    header('Location: ../view/consulta_dispositivos.php');


}