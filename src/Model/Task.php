<?php

namespace App\Model;

class Task extends TaskBase {
    use Timestampable;

    private bool $isCompleted = false;

    public function complete(): void {
        $this->isCompleted = true;
        $this->updateTimestamp();
    }
}