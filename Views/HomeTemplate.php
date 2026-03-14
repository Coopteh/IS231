<?php
namespace App\Views;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(string $content): string
    {
        $title = 'Кинотеатр KKT-Legion — Афиша';
        
        // Данные фильмов (имитация БД)
        $movies = [
            [
                "id" => 1,
                "title" => "Зеленый зомби",
                "genre" => "Фантастический отрыв тромба, Документалка, Политика",
                "time" => "3:22",
                "price" => "1488 ₽",
                "image" => "assets/images/movie4.jpg"
            ],
            [
                "id" => 2,
                "title" => "Во все тяжкие (Последствия Глэка)",
                "genre" => "Криминал, Драма, Романтика",
                "time" => "10:30",
                "price" => "500 ₽",
                "image" => "assets/images/movie5.jpg"
            ],
            [
                "id" => 3,
                "title" => "Мастер утупения",
                "genre" => "Комедия, Затуп, Дядя Богдан 14 ключ",
                "time" => "19:15",
                "price" => "400 ₽",
                "image" => "assets/images/movie6.jpg"
            ],
            [
                "id" => 4,
                "title" => "Кунг-фу Панда 4",
                "genre" => "Мультфильм, Комедия",
                "time" => "16:00",
                "price" => "350 ₽",
                "image" => "https://via.placeholder.com/300x450/333/fff?text=Kung+Fu+Panda"
            ]
        ];
        $currentDate = date("d.m.Y");

        // Карусель + контент главной страницы
        $content = '
        <!-- Секция карусели -->
        <section aria-label="Рекомендуемые фильмы">
            <div id="cinemaCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Слайд 1"></button>
                    <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="1" aria-label="Слайд 2"></button>
                    <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="2" aria-label="Слайд 3"></button>
                </div>
                
                <div class="carousel-inner rounded">
                    <div class="carousel-item active">
                        <img src="assets/images/movie1.jpg" class="d-block w-100" alt="Премьера недели" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>🎬 Премьера недели</h5>
                            <p>Новинки кинопроката уже в нашем кинотеатре!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/movie2.jpg" class="d-block w-100" alt="Скидки на билеты" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>🎟️ Скидки студентам</h5>
                            <p>Предъяви студенческий — получи скидку 20%</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/movie3.jpg" class="d-block w-100" alt="Комфортные залы" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>🍿 Комфорт и звук</h5>
                            <p>Залы с технологией Dolbyt Normalno и удобными креслами</p>
                        </div>
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#cinemaCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Предыдущий</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cinemaCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Следующий</span>
                </button>
            </div>
        </section>
        
        <!-- Основной контент: афиша -->
        <main>
            <h2 class="border-start border-4 border-danger ps-3 mb-4">
                Афиша на сегодня 
                <span class="badge bg-secondary ms-2">' . $currentDate . '</span>
            </h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                ';
                
                foreach ($movies as $movie) {
                    $content .= '
                    <div class="col">
                        <div class="card h-100 bg-dark text-white border-secondary movie-card">
                            <img src="' . $movie['image'] . '" class="card-img-top" alt="' . $movie['title'] . '" style="height: 375px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">' . $movie['title'] . '</h5>
                                <p class="card-text text-secondary small">' . $movie['genre'] . '</p>
                                <p class="card-text small">⏰ Начало: <strong>' . $movie['time'] . '</strong></p>
                                <div class="mt-auto">
                                    <span class="badge bg-danger mb-2">' . $movie['price'] . '</span>
                                    <button class="btn btn-outline-danger w-100 btn-sm" 
                                            onclick="alert(\'Вы выбрали билет на фильм: ' . $movie['title'] . '\')">
                                        Купить билет
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                
                $content .= '
            </div>
        </main>
        ';
        
        return parent::getTemplate($content);
    }

}