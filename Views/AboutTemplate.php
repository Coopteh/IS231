<?php
namespace App\Views;

use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate
{
    // ИСПРАВЛЕНИЕ: Добавлен аргумент string $content, чтобы соответствовать родителю
    public static function getTemplate(string $content): string
    {
        // Формируем уникальный контент для страницы "О нас"
        $aboutContent = '
        <div class="container py-5">
            <h1 class="text-center mb-4">О нашем техникуме</h1>
            
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h3>Кемеровский кооперативный техникум</h3>
                    <p class="lead">Частное образовательное учреждение профессионального образования</p>
                    <p>Кемеровский кооперативный техникум был основан в 1974 году.</p>
                    
                    <h5 class="mt-4">Наши преимущества:</h5>
                    <ul class="list-unstyled">
                        <li>✅ Востребованные специальности</li>
                        <li>✅ Современные технологии обучения</li>
                        <li>✅ Квалифицированные педагоги</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x300?text=ККТ" 
                         class="img-fluid rounded shadow" 
                         alt="Здание техникума">
                </div>
            </div>

            <!-- Карта -->
            <div class="map-container rounded overflow-hidden shadow mt-4">
                <iframe src="https://yandex.ru/map-widget/v1/?ll=86.080565%2C55.347745&z=16" 
                        width="100%" height="400" frameborder="0"></iframe>
            </div>
        </div>
        ';

        // Вызываем метод родителя, передавая туда НАШ контент
        // Аргумент $content, принятый в скобках метода, здесь не используется,
        // но его наличие обязательно для совместимости типов.
        return parent::getTemplate($aboutContent);
    }
}