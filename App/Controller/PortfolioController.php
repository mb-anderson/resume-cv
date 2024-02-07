<?php

namespace App\Controller;

use App\Entity\Project;
use App\Theme\AppController;
use CoreDB\Kernel\Router;
use PDO;
use Src\Controller\NotFoundController;
use Src\Entity\Translation;

class PortfolioController extends AppController
{
    public $content;
    public $project = [];
    public $projectAdvantages = [];

    public function checkAccess(): bool
    {
        return true;
    }

    public function getTemplateFile(): string
    {
        return "page-portfolio.twig";
    }
    
    public function preprocessPage()
    {
        if (isset($this->arguments[0])) {
                Router::getInstance()->route(NotFoundController::getUrl());
        } else {
            $this->setTitle(Translation::getTranslation("projects"));

            $projectIds = \CoreDB::database()->select(Project::getTableName())
                ->select(Project::getTableName(), ["ID"])
                ->execute()->fetchAll(PDO::FETCH_COLUMN);

            foreach ($projectIds as $projectId) {
                $this->project[] = Project::get($projectId);
            }
        }
    }
    
}
