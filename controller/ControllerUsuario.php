<?php

require_once '/app/dao/DaoUsuario.php';
require_once '/app/model/Usuario.php';
class ControllerUsuario
{
    private $daoUsuario;

    public function __construct()
    {
        $this->daoUsuario = new DaoUsuario();
    }

    public function obtenerUsuario($id, $tipo)
    {
        $result = $this->daoUsuario->readUserWithSecurity($id, $tipo);
        $usuario = new Usuario();
        $usuario->setIdUsuario($result['id_usuario']);
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

    public function obtenerUsuarios()
    {
        $result = $this->daoUsuario->readAllUsersWithSecurity();
        $usuarios = [];

        if (!empty($result)) {
            foreach ($result as $row) {
                $usuario = new Usuario();
                $usuario->setIdUsuario($row['id_usuario']);
                $usuario->setNombre($row['nombre']);
                $usuario->setCorreo($row['correo']);
                $usuario->setTelefono($row['telefono']);
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }
}