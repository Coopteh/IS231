<?php
// Автозагрузка классов Composer
require_once __DIR__ . '/vendor/autoload.php';

// Подключение пространств имён
use Controllers\HomeController;

// Создаём контроллер и выводим результат
$controller = new HomeController();
echo $controller->get();