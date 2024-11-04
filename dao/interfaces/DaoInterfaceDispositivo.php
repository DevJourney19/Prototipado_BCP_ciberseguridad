<?php
interface daoInterfaceDispositivo
{
    public function createDevice($object);
    public function updateDeviceStatus($accion, $id_dispositivo);
    public function delete($id);
    public function readById($id);
    public function readDispoByUserSecurity($id_seguridad);
    public function enterAccess($id_seguridad, $dir_ip);
}
;
