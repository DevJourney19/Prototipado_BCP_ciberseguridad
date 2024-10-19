<?php

header('Content-Type: application/json');
include 'util/connection.php';
session_start();

try {
  conectar();
  $data = json_decode(file_get_contents('php://input'), true);
  // Verifica si las claves existen antes de acceder a ellas
  if (isset($data['estado'])) {
    $estado = $data['estado'];
  } else {
    $estado = null; // o manejar el error
  }
  if (isset($data['funcion'])) {
    $funcion = $data['funcion'];
  } else {
    $funcion = null; // o manejar el error
  }
  $seguridad = $_SESSION['id_seguridad'];
  // Construir la consulta
  $query = "UPDATE seguridad set $funcion  = '$estado' where id_seguridad='$seguridad'";

  // Ejecutar la consulta
  if (ejecutar($query)) {
    $response = ['status' => $estado ? 'activado' : 'desactivado'];
  } else {
    $response = ['status' => 'no activado'];
  }

  // Desconectar de la base de datos
  desconectar();
} catch (Exception $e) {
  echo "Error: " . $e;
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'Error'
  ];
}

// Enviar la respuesta en formato JSON
echo json_encode($response);
