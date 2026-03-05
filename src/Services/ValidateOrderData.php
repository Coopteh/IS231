<?php

namespace App\Services;

class ValidateOrderData
{
    /**
     * Validate order data array
     * 
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        // Check all required fields exist and are not empty
        $requiredFields = ['fio', 'address', 'phone', 'email'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                return false;
            }
        }

        // Validate FIO (Cyrillic letters, spaces, hyphens allowed)
        if (!preg_match('/^[\p{Cyrillic}\s\-]+$/u', trim($data['fio']))) {
            return false;
        }

        // Validate address (basic non-empty check - customize as needed)
        if (mb_strlen(trim($data['address'])) < 10) {
            return false;
        }

        // Validate phone: Russian format (8 or +7 followed by 10 digits)
        $cleanPhone = preg_replace('/[^\d+]/', '', $data['phone']);
        if (!preg_match('/^(\+7|8)\d{10}$/', $cleanPhone)) {
            return false;
        }

        // Validate email format
        if (!filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}
