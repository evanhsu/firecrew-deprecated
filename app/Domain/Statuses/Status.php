<?php

namespace App\Domain\Statuses;

use App\Domain\Aircrafts\Aircraft;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // This is a polymorphic model that is used to track the movements of different types of firefighting resources.
    // A Status can belong to either a Crew or a Helicopter, as defined by Status->

    // Explicitly define the database table, since 'status' has an awkward plural form
    protected $table = 'statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude',
        'longitude',
        'staffing_category1',
        'staffing_value1',
        'staffing_category2',
        'staffing_value2',
        'manager_name',
        'manager_phone',
        'comments1',
        'comments2',
        'assigned_fire_name',
        'assigned_fire_number',
        'assigned_supervisor',
        'assigned_supervisor_phone',
        'distance',
        'label_text',
        'popup_content',
        'crew_name',
        'statusable_name',
        'statusable_type',
        'statusable_id',
        'created_by'];

    /**
     * The attributes excluded from the models JSON form.
     *
     * @var array
     */
    // Consider hiding 'created_by'...
    protected $hidden = [];

    public function statusable()
    {
        return $this->morphTo();    // Allow multiple other Models to claim a relationship to this model
    }

    public function statusable_type_plain()
    {
        // Returns the name of the Class that this Status belongs to, without any namespacing.
        //   i.e. If this Status belongs to a Aircraft, then:
        //           $this->statusable_type == "App\Aircraft"
        //        and
        //           $this->statusable_type_plain() == "aircraft"

        if ($pos = strrpos($this->statusable_type, '\\')) {
            return strtolower(substr($this->statusable_type, $pos + 1));
        } else {
            return strtolower($this->statusable_type);
        }
    }

    public function redirectToNewStatus()
    {
        // Returns the RedirectResponse that should be used to submit a new Status for the same resource.
        // For example, if $this is a Status for Aircraft 'N2345', then redirect to "route(new_status_for_aircraft,'N2345')"

        // Returns an array that can be used to build a redirect
        // ['class' => 'aircraft',
        //  'id'    => 'N2345' ]
        //
        // The calling function could do something like this:
        //   routeParams = myStatus->redirectToNewStatus();
        //   return redirect()->route(routePrams['route_name'], routePrams['id']);

        $parent = $this->statusable;  // The instance of the parent class that owns this Status (ShortHaulHelicopter, Crew, etc)
        $is_an_aircraft_crew = ($parent instanceof Aircraft);

        if ($is_an_aircraft_crew) {
            $route_id = $parent->tailnumber; // Aircrafts routes use the tailnumber rather than the ID
            $route_name = "new_status_for_aircraft";
        } else {
            $route_id = $parent->id;
            $route_name = "new_status_for_crew";
        }

        // return redirect()->route($route_name,$route_id);
        return array('route_name' => $route_name,
            'id' => $route_id);
    }

    public function crewToUpdate()
    {
        // Returns the ID of the Crew that CURRENTLY owns the Aircraft/Crew from $this Status.

        $parent = $this->statusable;
        return $parent->get_crew_id();
    }
}
