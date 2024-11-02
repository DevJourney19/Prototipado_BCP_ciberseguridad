<?php

header('Content-Type: application/json');
include 'util/connection.php';
include 'util/direccion_ip.php';
session_start();

$public_ip = getPublicIp();
$info = obtener_info_ip($public_ip);
$pais = $info['country'];
$ciudad = $info['city'];

$tipo = obtener_dispositivo();
// Verificar si los datos necesarios están presentes
try {
  // Conectar a la base de datos
  conectar();

  $id_usuario = $_SESSION['id_usuario'];

  // verificar si ya ha sido contratado el servicio
  $sql = "SELECT * FROM seguridad WHERE id_usuario = '$id_usuario'";
  $resultadoVerificacion = consultar($sql);
  if ($resultadoVerificacion) {
    $query = "UPDATE seguridad set activacion_seguridad  = '1' where id_usuario='$id_usuario'";
    //
    // Ejecutar la consulta
    if (ejecutar($query)) {
      $response = ['status' => 'registrado'];
      $query = "SELECT * FROM seguridad WHERE id_usuario = '$id_usuario'";
      $result = consultar($query);
      $_SESSION['id_seguridad'] = $result[0]['id_seguridad'];

      //Hacer un update en caso si quiere volver a activar
      $id_seguridad = $_SESSION['id_seguridad'];
      $query2 = "UPDATE dispositivo SET estado_dispositivo='activado')";
      ejecutar($query2);

      unset($result);
    } else {
      $response = ['status' => 'no registrado'];
    }
  } else {
    //Se obtiene la dirección pública que posteriormente se almacenará en la base de datos
    $public_ip = getPublicIp();

    $query = "INSERT INTO seguridad(id_usuario) VALUES('$id_usuario')";
    if (ejecutar($query)) {

      $query = "SELECT * FROM seguridad WHERE id_usuario = '$id_usuario'";
      $result = consultar($query);
      $_SESSION['id_seguridad'] = $result[0]['id_seguridad'];
      $id_seguridad = $_SESSION['id_seguridad'];
      $query2 = "INSERT INTO dispositivo(id_seguridad, estado_dispositivo, tipo_dispositivo, direccion_ip,
      pais, ciudad, fecha_registro, ultima_conexion ) 
      VALUES('$id_seguridad', 'activado', '$tipo','$public_ip', '$pais','$ciudad',
      NOW(), NOW())";
      //No lo lee 
      
      ejecutar($query2);
      unset($result);
    } else {
      $response = ['status' => 'registrado'];
    }
  }

  // Desconectar de la base de datos
  desconectar();
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'error'
  ];
}
//header('Location: ../view/dispositivos.php');
//echo "<script>window.location.href: '';</script>";

// Enviar la respuesta en formato JSON
echo json_encode($response);