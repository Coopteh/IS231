<?php
namespace App\Models;

use PDO;

class UserDBStorage extends DBStorage
{
    public function getUser($email, $password) {
        $sql = "SELECT * FROM users WHERE email='".$email."' and password='".$password."'";
        $result = $this->connection->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
//var_dump($sql);
//exit();
        return $row;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function addUser($row) {
        $sql = "INSERT INTO `users`(`email`, `password`, `role`) 
        VALUES ('".$row['email']."','".$row['password']."','".$row['role']."')";
        $result = $this->connection->query($sql);
        return $result;
    }
}
