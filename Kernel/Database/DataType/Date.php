<?php

namespace CoreDB\Kernel\Database\DataType;

use Src\Entity\Translation;
use Src\Form\Widget\FormWidget;
use Src\Form\Widget\InputWidget;

class Date extends DataTypeAbstract
{
    /**
     * @inheritdoc
     */
    public static function getText(): string{
        return Translation::getTranslation("date");
    }

    /**
     * @inheritdoc
     */
    public function getWidget(): FormWidget{
        $rand_id = random_int(0, 100);
        return InputWidget::create("")
        ->addClass("dateinput datetimepicker-input")
        ->addAttribute("id", $rand_id)
        ->addAttribute("data-target", "#" . $rand_id)
        ->addAttribute("data-toggle", "datetimepicker")
        ->addAttribute("autocomplete", "off");
    }

    /**
     * @inheritdoc
     */
    public function getSearchWidget() : FormWidget{
        return InputWidget::create("")
        ->addClass("daterangeinput");
    }
}
