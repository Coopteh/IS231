<?php
use PHPUnit\Framework\TestCase;
use App\Services\ValidateOrderData;

class OrderDataTest extends TestCase 
{
    private array $data;
    private ValidateOrderData $obj;

    public function setUp(): void {
        $this->data = [
            'fio' => "Иванов Иван Иванович",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "89007009911",
            'email' => "ivanov@example.com",
        ];
        $this->obj = new ValidateOrderData();
    }

    public function testValidateOrderDataWithValidFio(): void {
        $this->assertTrue($this->obj->validate($this->data));
    }

    public function testValidFioFormats(string $fio): void {
        $this->data['fio'] = $fio;
        $this->assertTrue(
            $this->obj->validate($this->data),
            "ФИО '{$fio}' должно быть валидным"
        );
    }

    public static function validFioProvider(): array {
        return [
            ["Иванов"],                          // Только фамилия
            ["Иванов Иван"],                     // Фамилия + имя
            ["Иванов Иван Иванович"],            // Полное ФИО
            ["Анна-Мария"],                      // ФИО с дефисом
            ["де Сент-Экзюпери Антуан"],        // Сложные фамилии
            ["Иванов-Петров Иван Сергеевич"],   // Двойная фамилия
        ];
    }


    public function testInvalidFioFormats(string $fio): void {
        $this->data['fio'] = $fio;
        $this->assertFalse(
            $this->obj->validate($this->data),
            "ФИО '{$fio}' должно быть невалидным"
        );
    }

    public static function invalidFioProvider(): array {
        return [
            [""],                                // Пустая строка
            [" "],                               // Только пробелы
            ["Иванов123"],                       // С цифрами
            ["Ivanov"],                          // Латиница
            ["Иванов!"],                         // Спецсимволы
            ["Иванов Иван Ivan"],                // Смешанные алфавиты
            ["И"],                               // Слишком короткое
            ["   Иванов   "],                    // Лишние пробелы по краям (если не обрабатывается trim)
            ["Иванов  Иван"],                    // Двойной пробел внутри (опционально)
        ];
    }

    public function testFioMinLength(): void {
        $this->data['fio'] = "Ив";
        $this->assertTrue($this->obj->validate($this->data));
        
        $this->data['fio'] = "И";
        $this->assertFalse($this->obj->validate($this->data));
    }
}