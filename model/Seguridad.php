<?php

class Seguridad {
    private $id_usuario;
    private $activacion_seguridad;
    private $estado_horas_direcciones;
    private $estado_yape;

    // Constructor
    public function __construct($id_usuario = null, $activacion_seguridad = null, $estado_horas_direcciones = null, $estado_yape = null) {
        $this->id_usuario = $id_usuario;
        $this->activacion_seguridad = $activacion_seguridad;
        $this->estado_horas_direcciones = $estado_horas_direcciones;
        $this->estado_yape = $estado_yape;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getActivacionSeguridad() {
        return $this->activacion_seguridad;
    }

    public function getEstadoHorasDirecciones() {
        return $this->estado_horas_direcciones;
    }

    public function getEstadoYape() {
        return $this->estado_yape;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setActivacionSeguridad($activacion_seguridad) {
        $this->activacion_seguridad = $activacion_seguridad;
    }

    public function setEstadoHorasDirecciones($estado_horas_direcciones) {
        $this->estado_horas_direcciones = $estado_horas_direcciones;
    }

    public function setEstadoYape($estado_yape) {
        $this->estado_yape = $estado_yape;
    }

  
}

?>