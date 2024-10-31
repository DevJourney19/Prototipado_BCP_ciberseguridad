<?php

include_once '../model/Usuario.php';
include_once '../config/Connection.php';
include_once 'DaoInterface.php';

class DaoUsuario implements DaoInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function create($emocion)
    {
        return false;
    }

    public function read($id_seguridad)
    {
        try {
            $query = "SELECT * FROM usuario 
                      JOIN seguridad ON usuario.id_usuario = seguridad.id_usuario 
                      WHERE seguridad.id_seguridad = :id_seguridad";
            $result = $this->db->consultar($query, ['id_seguridad' => $id_seguridad]);
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

    public function update($emocion)
    {
        return false;
    }

    public function delete($id)
    {
        return false;
    }

    public function readAll()
    {
        return null;
    }

    public function readUser($id)
    {
        try {
            $query = "SELECT * FROM usuario WHERE id_usuario = :id";
            $result = $this->db->consultar($query, ['id' => $id]);
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

    public function verificarLogin($tarjeta, $dni, $clave_internet){
        try {
            $sql = "SELECT * FROM usuario WHERE numero_tarjeta = :tarjeta AND dni = :dni AND AES_DECRYPT(clave_internet, 'D9u#F5h8*Z3kB9!nL7^mQ4') = :clave_internet";
            $result = $this->db->consultar($sql, ['tarjeta' => $tarjeta, 'dni' => $dni, 'clave_internet' => $clave_internet]);
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function verificarLoginAdmi($email, $nombre, $contra){
        try{
            $sql = "SELECT * FROM usuario WHERE correo = :email AND nombre= :nombre AND AES_DECRYPT(password, 'D9u#F5h8*Z3kB9!nL7^mQ4') = :contra";
            $result = $this->db->consultar($sql, ['email' => $email, 'nombre'=> $nombre,'contra' => $contra]);
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
