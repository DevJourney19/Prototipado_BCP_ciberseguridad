<?php

include_once '../config/Connection.php';
include_once 'interfaces/DaoInterfaceUsuario.php';

class DaoUsuario implements DaoInterfaceUsuario
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function readUserWithSecurity($id, $entrada)
    {
        try {
            if ($entrada == 'seguridad') {
                $query = "SELECT * FROM usuario 
                      JOIN seguridad ON usuario.id_usuario = seguridad.id_usuario 
                      WHERE seguridad.id_seguridad = :id";
            } else {
                $query = "SELECT * FROM usuario WHERE id_usuario = :id";
            }
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

    public function readAllUsersWithSecurity()
    {
        try {

            $query = "SELECT * FROM usuario 
                      JOIN seguridad ON usuario.id_usuario = seguridad.id_usuario 
                      WHERE activacion_seguridad=1";

            $result = $this->db->consultar($query);
            if (is_array($result) && count($result) > 0) {
                return $result;
            } else {
                return [];
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function readUser($idUsuario)
    {
        try {
            $query = "SELECT * FROM usuario WHERE id_usuario = :idUsuario";
            $result = $this->db->consultar($query, ['idUsuario' => $idUsuario]);
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

    public function readUserWithSecurityByEmail($email)
    {
        try {
            $query = "SELECT * FROM usuario WHERE correo = :correo";
            $result = $this->db->consultar($query, ['correo' => $email]);
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


    public function verificarLogin($tarjeta, $dni, $clave_internet)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE numero_tarjeta = :tarjeta AND dni = :dni AND AES_DECRYPT(clave_internet, 'D9u#F5h8*Z3kB9!nL7^mQ4') = :clave_internet";
            $result = $this->db->consultar($sql, ['tarjeta' => $tarjeta, 'dni' => $dni, 'clave_internet' => $clave_internet]);
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function verificarLoginAdmi($email, $nombre, $contra)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE correo = :email AND nombre= :nombre AND AES_DECRYPT(password, 'D9u#F5h8*Z3kB9!nL7^mQ4') = :contra";
            $result = $this->db->consultar($sql, ['email' => $email, 'nombre' => $nombre, 'contra' => $contra]);
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function updateUser($usuario)
    {
        try {
            $sql = "UPDATE usuario SET telefono = :telefono, correo = :correo WHERE id_usuario = :id";
            $result = $this->db->ejecutar($sql, ['telefono' => $usuario->getTelefono(), 'correo' => $usuario->getCorreo(), 'id' => $usuario->getIdUsuario()]);
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
