## Событийно ориентированная модульная архитектура на микроядре, управляемая через настройки

Работа с git
```
запустите Git Bash
перейдите в каталог c:/xampp/htdocs
> cd c:/xampp/htdocs

Сделайте Sync fork в своем репозитории IS231 для форкнутой репы из Coopteh/IS231
получим обновления веток с оригинального репозитория (на coopteh)
> git fetch coopteh

выполните в bash терминале
> git pull
переключитесь на ветку main
> git checkout main
удалите все файлы, кроме readme.md

Создайте новую ветку SOA-project
> git checkout -b SOA-project
```

Создайте следующие файлы:
composer.json
```
{
    "name": "coopteh/soa-project",
    "description": "Это учебный проект группы ИС-231",
    "type": "project",
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```
.gitignore
```
vendor
```
src\Core\Event.php
```
<?php
namespace App\Core;

class Event
{
    private string $name;
    private mixed $data;

    public function __construct(string $name, mixed $data = null)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
```
src\Core\Dispatcher.php
```
<?php
namespace App\Core;

class Dispatcher
{
    // Хранилище подписчиков: [eventName => [callback1, callback2]]
    private array $listeners = [];

    /**
     * Подписка на событие
     */
    public function subscribe(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * Генерация (диспетчеризация) события
     */
    public function dispatch(Event $event): void
    {
        $eventName = $event->getName();

        if (!isset($this->listeners[$eventName])) {
            return; // Никто не слушает это событие
        }

        echo "\n[ЯДРО] Событие '{$eventName}' запущено. Обработчиков: " . count($this->listeners[$eventName]) . "\n";

        foreach ($this->listeners[$eventName] as $listener) {
            // Вызываем метод handle у модуля, передавая событие
            call_user_func($listener, $event);
        }
    }
}
```
src\Modules\LoggerModule.php
```
<?php
namespace App\Modules;

use App\Core\Event;

class LoggerModule
{
    public function handle(Event $event): void
    {
        $data = json_encode($event->getData());
        echo "[LOGGER] Запись в лог: Событие '{$event->getName()}' с данными: {$data}\n";
    }
}
```
src\Modules\EmailModule.php
```
<?php
namespace App\Modules;

use App\Core\Event;

class EmailModule
{
    public function handle(Event $event): void
    {
        $data = $event->getData();
        if (isset($data['email'])) {
            echo "[EMAIL] Отправка письма на {$data['email']} о событии '{$event->getName()}'\n";
        }
    }
}
```
src\Modules\AnalyticsModule.php
```
<?php
namespace App\Modules;

use App\Core\Event;

class AnalyticsModule
{
    public function handle(Event $event): void
    {
        echo "[ANALYTICS] Трекинг действия: {$event->getName()} (User ID: " . ($event->getData()['user_id'] ?? 'N/A') . ")\n";
    }
}
```
src\Config\config.php
```
<?php

// Возвращаем массив конфигурации
return [
    // Ключ массива - имя события
    'user.registered' => [
        \App\Modules\LoggerModule::class,      // Логгер слушает регистрацию
        \App\Modules\EmailModule::class,       // Email слушает регистрацию
        \App\Modules\AnalyticsModule::class,   // Аналитика слушает регистрацию
    ],
    'order.paid' => [
        \App\Modules\LoggerModule::class,      // Логгер слушает оплату
        \App\Modules\EmailModule::class,       // Email слушает оплату
        // Аналитика НЕ слушает оплату (пример гибкости)
    ],
    'system.error' => [
        \App\Modules\LoggerModule::class,      // Только логгер слушает ошибки
    ]
];
```
index.php
```
<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Event;
use App\Core\Dispatcher;

use App\Modules\LoggerModule;
use App\Modules\EmailModule;
use App\Modules\AnalyticsModule;

// 1. Инициализация ядра
$dispatcher = new Dispatcher();

// 2. Загрузка конфигурации
$config = require __DIR__ .'/Config/config.php';

// 3. Динамическая регистрация подписчиков на основе настроек
foreach ($config as $eventName => $subscriberClasses) {
    foreach ($subscriberClasses as $class) {
        // Создаем экземпляр модуля
        $subscriber = new $class();
        
        // Подписываем метод handle этого модуля на событие
        $dispatcher->subscribe($eventName, [$subscriber, 'handle']);
    }
}

// Тестовые сценарии исполнения
echo "=== СИСТЕМА ЗАПУЩЕНА ===\n";

// --- Сценарий 1: Регистрация пользователя ---
echo "\n--- Сценарий: Регистрация пользователя ---\n";
$registerEvent = new Event('user.registered', [
    'user_id' => 101,
    'email' => 'ivan@example.com',
    'name' => 'Ivan'
]);
$dispatcher->dispatch($registerEvent);

// --- Сценарий 2: Оплата заказа ---
echo "\n--- Сценарий: Оплата заказа ---\n";
$payEvent = new Event('order.paid', [
    'order_id' => 555,
    'email' => 'ivan@example.com',
    'amount' => 1500
]);
$dispatcher->dispatch($payEvent);

// --- Сценарий 3: Ошибка системы ---
echo "\n--- Сценарий: Ошибка системы ---\n";
$errorEvent = new Event('system.error', [
    'message' => 'Database connection failed',
    'code' => 500
]);
$dispatcher->dispatch($errorEvent);

echo "\n=== РАБОТА ЗАВЕРШЕНА ===\n";
```

Запустите менеджер зависимостей
> composer install

Запустите приложение через точку входа - index.php
> Run
или через браузер (XAMPP + Apache -> localhost)

Закоммитьте и запуште изменения
```
> git status
> git add .
> git status
> git commit -m "Проект SOA"
> git push --set-upstream origin SOA-project
```
Сдайте работу - создав запрос на изменения Pull Request
```
зайдите на github и создайте Pull Request в исходный репозиторий для аккаунта Coopteh
```

Как это работает и почему это круто:
```
Развязка (Decoupling): Ядро (Dispatcher) не знает о существовании EmailModule или LoggerModule. Оно просто вызывает функции из списка.

Гибкость через конфиг: Если вы захотите отключить отправку писем при регистрации, вам не нужно лезть в код контроллера или ядра. Вы просто убираете строку \App\Modules\EmailModule::class из файла config.php.

Масштабируемость: Чтобы добавить новый модуль (например, SmsModule), вы создаете новый класс и добавляете его в конфиг. Старый код не меняется (принцип Open/Closed).

Микроядро: Dispatcher выполняет роль шины данных, через которую проходят все важные действия системы.
```
