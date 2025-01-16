<?php

namespace App\View;

use Src\Views\Navbar;

class FrontFooter extends Navbar
{
    public function __construct()
    {
    }

    public function getTemplateFile(): string
    {
        return "front-footer.twig";
    }
}
