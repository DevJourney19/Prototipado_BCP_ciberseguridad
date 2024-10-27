<?php

class Usuario {
    private $id_usuario;
    private $nombre;
    private $telefono;
    private $correo;
    private $clave;
    private $dni;
    private $tarjeta;

    public function __construct($id_usuario = null, $nombre = null, $telefono = null, $correo = null, $clave = null, $dni = null, $tarjeta = null) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->dni = $dni;
        $this->tarjeta = $tarjeta;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function getTarjeta() {
        return $this->tarjeta;
    }

    public function setTarjeta($tarjeta) {
        $this->tarjeta = $tarjeta;
    }
    
}

?>