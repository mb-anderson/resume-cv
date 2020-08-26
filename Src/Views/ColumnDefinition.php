<?php

namespace Src\Views;

use CoreDB;
use CoreDB\Kernel\Database\DataType\DataTypeAbstract;
use Src\Entity\Translation;
use Src\Form\Widget\InputWidget;
use Src\Form\Widget\OptionWidget;
use Src\Form\Widget\SelectWidget;
use Src\Form\Widget\TextareaWidget;

class ColumnDefinition extends CollapsableCard
{
    private ?DataTypeAbstract $dataType;
    private string $name;

    public function __construct(string $name, DataTypeAbstract $dataType = null)
    {
        $this->name = $name;
        $this->dataType = $dataType;
        
        $this->setId($this->name);
        $this->addClass("column_definition");
        $this->opened = true;
    }

    public static function create($name, $dataType = null): ColumnDefinition
    {
        return new ColumnDefinition($name, $dataType);
    }

    public function render()
    {
        $field_name_input = InputWidget::create("{$this->name}[field_name]")
            ->addClass("lowercase_filter column_name")
            ->addAttribute("placeholder", Translation::getTranslation("column_name"))
            ->addAttribute("autocomplete", "off")
            ->addAttribute("required", "true")
            ->setLabel(Translation::getTranslation("column_name"))
            ->setDescription(Translation::getTranslation("available_characters", ["a-z, _, 1-9"]));

        $data_type_options = [];
        $dataTypes = \CoreDB::database()::dataTypes();
        foreach ($dataTypes as $key => $dataType) {
            /**
             * @var DataTypeAbstract $dataType
             */
            $data_type_options[$key] =  ($dataType)::getText();
        }

        $data_type_select = new SelectWidget("{$this->name}[field_type]");
        $data_type_select->setLabel(Translation::getTranslation("data_type"))
            ->setNullElement(null)
            ->addAttribute("required", "true")
            ->addClass("type-control")
            ->setOptions($data_type_options);

        $reference_table_select = SelectWidget::create("{$this->name}[reference_table]")
        ->addClass("reference_table")
        ->setLabel(Translation::getTranslation("reference_table"))
        ->setNullElement(Translation::getTranslation("reference_table"))
        ->setOptions(\CoreDB::database()::getTableList());

        $list_values_input = TextareaWidget::create("{$this->name}[list_values]")
        ->addClass("list_values")
        ->setLabel(Translation::getTranslation("list_values"))
        ->addAttribute("placeholder", Translation::getTranslation("list_values") )
        ->setDescription(Translation::getTranslation("list_values_description"));

        $field_length = InputWidget::create("{$this->name}[field_length]")
        ->addClass("field_length")
        ->setLabel(Translation::getTranslation("length_varchar"))
        ->addAttribute("placeholder", Translation::getTranslation("length_varchar"));
        
        $is_unique_checkbox = InputWidget::create("{$this->name}[is_unique]")
        ->setType("checkbox")
        ->setLabel(Translation::getTranslation("unique"))
        ->removeClass("form-control");

        $column_comment = TextareaWidget::create("{$this->name}[comment]")
        ->addAttribute("placeholder", Translation::getTranslation("column_comment"))
        ->addClass("my-2");

        $remove_button = ViewGroup::create("a", "btn btn-danger removefield")
        ->addAttribute("href", "#")
        ->addField(
            ViewGroup::create("i", "fa fa-trash")
        )
        ->addField(TextElement::create(Translation::getTranslation("drop_column")));

        if ($this->dataType) {
            $this->title = $this->dataType->column_name;
            $field_name_input->setValue($this->dataType->column_name);
                //->addAttribute("disabled", "true");
            $data_type_select//->addAttribute("disabled", "true")
                ->setValue( array_search( get_class($this->dataType), $dataTypes));
            /*$is_unique_checkbox->addAttribute("disabled", "true");
            $reference_table_select->addAttribute("disabled", "true");
            $list_values_input->addAttribute("disabled", "true");
            $field_length->addAttribute("disabled", "true");*/
            $column_comment//->addAttribute("disabled", "true")
                ->setValue($this->dataType->comment);
            $remove_button->removeClass("removefield")
                ->addClass("dropfield");

            if($this->dataType->isUnique){
                $is_unique_checkbox->addAttribute("checked", "true");
            }
            if($this->dataType instanceof \CoreDB\Kernel\Database\DataType\TableReference){
                $reference_table_select->setValue($this->dataType->reference_table);
            }
            if( $this->dataType instanceof \CoreDB\Kernel\Database\DataType\ShortText ){
                $field_length->setValue(strval($this->dataType->length));
            }

            if( $this->dataType instanceof \CoreDB\Kernel\Database\DataType\EnumaratedList ){
                $list_values_input->setValue( implode(",", array_keys($this->dataType->values) ) );
            }
            
        }else{
            $this->title = Translation::getTranslation("new_field");
        }

        $this->content = new ViewGroup("div", "row");
        $this->content->addField(
            ViewGroup::create("div", "col-sm-3")
                ->addField($field_name_input)
        )->addField(
            ViewGroup::create("div", "col-sm-3")
                ->addField($data_type_select)
        )->addField(
            ViewGroup::create("div", "col-sm-3 ".(!$reference_table_select->value ? "d-none" : ""))
                ->addField($reference_table_select)
        )->addField(
            ViewGroup::create("div", "col-sm-3 ".(!$field_length->value ? "d-none" : ""))
                ->addField($field_length)
        )->addField(
            ViewGroup::create("div", "col-sm-3")
                ->addField($is_unique_checkbox)
        )->addField(
            ViewGroup::create("div", "col-sm-12 ".(!$list_values_input->value ? "d-none" : ""))
                ->addField($list_values_input)
        )->addField(
            ViewGroup::create("div", "col-sm-12")
                ->addField($column_comment)
        )->addField(
            ViewGroup::create("div", "col-sm-3")
                ->addField($remove_button)
        );
        parent::render();
    }
}
