<?php
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Models\Product;

class OrderController {
    public function get(): string 
    {
        $order = new Product();
        $data = $order->getBasketData();
        $orderTemplate = new OrderTemplate();
        return $orderTemplate->getOrderTemplate($data);
    }

}