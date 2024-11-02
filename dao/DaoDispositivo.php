<?php
class DaoDispositivo implements DaoInterfaceDispositivo
{
    private $db;
    function create($object)
    {

    }
    function delete($id)
    {

    }
    function read($id)
    {

    }
    function readAll()
    {

    }
    function update($object)
    {

    }
    function readById($id)
    {
        try {
            $query = "SELECT * FROM dispositivo where id_dispositivo='$id'";
            return $this->db->consultar($query);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}