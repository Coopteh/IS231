<?php
namespace Controllers;

use Views\HomeTemplate;

class HomeController
{
    /**
     * Обработка GET-запроса к главной странице
     * @return string HTML-код страницы
     */
    public function get(): string 
    {
        return HomeTemplate::getTemplate();
    }
}