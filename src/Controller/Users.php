<?php
namespace App\Controllers;

use App\Models\UserDBStorage;
use App\Views\UserTemplate;

class Users {
    public function get(): string 
    {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getLoginTemplate();
        return $template;
    }

    public function auth($login,$password)
    {
        $storage = new UserDBStorage();
        $result = $storage->getUser($login,$password);
        if ($result !== false) {
            $_SESSION['user_id']= $result["id_user"];
            $_SESSION['user_name']= $result["fio"];
            $_SESSION['user_role']= $result["role"];
        }
        return $result;
    }

    public function getAll(): string 
    {
        $objTemplate = new UserTemplate();
        $storage = new UserDBStorage();
        $result = $storage->getAllUsers();
        $template = $objTemplate->getUsersTemplate($result);
        return $template;
    }    

    public function addUser($row)
    {
        $storage = new UserDBStorage();
        $result = $storage->addUser($row);
        return $result;
    }

    public function getForm() {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getFormTemplate();
        return $template;
    }
}