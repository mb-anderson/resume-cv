<?php

namespace App\Entity;

use CoreDB\Kernel\Model;
use CoreDB\Kernel\Database\DataType\TableReference;
use CoreDB\Kernel\Database\DataType\ShortText;

/**
 * Object relation with table project_advantages
 * @author makaron
 */

class ProjectAdvantage extends Model
{
    /**
    * @var TableReference $project
    *
    */
    public TableReference $project;
    /**
    * @var ShortText $advantage
    *
    */
    public ShortText $advantage;

    /**
     * @inheritdoc
     */
    public static function getTableName(): string
    {
        return "project_advantages";
    }
}
