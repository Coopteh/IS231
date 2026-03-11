<?php
namespace Views;

class BaseTemplate
{
    public static function getTemplate(): string
    {
        return '
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="/assets/css/style.css" rel="stylesheet">
        </head>
        <body>
            <!-- Header -->
            <header class="bg-dark text-white py-3 border-bottom border-danger">
                <div class="container d-flex justify-content-between align-items-center">
                    <a href="/" class="logo text-decoration-none text-white fs-3 fw-bold">
                        KKT-<span class="text-danger">Legion</span>
                    </a>
                    <nav>
                        <a href="#" class="text-secondary text-decoration-none mx-2 fw-bold hover-danger">Афиша</a>
                        <a href="#" class="text-secondary text-decoration-none mx-2 fw-bold hover-danger">Скоро</a>
                        <a href="#" class="text-secondary text-decoration-none mx-2 fw-bold hover-danger">Контакты</a>
                    </nav>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="container my-4">
                %s
            </main>

            <!-- Footer -->
            <footer class="bg-dark text-center text-secondary py-4 mt-5">
                <p class="mb-1">&copy; ' . date("Y") . ' Кинотеатр KKT-Legion. Все права защищены.</p>
                <small>Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме"<br>
                по специальности "Специалист по информационным технологиям"</small>
            </footer>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        ';
    }
}