<?php

include_once '../model/Emocion.php';
include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceEmocion.php';

class DaoEmocion implements DaoInterfaceEmocion
{
  private $db;

  public function __construct() {
      $this->db = new Connection();
  }

  public function guardarResultado($emocion)
  {
    $response = false;
    try {
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
