<?php

use PHPUnit\Framework\TestCase;
use App\Services\ValidateOrderData;

class OrderDataTest extends TestCase 
{
    private array $data;
    private ValidateOrderData $obj;

    public function setUp():void {
        // Массив валидных данных для передачи в метод
        $this->data = [];
        $this->data['fio'] = "Иванов";
        $this->data['address'] = "Кемерово, ул.Тухачевского 32";
        $this->data['phone'] = "89007009911";
        $this->data['email'] = "ivanov@example.com";
        // Объект класса ValidateOrderData
        $this->obj = new ValidateOrderData();
    }

    /**
     * Тестируем проверку правильных данных заказа
     */
    public function testValidateOrderDataWithValidData(): void {
        $this->assertTrue(
            $this->obj->validate($this->data)
        );
    }
    
    /**
     * Проверяем обработку некорректного ФИО (например, пустое значение)
     */
    public function testInvalidFIO(): void {
        $invalidData = $this->data;
        $invalidData['fio'] = ''; // Некорректное значение поля FIO
        
        $this->assertFalse(
            $this->obj->validate($invalidData),
            'Метод должен возвращать false при передаче неверного значения'
        );
    }
}
