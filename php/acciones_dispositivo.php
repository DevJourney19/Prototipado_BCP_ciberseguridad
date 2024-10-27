<?php

include 'util/connection.php';
conectar();
$tarjeta = $_POST['eliminar_b'];
$dni = $_POST['eliminar_b'];


$validar_login = "SELECT * FROM usuario WHERE numero_tarjeta = '$tarjeta' AND dni = '$dni'" ; 


$id_dispositivo = $_POST['id_dispositivo'];

session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $accion = $_POST['accion'] ?? '';

    if($accion === 'eliminar'){
        $sql = "delete from dispositivos where id_dispositivo = '$id_dispositivo'";
        $ejecutar($sql);
    }else if($accion === 'bloquear'){
        //realizar el bloqueo
        $sql = "delete from dispositivos where id_dispositivo = '$id_dispositivo'";
        $ejecutar($sql);
    }else{
        echo "Acción no válida";
    }



}