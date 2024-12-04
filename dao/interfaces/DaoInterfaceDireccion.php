<?php

interface DaoInterfaceDireccion {
    public function registrarDireccion($id_seguridad, $direccion_exacta, $longitud, $latitud, $rango_gps, $fecha_configuracion, $hora_configuracion);
    public function obtenerTodasDirecciones($id);
    public function modificarDireccion($id, $direccion_exacta, $longitud, $latitud, $rango_gps);
    public function eliminarDireccion($id);
}
