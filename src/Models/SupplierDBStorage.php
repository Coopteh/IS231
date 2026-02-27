<?php
namespace src\Models;

class SupplierDBStorage extends DBStorage
{
    protected $table = 'Suppliers';

    public function findByUsername($username, $password)
    {
        $sql = "SELECT s.SupplierID, s.SupplierName, s.ContactPerson, s.Email
                FROM SupplierUsers su
                JOIN Suppliers s ON su.SupplierID = s.SupplierID
                WHERE su.Username = :username AND su.Password = :password AND s.IsDeleted = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        return $stmt->fetch();
    }

    public function getIdColumn()
    {
        return 'SupplierID';
    }
}