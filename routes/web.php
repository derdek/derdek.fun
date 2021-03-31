<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Localizate;
use App\Http\Controllers\LocalizationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware([Localizate::class])->group(function () {
    
    Route::view('/', 'main')
        ->name('main');;

    Route::get('/set-locale/{locale}', [LocalizationController::class, 'setLocale'])
        ->name('locale');
});
