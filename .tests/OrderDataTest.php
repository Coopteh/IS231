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
    public function testInvalidFIO(): void {
    // Изменяем поле 'fio' на некорректное значение
    $invalidData = $this->data;
    $invalidData['fio'] = ""; // пустое ФИО

    // Проверяем, что метод validate вернет false
    $this->assertFalse(
        $this->obj->validate($invalidData),
        "Метод должен возвращать false при передаче неверного ФИО"
    );
}
    public function testValidateOrderData(): void {
        $this->assertSame( true, 
                           $this->obj->validate($this->data) );
    }
}
