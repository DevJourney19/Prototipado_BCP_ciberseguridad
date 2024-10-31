<?php

include 'util/connection.php';
conectar();

$id_dispositivo = $_POST['id_dispositivo'];
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'eliminar') {
        $sql = "delete from dispositivo where id_dispositivo = '$id_dispositivo'";
        ejecutar($sql);
    } else if ($accion === 'bloquear') {
        //realizar el bloqueo
        //$sql = "delete from dispositivo where id_dispositivo = '$id_dispositivo'";
        //ejecutar($sql);
    } else if ($accion === 'permitir') {
        //Voy a traer el id de esa fila y procederé a cambiarle el estado
        $sql = "UPDATE dispositivo SET estado_dispositivo='seguro' where id_dispositivo ='$id_dispositivo'";
        ejecutar($sql);
    }
    header('Location: ../view/consulta_dispositivos.php');


}