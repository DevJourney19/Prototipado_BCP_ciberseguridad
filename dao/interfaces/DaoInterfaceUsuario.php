<?php

interface DaoInterfaceUsuario
{
  public function read($id, $tipo);
  public function verificarLogin($tarjeta, $dni, $clave_internet);
  public function verificarLoginAdmi($email, $nombre, $contra);
  public function readUser($idUsuario);
}