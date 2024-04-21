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
    Route::get('suppliers/json/datatable', 'SupplierController@json')->name('suppliers.json');
});
