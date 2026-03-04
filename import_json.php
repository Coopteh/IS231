<?php

$host = 'localhost';
$db   = 'db_customers';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    $jsonFile = 'customers.json';
    if (!file_exists($jsonFile)) {
        throw new Exception("Файл $jsonFile не найден.");
    }
    
    $jsonString = file_get_contents($jsonFile);
    
    $customers = json_decode($jsonString, true); 
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Ошибка парсинга JSON: " . json_last_error_msg());
    }

    $sql = "INSERT INTO customers (id, name, inn, addres, phone, salesman, buyer) 
            VALUES (:id, :name, :inn, :addres, :phone, :salesman, :buyer)";
    
    $stmt = $pdo->prepare($sql);

    foreach ($customers as $customer) {
        $salesmanFlag = $customer['salesman'] ? 1 : 0;
        $buyerFlag = $customer['buyer'] ? 1 : 0;

        $stmt->execute([
            ':id'       => $customer['id'],
            ':name'     => $customer['name'],
            ':inn'      => $customer['inn'],
            ':addres'   => $customer['addres'],
            ':phone'    => $customer['phone'],
            ':salesman' => $salesmanFlag,
            ':buyer'    => $buyerFlag
        ]);
        
        echo "Успешно добавлен заказчик: " . $customer['name'] . "<br>";
    }

    echo "<hr>Импорт завершен успешно! Всего записей: " . count($customers);

} catch (\PDOException $e) {
    echo "Ошибка базы данных: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>