<?php

namespace App\Models;

use PDO;

class DBStorage
{
    public const DNS = 'mysql:dbname=demo3;host=localhost';
    public const USER = 'root';
    public const PASSWORD = '';

    protected $connection;

    public function __construct()
    {
        // устанавливаем соединение
        $this->connection = new PDO(self::DNS, self::USER, self::PASSWORD);
        $this->connection->exec("set names utf8mb4");
    }
}
