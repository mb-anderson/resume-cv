<?php

namespace App\AdminTheme;

use Src\BaseTheme\BaseTheme;
use Src\Theme\ThemeInteface;

class AdminTheme extends BaseTheme
{
    public static function getTemplateDirectories(): array
    {
        $directories = parent::getTemplateDirectories();
        array_unshift($directories, __DIR__ . "/templates");
        return $directories;
    }

    public function getTheme(): ThemeInteface
    {
        return new AdminTheme();
    }
}
