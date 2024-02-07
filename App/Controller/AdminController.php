<?php

namespace App\Controller;

use App\AdminTheme\AdminTheme;
use Src\Controller\AdminController as ControllerAdminController;
use Src\Theme\ThemeInteface;

class AdminController extends ControllerAdminController
{
    public function getTheme(): ThemeInteface
    {
        return new AdminTheme();
    }

}
