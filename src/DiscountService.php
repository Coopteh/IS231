<?php
namespace App;

class DiscountService
{
    /**
     * Рассчитывает процент скидки.
     *
     * @param int $age Возраст клиента
     * @param bool $isVip Статус VIP клиента
     * @param float $amount Сумма заказа
     * @return float Процент скидки (0.0 - 0.5)
     * @throws \InvalidArgumentException Если сумма заказа некорректна
     */
    public function calculate(int $age, bool $isVip, float $amount): float
    {
        // Проверка на валидность суммы (Ветка 1)
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Сумма заказа должна быть больше нуля");
        }

        $discount = 0.0;

        // Сложное условие (Ветка 2)
        if ($amount > 1000 && $isVip) {
            $discount = 0.20; // 20%
        } 
        // Вложенное условие (Ветка 3)
        elseif ($amount > 500) {
            if ($age > 60 || $isVip) {
                $discount = 0.10; // 10%
            }
        }

        return $discount;
    }
}