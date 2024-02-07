<?php

namespace App\Controller;

use App\Entity\Project;
use App\Theme\AppController;
use Src\Entity\Translation;

class MainpageController extends AppController
{
    public $projects;

    public function checkAccess(): bool
    {
        return true;
    }

    public function getTemplateFile(): string
    {
        return "page-mainpage.twig";
    }

    public function preprocessPage()
    {
        $this->projects = Project::getAll([]);
    }
    
}
