<?php

namespace App\View;

use Src\Views\Navbar;

class FrontNavbar extends Navbar{

    public function __construct()
    {
        
    }

    public function getTemplateFile(): string
    {
        return "front-navbar.twig";
    }
}