<?php
interface daoInterfaceDispositivo
{
    public function create($object);
    public function read($id);
    public function update($object);
    public function delete($id);
    public function readById($id);
    public function searchById();
}
;
