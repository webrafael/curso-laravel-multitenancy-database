<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function __construct(private Company $company)
    {
        
    }

    public function store(Request $request)
    {
        $name = Str::random(5);
        $company = $this->company->create([
            'name' => 'Empresa XPTO' . $name,
            'domain' => $name . 'minhaempresa.net',
            'db_database' => $name . '_curso_laravel_multi_database_minhaempresa',
            'db_hostname' => '127.0.0.1',
            'db_username' => 'curso_laravel_multi_database',
            'db_password' => 'curso_laravel_multi_database',
        ]);

        if (true)
            event(new CompanyCreated($company));
        else
            event(new DatabaseCreated($company));

        dd($company);
    }
}
