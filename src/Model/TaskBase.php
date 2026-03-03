<?php

namespace App\Model;

use App\Service\Notifiable;

abstract class TaskBase {
    protected string $title;
    protected string $description;

    public function __construct(string $title, string $description) {
        $this->title = $title;
        $this->description = $description;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    // Исправлено: добавлен интерфейс Notifiable для соблюдения SOLID
    abstract public function complete(Notifiable $notifier): void;
}