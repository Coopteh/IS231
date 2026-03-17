<?php
namespace App\Models;

use App\Configs\Config;

class Product
{
    public function loadData(): ?array
    {
        $filePath = Config::FILE_PRODUCTS;
        
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return null;
        }
        
        $data = fread($handle, filesize($filePath));
        fclose($handle);
        
        $arr = json_decode($data, true);
        
        return $arr;
    }
}