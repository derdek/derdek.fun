<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/programs',[ProgramsController::class, 'getPrograms'])->name('programs');

Route::group(['middleware' => ['can:edit programs']], function () {
    
    Route::get('/categories',[CategoryController::class, 'getCategories'])->name('categories');
    Route::get('/types',[TypeController::class, 'getTypes'])->name('types');
    Route::get('/links',[LinkController::class, 'getLinks'])->name('links');
    
    Route::get('/program/{id}',[ProgramsController::class, 'getProgram'])
        ->where(['id' => '[0-9]+'])
        ->name('program');
    
    Route::get('/category/{id}',[CategoryController::class, 'getCategory'])
        ->where(['id' => '[0-9]+'])
        ->name('category');
    
    Route::get('/type/{id}',[TypeController::class, 'getType'])
        ->where(['id' => '[0-9]+'])
        ->name('type');
    
    Route::get('/link/{id}',[LinkController::class, 'getLink'])
        ->where(['id' => '[0-9]+'])
        ->name('link');
});

require __DIR__.'/auth.php';
