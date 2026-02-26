<?php
namespace App\Controller;

use App\Model\Post;

class BlogController
{
    public function index(): void
    {
        $rec = new Post("Заголовок публикации", "Это текст публикации.");
        echo "<h1>" . $rec->getTitle() . "</h1>";
        echo "<p>" . $rec->getContent() . "</p>";
    }
}
