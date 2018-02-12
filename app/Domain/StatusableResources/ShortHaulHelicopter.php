<?php
namespace App\Domain\StatusableResources;

class ShortHaulHelicopter extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "ShortHaulHelicopter";

    public static function resourceType()
    {
        return self::$resource_type;
    }
}
