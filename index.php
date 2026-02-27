<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

// Создаем объект клиента
$client = new Client();

// Отправляем GET-запрос на указанный URL
try {
    $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts/1');

    // Получаем тело ответа
    $body = $response->getBody();

    // Декодируем JSON в массив
    $data = json_decode($body, true);

    // Выводим данные
    echo "Title: " . $data['title'] . "\n";
    echo "Body: " . $data['body'] . "\n";
} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo "Ошибка запроса: " . $e->getMessage();
}
