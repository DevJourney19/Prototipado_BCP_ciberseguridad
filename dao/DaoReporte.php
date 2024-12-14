<?php

include_once '/app/config/Connection.php';
include_once '/app/dao/interfaces/DaoInterfaceReportes.php';

class DaoReporte implements DaoInterfaceReportes
{
  private $db;

  public function __construct()
  {
    $this->db = new Connection();

  }

  public function insertarReporte($reporte)
  {
    $response = false;
    try {
      $id_seguridad = $reporte->getIdSeguridad();
      $titulo = $reporte->getTitulo();
      $tipo = $reporte->getTipo();
      $descripcion = $reporte->getDescripcion();
      $query = "INSERT INTO reporte(id_seguridad, titulo, descripcion, tipo) VALUES(:id_seguridad, :titulo, :descripcion, :tipo)";
      $response = $this->db->ejecutar($query, ['id_seguridad' => $id_seguridad, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tipo' => $tipo]);
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
    return $response;
  }


}
