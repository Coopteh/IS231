<?php
/**
 * @param string $email 
 * @return string 
 * @throws InvalidArgumentException 
 */
function validateEmail(string $email): string
{
    if (empty(trim($email))) {
        throw new InvalidArgumentException("Некорректный формат email: адрес не может быть пустым");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Некорректный формат email: '{$email}' не является валидным адресом");
    }
    
    return "Email корректен";
}


$testCases = [
    "example@example.com",      
    "not-an-email",             
    "",                         
    "user.name+tag@domain.co",  
    "@invalid.com",             
    "invalid@.com",             
];

echo "=== Тестирование функции validateEmail ===\n\n";

foreach ($testCases as $testEmail) {
    try {
        $result = validateEmail($testEmail);
        echo "✓ Вход: '{$testEmail}'\n";
        echo "  Результат: {$result}\n\n";
        
    } catch (InvalidArgumentException $e) {
        echo "✗ Вход: '{$testEmail}'\n";
        echo "  Ошибка: " . $e->getMessage() . "\n\n";
        
    } catch (Exception $e) {
        echo "✗ Вход: '{$testEmail}'\n";
        echo "  Неожиданная ошибка: " . $e->getMessage() . "\n\n";
    }
}

echo "=== Тестирование завершено ===\n";