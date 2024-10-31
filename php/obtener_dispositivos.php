<?php
header('Content-Type: application/json');
include_once 'util/connection.php';
session_start();
$id_seguridad = $_SESSION['id_seguridad'];
conectar();

$response = [];

$query = "SELECT id_dispositivo, tipo_dispositivo, direccion_ip, 
pais, ciudad, estado_dispositivo, fecha_registro FROM dispositivo WHERE id_seguridad='$id_seguridad'
AND (estado_dispositivo='en_proceso_si' || estado_dispositivo='en_proceso_no')";
$resultado_total = consultar($query);

if ($resultado_total) {
    foreach ($resultado_total as $row) {
        //Agregar dispositivos al array de respuesta
        $response[] = [
            'id' => $row['id_dispositivo'],
            'tipo' => $row['tipo_dispositivo'],
            'dip' => $row['direccion_ip'],
            'pais' => $row['pais'],
            'ciudad' => $row['ciudad'],
            'estado' => $row['estado_dispositivo'],
            'fecha' => $row['fecha_registro']
        ];
    }
}
echo json_encode($response);
desconectar();