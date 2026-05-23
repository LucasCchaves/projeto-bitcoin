<?php

class Database {
    private $host = 'localhost';
    private $port = '3306';
    private $db   = 'db_bitcoin';
    private $user = 'root';
    private $pass = '';
    private $pdo  = null;

    private static $instancia = null; // guarda a única instância

    private function __construct() {} // ninguém faz new Database() de fora

    public static function getInstance() {
        if (self::$instancia === null) {
            self::$instancia = new self(); // cria uma vez só
        }
        return self::$instancia; // sempre retorna a mesma
    }

    public function connect() {
        if (!$this->pdo) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db}";
                $this->pdo = new PDO($dsn, $this->user, $this->pass);
            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}