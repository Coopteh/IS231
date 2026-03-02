<?php

namespace App\Services;

class ValidateOrderData
{
    /**
     * Валидация данных заказа
     * 
     * @param array $data Массив с полями: fio, address, phone, email
     * @return bool true если все данные валидны, false иначе
     */
    public function validate(array $data): bool
    {
        // 1. Проверка ФИО - не пустое, строка, после trim не пустое
        if (!$this->isValidFio($data['fio'] ?? null)) {
            return false;
        }

        // 2. Проверка адреса - более 10 символов
        if (!$this->isValidAddress($data['address'] ?? null)) {
            return false;
        }

        // 3. Проверка телефона - 11 цифр, начинается с 7 или 8
        if (!$this->isValidPhone($data['phone'] ?? null)) {
            return false;
        }

        // 4. Проверка email - валидный формат
        if (!$this->isValidEmail($data['email'] ?? null)) {
            return false;
        }

        return true;
    }

    /**
     * Валидация ФИО
     */
    private function isValidFio(mixed $fio): bool
    {
        return is_string($fio) && trim($fio) !== '';
    }

    /**
     * Валидация адреса - более 10 символов
     */
    private function isValidAddress(mixed $address): bool
    {
        return is_string($address) && strlen(trim($address)) > 10;
    }

    /**
     * Валидация телефона: 11 цифр, начинается с 7 или 8
     * Допускает формат: 89007009911, +7 (900) 700-99-11 и т.п.
     */
    private function isValidPhone(mixed $phone): bool
    {
        if (!is_string($phone)) {
            return false;
        }
        
        // Удаляем все нецифровые символы
        $cleanPhone = preg_replace('/\D/', '', $phone);
        
        // Проверяем: 11 цифр и начинается с 7 или 8
        return preg_match('/^[78]\d{10}$/', $cleanPhone) === 1;
    }

    /**
     * Валидация email через встроенный фильтр PHP
     */
    private function isValidEmail(mixed $email): bool
    {
        return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}