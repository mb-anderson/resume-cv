<?php

namespace App\Entity;

use CoreDB\Kernel\Model;
use CoreDB\Kernel\Database\DataType\TableReference;
use CoreDB\Kernel\Database\DataType\File;
use CoreDB\Kernel\Database\DataType\EnumaratedList;

/**
 * Object relation with table project_images
 * @author anderson
 */

class ProjectImage extends Model
{
    /**
    * IMAGE_TYPE_DESKTOP description.
    */
    public const IMAGE_TYPE_DESKTOP = "DESKTOP";
    /**
    * IMAGE_TYPE_MOBILE description.
    */
    public const IMAGE_TYPE_MOBILE = "MOBILE";

    /**
    * @var TableReference $project
    * Project reference
    */
    public TableReference $project;
    /**
    * @var File $image
    * 
    */
    public File $image;
    /**
    * @var EnumaratedList $image_type
    * Image tpe is desktop or is mobile image?
    */
    public EnumaratedList $image_type;

    /**
     * @inheritdoc
     */
    public static function getTableName(): string
    {
        return "project_images";
    }
}
