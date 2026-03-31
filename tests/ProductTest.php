<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    /**
     * Тест: правильная сумма для одного товара
     */
    public function testPrepareDataCalculatesTotalSumCorrectly(): void
    {
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

        $result = $this->product->prepareData($formData, $basketData);

        // Ожидаемая сумма: (100 * 2) + (250.50 * 3) = 200 + 751.50 = 951.50
        $expectedSum = 951.50;

        $this->assertEquals($expectedSum, $result['all_sum'], 'Общая сумма заказа рассчитана неверно');
    }

    /**
     * Тест: сумма для пустой корзины
     */
    public function testPrepareDataWithEmptyBasket(): void
    {
        $formData = [
            'fio' => 'Петров Петр',
            'address' => 'г. СПб',
            'phone' => '+79000000000',
        ];

        $result = $this->product->prepareData($formData, []);

        $this->assertEquals(0, $result['all_sum']);
        $this->assertIsArray($result['products']);
        $this->assertEmpty($result['products']);
    }



    /**
     * Тест: проверяем, что метод возвращает все ожидаемые поля
     */
    public function testPrepareDataReturnsAllRequiredFields(): void
    {
        $formData = [
            'fio' => 'Тестов Тест',
            'address' => 'Тестовая улица',
            'phone' => '123456',
        ];

        $basketData = [
            ['id' => 1, 'name' => 'Тест', 'price' => 50, 'quantity' => 2, 'sum' => 100],
        ];

        $result = $this->product->prepareData($formData, $basketData);

        $this->assertArrayHasKey('fio', $result);
        $this->assertArrayHasKey('address', $result);
        $this->assertArrayHasKey('phone', $result);
        $this->assertArrayHasKey('created_at', $result);
        $this->assertArrayHasKey('products', $result);
        $this->assertArrayHasKey('all_sum', $result);

        $this->assertEquals($formData['fio'], $result['fio']);
        $this->assertMatchesRegularExpression('/\d{2}-\d{2}-\d{4} \d{2}:\d{2}:\d{2}/', $result['created_at']);
    }
}