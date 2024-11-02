<?php

header('Content-Type: application/json');
include '../dao/DaoSeguridad.php';
session_start();

// Verificar si los datos necesarios están presentes
try {

  $daoSeguridad = new DaoSeguridad();
  $id = $_SESSION['id_usuario'];

  // Ejecutar la consulta
  if ($daoSeguridad->verificarActivaciones($id)) {
    $response = ['status' => 'registrado'];
    $result = $daoSeguridad->readByUser($id);
    $_SESSION['id_seguridad'] = $result[0]['id_seguridad'];
    unset($result);
  } else {
    $response = ['status' => 'no registrado'];
  }

} catch (Exception $e) {
  echo "Error: " . $e;
  $response = [
    'status' => 'Datos incompletos',
    'message' => 'error'
  ];
}

// Enviar la respuesta en formato JSON
echo json_encode($response);
