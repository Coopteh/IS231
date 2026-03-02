## Модульное тестирование на PHPUnit

Работа с git
```
запустите Git Bash
перейдите в каталог c:/xampp/htdocs
> cd c:/xampp/htdocs

выполните в bash терминале
> git pull
переключитесь на ветку main
> git checkout main

Создайте новую ветку phpunit-01
> git checkout -b phpunit-01
```

Установите phpunit
```
composer require --dev phpunit/phpunit
```
Создайте папки ./tests и ./src
Создайте файл .gitignore
```
vendor
```
Создать в папке /tests новый файл OrderDataTest.php  
```
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
                           $this->obj->validate($this->data) );
    }
```
Создайте файл src\Services\ValidateOrderData.php, который проверяет правильной заполнения переданных данных validate($data)  
формат данных указан в тесте  

Запустите на выполнение тесты (они должны пройти успешно) командой:
```
./vendor/bin/phpunit ./tests --color
```
Создайте набор тестов для невалидных данных:
```
// ФИО - заполнено
// адрес > 10
// телефон - 11 цифр, 7 либо 8 в начале
// емайл - невалидные адреса проверить, типа "invalid", "@missing.username", ""
```
Добейтесь успешного выполнения тестов!

Закоммитьте и запуште изменения
```
> git status
> git add .
> git status
> git commit -m "Модульные тесты phpunit"
> git push --set-upstream origin phpunit-01
```
