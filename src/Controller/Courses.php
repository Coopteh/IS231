<?php
namespace App\Controllers;

use App\Models\CourseDBStorage;
use App\Views\CourseTemplate;

class Courses {
    public function getAll(): string 
    {
        $objTemplate = new SubjectsTemplate();
        $storage = new SubjectsDBStorage();

        $result = $storage->getAllSubjects();

        $template = $objTemplate->getSubjectsTemplate($result);
        return $template;
    }    
}