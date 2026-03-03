<?php
// import_json.php

header('Content-Type: text/html; charset=utf-8');

$jsonFile = __DIR__ . '/customers.json';
$host = 'localhost';
$dbname = 'db_customers';
$username = 'root';
$password = '';

try {
    // Проверка наличия JSON-файла
    if (!file_exists($jsonFile)) {
        throw new Exception("Файл customers.json не найден!");
    }

    // Чтение и декодирование JSON
    $jsonContent = file_get_contents($jsonFile);
    $customers = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Ошибка JSON: " . json_last_error_msg());
    }

    // Подключение к базе данных через PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "<h2>Импорт данных из JSON в базу данных</h2>";
    echo "<p>Найдено записей: " . count($customers) . "</p>";

    // Подготовка SQL-запроса
    $stmt = $pdo->prepare("
        INSERT INTO customers (id, name, inn, addres, phone, salesman, buyer) 
        VALUES (:id, :name, :inn, :addres, :phone, :salesman, :buyer)
        ON DUPLICATE KEY UPDATE 
            name = VALUES(name),
            inn = VALUES(inn),
            addres = VALUES(addres),
            phone = VALUES(phone),
            salesman = VALUES(salesman),
            buyer = VALUES(buyer)
    ");

    $successCount = 0;
    $errorCount = 0;

    // Цикл по всем записям
    foreach ($customers as $customer) {
        try {
            $stmt->execute([
                ':id' => $customer['id'],
                ':name' => $customer['name'],
                ':inn' => $customer['inn'] ?? '',
                ':addres' => $customer['addres'],
                ':phone' => $customer['phone'],
                ':salesman' => $customer['salesman'] ? 1 : 0,
                ':buyer' => $customer['buyer'] ? 1 : 0
            ]);
            $successCount++;
            echo "<p style='color: green;'>✓ Добавлен: {$customer['name']}</p>";
        } catch (Exception $e) {
            $errorCount++;
            echo "<p style='color: red;'>✗ Ошибка для {$customer['name']}: {$e->getMessage()}</p>";
        }
    }

    echo "<hr>";
    echo "<h3>Результат импорта:</h3>";
    echo "<p>Успешно: <strong>$successCount</strong></p>";
    echo "<p>Ошибок: <strong>$errorCount</strong></p>";

} catch (Exception $e) {
    echo "<h2 style='color: red;'>Ошибка: " . $e->getMessage() . "</h2>";
}
?>