<?php
namespace App\Service;

interface Notifiable {
    public function sendNotification(string $message): void;
}

