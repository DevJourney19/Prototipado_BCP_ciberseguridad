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

  public function activarSeguridad($id)
  {
    $seguridad = $this->daoSeguridad->readByUser($id);
    if ($seguridad) {
      $seguridad->setActivacionSeguridad(1);
      return $this->daoSeguridad->update($seguridad);
    } else {
      $seguridad = new Seguridad();
      $seguridad->setIdUsuario($id);
      $seguridad->setActivacionSeguridad(1);
      $seguridad->setEstadoYape(0);
      return $this->daoSeguridad->create($seguridad);
    }
  }

  public function verificarSeguridad($id)
  {
    $datosActivacion = $this->daoSeguridad->readActiveSecurity($id);
    return $datosActivacion;
  }
}
