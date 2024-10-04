<?php

header('Content-Type: application/json');
include 'util/connection.php';
session_start();

// Verificar si los datos necesarios están presentes
try {
  // Conectar a la base de datos
  conectar();

  $id = $_SESSION['id'];
  // Construir la consulta
  $query = "INSERT INTO seguridad(id_usuario) VALUES('$id')";

  // Ejecutar la consulta
  if (ejecutar($query)) {
    $response = ['status' => 'registrado'];
  } else {
    $response = ['status' => 'no registrado'];
  }

  // Desconectar de la base de datos
  desconectar();
} catch (Exception $e) {
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'error'
  ];
}

// Enviar la respuesta en formato JSON
echo json_encode($response);
