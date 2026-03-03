<?php

namespace App\Model;

use App\Service\NotificationService;

class Task extends TaskBase
{
    use Timestampable;

    private bool $isCompleted = false;
    // Храним сервис внутри класса
    private NotificationService $notificationService;

    public function __construct(string $title, string $description, NotificationService $notificationService)
    {
        parent::__construct($title, $description);
        $this->notificationService = $notificationService;
        $this->setTimestamps();
    }

    // Метод теперь соответствует подписи родителя (без параметров)
    public function complete(): void
    {
        $this->isCompleted = true;
        $this->updateTimestamp();
        
        // Используем сервис, который уже есть внутри объекта
        $this->notificationService->sendNotification("Task '{$this->title}' completed!");
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }
}