<?php

require_once '../dao/DaoUsuario.php';
require_once '../model/Usuario.php';
class ControllerUsuario {
    private $daoUsuario;

    public function __construct() {
        $this->daoUsuario = new DaoUsuario();
    }

    public function obtenerUsuario($id, $tipo) {
        $result = $this->daoUsuario->read($id, $tipo);
        $usuario = new Usuario();
        $usuario->setIdUsuario($result['id_usuario']);
        $usuario->setNombre($result['nombre']);
        $usuario->setTelefono($result['telefono']);
        return $usuario;
    }
}