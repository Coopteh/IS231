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
        // Проверка ФИО - должно быть заполнено
        if (empty(trim($data['fio'] ?? ''))) {
            return false;
        }

        // Проверка адреса - более 10 символов
        if (mb_strlen(trim($data['address'] ?? '')) <= 10) {
            return false;
        }

        // Проверка телефона - 11 цифр, начинается с 7 или 8
        $phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        if (!preg_match('/^[78]\d{10}$/', $phone)) {
            return false;
        }

        // Проверка email - валидный формат
        if (!filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}