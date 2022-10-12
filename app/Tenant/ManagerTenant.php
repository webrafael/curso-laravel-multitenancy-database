<?php namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    public function setConnection(Company $company)
    {
        DB::purge('tenant');
        
        config()->set('database.connections.tenant.host', $company->db_hostname);
        config()->set('database.connections.tenant.database', $company->db_database);
        config()->set('database.connections.tenant.username', $company->db_username);
        config()->set('database.connections.tenant.password', $company->db_password);

        DB::reconnect('tenant');

        try
        {
            $reconnect = Schema::connection('tenant')->getConnection()->reconnect();
        } catch(\Exception $error) {
            dd($error);
        }

    }

    public function domainIsMain(): bool
    {
        return request()->getHost() == config('tenant.domain_main');
    }
}