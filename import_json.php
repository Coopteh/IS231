<?php
// Путь к файлу JSON
$jsonFile = 'customers.json';

// Считываем содержимое файла
$jsonData = file_get_contents($jsonFile);
if ($jsonData === false) {
    die('Не удалось прочитать файл: ' . $jsonFile);
}

// Декодируем JSON в ассоциативный массив
$customers = json_decode($jsonData, true);
if ($customers === null) {
    die('Ошибка декодирования JSON: ' . json_last_error_msg());
}

// Устанавливаем PDO-соединение
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_customers;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

// Перебираем клиентов и вставляем их в базу
foreach ($customers as $customer) {
    // Подготовка SQL-запроса
    $stmt = $pdo->prepare("
        INSERT INTO db_customers (id, name, inn, addres, phone, salesman, buyer) 
        VALUES (:id, :name, :inn, :addres, :phone, :salesman, :buyer)
    ");

    // Выполняем вставку с привязками
    $stmt->execute([
        ':id' => $customer['id'],
        ':name' => $customer['name'],
        ':inn' => $customer['inn'],
        ':addres' => $customer['addres'],
        ':phone' => $customer['phone'],
        ':salesman' => $customer['salesman'] ? 1 : 0, // логические значения в PHP
        ':buyer' => $customer['buyer'] ? 1 : 0
    ]);
}

echo "Импорт завершен.";
