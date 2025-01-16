<?php

namespace App\Entity;

use App\Controller\Admin\ProjectsController;
use CoreDB\Kernel\Database\DataType\LongText;
use CoreDB\Kernel\Model;
use CoreDB\Kernel\Database\DataType\ShortText;
use CoreDB\Kernel\EntityReference;
use Src\Entity\Translation;
use Src\Views\Link;
use Src\Views\TextElement;

/**
 * Object relation with table projects
 * @author makaron
 */

class Project extends Model
{
    /**
    * @var ShortText $title
    * Project title
    */
    public ShortText $title;

    /**
    * @var LongText $description
    *
    */
    public LongText $description;

    public EntityReference $project_advantages;

    public EntityReference $project_images;

    /**
     * @inheritdoc
     */
    public static function getTableName(): string
    {
        return "projects";
    }

    public function editUrl($value = null)
    {
        return ProjectsController::getUrl() . ($value ?: $this->ID);
    }

    public function actions(): array
    {
        return [
            Link::create(
                ProjectsController::getUrl() . "add",
                TextElement::create(
                    "<i class='fa fa-plus'></i> " . Translation::getTranslation("add")
                )->setIsRaw(true)
            )->addClass("d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-1 mb-1")
        ];
    }

    public function getProjectImages(): array
    {
        $desktopImages = ProjectImage::getAll([
            "project" => $this->ID,
            "image_type" => ProjectImage::IMAGE_TYPE_DESKTOP
        ]);
        $mobileImages = ProjectImage::getAll([
            "project" => $this->ID,
            "image_type" => ProjectImage::IMAGE_TYPE_MOBILE
        ]);
        $newArray = [];
        $maxCount = max(count($desktopImages), count($mobileImages));
        for ($i = 0; $i < $maxCount; $i++) {
            if (isset($desktopImages[$i])) {
                $newArray[] = $desktopImages[$i];
            }
            if (isset($mobileImages[$i])) {
                $newArray[] = $mobileImages[$i];
            }
        }
        return $newArray;
    }
}
