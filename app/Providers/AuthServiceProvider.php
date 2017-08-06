<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Domain\Items\Item' => 'App\Domain\Items\ItemPolicy',
//        'App\Domain\LogEntries\LogEntry' => 'App\Domain\LogEntries\LogEntryPolicy',
//        'App\Domain\People\Person' => 'App\Domain\People\PersonPolicy',
//        'App\Domain\Users\User' => 'App\Domain\Users\UserPolicy',
//        'App\Domain\Crews\Crew' => 'App\Domain\Crews\CrewPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // To use Gates in a controller:
        //   if(Gate::allows('access-crew', $crew_id)) {...}
        //   if(Gate::denies('access-crew', $crew_id)) {...}

        Gate::define('access-crew', function ($user, $crewId) {
            return ($user->isGlobalAdmin() || ($user->crew_id === $crewId));
        });

        Gate::define('act-as-admin-for-crew', function ($user, $crew) {
            // Allow $crew to be passed in as either a Crew object OR an Integer crew_id
            // If $crew is NULL, return FALSE.... UNLESS the $user is a Global Admin
            if (is_object($crew)) return $user->isAdminForCrew($crew->id);
            elseif (is_numeric($crew)) return $user->isAdminForCrew(intval($crew));
            else return false; // An invalid data type was passed in for $crew (only integer or Crew Object are allowed)
        });
    }
}
