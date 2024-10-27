<?php

include_once '../model/Usuario.php';
include_once '../php/util/connection.php';
include_once 'DaoInterface.php';

class DaoUsuario implements DaoInterface {
    public function create($emocion) {
        return false;
    }

    public function read($id_seguridad) {
        try {
            conectar();
            $query = "SELECT * FROM usuario JOIN seguridad ON usuario.id_usuario = seguridad.id_usuario WHERE seguridad.id_seguridad = '$id_seguridad'";
            $result = consultar($query);
            desconectar();
            if (count($result) > 0) {
                return $result[0];
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function update($emocion) {
       return false;
    }

    public function delete($id) {
        return false;
    }

    public function readAll() {
        return null;
    }
}

?>