<?php

namespace App\Theme;

use App\View\FrontFooter;
use App\View\FrontNavbar;
use CoreDB\Kernel\ControllerInterface;
use Src\BaseTheme\BaseTheme;

class AppTheme extends BaseTheme
{
    public FrontFooter $footer;
    public static function getTemplateDirectories(): array
    {
        $directories = parent::getTemplateDirectories();
        array_unshift($directories, __DIR__ . "/templates");
        return $directories;
    }

    public function buildNavbar()
    {
        $this->navbar = FrontNavbar::create();
    }

    public function buildFooter()
    {
        $this->footer = FrontFooter::create();
    }

    public function setDefaults(ControllerInterface $controller)
    {
        parent::setDefaults($controller);
        $this->buildFooter();
    }
}
