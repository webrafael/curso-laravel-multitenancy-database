<?php

use Illuminate\Support\Facades\Route;

Route::get('company/store', [\App\Http\Controllers\Tenant\CompanyController::class, 'store'])->name('company.store');

Route::get('/tenant', function () {
    return "funcionou";
})->name('tenant');