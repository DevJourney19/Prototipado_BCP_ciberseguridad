<?php

include 'util/connection.php';
conectar();

session_start();
$response = ['status' => 'error', 'message' => '']; // Inicializa la respuesta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_dispositivo = $_POST['id_dispositivo'] ?? '';
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'eliminar') {
        $sql = "delete from dispositivo where id_dispositivo = '$id_dispositivo'";
        ejecutar($sql);
        $response['status'] = 'success';
        $response['message'] = 'Dispositivo eliminado con éxito.';
    } else if ($accion === 'bloquear') {
        $sql = "UPDATE dispositivo SET estado_dispositivo='bloqueado' where id_dispositivo ='$id_dispositivo'";
        ejecutar($sql);
        $response['status'] = 'success';
        $response['message'] = 'Dispositivo bloqueado con éxito.';
    } else if ($accion === 'permitir') {
        //Voy a traer el id de esa fila y procederé a cambiarle el estado
        $sql = "UPDATE dispositivo SET estado_dispositivo='seguro' where id_dispositivo ='$id_dispositivo'";
        ejecutar($sql);
        $response['status'] = 'success';
        $response['message'] = 'Dispositivo permitido con éxito.';
    }
    //header('Location: ../view/consulta_dispositivos.php'); //evitar cargar la pagina
    header('Content-Type: application/json');
    echo json_encode($response);
}