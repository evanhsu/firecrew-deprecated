<?php

namespace App\Domain\StatusableResources;

class RappelHelicopter extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "RappelHelicopter";
    protected static $staffing_category1 = "Rappellers";
    protected static $staffing_category2 = "HRAP Surplus";

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
