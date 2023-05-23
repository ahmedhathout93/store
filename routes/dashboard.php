<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;



Route::group([
    'middleware' => 'auth',
    'as' => 'dashboard.', // before name
    'prefix' => 'dashboard' // before path
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/categories', CategoriesController::class);
});
