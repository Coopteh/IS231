<?php
namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public function getHomeTemplate(): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row mt-5">
            <p>
            АИС "Журнал услуг" предназначена для учета услуг станции технического осмотра.
            </p>        
            <p>
            Для работы с системой требуется авторизоваться через меню "Вход".
            </p>
        </div>   
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Главная страница', $str);
        return $resultTemplate;
    }
}