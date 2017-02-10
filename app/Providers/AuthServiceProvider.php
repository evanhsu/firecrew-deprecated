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
        'App\Domain\Crews\Crew' => 'App\Domain\Crews\Policies\CrewPolicy',
        'App\Domain\Items\Item' => 'App\Domain\Items\Policies\ItemPolicy',
        'App\Domain\LogEntries\LogEntry' => 'App\Domain\LogEntries\Policies\LogEntryPolicy',
        'App\Domain\People\Person' => 'App\Domain\People\Policies\PersonPolicy',
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
    }
}
