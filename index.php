<?php
require_once 'config.php';
//require_once 'database.php';

// Read JSON file
$jsonContent = file_get_contents("customers.json");

if ($jsonContent === false) {
    die("Error: Could not read JSON file");
}

// Decode JSON
$data = json_decode($jsonContent, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error: Invalid JSON - " . json_last_error_msg());
}

// Handle both single object and array of objects
if (!isset($data[0])) {
    $data = [$data];
}

// Connect to database
$pdo = getDBConnection();

// Prepare SQL statement
$sql = "INSERT INTO customers (id, name, inn, address, phone, salesman, buyer) 
        VALUES (:id, :name, :inn, :address, :phone, :salesman, :buyer)";

$stmt = $pdo->prepare($sql);

// Insert each record
foreach ($data as $record) {
    try {
        $stmt->execute([
            ':id' => $record['id'],
            ':name' => $record['name'],
            ':inn' => $record['inn'] ?? '',
            ':address' => $record['addres'] ?? '',  // Note: JSON has typo "addres"
            ':phone' => $record['phone'] ?? '',
            ':salesman' => $record['salesman'] ? 1 : 0,
            ':buyer' => $record['buyer'] ? 1 : 0
        ]);
        echo "Record {$record['id']} inserted successfully\n";
    } catch (PDOException $e) {
        echo "Error inserting record {$record['id']}: " . $e->getMessage() . "\n";
    }
}

echo "Process completed!";
?>