<?php

interface DaoInterfaceSeguridad
{
  public function read($idSeguridad);
  public function editarEstadoFuncionalidad($funcion, $estado, $seguridad);
  public function readByUser($idUsuario);
  public function readActiveSecurity($idUsuario);
  public function verificarActivaciones($idUsuario);
  public function mostrarDispositivos();
}
 