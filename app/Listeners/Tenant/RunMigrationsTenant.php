<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseCreated;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Tenant\DatabaseCreated  $event
     * @return void
     */
    public function handle(DatabaseCreated $event)
    {
        $company   = $event->company();
        $migration = Artisan::call('tenants:migrations', [
            'id' => $company->id,
        ]);

        return $migration === 0;
    }
}
