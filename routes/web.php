<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('lte_context:admin')
    ->group(function () {
        Auth::routes([
            'register' => false,
        ]);

        require __DIR__.'/command.php';

        Route::name('admin.')->group(function () {
            require __DIR__.'/admin.php';
        });
    });
