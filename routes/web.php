<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/load-more', [ProductController::class, 'loadMore'])->middleware('throttle:60,1')->name('products.load-more');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');

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
