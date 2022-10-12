<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations tenants';

    public function __construct(private ManagerTenant $tenant)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $companies = Company::all();
        
        if ($id = $this->argument('id')) {
            if ($company = Company::find($id)) {
                $this->execCommand($company);
                return Command::SUCCESS;
            }
        }
        
        foreach($companies as $company) {
            $this->execCommand($company);
        }
        
        return Command::SUCCESS;
    }
    
    public function execCommand(Company $company): void
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $this->tenant->setConnection($company);
        
        $this->info("Connecting Company {$company->name}");
    
        Artisan::call($command, [
            '--force' => true,
            '--path'  => '/database/migrations/tenant',
        ]);
    
        $this->info("End Connection Company {$company->name}");
        $this->info("---------------------------------------------");
    }
}
