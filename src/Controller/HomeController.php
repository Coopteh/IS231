<?php
namespace App\Controller;

use App\Views\HomeTemplate;
class HomeController{
    public static function get(): string 
    {
        return HomeTemplate::getTemplate();
    }
}