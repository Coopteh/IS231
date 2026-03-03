<?php

$jsonFile = 'customers.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

$dsn = 'mysql:host=localhost;dbname=db_customers;charset=utf8mb4';
$user = 'root';
$pass = '';

$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "INSERT INTO companies (id, name, inn, address, phone, is_salesman, is_buyer) VALUES (:id, :name, :inn, :address, :phone, :is_salesman, :is_buyer)";
$stmt = $pdo->prepare($sql);

foreach ($data as $item) {
    $stmt->execute([
        ':id' => $item['id'],
        ':name' => $item['name'],
        ':inn' => $item['inn'],
        ':address' => $item['addres'],
        ':phone' => $item['phone'],
        ':is_salesman' => $item['salesman'],
        ':is_buyer' => $item['buyer']
    ]);
}