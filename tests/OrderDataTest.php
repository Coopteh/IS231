
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

    public function testValidateOrderData(): void {
        $this->assertSame( true, 
                           $this->obj->validateFullName($this->data["fio"]) );
        $this->assertSame( true, 
                           $this->obj->validateAddress($this->data["address"]) );
        $this->assertSame( true, 
                           $this->obj->validatePhone($this->data["phone"]) );
        $this->assertSame( true, 
                           $this->obj->validateEmail($this->data["email"]) );

    }    
}