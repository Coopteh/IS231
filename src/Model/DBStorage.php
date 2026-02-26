<?php
namespace App\Models;

use PDO;

class DBStorage 
{
    const DNS = 'mysql:dbname=demo3;host=localhost';
    const USER = 'root';
    const PASSWORD = '';

    protected $connection;

    public function __construct(){
        // устанавливаем соединение
        $this->connection = new PDO(self::DNS, self::USER, self::PASSWORD);
        $this->connection->exec("set names utf8mb4");
    }
}
