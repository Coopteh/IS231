<?php
namespace App\Controllers;

use App\Views\HomeTemplate;

class Home {
    public function get(): string 
    {
        $objTemplate = new HomeTemplate();
        $template = $objTemplate->getHomeTemplate();
        return $template;
    }
}