<?php

include_once 'db_config.php';

class Connection
{
    private $pdo;

    public function __construct()
    {
        $this->conectar();
    }

    public function __destruct()
    {
        $this->desconectar();
    }

    public function conectar()
    {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, USER, PASS, $options);
        } catch (PDOException $e) {
            return ['error' => "Error en la consulta: " . $e->getMessage()];
        }
    }

    public function desconectar()
    {
        $this->pdo = null;
    }

    public function consultar($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: [];
        } catch (PDOException $e) {

            error_log("Error en la consulta: " . $e->getMessage());
            return [];
        }
    }

    public function ejecutar($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return ['error' => "Error en la consulta: " . $e->getMessage()];
        }
    }

}
