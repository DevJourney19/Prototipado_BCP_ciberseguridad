<?php

interface DaoInterfaceUsuario
{
  public function read($id_seguridad);
  public function verificarLogin($tarjeta, $dni, $clave_internet);
  public function verificarLoginAdmi($email, $nombre, $contra);
  public function readUser($idUsuario);
}