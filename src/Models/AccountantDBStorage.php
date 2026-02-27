<?php
namespace src\Models;

class AccountantDBStorage extends DBStorage
{
    protected $table = 'Accountants';

    public function findByEmail($email, $password)
    {
        $sql = "SELECT AccountantID, FullName, Position, Email 
                FROM Accountants 
                WHERE Email = :email AND Password = :password AND IsDeleted = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $password]);
        return $stmt->fetch();
    }

    public function getIdColumn()
    {
        return 'AccountantID';
    }
}
