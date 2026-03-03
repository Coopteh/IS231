<?php
namespace App\Service;

class NotificationService implements Notifiable {
    public function sendNotification(string $message): void {
        echo "Notification sent: $message";
    }
}
