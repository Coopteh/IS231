<?php

namespace App\Services;

class ValidateOrderData
{
    /**
     * Валидация данных заказа
     * 
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        // Проверка ФИО - не пустое
        if (empty($data['fio']) || !is_string($data['fio']) || trim($data['fio']) === '') {
            return false;
        }

        // Проверка адреса - длина > 10 символов
        if (empty($data['address']) || strlen(trim($data['address'])) <= 10) {
            return false;
        }

        // Проверка телефона - 11 цифр, начинается с 7 или 8
        $phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        if (!preg_match('/^[78]\d{10}$/', $phone)) {
            return false;
        }

        // Проверка email - валидный формат
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}