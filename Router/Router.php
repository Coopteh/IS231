<?php
namespace App\Router;

// ИСПРАВЛЕНИЕ: Импорт из App\Controllers
use App\Controllers\HomeController;
use App\Controllers\AboutController;
use Throwable;

class Router
{
    public function route(string $url): ?string 
    {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", $path);

        // ИСПРАВЛЕНИЕ: Берем индекс 1, так как индекс 0 - это пустота до первого слэша
        $resource = $pieces[1] ?? ''; 

        // Дополнительно: убираем возможные хвостовые слэши, если URL был /about/
        $resource = trim($resource, '/');

        error_log("Resource: '" . $resource . "'"); // Теперь тут будет 'about'

        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();

            case "home":
            case "": // Пустая строка теперь корректно ведет на Home (главная страница)
                $home = new HomeController();
                return $home->get();

            default:
                http_response_code(404);
                return "Страница не найдена";
        }
    }
}