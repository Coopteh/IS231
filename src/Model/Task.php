<?php

namespace App\Model;

use App\Service\Notifiable;

class Task extends TaskBase {
    use Timestampable;

    private bool $isCompleted = false;

    public function __construct(string $title, string $description) {
        parent::__construct($title, $description);
        $this->setTimestamps(); 
    }
    public function complete(Notifiable $notifier): void {
        $this->isCompleted = true;
        $this->updateTimestamp();
        $notifier->sendNotification("Task '{$this->title}' completed!");
    }
    public function isCompleted(): bool {
        return $this->isCompleted;
    }
}