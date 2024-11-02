<?php

require_once '../dao/DaoSeguridad.php';

class ControllerSeguridad
{
  private $daoSeguridad;

  public function __construct()
  {
    $this->daoSeguridad = new DaoSeguridad();
  }

  public function obtenerUsuario($id)
  {
    return $this->daoSeguridad->readByUser($id);
  }

  public function verificarSeguridad($id)
  {
    $datosActivacion = $this->daoSeguridad->readActiveSecurity($id);
    return $datosActivacion;
  }
}
