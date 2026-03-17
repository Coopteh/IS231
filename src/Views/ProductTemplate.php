<?php
namespace App\Views;

class ProductTemplate extends BaseTemplate {
    public static function getAllTemplate(array $arr): string {
        $template = parent::getTemplate();
        $str= '<div class="container">';

        // для каждого товара
        foreach( $arr as $key => $item ) {

            $element_template= <<<END
            <div class="row mb-5">
                <div class="col-6">
                    <img src="{$item['image']}" class="w-100">
                </div>
                <div class="col-6">
                    <div class="block mt-3">
                        <a href="/products/{$item['id']}"><h2>{$item['name']}</h2></a>
                        <p>{$item['description']}</p>
                        <h3>{$item['price']} ₽</h3>
                    </div>
                </div>
                <hr>
            </div>
            END;

            $str.= $element_template;
        }
        $str.= "</div>";
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }
    public static function getCardTemplate($data):string {
        $card= <<<CARD
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{$data['image']}" class="img-fluid rounded-start" alt="{$data['name']}">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{$data['name']}</h5>
                        <p class="card-text">{$data['price']} рублей</p>
                        <p class="card-text"><small class="text-body-secondary">{$data['description']}</small></p>
                    </div>
                    </div>
                </div>
            </div>
        CARD;
        $template = parent::getTemplate();
        $title= 'Карточка товара: ' . $data['name'];
        $resultTemplate = sprintf($template, $title, $card);
        return $resultTemplate;
    }
}