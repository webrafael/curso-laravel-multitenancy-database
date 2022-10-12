<?php

use Illuminate\Support\Facades\Route;

Route::get('/tenant', function () {
    return "funcionou";
})->name('tenant');