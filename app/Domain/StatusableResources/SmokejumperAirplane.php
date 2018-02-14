<?php
namespace App\Domain\StatusableResources;

class SmokejumperAirplane extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "SmokejumperAirplane";
    protected static $staffing_category1 = "SMKJ";
    protected static $staffing_category2 = "Load Size";

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