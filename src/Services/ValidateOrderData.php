<?php

namespace App\Services;

class ValidateOrderData
{
    public function validate(array $data): bool
    {
        if (
            empty($data['fio']) || 
            strlen($data['address']) <= 10 ||
            !preg_match('/^(7|8)\d{10}$/', $data['phone']) ||
            filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false
        ) {
            return false;
        }
        return true;
    }
}