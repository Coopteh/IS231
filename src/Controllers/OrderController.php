<?php
namespace App\Controllers;
use App\Views\OrderTemplate;
use App\Models\Product;

class OrderController {
        public function get(): string {
        // MODEL CREATION
        $model = new Product();
        $data = $model->getBasketData();
        // var_dump($_SESSION);
        // exit();
        return OrderTemplate::getOrderTemplate($data);
    }
    public function create() {
        $model = new Product();
        $products  = $model -> getBasketData();
        $arr = $model -> prepareData($_POST, $products);
        $model ->saveData($arr);
        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";

	        header("Location: /");
	        return '';
    }
}  