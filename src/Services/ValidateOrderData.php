<?php

namespace App\Services;

class ValidateOrderData
{
    /**
     * Проверка ФИО - не пустое
     */
    public static function validateFullName(string $value): bool
    {
        return !empty(trim($value));
    }

    /**
     * Проверка адреса - длина > 10 символов
     */
    public static function validateAddress(string $value): bool
    {
        return mb_strlen(trim($value)) > 10;
    }

    /**
     * Проверка телефона - 11 цифр, начинается с 7 или 8
     */
    public static function validatePhone(string $value): bool
    {
        $clean = preg_replace('/[^\d]/', '', $value);
        return preg_match('/^[78]\d{10}$/', $clean) === 1;
    }

    /**
     * Проверка email - базовая валидация
     */
    public static function validateEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}