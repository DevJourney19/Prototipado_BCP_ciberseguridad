<?php

interface DaoInterfaceUsuario
{
  
  public function readUserWithSecurity($idUsuario, $tipo);
  public function readUser($idUsuario);
  public function verificarLogin($tarjeta, $dni, $clave_internet);
  public function verificarLoginAdmi($email, $nombre, $contra);
  
}