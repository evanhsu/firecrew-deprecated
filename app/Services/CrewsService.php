<?php
namespace App\Services;

use App\Domain\Crews\Crew;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CrewsService
{
    public function all()
    {
        return Crew::all();
    }

    public function findOrFail($crewId)
    {
        $crew = Crew::find($crewId);
        if(!$crew) {
            throw new ResourceNotFoundException("Crew $crewId doesn't exist.");
        }

        return $crew;
    }
}
