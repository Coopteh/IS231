<?php

function validateEmail(string $email): string
{
    $email = trim($email);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Некорректный формат email");
    }

    return "Email корректен";
}

$tests = ["example@example.com", "not-an-email", ""];

foreach ($tests as $test) {
    try {
        echo validateEmail($test) . "\n";
    } catch (InvalidArgumentException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
}
