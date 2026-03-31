<?php
namespace App\Views;

class BaseTemplate
{
    public static function getTemplate(string $content): string
    {
        return '
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <title>ККТ</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="/">ККТ</a>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="/about">О нас</a></li>
                    </ul>
                </div>
            </nav>
            
            <main>' . $content . '</main>
            
            <footer class="bg-light text-center py-3 mt-5">
                <p>&copy; 2026 Кемеровский кооперативный техникум</p>
            </footer>
        </body>
        </html>
        ';
    }
}