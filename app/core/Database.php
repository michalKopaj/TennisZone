<?php
namespace App\Core;
class Database {
    private $host = 'localhost';
    private $dbname = 'tenniszone1';
    private $username = 'root';
    private $password = '';
    private \PDO $connection;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->connection = new \PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo "Chyba pripojenia: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
