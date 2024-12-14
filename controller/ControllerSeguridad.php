<?php

require_once '/app/dao/DaoSeguridad.php';

class ControllerSeguridad
{
  private $daoSeguridad;

  public function __construct()
  {
    $this->daoSeguridad = new DaoSeguridad();
  }

  public function obtenerSeguridadUsuario($id_usuario)
  {
    //Importante para hacer la conexion con dispositivos
    return $this->daoSeguridad->readByUser($id_usuario);
  }

  public function verificarSeguridad($id)
  {
    $datosActivacion = $this->daoSeguridad->readActiveSecurity($id);
    return $datosActivacion;
  }
}
