<?php
// ИСПРАВЛЕНИЕ 1: Пространство имен контроллера должно быть App\Controllers
namespace App\Controllers;

// ИСПРАВЛЕНИЕ 2: Импортируем шаблон из правильного пространства App\Views
use App\Views\HomeTemplate;

class HomeController
{
    public function get(): string 
    {
        // Теперь класс HomeTemplate будет найден
        return HomeTemplate::getTemplate(''); 
    }
}