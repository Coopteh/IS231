<?php
namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController {
    public function get($id = null): string 
    {
        $model = new Product();
        $data = $model->loadData();
        if ($id) {
            $data = $data[$id-1];
            return ProductTemplate::getCardTemplate($data);
        } else {
            return ProductTemplate::getAllTemplate($data);            
        }
    }
}