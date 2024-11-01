<?php

interface DaoInterfaceDireccion {
    public function registrarDireccion($id_seguridad, $direccion_exacta, $rango_gps, $fecha_configuracion, $hora_configuracion);
    public function obtenerTodasDirecciones();
    public function modificarDireccion($id, $direccion_exacta, $rango_gps);
    public function eliminarDireccion($id);
}
?>