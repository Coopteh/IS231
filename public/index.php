<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Task;
use App\Model\User;
use App\Service\NotificationService;

// 1. Создаем сервис (однократно)
$notificationService = new NotificationService();

$user = new User('John Doe');
echo "<h1>Задачи пользователя: " . $user->getName() . "</h1>";

// 2. Передаем сервис в конструктор задачи
$task1 = new Task('Купить молоко', 'Не забыть купить молоко в магазине', $notificationService);
$task2 = new Task('Сделать отчет', 'Подготовить квартальный отчет', $notificationService);

$user->assignTask($task1);
$user->assignTask($task2);

foreach ($user->getTasks() as $task) {
    echo "Task: <b>" . $task->getTitle() . "</b> - " . $task->getDescription();
    $timestamps = $task->getTimestamps();
    echo " <i>(Создано: " . $timestamps['createdAt'] . ")</i><br>";
}

echo "<hr><h3>Выполняем задачу 1...</h3>";

// 3. Вызываем метод без параметров
$task1->complete();

echo "<hr>Статус задачи 1: " . ($task1->isCompleted() ? 'Выполнена' : 'В процессе');