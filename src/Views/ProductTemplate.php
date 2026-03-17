<?php
namespace App\Views;
class ProductTemplate extends BaseTemplate
{
    public static function getTemplate():string{
        $template = parent::getTemplate();
        $title= 'Главная страница';
        $content = <<<HTML

            <div class="h-50 w-50 mx-auto">        
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height:65vh;">
                        <div class="carousel-item active">
                        <img src="../../assets/img/pizza01.jpg" class="d-block w-100 h-100" alt="loading">
                        </div>
                        <div class="carousel-item">
                        <img src="../../assets/img/pizza02.jpg" class="d-block w-100 h-100 " alt="loading">
                        </div>
                        <div class="carousel-item">
                        <img src="../../assets/img/pizza03.jpg" class="d-block w-100 h-100" alt="loading">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
            </div>
        </section>
        <main class="row">
            <div class="p-5">
                <p>Здесь можно заказать пиццу с доставкой по городу Кемерово.</p>
                <p>Широкий ассортимент, низкие цены, быстрая доставка!</p>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </main>    

        HTML;
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
{
    public static function getCardTemplate():string{
        $template = parent::getTemplate();
        $title= 'Главная страница';
        $content = <<<HTML
    <div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="..." class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Заголовок карточки</h5>
        <p class="card-text">Это более широкая карточка с вспомогательным текстом ниже в качестве естественного перехода к дополнительному контенту. Этот контент немного длиннее.</p>
        <p class="card-text"><small class="text-body-secondary">Последнее обновление 3 мин. назад</small></p>
      </div>
    </div>
  </div>
</div>
$resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}