<?php
namespace App\Controller;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController
{
    public function get($id): string 
{
    $model = new Product();
    $data = $model->loadData();
    if ($id)
        $data = $data[$id];
    return ProductTemplate::getCardTemplate($data);
}
    // public function get($id): string 
    // {
    //     $model = new Product();
    //     $data = $model->loadData();
        
    //     if ($data && isset($data[$id])) {
           
    //         $product = null;
    //         foreach ($data as $item) {
    //             if ($item['id'] == $id) {
    //                 $product = $item;
    //                 break;
    //             }
    //         }
    //         return ProductTemplate::getCardTemplate($product);
    //     }
        
    //     return ProductTemplate::getCardTemplate(null);
    // }
}