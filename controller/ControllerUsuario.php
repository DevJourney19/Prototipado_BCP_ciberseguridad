<?php

require_once '../dao/DaoUsuario.php';

class ControllerUsuario {
    private $daoUsuario;

    public function __construct() {
        $this->daoUsuario = new DaoUsuario();
    }

    public function obtenerUsuario($id) {
        return $this->daoUsuario->readUser($id);
    }
}