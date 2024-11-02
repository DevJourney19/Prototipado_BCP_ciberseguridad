<?php
require_once '../dao/DaoDispositivo.php';
require_once '../dao/DaoUsuario.php';

class ControllerDispositivo
{
    private $daoUsuario;
    private $daoDispositivo;
    public function __construct()
    {
        $this->daoUsuario = new DaoUsuario();
        $this->daoDispositivo = new DaoDispositivo();
    }
    public function readById($id)
    {
        return $this->daoDispositivo->readById($id);
    }
}

