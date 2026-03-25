<?php

namespace App\Views;

class OrderTemplate 
{
    public function getOrderTemplate(array $data): string
    {
        // Начинаем формирование HTML
        $html = '<h1>Создание заказа</h1>';
        $all_sum = 0;
        
        // Исправлено: $data вместо $products
        foreach ($data as $product) {
            $name = $product['name'];
            $price = $product['price'];
            // Исправлено: .. на корректное обращение к массиву
            $quantity = $product['quantity'];
            $sum = $price * $quantity;
            $all_sum += $sum;
            // Исправлено: используем $html и корректный хередок
            $html .= <<<LINE
                <div class="row">
                    <div class="col-6">
                        {$name}
                    </div>
                    <div class="col-2">
                        {$quantity} ед. x {$price} руб.
                    </div>
                    <div class="col-2">
                        {$sum} ₽
                    </div>
                </div>
LINE; 
                    if ($all_sum > 0) {
            $html .= <<<LINE
                <div class="row total">
                    <div class="col-12">
                        <strong>Итого к оплате: {$all_sum} ₽</strong>
                    </div>
                </div>
LINE;
                    } else {
            $html .= <<<LINE
                <div class="row">
                    <div class="col-12">
                        - нет добавленных товаров -
                    </div>
                </div>
LINE;                 
                $html .= <<<LINE
                    <div class="row">
                    <div class="col-6">
                         
                    </div>
                    <div class="col-6 float-end">
                        <form action="/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину
                        </form>
                    </div>
                </div>    
LINE;    
        } //Закрываем foreach

                
        $html .= "<div class='total'><strong>Итого: {$all_sum} ₽</strong></div>";
        
        return $html;
            }
}       
}