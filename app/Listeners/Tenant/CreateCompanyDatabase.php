<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Tenant\Database\DatabaseManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private DatabaseManager $database)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Tenant\CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $company = $event->company();

        if (! $this->database->createDatabase($company)) {
            throw new \Exception("Erro ao tentar criar o banco de dados");
        }

        event(new DatabaseCreated($company));
    }
}
