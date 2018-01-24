<?php

namespace App\Domain\Crews;

use App\Domain\Aircrafts\Aircraft;
use App\Domain\Statuses\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\Item;
use App\Domain\People\Person;
use App\Domain\Users\User;

class Crew extends Model
{
	public static $types = [
		'handcrew'	=> 'Type 2 Handcrew',
		'hotshot'	=> 'Interagency Hotshot Crew',
		'engine'	=> 'Engine Crew',
		'helitack'	=> 'Helitack Crew (not Short Haul or Rappel)',
		'shorthaulhelicopter'	=> 'Short Haul',
		'rappelhelicopter'	=> 'Rappel Crew',
		'smokejumperairplane'=>'Smokejumper Base',
		'district'	=> 'A Ranger District or fire compound',
	];

    public function aircrafts() {
        // return $this->hasMany(Aircraft::class);
        if($this->is_an_aircraft_crew()) {
            $classname = $this->statusable_type;
            return $this->hasMany($classname);
        }
        else {
            return false;
        }
    }

	public function people() {
		return $this->belongsToMany(Person::class, 'crew_person');
	}

	public function roster($year) {
		return $this->people()->wherePivot('year',$year);
	}

	public function items() {
		return $this->hasMany(Item::class);
	}

	public function users() {
	    return $this->hasMany(User::class);
    }

    public function crew() {
	    return $this;
    }

    public function statuses() {
        // Create a relationship with the polymorphic Status model
        return $this->morphMany(Status::class, 'statusable');
    }
    public function status() {
        // Get the MOST RECENT status for this Crew
        $status = $this->statuses()->orderBy('created_at','desc')->first();
        if(is_null($status)) {
            return new Status;
        }
        else return $status;
    }

    public function statusable_type_plain() {
        if ($pos = strrpos($this->statusable_type, '\\')) {
            $chunks = explode('\\', $this->statusable_type);
            return strtolower($chunks[count($chunks)-1]);
        } else {
            return strtolower($this->statusable_type);
        }
    }

    public function is_an_aircraft_crew() {
        // Check to see if this Crew's 'statusable_type' is a class that inherits from the Aircraft class.
        // $classname = "App\\".ucfirst($this->statusable_type);
        $classname = $this->statusable_type;

        $instance = new $classname;
        if($instance instanceof Aircraft) {
            $result = true;
        }
        else {
            $result = false;
        }
        unset($instance);

        return $result;
    }
    public function is_not_an_aircraft_crew() {
        return !$this->is_an_aircraft_crew();
    }
    public function get_crew_id() {
        // This is simply an alias for crew->id to provide a consistent notation for querying the crew id for all resource types
        return $this->id;
    }
    public function resource_type()
    {
        // Returns a human-friendly text string that describes this crew's fire resource type (i.e. Short Haul Crew or Hotshot Crew)
        return self::$types[$this->statusable_type_plain()];
    }

    public function freshness() {
        // Check the timestamp of the most recent update for this Crew.
        // Return 'fresh', 'stale', 'expired', or 'missing' depending on age thresholds.
        //
        // NOTE: if this function is called on a Crew that has Helicopters, the freshness verb will
        //       refer to the length of time that has passed since ANY of this Crew's helicopters were updated.
        $max_fresh_age = config('app.hours_until_updates_go_stale');
        $expiration_age= config('app.days_until_updates_expire') * 24; // Converted to hours
        $now = Carbon::now();
        $last_status = $this->status();
        if(is_null($last_status->id)) $freshness = "missing"; // No Status has ever been created for this Crew
        else {
            $last_update = $last_status->created_at;
            $age_hours = $now->diffInHours($last_update);  // The number of hours between NOW and the last update

            if($age_hours <= $max_fresh_age) $freshness = "fresh";
            elseif(($age_hours > $max_fresh_age) && ($age_hours < $expiration_age)) $freshness = "stale";
            else $freshness = "expired";
        }
        return $freshness;
    }
    public function is_fresh() {
        if($this->freshness() == "fresh") return true;
        else return false;
    }
    public function is_stale() {
        if($this->freshness() == "stale") return true;
        else return false;
    }
    public function is_expired() {
        if($this->freshness() == "expired") return true;
        else return false;
    }
    public function has_no_updates() {
        if($this->freshness() == "missing") return true;
        else return false;
    }
}
