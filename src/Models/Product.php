<?php
namespace App\Models;

use App\Configs\Config;

class Product
{
    // Существующий метод для загрузки всех данных
    public function loadData(): ?array
    {
        $file = Config::FILE_PRODUCTS;
        if (!file_exists($file)) {
            return null;
        }
        $data = file_get_contents($file);
        return json_decode($data, true);
    }

    // НОВЫЙ МЕТОД: Получить все товары
    public function getAllProducts(): array
    {
        $data = $this->loadData();
        return $data ?? []; // Если данных нет, вернем пустой массив
    }

    // Метод для получения одного товара (уже был)
    public function getProductById(int $id): ?array
    {
        $all = $this->getAllProducts();
        foreach ($all as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }
    public function getBasketData(): array {
        session_start();
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
	$products = $this->loadData();
	$basketProducts= [];

        foreach ($products as $product) {
            $id = $product['id'];

            if (array_key_exists($id, $_SESSION['basket'])) {
		// количество товара берем то что указано в корзине
                $quantity = $_SESSION['basket'][$id]['quantity'];

		// остальные характеристики берем из массива всех товаров
                $name = $product['name'];
                $price= $product['price'];

		// сумму вычислим 
                $sum  = $price * $quantity;

		// добавим в новый массив
		$basketProducts[] = array( 
			'id' => $id, 
			'name' => $name, 
			'quantity' => $quantity,
			'price' => $price,
			'sum' => $sum,
		);
            }
        }
	return $basketProducts;
}
}