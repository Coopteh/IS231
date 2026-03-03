<?php
namespace App\Model;

use App\Service\NotificationService;

class Task extends TaskBase {
	use Timestampable;

	private bool $isCompleted = false;

    // 	public function complete(): void {
    //     $this->isCompleted = true;
    // }

    	public function isCompleted(): bool {
        return $this->isCompleted;
    }
	public function complete(NotificationService $notificationService): void {
    $this->isCompleted = true;
    $this->updateTimestamp();
    $notificationService->sendNotification("Task '{$this->title}' completed!");
    }
}
