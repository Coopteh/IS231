<?php
namespace src\Views;

class BaseTemplate
{
    protected $title = 'Система учета счетов';
    
    protected function renderHeader()
    {
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $this->title; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="/css/style.css">
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <i class="fas fa-file-invoice"></i> Учет счетов
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <?php if (isset($_SESSION['user_type'])): ?>
                                <li class="nav-item">
                                    <span class="nav-link">
                                        <i class="fas fa-user"></i> 
                                        <?php echo $_SESSION['user_name']; ?>
                                        (<?php echo $_SESSION['user_type'] == 'accountant' ? 'Бухгалтер' : 'Поставщик'; ?>)
                                    </span>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">
                                        <i class="fas fa-sign-out-alt"></i> Выход
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">
                                        <i class="fas fa-sign-in-alt"></i> Вход
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="container mt-4">
        <?php
    }
    
    protected function renderFooter()
    {
        ?>
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="/js/script.js"></script>
        </body>
        </html>
        <?php
    }
    
    protected function showMessages()
    {
        if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif;
        
        if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif;
    }
}