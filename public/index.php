<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Model\Task;
use App\Model\User;
use App\Service\NotificationService;


$notificationService = new NotificationService();

$user = new User('John Doe');

$task1 = new Task('Изучить PHP', 'Прочитать документацию по ООП');
$task2 = new Task('Сделать проект', 'Реализовать систему задач');

$user->assignTask($task1);
$user->assignTask($task2);

echo "Список задач для пользователя {$user->getName()}:<br>";
echo "<hr>";

foreach ($user->getTasks() as $task) {
    echo "Задача: " . $task->getTitle() . "<br>";
    echo "Описание: " . $task->getDescription() . "<br>";
    

    $timeInfo = $task->getTimestamps();
    echo "Создано: " . $timeInfo['createdAt'] . "<br>";


    if ($task->getTitle() === 'Изучить PHP') {
        echo "Выполняем задачу...<br>";
        $task->complete($notificationService);
    }
    
    echo "Статус: " . ($task->isCompleted() ? 'Выполнено' : 'В процессе') . "<br>";
    echo "<hr>";
}