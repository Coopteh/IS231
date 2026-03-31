<?php
// Автозагрузчик
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Класс не начинается с App\, игнорируем
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Router\Router;

$router = new Router();
$url = $_SERVER['REQUEST_URI'];
echo $router->route($url);