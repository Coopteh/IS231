<?php

namespace App\Service;

class NotificationService implements Notifiable
{
    public function sendNotification(string $message): void
    {
        // В реальном проекте здесь была бы отправка email или push-уведомления
        echo "<br><strong>[SYSTEM NOTIFICATION]:</strong> $message<br>";
    }
}