<?php

require_once '../dao/DaoEntrada.php';

class ControllerEntradas
{
    private $daoEntrada;

    public function __construct()
    {
        $this->daoEntrada = new DaoEntrada();
    }

    public function validarEntrada($location)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_usuario'])) {
            echo "<script>alert('Inicie Sesion para poder continuar');
                window.location.href = '$location';</script>";
            exit();
        }
    }

    public function validarServicio($location, $id)
    {
        $datos = $this->daoEntrada->verificarServicio($id);
        if (!$datos) {
            echo "<script>alert('No ha contratado el servicio de seguridad');
                window.location.href = '$location';</script>";
            exit();
        }
    }

    
    public function validarYape($location, $id) {
        $datos = $this->daoEntrada->verificarYape($id);
        if (!$datos) {
            echo "<script>alert('No ha activado la funcion de Yape');
                window.location.href = '$location';</script>";
            exit();
        }
    }
}