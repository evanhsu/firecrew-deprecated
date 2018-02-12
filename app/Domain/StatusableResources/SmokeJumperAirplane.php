<?php
namespace App\Domain\StatusableResources;

class SmokeJumperAirplane extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "SmokejumperAirplane";

    public static function resourceType()
    {
        return self::$resource_type;
    }
}