<?php

namespace App\Views;

class BaseTemplate
{
    public function getBaseTemplate()
    {
        global $user_id, $user_name, $user_role;

        $template = <<<END
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <link rel="stylesheet" href="https://localhost/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary mb-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">АИС "Учёт Счетов"</a>
                    <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" 
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/">Главная</a>
                    </div>
        END;
        if ($user_id > 0) {
            $template .= <<<SCORE
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/bill">Счета</a>
            </div>
            SCORE;
        }
        $template .= "</div></div>";

        if ($user_id > 0) {
            $template .= <<<LINE
                    <ul class="navbar-nav w-25">
                        <li class="nav-item">
                            {$user_name} ({$user_role}) |
                        </li>
                        <li class="nav-item">
                            &nbsp;
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="/logout">Выход</a>
                        </li>
                    </ul>
                LINE;
        } else {
            $template .= <<<LINE
                <a class="nav-link p-3" href="/login">
                Вход
                </a>
            LINE;
        }
        $template .= "</nav>";

        $template = self::getSimpleFlash($template);
        $template .= <<<END
            %s
        </div>
        </body>
        </html>
        END;
        return $template;
    }

    // Добавим flash сообщение
    public static function getSimpleFlash(string $str): string
    {
        if (isset($_SESSION['flash'])) {
            $class_alert = isset($_SESSION['flash_class']) ? $_SESSION['flash_class'] : 'alert-info';
            $str .= <<<END
                <div id="liveAlertBtn" class="alert {$class_alert} alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        onclick="this.parentNode.style.display='none';"></button>
                </div>
                END;
            unset($_SESSION['flash']);
            unset($_SESSION['flash_class']);
        }
        return $str;
    }
}
