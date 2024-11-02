<?php

require_once '../dao/DaoUsuario.php';
require_once '../model/Usuario.php';
class ControllerUsuario
{
    private $daoUsuario;

    public function __construct()
    {
        $this->daoUsuario = new DaoUsuario();
    }

    public function obtenerUsuario($id)
    {
        $result = $this->daoUsuario->read($id);
        $usuario = new Usuario();
        //$usuario->setIdUsuario($result['id']);
        $usuario->setNombre($result['nombre']);
        $usuario->setTelefono($result['telefono']);
        return $usuario;
    }
    public function obtener_info_usuario($id)
    {
        $result = $this->daoUsuario->readUser($id);
        $usuario = new Usuario();
        //$usuario->setIdUsuario($result['id']);
        $usuario->setNombre($result['nombre']);
        $usuario->setTelefono($result['telefono']);
        return $usuario;
    }
    public function usuario_activado($id)
    {
        $result = $this->daoUsuario->readUser($id);
        $usuario = new Usuario();
        //$usuario->setIdUsuario($result['id']);
        $usuario->setNombre($result['nombre']);
        $usuario->setTelefono($result['telefono']);
        return $usuario;
    }
    public function estado_activado($id)
    {
        $result = $this->daoUsuario->readDispo($id);
        $usuario = new Usuario();
        //$usuario->setIdUsuario($result['id']);
        $usuario->setNombre($result['nombre']);
        $usuario->setTelefono($result['telefono']);
        return $usuario;
        
    }
}