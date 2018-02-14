<?php

namespace App\Domain\StatusableResources;

class Type1Helicopter extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "Type1Helicopter";
    protected static $staffing_category1 = null;
    protected static $staffing_category2 = null;

    public static function resourceType()
    {
        return self::$resource_type;
    }

    public static function staffingCategory1()
    {
        return self::$staffing_category1;
    }

    public static function staffingCategory2()
    {
        return self::$staffing_category2;
    }
}
