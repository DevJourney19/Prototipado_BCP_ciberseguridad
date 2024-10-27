<?php

include_once '../model/Emocion.php';
include_once '../php/util/connection.php';

class DaoEmocion
{
  public function guardarResultado($id_seguridad, $estado)
  {
    try {
      conectar();
      $emocion = new Emocion();
      $emocion->setIdSeguridad($id_seguridad);
      $emocion->setTipoEmocion($estado);
      $id_seguridad = $emocion->getIdSeguridad();
      $estado = $emocion->getTipoEmocion();
      $query = "INSERT INTO encuestas(id_seguridad, estado) VALUES('$id_seguridad', '$estado')";
      $response = ejecutar($query);
      desconectar();
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
    return $response;
  }
}
