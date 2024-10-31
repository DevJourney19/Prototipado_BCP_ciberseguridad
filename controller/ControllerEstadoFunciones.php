<?php

header('Content-Type: application/json');
include '../dao/DaoSeguridad.php';
session_start();

try {
  $data = json_decode(file_get_contents('php://input'), true);

  // Verifica si las claves existen antes de acceder a ellas
  if (isset($data['estado'])) {
    $estado = $data['estado'];
  } else {
    throw new Exception('Estado no proporcionado');
  }

  if (isset($data['funcion'])) {
    $funcion = $data['funcion'];
  } else {
    throw new Exception('Función no proporcionada');
  }

  if (!isset($_SESSION['id_seguridad'])) {
    throw new Exception('ID de seguridad no encontrado en la sesión');
  }

  $seguridad = $_SESSION['id_seguridad'];

  $daoSeguridad = new DaoSeguridad();

  if ($daoSeguridad->editarEstadoFuncionalidad($funcion, $estado, $seguridad)) {
    $response = ['status' => $estado ? 'activado' : 'desactivado'];
  } else {
    $response = ['status' => 'no activado'];
  }
} catch (Exception $e) {
  $response = [
    'status' => 'error',
    'message' => $e->getMessage()
  ];
}

header('Content-Type: application/json');

echo json_encode($response);
