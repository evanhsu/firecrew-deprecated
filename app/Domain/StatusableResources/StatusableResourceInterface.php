<?php

namespace App\Domain\StatusableResources;


interface StatusableResourceInterface
{
    /**
     * @return string   A string describing the type of resource (i.e. 'rappel_helicopter', 'hotshot_crew')
     */
    public static function resourceType();
}