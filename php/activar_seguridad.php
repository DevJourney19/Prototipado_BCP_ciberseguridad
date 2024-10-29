<?php

header('Content-Type: application/json');
include 'util/connection.php';
session_start();

// Verificar si los datos necesarios están presentes
try {
  // Conectar a la base de datos
  conectar();

  $id = $_SESSION['id'];

  // verificar si ya ha sido contratado el servicio
  $sql = "SELECT * FROM seguridad WHERE id_usuario = '$id'";
  $resultadoVerificacion = consultar($sql);
  if ($resultadoVerificacion) {
    $query = "UPDATE seguridad set activacion_seguridad  = '1' where id_usuario='$id'";
  } else {
    //Se obtiene la dirección pública que posteriormente se almacenará en la base de datos
    $public_ip = getPublicIp();
    $query = "INSERT INTO seguridad(id_usuario, ip_activacion) VALUES('$id', '$public_ip')";
  }
 
  // Ejecutar la consulta
  if (ejecutar($query)) {
    $response = ['status' => 'registrado'];
    $query = "SELECT * FROM seguridad WHERE id_usuario = '$id'";
    $result = consultar($query);
    $_SESSION['id_seguridad'] = $result[0]['id_seguridad'];
    unset($result);
  } else {
    $response = ['status' => 'no registrado'];
  }

  // Desconectar de la base de datos
  desconectar();
} catch (Exception $e) {
  echo "Error: " . $e;
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'error'
  ];
}
function getPublicIp()
{
  //Hacer una solicitud a ipify.org para obtener la IP pública
  $ip = file_get_contents('https://api.ipify.org');
  return $ip;
}
// Enviar la respuesta en formato JSON
echo json_encode($response);
