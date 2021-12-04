<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/programs',[ProgramsController::class, 'getPrograms'])->name('programs');

Route::get('/program/{id}',[ProgramsController::class, 'getProgramView'])
        ->where(['id' => '[0-9]+'])
        ->name('programView');

Route::group(['middleware' => ['can:edit programs']], function () {
    
    Route::get('/edit/categories',[CategoryController::class, 'getCategories'])->name('categories');
    Route::get('/edit/types',[TypeController::class, 'getTypes'])->name('types');
    Route::get('/edit/links',[LinkController::class, 'getLinks'])->name('links');
    
    Route::get('/edit/program/{id}',[ProgramsController::class, 'getProgram'])
        ->where(['id' => '[0-9]+'])
        ->name('program');
    Route::post('/edit/program/{id}',[ProgramsController::class, 'updateProgram'])
        ->where(['id' => '[0-9]+'])
        ->name('updateProgram');
    
    Route::get('/edit/category/{id}',[CategoryController::class, 'getCategory'])
        ->where(['id' => '[0-9]+'])
        ->name('category');
    Route::post('edit//category/{id}',[CategoryController::class, 'updateCategory'])
        ->where(['id' => '[0-9]+'])
        ->name('updateCategory');
    
    Route::get('/edit/type/{id}',[TypeController::class, 'getType'])
        ->where(['id' => '[0-9]+'])
        ->name('type');
    Route::post('edit//type/{id}',[TypeController::class, 'updateType'])
        ->where(['id' => '[0-9]+'])
        ->name('updateType');
    
    Route::get('/edit/link/{id}',[LinkController::class, 'getLink'])
        ->where(['id' => '[0-9]+'])
        ->name('link');
    Route::post('/edit/link/{id}',[LinkController::class, 'updateLink'])
        ->where(['id' => '[0-9]+'])
        ->name('updateLink');
});

Route::group(['middleware' => ['can:edit programs']], function () {
    Route::get('/create/program',[ProgramsController::class, 'getCreateProgram'])
        ->name('createProgramView');
    Route::post('/create/program',[ProgramsController::class, 'createProgram'])
        ->name('createProgram');
});

require __DIR__.'/auth.php';
