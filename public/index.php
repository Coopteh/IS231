<?php

// Подключаем автозагрузчик Composer
require __DIR__ . '/../vendor/autoload.php';

use App\Model\Task;
use App\Model\User;
use App\Service\NotificationService;

// 1. Создаем сервис уведомлений
$notificationService = new NotificationService();

// 2. Создаем пользователя
$user = new User('John Doe');

// 3. Создаем задачи
$task1 = new Task('Изучить PHP', 'Прочитать документацию по ООП');
$task2 = new Task('Сделать проект', 'Реализовать систему задач');

// 4. Назначаем задачи пользователю
$user->assignTask($task1);
$user->assignTask($task2);

// 5. Выводим список задач и завершаем одну из них
echo "Список задач для пользователя {$user->getName()}:\n";
echo "------------------------------------------\n";

foreach ($user->getTasks() as $task) {
    echo "Задача: " . $task->getTitle() . "\n";
    echo "Описание: " . $task->getDescription() . "\n";
    
    // Демонстрация работы Trait (время создания)
    $timeInfo = $task->getTimestamps();
    echo "Создано: " . $timeInfo['createdAt'] . "\n";

    // Завершаем первую задачу и проверяем уведомление
    if ($task->getTitle() === 'Изучить PHP') {
        echo "Выполняем задачу...\n";
        $task->complete($notificationService); // Передаем сервис уведомлений
    }
    
    echo "Статус: " . ($task->isCompleted() ? 'Выполнено' : 'В процессе') . "\n";
    echo "------------------------------------------\n";
}