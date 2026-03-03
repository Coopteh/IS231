<?php
namespace App\Model;

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

    // abstract public function complete(): void;
}