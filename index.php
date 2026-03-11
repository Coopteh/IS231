<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Controller\HomeController;

$controller = new HomeController();
echo $controller->get();