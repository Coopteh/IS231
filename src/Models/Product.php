<?php
namespace App\Models;
use App\Config\Config;

class Product {
    public function loadData(): ?array {
        
        $file = file_get_contents(Config::FILE_DATA);
        $data = json_decode($file, true);

        return $data;
    }
    public function getBasketData(): array {
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
        public function saveData($arr) {
        $nameFile= Config::FILE_ORDERS;

        $handle = fopen($nameFile, "r");
        if (filesize($nameFile) > 0){ 
            $data = fread($handle, filesize($nameFile)); 
            $allRecords = json_decode($data, true); 
        } else {
            $allRecords = [];
        }
        fclose($handle);
        
        $allRecords[]= $arr;
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $handle = fopen($nameFile, "w");
        fwrite($handle, $json);
        fclose($handle);

        // Тестовые данные
        $form_data = [
            'name' => 'Тест',
            'email' => 'test@example.com',
            'phone' => '+79990000000',
            'address' => 'ул. Тестовая, 1',
            'delivery_method' => 'pickup' // бесплатная доставка
        ];

        $basket_data = [
            ['id' => 1, 'name' => 'Товар 1', 'price' => 350, 'quantity' => 2], // 350 × 2 = 700
            ['id' => 2, 'name' => 'Товар 2', 'price' => 500, 'quantity' => 1]  // 500 × 1 = 500
        ];

        // Запуск теста
        $model = new Product();
        $arr = $model->prepareData($form_data, $basket_data);

        // Проверка суммы: 700 + 500 = 1200 (без доставки)
        // Если доставка = 100, то 1200 + 100 = 1300
        echo "Сумма товаров: " . $arr['total'] . "\n";        // 1200
        echo "Доставка: " . $arr['delivery_cost'] . "\n";     // 100 (если настроена)
        echo "Итого: " . $arr['all_sum'] . "\n";              // 1300 ✓

        // Assert
        assert($arr['all_sum'] === 1300, 'Ошибка расчёта суммы заказа');
        }
            

}