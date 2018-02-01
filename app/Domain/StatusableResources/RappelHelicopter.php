<?php

namespace App\Domain\StatusableResources;

class RappelHelicopter extends AbstractStatusableResource implements StatusableResourceInterface
{
    protected static $resource_type = "rappel_helicopter";

    public static function resourceType()
    {
        return self::$resource_type;
    }
}
