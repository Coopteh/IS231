<?php
// config.php - Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_customers');
define('DB_USER', 'root');
define('DB_PASS', '');
define('JSON_FILE', 'customers.json');

// database.php - Database connection
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
