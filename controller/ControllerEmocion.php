<?php

include_once '/app/dao/DaoEmocion.php';
include_once '/app/model/Emocion.php';
header('Content-Type: application/json');
session_start();

$daoEmocion = new DaoEmocion();
$id_seguridad = $_SESSION['id_seguridad'];
try {
  $response = [];
  $data = json_decode(file_get_contents('php://input'), true);
  $estado = $data['estado'];
  $emocion = new Emocion();
  $emocion->setIdSeguridad($id_seguridad);
  $emocion->setTipoEmocion($estado);
  $result = $daoEmocion->guardarResultado($emocion);
  if ($result) {
    $response = ['status' => 'registrado'];
  } else {
    $response = ['status' => 'no registrado'];
  }
} catch (Exception $e) {
  $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);