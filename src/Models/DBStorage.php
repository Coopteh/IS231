<?php
namespace src\Models;

use PDO;
use PDOException;

class DBStorage
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->connect();
    }

    protected function connect()
    {
        try {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'AccountingSystem';
            $user = $_ENV['DB_USER'] ?? 'root';
            $pass = $_ENV['DB_PASSWORD'] ?? '';
            
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Ошибка подключения к БД: " . $e->getMessage());
        }
    }

    public function getAll($orderBy = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE IsDeleted = FALSE";
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $orderBy;
        }
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $idColumn = $this->getIdColumn();
        $sql = "SELECT * FROM {$this->table} WHERE $idColumn = :id AND IsDeleted = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    protected function getIdColumn()
    {
        return str_replace('DBStorage', 'ID', (new \ReflectionClass($this))->getShortName());
    }
}