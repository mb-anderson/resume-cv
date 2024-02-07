<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use App\Entity\Project;
use CoreDB\Kernel\Model;
use CoreDB\Kernel\Router;
use Src\Controller\NotFoundController;
use Src\Entity\Translation;
use Src\Form\SearchForm;
use Src\Traits\Controller\ListFormControllerTrait;

class ProjectsController extends AdminController
{
    use ListFormControllerTrait;

    public function getModelClass(): string
    {
        return Project::class;
    }

    public function getUpdateTitle(Model $model): string
    {
        return Translation::getTranslation("update");
    }

    public function getAddTitle(): string
    {
        return Translation::getTranslation("add");
    }
}
