<?php

namespace App\Services;

class ValidateOrderData
{
    /**
 
     * @param array $data
     * @return bool true если все данные валидны, иначе false
     */
    public function validate(array $data): bool
    {
        if (empty(trim($data['fio'] ?? ''))) {
            return false;
        }

        if (strlen(trim($data['address'] ?? '')) < 10) {
            return false;
        }

        $phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        if (!preg_match('/^[78]\d{10}$/', $phone)) {
            return false;
        }

        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}