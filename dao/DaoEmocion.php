<?php

include_once '../model/Emocion.php';
include_once '../config/Connection.php';

class DaoEmocion
{
  private $db;

  public function __construct() {
      $this->db = new Connection();
  }

  public function guardarResultado($id_seguridad, $estado)
  {
    $response = false;
    try {
      $emocion = new Emocion();
      $emocion->setIdSeguridad($id_seguridad);
      $emocion->setTipoEmocion($estado);
      $id_seguridad = $emocion->getIdSeguridad();
      $estado = $emocion->getTipoEmocion();
      $query = "INSERT INTO encuestas(id_seguridad, estado) VALUES(:id_seguridad, :estado)";
      $response = $this->db->ejecutar($query, ['id_seguridad'=>$id_seguridad, 'estado' => $estado]);
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
    return $response;
  }
}
