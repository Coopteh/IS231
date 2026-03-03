<?php

namespace App\Model;

class User {
    private string $name;
    private array $tasks = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function assignTask(Task $task): void {
        $this->tasks[] = $task;
    }

    public function getTasks(): array {
        return $this->tasks;
    }
}