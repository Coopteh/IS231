<?php
namespace App\Controller;

use App\Views\AboutTemplate;
class AboutController {
    public function get(): string 
    {
        return AboutTemplate::getTemplate();
    }
}