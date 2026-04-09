<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use App\Models\Product;


class ProductTest extends TestCase
{
    // private Product $product;

    protected function setUp(): void
    {
        // $this->product = new Product();
    }

    /**
     * Тест: правильная сумма для одного товара
     */
    public function testPrepareDataCalculatesTotalSumCorrectly(): void
    {

        $storage = new MockStorage();
        $model = new Product($storage, "", "");

        $formData = [
            'fio' => 'Иванов Иван',
            'address' => 'г. Москва, ул. Примерная, 1',
            'phone' => '+79991234567',
        ];

        $basketData = [
            [
                'id' => 1,
                'name' => 'Товар 1',
                'price' => 100,
                'quantity' => 2,
                'sum' => 200,
            ],
            [
                'id' => 2,
                'name' => 'Товар 2',
                'price' => 250.50,
                'quantity' => 3,
                'sum' => 751.50,
            ],
        ];

        $result = $model->prepareData($formData, $basketData);

        // Ожидаемая сумма: (100 * 2) + (250.50 * 3) = 200 + 751.50 = 951.50
        $expectedSum = 951.50;

        $this->assertEquals($expectedSum, $result['all_sum'], 'Общая сумма заказа рассчитана неверно');
    }
}