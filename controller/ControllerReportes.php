<?php

include_once '../dao/DaoReporte.php';
include_once '../model/Reporte.php';
header('Content-Type: application/json');
session_start();

class ControllerReportes
{
  private $daoReportes;
  private $reporte;

  public function __construct()
  {
    $this->daoReportes = new DaoReporte();
    $this->reporte = new Reporte();
  }

  public function registrar($data)
  {
    $id_seguridad = $_SESSION['id_seguridad'];
    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $tipo = $data['tipo'];
    $this->reporte->setIdSeguridad($id_seguridad);
    $this->reporte->setTitulo($titulo);
    $this->reporte->setDescripcion($descripcion);
    $this->reporte->setTipo($tipo);
    $result = $this->daoReportes->insertarReporte($this->reporte);
    if ($result) {
      $response = ['status' => 'registrado'];
  } else {
      $response = ['status' => 'no registrado'];
  }
    return $response;
  }
}

$controller = new ControllerReportes();
$action = $_GET['action'] ?? null;

$data = json_decode(file_get_contents('php://input'), true);
if ($action && method_exists($controller, $action)) {
  $resultado = $controller->$action($data);
}


echo json_encode($resultado);