<?php
namespace App\Models;

use PDO;

class BillDBStorage extends DBStorage
{

    // получаем все записи для таблицы журнала
public function getAllBills(): mixed {
    global $user_id, $user_role;

    if ($user_role == 'Бухгалтер') {
        $sql = "SELECT 
                    m.id_bill, m.id_user, m.date_bill, m.price, 
                    users.fio, groups.name AS group_name, m.status
                FROM bills AS m
                JOIN users ON m.id_user = users.id_user
                JOIN groups ON users.id_group = groups.id_group
                WHERE m.deleted = 0
                ORDER BY m.id_bill DESC";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    } else {
        $sql = "SELECT 
                    m.id_bill, m.id_user, m.date_bill, m.price, 
                    users.fio, groups.name AS group_name, m.status
                FROM bills AS m
                JOIN users ON m.id_user = users.id_user
                JOIN groups ON users.id_group = groups.id_group
                WHERE m.id_user = ".$user_id." AND m.deleted = 0
                ORDER BY m.id_bill DESC";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }
}
    public function addBill($row) {
    global $user_id;
        $sql = "INSERT INTO `bills` 
        (`price`, `id_user`, `status`) 
        VALUES 
        ('".$row['price']."','".$row['id_user']."','".$row['status']."')";
//var_dump($sql);
//exit();        
        $result = $this->connection->query($sql);
        return $result;
    }

    public function getRecord($id_rec) {
    $sql = "SELECT 
                b.id_bill, b.id_user, b.date_bill, b.price, b.deleted, b.status,
                u.fio,
                g.name AS group_name
            FROM bills b
            JOIN users u ON b.id_user = u.id_user
            JOIN groups g ON u.id_group = g.id_group
            WHERE b.id_bill = ".$id_rec;
    $result = $this->connection->query($sql);
    $row = $result->fetch();
    return $row;       
}

    public function saveBill($row)
    {
        $sql = "UPDATE `bills` SET 
        `price`='".$row['price']."',
        `id_user`='".$row['id_user']."',
        `date_bill`='".$row['date_bill']."',
        `status`='".$row['status']."'
        WHERE `id_bill` = ".$row['id_bill'];

        $result = $this->connection->query($sql);
        return $result;
    }

    public function getClients() {
        $sql= "SELECT id_user, fio FROM users WHERE role='user'";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function deleteBill($id_rec)
    {
        $sql = "UPDATE `bills` SET `deleted`=1
        WHERE `id_bill` = ".$id_rec;
        $result = $this->connection->query($sql);
        return $result;
    }
}
