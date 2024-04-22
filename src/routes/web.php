<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])
->name('admin.')
->prefix('admin')
->namespace('App\Http\Controllers')
->group(function () {
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('suppliers', 'SupplierController');
    Route::get('suppliers/{supplier}/delete', 'SupplierController@delete')->name('suppliers.delete');
    Route::get('suppliers/json/datatable', 'SupplierController@jsonDatatable')->name('suppliers.json.datatable');
    Route::get('suppliers/json/cnpj', 'SupplierController@jsonCnpj')->name('suppliers.json.cnpj');
    Route::get('suppliers/json/zipcode', 'SupplierController@jsonZipCode')->name('suppliers.json.zipcode');

    Route::get('cities/json/list', 'CityController@jsonList')->name('cities.json.list');
});
