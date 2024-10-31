<?php

include_once 'db_config.php';

class Connection {
    private $pdo;

    public function __construct() {
        $this->conectar();
    }

    public function __destruct() {
        $this->desconectar();
    }

    private function conectar() {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, USER, PASS, $options);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    private function desconectar() {
        $this->pdo = null;
    }

    public function consultar($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    public function ejecutar($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            die("Error en la ejecución: " . $e->getMessage());
        }
    }
}