<?php

class Emocion {
    private $id_seguridad;
    private $tipo_emocion;

    // Constructor
    public function __construct($id_seguridad = null, $tipo_emocion = null) {
        $this->id_seguridad = $id_seguridad;
        $this->tipo_emocion = $tipo_emocion;
    }

    public function getIdSeguridad() {
        return $this->id_seguridad;
    }

    public function getTipoEmocion() {
        return $this->tipo_emocion;
    }

    public function setIdSeguridad($id_seguridad) {
        $this->id_seguridad = $id_seguridad;
    }

    public function setTipoEmocion($tipo_emocion) {
        $this->tipo_emocion = $tipo_emocion;
    }
}

?>