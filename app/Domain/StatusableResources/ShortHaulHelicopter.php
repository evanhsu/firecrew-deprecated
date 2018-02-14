<?php
namespace App\Domain\StatusableResources;

class ShortHaulHelicopter extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "ShortHaulHelicopter";
    protected static $staffing_category1 = "HAUL";
    protected static $staffing_category2 = "EMT";

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
