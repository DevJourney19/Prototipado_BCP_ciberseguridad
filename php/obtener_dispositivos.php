<?php
header('Content-Type: application/json');
include_once '../config/Connection.php';
session_start();
$id_seguridad = $_SESSION['id_seguridad'];
if (!isset($_SESSION['id_seguridad'])) {
    echo json_encode(['error' => 'Sesión no iniciada']);
    exit;
}
$conectar = new Connection();
$conectar->conectar();

$response = [];

//Select para obtener los dispositivos que hayan accedido desde otro dispositivo 

$query = "SELECT id_dispositivo, tipo_dispositivo, direccion_ip, 
pais, ciudad, estado_dispositivo, fecha_registro FROM dispositivo WHERE id_seguridad='$id_seguridad'";

$resultado_total = $conectar->consultar($query);

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
//$conexion->desconectar();